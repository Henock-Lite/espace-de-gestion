<x-layout.admin title="Détail lot">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('lots.index') }}" class="text-muted-foreground hover:text-foreground transition">
            ← Retour
        </a>
        <h1 class="text-2xl font-bold">Lot — {{ $lot->numero_lot }}</h1>
        @if($lot->is_perime)
            <span class="px-2 py-1 bg-red-500/10 text-red-400 rounded text-xs">Périmé</span>
        @elseif($lot->actif)
            <span class="px-2 py-1 bg-green-500/10 text-green-400 rounded text-xs">Actif</span>
        @else
            <span class="px-2 py-1 bg-border text-muted-foreground rounded text-xs">Inactif</span>
        @endif
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-card border border-border p-4 rounded-lg">
            <p class="text-muted-foreground text-sm">Produit</p>
            <p class="font-semibold">{{ $lot->produit->nom }}</p>
        </div>
        <div class="bg-card border border-border p-4 rounded-lg">
            <p class="text-muted-foreground text-sm">Qté initiale</p>
            <p class="text-2xl font-bold">{{ $lot->quantite_initiale }}</p>
        </div>
        <div class="bg-card border border-border p-4 rounded-lg">
            <p class="text-muted-foreground text-sm">Qté restante</p>
            <p class="text-2xl font-bold">{{ $lot->quantite_restante }}</p>
        </div>
        <div class="bg-card border border-border p-4 rounded-lg">
            <p class="text-muted-foreground text-sm">Expiration</p>
            <p class="font-semibold {{ $lot->is_perime ? 'text-red-400' : '' }}">
                {{ $lot->date_expiration->format('d/m/Y') }}
            </p>
        </div>
    </div>

    {{-- MOUVEMENTS --}}
    <div class="bg-card border border-border rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b border-border">
            <h2 class="font-semibold">Historique des mouvements</h2>
        </div>
        <table class="w-full text-sm">
            <thead class="border-b border-border">
                <tr class="text-muted-foreground">
                    <th class="text-left px-4 py-3">Type</th>
                    <th class="text-left px-4 py-3">Quantité</th>
                    <th class="text-left px-4 py-3">Avant</th>
                    <th class="text-left px-4 py-3">Après</th>
                    <th class="text-left px-4 py-3">Description</th>
                    <th class="text-left px-4 py-3">Date</th>
                    <th class="text-left px-4 py-3">Par</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @forelse($lot->mouvements as $mouvement)
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
                        </td>
                        <td class="px-4 py-3">{{ $mouvement->quantite }}</td>
                        <td class="px-4 py-3 text-muted-foreground">{{ $mouvement->stock_avant }}</td>
                        <td class="px-4 py-3 text-muted-foreground">{{ $mouvement->stock_apres }}</td>
                        <td class="px-4 py-3 text-muted-foreground">{{ $mouvement->description ?? '—' }}</td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{ $mouvement->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{ $mouvement->user?->name ?? '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-muted-foreground">
                            Aucun mouvement pour ce lot.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-layout.admin>