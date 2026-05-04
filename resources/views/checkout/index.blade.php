@extends('layouts.app')

@section('content')
    <x-page-header
        title="Checkout"
        subtitle="Payment method: Cash on delivery (COD)."
    >
        <x-button href="/cart" variant="secondary">Back to cart</x-button>
    </x-page-header>

    @if(!$cart || $cart->items->isEmpty())
        <x-empty-state
            title="Your cart is empty"
            message="Add products before checking out."
        >
            <x-button href="/products">Browse products</x-button>
        </x-empty-state>
    @else
        <div class="grid gap-4 lg:grid-cols-5 lg:items-start">
            <x-card class="lg:col-span-3">
                <div class="text-lg font-extrabold tracking-tight text-slate-900">Shipping details</div>
                <p class="mt-1 text-sm text-slate-500">We’ll ship to this address and you’ll pay on delivery.</p>

                <form method="POST" action="/checkout" class="mt-5 grid gap-4">
                    @csrf

                    <x-input
                        id="shipping_name"
                        name="shipping_name"
                        label="Full name"
                        value="{{ old('shipping_name') }}"
                        required
                    />

                    <x-input
                        id="shipping_phone"
                        name="shipping_phone"
                        label="Phone"
                        value="{{ old('shipping_phone') }}"
                        required
                    />

                    <x-input
                        id="shipping_line1"
                        name="shipping_line1"
                        label="Address line 1"
                        value="{{ old('shipping_line1') }}"
                        required
                    />

                    <x-input
                        id="shipping_line2"
                        name="shipping_line2"
                        label="Address line 2 (optional)"
                        value="{{ old('shipping_line2') }}"
                    />

                    <div class="grid gap-4 sm:grid-cols-2">
                        <x-input
                            id="shipping_city"
                            name="shipping_city"
                            label="City"
                            value="{{ old('shipping_city') }}"
                            required
                        />

                        <x-input
                            id="shipping_postal_code"
                            name="shipping_postal_code"
                            label="Postal code"
                            value="{{ old('shipping_postal_code') }}"
                        />
                    </div>

                    <x-input
                        id="shipping_country"
                        name="shipping_country"
                        label="Country (2-letter code)"
                        value="{{ old('shipping_country', 'US') }}"
                        required
                        hint="Example: US, PK, AE"
                    />

                    <div class="pt-2">
                        <x-button type="submit" class="w-full sm:w-auto">
                            Place order (COD)
                        </x-button>
                    </div>
                </form>
            </x-card>

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

                        <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                            Payment method: <span class="font-semibold text-slate-900">Cash on delivery</span>
                        </div>
                    </x-card>
                </div>
            </div>
        </div>
    @endif
@endsection

