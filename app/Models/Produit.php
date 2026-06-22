<?php

namespace App\Models;
use App\Models\Lot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produit extends Model
{
     protected $fillable = [
        'categorie_id',
        'nom',
        'code_barre',
        'description',
        'stock_minimum',
        'actif',
    ];

    protected $casts = [
        'actif'         => 'boolean',
        'stock_minimum' => 'integer',
    ];

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }

    public function lots(): HasMany
    {
        return $this->hasMany(Lot::class);
    }

    public function mouvements(): HasMany
    {
        return $this->hasMany(MouvementStock::class);
    }

    // Stock total calculé depuis les lots
    public function getStockTotalAttribute(): int
    {
        return $this->lots()
            ->where('actif', true)
            ->where('is_perime', false)
            ->sum('quantite_restante');
    }

    // Vrai si stock sous le seuil minimum
    public function getStockCritiqueAttribute(): bool
    {
        return $this->stock_total <= $this->stock_minimum;
    }
}
