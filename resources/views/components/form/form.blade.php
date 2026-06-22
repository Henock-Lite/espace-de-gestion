@props(['title', 'description'])

<div class="flex min-h-[calc(100dvh-4rem)] items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="text-center">
            <h1 class="tracking-tight text-3xl font-bold text-foreground">{{ $title }}</h1>
            <p class="text-muted-foreground mt-1">{{ $description }}</p>
        </div>
        {{ $slot }}
    </div>
</div>  