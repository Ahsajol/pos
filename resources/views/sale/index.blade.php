@extends('layout')
@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Product Sales</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form action="{{ route('sales.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="customer" class="form-label">Customer</label>
                <select class="form-select" id="customer" name="customer_id" required>
                    <option value="" selected disabled>Select Customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="product" class="form-label">Product</label>
                <select class="form-select" id="product" name="product_id" required>
                    <option value="" selected disabled>Select Product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->name }} - ${{ $product->price }} ({{ $product->brand->name }}, {{ $product->category->name }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <button type="submit" class="btn btn-primary">Sell</button>
        </form>
    </div>
@endsection
