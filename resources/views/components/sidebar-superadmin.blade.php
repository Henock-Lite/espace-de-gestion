<aside class="w-64 bg-card border-r border-border flex flex-col">

    <!-- Logo -->
    <div class="h-16 flex items-center px-6 border-b border-border">
        <h1 class="text-xl font-bold text-primary">
            PharmaSys
        </h1>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-2">

        <a href="{{ route('super.dashboard') }}"
            class="block px-4 py-3 rounded-lg transition-colors
            {{ request()->routeIs('super.dashboard') ? 'bg-primary text-primary-foreground font-medium' : 'hover:bg-border text-foreground' }}">
            Dashboard
        </a>

        <a href="{{ route('users.index') }}"
            class="block px-4 py-3 rounded-lg transition-colors
            {{ request()->routeIs('users.*') ? 'bg-primary text-primary-foreground font-medium' : 'hover:bg-border text-foreground' }}">
            Gestion utilisateurs
        </a>

    </nav>


 <!-- Footer -->
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
