<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Category;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::with('categorie')
            ->latest()
            ->paginate(10);

        return view('pages.admin.produits.index', compact('produits'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('pages.admin.produits.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'categorie_id'  => 'nullable|exists:categories,id',
            'nom'           => 'required|string|max:255',
            'code_barre'    => 'nullable|string|unique:produits,code_barre',
            'description'   => 'nullable|string',
            'stock_minimum' => 'required|integer|min:0',
        ]);

        Produit::create($request->all());

        return redirect()->route('produits.index')
            ->with('success', 'Produit créé avec succès.');
    }

    public function show(string $id)
    {
        $produit = Produit::with([
            'categorie',
            'lots' => fn($q) => $q->where('actif', true)->orderBy('date_expiration'),
            'mouvements' => fn($q) => $q->latest()->take(10),
        ])->findOrFail($id);

        return view('pages.admin.produits.show', compact('produit'));
    }

    public function edit(string $id)
    {
        $produit    = Produit::findOrFail($id);
        $categories = Category::where('is_active', true)->get();

        return view('pages.admin.produits.edit', compact('produit', 'categories'));
    }

    public function update(Request $request, string $id)
    {
     
        $produit = Produit::findOrFail($id);

        $request->validate([
            'categorie_id'  => 'nullable|exists:categories,id',
            'nom'           => 'required|string|max:255',
            'code_barre'    => 'nullable|string|unique:produits,code_barre,' . $id,
            'description'   => 'nullable|string',
            'stock_minimum' => 'required|integer|min:0',
            'actif'         => 'boolean',
        ]);

        $updated = $produit->update($request->all());


        return redirect()->route('produits.index')
            ->with('success', 'Produit mis à jour.');
    }

    public function destroy(string $id)
    {
        $produit = Produit::findOrFail($id);
        $produit->update(['actif' => false]);

        return redirect()->route('produits.index')
            ->with('success', 'Produit désactivé.');
    }
}
