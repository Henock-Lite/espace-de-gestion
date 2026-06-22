@props(['name', 'label', 'type' => 'text'])

<div class="space-y-1">
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge(['class' => 'input']) }} value="{{ old($name) }}"  />
</div>

