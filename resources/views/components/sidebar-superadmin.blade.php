<aside class="w-64 h-full bg-card border-r border-border flex flex-col">

    <div class="h-14 flex items-center justify-between px-6 border-b border-border">
        <h1 class="text-xl font-bold text-primary">PharmaSys</h1>
        <button @click="open = false" class="md:hidden text-muted-foreground hover:text-foreground">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <nav class="flex-1 p-4 space-y-1 overflow-y-auto">

        <a href="{{ route('super.dashboard') }}"
            class="block px-4 py-3 rounded-lg transition-colors text-sm
            {{ request()->routeIs('super.dashboard') ? 'bg-primary text-primary-foreground font-medium' : 'hover:bg-border text-foreground' }}">
            Dashboard
        </a>

        <a href="{{ route('users.index') }}"
            class="block px-4 py-3 rounded-lg transition-colors text-sm
            {{ request()->routeIs('users.*') ? 'bg-primary text-primary-foreground font-medium' : 'hover:bg-border text-foreground' }}">
            Gestion utilisateurs
        </a>

    </nav>

    <div class="p-4 border-t border-border">
        <div class="flex items-center gap-2">
            <span class="relative flex h-2 w-2 shrink-0">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
            </span>
            <div class="text-xs text-muted-foreground">{{ auth()->user()->name }}</div>
        </div>
    </div>

</aside>