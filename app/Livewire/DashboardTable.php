<?php

namespace App\Livewire;

use App\Models\Account;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardTable extends Component
{
    use WithPagination;

    public $search         = '';
    public $sortField      = 'created_at';
    public $sortDirection  = 'desc';
    public $categoryFilter = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Tri par colonne — inverse la direction si on clique deux fois sur le même champ.
     */
    public function sortBy(string $field): void
    {
        $allowed = ['name', 'updated_at', 'created_at'];

        if (!in_array($field, $allowed)) {
            return;
        }

        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField     = $field;
            $this->sortDirection = 'asc';
        }
    }

    /**
     * Filtre par catégorie — null = toutes les catégories.
     */
    public function filterCategory(?int $categoryId): void
    {
        $this->categoryFilter = $categoryId;
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
        $this->dispatch(
            'password-revealed-' . $accountId,
            password: $account->password ?? ''
        );
    }

    public function render()
    {
        $organisation = auth()->user()->organisations()->first();

        if (!$organisation) {
            return view('livewire.dashboard-table', ['accounts' => collect()]);
        }

        $accounts = Account::where('organisation_id', $organisation->id)
            ->where('user_id', auth()->user()->id)
            ->whereHas('organisation', function ($query) {
                $query->where('organisations.active', true)
                    ->where('organisations.created_at', '>=', now()->subDays(30));
            })
            ->whereHas('user', function ($query) {
                $query->where('users.active', true);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('url', 'like', '%' . $this->search . '%')
                        ->orWhere('identifiant', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category_id', $this->categoryFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
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
