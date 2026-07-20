<x-layout.admin title="Détail vente">

    <div class="flex flex-wrap items-center gap-3 mb-6">
        <a href="{{ route('ventes.index') }}" class="text-muted-foreground hover:text-foreground transition text-sm">
            ← Retour
        </a>
        <h1 class="text-xl md:text-2xl font-bold">Facture — {{ $vente->numero_facture }}</h1>
        @if($vente->statut === 'validée')
            <span class="px-2 py-1 bg-green-500/10 text-green-400 rounded text-xs">Validée</span>
        @elseif($vente->statut === 'annulée')
            <span class="px-2 py-1 bg-red-500/10 text-red-400 rounded text-xs">Annulée</span>
        @else
            <span class="px-2 py-1 bg-yellow-500/10 text-yellow-400 rounded text-xs">En cours</span>
        @endif
    </div>

    {{-- INFOS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6">

        <div class="bg-card border border-border p-4 rounded-lg">
            <p class="text-muted-foreground text-sm mb-1">Client</p>
            <p class="font-semibold">{{ $vente->client?->nom ?? 'Client anonyme' }}</p>
            @if($vente->client?->telephone)
                <p class="text-sm text-muted-foreground">{{ $vente->client->telephone }}</p>
            @endif
        </div>

        <div class="bg-card border border-border p-4 rounded-lg">
            <p class="text-muted-foreground text-sm mb-1">Vendeur</p>
            <p class="font-semibold">{{ $vente->user?->name ?? '—' }}</p>
            <p class="text-sm text-muted-foreground">
                {{ $vente->date_vente->format('d/m/Y à H:i') }}
            </p>
        </div>

        <div class="bg-card border border-border p-4 rounded-lg sm:col-span-2 md:col-span-1">
            <p class="text-muted-foreground text-sm mb-1">Montant total</p>
            <p class="text-2xl font-bold text-primary">
                {{ number_format($vente->montant_total, 2, ',', ' ') }} DA
            </p>
        </div>

    </div>

    {{-- LIGNES --}}
    <div class="bg-card border border-border rounded-lg overflow-hidden mb-6">
        <div class="px-4 py-3 border-b border-border">
            <h2 class="font-semibold">Produits vendus</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[480px]">
                <thead class="border-b border-border">
                    <tr class="text-muted-foreground">
                        <th class="text-left px-4 py-3">Produit</th>
                        <th class="text-left px-4 py-3 hidden sm:table-cell">N° Lot</th>
                        <th class="text-left px-4 py-3">Qté</th>
                        <th class="text-left px-4 py-3 hidden sm:table-cell">Prix unitaire</th>
                        <th class="text-left px-4 py-3">Sous-total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach($vente->lignes as $ligne)
                        <tr>
                            <td class="px-4 py-3 font-medium">
                                {{ $ligne->produit->nom }}
                                <div class="text-xs text-muted-foreground sm:hidden">
                                    {{ $ligne->lot->numero_lot }}
                                </div>
                            </td>
                            <td class="px-4 py-3 text-muted-foreground hidden sm:table-cell">
                                {{ $ligne->lot->numero_lot }}
                            </td>
                            <td class="px-4 py-3">{{ $ligne->quantite }}</td>
                            <td class="px-4 py-3 hidden sm:table-cell">
                                {{ number_format($ligne->prix_unitaire, 2, ',', ' ') }} DA
                            </td>
                            <td class="px-4 py-3 font-medium">
                                {{ number_format($ligne->sous_total, 2, ',', ' ') }} DA
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-t border-border">
                    <tr>
                        <td colspan="2" class="px-4 py-3 text-right font-semibold sm:hidden">Total</td>
                        <td colspan="4" class="px-4 py-3 text-right font-semibold hidden sm:table-cell">Total</td>
                        <td class="px-4 py-3 font-bold text-primary">
                            {{ number_format($vente->montant_total, 2, ',', ' ') }} DA
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- ANNULER --}}
    @if($vente->statut === 'validée')
        <div class="bg-card border border-red-500/20 rounded-lg p-4"
            x-data="{ open: false }">
            <h2 class="font-semibold text-red-400 mb-2">Annuler la vente</h2>
            <p class="text-sm text-muted-foreground mb-3">
                L'annulation réintègre les quantités dans les lots et crée des mouvements de retour.
            </p>
            <button type="button" @click="open = !open" class="btn btn-outlined text-sm">
                Annuler cette vente
            </button>

            <div x-show="open" x-transition class="mt-4">
                <form method="POST" action="{{ route('ventes.destroy', $vente->id) }}">
                    @csrf
                    @method('DELETE')
                    <div class="mb-3">
                        <label for="motif">Motif d'annulation</label>
                        <input type="text" id="motif" name="motif"
                            class="input {{ $errors->has('motif') ? 'border-red-500' : '' }}"
                            placeholder="Raison de l'annulation...">
                        @error('motif') <p class="error">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="btn w-full sm:w-auto"
                        style="background-color: #ef4444;">
                        Confirmer l'annulation
                    </button>
                </form>
            </div>
        </div>
    @endif

</x-layout.admin>