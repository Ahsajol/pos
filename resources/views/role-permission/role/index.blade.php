@extends('layout')
@section('content')
@include('role-permission.nav-links')
    <div class="container" style="margin-top:100px;">
       <div class="d-flex justify-content-center align-items-center">
            <div class="text-center">
                <h2 class="mt-3">Roles Assignment</h2>
                {{-- <a href="{{ url('role') }}" class="btn btn-primary mt-2">back</a> --}}
            </div>
        </div>
        <hr>
        @if (@session('status'))
            <div class="alert alert-success">
                {{ session('status')}}
            </div>            
        @endif
        <div class="row">
            <div class="col">
                <div class="form-area">
                    <form method="POST" action="{{ url('/role') }}">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label>Role Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            {{-- <div class="col-md-6">
                                <label>Status</label>
                                <select class="form-control" name="status" id="">
                                    <option selected>Select Menu</option>
                                    <option value="0">Inactive</option>
                                    <option value="1">Active</option>
                                </select>
                            </div> --}}
                        </div>
                        <div class="row">
                            <div class="col p-2 text-center">
                                <input type="submit" class="btn btn-primary" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
                <table class="table mt-5">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Role</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($role as $key => $item)
                            <tr>
                                <td scope="col">{{ ++$key }}</td>
                                <td scope="col">{{ $item->name }}</td>
                                {{-- <td scope="col">
                                    @if ($item->status == 1)
                                        Active
                                    @else
                                        Inactive
                                    @endif
                                </td> --}}
                                <td scope="col">
                                    
                                    <a href="{{ url('role/'. $item->id.'/give-permission') }}">
                                        <button class="btn btn-primary btn-sm">
                                            <i class="fa fa-pencil-square" aria-hidden="true"></i> Add/Edit Role
                                        </button>
                                    </a>
                                    @can('edit role')
                                     <a href="{{ route('role.edit', $item->id) }}">
                                        <button class="btn btn-primary btn-sm">
                                            <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                                        </button>
                                    </a>
                                    @endcan
                                    @can('delete role')
                                    <form action="{{ route('role.destroy', $item->id) }}" method="POST"
                                        style ="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    @endcan
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
