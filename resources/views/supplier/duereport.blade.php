@extends('layout')

@section('content')
    <div class="container" style="margin-top: 100px;">
        <div class="container mt-5">
        <h1 class="mb-4 text-center">Supplier Due Report</h1>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Due Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $supplier)
                    <tr>
                        <td>{{ $supplier->suppliername }}</td>
                        <td>{{ $supplier->supplierphone }}</td>
                        <td>BDT- {{ number_format($supplier->supplierpreviousdue, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>

    @push('css')
        <style>
            .card {
                border: none;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .card-header {
                background-color: #007bff;
                color: white;
                border-radius: 10px 10px 0 0;
                padding: 15px 20px;
            }

            .card-body {
                padding: 30px;
            }

            .card-footer {
                background-color: #f8f9fa;
                border-radius: 0 0 10px 10px;
                padding: 15px 20px;
            }

            h5 {
                font-weight: bold;
            }

            .table-bordered th, .table-bordered td {
                border: 1px solid #dee2e6;
            }
        </style>
    @endpush
@endsection
