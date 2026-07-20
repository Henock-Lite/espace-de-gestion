<x-layout.admin title="Détail produit">

    <div class="flex flex-wrap items-center gap-3 mb-6">
        <a href="{{ route('produits.index') }}" class="text-muted-foreground hover:text-foreground transition text-sm">
            ← Retour
        </a>
        <h1 class="text-xl md:text-2xl font-bold">{{ $produit->nom }}</h1>
        @if($produit->actif)
            <span class="px-2 py-1 bg-green-500/10 text-green-400 rounded text-xs">Actif</span>
        @else
            <span class="px-2 py-1 bg-red-500/10 text-red-400 rounded text-xs">Inactif</span>
        @endif
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-card border border-border p-4 rounded-lg">
            <p class="text-muted-foreground text-sm">Stock total</p>
            <p class="text-2xl font-bold {{ $produit->stock_critique ? 'text-red-400' : '' }}">
                {{ $produit->stock_total }}
            </p>
        </div>
        <div class="bg-card border border-border p-4 rounded-lg">
            <p class="text-muted-foreground text-sm">Seuil minimum</p>
            <p class="text-2xl font-bold">{{ $produit->stock_minimum }}</p>
        </div>
        <div class="bg-card border border-border p-4 rounded-lg">
            <p class="text-muted-foreground text-sm">Catégorie</p>
            <p class="font-bold text-lg">{{ $produit->categorie?->nom ?? '—' }}</p>
        </div>
    </div>

    {{-- LOTS --}}
    <div class="bg-card border border-border rounded-lg overflow-hidden mb-6">
        <div class="px-4 py-3 border-b border-border flex items-center justify-between">
            <h2 class="font-semibold">Lots disponibles</h2>
            <a href="{{ route('lots.create') }}" class="btn text-xs">+ Nouveau lot</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[480px]">
                <thead class="border-b border-border">
                    <tr class="text-muted-foreground">
                        <th class="text-left px-4 py-3">N° Lot</th>
                        <th class="text-left px-4 py-3">Qté restante</th>
                        <th class="text-left px-4 py-3">Expiration</th>
                        <th class="text-left px-4 py-3 hidden md:table-cell">Prix achat</th>
                        <th class="text-left px-4 py-3">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($produit->lots as $lot)
                        <tr class="hover:bg-border/20 transition">
                            <td class="px-4 py-3 font-medium">{{ $lot->numero_lot }}</td>
                            <td class="px-4 py-3">{{ $lot->quantite_restante }}</td>
                            <td class="px-4 py-3 {{ $lot->is_perime ? 'text-red-400' : '' }}">
                                {{ $lot->date_expiration->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3 hidden md:table-cell">
                                {{ number_format($lot->prix_achat, 2) }} DA
                            </td>
                            <td class="px-4 py-3">
                                @if($lot->is_perime)
                                    <span class="px-2 py-1 bg-red-500/10 text-red-400 rounded text-xs">Périmé</span>
                                @elseif($lot->actif)
                                    <span class="px-2 py-1 bg-green-500/10 text-green-400 rounded text-xs">Actif</span>
                                @else
                                    <span class="px-2 py-1 bg-border text-muted-foreground rounded text-xs">Inactif</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-muted-foreground">
                                Aucun lot pour ce produit.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- DERNIERS MOUVEMENTS --}}
    <div class="bg-card border border-border rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b border-border">
            <h2 class="font-semibold">Derniers mouvements</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[480px]">
                <thead class="border-b border-border">
                    <tr class="text-muted-foreground">
                        <th class="text-left px-4 py-3">Type</th>
                        <th class="text-left px-4 py-3">Quantité</th>
                        <th class="text-left px-4 py-3 hidden sm:table-cell">Avant</th>
                        <th class="text-left px-4 py-3 hidden sm:table-cell">Après</th>
                        <th class="text-left px-4 py-3 hidden md:table-cell">Date</th>
                        <th class="text-left px-4 py-3 hidden md:table-cell">Par</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($produit->mouvements as $mouvement)
                        @php
                            $colors = [
                                'entree'     => 'text-green-400',
                                'vente'      => 'text-blue-400',
                                'retour'     => 'text-yellow-400',
                                'perte'      => 'text-red-400',
                                'ajustement' => 'text-purple-400',
                            ];
                        @endphp
                        <tr class="hover:bg-border/20 transition">
                            <td class="px-4 py-3">
                                <span class="{{ $colors[$mouvement->type_mouvement] ?? '' }} capitalize">
                                    {{ $mouvement->type_mouvement }}
                                </span>
                                <div class="text-xs text-muted-foreground md:hidden">
                                    {{ $mouvement->date_mouvement->format('d/m/Y') }}
                                </div>
                            </td>
                            <td class="px-4 py-3">{{ $mouvement->quantite }}</td>
                            <td class="px-4 py-3 text-muted-foreground hidden sm:table-cell">{{ $mouvement->stock_avant }}</td>
                            <td class="px-4 py-3 text-muted-foreground hidden sm:table-cell">{{ $mouvement->stock_apres }}</td>
                            <td class="px-4 py-3 text-muted-foreground hidden md:table-cell">
                                {{ $mouvement->date_mouvement->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-muted-foreground hidden md:table-cell">
                                {{ $mouvement->user?->name ?? '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-muted-foreground">
                                Aucun mouvement.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-layout.admin>