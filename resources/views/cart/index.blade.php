@extends('layouts.app')

@section('content')
    <x-page-header
        title="Your cart"
        subtitle="Review items before checkout."
    >
        <x-button href="/checkout" variant="secondary">Checkout</x-button>
    </x-page-header>

    @if(!$cart || $cart->items->isEmpty())
        <x-empty-state
            title="Your cart is empty"
            message="Browse products and add something you like."
        >
            <x-button href="/products">Browse products</x-button>
        </x-empty-state>
    @else
        <div class="grid gap-4 lg:grid-cols-5 lg:items-start">
            <div class="lg:col-span-3">
                <div class="grid gap-3">
                    @foreach($cart->items as $item)
                        <x-card class="p-4">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div class="min-w-0">
                                    <div class="truncate text-base font-extrabold text-slate-900">
                                        {{ $item->product?->name ?? 'Product' }}
                                    </div>
                                    <div class="mt-1 text-sm text-slate-500">
                                        Unit price:
                                        <span class="font-semibold text-slate-900">
                                            ${{ number_format($item->price_cents_snapshot / 100, 2) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex flex-wrap items-end gap-2">
                                    <form method="POST" action="/cart/items/{{ $item->id }}" class="flex flex-wrap items-end gap-2">
                                        @csrf
                                        @method('PATCH')

                                        <div class="w-28">
                                            <x-input
                                                id="qty_{{ $item->id }}"
                                                name="quantity"
                                                type="number"
                                                min="1"
                                                value="{{ $item->quantity }}"
                                                label="Qty"
                                            />
                                        </div>

                                        <x-button type="submit" variant="secondary">Update</x-button>
                                    </form>

                                    <form method="POST" action="/cart/items/{{ $item->id }}" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="submit" variant="secondary">Remove</x-button>
                                    </form>
                                </div>
                            </div>
                        </x-card>
                    @endforeach
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="lg:sticky lg:top-24">
                    <x-card class="space-y-4">
                        <div class="text-lg font-extrabold tracking-tight text-slate-900">Order summary</div>

                        <div class="space-y-2 text-sm">
                            @foreach($cart->items as $item)
                                <div class="flex items-center justify-between gap-3 text-slate-600">
                                    <div class="min-w-0 truncate">
                                        {{ $item->product?->name ?? 'Product' }} × {{ $item->quantity }}
                                    </div>
                                    <div class="shrink-0 font-semibold text-slate-900">
                                        ${{ number_format(($item->price_cents_snapshot * $item->quantity) / 100, 2) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-slate-200 pt-4">
                            <div class="flex items-center justify-between text-sm text-slate-600">
                                <div>Subtotal</div>
                                <div class="font-semibold text-slate-900">
                                    ${{ number_format($cart->subtotalCents() / 100, 2) }}
                                </div>
                            </div>
                            <div class="mt-2 flex items-center justify-between text-sm text-slate-600">
                                <div>Shipping</div>
                                <div class="font-semibold text-slate-900">$0.00</div>
                            </div>
                            <div class="mt-3 flex items-center justify-between text-base font-extrabold text-slate-900">
                                <div>Total</div>
                                <div>${{ number_format($cart->subtotalCents() / 100, 2) }}</div>
                            </div>
                        </div>

                        <x-button href="/checkout" class="w-full">
                            Continue to checkout
                        </x-button>
                        <x-button href="/products" variant="secondary" class="w-full">
                            Continue shopping
                        </x-button>
                    </x-card>
                </div>
            </div>
        </div>
    @endif
@endsection

