<x-layout.superadmin title="Nouvel utilisateur">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('users.index') }}" class="text-muted-foreground hover:text-foreground transition">
            ← Retour
        </a>
        <h1 class="text-2xl font-bold">Nouvel utilisateur</h1>
    </div>

    <div class="bg-card border border-border rounded-lg p-6 max-w-xl mx-auto">

        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="mb-4">
                <label for="name">Nom</label>
                <input type="text" id="name" name="name"
                    class="input {{ $errors->has('name') ? 'border-red-500' : '' }}"
                    value="{{ old('name') }}"
                    placeholder="Nom complet">
                @error('name') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                    class="input {{ $errors->has('email') ? 'border-red-500' : '' }}"
                    value="{{ old('email') }}"
                    placeholder="email@exemple.com">
                @error('email') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="role">Rôle</label>
                <select id="role" name="role"
                    class="input {{ $errors->has('role') ? 'border-red-500' : '' }}">
                    <option value="">— Sélectionner un rôle —</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                </select>
                @error('role') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password"
                    class="input {{ $errors->has('password') ? 'border-red-500' : '' }}"
                    placeholder="Minimum 8 caractères">
                @error('password') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="input"
                    placeholder="Répéter le mot de passe">
            </div>

            <div class="flex gap-3">
                <button type="submit" class="btn">Créer l'utilisateur</button>
                <a href="{{ route('users.index') }}" class="btn btn-outlined">Annuler</a>
            </div>

        </form>

    </div>

</x-layout.superadmin>