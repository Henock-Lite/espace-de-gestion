<x-layout.admin title="Nouvelle catégorie">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('categories.index') }}" class="text-muted-foreground hover:text-foreground transition">
            ← Retour
        </a>
        <h1 class="text-2xl font-bold">Nouvelle catégorie</h1>
    </div>

    <div class="bg-card border border-border rounded-lg p-6 max-w-lg  mx-auto">

        <form method="POST" action="{{ route('categories.store') }}">
            @csrf

            <div class="mb-4">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom"
                    class="input {{ $errors->has('nom') ? 'border-red-500' : '' }}"
                    value="{{ old('nom') }}"
                    placeholder="Ex: Antibiotiques">
                @error('nom')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description">Description</label>
                <textarea id="description" name="description"
                    class="textarea"
                    placeholder="Description optionnelle...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="btn">Créer la catégorie</button>
                <a href="{{ route('categories.index') }}" class="btn btn-outlined">Annuler</a>
            </div>

        </form>

    </div>

</x-layout.admin>