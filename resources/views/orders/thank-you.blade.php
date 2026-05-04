@extends('layouts.app')

@section('content')
    <x-card>
        <h1 class="text-2xl font-semibold text-slate-900 mb-2">Thank you!</h1>
        <p class="text-sm text-slate-600">Your order <strong>{{ $order->order_number }}</strong> has been placed (Cash on Delivery).</p>
    </x-card>

    <x-card class="mt-4">
        <h2 class="text-lg font-semibold text-slate-900 mb-3">Order summary</h2>

        <div class="grid gap-2 mb-4">
            @foreach($order->items as $item)
                <div class="flex items-center justify-between gap-3 text-slate-600">
                    <div>{{ $item->name_snapshot }} × {{ $item->quantity }}</div>
                    <div class="font-semibold text-slate-900">${{ number_format(($item->price_cents * $item->quantity) / 100, 2) }}</div>
                </div>
            @endforeach
        </div>

        <div class="flex items-center justify-between gap-3 text-slate-600">
            <div>Subtotal</div>
            <div>${{ number_format($order->subtotal_cents / 100, 2) }}</div>
        </div>
        <div class="mt-2 flex items-center justify-between gap-3 text-slate-600">
            <div>Shipping</div>
            <div>${{ number_format($order->shipping_cents / 100, 2) }}</div>
        </div>
        <div class="mt-3 flex items-center justify-between gap-3 font-semibold text-slate-900">
            <div>Total</div>
            <div>${{ number_format($order->total_cents / 100, 2) }}</div>
        </div>

        <div class="mt-4 text-sm text-slate-600">
            Status: <strong>{{ $order->status }}</strong>
        </div>
    </x-card>
@endsection

