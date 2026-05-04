@extends('layouts.app')

@section('content')
    <div class="surface p-6 sm:p-8">
        <x-page-header
            title="Orders Table"
            subtitle="Manage all orders with DataTables."
        />

        <div class="rounded-lg border border-slate-200 bg-white/80 p-4 sm:p-6">
            <table id="ordersTable" class="table table-striped table-hover w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Order Number</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
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
            $('#ordersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admin.orders-table") }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'order_number', name: 'order_number'},
                    {data: 'customer_name', name: 'customer_name'},
                    {data: 'customer_email', name: 'customer_email'},
                    {data: 'total', name: 'total'},
                    {data: 'status', name: 'status'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endsection
