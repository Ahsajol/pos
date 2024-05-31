@extends('layout')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-center align-items-center">
            <div class="text-center">
                <h2 class="mt-3">Permission Update</h2>
                <a href="{{ url('permission') }}" class="btn btn-primary mt-2">Back</a>
            </div>
        </div>
        @if (@session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="row">
            <div class="col">
                <div class="form-area">
                    <form method="POST" action="{{ url('permission/'.$permission->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col">
                                <label>Permission Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $permission->name }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col p-2 text-center">
                                <input type="submit" class="btn btn-primary" value="Update">
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
