@props([
    'p' => 'p-5',
])

<div {{ $attributes->merge(['class' => "surface backdrop-blur {$p}"]) }}>
    {{ $slot }}
</div>

