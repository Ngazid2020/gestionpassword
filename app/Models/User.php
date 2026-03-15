<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasTenants
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function organisations()
    {
        return $this->belongsToMany(Organisation::class);
    }

    public function getTenants(Panel $panel): Collection
    {
        return $this->organisations;
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->organisations()->whereKey($tenant)->exists();
    }

    /**
     * Partages que cet utilisateur a créés (il est l'owner).
     */
    public function sharedByMe(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AccountShare::class, 'owner_id');
    }
 
    /**
     * Partages reçus par cet utilisateur.
     */
    public function sharedWithMe(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AccountShare::class, 'recipient_id');
    }
 
    /**
     * Partages reçus encore actifs (non expirés).
     */
    public function activeShares(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->sharedWithMe()->active();
    }
}
