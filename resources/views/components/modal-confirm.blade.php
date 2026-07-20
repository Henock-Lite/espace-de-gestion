@props([
    'id',
    'action',
    'title' => 'Confirmation',
    'message' => 'Êtes-vous sûr de vouloir effectuer cette action ?',
    'buttonText' => 'Désactiver',
    'buttonClass' =>
        'text-xs px-2 md:px-3 py-1 bg-red-500/10 text-red-400 border border-red-500/20 rounded hover:bg-red-500/20 transition',
    'confirmText' => 'Confirmer',
    'method' => 'DELETE',
])

<div x-data="{ open: false }" class="inline-block">
    <!-- Bouton déclencheur -->
    <button @click="open = true" type="button" class="{{ $buttonClass }}">
        {{ $buttonText }}
    </button>

    <!-- Portail pour téléporter le modal en fin de DOM (évite les bugs de z-index dans les tableaux) -->
    <template x-teleport="body">
        <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" x-cloak>


            <div @click.outside="open = false" @keydown.escape.window="open = false"
                class="bg-card border border-border p-6 rounded-xl max-w-sm w-full shadow-2xl relative">

                <h3 class="text-base font-bold text-foreground mb-2">{{ $title }}</h3>
                <p class="text-sm text-muted-foreground mb-6">{{ $message }}</p>


                <div class="flex justify-end gap-2 text-sm">
                    <button @click="open = false" type="button"
                        class="px-4 py-2 font-medium bg-border/40 hover:bg-border/75 rounded-lg transition text-foreground">
                        Annuler
                    </button>

                    <form method="POST" action="{{ $action }}" class="inline">
                        @csrf
                        @method($method)
                        <button type="submit"
                            class="px-4 py-2 font-medium bg-red-500/20 text-red-400 border border-red-500/30 hover:bg-red-500/30 rounded-lg transition">
                            {{ $confirmText }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </template>
</div>
