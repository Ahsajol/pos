@extends('layout')

@section('content')
    <div class="container" style="margin-top:100px;">
        <h3 align="center">Purchase Products</h3> <hr>
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
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Supplier Name</label>
                                        <select class="form-control" name="supplier_id" required>
                                            <option value="">Select Supplier</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->suppliername }}</option>
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
                                        <label>Purchased QTY</label>
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
                                        <input type="hidden" name="transaction_type" value="purchase">
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
                        <form method="POST" action="{{ route('purchase.fromCart') }}">
                            @csrf
                            <input type="hidden" name="supplier_id" value="{{ $suppliers[0]->id }}">
                            <!-- Set the default supplier_id -->
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
                                <input type="submit" class="btn btn-success" value="Purchase from Cart">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <div class="form-area">
                    <form method="POST" action="{{ route('cart.add') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label>Supplier Name</label>
                                <select class="form-control" name="supplier_id" required>
                                    <option value="">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->suppliername }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Product Name</label>
                                <select class="form-control" id="product_id" name="product_id" required onchange="updatePrice()">
                                    <option value="">Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                            {{ $product->productname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Purchased QTY</label>
                                <input type="text" class="form-control" id="quantity" name="quantity" required oninput="calculateTotalPrice()">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Price</label>
                                <input type="text" class="form-control" id="price" name="price" required oninput="calculateTotalPrice()">
                            </div>
                            <div class="col-md-4">
                                <label>Total Price</label>
                                <input type="text" class="form-control" id="total_price" name="total_price" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Paid Amount</label>
                                <input type="text" class="form-control" id="paid_amount" name="paid_amount" required
                                    oninput="calculateDue()">
                            </div>
                            <div class="col-md-4 mt-4">
                                <input type="submit" class="btn btn-primary" value="Add to Cart">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}
        {{-- <div class="row mt-5">
            <div class="col-md-12">
                <h4>Cart Items</h4>
                <form method="POST" action="{{ route('purchase.fromCart') }}">
                    @csrf
                    <input type="hidden" name="supplier_id" value="{{ $suppliers[0]->id }}"> <!-- Set the default supplier_id -->
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
                        <input type="submit" class="btn btn-success" value="Purchase from Cart">
                    </div>
                </form>
            </div>
        </div> --}}
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table mt-5 text-center">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Supplier Name</th>
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
                    @foreach ($purchases as $key => $purchase)
                        <tr class="text-center">
                            <td scope="col">{{ ++$key }}</td>
                            <td scope="col">{{ $purchase->supplier->suppliername }}</td>
                            <td scope="col">{{ $purchase->product->productname }}</td>
                            <td scope="col">{{ $purchase->quantity }}</td>
                            <td scope="col">{{ $purchase->price }}</td>
                            <td scope="col">{{ $purchase->total_price }}</td>
                            <td scope="col">{{ $purchase->paid_amount }}</td>
                            <td scope="col">{{ $purchase->total_price - $purchase->paid_amount }}</td>
                            <td scope="col">{{ $purchase->created_at->format('Y-m-d') }}</td>
                            <td scope="col">
                                <a href="{{ route('purchase.edit', $purchase->id) }}">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                                    </button>
                                </a>
                                <a href="{{ route('purchase.invoice', $purchase->id) }}">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fa fa-eye" aria-hidden="true"></i> Invoice
                                    </button>
                                </a>

                                <form action="{{ route('purchase.destroy', $purchase->id) }}" method="POST"
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
@endsection

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
    // function calculateTotalPrice() {
    //         const quantity = document.getElementById('quantity').value;
    //         const price = document.getElementById('price').value;
    //         const totalPrice = document.getElementById('total_price');
    //         totalPrice.value = quantity * price;
    //         calculateDue();
    //     }

    // function updatePrice() {
    //     const productSelect = document.getElementById('product_id');
    //     const selectedOption = productSelect.options[productSelect.selectedIndex];
    //     const price = selectedOption.getAttribute('data-price');
    //     document.getElementById('price').value = price;
    //     calculateTotalPrice();
    // }

    function calculateDue() {
        const totalPrice = document.getElementById('total_price').value;
        const paidAmount = document.getElementById('paid_amount').value;
        const dueAmount = totalPrice - paidAmount;
        // Display due amount in some way if needed
    }
</script>
