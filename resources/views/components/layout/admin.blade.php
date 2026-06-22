<!DOCTYPE html>
<html>

<head>
    <title>{{ $title ?? 'Dashboard' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-background text-foreground">

    <div class="flex h-screen overflow-hidden">

        <x-sidebar-admin />

        <div class="flex-1 flex flex-col min-h-0">

            <x-navbar />

            <main class="flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </main>

        </div>

    </div>

</body>

</html>