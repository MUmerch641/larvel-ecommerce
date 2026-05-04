@extends('layouts.app')

@section('content')
    <div class="surface p-6 sm:p-8">
        <x-page-header
            title="Order Items Table"
            subtitle="Manage all order items with DataTables."
        />

        <div class="rounded-lg border border-slate-200 bg-white/80 p-4 sm:p-6">
            <table id="orderItemsTable" class="table table-striped table-hover w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Order Number</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <style>
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: #64748b;
        }
        
        table.table {
            color: #334155;
            background-color: transparent;
        }
        
        table.table thead th {
            border-color: #e2e8f0;
            color: #475569;
            background-color: #f8fafc;
        }
        
        table.table tbody td {
            border-color: #e2e8f0;
        }
        
        table.table tbody tr:hover {
            background-color: #f1f5f9;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #0f172a;
            border-color: #0f172a;
            color: #ffffff !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #0f172a;
            border-color: #0f172a;
            color: #ffffff !important;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#orderItemsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admin.order-items-table") }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'order_number', name: 'order_number'},
                    {data: 'product_name', name: 'product_name'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'price', name: 'price'},
                    {data: 'total_price', name: 'total_price'}
                ]
            });
        });
    </script>
@endsection
