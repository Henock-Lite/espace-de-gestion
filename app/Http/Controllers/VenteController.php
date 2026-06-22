<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\Client;
use App\Models\Produit;
use App\Services\VenteService;
use Illuminate\Http\Request;

class VenteController extends Controller
{
    public function __construct(protected VenteService $venteService) {}

    public function index()
    {
        $ventes = Vente::with('client', 'user')
            ->latest()
            ->paginate(10);

        return view('pages.admin.ventes.index', compact('ventes'));
    }

    public function create()
    {
        $clients  = Client::where('is_active', true)->get();
        $produits = Produit::with('lots')
            ->where('actif', true)
            ->get();

        return view('pages.admin.ventes.create', compact('clients', 'produits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id'                => 'nullable|exists:clients,id',
            'lignes'                   => 'required|array|min:1',
            'lignes.*.produit_id'      => 'required|exists:produits,id',
            'lignes.*.quantite'        => 'required|integer|min:1',
            'lignes.*.prix_unitaire'   => 'required|numeric|min:0',
        ]);

        try {
            $vente = $this->venteService->creer($request->all());

            return redirect()->route('ventes.show', $vente->id)
                ->with('success', "Vente #{$vente->numero_facture} créée avec succès.");

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        $vente = Vente::with([
            'client',
            'user',
            'lignes.produit',
            'lignes.lot',
        ])->findOrFail($id);

        return view('pages.admin.ventes.show', compact('vente'));
    }

    public function edit(string $id)
    {
        // Une vente validée ne se modifie pas
        abort(403, 'Une vente ne peut pas être modifiée.');
    }

    public function update(Request $request, string $id)
    {
        // Une vente validée ne se modifie pas
        abort(403, 'Une vente ne peut pas être modifiée.');
    }

    public function destroy(string $id)
    {
        $request = request();

        $request->validate([
            'motif' => 'required|string|max:255',
        ]);

        $vente = Vente::findOrFail($id);

        try {
            $this->venteService->annuler($vente, $request->motif);

            return redirect()->route('ventes.index')
                ->with('success', "Vente #{$vente->numero_facture} annulée.");

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}