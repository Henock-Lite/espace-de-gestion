<x-layout.admin title="Nouveau client">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('clients.index') }}" class="text-muted-foreground hover:text-foreground transition">
            ← Retour
        </a>
        <h1 class="text-2xl font-bold">Nouveau client</h1>
    </div>

    <div class="bg-card border border-border rounded-lg p-6 max-w-xl mx-auto">

        <form method="POST" action="{{ route('clients.store') }}">
            @csrf

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom"
                        class="input {{ $errors->has('nom') ? 'border-red-500' : '' }}"
                        value="{{ old('nom') }}"
                        placeholder="Nom">
                    @error('nom') <p class="error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom"
                        class="input"
                        value="{{ old('prenom') }}"
                        placeholder="Prénom">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="telephone">Téléphone</label>
                    <input type="text" id="telephone" name="telephone"
                        class="input {{ $errors->has('telephone') ? 'border-red-500' : '' }}"
                        value="{{ old('telephone') }}"
                        placeholder="Ex: 0661234567">
                    @error('telephone') <p class="error">{{ $message }}</p> @enderror
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

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="ville">Ville</label>
                    <input type="text" id="ville" name="ville"
                        class="input"
                        value="{{ old('ville') }}"
                        placeholder="Ville">
                </div>
                <div>
                    <label for="date_naissance">Date de naissance</label>
                    <input type="date" id="date_naissance" name="date_naissance"
                        class="input"
                        value="{{ old('date_naissance') }}">
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn">Créer le client</button>
                <a href="{{ route('clients.index') }}" class="btn btn-outlined">Annuler</a>
            </div>

        </form>

    </div>

</x-layout.admin>