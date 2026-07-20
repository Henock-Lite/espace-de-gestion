<x-layout.auth title="Réinitialiser le mot de passe">
    <x-form title="Nouveau mot de passe" description="Choisissez un nouveau mot de passe">

        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <x-form.field name="email" type="email" label="Adresse e-mail" placeholder="Entrer votre mail" />

            <x-form.field name="password" type="password" label="Nouveau mot de passe"
                placeholder="Minimum 8 caractères" />


            <x-form.field name="password_confirmation" type="password" label="Confirmer le mot de passe"
                placeholder="Répéter le mot de passe" />

            <x-form.errors name="email" />
            <x-form.errors name="password" />

            <button class="btn w-full flex items-center justify-center" type="submit">
                Réinitialiser le mot de passe
            </button>

            <a href="{{ route('login') }}"
                class="block text-center text-sm text-muted-foreground hover:text-foreground transition">
                ← Retour à la connexion
            </a>

        </form>

    </x-form>
</x-layout.auth>
