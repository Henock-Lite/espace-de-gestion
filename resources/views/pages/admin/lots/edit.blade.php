<x-layout.admin title="Modifier lot">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('lots.index') }}" class="text-muted-foreground hover:text-foreground transition text-sm">
            ← Retour
        </a>
        <h1 class="text-xl md:text-2xl font-bold">Modifier lot — {{ $lot->numero_lot }}</h1>
    </div>

    <div class="bg-card border border-border rounded-lg p-4 md:p-6 max-w-xl mx-auto">

        <form method="POST" action="{{ route('lots.update', $lot->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label>Produit</label>
                <input type="text" class="input" value="{{ $lot->produit->nom }}" disabled>
            </div>

            <div class="mb-4">
                <label for="numero_lot">Numéro de lot</label>
                <input type="text" id="numero_lot" name="numero_lot"
                    class="input {{ $errors->has('numero_lot') ? 'border-red-500' : '' }}"
                    value="{{ old('numero_lot', $lot->numero_lot) }}">
                @error('numero_lot') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="date_fabrication">Date fabrication</label>
                    <input type="date" id="date_fabrication" name="date_fabrication"
                        class="input"
                        value="{{ old('date_fabrication', $lot->date_fabrication?->format('Y-m-d')) }}">
                </div>
                <div>
                    <label for="date_expiration">Date expiration</label>
                    <input type="date" id="date_expiration" name="date_expiration"
                        class="input {{ $errors->has('date_expiration') ? 'border-red-500' : '' }}"
                        value="{{ old('date_expiration', $lot->date_expiration->format('Y-m-d')) }}">
                    @error('date_expiration') <p class="error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="quantite_restante">Quantité restante</label>
                    <input type="number" id="quantite_restante" name="quantite_restante"
                        class="input"
                        value="{{ old('quantite_restante', $lot->quantite_restante) }}"
                        min="0">
                    <p class="text-xs text-muted-foreground mt-1">
                        Initiale : {{ $lot->quantite_initiale }} — tout ajustement sera tracé
                    </p>
                </div>
                <div>
                    <label for="prix_achat">Prix achat (DA)</label>
                    <input type="number" id="prix_achat" name="prix_achat"
                        class="input {{ $errors->has('prix_achat') ? 'border-red-500' : '' }}"
                        value="{{ old('prix_achat', $lot->prix_achat) }}"
                        step="0.01" min="0">
                    @error('prix_achat') <p class="error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-6" x-data="{ active: {{ $lot->actif ? 'true' : 'false' }} }">
                <label>Statut</label>
                <div class="flex items-center gap-3 mt-2">
                    <input type="hidden" name="actif" :value="active ? '1' : '0'">
                    <button type="button"
                        @click="active = !active"
                        :class="active ? 'bg-primary' : 'bg-border'"
                        class="relative w-10 h-6 rounded-full transition-colors">
                        <span :class="active ? 'translate-x-5' : 'translate-x-1'"
                            class="absolute top-1 w-4 h-4 bg-white rounded-full transition-transform block">
                        </span>
                    </button>
                    <span class="text-sm" x-text="active ? 'Actif' : 'Inactif'"></span>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit" class="btn w-full sm:w-auto">Enregistrer</button>
                <a href="{{ route('lots.index') }}" class="btn btn-outlined w-full sm:w-auto text-center">Annuler</a>
            </div>

        </form>

    </div>

</x-layout.admin>