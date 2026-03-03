<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Account;
use App\Models\Category;

class CreateAccountModal extends Component
{
    public bool $showModal = false;

    public string $name = '';
    public string $url = '';
    public string $identifiant = '';
    public string $password = '';
    public ?int $category_id = null;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'identifiant' => 'required|string|max:255',
            'url' => 'nullable|url',
            'password' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
        ];
    }

    public function save()
    {
        $this->validate();

        Account::create([
            'name' => $this->name,
            'url' => $this->url,
            'identifiant' => $this->identifiant,
            'password' => $this->password,
            'category_id' => $this->category_id,
            'organisation_id' => auth()->user()->organisations()->first()->id,
            'user_id' => auth()->user()->id,
        ]);

        // Réinitialiser le form
        $this->reset();

        // Fermer modal
        $this->showModal = false;

        // Notification pour le dashboard (facultatif)
        $this->dispatch('accountCreated');
        dd(filament()->getTenant());
    }

    public function render()
    {
        return view('livewire.create-account-modal');
    }
}