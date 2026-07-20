<x-layout.admin title="Catégories">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Catégories</h1>
            <p class="text-muted-foreground text-sm">Gérer les catégories de produits</p>
        </div>
        <a href="{{ route('categories.create') }}" class="btn self-start sm:self-auto">+ Nouvelle catégorie</a>
    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="bg-card border border-border rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[600px]">
                <thead class="border-b border-border">
                    <tr class="text-muted-foreground">
                        <th class="text-left px-4 py-3">#</th>
                        <th class="text-left px-4 py-3">Nom</th>
                        <th class="text-left px-4 py-3 hidden md:table-cell">Description</th>
                        <th class="text-left px-4 py-3 hidden sm:table-cell">Produits</th>
                        <th class="text-left px-4 py-3">Statut</th>
                        <th class="text-left px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($categories as $categorie)
                        <tr class="hover:bg-border/20 transition">
                            <td class="px-4 py-3 text-muted-foreground">{{ $categorie->id }}</td>
                            <td class="px-4 py-3 font-medium">{{ $categorie->nom }}</td>
                            <td class="px-4 py-3 text-muted-foreground hidden md:table-cell">
                                {{ $categorie->description ?? '—' }}
                            </td>
                            <td class="px-4 py-3 hidden sm:table-cell">
                                {{ $categorie->produits_count ?? 0 }}
                            </td>
                            <td class="px-4 py-3">
                                @if($categorie->is_active)
                                    <span class="px-2 py-1 bg-green-500/10 text-green-400 rounded text-xs">Actif</span>
                                @else
                                    <span class="px-2 py-1 bg-red-500/10 text-red-400 rounded text-xs">Inactif</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('categories.edit', $categorie->id) }}"
                                        class="text-xs px-3 py-1 bg-card border border-border rounded hover:bg-border transition">
                                        Modifier
                                    </a>
                                    <form method="POST" action="{{ route('categories.destroy', $categorie->id) }}"
                                        x-data
                                        @submit.prevent="if(confirm('Désactiver cette catégorie ?')) $el.submit()">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-xs px-3 py-1 bg-red-500/10 text-red-400 border border-red-500/20 rounded hover:bg-red-500/20 transition">
                                            Désactiver
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-muted-foreground">
                                Aucune catégorie trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($categories->hasPages())
            <div class="px-4 py-3 border-t border-border">
                {{ $categories->links() }}
            </div>
        @endif
    </div>

</x-layout.admin>