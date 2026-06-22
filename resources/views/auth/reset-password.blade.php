<x-layout.auth title="Réinitialiser le mot de passe">
    <x-form title="Nouveau mot de passe" description="Choisissez un nouveau mot de passe">

        <form action="{{ route('password.update') }}" method="POST" class="mt-10 space-y-4">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <x-form.field name="email" type="email" label="Adresse e-mail" placeholder="Entrer votre mail" />
            @error('email') <p class="error">{{ $message }}</p> @enderror

            <x-form.field name="password" type="password" label="Nouveau mot de passe" placeholder="Minimum 8 caractères" />
            @error('password') <p class="error">{{ $message }}</p> @enderror

            <x-form.field name="password_confirmation" type="password" label="Confirmer le mot de passe" placeholder="Répéter le mot de passe" />

            <button class="btn mt-4 w-full" type="submit">
                Réinitialiser le mot de passe
            </button>

        </form>

    </x-form>
</x-layout.auth>