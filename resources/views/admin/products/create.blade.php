@extends('layouts.app')

@section('content')
    <x-page-header title="New product" subtitle="Create a product and set price/stock.">
        <x-button href="/admin/products" variant="secondary" size="sm">Back</x-button>
    </x-page-header>

    <x-card>
        <form method="POST" action="/admin/products" class="grid gap-4">
            @csrf

            <x-input label="Name" name="name" id="name" value="{{ old('name') }}" required />

            <x-input label="Slug (optional)" name="slug" id="slug" value="{{ old('slug') }}" placeholder="auto-generated if empty" />

            <div class="grid gap-1.5">
                <label for="category_id" class="text-sm font-semibold text-slate-700">Category (optional)</label>
                <select id="category_id" name="category_id" class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                    <option value="">None</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ (string)old('category_id')===(string)$c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <div class="text-sm text-rose-600">{{ $message }}</div> @enderror
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <x-input label="Price (e.g. 19.99)" name="price" id="price" value="{{ old('price', '0.00') }}" required />
                <x-input label="Stock" name="stock" id="stock" type="number" min="0" value="{{ old('stock', 0) }}" required />
            </div>

            <x-input label="SKU (optional)" name="sku" id="sku" value="{{ old('sku') }}" />

            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }} class="rounded border-slate-300 bg-white text-slate-700 focus:ring-slate-300" />
                Active
            </label>

            <div class="grid gap-1.5">
                <label for="description" class="text-sm font-semibold text-slate-700">Description (optional)</label>
                <textarea id="description" name="description" rows="5" class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-slate-400 focus:ring-2 focus:ring-slate-200">{{ old('description') }}</textarea>
                @error('description') <div class="text-sm text-rose-600">{{ $message }}</div> @enderror
            </div>

            <div class="flex justify-end">
                <x-button type="submit">Create</x-button>
            </div>
        </form>
    </x-card>
@endsection

