<aside class="w-64 h-full bg-card border-r border-border flex flex-col">

    <div class="h-14 flex items-center justify-between px-6 border-b border-border">
        <h1 class="text-xl font-bold text-primary">PharmaSys</h1>
        <button @click="open = false" class="md:hidden text-muted-foreground hover:text-foreground">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="flex-1 p-4 space-y-1 overflow-y-auto">

        <a href="{{ route('dashboard') }}"
            class="block px-4 py-3 rounded-lg transition-colors text-sm
            {{ request()->is('dashboard') ? 'bg-primary text-primary-foreground font-medium' : 'hover:bg-border text-foreground' }}">
            Dashboard
        </a>

        <a href="{{ route('produits.index') }}"
            class="block px-4 py-3 rounded-lg transition-colors text-sm
            {{ request()->is('produits*') ? 'bg-primary text-primary-foreground font-medium' : 'hover:bg-border text-foreground' }}">
            Produits
        </a>

        <a href="{{ route('lots.index') }}"
            class="block px-4 py-3 rounded-lg transition-colors text-sm
            {{ request()->is('lots*') ? 'bg-primary text-primary-foreground font-medium' : 'hover:bg-border text-foreground' }}">
            Lots & Stock
        </a>

        <a href="{{ route('ventes.index') }}"
            class="block px-4 py-3 rounded-lg transition-colors text-sm
            {{ request()->is('ventes*') ? 'bg-primary text-primary-foreground font-medium' : 'hover:bg-border text-foreground' }}">
            Ventes
        </a>

        <a href="{{ route('approvisionnements.index') }}"
            class="block px-4 py-3 rounded-lg transition-colors text-sm
            {{ request()->is('approvisionnements*') ? 'bg-primary text-primary-foreground font-medium' : 'hover:bg-border text-foreground' }}">
            Approvisionnements
        </a>

        <a href="{{ route('clients.index') }}"
            class="block px-4 py-3 rounded-lg transition-colors text-sm
            {{ request()->is('clients*') ? 'bg-primary text-primary-foreground font-medium' : 'hover:bg-border text-foreground' }}">
            Clients
        </a>

        <a href="{{ route('fournisseurs.index') }}"
            class="block px-4 py-3 rounded-lg transition-colors text-sm
            {{ request()->is('fournisseurs*') ? 'bg-primary text-primary-foreground font-medium' : 'hover:bg-border text-foreground' }}">
            Fournisseurs
        </a>

        <a href="{{ route('categories.index') }}"
            class="block px-4 py-3 rounded-lg transition-colors text-sm
            {{ request()->is('categories*') ? 'bg-primary text-primary-foreground font-medium' : 'hover:bg-border text-foreground' }}">
            Catégories
        </a>

        <a href="{{ route('mouvements.index') }}"
            class="block px-4 py-3 rounded-lg transition-colors text-sm
            {{ request()->is('mouvements*') ? 'bg-primary text-primary-foreground font-medium' : 'hover:bg-border text-foreground' }}">
            Mouvements stock
        </a>

    </nav>

    <div class="p-4 border-t border-border">
        <div class="flex items-center gap-2">
            <span class="relative flex h-2 w-2 shrink-0">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
            </span>
            @if (auth()->user()->role === 'super_admin')
                <div>
                    <div class="text-xs text-primary font-medium">Super Administrateur</div>
                    <div class="text-xs text-muted-foreground">{{ auth()->user()->name }}</div>
                </div>
            @else
                <div class="text-xs text-muted-foreground">{{ auth()->user()->name }}</div>
            @endif
        </div>
    </div>

</aside>
