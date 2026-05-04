@extends('layouts.app')

@section('content')
    <div class="surface p-8 sm:p-10 mb-12">
        <div class="grid gap-8 lg:grid-cols-12 lg:items-center">
            <div class="lg:col-span-7">
                <div class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white/80 px-4 py-2 text-xs font-semibold text-slate-600 mb-6">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    Cash on delivery · secure checkout
                </div>
                <h1 class="text-4xl font-black tracking-tight text-slate-900 mb-4 leading-tight sm:text-5xl">
                    Modern Storefront for Your Shop
                </h1>
                <p class="text-lg leading-relaxed text-slate-600 mb-8 max-w-2xl">
                    Browse products, add to cart, and place orders with a clean, responsive experience built with Laravel and Tailwind CSS.
                </p>
                <div class="flex flex-wrap gap-3">
                    <x-button href="/products">Browse products</x-button>
                    <x-button href="/cart" variant="secondary">View cart</x-button>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl border border-slate-200 bg-white/80 p-6 transition hover:border-slate-300">
                        <div class="text-sm font-semibold text-slate-500">Checkout</div>
                        <div class="mt-2 text-xl font-extrabold text-slate-900">COD ready</div>
                        <div class="mt-2 text-sm text-slate-500">Minimal friction and clear totals.</div>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white/80 p-6 transition hover:border-slate-300">
                        <div class="text-sm font-semibold text-slate-500">Catalog</div>
                        <div class="mt-2 text-xl font-extrabold text-slate-900">Search and filter</div>
                        <div class="mt-2 text-sm text-slate-500">Fast browsing with pagination.</div>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white/80 p-6 transition hover:border-slate-300 sm:col-span-2">
                        <div class="text-sm font-semibold text-slate-500">Admin Panel</div>
                        <div class="mt-2 text-xl font-extrabold text-slate-900">Full management</div>
                        <div class="mt-2 text-sm text-slate-500">Manage products, orders, customers, and admins with DataTables.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-page-header
        title="Featured products"
        subtitle="Handpicked products available now"
    >
        <x-button href="/products" variant="secondary">View all</x-button>
    </x-page-header>

    @if($featured->isEmpty())
        <x-empty-state
            title="No products yet"
            message="Create one from the Admin area or seed the database."
        >
            <x-button href="/admin" variant="secondary">Go to admin</x-button>
            <x-button href="/products">Browse products</x-button>
        </x-empty-state>
    @else
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($featured as $product)
                <a href="/products/{{ $product->slug }}"
                   class="group relative overflow-hidden rounded-2xl border border-slate-200/70 bg-white/80 p-4 transition-all duration-300 hover:border-slate-300 hover:shadow-lg hover:shadow-slate-200/60">
                    <div class="absolute inset-0 -z-10 bg-slate-50 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                    
                    <div class="mt-4 flex items-start justify-between gap-3">
                        <div class="min-w-0 flex-1">
                            <h3 class="truncate text-base font-semibold tracking-tight text-slate-900 group-hover:text-slate-700 transition">
                                {{ $product->name }}
                            </h3>
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
                        <span class="{{ $badgeClass }} inline-flex items-center rounded-full border px-3 py-1 text-xs font-bold whitespace-nowrap">
                            {{ $badge }}
                        </span>
                    </div>

                    <div class="mt-4 rounded-lg border border-slate-200 bg-slate-50 p-3 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Stock</span>
                            <span class="font-bold text-slate-900">{{ $product->stock }}</span>
                        </div>
                    </div>

                    <div class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-slate-600 group-hover:text-slate-900 transition">
                        View details <span class="transition-transform duration-300 group-hover:translate-x-1">→</span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
@endsection

