@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="container-fluid p-5 bg-primary text-white text-center">
                    <h1>Dashboard</h1>
                    <div class="container mt-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card bg-info">
                                    <div class="card-body">
                                        <h4 class="card-title">Todays Sales</h4>
                                        <p class="card-text">Some example text. Some example text.</p>
                                        <a href="#" class="card-link">Card link</a>
                                        <a href="#" class="card-link">Another link</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-info">
                                    <div class="card-body">
                                        <h4 class="card-title">Todays Cost</h4>
                                        <p class="card-text">Some example text. Some example text.</p>
                                        <a href="#" class="card-link">Card link</a>
                                        <a href="#" class="card-link">Another link</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-info">
                                    <div class="card-body">
                                        <h4 class="card-title">More</h4>
                                        <p class="card-text">Some example text. Some example text.</p>
                                        <a href="#" class="card-link">Card link</a>
                                        <a href="#" class="card-link">Another link</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
