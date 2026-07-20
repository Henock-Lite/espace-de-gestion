<x-layout.admin title="Lots & Stock">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Lots & Stock</h1>
            <p class="text-muted-foreground text-sm">Suivi des lots et dates de péremption</p>
        </div>
        <a href="{{ route('lots.create') }}" class="btn self-start sm:self-auto">+ Nouveau lot</a>
    </div>

    @if (session('success'))
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-card border border-border rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[700px]">
                <thead class="border-b border-border">
                    <tr class="text-muted-foreground">
                        <th class="text-left px-4 py-3">N° Lot</th>
                        <th class="text-left px-4 py-3">Produit</th>
                        <th class="text-left px-4 py-3 hidden md:table-cell">Fournisseur</th>
                        <th class="text-left px-4 py-3">Qté</th>
                        <th class="text-left px-4 py-3">Expiration</th>
                        <th class="text-left px-4 py-3 hidden md:table-cell">Prix achat</th>
                        <th class="text-left px-4 py-3">Statut</th>
                        <th class="text-left px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($lots as $lot)
                        <tr class="hover:bg-border/20 transition">
                            <td class="px-4 py-3 font-medium">{{ $lot->numero_lot }}</td>
                            <td class="px-4 py-3">{{ $lot->produit->nom }}</td>
                            <td class="px-4 py-3 text-muted-foreground hidden md:table-cell">
                                {{ $lot->fournisseur?->nom ?? '—' }}
                            </td>
                            <td class="px-4 py-3">{{ $lot->quantite_restante }}</td>
                            <td
                                class="px-4 py-3 {{ $lot->is_perime ? 'text-red-400' : ($lot->date_expiration->diffInDays(now()) <= 30 ? 'text-yellow-400' : '') }}">
                                {{ $lot->date_expiration->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3 hidden md:table-cell">
                                {{ number_format($lot->prix_achat, 2) }} DA
                            </td>
                            <td class="px-4 py-3">
                                @if ($lot->is_perime)
                                    <span class="px-2 py-1 bg-red-500/10 text-red-400 rounded text-xs">Périmé</span>
                                @elseif(!$lot->actif)
                                    <span
                                        class="px-2 py-1 bg-border text-muted-foreground rounded text-xs">Inactif</span>
                                @else
                                    <span class="px-2 py-1 bg-green-500/10 text-green-400 rounded text-xs">Actif</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-1 md:gap-2">
                                    <a href="{{ route('lots.show', $lot->id) }}"
                                        class="text-xs px-2 md:px-3 py-1 bg-card border border-border rounded hover:bg-border transition">
                                        Voir
                                    </a>
                                    <a href="{{ route('lots.edit', $lot->id) }}"
                                        class="text-xs px-2 md:px-3 py-1 bg-card border border-border rounded hover:bg-border transition">
                                        Modifier
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-muted-foreground">
                                Aucun lot trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($lots->hasPages())
            <div class="px-4 py-3 border-t border-border">
                {{ $lots->links() }}
            </div>
        @endif
    </div>

</x-layout.admin>
