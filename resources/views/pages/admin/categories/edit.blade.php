<x-layout.admin title="Modifier catégorie">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('categories.index') }}" class="text-muted-foreground hover:text-foreground transition text-sm">
            ← Retour
        </a>
        <h1 class="text-xl md:text-2xl font-bold">Modifier — {{ $categorie->nom }}</h1>
    </div>

    <div class="bg-card border border-border rounded-lg p-4 md:p-6 max-w-lg mx-auto">

        <form method="POST" action="{{ route('categories.update', $categorie->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom"
                    class="input {{ $errors->has('nom') ? 'border-red-500' : '' }}"
                    value="{{ old('nom', $categorie->nom) }}"
                    placeholder="Ex: Antibiotiques">
                @error('nom')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description">Description</label>
                <textarea id="description" name="description"
                    class="textarea"
                    placeholder="Description optionnelle...">{{ old('description', $categorie->description) }}</textarea>
                @error('description')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6" x-data="{ active: {{ $categorie->is_active ? 'true' : 'false' }} }">
                <label>Statut</label>
                <div class="flex items-center gap-3 mt-2">
                    <input type="hidden" name="is_active" :value="active ? '1' : '0'">
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
                <a href="{{ route('categories.index') }}" class="btn btn-outlined w-full sm:w-auto text-center">Annuler</a>
            </div>

        </form>

    </div>

</x-layout.admin>