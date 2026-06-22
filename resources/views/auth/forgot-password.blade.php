<x-layout.auth title="Mot de passe oublié">
    <x-form title="Mot de passe oublié" description="Entrez votre email pour recevoir un lien de réinitialisation">

        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mt-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="mt-10 space-y-4">
            @csrf
            <x-form.field name="email" type="email" label="Adresse e-mail" placeholder="Entrer votre mail" />
            @error('email') <p class="error">{{ $message }}</p> @enderror

            <button class="btn mt-4 w-full" type="submit">
                Envoyer le lien
            </button>

            <a href="{{ route('login') }}" class="block text-center text-sm text-muted-foreground hover:text-foreground transition mt-2">
                ← Retour à la connexion
            </a>
        </form>

    </x-form>
</x-layout.auth>