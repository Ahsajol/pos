@extends('layout')

@section('content')
    <div class="container">
        <h3 align="center" class="mt-5">Category Edit</h3>
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <div class="form-area">
                    <form method="POST" action="{{ route('category.update', $category->id) }}">
                        {!! csrf_field() !!}
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-6">
                                <label>Category Name</label>
                                <input type="text" class="form-control" name="catname" value="{{ $category->catname }}">
                            </div>
                            <div class="col-md-6">
                                <label>Status</label>
                                <select class="form-control" name="status" id="">
                                    <option selected disabled>Select Menu</option>
                                    <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Active</option>
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
