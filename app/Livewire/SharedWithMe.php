<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\AccountShare;
use Illuminate\Support\Facades\Auth;

class SharedWithMe extends Component
{
    // ID du partage dont on affiche le détail
    public ?int $openShareId = null;

    // ─── Listeners ──────────────────────────────────────────────────────────

    #[On('share-created')]
    public function refresh(): void
    {
        // Rechargement automatique quand un nouveau partage est créé
    }

    // ─── Actions ────────────────────────────────────────────────────────────

    public function toggleShare(int $shareId): void
    {
        $this->openShareId = $this->openShareId === $shareId ? null : $shareId;
    }

    /**
     * Charge le mot de passe UNIQUEMENT via Livewire, jamais dans le HTML.
     * Le mot de passe est envoyé via un événement JS ciblé sur la card Alpine.
     * Vérifie que l'utilisateur a bien accès à ce compte via un partage actif.
     */
    public function revealPassword(int $accountId): void
    {
        $hasAccess = AccountShare::active()
            ->where('recipient_id', auth()->user()->id)
            ->whereHas('accounts', fn($q) => $q->where('accounts.id', $accountId))
            ->exists();

        if (! $hasAccess) {
            return;
        }

        // Récupère le compte via le partage actif — jamais directement
        $share = AccountShare::active()
            ->where('recipient_id', auth()->user()->id)
            ->whereHas('accounts', fn($q) => $q->where('accounts.id', $accountId))
            ->first();

        $account = $share->accounts()->find($accountId);

        if (! $account) {
            return;
        }

        // Dispatch un événement JS ciblé sur la card Alpine correspondante
        // Le mot de passe n'est JAMAIS dans le HTML source
        $this->dispatch(
            'shared-password-revealed-' . $accountId,
            password: $account->password ?? ''
        );
    }

    // ─── Computed ────────────────────────────────────────────────────────────

    public function getSharesProperty()
    {
        return AccountShare::active()
            ->where('recipient_id', Auth::id())
            ->with(['owner', 'accounts.category'])
            ->latest()
            ->get();
    }

    // ─── Render ─────────────────────────────────────────────────────────────

    public function render()
    {
        return view('livewire.shared-with-me', [
            'shares' => $this->shares,
        ]);
    }
}
