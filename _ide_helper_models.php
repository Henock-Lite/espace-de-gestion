<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $fournisseur_id
 * @property int|null $user_id
 * @property string $numero_bon
 * @property numeric $montant_total
 * @property string $statut
 * @property \Illuminate\Support\Carbon|null $date_approvisionnement
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $lot_id
 * @property-read \App\Models\Fournisseur $fournisseur
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LigneApprovisionnement> $lignes
 * @property-read int|null $lignes_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Approvisionnement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Approvisionnement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Approvisionnement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Approvisionnement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Approvisionnement whereDateApprovisionnement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Approvisionnement whereFournisseurId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Approvisionnement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Approvisionnement whereLotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Approvisionnement whereMontantTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Approvisionnement whereNumeroBon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Approvisionnement whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Approvisionnement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Approvisionnement whereUserId($value)
 */
	class Approvisionnement extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nom
 * @property string|null $description
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Produit> $produits
 * @property-read int|null $produits_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nom
 * @property string|null $prenom
 * @property string|null $telephone
 * @property string|null $email
 * @property string|null $adresse
 * @property string|null $ville
 * @property \Illuminate\Support\Carbon|null $date_naissance
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereDateNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereVille($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client withoutTrashed()
 */
	class Client extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nom
 * @property string|null $telephone
 * @property string|null $email
 * @property string|null $adresse
 * @property string|null $ville
 * @property string|null $description
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Approvisionnement> $approvisionnements
 * @property-read int|null $approvisionnements_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fournisseur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fournisseur newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fournisseur query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fournisseur whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fournisseur whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fournisseur whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fournisseur whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fournisseur whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fournisseur whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fournisseur whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fournisseur whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fournisseur whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fournisseur whereVille($value)
 */
	class Fournisseur extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $approvisionnement_id
 * @property int $produit_id
 * @property int $quantite
 * @property numeric $prix_achat
 * @property numeric $sous_total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Approvisionnement $approvisionnement
 * @property-read \App\Models\Produit $produit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneApprovisionnement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneApprovisionnement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneApprovisionnement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneApprovisionnement whereApprovisionnementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneApprovisionnement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneApprovisionnement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneApprovisionnement wherePrixAchat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneApprovisionnement whereProduitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneApprovisionnement whereQuantite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneApprovisionnement whereSousTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneApprovisionnement whereUpdatedAt($value)
 */
	class LigneApprovisionnement extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $vente_id
 * @property int $lot_id
 * @property int $quantite
 * @property numeric $prix_unitaire
 * @property numeric $sous_total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Produit|null $produit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneVente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneVente newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneVente query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneVente whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneVente whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneVente whereLotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneVente wherePrixUnitaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneVente whereQuantite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneVente whereSousTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneVente whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneVente whereVenteId($value)
 */
	class LigneVente extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read \App\Models\Produit|null $produit
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MouvementStock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MouvementStock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MouvementStock query()
 */
	class MouvementStock extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $categorie_id
 * @property string $nom
 * @property string|null $code_barre
 * @property string|null $description
 * @property int $stock_minimum
 * @property bool $actif
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $categorie
 * @property-read bool $stock_critique
 * @property-read int $stock_total
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MouvementStock> $mouvements
 * @property-read int|null $mouvements_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereActif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereCategorieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereCodeBarre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereStockMinimum($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereUpdatedAt($value)
 */
	class Produit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $role
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

