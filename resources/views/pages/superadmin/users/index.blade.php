<x-layout.superadmin title="Utilisateurs">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Utilisateurs</h1>
            <p class="text-muted-foreground text-sm">Gérer les comptes utilisateurs</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn">+ Nouvel utilisateur</a>
    </div>

    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->has('error'))
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-4 text-sm">
            {{ $errors->first('error') }}
        </div>
    @endif

    <div class="bg-card border border-border rounded-lg overflow-hidden">
        <table class="w-full text-sm">
            <thead class="border-b border-border">
                <tr class="text-muted-foreground">
                    <th class="text-left px-4 py-3">#</th>
                    <th class="text-left px-4 py-3">Nom</th>
                    <th class="text-left px-4 py-3">Email</th>
                    <th class="text-left px-4 py-3">Rôle</th>
                    <th class="text-left px-4 py-3">Statut</th>
                    <th class="text-left px-4 py-3">Créé le</th>
                    <th class="text-left px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @forelse($users as $user)
                    <tr class="hover:bg-border/20 transition">
                        <td class="px-4 py-3 text-muted-foreground">{{ $user->id }}</td>
                        <td class="px-4 py-3 font-medium">
                            {{ $user->name }}
                            @if($user->id === auth()->id())
                                <span class="text-xs text-muted-foreground ml-1">(vous)</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-muted-foreground">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            @if($user->role === 'super_admin')
                                <span class="px-2 py-1 bg-purple-500/10 text-purple-400 rounded text-xs">Super Admin</span>
                            @else
                                <span class="px-2 py-1 bg-blue-500/10 text-blue-400 rounded text-xs">Admin</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($user->is_active)
                                <span class="px-2 py-1 bg-green-500/10 text-green-400 rounded text-xs">Actif</span>
                            @else
                                <span class="px-2 py-1 bg-red-500/10 text-red-400 rounded text-xs">Inactif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('users.edit', $user->id) }}"
                                    class="text-xs px-3 py-1 bg-card border border-border rounded hover:bg-border transition">
                                    Modifier
                                </a>
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('users.destroy', $user->id) }}"
                                        x-data
                                        @submit.prevent="if(confirm('Désactiver cet utilisateur ?')) $el.submit()">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-xs px-3 py-1 bg-red-500/10 text-red-400 border border-red-500/20 rounded hover:bg-red-500/20 transition">
                                            Désactiver
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-muted-foreground">
                            Aucun utilisateur trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($users->hasPages())
            <div class="px-4 py-3 border-t border-border">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</x-layout.superadmin>