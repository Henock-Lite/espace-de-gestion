<x-layout.admin title="Ventes">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Ventes</h1>
            <p class="text-muted-foreground text-sm">Historique de toutes les ventes</p>
        </div>
        <a href="{{ route('ventes.create') }}" class="btn self-start sm:self-auto">+ Nouvelle vente</a>
    </div>

    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-card border border-border rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[600px]">
                <thead class="border-b border-border">
                    <tr class="text-muted-foreground">
                        <th class="text-left px-4 py-3">N° Facture</th>
                        <th class="text-left px-4 py-3 hidden sm:table-cell">Client</th>
                        <th class="text-left px-4 py-3 hidden md:table-cell">Vendeur</th>
                        <th class="text-left px-4 py-3">Montant</th>
                        <th class="text-left px-4 py-3 hidden md:table-cell">Date</th>
                        <th class="text-left px-4 py-3">Statut</th>
                        <th class="text-left px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($ventes as $vente)
                        <tr class="hover:bg-border/20 transition">
                            <td class="px-4 py-3 font-medium">
                                {{ $vente->numero_facture }}
                                <!-- Infos secondaires regroupées pour le mobile uniquement -->
                                <div class="text-xs text-muted-foreground sm:hidden mt-0.5 space-y-0.5">
                                    <div>{{ $vente->date_vente->format('d/m/Y') }}</div>
                                    <div class="text-foreground/70 font-normal">
                                        {{ $vente->client?->nom ?? 'Client anonyme' }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-muted-foreground hidden sm:table-cell">
                                {{ $vente->client?->nom ?? 'Client anonyme' }}
                            </td>
                            <td class="px-4 py-3 text-muted-foreground hidden md:table-cell">
                                {{ $vente->user?->name ?? '—' }}
                            </td>
                            <td class="px-4 py-3 font-medium text-foreground">
                                {{ number_format($vente->montant_total, 2, ',', ' ') }} DA
                            </td>
                            <td class="px-4 py-3 text-muted-foreground hidden md:table-cell">
                                {{ $vente->date_vente->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3">
                                @if($vente->statut === 'validée')
                                    <span class="px-2 py-1 bg-green-500/10 text-green-400 rounded text-xs">Validée</span>
                                @elseif($vente->statut === 'annulée')
                                    <span class="px-2 py-1 bg-red-500/10 text-red-400 rounded text-xs">Annulée</span>
                                @else
                                    <span class="px-2 py-1 bg-yellow-500/10 text-yellow-400 rounded text-xs">En cours</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('ventes.show', $vente->id) }}"
                                    class="text-xs px-2 md:px-3 py-1 bg-card border border-border rounded hover:bg-border transition inline-block">
                                    Voir
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-muted-foreground">
                                Aucune vente enregistrée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($ventes->hasPages())
            <div class="px-4 py-3 border-t border-border">
                {{ $ventes->links() }}
            </div>
        @endif
    </div>

</x-layout.admin>