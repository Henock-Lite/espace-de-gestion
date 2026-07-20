<x-layout.admin title="Détail fournisseur">

    {{-- HEADER --}}
    <div class="flex flex-col gap-2 mb-6">
        <a href="{{ route('fournisseurs.index') }}" class="text-muted-foreground hover:text-foreground transition text-sm flex items-center gap-1 w-fit">
            <span>←</span> Retour aux fournisseurs
        </a>
        <div class="flex flex-wrap items-center gap-3">
            <h1 class="text-xl md:text-2xl font-bold tracking-tight">{{ $fournisseur->nom }}</h1>
            @if($fournisseur->is_active)
                <span class="px-2.5 py-0.5 bg-green-500/10 border border-green-500/20 text-green-400 rounded-full text-xs font-medium">
                    Actif
                </span>
            @else
                <span class="px-2.5 py-0.5 bg-red-500/10 border border-red-500/20 text-red-400 rounded-full text-xs font-medium">
                    Inactif
                </span>
            @endif
        </div>
    </div>

    {{-- INFOS & STATISTIQUES --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        {{-- INFORMATIONS GENERALES --}}
        <div class="bg-card border border-border p-5 rounded-lg shadow-sm space-y-3">
            <h2 class="font-semibold text-sm border-b border-border/60 pb-2">Informations générales</h2>
            
            <div class="flex justify-between items-center text-sm py-0.5">
                <span class="text-xs text-muted-foreground font-medium">Téléphone</span>
                <span class="text-foreground font-mono">{{ $fournisseur->telephone ?? '—' }}</span>
            </div>
            <div class="flex justify-between items-center text-sm py-0.5">
                <span class="text-xs text-muted-foreground font-medium">Email</span>
                <span class="text-foreground">{{ $fournisseur->email ?? '—' }}</span>
            </div>
            <div class="flex justify-between items-center text-sm py-0.5">
                <span class="text-xs text-muted-foreground font-medium">Ville</span>
                <span class="text-foreground">{{ $fournisseur->ville ?? '—' }}</span>
            </div>
            <div class="flex justify-between items-center text-sm py-0.5">
                <span class="text-xs text-muted-foreground font-medium">Adresse</span>
                <span class="text-foreground text-right truncate max-w-[200px]" title="{{ $fournisseur->adresse }}">
                    {{ $fournisseur->adresse ?? '—' }}
                </span>
            </div>

            @if($fournisseur->description)
                <div class="pt-2 border-t border-border/40 text-sm">
                    <span class="text-xs text-muted-foreground font-medium block mb-1">Description / Notes</span>
                    <p class="text-xs text-foreground/90 bg-background/50 p-2.5 rounded border border-border/60 leading-relaxed">
                        {{ $fournisseur->description }}
                    </p>
                </div>
            @endif
        </div>

        {{-- STATISTIQUES D'APPROVISIONNEMENT --}}
        <div class="bg-card border border-border p-5 rounded-lg shadow-sm flex flex-col justify-between">
            <div>
                <h2 class="font-semibold text-sm border-b border-border/60 pb-2 mb-4">Statistiques d'approvisionnement</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-background/50 border border-border/80 p-3 rounded-md">
                        <p class="text-xs text-muted-foreground font-medium mb-1">Total commandes</p>
                        <p class="text-xl md:text-2xl font-bold font-mono text-foreground">
                            {{ $fournisseur->approvisionnements->count() }}
                        </p>
                    </div>
                    <div class="bg-background/50 border border-border/80 p-3 rounded-md">
                        <p class="text-xs text-muted-foreground font-medium mb-1">Montant cumulé</p>
                        <p class="text-xl md:text-2xl font-bold font-mono text-primary">
                            {{ number_format($fournisseur->approvisionnements->sum('montant_total'), 2, ',', ' ') }} <span class="text-xs font-normal text-muted-foreground">DA</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- HISTORIQUE DES APPROVISIONNEMENTS --}}
    @php
        $statuts = [
            'reçu' => 'text-green-400 bg-green-500/10 border-green-500/20',
            'annulé' => 'text-red-400 bg-red-500/10 border-red-500/20',
            'en_attente' => 'text-yellow-400 bg-yellow-500/10 border-yellow-500/20',
        ];
    @endphp

    <div class="bg-card border border-border rounded-lg overflow-hidden shadow-sm">
        <div class="px-4 py-3 border-b border-border bg-muted/20">
            <h2 class="font-semibold text-sm">Historique des approvisionnements</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[640px]">
                <thead class="border-b border-border bg-muted/10">
                    <tr class="text-muted-foreground">
                        <th class="text-left px-4 py-3 font-medium">N° Bon</th>
                        <th class="text-left px-4 py-3 font-medium">Date</th>
                        <th class="text-left px-4 py-3 font-medium">Montant</th>
                        <th class="text-left px-4 py-3 font-medium">Statut</th>
                        <th class="text-left px-4 py-3 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($fournisseur->approvisionnements as $appro)
                        <tr class="hover:bg-border/10 transition">
                            <td class="px-4 py-3 font-medium font-mono text-foreground">
                                {{ $appro->numero_bon }}
                            </td>
                            <td class="px-4 py-3 text-muted-foreground font-mono text-xs">
                                {{ $appro->date_approvisionnement?->format('d/m/Y') ?? '—' }}
                            </td>
                            <td class="px-4 py-3 font-semibold font-mono text-foreground">
                                {{ number_format($appro->montant_total, 2, ',', ' ') }} DA
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 border rounded text-xs font-medium capitalize {{ $statuts[$appro->statut] ?? 'bg-border text-foreground' }}">
                                    {{ $appro->statut }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('approvisionnements.show', $appro->id) }}"
                                    class="text-xs px-3 py-1 bg-card border border-border rounded hover:bg-border transition font-medium">
                                    Voir
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-muted-foreground">
                                Aucun approvisionnement enregistré pour ce fournisseur.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-layout.admin>