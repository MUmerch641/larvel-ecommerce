@extends('layouts.app')

@section('content')
    <x-page-header title="Edit category" subtitle="Update category details.">
        <x-button href="/admin/categories" variant="secondary" size="sm">Back</x-button>
    </x-page-header>

    <x-card>
        <form method="POST" action="/admin/categories/{{ $category->id }}" class="grid gap-4">
            @csrf
            @method('PUT')

            <x-input label="Name" name="name" id="name" value="{{ old('name', $category->name) }}" required />

            <x-input label="Slug (optional)" name="slug" id="slug" value="{{ old('slug', $category->slug) }}" />

            <div class="grid gap-1.5">
                <label for="parent_id" class="text-sm font-semibold text-slate-700">Parent (optional)</label>
                <select id="parent_id" name="parent_id" class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                    <option value="">None</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ (string)old('parent_id', $category->parent_id)===(string)$c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
                @error('parent_id') <div class="text-sm text-rose-600">{{ $message }}</div> @enderror
            </div>

            <div class="flex justify-end">
                <x-button type="submit">Save</x-button>
            </div>
        </form>
    </x-card>
@endsection

