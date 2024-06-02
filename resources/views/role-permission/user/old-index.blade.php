@extends('layout')

@section('content')
    @include('role-permission.nav-links')
    <div class="container">
        <div class="d-flex justify-content-center align-items-center">
            <div class="text-center">
                <h2 class="mt-3">Users</h2>
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
                    <form id="userForm" method="POST" action="{{ route('user.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label>User Name</label>
                                <input type="text" class="form-control" name="name" required>
                                <span class="text-danger error-message" id="nameError"></span>
                            </div>
                            <div class="col">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" required>
                                <span class="text-danger error-message" id="emailError"></span>
                            </div>
                            <div class="col">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" required>
                                <span class="text-danger error-message" id="passwordError"></span>
                            </div>
                            <div class="col">
                                <label>Roles</label>
                                <select class="form-control" name="role[]" multiple required>
                                    <option disabled>Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-message" id="roleError"></span>
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
                                    @if (!empty($user->getRoleNames()))
                                        @foreach ($user->getRoleNames() as $rolename)
                                            <label for="" class="badge bg-info mx-1">{{ $rolename }}</label>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                        style="display:inline">
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
        .error-message {
            font-size: 0.875em;
            color: red;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.getElementById('userForm').addEventListener('submit', function(event) {
            let valid = true;

            const name = document.querySelector('input[name="name"]');
            const email = document.querySelector('input[name="email"]');
            const password = document.querySelector('input[name="password"]');
            const role = document.querySelector('select[name="role[]"]');

            const nameError = document.getElementById('nameError');
            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');
            const roleError = document.getElementById('roleError');

            nameError.textContent = '';
            emailError.textContent = '';
            passwordError.textContent = '';
            roleError.textContent = '';

            if (name.value.length < 1 || name.value.length > 25) {
                nameError.textContent = 'Name must be between 1 and 25 characters.';
                valid = false;
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email.value)) {
                emailError.textContent = 'Invalid email address.';
                valid = false;
            }

            if (password.value.length < 5 || password.value.length > 13) {
                passwordError.textContent = 'Password must be between 5 and 13 characters.';
                valid = false;
            }

            if (!role.value) {
                roleError.textContent = 'Please select at least one role.';
                valid = false;
            }

            if (!valid) {
                event.preventDefault();
            }
        });
    </script>
@endpush
