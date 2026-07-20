<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Auth' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-background text-foreground min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md mx-auto">
        {{ $slot }}
    </div>

</body>

</html>
