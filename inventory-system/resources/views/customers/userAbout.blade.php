@extends('partials.navbar')
@vite(['resources/css/about.css', 'resources/js/app.js'])

@section('content')
    <div class="about-main-content">
            <img src="{{ asset('system-images/about.png') }}" alt="Login Image" class="a-img">
            <div class="about-us-box">
                <div class="aa-c">
                <h2 class="header-about">About Us</h2>
                <img src="{{ asset('system-images/aa.png') }}" alt="Login Image" class="aa-img">
                </div>
                <div class="a-bout-box">
                    <div class="a-box"></div>
                    <div class="a-box"></div>
                    <div class="a-box"></div>
                    <div class="a-box"></div>
                </div>
            </div>
            <img src="{{ asset('system-images/bbb.png') }}" alt="Login Image" class="aa-img">
       </div>
@endsection