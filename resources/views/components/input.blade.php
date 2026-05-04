@props([
    'label' => null,
    'name' => null,
    'type' => 'text',
    'hint' => null,
])

@php
    $fieldId = $attributes->get('id') ?? $name;
    $hasError = $name ? $errors->has($name) : false;
@endphp

<div class="grid gap-1.5">
    @if($label)
        <label @if($fieldId) for="{{ $fieldId }}" @endif class="text-sm font-semibold text-slate-700">
            {{ $label }}
        </label>
    @endif

    <input
        @if($fieldId) id="{{ $fieldId }}" @endif
        @if($name) name="{{ $name }}" @endif
        type="{{ $type }}"
        {{ $attributes->merge([
            'class' =>
                'w-full rounded-xl border bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 outline-none transition '.
                ($hasError
                    ? 'border-rose-400 focus:border-rose-400 focus:ring-2 focus:ring-rose-200'
                    : 'border-slate-300 focus:border-slate-400 focus:ring-2 focus:ring-slate-200'
                )
        ]) }}
    />

    @if($hint)
        <div class="text-xs text-slate-500">{{ $hint }}</div>
    @endif

    @if($name)
        @error($name)
            <div class="text-sm text-rose-600">{{ $message }}</div>
        @enderror
    @endif
</div>

