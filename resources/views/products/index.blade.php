@extends('layouts.app')

@section('content')
    <x-page-header
        title="Products"
        subtitle="Search and browse all products."
    />

    <x-card class="mb-4">
        <form method="GET" action="/products" class="grid gap-3 sm:grid-cols-3 sm:items-end">
            <div class="sm:col-span-2">
                <x-input
                    id="q"
                    name="q"
                    label="Search"
                    value="{{ $q }}"
                    placeholder="Name, SKU, description..."
                />
            </div>

            <div class="grid gap-1.5">
                <label for="category" class="text-sm font-semibold text-slate-700">Category</label>
                <select id="category"
                        name="category"
                    class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                    <option value="">All</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->slug }}" {{ ($category ?? '') === $c->slug ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-wrap gap-2 sm:col-span-3">
                <x-button type="submit">Search</x-button>
                <x-button href="/products" variant="secondary">Reset</x-button>
            </div>
        </form>
    </x-card>

    @if($products->isEmpty())
        <x-empty-state
            title="No matching products"
            message="Try a different search or clear filters."
        >
            <x-button href="/products" variant="secondary">Clear filters</x-button>
        </x-empty-state>
    @else
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($products as $product)
                <a href="/products/{{ $product->slug }}"
                   class="group rounded-2xl border border-slate-200/70 bg-white/80 p-5 transition hover:-translate-y-0.5 hover:border-slate-300 hover:bg-white">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <div class="truncate text-base font-extrabold tracking-tight text-slate-900">
                                {{ $product->name }}
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-700">
                                {{ $product->price_formatted }}
                            </div>
                        </div>

                        @php
                            $badge = $product->stock <= 0 ? 'Out' : ($product->stock <= 3 ? 'Low' : 'In');
                            $badgeClass = $product->stock <= 0
                                ? 'border-rose-200 bg-rose-50 text-rose-600'
                                : ($product->stock <= 3 ? 'border-amber-200 bg-amber-50 text-amber-700' : 'border-emerald-200 bg-emerald-50 text-emerald-700');
                        @endphp
                        <span class="{{ $badgeClass }} inline-flex items-center rounded-full border px-2.5 py-1 text-xs font-bold">
                            {{ $badge }}
                        </span>
                    </div>

                    <div class="mt-4 rounded-xl bg-slate-50 p-4 text-sm text-slate-600">
                        <div class="flex items-center justify-between">
                            <span>Stock</span>
                            <span class="font-semibold text-slate-900">{{ $product->stock }}</span>
                        </div>
                    </div>

                    <div class="mt-4 text-sm font-semibold text-slate-700 group-hover:text-slate-900">
                        View details →
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    @endif
@endsection

