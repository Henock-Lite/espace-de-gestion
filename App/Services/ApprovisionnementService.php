<?php

namespace App\Services;

use App\Models\Lot;
use App\Models\MouvementStock;
use App\Models\Approvisionnement;
use App\Models\LigneApprovisionnement;
use Illuminate\Support\Facades\DB;

class ApprovisionnementService
{
    /**
     * Créer un approvisionnement en brouillon
     *
     * @param array $data
     * [
     *   'fournisseur_id' => 1,
     *   'lignes' => [
     *     [
     *       'produit_id'      => 1,
     *       'quantite'        => 100,
     *       'prix_achat'      => 5.50,
     *       'numero_lot'      => 'LOT-2024-001',
     *       'date_expiration' => '2026-12-31',
     *       'date_fabrication'=> '2024-01-01',  // nullable
     *     ],
     *   ]
     * ]
     */
    public function creer(array $data): Approvisionnement
    {
        return DB::transaction(function () use ($data) {

            $appro = Approvisionnement::create([
                'fournisseur_id'         => $data['fournisseur_id'],
                'user_id'                => auth()->id(),
                'numero_bon'             => $this->genererNumeroBon(),
                'montant_total'          => 0,
                'statut'                 => 'en_attente',
                'date_approvisionnement' => now(),
            ]);

            $montantTotal = 0;

            foreach ($data['lignes'] as $ligne) {
                $sousTotal     = $ligne['quantite'] * $ligne['prix_achat'];
                $montantTotal += $sousTotal;

                LigneApprovisionnement::create([
                    'approvisionnement_id' => $appro->id,
                    'produit_id'           => $ligne['produit_id'],
                    'lot_id'               => null, // créé à la validation
                    'quantite'             => $ligne['quantite'],
                    'prix_achat'           => $ligne['prix_achat'],
                    'sous_total'           => $sousTotal,
                ]);
            }

            $appro->update(['montant_total' => $montantTotal]);

            return $appro->load('lignes.produit', 'fournisseur');
        });
    }

    /**
     * Valider la réception — crée les lots et les mouvements de stock
     */
    public function valider(Approvisionnement $appro, array $detailsLots): Approvisionnement
    {
        if ($appro->statut !== 'en_attente') {
            throw new \Exception("Cet approvisionnement ne peut plus être validé.");
        }

        return DB::transaction(function () use ($appro, $detailsLots) {

            foreach ($appro->lignes as $ligne) {
                $details = $detailsLots[$ligne->produit_id] ?? [];

                // Créer le lot
                $lot = Lot::create([
                    'produit_id'        => $ligne->produit_id,
                    'fournisseur_id'    => $appro->fournisseur_id,
                    'numero_lot'        => $details['numero_lot'] ?? null,
                    'date_fabrication'  => $details['date_fabrication'] ?? null,
                    'date_expiration'   => $details['date_expiration'],
                    'quantite_initiale' => $ligne->quantite,
                    'quantite_restante' => $ligne->quantite,
                    'prix_achat'        => $ligne->prix_achat,
                    'actif'             => true,
                    'is_perime'         => false,
                ]);

                // Lier le lot à la ligne
                $ligne->update(['lot_id' => $lot->id]);

                // Mouvement de stock — entrée
                MouvementStock::create([
                    'lot_id'         => $lot->id,
                    'produit_id'     => $ligne->produit_id,
                    'user_id'        => auth()->id(),
                    'type_mouvement' => 'entree',
                    'quantite'       => $ligne->quantite,
                    'stock_avant'    => 0,
                    'stock_apres'    => $ligne->quantite,
                    'description'    => "Approvisionnement #{$appro->numero_bon}",
                    'date_mouvement' => now(),
                ]);
            }

            $appro->update(['statut' => 'reçu']);

            return $appro->load('lignes.lot', 'lignes.produit');
        });
    }

    /**
     * Générer un numéro de bon unique
     * Format : BON-2024-000001
     */
    private function genererNumeroBon(): string
    {
        $annee   = now()->year;
        $dernier = Approvisionnement::whereYear('date_approvisionnement', $annee)->count();
        $numero  = str_pad($dernier + 1, 6, '0', STR_PAD_LEFT);

        return "BON-{$annee}-{$numero}";
    }
}