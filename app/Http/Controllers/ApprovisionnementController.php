<?php

namespace App\Http\Controllers;

use App\Models\Approvisionnement;
use App\Models\Fournisseur;
use App\Models\Produit;
use App\Services\ApprovisionnementService;
use Illuminate\Http\Request;

class ApprovisionnementController extends Controller
{
    public function __construct(protected ApprovisionnementService $approService) {}

    public function index()
    {
        $approvisionnements = Approvisionnement::with('fournisseur', 'user')
            ->latest()
            ->paginate(10);

        return view('pages.admin.approvisionnements.index', compact('approvisionnements'));
    }

    public function create()
    {
        $fournisseurs = Fournisseur::where('is_active', true)->get();
        $produits     = Produit::where('actif', true)->get();

        return view('pages.admin.approvisionnements.create', compact('fournisseurs', 'produits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fournisseur_id'               => 'required|exists:fournisseurs,id',
            'lignes'                       => 'required|array|min:1',
            'lignes.*.produit_id'          => 'required|exists:produits,id',
            'lignes.*.quantite'            => 'required|integer|min:1',
            'lignes.*.prix_achat'          => 'required|numeric|min:0',
            'lignes.*.numero_lot'          => 'nullable|string|max:255',
            'lignes.*.date_expiration'     => 'required|date|after:today',
            'lignes.*.date_fabrication'    => 'nullable|date',
        ]);

        try {
            $appro = $this->approService->creer($request->all());

            return redirect()->route('approvisionnements.show', $appro->id)
                ->with('success', "Approvisionnement #{$appro->numero_bon} créé avec succès.");

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        $appro = Approvisionnement::with([
            'fournisseur',
            'user',
            'lignes.produit',
            'lignes.lot',
        ])->findOrFail($id);

        return view('pages.admin.approvisionnements.show', compact('appro'));
    }

    public function edit(string $id)
    {
        $appro = Approvisionnement::findOrFail($id);

        if ($appro->statut !== 'en_attente') {
            return back()->withErrors(['error' => 'Cet approvisionnement ne peut plus être modifié.']);
        }

        $fournisseurs = Fournisseur::where('is_active', true)->get();
        $produits     = Produit::where('actif', true)->get();

        return view('pages.admin.approvisionnements.edit', compact('appro', 'fournisseurs', 'produits'));
    }

    public function update(Request $request, string $id)
    {
        $appro = Approvisionnement::findOrFail($id);

        // Valider la réception
        if ($request->action === 'valider') {
            $request->validate([
                'details_lots'                          => 'required|array',
                'details_lots.*.date_expiration'        => 'required|date|after:today',
                'details_lots.*.numero_lot'             => 'nullable|string|max:255',
                'details_lots.*.date_fabrication'       => 'nullable|date',
            ]);

            try {
                $this->approService->valider($appro, $request->details_lots);

                return redirect()->route('approvisionnements.show', $appro->id)
                    ->with('success', "Approvisionnement #{$appro->numero_bon} validé.");

            } catch (\Exception $e) {
                return back()->withErrors(['error' => $e->getMessage()]);
            }
        }

        return back()->withErrors(['error' => 'Action non reconnue.']);
    }

    public function destroy(string $id)
    {
        $appro = Approvisionnement::findOrFail($id);

        if ($appro->statut !== 'en_attente') {
            return back()->withErrors(['error' => 'Seul un approvisionnement en attente peut être annulé.']);
        }

        $appro->update(['statut' => 'annulé']);

        return redirect()->route('approvisionnements.index')
            ->with('success', "Approvisionnement #{$appro->numero_bon} annulé.");
    }
}