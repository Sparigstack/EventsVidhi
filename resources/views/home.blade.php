@extends('layouts.app')

@section('content')
<div class="container">
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Coming Soon!</h1>
        <p class="lead">We are building cool Events management system, easy to use and friendly to pockets!</p>
        @guest
        <a class="btn btn-primary btn-lg mb-5 mb-lg-2" href="{{ route('register') }}">List Your Event</a>
        @else
        <a class="btn btn-primary btn-lg mb-5 mb-lg-2" href="{{ route('orgEvents') }}">My Account</a>
        @endguest
    </div>

<!--    <h4>Your files</h4>
    <ul class="list-group">
        @forelse ($s3Files as $file)
        <li class="list-group-item">
            <a href="#">
                {{ basename($file) }}
            </a>
        </li>
        @empty
        <li class="list-group-item">You have no files</li>
        @endforelse
    </ul>

    @if (!empty($localFiles))
    <hr />
    <h4>Uploading and encrypting...</h4>
    <ul class="list-group">
        @foreach ($localFiles as $file)
        <li class="list-group-item">
            {{ basename($file) }}
        </li>
        @endforeach
    </ul>
    @endif-->

    <!--    <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
    
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
    
                        You are logged in!
                    </div>
                </div>
            </div>
        </div>-->
</div>
@endsection
