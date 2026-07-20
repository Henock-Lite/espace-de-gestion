<x-layout.admin title="Mouvements de stock">

    {{-- HEADER --}}
    <div class="flex flex-col gap-2 mb-6">
        @if(auth()->user()->role === 'super_admin')
            <a href="{{ route('super.dashboard') }}" class="text-muted-foreground hover:text-foreground transition text-sm flex items-center gap-1 w-fit">
                <span>←</span> Retour au dashboard
            </a>
        @endif
        <h1 class="text-xl md:text-2xl font-bold tracking-tight">Mouvements de stock</h1>
    </div>

    {{-- FILTRES --}}
    <div class="bg-card border border-border rounded-lg p-4 mb-6">
        <form method="GET" action="{{ route('mouvements.index') }}"
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">

            <div>
                <label for="produit_id" class="text-xs text-muted-foreground mb-1 block font-medium">Produit</label>
                <select name="produit_id" id="produit_id" class="input text-sm w-full bg-background border-border">
                    <option value="">— Tous les produits —</option>
                    @foreach($produits as $produit)
                        <option value="{{ $produit->id }}"
                            {{ request('produit_id') == $produit->id ? 'selected' : '' }}>
                            {{ $produit->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="type_mouvement" class="text-xs text-muted-foreground mb-1 block font-medium">Type de flux</label>
                <select name="type_mouvement" id="type_mouvement" class="input text-sm w-full bg-background border-border">
                    <option value="">— Tous les types —</option>
                    @foreach(['entree', 'vente', 'retour', 'perte', 'ajustement'] as $type)
                        <option value="{{ $type }}" {{ request('type_mouvement') == $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="date_debut" class="text-xs text-muted-foreground mb-1 block font-medium">Du</label>
                <input type="date" name="date_debut" id="date_debut"
                    class="input text-sm w-full bg-background border-border"
                    value="{{ request('date_debut') }}">
            </div>

            <div>
                <label for="date_fin" class="text-xs text-muted-foreground mb-1 block font-medium">Au</label>
                <input type="date" name="date_fin" id="date_fin"
                    class="input text-sm w-full bg-background border-border"
                    value="{{ request('date_fin') }}">
            </div>

            <div class="sm:col-span-2 md:col-span-4 flex items-center gap-3 pt-1">
                <button type="submit" class="btn text-sm px-4">Filtrer les résultats</button>
                <a href="{{ route('mouvements.index') }}" class="btn btn-outlined text-sm px-4">
                    Réinitialiser
                </a>
            </div>

        </form>
    </div>

    {{-- TABLEAU --}}
    @php
        $colors = [
            'entree'     => 'text-green-400 bg-green-500/10 border-green-500/20',
            'vente'      => 'text-blue-400 bg-blue-500/10 border-blue-500/20',
            'retour'     => 'text-yellow-400 bg-yellow-500/10 border-yellow-500/20',
            'perte'      => 'text-red-400 bg-red-500/10 border-red-500/20',
            'ajustement' => 'text-purple-400 bg-purple-500/10 border-purple-500/20',
        ];
    @endphp

    <div class="bg-card border border-border rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[640px]">
                <thead class="border-b border-border bg-muted/20">
                    <tr class="text-muted-foreground">
                        <th class="text-left px-4 py-3 font-medium">Type</th>
                        <th class="text-left px-4 py-3 font-medium">Produit</th>
                        <th class="text-left px-4 py-3 font-medium hidden md:table-cell">Lot</th>
                        <th class="text-left px-4 py-3 font-medium">Quantité</th>
                        <th class="text-left px-4 py-3 font-medium hidden sm:table-cell">Avant</th>
                        <th class="text-left px-4 py-3 font-medium hidden sm:table-cell">Après</th>
                        <th class="text-left px-4 py-3 font-medium hidden md:table-cell">Date & Heure</th>
                        <th class="text-left px-4 py-3 font-medium hidden md:table-cell">Opérateur</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($mouvements as $mouvement)
                        <tr class="hover:bg-border/10 transition">
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 border rounded text-xs font-medium capitalize {{ $colors[$mouvement->type_mouvement] ?? 'bg-border text-foreground' }}">
                                    {{ $mouvement->type_mouvement }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-medium">
                                <div class="text-foreground">{{ $mouvement->produit->nom }}</div>
                                <div class="text-xs text-muted-foreground md:hidden mt-0.5 space-y-0.5 font-normal">
                                    <div>Lot: <span class="text-foreground/80">{{ $mouvement->lot->numero_lot }}</span></div>
                                    <div class="text-muted-foreground/70">{{ $mouvement->date_mouvement->format('d/m/Y H:i') }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-muted-foreground hidden md:table-cell font-mono">
                                {{ $mouvement->lot->numero_lot }}
                            </td>
                            <td class="px-4 py-3 font-semibold">
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
                                {{ $mouvement->date_mouvement->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-muted-foreground hidden md:table-cell">
                                {{ $mouvement->user?->name ?? '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center text-muted-foreground">
                                Aucun mouvement de stock enregistré pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($mouvements->hasPages())
            <div class="px-4 py-3 border-t border-border bg-muted/10">
                {{ $mouvements->links() }}
            </div>
        @endif
    </div>

</x-layout.admin>