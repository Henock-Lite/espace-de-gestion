<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'Auth' }}</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-background text-foreground flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md">
        {{ $slot }}
    </div>

</body>
</html>