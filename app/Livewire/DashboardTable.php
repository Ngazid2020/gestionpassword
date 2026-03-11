<?php

namespace App\Livewire;

use App\Models\Account;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardTable extends Component
{
    use WithPagination;

    public $search = '';

    // Réinitialise la pagination quand on tape une recherche
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // On récupère l'organisation active de l'utilisateur
        $organisation = auth()->user()->organisations()->first();

        if (!$organisation) {
            return view('livewire.dashboard-table', ['accounts' => collect()]);
        }

        $accounts = Account::where('organisation_id', $organisation->id)
            // On précise 'organisations.active'
            ->whereHas('organisation', function ($query) {
                $query->where('organisations.active', true)
                    // L'organisation doit avoir moins de 14 jours
                    ->where('organisations.created_at', '>=', now()->subDays(14));
            })
            // On précise 'users.active'
            ->whereHas('user', function ($query) {
                $query->where('users.active', true);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('url', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(6);

        // On applique votre logique de favicon sur les résultats paginés
        $accounts->getCollection()->transform(function ($account) {
            if ($account->url) {
                $domain = parse_url($account->url, PHP_URL_HOST);
                $account->favicon_url = "https://www.google.com/s2/favicons?sz=128&domain=" . ($domain ?? $account->url);
            } else {
                $account->favicon_url = null;
            }
            return $account;
        });

        return view('livewire.dashboard-table', [
            'accounts' => $accounts
        ]);
    }
}
