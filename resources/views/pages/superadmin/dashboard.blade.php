<x-layout.superadmin title="Super Admin Dashboard">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Dashboard Global</h1>
            <p class="text-muted-foreground text-sm">Vue d'ensemble complète du système</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn self-start sm:self-auto">+ Nouvel utilisateur</a>
    </div>

    {{-- STATS UTILISATEURS & VENTES --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">

        <div class="bg-card border border-border p-3 md:p-4 rounded-lg">
            <p class="text-muted-foreground text-xs md:text-sm">Utilisateurs actifs</p>
            <p class="text-xl md:text-2xl font-bold">{{ $usersActifs }}</p>
            <p class="text-xs text-muted-foreground mt-1">{{ $totalUsers }} au total</p>
        </div>

        <div class="bg-card border border-border p-3 md:p-4 rounded-lg">
            <p class="text-muted-foreground text-xs md:text-sm">Ventes totales</p>
            <p class="text-xl md:text-2xl font-bold">{{ $ventesTotales }}</p>
        </div>

        <div class="bg-card border border-border p-3 md:p-4 rounded-lg">
            <p class="text-muted-foreground text-xs md:text-sm">CA ce mois</p>
            <p class="text-lg md:text-2xl font-bold text-primary">
                {{ number_format($ventesCeMois, 2, ',', ' ') }} DA
            </p>
        </div>

        <div class="bg-card border border-border p-3 md:p-4 rounded-lg">
            <p class="text-muted-foreground text-xs md:text-sm">CA aujourd'hui</p>
            <p class="text-lg md:text-2xl font-bold text-primary">
                {{ number_format($ventesAujourdhui, 2, ',', ' ') }} DA
            </p>
        </div>

    </div>

    {{-- ALERTES STOCK --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">

        <div class="bg-card border border-border p-3 md:p-4 rounded-lg">
            <p class="text-muted-foreground text-xs md:text-sm">Total produits</p>
            <p class="text-xl md:text-2xl font-bold">{{ $totalProduits }}</p>
        </div>

        <div class="bg-card border border-border p-3 md:p-4 rounded-lg">
            <p class="text-muted-foreground text-xs md:text-sm">Stock faible</p>
            <p class="text-xl md:text-2xl font-bold {{ $stockFaible > 0 ? 'text-red-400' : '' }}">
                {{ $stockFaible }}
            </p>
        </div>

        <div class="bg-card border border-border p-3 md:p-4 rounded-lg">
            <p class="text-muted-foreground text-xs md:text-sm">Lots périmés</p>
            <p class="text-xl md:text-2xl font-bold {{ $lotsPerimes > 0 ? 'text-red-400' : '' }}">
                {{ $lotsPerimes }}
            </p>
        </div>

        <div class="bg-card border border-border p-3 md:p-4 rounded-lg">
            <p class="text-muted-foreground text-xs md:text-sm">Expire sous 30j</p>
            <p class="text-xl md:text-2xl font-bold {{ $lotsExpirantBientot > 0 ? 'text-yellow-400' : '' }}">
                {{ $lotsExpirantBientot }}
            </p>
        </div>

    </div>

    {{-- PRODUITS LES PLUS VENDUS + DERNIERS MOUVEMENTS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        {{-- PRODUITS LES PLUS VENDUS --}}
        <div class="bg-card border border-border rounded-lg overflow-hidden">
            <div class="px-4 py-3 border-b border-border">
                <h2 class="font-semibold text-sm md:text-base">Produits les plus vendus</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="border-b border-border">
                        <tr class="text-muted-foreground">
                            <th class="text-left px-4 py-3">Produit</th>
                            <th class="text-left px-4 py-3">Qté vendue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($produitsLesPlusVendus as $produit)
                            <tr class="hover:bg-border/20 transition">
                                <td class="px-4 py-3 font-medium truncate max-w-[180px]">{{ $produit->nom }}</td>
                                <td class="px-4 py-3 text-primary font-bold">{{ $produit->total_vendu }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-8 text-center text-muted-foreground">
                                    Aucune vente enregistrée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- DERNIERS MOUVEMENTS --}}
        <div class="bg-card border border-border rounded-lg overflow-hidden">
            <div class="px-4 py-3 border-b border-border flex items-center justify-between">
                <h2 class="font-semibold text-sm md:text-base">Derniers mouvements</h2>
                <a href="{{ route('mouvements.index') }}" class="text-xs text-primary">Voir tout</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="border-b border-border">
                        <tr class="text-muted-foreground">
                            <th class="text-left px-4 py-3">Type</th>
                            <th class="text-left px-4 py-3">Produit</th>
                            <th class="text-left px-4 py-3">Qté</th>
                            <th class="text-left px-4 py-3 hidden sm:table-cell">Par</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($derniersMouvements as $mouvement)
                            @php
                                $colors = [
                                    'entree'     => 'text-green-400 bg-green-500/10',
                                    'vente'      => 'text-blue-400 bg-blue-500/10',
                                    'retour'     => 'text-yellow-400 bg-yellow-500/10',
                                    'perte'      => 'text-red-400 bg-red-500/10',
                                    'ajustement' => 'text-purple-400 bg-purple-500/10',
                                ];
                            @endphp
                            <tr class="hover:bg-border/20 transition">
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded text-xs capitalize {{ $colors[$mouvement->type_mouvement] ?? '' }}">
                                        {{ $mouvement->type_mouvement }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 font-medium truncate max-w-[120px]">
                                    {{ $mouvement->produit->nom }}
                                </td>
                                <td class="px-4 py-3">{{ $mouvement->quantite }}</td>
                                <td class="px-4 py-3 text-muted-foreground hidden sm:table-cell">
                                    {{ $mouvement->user?->name ?? '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-muted-foreground">
                                    Aucun mouvement.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</x-layout.superadmin>