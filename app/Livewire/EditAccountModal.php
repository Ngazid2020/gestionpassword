<?php

namespace App\Livewire;

use App\Models\Account;
use Filament\Livewire\Notifications;
use Filament\Notifications\Notification;
use Livewire\Component;

class EditAccountModal extends Component
{
    public $isOpen = false;
    public Account $account;

    // Champs du formulaire
    public $name, $identifiant, $password, $url, $notes, $category_id;

    protected $rules = [
        'name' => 'required|string|max:255',
        'identifiant' => 'required|string',
        'password' => 'nullable|string',
        'url' => 'nullable|string',
        'notes'=>'nullable|string|max:1000',
        'category_id' => 'nullable|exists:categories,id',
    ];

    // On écoute l'événement pour ouvrir le modal
    protected $listeners = ['openEditModal' => 'loadAccount'];

    public function loadAccount(Account $account)
    {
        $this->account = $account;
        $this->name = $account->name;
        $this->identifiant = $account->identifiant;
        $this->password = $account->password;
        $this->url = $account->url;
        $this->notes = $account->notes;
        $this->category_id = $account->category_id;
        $this->isOpen = true;
    }

    public function update()
    {
        $this->validate();

        $this->account->update([
            'name' => $this->name,
            'identifiant' => $this->identifiant,
            'password' => $this->password,
            'url' => $this->url,
            'notes' => $this->notes,
            'category_id' => $this->category_id,
        ]);

        $this->isOpen = false;
        // $this->dispatch('accountUpdated'); // Pour rafraîchir la liste
        $this->isOpen = false;

        // Cette ligne force le navigateur à rafraîchir la page entière


        Notification::make()
            ->title('Modifications réussies!')
            ->success()
            ->send();
        $this->js('window.location.reload()');
    }

    public function render()
    {
        return view('livewire.edit-account-modal', [
            'categories' => \App\Models\Category::all()
        ]);
    }
}
