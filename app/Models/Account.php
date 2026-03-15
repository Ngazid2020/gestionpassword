<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /** @use HasFactory<\Database\Factories\AccountFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'identifiant',
        'password',
        'notes',
        'category_id',
        'user_id',
        'organisation_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    /**
     * Partages actifs qui incluent ce compte.
     */
    public function shares(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(AccountShare::class, 'account_share_items');
    }

    /**
     * Vérifie si ce compte est actuellement partagé avec un utilisateur donné.
     */
    public function isSharedWith(int $userId): bool
    {
        return $this->shares()
            ->active()
            ->where('recipient_id', $userId)
            ->exists();
    }
}
