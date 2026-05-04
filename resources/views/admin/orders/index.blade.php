@extends('layouts.app')

@section('content')
    <x-page-header
        title="Orders"
        subtitle="Manage order statuses."
    />

    <x-card class="p-0 overflow-hidden">
        @if($orders->isEmpty())
            <div class="p-5">
                <x-empty-state
                    title="No orders yet"
                    message="Once customers place orders, they’ll show up here."
                />
            </div>
        @else
            <div class="divide-y divide-slate-200/70">
                @foreach($orders as $order)
                    <a href="/admin/orders/{{ $order->id }}"
                       class="block p-5 transition hover:bg-slate-50">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div class="min-w-0">
                                <div class="truncate text-base font-extrabold text-slate-900">{{ $order->order_number }}</div>
                                <div class="mt-1 text-sm text-slate-600">
                                    Status: <span class="font-semibold text-slate-900">{{ $order->status }}</span>
                                    <span class="text-slate-400">·</span>
                                    Payment: <span class="font-semibold text-slate-900">{{ $order->payment_method }}</span>
                                </div>
                            </div>

                            <div class="text-base font-extrabold text-slate-900">
                                ${{ number_format($order->total_cents / 100, 2) }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="border-t border-slate-200/70 p-5">
                {{ $orders->links() }}
            </div>
        @endif
    </x-card>
@endsection

