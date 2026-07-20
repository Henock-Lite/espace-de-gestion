<x-layout.admin title="Détail lot">

    {{-- HEADER --}}
    <div class="flex flex-col gap-2 mb-6">
        <a href="{{ route('lots.index') }}" class="text-muted-foreground hover:text-foreground transition text-sm flex items-center gap-1 w-fit">
            <span>←</span> Retour aux lots
        </a>
        <div class="flex flex-wrap items-center gap-3">
            <h1 class="text-xl md:text-2xl font-bold tracking-tight">Lot — {{ $lot->numero_lot }}</h1>
            @if($lot->is_perime)
                <span class="px-2.5 py-0.5 bg-red-500/10 border border-red-500/20 text-red-400 rounded-full text-xs font-medium">
                    Périmé
                </span>
            @elseif($lot->actif)
                <span class="px-2.5 py-0.5 bg-green-500/10 border border-green-500/20 text-green-400 rounded-full text-xs font-medium">
                    Actif
                </span>
            @else
                <span class="px-2.5 py-0.5 bg-muted border border-border text-muted-foreground rounded-full text-xs font-medium">
                    Inactif
                </span>
            @endif
        </div>
    </div>

    {{-- STATS / INFORMATIONS DU LOT --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-card border border-border p-4 rounded-lg shadow-sm">
            <p class="text-xs text-muted-foreground font-medium mb-1">Produit concerné</p>
            <p class="font-semibold text-sm md:text-base text-foreground truncate" title="{{ $lot->produit->nom }}">
                {{ $lot->produit->nom }}
            </p>
        </div>
        <div class="bg-card border border-border p-4 rounded-lg shadow-sm">
            <p class="text-xs text-muted-foreground font-medium mb-1">Quantité initiale</p>
            <p class="text-xl md:text-2xl font-bold font-mono text-foreground">{{ $lot->quantite_initiale }}</p>
        </div>
        <div class="bg-card border border-border p-4 rounded-lg shadow-sm">
            <p class="text-xs text-muted-foreground font-medium mb-1">Quantité restante</p>
            <p class="text-xl md:text-2xl font-bold font-mono text-foreground">{{ $lot->quantite_restante }}</p>
        </div>
        <div class="bg-card border border-border p-4 rounded-lg shadow-sm">
            <p class="text-xs text-muted-foreground font-medium mb-1">Date d'expiration</p>
            <p class="text-base md:text-lg font-bold {{ $lot->is_perime ? 'text-red-400' : 'text-foreground' }}">
                {{ $lot->date_expiration->format('d/m/Y') }}
            </p>
        </div>
    </div>

    {{-- HISTORIQUE DES MOUVEMENTS --}}
    @php
        $colors = [
            'entree'     => 'text-green-400 bg-green-500/10 border-green-500/20',
            'vente'      => 'text-blue-400 bg-blue-500/10 border-blue-500/20',
            'retour'     => 'text-yellow-400 bg-yellow-500/10 border-yellow-500/20',
            'perte'      => 'text-red-400 bg-red-500/10 border-red-500/20',
            'ajustement' => 'text-purple-400 bg-purple-500/10 border-purple-500/20',
        ];
    @endphp

    <div class="bg-card border border-border rounded-lg overflow-hidden shadow-sm">
        <div class="px-4 py-3 border-b border-border bg-muted/20">
            <h2 class="font-semibold text-sm">Historique des mouvements</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[500px]">
                <thead class="border-b border-border bg-muted/10">
                    <tr class="text-muted-foreground">
                        <th class="text-left px-4 py-3 font-medium">Type</th>
                        <th class="text-left px-4 py-3 font-medium">Quantité</th>
                        <th class="text-left px-4 py-3 font-medium hidden sm:table-cell">Avant</th>
                        <th class="text-left px-4 py-3 font-medium hidden sm:table-cell">Après</th>
                        <th class="text-left px-4 py-3 font-medium hidden md:table-cell">Description</th>
                        <th class="text-left px-4 py-3 font-medium hidden md:table-cell">Date & Heure</th>
                        <th class="text-left px-4 py-3 font-medium hidden md:table-cell">Opérateur</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($lot->mouvements as $mouvement)
                        <tr class="hover:bg-border/10 transition">
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 border rounded text-xs font-medium capitalize {{ $colors[$mouvement->type_mouvement] ?? 'bg-border text-foreground' }}">
                                    {{ $mouvement->type_mouvement }}
                                </span>
                                <div class="text-xs text-muted-foreground/70 md:hidden mt-1 font-normal">
                                    {{ $mouvement->created_at->format('d/m/Y H:i') }}
                                </div>
                            </td>
                            <td class="px-4 py-3 font-semibold font-mono">
                                @if(in_array($mouvement->type_mouvement, ['entree', 'retour']))
                                    <span class="text-green-400">+{{ $mouvement->quantite }}</span>
                                @elseif(in_array($mouvement->type_mouvement, ['vente', 'perte']))
                                    <span class="text-red-400">-{{ $mouvement->quantite }}</span>
                                @else
                                    <span class="text-foreground">{{ $mouvement->quantite }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-muted-foreground hidden sm:table-cell font-mono">
                                {{ $mouvement->stock_avant }}
                            </td>
                            <td class="px-4 py-3 text-muted-foreground hidden sm:table-cell font-mono">
                                {{ $mouvement->stock_apres }}
                            </td>
                            <td class="px-4 py-3 text-muted-foreground hidden md:table-cell">
                                {{ $mouvement->description ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-muted-foreground hidden md:table-cell">
                                {{ $mouvement->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-muted-foreground hidden md:table-cell">
                                {{ $mouvement->user?->name ?? '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-muted-foreground">
                                Aucun mouvement associé à ce lot pour l'instant.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-layout.admin>