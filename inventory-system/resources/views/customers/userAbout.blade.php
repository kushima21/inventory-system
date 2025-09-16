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
                    <div class="a-box">
                        <h3>🏀 Who We Are</h3>
                        <p>* LSSTI Basketball Gym Reservation is a platform created to make court booking simple, fast, and accessible for everyone.</p>
                        <p>* We are dedicated to promoting sportsmanship, teamwork, and convenience by providing a reliable space where students and players can easily manage their games.</p>
                    </div>
                    <div class="a-box">
                        <h3>🎯 Our Mission</h3>
                        <p>* We aim to provide students, athletes, and basketball enthusiasts with a reliable system for managing gym schedules and reservations.</p>
                        <p>* Our goal is to make basketball more accessible by removing the stress of scheduling, so players can focus on improving their skills and enjoying the game.</p>
                    </div>
                    <div class="a-box">
                         <h3>📅 What We Offer</h3>
                         <p>* We provide an organized platform that helps players, teams, and event organizers save time while securing their preferred schedules with ease.</p>
                         <p>* From practice sessions to tournaments, our system ensures a smooth reservation process and a hassle-free basketball experience.</p>
                    </div>
                    <div class="a-box">
                        <h3>⭐ Why Choose Us</h3>
                        <p>* With our reliable system and commitment to providing the best experience, we make every reservation smooth, so you can enjoy basketball without worries.</p>
                        <p>* We value convenience, organization, and quality—helping you focus more on the game and less on the scheduling.</p>
                    </div>
                </div>
            </div>
            <img src="{{ asset('system-images/bbb.png') }}" alt="Login Image" class="aa-img">
       </div>
@endsection