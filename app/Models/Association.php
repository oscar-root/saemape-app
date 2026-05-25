<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // Import nécessaire pour la relation

#[Fillable(['num_rccm', 'raison_sociale', 'date_creation', 'localite', 'user_id', 'statut'])]
class Association extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'en_attente';
    public const STATUS_VALIDATED = 'valide';
    public const STATUS_SUSPENDED = 'suspendu';

    public function delegue(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function declarations(): HasMany
    {
        return $this->hasMany(Declaration::class);
    }

    protected function casts(): array
    {
        return [
            'date_creation' => 'date',
        ];
    }

    public function scopeValidated($query)
    {
        return $query->where('statut', self::STATUS_VALIDATED);
    }

    public function scopePending($query)
    {
        return $query->where('statut', self::STATUS_PENDING);
    }
}