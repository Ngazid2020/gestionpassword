<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    /** @use HasFactory<\Database\Factories\OrganisationFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'active',
        'plan',
        'subscription_status',
        'trial_ends_at',
        'subscription_ends_at',
    ];

    protected $casts = [
        'trial_ends_at'        => 'datetime',
        'subscription_ends_at' => 'datetime',
        'active'               => 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // ─── Subscription helpers ─────────────────────────────────────────────────

    /**
     * L'organisation a-t-elle un accès valide (trial ou abonnement actif) ?
     */
    public function hasActiveAccess(): bool
    {
        if (! $this->active) {
            return false;
        }

        return match ($this->subscription_status) {
            'trial'  => $this->trial_ends_at?->isFuture() ?? false,
            'active' => $this->subscription_ends_at?->isFuture() ?? false,
            default  => false,
        };
    }

    public function isOnTrial(): bool
    {
        return $this->subscription_status === 'trial'
            && $this->trial_ends_at?->isFuture();
    }

    public function isExpired(): bool
    {
        return ! $this->hasActiveAccess();
    }

    /**
     * Jours restants avant expiration (trial ou abonnement).
     */
    public function daysRemaining(): int
    {
        $date = match ($this->subscription_status) {
            'trial'  => $this->trial_ends_at,
            'active' => $this->subscription_ends_at,
            default  => null,
        };

        if (! $date || $date->isPast()) {
            return 0;
        }

        return (int) now()->diffInDays($date);
    }

    /**
     * Label du statut pour l'affichage Filament.
     */
    public function subscriptionStatusLabel(): string
    {
        return match ($this->subscription_status) {
            'trial'     => "⏳ Essai ({$this->daysRemaining()}j restants)",
            'active'    => "✅ Actif ({$this->daysRemaining()}j restants)",
            'expired'   => '❌ Expiré',
            'cancelled' => '🚫 Annulé',
            default     => $this->subscription_status,
        };
    }

    public function planLabel(): string
    {
        return match ($this->plan) {
            'starter'    => 'Starter',
            'pro'        => 'Pro',
            'enterprise' => 'Enterprise',
            default      => $this->plan,
        };
    }

    /**
     * Enregistre un paiement et renouvelle/active l'abonnement.
     */
    public function recordPayment(array $data, int $adminId): Payment
    {
        // Calcul de la nouvelle période
        $start = $this->subscription_ends_at?->isFuture()
            ? $this->subscription_ends_at          // prolongation
            : now();                                // nouveau départ

        // $end = $start->copy()->addMonths($data['duration_months']);
        // ✅ Cast explicite en int
        $end = $start->copy()->addMonths((int) $data['duration_months']);

        $payment = $this->payments()->create([
            'recorded_by'     => $adminId,
            'plan'            => $data['plan'],
            'payment_method'  => $data['payment_method'],
            'amount'          => $data['amount'],
            'currency'        => $data['currency'] ?? 'KMF',
            'duration_months' => $data['duration_months'],
            'paid_at'         => now(),
            'period_start'    => $start,
            'period_end'      => $end,
            'notes'           => $data['notes'] ?? null,
        ]);

        // Mise à jour de l'organisation
        $this->update([
            'plan'                 => $data['plan'],
            'subscription_status'  => 'active',
            'subscription_ends_at' => $end,
            'active'               => true,
        ]);

        return $payment;
    }
}
