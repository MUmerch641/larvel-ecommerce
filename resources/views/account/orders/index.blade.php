@extends('layouts.app')

@section('content')
    <x-page-header title="My orders" subtitle="Your order history." />

    @if($orders->isEmpty())
        <x-card>No orders yet.</x-card>
    @else
        <div class="grid gap-3">
            @foreach($orders as $order)
                <a class="surface surface-hover p-4 rounded-xl border border-slate-200/70 flex flex-wrap items-center justify-between gap-3" href="/account/orders/{{ $order->order_number }}">
                    <div>
                        <div class="font-semibold text-slate-900">{{ $order->order_number }}</div>
                        <div class="text-sm text-slate-600">Placed: {{ optional($order->placed_at)->format('Y-m-d H:i') }}</div>
                        <div class="text-xs text-slate-500">Status: {{ $order->status }}</div>
                    </div>
                    <div class="font-semibold text-slate-900">${{ number_format($order->total_cents / 100, 2) }}</div>
                </a>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @endif
@endsection

