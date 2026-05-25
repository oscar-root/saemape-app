<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'association_id', 'qualite_minerai', 'quantite_produite', 
    'tennaire', 'localite', 'montant_cotisation', 'date_paiement', 'statut'
])]
class Declaration extends Model
{
    use HasFactory;

    // BARÈME DES TARIFS (USD par Tonne à 100% de teneur)
    public const TARIFS = [
        'Cuivre' => 15.0,
        'Cobalt' => 48.5,
        'Or' => 1250.0,
        'Cassitérite' => 22.0,
    ];

    public const STATUS_PENDING = 'en_attente';
    public const STATUS_PAID = 'payé';

    /**
     * Logique de calcul métier
     */
    public static function calculerCotisation($minerai, $quantite, $tennaire)
    {
        $taux = self::TARIFS[$minerai] ?? 10.0;
        // Formule : (Quantité * Taux) * (Teneur en %)
        return ($quantite * $taux) * ($tennaire / 100);
    }

    public function association(): BelongsTo
    {
        return $this->belongsTo(Association::class);
    }
    
    protected function casts(): array
    {
        return [
            'date_paiement' => 'date',
            'quantite_produite' => 'double',
            'tennaire' => 'double',
            'montant_cotisation' => 'decimal:2',
        ];
    }
}