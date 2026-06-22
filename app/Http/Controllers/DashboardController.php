<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use App\Models\Vente;
use App\Models\Produit;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduits    = Produit::where('actif', true)->count();
        $stockFaible      = Produit::where('actif', true)->get()
                            ->filter(fn($p) => $p->stock_critique)->count();
        $lotsExpirantBientot = Lot::prochesExpiration(30)->count();
        $lotsPerimes      = Lot::where('is_perime', true)
                            ->where('quantite_restante', '>', 0)->count();
        $ventesAujourdhui = Vente::whereDate('date_vente', today())
                            ->where('statut', 'validée')->count();
        $chiffreAujourdhui = Vente::whereDate('date_vente', today())
                            ->where('statut', 'validée')->sum('montant_total');
        $ventesHier       = Vente::whereDate('date_vente', today()->subDay())
                            ->where('statut', 'validée')->count();

        $alertesStock = Produit::with('lots')
            ->where('actif', true)->get()
            ->filter(fn($p) => $p->stock_critique)
            ->take(5);

        $alertesExpiration = Lot::with('produit')
            ->prochesExpiration(30)
            ->take(5)
            ->get();

        return view('pages.admin.dashboard', compact(
            'totalProduits',
            'stockFaible',
            'lotsExpirantBientot',
            'lotsPerimes',
            'ventesAujourdhui',
            'chiffreAujourdhui',
            'ventesHier',
            'alertesStock',
            'alertesExpiration',
        ));
    }
}