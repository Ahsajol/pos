@extends('layout')

@section('content')
    <div class="container" style="margin-top: 100px;">
        <div class="card">
            <div class="card-header text-center">
                <h3>Invoice</h3>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Supplier Information:</h5>
                        <p><strong>Name:</strong> {{ $purchase->supplier->suppliername }}</p>
                        <p><strong>Contact:</strong> {{ $purchase->supplier->supplierphone ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <h5>Invoice Details:</h5>
                        <p><strong>Invoice No:</strong> INV-{{ $purchase->id }}</p>
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total Price</th>
                                    <th>paid Amount</th>
                                    <th>Current Due</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>{{ $purchase->product->productname }}</td>
                                    <td>{{ $purchase->quantity }}</td>
                                    <td>{{ $purchase->price }}</td>
                                    <td>${{ $purchase->total_price }}</td>
                                    <td>${{ $purchase->paid_amount }}</td>
                                    <td>${{ $purchase->total_price-$purchase->paid_amount }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-md-right">
                        <h6>Invoice Total: ৳ {{ $purchase->total_price }}</h6>
                        <h6>Paid amount: ৳ {{ $purchase->paid_amount }}</h6>
                        <h6>Supplier Current Due: ৳ {{ $purchase->total_price-$purchase->paid_amount }}</h6>
                        <h6>Supplier Total Due: ৳ {{ $purchase->supplier->supplierpreviousdue }}</h6>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('purchase.index') }}" class="btn btn-secondary">Cancel</a>
                <button class="btn btn-primary" onclick="window.print()">Print Invoice</button>
            </div>
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
