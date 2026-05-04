@props([
    'title' => 'Nothing here yet',
    'message' => null,
])

<x-card class="text-center">
    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-600">
        <span class="text-xl font-black">—</span>
    </div>
    <div class="mt-4 text-base font-bold text-slate-900">{{ $title }}</div>
    @if($message)
        <div class="mt-1 text-sm text-slate-500">{{ $message }}</div>
    @endif

    @if(trim($slot) !== '')
        <div class="mt-4 flex justify-center gap-2">
            {{ $slot }}
        </div>
    @endif
</x-card>

