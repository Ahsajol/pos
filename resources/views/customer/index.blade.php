@extends('layout')

@section('content')
    <div class="container" style="margin-top:100px;">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-10" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif
        </div>
        <h3 align="center" class="mt-4">Customer Manage</h3>
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <div class="form-area">
                    <form method="POST" action="{{ route('customer.store') }}">
                        @csrf
                        <div class="row">
                            <!-- Row with three fields: Name, Address, Phone -->
                            <div class="col-md-4">
                                <label>Name</label>
                                <input type="text" class="form-control" name="customername">
                            </div>
                            <div class="col-md-4">
                                <label>Address</label>
                                <input type="text" class="form-control" name="customeraddress">
                            </div>
                            <div class="col-md-4">
                                <label>Phone</label>
                                <input type="number" id="number" class="form-control" name="customerphone">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-2">
                                <label>Previous Due</label>
                                <input type="number" class="form-control" id="number" name="customerpreviousdue">
                            </div>
                            <div class="col-md-2">
                                <label>Credit Limit</label>
                                <input type="number" class="form-control" id="number" name="customercreditlimit">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label>Status</label>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="status" name="status"
                                        value="1">
                                    <label class="form-check-label" for="status">Active</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-primary" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12 mt-5 text-center">
                <h4>Customer List</h4>
                <hr class="mx-auto" style="width: 50%;">
            </div>
            <div class="col-md-12">
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Phone</th>
                            <th scope="col">previous due</th>
                            <th scope="col">Credit Limit</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $key => $customer)
                            <tr>
                                <td scope="col">{{ ++$key }}</td>
                                <td scope="col">{{ $customer->customername }}</td>
                                <td scope="col">{{ $customer->customeraddress }}</td>
                                <td scope="col">{{ $customer->customerphone }}</td>
                                <td scope="col">{{ $customer->customerpreviousdue }}</td>
                                <td scope="col">{{ $customer->customercreditlimit }}</td>
                                <td scope="col">
                                    @if ($customer->status == 1)
                                        Active
                                    @else
                                        Inactive
                                    @endif
                                </td>
                                <td scope="col">
                                    <a href="{{ route('customer.edit', $customer->id) }}">
                                        <button class="btn btn-primary btn-sm">
                                            <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                                        </button>
                                    </a>
                                    <a href="{{ route('customer.view', $customer->id) }}">
                                        <button class="btn btn-primary btn-sm">
                                            <i class="fa fa-eye" aria-hidden="true"></i> View
                                        </button>
                                    </a>
                                    {{-- <a href="{{ route('customer.invoice', $customer->id) }}">
                                        <button class="btn btn-primary btn-sm">
                                            <i class="fa fa-file-invoice" aria-hidden="true"></i> Invoice
                                        </button>
                                    </a> --}}

                                    <form action="{{ route('customer.destroy', $customer->id) }}" method="POST"
                                        style ="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Delete <i class="fa fa-delete-left"></i>
                                        </button>
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
