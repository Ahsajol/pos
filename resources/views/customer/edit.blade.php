@extends('layout')

@section('content')
    <div class="container" style="margin-top:100px;">
        <h3 align="center" class="mt-4">Edit Customer</h3>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="form-area">
                    <form method="POST" action="{{ route('customer.update', $customers->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <label>Name</label>
                                <input type="text" class="form-control" name="customername" value="{{ $customers->customername }}">
                            </div>
                            <div class="col-md-4">
                                <label>Address</label>
                                <input type="text" class="form-control" name="customeraddress" value="{{ $customers->customeraddress }}">
                            </div>
                            <div class="col-md-4">
                                <label>Phone</label>
                                <input type="number" id="number" class="form-control" name="customerphone" value="{{ $customers->customerphone }}">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label>Previous Due</label>
                                <input type="number" class="form-control" id="number" name="customerpreviousdue" value="{{ $customers->customerpreviousdue }}">
                            </div>
                            <div class="col-md-4">
                                <label>Credit Limit</label>
                                <input type="number" class="form-control" id="number" name="customercreditlimit" value="{{ $customers->customercreditlimit }}">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label>Status</label>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="status" name="status" value="1" {{ $customers->status == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status">Active</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
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
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 1000); // 3000 milliseconds = 3 seconds
        });
    </script>
@endpush
