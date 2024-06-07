@extends('layout')

@section('content')
    <div class="container" style="margin-top:100px;">
        <h3 align="center" class="mt-5">Purchase Products</h3>
        <div class="row">
            <div class="col-md-2">
            </div>
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
                    <form method="POST" action="{{ route('purchase.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label>Supplier Name</label>
                                <select class="form-control" name="supplier_id" required>
                                    <option value="">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->suppliername }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Product Name</label>
                                <select class="form-control" name="product_id" required>
                                    <option value="">Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->productname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Quantity</label>
                                <input type="text" class="form-control" name="quantity" required>
                            </div>
                            <div class="col-md-4">
                                <label>Price</label>
                                <input type="text" class="form-control" name="price" required>
                            </div>
                            <div class="col-md-4">
                                <label>Total Price</label>
                                <input type="text" class="form-control" name="total_price" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <input type="submit" class="btn btn-primary" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
                <table class="table mt-5 text-center">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Supplier Name</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Qty</th>
                            <th scope="col">price</th>
                            <th scope="col">Total Price</th>
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
                                {{-- <td scope="col">{{ $category->status }}</td> --}}

                                <td scope="col">
                                    <a href="{{ route('purchase.edit', $purchase->id) }}">
                                        <button class="btn btn-primary btn-sm">
                                            <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                                        </button>
                                    </a>
                                    <a href="{{ route('purchase.show', $purchase->id) }}">
                                        <button class="btn btn-primary btn-sm">
                                            <i class="fa fa-eye" aria-hidden="true"></i> View
                                        </button>
                                    </a>

                                    <form action="{{ route('purchase.destroy', $purchase->id) }}" method="POST"
                                        style ="display:inline">
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
        2
    </script>
@endsection

@push('css')
    <style>
        .form-area {
            padding: 20px;
            margin-top: 20px;
            background-color: #b3e5fc;
        }

        .bi-trash-fill {
            color: red;
            font-size: 18px;
        }

        .bi-pencil {
            color: green;
            font-size: 18px;
            margin-left: 20px;
        }
    </style>
@endpush
