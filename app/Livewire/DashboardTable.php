<?php

namespace App\Livewire;

use App\Models\Account;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardTable extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Retourne le mot de passe uniquement si le compte
     * appartient bien à l'organisation de l'utilisateur connecté.
     * Le mot de passe n'est JAMAIS rendu dans le HTML initial.
     */
    public function revealPassword(int $accountId): void
    {
        $organisation = auth()->user()->organisations()->first();

        abort_unless($organisation, 403);

        $account = Account::where('id', $accountId)
            ->where('organisation_id', $organisation->id)
            ->firstOrFail();

        // Event unique par compte : seule la bonne card Alpine est mise à jour.
        $this->dispatch('password-revealed-' . $accountId, password: $account->password ?? '');
    }

    public function render()
    {
        $organisation = auth()->user()->organisations()->first();

        if (!$organisation) {
            return view('livewire.dashboard-table', ['accounts' => collect()]);
        }

        $accounts = Account::where('organisation_id', $organisation->id)
            ->whereHas('organisation', function ($query) {
                $query->where('organisations.active', true)
                    ->where('organisations.created_at', '>=', now()->subDays(14));
            })
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

        // Favicon uniquement — `password` n'est pas nécessaire pour la liste.
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
            'accounts' => $accounts,
        ]);
    }
}
