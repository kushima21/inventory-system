@extends('partials.navbar')
@vite(['resources/css/sideBar.css', 'resources/js/app.js'])
@php
$user = \App\Models\User::find(session('user_id'));
@endphp
@section('content')
    <div class="sideBar-main-Container">
        <div class="main-bar-container">
            <div class="left-b-container">
                <div class="l-h-container">
                    <img src="{{ asset('icons/basket-ball.png') }}" alt="basket Image" class="ball-img">
                    <h3 class="l-header">
                        LSSTI Basketball Gym Reservation
                    </h3>
                </div>
                <div class="l-m-container">
                    <div class="link-c">
                        <a href="{{ url('/customers/profile') }}">
                            <div class="link-box">
                                <img src="{{ asset('icons/profile.png') }}" alt="Profile Image" class="user-image">
                                <h3>Profile Modification</h3>
                               
                            </div>
                        </a>
                        <a href="{{ url('/customers/bookRequest') }}">
                            <div class="link-box">
                                <img src="{{ asset('icons/booking.png') }}" alt="Profile Image" class="user-image">
                                <h3>Booking Request</h3>
                           
                            </div>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="link-box" style="background:none; border:none; cursor:pointer;">
                                <img src="{{ asset('icons/logout.png') }}" alt="Profile Image" class="user-image">
                                <h3>Logout</h3>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
            <div class="right-b-container">
                @yield ('Sidecontent')
            </div>
        </div>
    </div>
@endsection