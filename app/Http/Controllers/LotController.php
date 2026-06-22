<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use App\Models\Produit;
use App\Models\Fournisseur;
use App\Models\MouvementStock;
use Illuminate\Http\Request;

class LotController extends Controller
{
    public function index()
    {
        $lots = Lot::with('produit', 'fournisseur')
            ->latest()
            ->paginate(10);

        return view('pages.admin.lots.index', compact('lots'));
    }

    public function create()
    {
        $produits     = Produit::where('actif', true)->get();
        $fournisseurs = Fournisseur::where('is_active', true)->get();

        return view('pages.admin.lots.create', compact('produits', 'fournisseurs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produit_id'        => 'required|exists:produits,id',
            'fournisseur_id'    => 'nullable|exists:fournisseurs,id',
            'numero_lot'        => 'required|string|max:255',
            'date_fabrication'  => 'nullable|date',
            'date_expiration'   => 'required|date|after:today',
            'quantite_initiale' => 'required|integer|min:1',
            'prix_achat'        => 'required|numeric|min:0',
        ]);

        $lot = Lot::create([
            'produit_id'        => $request->produit_id,
            'fournisseur_id'    => $request->fournisseur_id,
            'numero_lot'        => $request->numero_lot,
            'date_fabrication'  => $request->date_fabrication,
            'date_expiration'   => $request->date_expiration,
            'quantite_initiale' => $request->quantite_initiale,
            'quantite_restante' => $request->quantite_initiale,
            'prix_achat'        => $request->prix_achat,
            'actif'             => true,
            'is_perime'         => false,
        ]);

        // Mouvement de stock — entrée
        MouvementStock::create([
            'lot_id'         => $lot->id,
            'produit_id'     => $lot->produit_id,
            'user_id'        => auth()->user()?->id,
            'type_mouvement' => 'entree',
            'quantite'       => $lot->quantite_initiale,
            'stock_avant'    => 0,
            'stock_apres'    => $lot->quantite_initiale,
            'description'    => "Création manuelle du lot #{$lot->numero_lot}",
            'date_mouvement' => now(),
        ]);

        return redirect()->route('lots.index')
            ->with('success', 'Lot créé avec succès.');
    }

    public function show(string $id)
    {
        $lot = Lot::with([
            'produit',
            'fournisseur',
            'mouvements.user',
        ])->findOrFail($id);

        return view('pages.admin.lots.show', compact('lot'));
    }

    public function edit(string $id)
    {
        $lot          = Lot::findOrFail($id);
        $produits     = Produit::where('actif', true)->get();
        $fournisseurs = Fournisseur::where('is_active', true)->get();

        return view('pages.admin.lots.edit', compact('lot', 'produits', 'fournisseurs'));
    }

    public function update(Request $request, string $id)
    {
        $lot = Lot::findOrFail($id);

        $request->validate([
            'numero_lot'       => 'required|string|max:255',
            'date_fabrication' => 'nullable|date',
            'date_expiration'  => 'required|date',
            'prix_achat'       => 'required|numeric|min:0',
            'actif'            => 'boolean',
        ]);

        // Ajustement si quantité modifiée
        if ($request->has('quantite_restante') && $request->quantite_restante != $lot->quantite_restante) {
            $stockAvant = $lot->quantite_restante;
            $stockApres = $request->quantite_restante;

            MouvementStock::create([
                'lot_id'         => $lot->id,
                'produit_id'     => $lot->produit_id,
                'user_id'        => auth()->user()?->id,
                'type_mouvement' => 'ajustement',
                'quantite'       => abs($stockApres - $stockAvant),
                'stock_avant'    => $stockAvant,
                'stock_apres'    => $stockApres,
                'description'    => "Ajustement manuel du lot #{$lot->numero_lot}",
                'date_mouvement' => now(),
            ]);
        }

        $lot->update($request->except(['produit_id']));

        return redirect()->route('lots.index')
            ->with('success', 'Lot mis à jour.');
    }

    public function destroy(string $id)
    {
        $lot = Lot::findOrFail($id);
        $lot->update(['actif' => false]);

        return redirect()->route('lots.index')
            ->with('success', 'Lot désactivé.');
    }
}