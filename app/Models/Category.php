<?php

namespace App\Models;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Category extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

     public function produits(): HasMany
    {
        return $this->hasMany(Produit::class, 'categorie_id');
    }
}
