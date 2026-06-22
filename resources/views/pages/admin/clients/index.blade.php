<x-layout.admin title="Clients">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Clients</h1>
            <p class="text-muted-foreground text-sm">Gérer les clients de la pharmacie</p>
        </div>
        <a href="{{ route('clients.create') }}" class="btn">+ Nouveau client</a>
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
                @forelse($clients as $client)
                    <tr class="hover:bg-border/20 transition">
                        <td class="px-4 py-3 text-muted-foreground">{{ $client->id }}</td>
                        <td class="px-4 py-3 font-medium">
                            {{ $client->nom }} {{ $client->prenom }}
                        </td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{ $client->telephone ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{ $client->email ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-muted-foreground">
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
                            <div class="flex gap-2">
                                <a href="{{ route('clients.show', $client->id) }}"
                                    class="text-xs px-3 py-1 bg-card border border-border rounded hover:bg-border transition">
                                    Voir
                                </a>
                                <a href="{{ route('clients.edit', $client->id) }}"
                                    class="text-xs px-3 py-1 bg-card border border-border rounded hover:bg-border transition">
                                    Modifier
                                </a>
                                <form method="POST" action="{{ route('clients.destroy', $client->id) }}"
                                    x-data
                                    @submit.prevent="if(confirm('Désactiver ce client ?')) $el.submit()">
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
                            Aucun client trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($clients->hasPages())
            <div class="px-4 py-3 border-t border-border">
                {{ $clients->links() }}
            </div>
        @endif
    </div>

</x-layout.admin>