<x-layout.admin title="Détail fournisseur">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('fournisseurs.index') }}" class="text-muted-foreground hover:text-foreground transition">
            ← Retour
        </a>
        <h1 class="text-2xl font-bold">{{ $fournisseur->nom }}</h1>
        @if($fournisseur->is_active)
            <span class="px-2 py-1 bg-green-500/10 text-green-400 rounded text-xs">Actif</span>
        @else
            <span class="px-2 py-1 bg-red-500/10 text-red-400 rounded text-xs">Inactif</span>
        @endif
    </div>

    {{-- INFOS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

        <div class="bg-card border border-border p-4 rounded-lg space-y-3">
            <h2 class="font-semibold mb-3">Informations</h2>
            <div class="flex justify-between text-sm">
                <span class="text-muted-foreground">Téléphone</span>
                <span>{{ $fournisseur->telephone ?? '—' }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-muted-foreground">Email</span>
                <span>{{ $fournisseur->email ?? '—' }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-muted-foreground">Ville</span>
                <span>{{ $fournisseur->ville ?? '—' }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-muted-foreground">Adresse</span>
                <span>{{ $fournisseur->adresse ?? '—' }}</span>
            </div>
            @if($fournisseur->description)
                <div class="text-sm">
                    <span class="text-muted-foreground">Description</span>
                    <p class="mt-1">{{ $fournisseur->description }}</p>
                </div>
            @endif
        </div>

        <div class="bg-card border border-border p-4 rounded-lg">
            <h2 class="font-semibold mb-3">Statistiques</h2>
            <div class="flex justify-between text-sm mb-2">
                <span class="text-muted-foreground">Total approvisionnements</span>
                <span class="font-bold">{{ $fournisseur->approvisionnements->count() }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-muted-foreground">Montant total</span>
                <span class="font-bold text-primary">
                    {{ number_format($fournisseur->approvisionnements->sum('montant_total'), 2, ',', ' ') }} DA
                </span>
            </div>
        </div>

    </div>

    {{-- HISTORIQUE APPROVISIONNEMENTS --}}
    <div class="bg-card border border-border rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b border-border">
            <h2 class="font-semibold">Historique des approvisionnements</h2>
        </div>
        <table class="w-full text-sm">
            <thead class="border-b border-border">
                <tr class="text-muted-foreground">
                    <th class="text-left px-4 py-3">N° Bon</th>
                    <th class="text-left px-4 py-3">Date</th>
                    <th class="text-left px-4 py-3">Montant</th>
                    <th class="text-left px-4 py-3">Statut</th>
                    <th class="text-left px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @forelse($fournisseur->approvisionnements as $appro)
                    <tr class="hover:bg-border/20 transition">
                        <td class="px-4 py-3 font-medium">{{ $appro->numero_bon }}</td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{ $appro->date_approvisionnement?->format('d/m/Y') ?? '—' }}
                        </td>
                        <td class="px-4 py-3">
                            {{ number_format($appro->montant_total, 2, ',', ' ') }} DA
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
                            <a href="{{ route('approvisionnements.show', $appro->id) }}"
                                class="text-xs px-3 py-1 bg-card border border-border rounded hover:bg-border transition">
                                Voir
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-muted-foreground">
                            Aucun approvisionnement enregistré.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-layout.admin>