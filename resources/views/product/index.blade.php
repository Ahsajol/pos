@extends('layout')

@section('content')
    <div class="container" style="margin-top:100px;">
        <h3 align="center" class="mt-5">Available Products</h3>
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <div class="form-area">
                    <form method="POST" action="{{ route('product.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label>Product Name</label>
                                <input type="text" class="form-control" name="productname">
                            </div>
                            <div class="col-md-6">
                                <label>category</label>
                                <select class="form-control" name="cat_id">
                                    @foreach ($category as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Price</label>
                                <input type="text" class="form-control" name="price">
                            </div>
                            <div class="col-md-6">
                                <label>Brands</label>
                                <select class="form-control" name="brand_id">
                                    @foreach ($brand as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <input type="submit" class="btn btn-primary" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
                <table class="table mt-5">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">category Name</th>
                            <th scope="col">Brand Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $key => $product)
                            <tr>
                                <td scope="col">{{ ++$key }}</td>
                                <td scope="col">{{ $product->productname }}</td>
                                <td scope="col">{{ $product->category->catname }}</td>
                                <td scope="col">{{ $product->brand->brandname }}</td>
                                <td scope="col">{{ $product->price }}</td>
                                {{-- <td scope="col">{{ $category->status }}</td> --}}

                                <td scope="col">
                                    <a href="{{ route('product.edit', $product->id) }}">
                                        <button class="btn btn-primary btn-sm">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                        </button>
                                    </a>

                                    <form action="{{ route('product.destroy', $product->id) }}" method="POST"
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
