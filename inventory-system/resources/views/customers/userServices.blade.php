@extends('partials.navbar')
@vite(['resources/css/services.css', 'resources/js/app.js'])

@section('content')
    <div class="services-header">
            <h2 class="services-H">Our Services</h2>
            <p class="services-P">
                Our basketball gym reservation service makes it easy to book your workout schedule in advance.<br>
                This ensures an organized experience, prevents overcrowding,<br>
                and provides flexibility for personal training, group classes, or individual sessions.
            </p>
       </div>

       <div class="services-container">
            <div class="service-b">
               <h3>📅 Schedule Management</h3>
                <p>Stay updated with your court bookings anytime, ensuring smooth planning for practices, games, and events.</p>
                <p>View and manage your upcoming reservations in one organized calendar, avoiding conflicts and overlaps.</p>
            </div>
            <img src="{{ asset('system-images/s.png') }}" alt="Login Image" class="s-img">
            <div class="service-b">
               <h3>⭐ Event Hosting</h3>
                <p>Enjoy a professional and well-maintained venue that can accommodate both small gatherings and large tournaments.</p>
                <p>Use the gym for basketball events, competitions, and school activities with hassle-free coordination.</p>
            </div>
       </div>
       <div class="services-container">
            <img src="{{ asset('system-images/f.png') }}" alt="Login Image" class="ss-img">
            <div class="service-b">
                <h3>📅 Schedule Management</h3>
                <p>Stay updated with your court bookings anytime, ensuring smooth planning for practices, games, and events.</p>
                <p>View and manage your upcoming reservations in one organized calendar, avoiding conflicts and overlaps.</p>
            </div>
            <div class="service-b">
               <h3>⭐ Event Hosting</h3>
                <p>Enjoy a professional and well-maintained venue that can accommodate both small gatherings and large tournaments.</p>
                <p>Use the gym for basketball events, competitions, and school activities with hassle-free coordination.</p>
            </div>
            <img src="{{ asset('system-images/d.png') }}" alt="Login Image" class="ss-img">
       </div>

@endsection