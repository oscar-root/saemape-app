<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'matricule'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * RÔLES OFFICIELS (Chapitre 3.A)
     */
    public const ROLE_DELEGUE = 'delegue';
    public const ROLE_AGENT = 'agent';
    public const ROLE_DIRECTEUR = 'directeur';
    public const ROLE_ADMIN = 'admin';

    
    public function association(): HasOne
    {
        return $this->hasOne(Association::class);
    }

    public function hasRole(string|array $role): bool
    {
        if (is_array($role)) {
            return in_array($this->role, $role);
        }
        return $this->role === $role;
    }

    public function getAssociationNameAttribute(): string
    {
        return $this->association ? $this->association->raison_sociale : 'Aucune association liée';
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}