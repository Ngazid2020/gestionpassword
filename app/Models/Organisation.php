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
}
