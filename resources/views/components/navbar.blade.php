<nav class="h-14 flex items-center justify-between px-6 border-b border-border bg-card">

    <div class="text-sm text-muted-foreground">
        Dashboard
    </div>

    <div class="flex items-center gap-4">

        @if(auth()->user()->role === 'super_admin')
            <a href="{{ route('dashboard') }}"
                class="text-sm px-3 py-1 bg-card border border-border rounded hover:bg-border transition">
                Basculer vers Admin
            </a>
        @endif

        <form method="POST" action="/logout">
            @csrf
            <button class="text-sm text-muted-foreground hover:text-foreground transition">
                Logout
            </button>
        </form>

    </div>

</nav>