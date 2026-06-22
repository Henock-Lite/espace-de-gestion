<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MouvementStock extends Model
{
    protected $table = 'mouvements_stock';
    protected $fillable = [
        'lot_id',
        'produit_id',
        'user_id',
        'type_mouvement',
        'quantite',
        'stock_avant',
        'stock_apres',
        'description',
        'date_mouvement',
    ];

    protected $casts = [
        'quantite'       => 'integer',
        'stock_avant'    => 'integer',
        'stock_apres'    => 'integer',
        'date_mouvement' => 'datetime',
    ];

    // Pas de updated_at — un mouvement ne se modifie jamais
    const UPDATED_AT = null;

    public function lot(): BelongsTo
    {
        return $this->belongsTo(Lot::class);
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}