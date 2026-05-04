@extends('layouts.app')

@section('content')
    <x-page-header
        title="Admin"
        subtitle="Manage your catalog and orders."
    />

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <a href="/admin/categories"
           class="group rounded-2xl border border-slate-200/70 bg-white/80 p-5 transition hover:-translate-y-0.5 hover:border-slate-300 hover:bg-white">
            <div class="text-base font-extrabold text-slate-900">Categories</div>
            <div class="mt-1 text-sm text-slate-500">Organize the catalog and navigation.</div>
            <div class="mt-4 text-sm font-semibold text-slate-700 group-hover:text-slate-900">Manage →</div>
        </a>

        <a href="/admin/products"
           class="group rounded-2xl border border-slate-200/70 bg-white/80 p-5 transition hover:-translate-y-0.5 hover:border-slate-300 hover:bg-white">
            <div class="text-base font-extrabold text-slate-900">Products</div>
            <div class="mt-1 text-sm text-slate-500">Pricing, stock, visibility, images.</div>
            <div class="mt-4 text-sm font-semibold text-slate-700 group-hover:text-slate-900">Manage →</div>
        </a>

        <a href="/admin/orders"
           class="group rounded-2xl border border-slate-200/70 bg-white/80 p-5 transition hover:-translate-y-0.5 hover:border-slate-300 hover:bg-white">
            <div class="text-base font-extrabold text-slate-900">Orders</div>
            <div class="mt-1 text-sm text-slate-500">Review and update order statuses.</div>
            <div class="mt-4 text-sm font-semibold text-slate-700 group-hover:text-slate-900">Manage →</div>
        </a>

        <a href="/admin/products-table"
           class="group rounded-2xl border border-slate-200/70 bg-white/80 p-5 transition hover:-translate-y-0.5 hover:border-slate-300 hover:bg-white">
            <div class="text-base font-extrabold text-slate-900">Products Table</div>
            <div class="mt-1 text-sm text-slate-500">View all products with DataTables.</div>
            <div class="mt-4 text-sm font-semibold text-slate-700 group-hover:text-slate-900">View →</div>
        </a>

        <a href="/admin/orders-table"
           class="group rounded-2xl border border-slate-200/70 bg-white/80 p-5 transition hover:-translate-y-0.5 hover:border-slate-300 hover:bg-white">
            <div class="text-base font-extrabold text-slate-900">Orders Table</div>
            <div class="mt-1 text-sm text-slate-500">View all orders with DataTables.</div>
            <div class="mt-4 text-sm font-semibold text-slate-700 group-hover:text-slate-900">View →</div>
        </a>

        <a href="/admin/order-items-table"
           class="group rounded-2xl border border-slate-200/70 bg-white/80 p-5 transition hover:-translate-y-0.5 hover:border-slate-300 hover:bg-white">
            <div class="text-base font-extrabold text-slate-900">Order Items</div>
            <div class="mt-1 text-sm text-slate-500">View all order items with DataTables.</div>
            <div class="mt-4 text-sm font-semibold text-slate-700 group-hover:text-slate-900">View →</div>
        </a>

        <a href="/admin/users-table"
           class="group rounded-2xl border border-slate-200/70 bg-white/80 p-5 transition hover:-translate-y-0.5 hover:border-slate-300 hover:bg-white">
            <div class="text-base font-extrabold text-slate-900">Customers</div>
            <div class="mt-1 text-sm text-slate-500">View customers who ordered.</div>
            <div class="mt-4 text-sm font-semibold text-slate-700 group-hover:text-slate-900">View →</div>
        </a>

        <a href="/admin/admins-table"
           class="group rounded-2xl border border-slate-200/70 bg-white/80 p-5 transition hover:-translate-y-0.5 hover:border-slate-300 hover:bg-white">
            <div class="text-base font-extrabold text-slate-900">Admins</div>
            <div class="mt-1 text-sm text-slate-500">View admin panel access users.</div>
            <div class="mt-4 text-sm font-semibold text-slate-700 group-hover:text-slate-900">View →</div>
        </a>
    </div>
@endsection
