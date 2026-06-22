<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use App\Models\User;
use App\Models\Vente;
use App\Models\Produit;
use App\Models\MouvementStock;
use Illuminate\Support\Facades\DB;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        // Utilisateurs
        $totalUsers    = User::count();
        $usersActifs   = User::where('is_active', true)->count();

        // Ventes
        $ventesTotales      = Vente::where('statut', 'validée')->count();
        $chiffreAffaires    = Vente::where('statut', 'validée')->sum('montant_total');
        $ventesAujourdhui   = Vente::whereDate('date_vente', today())
                                ->where('statut', 'validée')->sum('montant_total');
        $ventesCeMois       = Vente::whereMonth('date_vente', now()->month)
                                ->whereYear('date_vente', now()->year)
                                ->where('statut', 'validée')->sum('montant_total');

        // Stock
        $totalProduits       = Produit::where('actif', true)->count();
        $lotsPerimes         = Lot::where('is_perime', true)->where('quantite_restante', '>', 0)->count();
        $lotsExpirantBientot = Lot::prochesExpiration(30)->count();
        $stockFaible         = Produit::where('actif', true)->get()
                                ->filter(fn($p) => $p->stock_critique)->count();

        // Produits les plus vendus
        $produitsLesPlusVendus = DB::table('ligne_ventes')
            ->join('produits', 'ligne_ventes.produit_id', '=', 'produits.id')
            ->join('ventes', 'ligne_ventes.vente_id', '=', 'ventes.id')
            ->where('ventes.statut', 'validée')
            ->select('produits.nom', DB::raw('SUM(ligne_ventes.quantite) as total_vendu'))
            ->groupBy('produits.id', 'produits.nom')
            ->orderByDesc('total_vendu')
            ->take(5)
            ->get();

        // Derniers mouvements
        $derniersMouvements = MouvementStock::with('produit', 'user')
            ->latest('date_mouvement')
            ->take(10)
            ->get();

        return view('pages.superadmin.dashboard', compact(
            'totalUsers',
            'usersActifs',
            'ventesTotales',
            'chiffreAffaires',
            'ventesAujourdhui',
            'ventesCeMois',
            'totalProduits',
            'lotsPerimes',
            'lotsExpirantBientot',
            'stockFaible',
            'produitsLesPlusVendus',
            'derniersMouvements',
        ));
    }
}