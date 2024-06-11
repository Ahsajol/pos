@extends('layout')

@section('content')
    <div class="container" style="margin-top:100px;">
        <h3 align="center" class="mt-5">Edit Purchase</h3>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-10" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="form-area">
                    <form method="POST" action="{{ route('purchase.update', $purchases->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <label>Supplier Name</label>
                                <select class="form-control" name="supplier_id" required>
                                    <option value="">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            @if ($supplier->id == $purchases->supplier_id) selected @endif>
                                            {{ $supplier->suppliername }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Product Name</label>
                                <select class="form-control" name="product_id" required>
                                    <option value="">Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            @if ($product->id == $purchases->product_id) selected @endif>
                                            {{ $product->productname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Quantity</label>
                                <input type="text" class="form-control" id="quantity" name="quantity"
                                    value="{{ $purchases->quantity }}" required oninput="calculateTotalPrice()">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Price</label>
                                <input type="text" class="form-control" id="price" name="price" value="{{ $purchases->price }}"
                                    required oninput="calculateTotalPrice()">
                            </div>
                            <div class="col-md-3">
                                <label>Total Price</label>
                                <input type="text" class="form-control" id="total_price" name="total_price"
                                    value="{{ $purchases->total_price }}" readonly>
                            </div>
                            <div class="col-md-3">
                                <label>Paid amount</label>
                                <input type="text" class="form-control" id="paid_amount" name="paid_amount"
                                    value="{{ $purchases->paid_amount }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <input type="submit" class="btn btn-primary" value="Update">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function calculateTotalPrice() {
            const quantity = document.getElementById('quantity').value;
            const price = document.getElementById('price').value;
            const totalPrice = document.getElementById('total_price');
            totalPrice.value = quantity * price;
            calculateDue();
        }

        function updatePrice() {
            const productSelect = document.getElementById('product_id');
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            document.getElementById('price').value = price;
            calculateTotalPrice();
        }

        function calculateDue() {
            const totalPrice = document.getElementById('total_price').value;
            const paidAmount = document.getElementById('paid_amount').value;
            const dueAmount = totalPrice - paidAmount;
            // Display due amount in some way if needed
        }
    </script>
@endsection

@push('css')
    <style>
        .form-area {
            padding: 20px;
            margin-top: 20px;
            background-color: #b3e5fc;
        }
    </style>
@endpush
