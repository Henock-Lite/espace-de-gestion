<x-layout.admin title="Clients">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Clients</h1>
            <p class="text-muted-foreground text-sm">Gérer les clients de la pharmacie</p>
        </div>
        <a href="{{ route('clients.create') }}" class="btn self-start sm:self-auto">+ Nouveau client</a>
    </div>

    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-card border border-border rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[580px]">
                <thead class="border-b border-border">
                    <tr class="text-muted-foreground">
                        <th class="text-left px-4 py-3 hidden sm:table-cell">#</th>
                        <th class="text-left px-4 py-3">Nom</th>
                        <th class="text-left px-4 py-3">Téléphone</th>
                        <th class="text-left px-4 py-3 hidden md:table-cell">Email</th>
                        <th class="text-left px-4 py-3 hidden md:table-cell">Ville</th>
                        <th class="text-left px-4 py-3">Statut</th>
                        <th class="text-left px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($clients as $client)
                        <tr class="hover:bg-border/20 transition">
                            <td class="px-4 py-3 text-muted-foreground hidden sm:table-cell">{{ $client->id }}</td>
                            <td class="px-4 py-3 font-medium">
                                {{ $client->nom }} {{ $client->prenom }}
                                <div class="text-xs text-muted-foreground md:hidden">
                                    {{ $client->ville ?? '' }}
                                </div>
                            </td>
                            <td class="px-4 py-3 text-muted-foreground">
                                {{ $client->telephone ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-muted-foreground hidden md:table-cell">
                                {{ $client->email ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-muted-foreground hidden md:table-cell">
                                {{ $client->ville ?? '—' }}
                            </td>
                            <td class="px-4 py-3">
                                @if($client->is_active)
                                    <span class="px-2 py-1 bg-green-500/10 text-green-400 rounded text-xs">Actif</span>
                                @else
                                    <span class="px-2 py-1 bg-red-500/10 text-red-400 rounded text-xs">Inactif</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-1 md:gap-2">
                                    <a href="{{ route('clients.show', $client->id) }}"
                                        class="text-xs px-2 md:px-3 py-1 bg-card border border-border rounded hover:bg-border transition">
                                        Voir
                                    </a>
                                    <a href="{{ route('clients.edit', $client->id) }}"
                                        class="text-xs px-2 md:px-3 py-1 bg-card border border-border rounded hover:bg-border transition">
                                        Modifier
                                    </a>
                                    
                                    <!-- Modal de confirmation avecAlpine.js pour la désactivation du client -->
                                    <x-modal-confirm 
                                        :action="route('clients.destroy', $client->id)" 
                                        title="Désactiver le client"
                                        message="Voulez-vous vraiment désactiver ce client ?" 
                                    />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-muted-foreground">
                                Aucun client trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($clients->hasPages())
            <div class="px-4 py-3 border-t border-border">
                {{ $clients->links() }}
            </div>
        @endif
    </div>

</x-layout.admin>