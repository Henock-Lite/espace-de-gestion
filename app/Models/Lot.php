<?php

namespace App\Models;

use App\Models\LigneVente;
use App\Models\MouvementStock;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lot extends Model
{
    protected $fillable = [
        'produit_id',
        'fournisseur_id',
        'numero_lot',
        'date_fabrication',
        'date_expiration',
        'quantite_initiale',
        'quantite_restante',
        'prix_achat',
        'actif',
        'is_perime',
    ];

    protected $casts = [
        'date_fabrication' => 'date',
        'date_expiration'  => 'date',
        'actif'            => 'boolean',
        'is_perime'        => 'boolean',
        'prix_achat'       => 'decimal:2',
    ];

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }

    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function mouvements(): HasMany
    {
        return $this->hasMany(MouvementStock::class);
    }

    public function ligneVentes(): HasMany
    {
        return $this->hasMany(LigneVente::class);
    }

    // Scope FIFO — lots disponibles triés par date d'expiration
    public function scopeDisponibles(Builder $query, int $produitId): Builder
    {
        return $query
            ->where('produit_id', $produitId)
            ->where('quantite_restante', '>', 0)
            ->where('actif', true)
            ->where('is_perime', false)
            ->orderBy('date_expiration', 'asc');
    }

    // Scope alertes expiration (dans les 30 prochains jours)
    public function scopeProchesExpiration(Builder $query, int $jours = 30): Builder
    {
        return $query
            ->where('is_perime', false)
            ->where('quantite_restante', '>', 0)
            ->whereBetween('date_expiration', [now(), now()->addDays($jours)]);
    }
}