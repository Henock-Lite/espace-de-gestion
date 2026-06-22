<x-layout.admin title="Approvisionnements">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Approvisionnements</h1>
            <p class="text-muted-foreground text-sm">Historique des bons de commande</p>
        </div>
        <a href="{{ route('approvisionnements.create') }}" class="btn">+ Nouvel approvisionnement</a>
    </div>

    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-card border border-border rounded-lg overflow-hidden">
        <table class="w-full text-sm">
            <thead class="border-b border-border">
                <tr class="text-muted-foreground">
                    <th class="text-left px-4 py-3">N° Bon</th>
                    <th class="text-left px-4 py-3">Fournisseur</th>
                    <th class="text-left px-4 py-3">Créé par</th>
                    <th class="text-left px-4 py-3">Montant</th>
                    <th class="text-left px-4 py-3">Date</th>
                    <th class="text-left px-4 py-3">Statut</th>
                    <th class="text-left px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @forelse($approvisionnements as $appro)
                    <tr class="hover:bg-border/20 transition">
                        <td class="px-4 py-3 font-medium">{{ $appro->numero_bon }}</td>
                        <td class="px-4 py-3">{{ $appro->fournisseur->nom }}</td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{ $appro->user?->name ?? '—' }}
                        </td>
                        <td class="px-4 py-3 font-medium">
                            {{ number_format($appro->montant_total, 2, ',', ' ') }} DA
                        </td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{ $appro->date_approvisionnement?->format('d/m/Y') ?? '—' }}
                        </td>
                        <td class="px-4 py-3">
                            @if($appro->statut === 'reçu')
                                <span class="px-2 py-1 bg-green-500/10 text-green-400 rounded text-xs">Reçu</span>
                            @elseif($appro->statut === 'annulé')
                                <span class="px-2 py-1 bg-red-500/10 text-red-400 rounded text-xs">Annulé</span>
                            @else
                                <span class="px-2 py-1 bg-yellow-500/10 text-yellow-400 rounded text-xs">En attente</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('approvisionnements.show', $appro->id) }}"
                                    class="text-xs px-3 py-1 bg-card border border-border rounded hover:bg-border transition">
                                    Voir
                                </a>
                                @if($appro->statut === 'en_attente')
                                    <form method="POST" action="{{ route('approvisionnements.destroy', $appro->id) }}"
                                        x-data
                                        @submit.prevent="if(confirm('Annuler cet approvisionnement ?')) $el.submit()">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-xs px-3 py-1 bg-red-500/10 text-red-400 border border-red-500/20 rounded hover:bg-red-500/20 transition">
                                            Annuler
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-muted-foreground">
                            Aucun approvisionnement enregistré.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($approvisionnements->hasPages())
            <div class="px-4 py-3 border-t border-border">
                {{ $approvisionnements->links() }}
            </div>
        @endif
    </div>

</x-layout.admin>