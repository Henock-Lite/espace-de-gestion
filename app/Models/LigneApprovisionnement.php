<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LigneApprovisionnement extends Model
{
    protected $fillable = [
        'approvisionnement_id',
        'produit_id',
        'lot_id',
        'quantite',
        'prix_achat',
        'sous_total',
    ];

    protected $casts = [
        'prix_achat' => 'decimal:2',
        'sous_total' => 'decimal:2',
        'quantite'   => 'integer',
    ];

    public function approvisionnement(): BelongsTo
    {
        return $this->belongsTo(Approvisionnement::class);
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }

    public function lot(): BelongsTo
    {
        return $this->belongsTo(Lot::class);
    }
}