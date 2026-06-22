<?php

namespace App\Models;

use App\Models\Vente;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'email',
        'adresse',
        'ville',
        'date_naissance',
        'is_active',
    ];

    protected $casts = [
        'is_active'      => 'boolean',
        'date_naissance' => 'date',
    ];

    public function ventes(): HasMany
    {
        return $this->hasMany(Vente::class);
    }
}