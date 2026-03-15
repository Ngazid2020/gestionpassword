<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Account;
use App\Models\AccountShare;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ShareAccountsModal extends Component
{
    public bool $showModal = false;

    // Comptes sélectionnés par l'owner
    public array $selectedAccountIds = [];

    // Destinataire
    public ?int $recipient_id = null;

    // Durée : 'preset' ou 'custom'
    public string $durationType = 'preset';

    // Durée prédéfinie : '1h', '24h', '7d'
    public string $presetDuration = '24h';

    // Durée personnalisée
    public ?string $customExpiresAt = null;

    // ─── Validation ─────────────────────────────────────────────────────────

    protected function rules(): array
    {
        return [
            'selectedAccountIds'   => 'required|array|min:1',
            'selectedAccountIds.*' => 'integer|exists:accounts,id',  // ✅ integer ajouté
            'recipient_id'         => 'required|integer|exists:users,id', // ✅ integer ajouté, different retiré
            'durationType'         => 'required|in:preset,custom',
            'presetDuration'       => 'required_if:durationType,preset|in:1h,24h,7d',
            'customExpiresAt'      => 'required_if:durationType,custom|date|after:now',
        ];
    }

    protected array $messages = [
        'selectedAccountIds.required' => 'Sélectionnez au moins un compte.',
        'selectedAccountIds.min'      => 'Sélectionnez au moins un compte.',
        'recipient_id.required'       => 'Choisissez un destinataire.',
        'recipient_id.different'      => 'Vous ne pouvez pas partager avec vous-même.',
        'customExpiresAt.required_if' => 'Précisez une date d\'expiration.',
        'customExpiresAt.after'       => 'La date doit être dans le futur.',
    ];

    // ─── Helpers ─────────────────────────────────────────────────────────────

    /**
     * Résolution robuste du tenant courant.
     * Priorité : Filament tenant → première organisation de l'user.
     */
    private function resolveOrganisationId(): int
    {
        // dd(auth()->user()->organisations()->first()->id);
        return auth()->user()->organisations()->first()->id;
    }

    // ─── Listeners ──────────────────────────────────────────────────────────

    /**
     * FIX #3 — Décorateur #[On] ajouté pour que le bouton global (dispatch JS
     * "openModal") puisse déclencher cette méthode depuis le dashboard.
     */
    #[On('openModal')]
    public function openModal(): void
    {
        $this->reset([
            'selectedAccountIds',
            'recipient_id',
            'durationType',
            'presetDuration',
            'customExpiresAt',
        ]);
        $this->durationType   = 'preset';
        $this->presetDuration = '24h';
        $this->showModal      = true;
    }

    /**
     * FIX #4 — Méthode manquante.
     * Ouvre le modal avec un compte pré-sélectionné depuis la card du dashboard.
     * Déclenché par : new CustomEvent('openShareModal', { detail: { accountId: X } })
     */
    #[On('openShareModal')]
    public function openWithAccount(int $accountId): void
    {
        $this->reset([
            'selectedAccountIds',
            'recipient_id',
            'durationType',
            'presetDuration',
            'customExpiresAt',
        ]);
        $this->durationType       = 'preset';
        $this->presetDuration     = '24h';
        $this->selectedAccountIds = [$accountId]; // ← compte pré-coché
        $this->showModal          = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    // ─── Actions ────────────────────────────────────────────────────────────

    public function share(): void
    {
        // Cast explicite pour éviter les problèmes de type string→int
        $this->selectedAccountIds = array_map('intval', $this->selectedAccountIds);
        $this->recipient_id = (int) $this->recipient_id;

        logger('share() déclenché', [
            'selectedAccountIds' => $this->selectedAccountIds,
            'recipient_id'       => $this->recipient_id,
            'durationType'       => $this->durationType,
            'presetDuration'     => $this->presetDuration,
            'organisationId'     => auth()->user()->organisations()->first()->id,
        ]);
        try {
            $this->validate();
            logger('validation passée ✅');
        } catch (\Illuminate\Validation\ValidationException $e) {
            logger('❌ validation échouée', $e->errors());
            throw $e; // important : on relance pour que Livewire affiche les erreurs
        } catch (\Exception $e) {
            logger('❌ exception inattendue', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);
            throw $e;
        }

        $organisationId = auth()->user()->organisations()->first()->id;

        // Calcul de l'expiration
        $expiresAt = match (true) {
            $this->durationType === 'custom' => \Carbon\Carbon::parse($this->customExpiresAt),
            $this->presetDuration === '1h'   => now()->addHour(),
            $this->presetDuration === '24h'  => now()->addDay(),
            $this->presetDuration === '7d'   => now()->addWeek(),
            default                          => now()->addDay(),
        };

        // Vérifier que les comptes appartiennent bien à l'organisation et à l'owner
        $validAccounts = Account::whereIn('id', $this->selectedAccountIds)
            ->where('organisation_id', $organisationId)
            ->where('user_id', Auth::id())
            ->pluck('id');

        if ($validAccounts->isEmpty()) {
            $this->addError('selectedAccountIds', 'Aucun compte valide sélectionné.');
            return;
        }

        // Création du partage
        $share = AccountShare::create([
            'owner_id'        => auth()->user()->id,
            'recipient_id'    => $this->recipient_id,
            'organisation_id' => $organisationId,
            'expires_at'      => $expiresAt,
        ]);

        $share->accounts()->attach($validAccounts);

        // Notification pour l'owner
        Notification::make()
            ->title('Accès partagé !')
            ->body(
                $validAccounts->count() . ' compte(s) partagé(s) — expire ' .
                    $expiresAt->diffForHumans()
            )
            ->success()
            ->send();

        // FIX #1 — sendToDatabase nécessite HasDatabaseNotifications sur User
        // (pense à ajouter le trait dans app/Models/User.php)
        $recipient = User::find($this->recipient_id);
        Notification::make()
            ->title('Accès temporaire reçu')
            ->body(
                Auth::user()->name . ' vous a partagé ' .
                    $validAccounts->count() . ' compte(s) jusqu\'au ' .
                    $expiresAt->format('d/m/Y à H:i')
            )
            ->success()
            ->sendToDatabase($recipient);

        $this->closeModal();
        $this->dispatch('share-created');
    }

    // ─── Computed ────────────────────────────────────────────────────────────

    public function getMyAccountsProperty()
    {
        // FIX #2 — Utilisation de resolveOrganisationId()
        return Account::where('user_id', Auth::id())
            ->where('organisation_id', $this->resolveOrganisationId())
            ->with('category')
            ->get();
    }

    public function getColleaguesProperty()
    {
        // FIX #2 — Utilisation de resolveOrganisationId()
        $organisationId = $this->resolveOrganisationId();

        return User::whereHas('organisations', fn($q) => $q->where('organisations.id', $organisationId))
            ->where('id', '!=', Auth::id())
            ->get();
    }

    // ─── Render ─────────────────────────────────────────────────────────────

    public function render()
    {
        return view('livewire.share-accounts-modal', [
            'myAccounts' => $this->myAccounts,
            'colleagues' => $this->colleagues,
        ]);
    }
}
