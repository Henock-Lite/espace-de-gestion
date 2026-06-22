<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('produits')->latest()->paginate(10);
        return view('pages.admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('pages.admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'         => 'required|string|max:255|unique:categories,nom',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'nom'         => $request->nom,
            'description' => $request->description,
            'is_active'   => true,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    public function show(string $id)
    {
        $categorie = Category::with('produits')->findOrFail($id);
        return view('pages.admin.categories.show', compact('categorie'));
    }

    public function edit(string $id)
    {
        $categorie = Category::findOrFail($id);
        return view('pages.admin.categories.edit', compact('categorie'));
    }

    public function update(Request $request, string $id)
    {
        $categorie = Category::findOrFail($id);

        $request->validate([
            'nom'         => 'required|string|max:255|unique:categories,nom,' . $id,
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);

        $categorie->update([
            'nom'         => $request->nom,
            'description' => $request->description,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie mise à jour.');
    }

    public function destroy(string $id)
    {
        $categorie = Category::findOrFail($id);
        $categorie->update(['is_active' => false]);

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie désactivée.');
    }
}