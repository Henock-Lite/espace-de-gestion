<x-layout.admin title="Modifier produit">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('produits.index') }}" class="text-muted-foreground hover:text-foreground transition">
            ← Retour
        </a>
        <h1 class="text-2xl font-bold">Modifier — {{ $produit->nom }}</h1>
    </div>

    <div class="bg-card border border-border rounded-lg p-6 max-w-xl mx-auto">

        <form method="POST" action="{{ route('produits.update', $produit->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nom">Nom du produit</label>
                <input type="text" id="nom" name="nom"
                    class="input {{ $errors->has('nom') ? 'border-red-500' : '' }}"
                    value="{{ old('nom', $produit->nom) }}">
                @error('nom') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="categorie_id">Catégorie</label>
                <select id="categorie_id" name="categorie_id" class="input">
                    <option value="">— Sans catégorie —</option>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->id }}"
                            {{ old('categorie_id', $produit->categorie_id) == $categorie->id ? 'selected' : '' }}>
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
                    value="{{ old('code_barre', $produit->code_barre) }}">
                @error('code_barre') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="stock_minimum">Seuil minimum</label>
                <input type="number" id="stock_minimum" name="stock_minimum"
                    class="input"
                    value="{{ old('stock_minimum', $produit->stock_minimum) }}"
                    min="0">
                @error('stock_minimum') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="description">Description</label>
                <textarea id="description" name="description"
                    class="textarea">{{ old('description', $produit->description) }}</textarea>
                @error('description') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6" x-data="{ active: {{ $produit->actif ? 'true' : 'false' }} }">
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

            <div class="flex gap-3">
                <button type="submit" class="btn">Enregistrer</button>
                <a href="{{ route('produits.index') }}" class="btn btn-outlined">Annuler</a>
            </div>

        </form>

    </div>

</x-layout.admin>