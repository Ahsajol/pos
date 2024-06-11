<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Point Of sales</title>
    <link rel="icon" href="{{ asset('images/posicon.png') }}" type="x-icon">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    {{-- <link rel="stylesheet" href=" "> --}}
    <style>
        .nav-link.active {
            font-weight: bold;
            color: #ff0000;
        }
    </style>
    {{-- <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery and Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}

</head>
@include('libraries.scripts')

<body style="background: #16a085;font-family: 'Roboto', sans-serif;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg navbar-light"
                    style="background-color: #b3e5f6; position: fixed; width: 98%; z-index: 1030;">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <img src="{{ asset('images/posicon.png') }}" alt=""
                                style="height:50px; width:50px;">Point Of Sale
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-5 mb-2 mb-lg-0">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle {{ Request::is('brand*', 'category*', 'product*', 'customer*') ? 'active' : '' }}"
                                        href="#" id="navbarDropdownRole" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        Settings
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownRole">
                                        <li><a class="dropdown-item {{ Request::is('brand') ? 'active' : '' }}"
                                                href="{{ url('/brand') }}">Brands</a></li>
                                        <li><a class="dropdown-item {{ Request::is('category') ? 'active' : '' }}"
                                                href="{{ url('/category') }}">Categories</a></li>
                                        <li><a class="dropdown-item {{ Request::is('product') ? 'active' : '' }}"
                                                href="{{ url('/product') }}">Products</a></li>
                                    </ul>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link {{ Request::is('brand') ? 'active' : '' }}"
                                        href="{{ url('/brand') }}">Brand</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('product') ? 'active' : '' }}"
                                        href="{{ url('/product') }}">Product</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('category') ? 'active' : '' }}"
                                        href="{{ url('/category') }}">Category</a> 
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('customer') ? 'active' : '' }}"
                                        href="{{ url('/customer') }}">Customer</a>
                                </li> --}}
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle {{ Request::is('supplier*', 'customer*', 'supplierPayment*', 'customerDueCollection*') ? 'active' : '' }}"
                                        href="#" id="navbarDropdownRole" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        Supplier & Customer
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownRole">
                                        <li><a class="dropdown-item {{ Request::is('supplier') ? 'active' : '' }}"
                                                href="{{ url('/supplier') }}">Supplier</a></li>
                                        <li><a class="dropdown-item {{ Request::is('supplierPayment') ? 'active' : '' }}"
                                                href="{{ url('/supplierPayment') }}">Supplier Payment</a></li>
                                        <li><a class="dropdown-item {{ Request::is('customer') ? 'active' : '' }}"
                                                href="{{ url('/customer') }}">Customers</a></li>
                                        <li><a class="dropdown-item {{ Request::is('customerDueCollection') ? 'active' : '' }}"
                                                href="{{ url('/customerDueCollection') }}">Customers Due Collection</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('purchase') ? 'active' : '' }}"
                                        href="{{ url('/purchase') }}">Purchase</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('sale') ? 'active' : '' }}"
                                        href="{{ url('/sale') }}">Sales</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle {{ Request::is('duereport*') ? 'active' : '' }}"
                                        href="#" id="navbarDropdownRole" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        Reports
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownRole">
                                        <li><a class="dropdown-item {{ Request::is('duereport') ? 'active' : '' }}"
                                                href="{{ url('duereport') }}">Supplier Due Report</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle {{ Request::is('role*', 'permission*', 'user*') ? 'active' : '' }}"
                                        href="#" id="navbarDropdownRole" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        User Control
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownRole">
                                        <li><a class="dropdown-item {{ Request::is('role') ? 'active' : '' }}"
                                                href="{{ url('/role') }}">Roles</a></li>
                                        <li><a class="dropdown-item {{ Request::is('permission') ? 'active' : '' }}"
                                                href="{{ url('/permission') }}">Permissions</a>
                                        </li>
                                        <li><a class="dropdown-item {{ Request::is('user') ? 'active' : '' }}"
                                                href="{{ url('/user') }}">Users</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="navbar-nav me-5 mb-2 mb-lg-0">
                                <li class="nav-item dropdown">
                                    <button type="button" class="btn btn-secondary dropdown-toggle"
                                        id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa fa-user"></i> {{ Auth::user()->name }}
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown"
                                        style="margin-left: -20px;">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="fa fa-user"></i> Profile: {{ Auth::user()->name }}
                                            </a>
                                        </li>
                                        <li>
                                            <form method="POST" action="{{ url('logout') }}"
                                                style="display: inline;">
                                                @csrf
                                                <x-dropdown-link class="btn btn-outline-danger" :href="route('logout')"
                                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                                    <i class="fas fa-sign-out-alt"></i> {{ __('LogOut') }}
                                                </x-dropdown-link>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div>
                @yield('content')
            </div>
        </div>
    </div>
    @include('libraries.style')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/all.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').fadeOut('fast');
            }, 3000); // 3000 milliseconds = 3 seconds
        });
    </script>


</body>

</html>
