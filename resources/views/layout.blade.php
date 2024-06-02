<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Point Of sales</title>
    <link rel="icon" href="{{ asset('images/posicon.png') }}" type="x-icon">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    {{-- <link rel="stylesheet" href=" "> --}}
</head>

<body>
    @include('libraries.scripts')
    <div class="row">
        <div class="col-md-12">
            {{-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="{{ 'layout' }}">
                            <img src="{{ asset('images/posicon.png') }}" alt="" srcset=""
                                style="height:50px; width:50px;">Point Of Sale
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                            <div class="navbar-nav">
                                <a class="nav-link active" aria-current="page"
                                    href="{{ url('/category') }}">Category</a>
                                <a class="nav-link active" aria-current="page" href="{{ url('/brand') }}">Brand</a>
                                <a class="nav-link active" aria-current="page" href="{{ url('/product') }}">Product</a>
                                <a class="nav-link active" aria-current="page" href="{{ url('/sales') }}">Sales</a>
                                <a class="nav-link active" aria-current="page"
                                    href="{{ url('role-permission/role/index') }}">User Control</a>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-outline-danger" style="text-decoration: none; background-color: red;">
                        <form method="POST" action="{{ url('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('LogOut') }}
                            </x-dropdown-link>
                        </form>
                    </button>
                    <div class="row">
                        <div class="col">
                            <div class="btn btn-danger">
                                <form method="POST" action="{{ url('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </div>
                    </div>
                </nav> --}}
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ 'layout' }}">
                        <img src="{{ asset('images/posicon.png') }}" alt="" srcset=""
                            style="height:50px; width:50px;">Point Of Sale
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ url('/brand') }}">Brand</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ url('/product') }}">Product</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/category') }}">Category</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/sales') }}">Sales</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('role-permission/role/index') }}">User Control</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <button type="button" class="btn btn-secondary dropdown-toggle" id="navbarDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-user"></i> {{ Auth::user()->name }}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="fa fa-user"></i> Profile: {{ Auth::user()->name }}
                                        </a>
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ url('logout') }}" style="display: inline;">
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

                        {{-- <form class="d-flex">
                                <input class="form-control me-2" type="search" placeholder="Search"
                                    aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Search</button>
                            </form> --}}
                    </div>
                </div>
            </nav>
        </div>
        <div>
            @yield('content')
        </div>
    </div>
    @include('libraries.style')
</body>
<script src="{{ asset('js/all.min.js') }}"></script>

</html>
