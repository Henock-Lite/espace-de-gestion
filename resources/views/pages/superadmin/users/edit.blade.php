<x-layout.superadmin title="Modifier utilisateur">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('users.index') }}" class="text-muted-foreground hover:text-foreground transition text-sm">
            ← Retour
        </a>
        <h1 class="text-xl md:text-2xl font-bold">Modifier — {{ $user->name }}</h1>
    </div>

    <div class="bg-card border border-border rounded-lg p-4 md:p-6 max-w-xl mx-auto">

        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name">Nom</label>
                <input type="text" id="name" name="name"
                    class="input {{ $errors->has('name') ? 'border-red-500' : '' }}"
                    value="{{ old('name', $user->name) }}">
                @error('name') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                    class="input {{ $errors->has('email') ? 'border-red-500' : '' }}"
                    value="{{ old('email', $user->email) }}">
                @error('email') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="role">Rôle</label>
                <select id="role" name="role" class="input">
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="super_admin" {{ old('role', $user->role) === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                </select>
                @error('role') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="password">Nouveau mot de passe</label>
                <input type="password" id="password" name="password"
                    class="input {{ $errors->has('password') ? 'border-red-500' : '' }}"
                    placeholder="Laisser vide pour ne pas changer">
                @error('password') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="input"
                    placeholder="Répéter le nouveau mot de passe">
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit" class="btn w-full sm:w-auto">Enregistrer</button>
                <a href="{{ route('users.index') }}" class="btn btn-outlined w-full sm:w-auto text-center">Annuler</a>
            </div>

        </form>

    </div>

</x-layout.superadmin>