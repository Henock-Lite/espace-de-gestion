<x-layout.admin title="Modifier fournisseur">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('fournisseurs.index') }}" class="text-muted-foreground hover:text-foreground transition text-sm">
            ← Retour
        </a>
        <h1 class="text-xl md:text-2xl font-bold">Modifier — {{ $fournisseur->nom }}</h1>
    </div>

    <div class="bg-card border border-border rounded-lg p-4 md:p-6 max-w-xl mx-auto">

        <form method="POST" action="{{ route('fournisseurs.update', $fournisseur->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom"
                    class="input {{ $errors->has('nom') ? 'border-red-500' : '' }}"
                    value="{{ old('nom', $fournisseur->nom) }}">
                @error('nom') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="telephone">Téléphone</label>
                    <input type="text" id="telephone" name="telephone"
                        class="input"
                        value="{{ old('telephone', $fournisseur->telephone) }}">
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email"
                        class="input {{ $errors->has('email') ? 'border-red-500' : '' }}"
                        value="{{ old('email', $fournisseur->email) }}">
                    @error('email') <p class="error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="adresse">Adresse</label>
                <input type="text" id="adresse" name="adresse"
                    class="input"
                    value="{{ old('adresse', $fournisseur->adresse) }}">
            </div>

            <div class="mb-4">
                <label for="ville">Ville</label>
                <input type="text" id="ville" name="ville"
                    class="input"
                    value="{{ old('ville', $fournisseur->ville) }}">
            </div>

            <div class="mb-4">
                <label for="description">Description</label>
                <textarea id="description" name="description"
                    class="textarea">{{ old('description', $fournisseur->description) }}</textarea>
            </div>

            <div class="mb-6" x-data="{ active: {{ $fournisseur->is_active ? 'true' : 'false' }} }">
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
                <a href="{{ route('fournisseurs.index') }}" class="btn btn-outlined w-full sm:w-auto text-center">Annuler</a>
            </div>

        </form>

    </div>

</x-layout.admin>