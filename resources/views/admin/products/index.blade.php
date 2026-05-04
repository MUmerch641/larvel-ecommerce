@extends('layouts.app')

@section('content')
    <x-page-header
        title="Products"
        subtitle="Manage products, pricing, and stock."
    >
        <x-button href="/admin/products/create">New product</x-button>
    </x-page-header>

    <x-card class="p-0 overflow-hidden">
        @if($products->isEmpty())
            <div class="p-5">
                <x-empty-state
                    title="No products yet"
                    message="Create a product to start selling."
                >
                    <x-button href="/admin/products/create">New product</x-button>
                </x-empty-state>
            </div>
        @else
            <div class="divide-y divide-slate-200/70">
                @foreach($products as $product)
                    <div class="flex flex-col gap-3 p-5 sm:flex-row sm:items-center sm:justify-between">
                        <div class="min-w-0">
                            <div class="truncate text-base font-extrabold text-slate-900">
                                {{ $product->name }}
                                @if(!$product->is_active)
                                    <span class="ml-2 text-sm font-semibold text-slate-500">(inactive)</span>
                                @endif
                            </div>
                            <div class="mt-1 text-sm text-slate-600">
                                <span class="font-semibold text-slate-900">{{ $product->price_formatted }}</span>
                                <span class="text-slate-400">·</span>
                                Stock: <span class="font-semibold text-slate-900">{{ $product->stock }}</span>
                                <span class="text-slate-400">·</span>
                                Category: <span class="font-semibold text-slate-900">{{ $product->category?->name ?? '—' }}</span>
                                <span class="text-slate-400">·</span>
                                Slug: <span class="font-semibold text-slate-900">{{ $product->slug }}</span>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-2">
                            <x-button href="/admin/products/{{ $product->id }}/edit" variant="secondary">Edit</x-button>
                            <form method="POST" action="/admin/products/{{ $product->id }}" class="m-0">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="secondary">Delete</x-button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="border-t border-slate-200/70 p-5">
                {{ $products->links() }}
            </div>
        @endif
    </x-card>
@endsection

