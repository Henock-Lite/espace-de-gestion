<x-layout.auth title="Mot de passe oublié">
    <x-form title="Mot de passe oublié" description="Entrez votre email pour recevoir un lien de réinitialisation">

        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
            @csrf

            <x-form.field
                name="email"
                type="email"
                label="Adresse e-mail"
                placeholder="Entrer votre mail" />
            <x-form.errors  name="email"/>

            <button class="btn w-full flex items-center justify-center" type="submit">
                Envoyer le lien
            </button>

            <a href="{{ route('login') }}"
                class="block text-center text-sm text-muted-foreground hover:text-foreground transition">
                ← Retour à la connexion
            </a>

        </form>

    </x-form>
</x-layout.auth>