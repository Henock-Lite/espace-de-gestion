<x-layout.admin title="Nouveau fournisseur">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('fournisseurs.index') }}" class="text-muted-foreground hover:text-foreground transition text-sm">
            ← Retour
        </a>
        <h1 class="text-xl md:text-2xl font-bold">Nouveau fournisseur</h1>
    </div>

    <div class="bg-card border border-border rounded-lg p-4 md:p-6 max-w-xl mx-auto">

        <form method="POST" action="{{ route('fournisseurs.store') }}">
            @csrf

            <div class="mb-4">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom"
                    class="input {{ $errors->has('nom') ? 'border-red-500' : '' }}"
                    value="{{ old('nom') }}"
                    placeholder="Nom du fournisseur">
                @error('nom') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="telephone">Téléphone</label>
                    <input type="text" id="telephone" name="telephone"
                        class="input"
                        value="{{ old('telephone') }}"
                        placeholder="Ex: 0661234567">
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email"
                        class="input {{ $errors->has('email') ? 'border-red-500' : '' }}"
                        value="{{ old('email') }}"
                        placeholder="email@exemple.com">
                    @error('email') <p class="error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="adresse">Adresse</label>
                <input type="text" id="adresse" name="adresse"
                    class="input"
                    value="{{ old('adresse') }}"
                    placeholder="Adresse complète">
            </div>

            <div class="mb-4">
                <label for="ville">Ville</label>
                <input type="text" id="ville" name="ville"
                    class="input"
                    value="{{ old('ville') }}"
                    placeholder="Ville">
            </div>

            <div class="mb-6">
                <label for="description">Description</label>
                <textarea id="description" name="description"
                    class="textarea"
                    placeholder="Notes sur le fournisseur...">{{ old('description') }}</textarea>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit" class="btn w-full sm:w-auto">Créer le fournisseur</button>
                <a href="{{ route('fournisseurs.index') }}" class="btn btn-outlined w-full sm:w-auto text-center">Annuler</a>
            </div>

        </form>

    </div>

</x-layout.admin>