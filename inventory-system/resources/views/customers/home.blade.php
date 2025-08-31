@extends('partials.navbar')
@vite(['resources/css/index.css', 'resources/js/app.js'])

@section('content')
    <div class="content-container">
        <div class="welcome-container"></div>
        <img src="{{ asset('system-images/index.png') }}" alt="Login Image" class="i-img">
    </div>

    <div class="offer-container">
        <div class="offer-box"></div>
            <img src="{{ asset('system-images/d.png') }}" alt="Login Image" class="l-img">
        <div class="offer-box"></div>
            <img src="{{ asset('system-images/aaa.png') }}" alt="Login Image" class="l-img">
            <img src="{{ asset('system-images/ccc.png') }}" alt="Login Image" class="l-img">
        <div class="offer-box"></div>
    </div>
@endsection