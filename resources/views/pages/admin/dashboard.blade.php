<x-layout.admin title="Dashboard pharmacie">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Tableau de bord</h1>
            <p class="text-muted-foreground text-sm">Vue générale du stock, ventes et alertes</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('ventes.create') }}" class="btn text-sm">+ Nouvelle vente</a>
            <a href="{{ route('approvisionnements.create') }}" class="btn btn-outlined text-sm">+ Approvisionnement</a>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">

        <div class="bg-card border border-border p-3 md:p-4 rounded-lg">
            <p class="text-muted-foreground text-xs md:text-sm">Total produits</p>
            <p class="text-xl md:text-2xl font-bold">{{ $totalProduits }}</p>
        </div>

        <div class="bg-card border border-border p-3 md:p-4 rounded-lg">
            <p class="text-muted-foreground text-xs md:text-sm">Ventes aujourd'hui</p>
            <p class="text-xl md:text-2xl font-bold">{{ $ventesAujourdhui }}</p>
            @if($ventesHier > 0)
                <p class="text-xs text-muted-foreground mt-1">{{ $ventesHier }} hier</p>
            @endif
        </div>

        <div class="bg-card border border-border p-3 md:p-4 rounded-lg">
            <p class="text-muted-foreground text-xs md:text-sm">Stock faible</p>
            <p class="text-xl md:text-2xl font-bold {{ $stockFaible > 0 ? 'text-red-400' : '' }}">
                {{ $stockFaible }}
            </p>
        </div>

        <div class="bg-card border border-border p-3 md:p-4 rounded-lg">
            <p class="text-muted-foreground text-xs md:text-sm">Expire sous 30j</p>
            <p class="text-xl md:text-2xl font-bold {{ $lotsExpirantBientot > 0 ? 'text-yellow-400' : '' }}">
                {{ $lotsExpirantBientot }}
            </p>
        </div>

    </div>

    {{-- CHIFFRE DU JOUR --}}
    <div class="bg-card border border-border p-4 rounded-lg mb-6">
        <p class="text-muted-foreground text-sm mb-1">Chiffre d'affaires aujourd'hui</p>
        <p class="text-2xl md:text-3xl font-bold text-primary">
            {{ number_format($chiffreAujourdhui, 2, ',', ' ') }} DA
        </p>
    </div>

    {{-- ALERTES --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        {{-- Stock faible --}}
        <div class="bg-card border border-border p-4 rounded-lg">
            <h2 class="font-semibold mb-3 text-sm md:text-base">Produits stock faible</h2>

            @forelse($alertesStock as $produit)
                <div class="flex items-center justify-between py-2 border-b border-border last:border-0 gap-2">
                    <span class="text-sm truncate">{{ $produit->nom }}</span>
                    <span class="text-sm text-red-400 font-medium shrink-0">
                        {{ $produit->stock_total }} / {{ $produit->stock_minimum }}
                    </span>
                </div>
            @empty
                <p class="text-sm text-muted-foreground">Aucune alerte stock.</p>
            @endforelse

            @if($stockFaible > 5)
                <a href="{{ route('produits.index') }}" class="text-xs text-primary mt-2 block">
                    Voir tous ({{ $stockFaible }})
                </a>
            @endif
        </div>

        {{-- Lots expirant bientôt --}}
        <div class="bg-card border border-border p-4 rounded-lg">
            <h2 class="font-semibold mb-3 text-sm md:text-base">Lots expirant bientôt</h2>

            @forelse($alertesExpiration as $lot)
                <div class="flex items-center justify-between py-2 border-b border-border last:border-0 gap-2">
                    <div class="min-w-0">
                        <span class="text-sm truncate block">{{ $lot->produit->nom }}</span>
                        <span class="text-xs text-muted-foreground">{{ $lot->numero_lot }}</span>
                    </div>
                    <span class="text-sm text-yellow-400 font-medium shrink-0">
                        {{ $lot->date_expiration->format('d/m/Y') }}
                    </span>
                </div>
            @empty
                <p class="text-sm text-muted-foreground">Aucun lot expirant bientôt.</p>
            @endforelse

            @if($lotsExpirantBientot > 5)
                <a href="{{ route('lots.index') }}" class="text-xs text-primary mt-2 block">
                    Voir tous ({{ $lotsExpirantBientot }})
                </a>
            @endif
        </div>

    </div>

</x-layout.admin>