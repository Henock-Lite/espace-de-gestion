<x-layout.admin title="Nouveau lot">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('lots.index') }}" class="text-muted-foreground hover:text-foreground transition text-sm">
            ← Retour
        </a>
        <h1 class="text-xl md:text-2xl font-bold">Nouveau lot</h1>
    </div>

    <div class="bg-card border border-border rounded-lg p-4 md:p-6 max-w-xl mx-auto">

        <form method="POST" action="{{ route('lots.store') }}">
            @csrf

            <div class="mb-4">
                <label for="produit_id">Produit</label>
                <select id="produit_id" name="produit_id"
                    class="input {{ $errors->has('produit_id') ? 'border-red-500' : '' }}">
                    <option value="">— Sélectionner un produit —</option>
                    @foreach($produits as $produit)
                        <option value="{{ $produit->id }}"
                            {{ old('produit_id') == $produit->id ? 'selected' : '' }}>
                            {{ $produit->nom }}
                        </option>
                    @endforeach
                </select>
                @error('produit_id') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="fournisseur_id">Fournisseur</label>
                <select id="fournisseur_id" name="fournisseur_id" class="input">
                    <option value="">— Optionnel —</option>
                    @foreach($fournisseurs as $fournisseur)
                        <option value="{{ $fournisseur->id }}"
                            {{ old('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>
                            {{ $fournisseur->nom }}
                        </option>
                    @endforeach
                </select>
                @error('fournisseur_id') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="numero_lot">Numéro de lot</label>
                <input type="text" id="numero_lot" name="numero_lot"
                    class="input {{ $errors->has('numero_lot') ? 'border-red-500' : '' }}"
                    value="{{ old('numero_lot') }}"
                    placeholder="Ex: LOT-2024-001">
                @error('numero_lot') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="date_fabrication">Date fabrication</label>
                    <input type="date" id="date_fabrication" name="date_fabrication"
                        class="input"
                        value="{{ old('date_fabrication') }}">
                    @error('date_fabrication') <p class="error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="date_expiration">Date expiration</label>
                    <input type="date" id="date_expiration" name="date_expiration"
                        class="input {{ $errors->has('date_expiration') ? 'border-red-500' : '' }}"
                        value="{{ old('date_expiration') }}">
                    @error('date_expiration') <p class="error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="quantite_initiale">Quantité</label>
                    <input type="number" id="quantite_initiale" name="quantite_initiale"
                        class="input {{ $errors->has('quantite_initiale') ? 'border-red-500' : '' }}"
                        value="{{ old('quantite_initiale') }}"
                        min="1">
                    @error('quantite_initiale') <p class="error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="prix_achat">Prix achat (DA)</label>
                    <input type="number" id="prix_achat" name="prix_achat"
                        class="input {{ $errors->has('prix_achat') ? 'border-red-500' : '' }}"
                        value="{{ old('prix_achat') }}"
                        step="0.01" min="0">
                    @error('prix_achat') <p class="error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit" class="btn w-full sm:w-auto">Créer le lot</button>
                <a href="{{ route('lots.index') }}" class="btn btn-outlined w-full sm:w-auto text-center">Annuler</a>
            </div>

        </form>

    </div>

</x-layout.admin>