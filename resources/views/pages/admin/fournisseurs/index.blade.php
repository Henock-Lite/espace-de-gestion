<x-layout.admin title="Fournisseurs">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Fournisseurs</h1>
            <p class="text-muted-foreground text-sm">Gérer les fournisseurs de la pharmacie</p>
        </div>
        <a href="{{ route('fournisseurs.create') }}" class="btn">+ Nouveau fournisseur</a>
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
                    <th class="text-left px-4 py-3">#</th>
                    <th class="text-left px-4 py-3">Nom</th>
                    <th class="text-left px-4 py-3">Téléphone</th>
                    <th class="text-left px-4 py-3">Email</th>
                    <th class="text-left px-4 py-3">Ville</th>
                    <th class="text-left px-4 py-3">Statut</th>
                    <th class="text-left px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @forelse($fournisseurs as $fournisseur)
                    <tr class="hover:bg-border/20 transition">
                        <td class="px-4 py-3 text-muted-foreground">{{ $fournisseur->id }}</td>
                        <td class="px-4 py-3 font-medium">{{ $fournisseur->nom }}</td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{ $fournisseur->telephone ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{ $fournisseur->email ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{ $fournisseur->ville ?? '—' }}
                        </td>
                        <td class="px-4 py-3">
                            @if($fournisseur->is_active)
                                <span class="px-2 py-1 bg-green-500/10 text-green-400 rounded text-xs">Actif</span>
                            @else
                                <span class="px-2 py-1 bg-red-500/10 text-red-400 rounded text-xs">Inactif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('fournisseurs.show', $fournisseur->id) }}"
                                    class="text-xs px-3 py-1 bg-card border border-border rounded hover:bg-border transition">
                                    Voir
                                </a>
                                <a href="{{ route('fournisseurs.edit', $fournisseur->id) }}"
                                    class="text-xs px-3 py-1 bg-card border border-border rounded hover:bg-border transition">
                                    Modifier
                                </a>
                                <form method="POST" action="{{ route('fournisseurs.destroy', $fournisseur->id) }}"
                                    x-data
                                    @submit.prevent="if(confirm('Désactiver ce fournisseur ?')) $el.submit()">
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
                        <td colspan="7" class="px-4 py-8 text-center text-muted-foreground">
                            Aucun fournisseur trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($fournisseurs->hasPages())
            <div class="px-4 py-3 border-t border-border">
                {{ $fournisseurs->links() }}
            </div>
        @endif
    </div>

</x-layout.admin>