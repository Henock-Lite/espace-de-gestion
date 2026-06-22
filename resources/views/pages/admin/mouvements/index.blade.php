<x-layout.admin title="Mouvements de stock">

    <div class="mb-6 flex items-center gap-3">
        @if (auth()->user()->role === 'super_admin')
            <a href="{{ route('super.dashboard') }}" class="text-muted-foreground hover:text-foreground transition">
                ← Retour au dashboard
            </a>
        @endif
        <h1 class="text-2xl font-bold">Mouvements de stock</h1>
    </div>

    {{-- FILTRES --}}
    <div class="bg-card border border-border rounded-lg p-4 mb-6">
        <form method="GET" action="{{ route('mouvements.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">

            <div>
                <label for="produit_id" class="text-xs text-muted-foreground mb-1 block">Produit</label>
                <select name="produit_id" id="produit_id" class="input text-sm">
                    <option value="">— Tous —</option>
                    @foreach ($produits as $produit)
                        <option value="{{ $produit->id }}"
                            {{ request('produit_id') == $produit->id ? 'selected' : '' }}>
                            {{ $produit->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="type_mouvement" class="text-xs text-muted-foreground mb-1 block">Type</label>
                <select name="type_mouvement" id="type_mouvement" class="input text-sm">
                    <option value="">— Tous —</option>
                    @foreach (['entree', 'vente', 'retour', 'perte', 'ajustement'] as $type)
                        <option value="{{ $type }}" {{ request('type_mouvement') == $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="date_debut" class="text-xs text-muted-foreground mb-1 block">Du</label>
                <input type="date" name="date_debut" id="date_debut" class="input text-sm"
                    value="{{ request('date_debut') }}">
            </div>

            <div>
                <label for="date_fin" class="text-xs text-muted-foreground mb-1 block">Au</label>
                <input type="date" name="date_fin" id="date_fin" class="input text-sm"
                    value="{{ request('date_fin') }}">
            </div>

            <div class="md:col-span-4 flex gap-3">
                <button type="submit" class="btn text-sm">Filtrer</button>
                <a href="{{ route('mouvements.index') }}" class="btn btn-outlined text-sm">Réinitialiser</a>
            </div>

        </form>
    </div>

    {{-- TABLE --}}
    <div class="bg-card border border-border rounded-lg overflow-hidden">
        <table class="w-full text-sm">
            <thead class="border-b border-border">
                <tr class="text-muted-foreground">
                    <th class="text-left px-4 py-3">Type</th>
                    <th class="text-left px-4 py-3">Produit</th>
                    <th class="text-left px-4 py-3">Lot</th>
                    <th class="text-left px-4 py-3">Quantité</th>
                    <th class="text-left px-4 py-3">Avant</th>
                    <th class="text-left px-4 py-3">Après</th>
                    <th class="text-left px-4 py-3">Date</th>
                    <th class="text-left px-4 py-3">Par</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @forelse($mouvements as $mouvement)
                    @php
                        $colors = [
                            'entree' => 'text-green-400 bg-green-500/10',
                            'vente' => 'text-blue-400 bg-blue-500/10',
                            'retour' => 'text-yellow-400 bg-yellow-500/10',
                            'perte' => 'text-red-400 bg-red-500/10',
                            'ajustement' => 'text-purple-400 bg-purple-500/10',
                        ];
                    @endphp
                    <tr class="hover:bg-border/20 transition">
                        <td class="px-4 py-3">
                            <span
                                class="px-2 py-1 rounded text-xs capitalize {{ $colors[$mouvement->type_mouvement] ?? '' }}">
                                {{ $mouvement->type_mouvement }}
                            </span>
                        </td>
                        <td class="px-4 py-3 font-medium">{{ $mouvement->produit->nom }}</td>
                        <td class="px-4 py-3 text-muted-foreground">{{ $mouvement->lot->numero_lot }}</td>
                        <td class="px-4 py-3">{{ $mouvement->quantite }}</td>
                        <td class="px-4 py-3 text-muted-foreground">{{ $mouvement->stock_avant }}</td>
                        <td class="px-4 py-3 text-muted-foreground">{{ $mouvement->stock_apres }}</td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{ $mouvement->date_mouvement->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-3 text-muted-foreground">
                            {{ $mouvement->user?->name ?? '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-muted-foreground">
                            Aucun mouvement trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($mouvements->hasPages())
            <div class="px-4 py-3 border-t border-border">
                {{ $mouvements->links() }}
            </div>
        @endif
    </div>

</x-layout.admin>
