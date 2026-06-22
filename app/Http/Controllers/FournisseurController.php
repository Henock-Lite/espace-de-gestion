<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    public function index()
    {
        $fournisseurs = Fournisseur::latest()->paginate(10);
        return view('pages.admin.fournisseurs.index', compact('fournisseurs'));
    }

    public function create()
    {
        return view('pages.admin.fournisseurs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'         => 'required|string|max:255',
            'telephone'   => 'nullable|string|max:255',
            'email'       => 'nullable|email|unique:fournisseurs,email',
            'adresse'     => 'nullable|string',
            'ville'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Fournisseur::create($request->all());

        return redirect()->route('fournisseurs.index')
            ->with('success', 'Fournisseur créé avec succès.');
    }

    public function show(string $id)
    {
        $fournisseur = Fournisseur::with('approvisionnements.lignes.produit')
            ->findOrFail($id);

        return view('pages.admin.fournisseurs.show', compact('fournisseur'));
    }

    public function edit(string $id)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        return view('pages.admin.fournisseurs.edit', compact('fournisseur'));
    }

    public function update(Request $request, string $id)
    {
        $fournisseur = Fournisseur::findOrFail($id);

        $request->validate([
            'nom'         => 'required|string|max:255',
            'telephone'   => 'nullable|string|max:255',
            'email'       => 'nullable|email|unique:fournisseurs,email,' . $id,
            'adresse'     => 'nullable|string',
            'ville'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);

        $fournisseur->update($request->all());

        return redirect()->route('fournisseurs.index')
            ->with('success', 'Fournisseur mis à jour.');
    }

    public function destroy(string $id)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        $fournisseur->update(['is_active' => false]);

        return redirect()->route('fournisseurs.index')
            ->with('success', 'Fournisseur désactivé.');
    }
}