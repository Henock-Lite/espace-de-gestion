<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-background text-foreground">

    <div x-data="{ open: false }" class="flex h-screen overflow-hidden">

        {{-- Overlay mobile --}}
        <div x-show="open"
            x-transition.opacity
            @click="open = false"
            class="fixed inset-0 bg-black/50 z-30 md:hidden">
        </div>

        {{-- Sidebar --}}
        <div :class="open ? 'translate-x-0' : '-translate-x-full'"
            class="fixed md:relative md:translate-x-0 z-40 h-full transition-transform duration-200 ease-in-out md:flex md:flex-shrink-0">
            <x-sidebar-admin />
        </div>

        <div class="flex-1 flex flex-col min-h-0 w-0">

            <x-navbar />

            <main class="flex-1 overflow-y-auto p-4 md:p-6">
                {{ $slot }}
            </main>

        </div>

    </div>

</body>

</html>