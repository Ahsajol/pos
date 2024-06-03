@extends('layout')

@section('content')
    <div class="container" style="margin-top:100px;">
        <h3 align="center" class="mt-5">Brand Manage</h3>
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <div class="form-area">
                    <form method="POST" action="{{ route('brand.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label>Brand Name</label>
                                <input type="text" class="form-control" name="brandname">
                            </div>
                            <div class="col-md-6">
                                <label>Status</label>
                                <select class="form-control" name="status" id="">
                                    <option selected>Select Menu</option>
                                    <option value="0">Inactive</option>
                                    <option value="1">Active</option>
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
                            <th scope="col">Brand Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($brand as $key => $brands)
                            <tr>
                                <td scope="col">{{ ++$key }}</td>
                                <td scope="col">{{ $brands->brandname }}</td>
                                {{-- <td scope="col">{{ $category->status }}</td> --}}
                                <td scope="col">
                                    @if ($brands->status == 1)
                                        Active
                                    @else
                                        Inactive
                                    @endif
                                </td>
                                <td scope="col">
                                    {{-- @if (session('flash_message'))
                                        <div class="alert alert-success">
                                            {{ session('flash_message') }}
                                        </div>
                                    @endif --}}
                                    <a href="{{ route('brand.edit', $brands->id) }}">
                                        <button class="btn btn-primary btn-sm">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                        </button>
                                    </a>
                                    <form action="{{ route('brand.destroy', $brands->id) }}" method="POST"
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
