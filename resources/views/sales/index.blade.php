@extends('layout')

@section('content')
    <div class="container" style="margin-top:100px;">
        <h3 align="center">Sales Products</h3> <hr>
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
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-area">
                            <form method="POST" action="{{ route('cart.add') }}">
                            {{-- <form method="POST" action=" "> --}}
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Customer Name</label>
                                        <select class="form-control" name="customer_id" required>
                                            <option value="">Select Customer</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->customername }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Product Name</label>
                                        <select class="form-control" id="product_id" name="product_id" required
                                            onchange="updatePrice()">
                                            <option value="">Select Product</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                    {{ $product->productname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Sales QTY</label>
                                        <input type="text" class="form-control" id="quantity" name="quantity" required
                                            oninput="calculateTotalPrice()">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Price</label>
                                        <input type="text" class="form-control" id="price" name="price" required
                                            oninput="calculateTotalPrice()">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Total Price</label>
                                        <input type="text" class="form-control" id="total_price" name="total_price"
                                            readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Paid Amount</label>
                                        <input type="text" class="form-control" id="paid_amount" name="paid_amount"
                                            required oninput="calculateDue()">
                                    </div>
                                    <div class="col-md-4 mt-4">
                                        <input type="hidden" name="transaction_type" value="sales">
                                        <input type="submit" class="btn btn-primary" value="Add to Cart">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-center">Cart Items</h4> <hr>
                        <form method="POST" action="{{ route('sales.fromCart') }}">
                            @csrf
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Paid Amount</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartItems as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->product->productname }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->product->price }}</td>
                                            <td>{{ $item->quantity * $item->product->price }}</td>
                                            <td>{{ $item->paid_amount }}</td>
                                            <td>
                                                <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="col-md-4 mt-4">
                                <input type="submit" class="btn btn-success" value="Complete Sale">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="row">
        <div class="col-md-12">
            <table class="table mt-5 text-center">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Price</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Paid Amount</th>
                        <th scope="col">Invoice Due</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $key => $sale)
                        <tr class="text-center">
                            <td scope="col">{{ ++$key }}</td>
                            <td scope="col">{{ $sale->customers->customername }}</td>
                            <td scope="col">{{ $sale->product->productname }}</td>
                            <td scope="col">{{ $sale->quantity }}</td>
                            <td scope="col">{{ $sale->price }}</td>
                            <td scope="col">{{ $sale->total_price }}</td>
                            <td scope="col">{{ $sale->paid_amount }}</td>
                            <td scope="col">{{ $sale->total_price - $sale->paid_amount }}</td>
                            <td scope="col">{{ $sale->created_at->format('Y-m-d') }}</td>
                            <td scope="col">
                                <a href="{{ route('sales.edit', $sale->id) }}">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                                    </button>
                                </a>
                                <a href="{{ route('sales.invoice', $sale->id) }}">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fa fa-eye" aria-hidden="true"></i> Invoice
                                    </button>
                                </a>

                                <form action="{{ route('sales.destroy', $sale->id) }}" method="POST"
                                    style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <script>
        function updatePrice() {
            var price = $('#product_id').find(':selected').data('price');
            $('#price').val(price);
            calculateTotalPrice();
        }

        function calculateTotalPrice() {
            var quantity = $('#quantity').val();
            var price = $('#price').val();
            var total_price = quantity * price;
            $('#total_price').val(total_price);
        }

        function calculateDue() {
            const totalPrice = document.getElementById('total_price').value;
            const paidAmount = document.getElementById('paid_amount').value;
            const dueAmount = totalPrice - paidAmount;
            // Display due amount in some way if needed
        }
    </script>
@endsection
