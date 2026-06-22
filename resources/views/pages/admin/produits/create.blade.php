<x-layout.admin title="Nouveau produit">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('produits.index') }}" class="text-muted-foreground hover:text-foreground transition">
            ← Retour
        </a>
        <h1 class="text-2xl font-bold">Nouveau produit</h1>
    </div>

    <div class="bg-card border border-border rounded-lg p-6 max-w-xl mx-auto">

        <form method="POST" action="{{ route('produits.store') }}">
            @csrf

            <div class="mb-4">
                <label for="nom">Nom du produit</label>
                <input type="text" id="nom" name="nom"
                    class="input {{ $errors->has('nom') ? 'border-red-500' : '' }}"
                    value="{{ old('nom') }}"
                    placeholder="Ex: Paracétamol 500mg">
                @error('nom') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="categorie_id">Catégorie</label>
                <select id="categorie_id" name="categorie_id" class="input">
                    <option value="">— Sans catégorie —</option>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->id }}"
                            {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                            {{ $categorie->nom }}
                        </option>
                    @endforeach
                </select>
                @error('categorie_id') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="code_barre">Code barre</label>
                <input type="text" id="code_barre" name="code_barre"
                    class="input"
                    value="{{ old('code_barre') }}"
                    placeholder="Optionnel">
                @error('code_barre') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="stock_minimum">Seuil minimum</label>
                <input type="number" id="stock_minimum" name="stock_minimum"
                    class="input"
                    value="{{ old('stock_minimum', 10) }}"
                    min="0">
                @error('stock_minimum') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="description">Description</label>
                <textarea id="description" name="description"
                    class="textarea"
                    placeholder="Description optionnelle...">{{ old('description') }}</textarea>
                @error('description') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="btn">Créer le produit</button>
                <a href="{{ route('produits.index') }}" class="btn btn-outlined">Annuler</a>
            </div>

        </form>

    </div>

</x-layout.admin>