<aside class="w-64 bg-card border-r border-border flex flex-col">

    <div class="h-16 flex items-center px-6 border-b border-border">
        <h1 class="text-xl font-bold text-primary">PharmaSys</h1>
    </div>

    <nav class="flex-1 p-4 space-y-2">

        <a href="{{ route('dashboard') }}"
            class="block px-4 py-3 rounded-lg transition-colors
            {{ request()->is('dashboard') ? 'bg-primary text-primary-foreground font-medium' : 'hover:bg-border text-foreground' }}">
            Dashboard
        </a>

        <a href="{{ route('produits.index') }}"
            class="block px-4 py-3 rounded-lg transition-colors
            {{ request()->is('produits*') ? 'bg-primary text-primary-foreground font-medium' : 'hover:bg-border text-foreground' }}">
            Produits
        </a>

        <a href="{{ route('lots.index') }}"
            class="block px-4 py-3 rounded-lg transition-colors
            {{ request()->is('lots*') ? 'bg-primary text-primary-foreground font-medium' : 'hover:bg-border text-foreground' }}">
            Lots & Stock
        </a>

        <a href="{{ route('ventes.index') }}"
            class="block px-4 py-3 rounded-lg transition-colors
            {{ request()->is('ventes*') ? 'bg-primary text-primary-foreground font-medium' : 'hover:bg-border text-foreground' }}">
            Ventes
        </a>

        <a href="{{ route('approvisionnements.index') }}"
            class="block px-4 py-3 rounded-lg transition-colors
            {{ request()->is('approvisionnements*') ? 'bg-primary text-primary-foreground font-medium' : 'hover:bg-border text-foreground' }}">
            Approvisionnements
        </a>

        <a href="{{ route('clients.index') }}"
            class="block px-4 py-3 rounded-lg transition-colors
            {{ request()->is('clients*') ? 'bg-primary text-primary-foreground font-medium' : 'hover:bg-border text-foreground' }}">
            Clients
        </a>

        <a href="{{ route('fournisseurs.index') }}"
            class="block px-4 py-3 rounded-lg transition-colors
            {{ request()->is('fournisseurs*') ? 'bg-primary text-primary-foreground font-medium' : 'hover:bg-border text-foreground' }}">
            Fournisseurs
        </a>

        <a href="{{ route('categories.index') }}"
            class="block px-4 py-3 rounded-lg transition-colors
            {{ request()->is('categories*') ? 'bg-primary text-primary-foreground font-medium' : 'hover:bg-border text-foreground' }}">
            Catégories
        </a>

        <a href="{{ route('mouvements.index') }}"
            class="block px-4 py-3 rounded-lg transition-colors
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
            <div class="flex items-center">
                <div class="text-xs text-muted-foreground">{{ auth()->user()->name }}</div>
            </div>
        </div>
    </div>

</aside>
