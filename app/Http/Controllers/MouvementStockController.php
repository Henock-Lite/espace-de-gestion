<?php

namespace App\Http\Controllers;

use App\Models\MouvementStock;
use App\Models\Produit;
use Illuminate\Http\Request;

class MouvementStockController extends Controller
{
    public function index(Request $request)
    {
        $query = MouvementStock::with('produit', 'lot', 'user')
            ->latest('date_mouvement');

        // Filtres
        if ($request->filled('produit_id')) {
            $query->where('produit_id', $request->produit_id);
        }

        if ($request->filled('type_mouvement')) {
            $query->where('type_mouvement', $request->type_mouvement);
        }

        if ($request->filled('date_debut')) {
            $query->whereDate('date_mouvement', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->whereDate('date_mouvement', '<=', $request->date_fin);
        }

        $mouvements = $query->paginate(15)->withQueryString();
        $produits   = Produit::where('actif', true)->get();

        return view('pages.admin.mouvements.index', compact('mouvements', 'produits'));
    }

    public function show(string $id)
    {
        $mouvement = MouvementStock::with('produit', 'lot', 'user')
            ->findOrFail($id);

        return view('pages.admin.mouvements.show', compact('mouvement'));
    }
}