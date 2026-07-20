@props(['title', 'description'])

<div class="w-full">
    <div class="text-center mb-8">
        <h1 class="tracking-tight text-2xl md:text-3xl font-bold text-foreground">{{ $title }}</h1>
        <p class="text-muted-foreground mt-1 text-sm md:text-base">{{ $description }}</p>
    </div>
    {{ $slot }}
</div>