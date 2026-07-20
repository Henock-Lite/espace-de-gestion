<x-layout.admin title="Produits">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Produits</h1>
            <p class="text-muted-foreground text-sm">Gérer les produits pharmaceutiques</p>
        </div>
        <a href="{{ route('produits.create') }}" class="btn self-start sm:self-auto">+ Nouveau produit</a>
    </div>

    {{-- FLASH --}}
    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="bg-card border border-border rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[640px]">
                <thead class="border-b border-border">
                    <tr class="text-muted-foreground">
                        <th class="text-left px-4 py-3 hidden sm:table-cell">#</th>
                        <th class="text-left px-4 py-3">Nom</th>
                        <th class="text-left px-4 py-3 hidden md:table-cell">Catégorie</th>
                        <th class="text-left px-4 py-3">Stock</th>
                        <th class="text-left px-4 py-3 hidden md:table-cell">Seuil min</th>
                        <th class="text-left px-4 py-3">Statut</th>
                        <th class="text-left px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($produits as $produit)
                        <tr class="hover:bg-border/20 transition">
                            <td class="px-4 py-3 text-muted-foreground hidden sm:table-cell">{{ $produit->id }}</td>
                            <td class="px-4 py-3">
                                <div class="font-medium">{{ $produit->nom }}</div>
                                @if($produit->code_barre)
                                    <div class="text-xs text-muted-foreground">{{ $produit->code_barre }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-muted-foreground hidden md:table-cell">
                                {{ $produit->categorie?->nom ?? '—' }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="{{ $produit->stock_critique ? 'text-red-400 font-medium' : 'text-foreground' }}">
                                    {{ $produit->stock_total }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-muted-foreground hidden md:table-cell">{{ $produit->stock_minimum }}</td>
                            <td class="px-4 py-3">
                                @if($produit->actif)
                                    <span class="px-2 py-1 bg-green-500/10 text-green-400 rounded text-xs">Actif</span>
                                @else
                                    <span class="px-2 py-1 bg-red-500/10 text-red-400 rounded text-xs">Inactif</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-1 md:gap-2">
                                    <a href="{{ route('produits.show', $produit->id) }}"
                                        class="text-xs px-2 md:px-3 py-1 bg-card border border-border rounded hover:bg-border transition">
                                        Voir
                                    </a>
                                    <a href="{{ route('produits.edit', $produit->id) }}"
                                        class="text-xs px-2 md:px-3 py-1 bg-card border border-border rounded hover:bg-border transition">
                                        Modifier
                                    </a>
                                    <form method="POST" action="{{ route('produits.destroy', $produit->id) }}"
                                        x-data
                                        @submit.prevent="if(confirm('Désactiver ce produit ?')) $el.submit()">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-xs px-2 md:px-3 py-1 bg-red-500/10 text-red-400 border border-red-500/20 rounded hover:bg-red-500/20 transition">
                                            Désactiver
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-muted-foreground">
                                Aucun produit trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($produits->hasPages())
            <div class="px-4 py-3 border-t border-border">
                {{ $produits->links() }}
            </div>
        @endif
    </div>

</x-layout.admin>