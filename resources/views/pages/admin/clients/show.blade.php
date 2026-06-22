<x-layout.admin title="Détail client">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('clients.index') }}" class="text-muted-foreground hover:text-foreground transition">
            ← Retour
        </a>
        <h1 class="text-2xl font-bold">{{ $client->nom }} {{ $client->prenom }}</h1>
        @if($client->is_active)
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
                <span>{{ $client->telephone ?? '—' }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-muted-foreground">Email</span>
                <span>{{ $client->email ?? '—' }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-muted-foreground">Ville</span>
                <span>{{ $client->ville ?? '—' }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-muted-foreground">Adresse</span>
                <span>{{ $client->adresse ?? '—' }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-muted-foreground">Date naissance</span>
                <span>{{ $client->date_naissance?->format('d/m/Y') ?? '—' }}</span>
            </div>
        </div>

        <div class="bg-card border border-border p-4 rounded-lg">
            <h2 class="font-semibold mb-3">Statistiques</h2>
            <div class="flex justify-between text-sm mb-2">
                <span class="text-muted-foreground">Total achats</span>
                <span class="font-bold">{{ $client->ventes->count() }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-muted-foreground">Montant total</span>
                <span class="font-bold text-primary">
                    {{ number_format($client->ventes->sum('montant_total'), 2, ',', ' ') }} DA
                </span>
            </div>
        </div>
    </div>

    {{-- HISTORIQUE VENTES --}}
    <div class="bg-card border border-border rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b border-border">
            <h2 class="font-semibold">Historique des achats</h2>
        </div>
        <table class="w-full text-sm">
            <thead class="border-b border-border">
                <tr class="text-muted-foreground">
                    <th class="text-left px-4 py-3">N° Facture</th>
                    <th class="text-left px-4 py-3">Date</th>
                    <th class="text-left px-4 py-3">Montant</th>
                    <th class="text-left px-4 py-3">Statut</th>
                    <th class="text-left px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @forelse($client->ventes as $vente)
                    <tr class="hover:bg-border/20 transition">
                        <td class="px-4 py-3 font-medium">{{ $vente->numero_facture }}</td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{ $vente->date_vente->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-3">
                            {{ number_format($vente->montant_total, 2, ',', ' ') }} DA
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
                                class="text-xs px-3 py-1 bg-card border border-border rounded hover:bg-border transition">
                                Voir
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-muted-foreground">
                            Aucun achat enregistré.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-layout.admin>