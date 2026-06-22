<x-layout.admin title="Détail produit">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('produits.index') }}" class="text-muted-foreground hover:text-foreground transition">
            ← Retour
        </a>
        <h1 class="text-2xl font-bold">{{ $produit->nom }}</h1>
        @if($produit->actif)
            <span class="px-2 py-1 bg-green-500/10 text-green-400 rounded text-xs">Actif</span>
        @else
            <span class="px-2 py-1 bg-red-500/10 text-red-400 rounded text-xs">Inactif</span>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

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
            <p class="text-2xl font-bold">{{ $produit->categorie?->nom ?? '—' }}</p>
        </div>

    </div>

    {{-- LOTS --}}
    <div class="bg-card border border-border rounded-lg overflow-hidden mb-6">
        <div class="px-4 py-3 border-b border-border flex items-center justify-between">
            <h2 class="font-semibold">Lots disponibles</h2>
            <a href="{{ route('lots.create') }}" class="btn text-xs">+ Nouveau lot</a>
        </div>
        <table class="w-full text-sm">
            <thead class="border-b border-border">
                <tr class="text-muted-foreground">
                    <th class="text-left px-4 py-3">N° Lot</th>
                    <th class="text-left px-4 py-3">Qté restante</th>
                    <th class="text-left px-4 py-3">Expiration</th>
                    <th class="text-left px-4 py-3">Prix achat</th>
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
                        <td class="px-4 py-3">{{ number_format($lot->prix_achat, 2) }} DA</td>
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

    {{-- DERNIERS MOUVEMENTS --}}
    <div class="bg-card border border-border rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b border-border">
            <h2 class="font-semibold">Derniers mouvements</h2>
        </div>
        <table class="w-full text-sm">
            <thead class="border-b border-border">
                <tr class="text-muted-foreground">
                    <th class="text-left px-4 py-3">Type</th>
                    <th class="text-left px-4 py-3">Quantité</th>
                    <th class="text-left px-4 py-3">Stock avant</th>
                    <th class="text-left px-4 py-3">Stock après</th>
                    <th class="text-left px-4 py-3">Date</th>
                    <th class="text-left px-4 py-3">Par</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @forelse($produit->mouvements as $mouvement)
                    <tr class="hover:bg-border/20 transition">
                        <td class="px-4 py-3">
                            @php
                                $colors = [
                                    'entree'      => 'text-green-400',
                                    'vente'       => 'text-blue-400',
                                    'retour'      => 'text-yellow-400',
                                    'perte'       => 'text-red-400',
                                    'ajustement'  => 'text-purple-400',
                                ];
                            @endphp
                            <span class="{{ $colors[$mouvement->type_mouvement] ?? '' }} capitalize">
                                {{ $mouvement->type_mouvement }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $mouvement->quantite }}</td>
                        <td class="px-4 py-3 text-muted-foreground">{{ $mouvement->stock_avant }}</td>
                        <td class="px-4 py-3 text-muted-foreground">{{ $mouvement->stock_apres }}</td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{ $mouvement->date_mouvement->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-3 text-muted-foreground">
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

</x-layout.admin>