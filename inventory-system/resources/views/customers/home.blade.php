@extends('partials.navbar')
@vite(['resources/css/index.css', 'resources/js/app.js'])
@php
    $user = \App\Models\User::find(session('user_id'));
    $notifications = $user?->notifications ?? collect();
@endphp
@section('content')
    <div class="content-container">
        <div class="welcome-container">
            <h2 class="w-h">Welcome to LSSTI Basketball Gym Reservation!</h2>
                <p class="w-p">
                    Experience the convenience of reserving your basketball court anytime and anywhere. 
                    With just a few clicks, you can schedule your games, avoid conflicts, and focus on 
                    enjoying the sport you love. Whether for practice, friendly matches, or tournaments, 
                    LSSTI makes your hoop sessions smooth and hassle-free.
                </p>
                <a href="{{ url('/userBook') }}">
                    <button type="button" class="w-btn">Book Now</button>
                </a>
        </div>
        <img src="{{ asset('system-images/index.png') }}" alt="Login Image" class="i-img">
    </div>

    <div class="offer-container">
        <div class="offer-box">
            <h3>🏀 Easy Court Reservation</h3>
                <p>* Reserve the gym for practice sessions, tournaments, or fun games with friends anytime.</p>
                <p>* Enjoy a fast and convenient booking process so you can focus more on the game and less on the hassle.</p>
        </div>  
            <img src="{{ asset('system-images/d.png') }}" alt="Login Image" class="l-img">
        <div class="offer-box">
            <h3>📅 Hassle-Free Scheduling</h3>
                <p>* Plan your games ahead with an organized and user-friendly booking system.</p>
                <p>* Avoid double bookings and secure your preferred time slot with ease.</p>
        </div>
            <img src="{{ asset('system-images/aaa.png') }}" alt="Login Image" class="l-img">
            <img src="{{ asset('system-images/ccc.png') }}" alt="Login Image" class="l-img">
        <div class="offer-box">
             <h3>⭐ Quality Experience</h3>
                <p>* Play on a well-maintained court designed for students and basketball enthusiasts.</p>
                <p>* Enjoy a safe, clean, and professional environment that enhances every game.</p>
        </div>
    </div>
@endsection