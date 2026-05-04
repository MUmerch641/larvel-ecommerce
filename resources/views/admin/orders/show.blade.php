@extends('layouts.app')

@section('content')
    <x-page-header title="Order {{ $order->order_number }}" subtitle="Payment: {{ $order->payment_method }}">
        <x-button href="/admin/orders" variant="secondary" size="sm">Back</x-button>
    </x-page-header>

    <x-card class="mb-4">
        <form method="POST" action="/admin/orders/{{ $order->id }}" class="flex flex-wrap items-end gap-3">
            @csrf
            @method('PATCH')
            <div class="grid gap-1.5 min-w-[240px]">
                <label for="status" class="text-sm font-semibold text-slate-700">Status</label>
                <select id="status" name="status" class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                    @foreach(['pending','confirmed','shipped','delivered','cancelled'] as $s)
                        <option value="{{ $s }}" {{ old('status', $order->status)===$s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                @error('status') <div class="text-sm text-rose-600">{{ $message }}</div> @enderror
            </div>
            <x-button type="submit">Update status</x-button>
        </form>
    </x-card>

    <div class="grid gap-4 lg:grid-cols-2">
        <x-card>
            <h2 class="text-lg font-semibold text-slate-900 mb-3">Shipping</h2>
            <div class="text-slate-700"><strong>{{ $order->shipping_name }}</strong></div>
            <div class="text-slate-600">{{ $order->shipping_phone }}</div>
            <div class="text-slate-600">{{ $order->shipping_line1 }}</div>
            @if($order->shipping_line2)
                <div class="text-slate-600">{{ $order->shipping_line2 }}</div>
            @endif
            <div class="text-slate-600">{{ $order->shipping_city }} {{ $order->shipping_postal_code }}</div>
            <div class="text-slate-600">{{ $order->shipping_country }}</div>
        </x-card>

        <x-card>
            <h2 class="text-lg font-semibold text-slate-900 mb-3">Totals</h2>
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
        </x-card>
    </div>

    <x-card class="mt-4">
        <h2 class="text-lg font-semibold text-slate-900 mb-3">Items</h2>
        <div class="grid gap-2">
            @foreach($order->items as $item)
                <div class="flex items-center justify-between gap-3 text-slate-600">
                    <div>{{ $item->name_snapshot }} × {{ $item->quantity }}</div>
                    <div class="font-semibold text-slate-900">${{ number_format(($item->price_cents * $item->quantity) / 100, 2) }}</div>
                </div>
            @endforeach
        </div>
    </x-card>
@endsection

