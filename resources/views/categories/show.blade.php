@extends('layouts.app')

@section('content')
    <x-page-header title="{{ $category->name }}" subtitle="Products in this category.">
        <x-button href="/products" variant="secondary" size="sm">All products</x-button>
    </x-page-header>

    @if($products->isEmpty())
        <x-card>No products in this category yet.</x-card>
    @else
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($products as $product)
                <a class="surface surface-hover p-4 rounded-xl border border-slate-200/70" href="/products/{{ $product->slug }}">
                    <div class="font-semibold text-slate-900 mb-1 truncate">{{ $product->name }}</div>
                    <div class="text-sm text-slate-600 mb-2">{{ $product->price_formatted }}</div>
                    <div class="text-xs text-slate-500">Stock: {{ $product->stock }}</div>
                </a>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @endif
@endsection

