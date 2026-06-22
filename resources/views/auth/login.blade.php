<x-layout.auth title="Login">
    <x-form title="Connexion" description="Accédez à votre espace de gestion">
        <form action="/login" method="POST" class="mt-10 space-y-4">
            @csrf
            <x-form.field name="email" type="email" label="Adresse e-mail" placeholder="Entrer votre mail" />
            <x-form.field name="password" type="password" label="Mot de passe"
                placeholder="Entrer votre mot de passe" />
            <x-form.errors name="email" />
            <a href="{{ route('password.request') }}"
                class="block text-center text-sm text-muted-foreground hover:text-foreground transition mt-4">
                Mot de passe oublié ?
            </a>
            <button class="btn mt-4 flex items-center justify-center font-medium" type="submit">
                Connexion
            </button>
        </form>
    </x-form>
</x-layout.auth>
