<?php

namespace App\Models;

use App\Models\LigneApprovisionnement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Approvisionnement extends Model
{
    protected $fillable = [
        'fournisseur_id',
        'user_id',
        'numero_bon',
        'montant_total',
        'statut',
        'date_approvisionnement',
    ];

    protected $casts = [
        'montant_total'          => 'decimal:2',
        'date_approvisionnement' => 'datetime',
    ];

    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lignes(): HasMany
    {
        return $this->hasMany(LigneApprovisionnement::class);
    }
}