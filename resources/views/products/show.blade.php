@extends('layouts.app')

@section('content')
    <div class="grid gap-6 lg:grid-cols-5">
        <div class="lg:col-span-3">
            <x-card>
                <div class="flex flex-col gap-5">
                    <div>
                        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">
                            {{ $product->name }}
                        </h1>
                        <div class="mt-2 text-lg font-bold text-slate-700">
                            {{ $product->price_formatted }}
                        </div>

                        @if($product->description)
                            <p class="mt-4 whitespace-pre-line text-sm leading-6 text-slate-600">
                                {{ $product->description }}
                            </p>
                        @else
                            <p class="mt-4 text-sm text-slate-500">
                                No description provided.
                            </p>
                        @endif
                    </div>
                </div>
            </x-card>
        </div>

        <div class="lg:col-span-2">
            <div class="lg:sticky lg:top-24">
                <x-card class="space-y-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <div class="text-sm font-semibold text-slate-500">Stock</div>
                            <div class="mt-1 text-2xl font-extrabold text-slate-900">{{ $product->stock }}</div>
                        </div>

                        @php
                            $badge = $product->stock <= 0 ? 'Out of stock' : ($product->stock <= 3 ? 'Low stock' : 'In stock');
                            $badgeClass = $product->stock <= 0
                                ? 'border-rose-200 bg-rose-50 text-rose-600'
                                : ($product->stock <= 3 ? 'border-amber-200 bg-amber-50 text-amber-700' : 'border-emerald-200 bg-emerald-50 text-emerald-700');
                        @endphp

                        <span class="{{ $badgeClass }} inline-flex items-center rounded-full border px-2.5 py-1 text-xs font-bold">
                            {{ $badge }}
                        </span>
                    </div>

                    <form method="POST" action="/cart/items" class="grid gap-3">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}" />

                        <x-input
                            id="quantity"
                            name="quantity"
                            type="number"
                            min="1"
                            value="1"
                            required
                            label="Quantity"
                        />

                        <div class="grid gap-2">
                            <x-button type="submit" class="w-full" :disabled="$product->stock <= 0">
                                Add to cart
                            </x-button>
                            <x-button href="/cart" variant="secondary" class="w-full">Go to cart</x-button>
                        </div>
                    </form>
                </x-card>
            </div>
        </div>
    </div>
@endsection

