<?php

namespace App\Filament\Pages;

use App\Models\Account;
use App\Models\Category;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class AccountCards extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static string $view = 'filament.pages.account-cards';
    protected static ?string $navigationLabel = 'Mes comptes';
    protected static ?string $title = 'Mes comptes';

    public $accounts = [];
    public $categoryId = null;
    public string $search = '';

    public ?Account $editing = null;
    public array $editForm = [];

    public function mount(): void
    {
        $this->loadAccounts();
    }

    public function updatedSearch()
    {
        $this->loadAccounts();
    }

    public function updatedCategoryId()
    {
        $this->loadAccounts();
    }


    public function loadAccounts(): void
    {
        $this->accounts = Account::query()
            ->with('category')
            ->where('organisation_id', filament()->getTenant()->id)
            ->when($this->categoryId, function ($query) {
                $query->where('category_id', $this->categoryId);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('identifiant', 'like', "%{$this->search}%")
                        ->orWhere('url', 'like', "%{$this->search}%");
                });
            })
            ->latest()
            ->get();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create')
                ->label('Nouveau compte')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->modalHeading('Créer un nouveau compte')
                ->modalSubmitActionLabel('Créer')
                ->form($this->getFormSchema())
                ->action(function (array $data) {

                    $data['organisation_id'] = filament()->getTenant()->id;
                    $data['user_id'] = auth()->id();

                    Account::create($data);

                    $this->loadAccounts();
                }),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Nom')
                ->required(),

            Forms\Components\TextInput::make('url')
                ->label('URL'),

            Forms\Components\TextInput::make('identifiant')
                ->required(),

            Forms\Components\TextInput::make('password')
                ->password()
                ->required(),

            Forms\Components\Textarea::make('notes'),

            Forms\Components\Select::make('category_id')
                ->label('Catégorie')
                ->options(
                    fn() => Category::query()
                        ->where('organisation_id', filament()->getTenant()->id)
                        ->pluck('name', 'id')
                )
                ->searchable()
                ->required(),
        ];
    }

    public function openEdit(int $accountId): void
    {
        $this->editing = Account::where('organisation_id', filament()->getTenant()->id)
            ->findOrFail($accountId);

        $this->editForm = [
            'name' => $this->editing->name,
            'url' => $this->editing->url,
            'identifiant' => $this->editing->identifiant,
            'password' => $this->editing->password,
            'notes' => $this->editing->notes,
            'category_id' => $this->editing->category_id,
        ];

        $this->dispatch('open-modal', id: 'edit-account');
    }

    public function saveEdit(): void
    {
        if (!$this->editing) {
            return;
        }

        if ($this->editing->organisation_id !== filament()->getTenant()->id) {
            abort(403);
        }

        $this->editing->update($this->editForm);

        $this->loadAccounts();

        $this->dispatch('close-modal', id: 'edit-account');
        Notification::make()
            ->title('Compte mis à jour')
            ->success()
            ->send();
    }
}
