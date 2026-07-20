<x-layout.admin title="Détail approvisionnement">

    <div class="flex flex-wrap items-center gap-3 mb-6">
        <a href="{{ route('approvisionnements.index') }}" class="text-muted-foreground hover:text-foreground transition text-sm">
            ← Retour
        </a>
        <h1 class="text-xl md:text-2xl font-bold">Bon — {{ $appro->numero_bon }}</h1>
        @if($appro->statut === 'reçu')
            <span class="px-2 py-1 bg-green-500/10 text-green-400 rounded text-xs">Reçu</span>
        @elseif($appro->statut === 'annulé')
            <span class="px-2 py-1 bg-red-500/10 text-red-400 rounded text-xs">Annulé</span>
        @else
            <span class="px-2 py-1 bg-yellow-500/10 text-yellow-400 rounded text-xs">En attente</span>
        @endif
    </div>

    {{-- INFOS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6">

        <div class="bg-card border border-border p-4 rounded-lg">
            <p class="text-muted-foreground text-sm mb-1">Fournisseur</p>
            <p class="font-semibold">{{ $appro->fournisseur->nom }}</p>
            @if($appro->fournisseur->telephone)
                <p class="text-sm text-muted-foreground">{{ $appro->fournisseur->telephone }}</p>
            @endif
        </div>

        <div class="bg-card border border-border p-4 rounded-lg">
            <p class="text-muted-foreground text-sm mb-1">Créé par</p>
            <p class="font-semibold">{{ $appro->user?->name ?? '—' }}</p>
            <p class="text-sm text-muted-foreground">
                {{ $appro->date_approvisionnement?->format('d/m/Y à H:i') ?? '—' }}
            </p>
        </div>

        <div class="bg-card border border-border p-4 rounded-lg sm:col-span-2 md:col-span-1">
            <p class="text-muted-foreground text-sm mb-1">Montant total</p>
            <p class="text-2xl font-bold text-primary">
                {{ number_format($appro->montant_total, 2, ',', ' ') }} DA
            </p>
        </div>

    </div>

    {{-- LIGNES --}}
    <div class="bg-card border border-border rounded-lg overflow-hidden mb-6">
        <div class="px-4 py-3 border-b border-border">
            <h2 class="font-semibold">Produits commandés</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[500px]">
                <thead class="border-b border-border">
                    <tr class="text-muted-foreground">
                        <th class="text-left px-4 py-3">Produit</th>
                        <th class="text-left px-4 py-3 hidden sm:table-cell">N° Lot</th>
                        <th class="text-left px-4 py-3">Qté</th>
                        <th class="text-left px-4 py-3 hidden sm:table-cell">Prix achat</th>
                        <th class="text-left px-4 py-3">Sous-total</th>
                        <th class="text-left px-4 py-3 hidden md:table-cell">Expiration</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach($appro->lignes as $ligne)
                        <tr>
                            <td class="px-4 py-3 font-medium">
                                {{ $ligne->produit->nom }}
                                <div class="text-xs text-muted-foreground sm:hidden">
                                    {{ $ligne->lot?->numero_lot ?? '—' }}
                                </div>
                            </td>
                            <td class="px-4 py-3 text-muted-foreground hidden sm:table-cell">
                                {{ $ligne->lot?->numero_lot ?? '—' }}
                            </td>
                            <td class="px-4 py-3">{{ $ligne->quantite }}</td>
                            <td class="px-4 py-3 hidden sm:table-cell">
                                {{ number_format($ligne->prix_achat, 2, ',', ' ') }} DA
                            </td>
                            <td class="px-4 py-3 font-medium">
                                {{ number_format($ligne->sous_total, 2, ',', ' ') }} DA
                            </td>
                            <td class="px-4 py-3 text-muted-foreground hidden md:table-cell">
                                {{ $ligne->lot?->date_expiration?->format('d/m/Y') ?? '—' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-t border-border">
                    <tr>
                        <td colspan="2" class="px-4 py-3 text-right font-semibold sm:hidden">Total</td>
                        <td colspan="4" class="px-4 py-3 text-right font-semibold hidden sm:table-cell">Total</td>
                        <td class="px-4 py-3 font-bold text-primary">
                            {{ number_format($appro->montant_total, 2, ',', ' ') }} DA
                        </td>
                        <td class="hidden md:table-cell"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- VALIDER --}}
    @if($appro->statut === 'en_attente')
        <div class="bg-card border border-green-500/20 rounded-lg p-4">
            <h2 class="font-semibold text-green-400 mb-2">Valider la réception</h2>
            <p class="text-sm text-muted-foreground mb-4">
                La validation crée les lots et enregistre les mouvements de stock.
            </p>

            <form method="POST" action="{{ route('approvisionnements.update', $appro->id) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="action" value="valider">

                @foreach($appro->lignes as $ligne)
                    <div class="border border-border rounded-lg p-4 mb-3">
                        <p class="font-medium mb-3">{{ $ligne->produit->nom }}</p>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="text-xs text-muted-foreground mb-1 block">N° Lot</label>
                                <input type="text"
                                    name="details_lots[{{ $ligne->produit_id }}][numero_lot]"
                                    class="input text-sm"
                                    placeholder="LOT-2024-001">
                            </div>
                            <div>
                                <label class="text-xs text-muted-foreground mb-1 block">Date fabrication</label>
                                <input type="date"
                                    name="details_lots[{{ $ligne->produit_id }}][date_fabrication]"
                                    class="input text-sm">
                            </div>
                            <div>
                                <label class="text-xs text-muted-foreground mb-1 block">Date expiration *</label>
                                <input type="date"
                                    name="details_lots[{{ $ligne->produit_id }}][date_expiration]"
                                    class="input text-sm {{ $errors->has('details_lots.' . $ligne->produit_id . '.date_expiration') ? 'border-red-500' : '' }}"
                                    required>
                            </div>
                        </div>
                    </div>
                @endforeach

                <button type="submit" class="btn w-full sm:w-auto">Confirmer la réception</button>
            </form>
        </div>
    @endif

</x-layout.admin>