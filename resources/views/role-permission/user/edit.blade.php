@extends('layout')

@section('content')
@include('role-permission.nav-links')
    <div class="container">
        <div class="d-flex justify-content-center align-items-center">
            <div class="text-center">
                <h2 class="mt-3">Edit User</h2>
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
                    <form method="POST" action="{{ route('user.update', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col">
                                <label>User Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                            </div>
                            <div class="col">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                            </div>
                            <div class="col">
                                <label>Password (leave blank to keep current password)</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <div class="col">
                                <label>Roles</label>
                                <select class="form-control" name="role[]" multiple required>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}" {{ in_array($role, $userRoles) ? 'selected' : '' }}>{{ $role }}</option>
                                    @endforeach
                                </select>
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
    </style>
@endpush
