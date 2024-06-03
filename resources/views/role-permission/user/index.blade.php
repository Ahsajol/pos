@extends('layout')

@section('content')
    @include('role-permission.nav-links')
    <div class="container" style="margin-top:100px;">
        <div class="d-flex justify-content-center align-items-center">
            <div class="text-center">
                <h2 class="mt-3">Users</h2>
                {{-- <a href="{{ url('role') }}" class="btn btn-primary mt-2">back</a> --}}
            </div>
        </div>
        <hr>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="row">
            <div class="col">
                <div class="form-area">
                    <form method="POST" action="{{ route('user.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label>User Name</label>
                                <input type="text" class="form-control" name="name" required>
                                @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="col">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" required>
                                @error('email') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="col">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" required>
                                @error('password') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="col">
                                <label>Roles</label>
                                <select class="form-control" name="role[]" multiple required>
                                    <option disabled>Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                                @error('role') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
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
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    {{-- @foreach ($user->roles as $role)
                                        <label class=" badge bg-primary mx-1">{{ $role->name }}</label>
                                    @endforeach --}}
                                    @if (!empty($user->getRoleNames()))
                                        @foreach ($user->getRoleNames() as $rolename)
                                            <label for="" class="badge bg-info mx-1">{{ $rolename }}</label>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @can('edit user')
                                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    @endcan
                                    @can('delete user')
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                        style="display:inline">
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
    </style>
@endpush
