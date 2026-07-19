<?php

namespace App\Services;

use App\Models\Lot;
use App\Models\Vente;
use App\Models\LigneVente;
use App\Models\MouvementStock;
use Illuminate\Support\Facades\DB;


class VenteService
{
    /**
     * Créer une vente complète avec gestion FIFO
     *
     * @param array $data
     * [
     *   'client_id' => 1,         // nullable
     *   'lignes' => [
     *     ['produit_id' => 1, 'quantite' => 3, 'prix_unitaire' => 10.00],
     *     ['produit_id' => 2, 'quantite' => 1, 'prix_unitaire' => 25.00],
     *   ]
     * ]
     */
    public function creer(array $data): Vente
    {
        return DB::transaction(function () use ($data) {

            // 1. Vérifier le stock disponible AVANT de commencer
            foreach ($data['lignes'] as $ligne) {
                $this->verifierStock($ligne['produit_id'], $ligne['quantite']);
            }

            // 2. Créer la vente
            $vente = Vente::create([
                'user_id'        => auth()->id(),
                'client_id'      => $data['client_id'] ?? null,
                'numero_facture' => $this->genererNumeroFacture(),
                'montant_total'  => 0,
                'statut'         => 'validée',
                'date_vente'     => now(),
            ]);

            $montantTotal = 0;

            // 3. Traiter chaque ligne (FIFO)
            foreach ($data['lignes'] as $ligne) {
                $montantTotal += $this->traiterLigne($vente, $ligne);
            }

            // 4. Mettre à jour le montant total
            $vente->update(['montant_total' => $montantTotal]);

            return $vente->load('lignes.produit', 'lignes.lot', 'client');
        });
    }

    /**
     * Traiter une ligne de vente avec FIFO sur les lots
     */
    private function traiterLigne(Vente $vente, array $ligne): float
    {
        $qteRestante  = $ligne['quantite'];
        $montantLigne = 0;

        // FIFO : lots triés par date_expiration ASC, avec verrou
        $lots = Lot::disponibles($ligne['produit_id'])
            ->lockForUpdate()
            ->get();

        foreach ($lots as $lot) {
            if ($qteRestante <= 0) break;

            $qteConsommee = min($lot->quantite_restante, $qteRestante);
            $stockAvant   = $lot->quantite_restante;
            $stockApres   = $stockAvant - $qteConsommee;

            // Créer la ligne de vente
            LigneVente::create([
                'vente_id'      => $vente->id,
                'lot_id'        => $lot->id,
                'produit_id'    => $ligne['produit_id'],
                'quantite'      => $qteConsommee,
                'prix_unitaire' => $ligne['prix_unitaire'],
                'sous_total'    => $qteConsommee * $ligne['prix_unitaire'],
            ]);

            // Enregistrer le mouvement de stock
            MouvementStock::create([
                'lot_id'         => $lot->id,
                'produit_id'     => $ligne['produit_id'],
                'user_id'        => auth()->id(),
                'type_mouvement' => 'vente',
                'quantite'       => $qteConsommee,
                'stock_avant'    => $stockAvant,
                'stock_apres'    => $stockApres,
                'description'    => "Vente #{$vente->numero_facture}",
                'date_mouvement' => now(),
            ]);

            // Décrémenter le lot
            $lot->decrement('quantite_restante', $qteConsommee);

            $montantLigne += $qteConsommee * $ligne['prix_unitaire'];
            $qteRestante  -= $qteConsommee;
        }

        return $montantLigne;
    }

    /**
     * Vérifier que le stock est suffisant (avant toute écriture)
     */
    private function verifierStock(int $produitId, int $quantite): void
    {
        $stockDisponible = Lot::disponibles($produitId)->sum('quantite_restante');

        if ($stockDisponible < $quantite) {
            throw new \Exception(
                "Stock insuffisant pour le produit #$produitId. 
                 Disponible : $stockDisponible, demandé : $quantite"
            );
        }
    }

    /**
     * Générer un numéro de facture unique
     * Format : FAC-2024-000001
     */
    private function genererNumeroFacture(): string
    {
        $annee   = now()->year;
        $dernier = Vente::whereYear('date_vente', $annee)->count();
        $numero  = str_pad($dernier + 1, 6, '0', STR_PAD_LEFT);

        return "FAC-{$annee}-{$numero}";
    }

    /**
     * Annuler une vente (crée des mouvements de retour, ne supprime rien)
     */
    public function annuler(Vente $vente, string $motif): Vente
    {
        if ($vente->statut === 'annulée') {
            throw new \Exception("Cette vente est déjà annulée.");
        }

        return DB::transaction(function () use ($vente, $motif) {

            foreach ($vente->lignes as $ligne) {
                $lot        = $ligne->lot;
                $stockAvant = $lot->quantite_restante;

                // Réintégrer la quantité dans le lot
                $lot->increment('quantite_restante', $ligne->quantite);

                // Mouvement de retour
                MouvementStock::create([
                    'lot_id'         => $lot->id,
                    'produit_id'     => $ligne->produit_id,
                    'user_id'        => auth()->id(),
                    'type_mouvement' => 'retour',
                    'quantite'       => $ligne->quantite,
                    'stock_avant'    => $stockAvant,
                    'stock_apres'    => $stockAvant + $ligne->quantite,
                    'description'    => "Annulation vente #{$vente->numero_facture} — {$motif}",
                    'date_mouvement' => now(),
                ]);
            }

            $vente->update(['statut' => 'annulée']);

            return $vente;
        });
    }
}