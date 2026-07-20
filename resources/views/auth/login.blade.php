<x-layout.auth title="Login">
    <x-form title="Connexion" description="Accédez à votre espace de gestion">
        <form action="/login" method="POST" class="space-y-4">
            @csrf
            <x-form.field
                name="email"
                type="email"
                label="Adresse e-mail"
                placeholder="Entrer votre mail" />
            <x-form.field
                name="password"
                type="password"
                label="Mot de passe"
                placeholder="Entrer votre mot de passe" />
            <x-form.errors name="email" />
            <a href="{{ route('password.request') }}"
                class="block text-center text-sm text-muted-foreground hover:text-foreground transition">
                Mot de passe oublié ?
            </a>
            <button class="btn w-full flex items-center justify-center font-medium" type="submit">
                Connexion
            </button>
        </form>
    </x-form>
</x-layout.auth>