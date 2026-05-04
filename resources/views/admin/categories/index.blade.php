@extends('layouts.app')

@section('content')
    <x-page-header
        title="Categories"
        subtitle="Manage product categories."
    >
        <x-button href="/admin/categories/create">New category</x-button>
    </x-page-header>

    <x-card class="p-0 overflow-hidden">
        @if($categories->isEmpty())
            <div class="p-5">
                <x-empty-state
                    title="No categories yet"
                    message="Create a category to organize products."
                >
                    <x-button href="/admin/categories/create">New category</x-button>
                </x-empty-state>
            </div>
        @else
            <div class="divide-y divide-slate-200/70">
                @foreach($categories as $category)
                    <div class="flex flex-col gap-3 p-5 sm:flex-row sm:items-center sm:justify-between">
                        <div class="min-w-0">
                            <div class="truncate text-base font-extrabold text-slate-900">{{ $category->name }}</div>
                            <div class="mt-1 text-sm text-slate-600">
                                Slug: <span class="font-semibold text-slate-900">{{ $category->slug }}</span>
                                @if($category->parent)
                                    <span class="text-slate-400">·</span>
                                    Parent: <span class="font-semibold text-slate-900">{{ $category->parent->name }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-2">
                            <x-button href="/admin/categories/{{ $category->id }}/edit" variant="secondary">Edit</x-button>
                            <form method="POST" action="/admin/categories/{{ $category->id }}" class="m-0">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="secondary">Delete</x-button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="border-t border-slate-200/70 p-5">
                {{ $categories->links() }}
            </div>
        @endif
    </x-card>
@endsection

