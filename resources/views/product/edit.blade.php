@extends('layout')

@section('content')
    <div class="container">
        <h3 align="center" class="mt-5">Product Edit</h3>
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <div class="form-area">
                    <form action="{{ route('product.update', $product->id) }}" method="post">
                        {!! csrf_field() !!}
                        @method('PATCH')
                        <input type="hidden" name="id" id="id" value="{{ $product->id }}" id="id" />

                        <label>Product Name</label></br>
                        <input type="numeric" name="productname" id="enroll_no" value="{{ $product->productname }}"
                            class="form-control"></br>

                        {{-- <label>Category</label></br>
                        <input type="numeric" name="cat_id" id="cat_id" value="{{ $product->category->id }}"
                            class="form-control"></br> --}}

                        {{-- <label>Category</label><br>
                        <input type="text" name="cat_id" id="cat_id" value="{{ $product->category->catname }}"
                            class="form-control"><br>
                        <input type="hidden" name="cat_id" id="cat_id" value="{{ $product->category->id }}"> --}}

                        <label>Category</label><br>
                        <select name="cat_id" id="cat_id" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $product->category->id == $category->id ? 'selected' : '' }}>
                                    {{ $category->catname }}
                                </option>
                            @endforeach
                        </select><br>

                        {{-- <label>Brand</label></br>
                        <input type="numeric" name="brand_id" id="brand_id" value="{{ $product->brand->id }}"
                            class="form-control"></br> --}}

                        <label>Brand</label><br>
                        <select name="brand_id" id="brand_id" class="form-control">
                            @foreach ($brand as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ $product->brand->id == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->brandname }}
                                </option>
                            @endforeach
                        </select><br>

                        <label>Price</label></br>
                        <input type="text" name="price" id="price" value="{{ $product->price }}"
                            class="form-control"></br>
                        <input type="submit" value="Update" class="btn btn-success"></br>
                    </form>
                </div>
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
