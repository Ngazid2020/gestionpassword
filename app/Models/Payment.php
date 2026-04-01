<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'organisation_id',
        'recorded_by',
        'plan',
        'payment_method',
        'amount',
        'currency',
        'duration_months',
        'paid_at',
        'period_start',
        'period_end',
        'notes',
    ];
 
    protected $casts = [
        'paid_at'      => 'datetime',
        'period_start' => 'datetime',
        'period_end'   => 'datetime',
        'amount'       => 'decimal:2',
    ];
 
    // ─── Relations ────────────────────────────────────────────────────────────
 
    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }
 
    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
 
    // ─── Helpers ──────────────────────────────────────────────────────────────
 
    public function paymentMethodLabel(): string
    {
        return match ($this->payment_method) {
            'cash'          => '💵 Espèces',
            'bank_transfer' => '🏦 Virement bancaire',
            default         => $this->payment_method,
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
 
    public function formattedAmount(): string
    {
        return number_format($this->amount, 0, ',', ' ') . ' ' . $this->currency;
    }
}
