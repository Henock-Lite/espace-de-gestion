<nav class="h-14 flex items-center justify-between px-4 md:px-6 border-b border-border bg-card">

    <div class="flex items-center gap-3">
        {{-- Hamburger mobile --}}
        <button @click="open = !open"
            class="md:hidden text-muted-foreground hover:text-foreground transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <div class="text-sm text-muted-foreground hidden md:block">Dashboard</div>
    </div>

    <div class="flex items-center gap-3">

        @if(auth()->user()->role === 'super_admin')
            @if(request()->routeIs('super.*') || request()->routeIs('users.*'))
                <a href="{{ route('dashboard') }}"
                    class="text-xs md:text-sm px-2 md:px-3 py-1 bg-card border border-border rounded hover:bg-border transition">
                    Basculer vers Admin
                </a>
            @else
                <a href="{{ route('super.dashboard') }}"
                    class="text-xs md:text-sm px-2 md:px-3 py-1 bg-card border border-border rounded hover:bg-border transition">
                    Basculer vers Super Admin
                </a>
            @endif
        @endif

        <form method="POST" action="/logout">
            @csrf
            <button class="text-sm text-muted-foreground hover:text-foreground transition">
                Logout
            </button>
        </form>

    </div>

</nav>