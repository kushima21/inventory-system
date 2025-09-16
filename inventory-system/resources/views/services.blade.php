<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/index.css', 'resources/js/app.js'])
    @vite(['resources/css/services.css', 'resources/js/app.js'])
    @vite(['resources/css/responsived.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.10.1/lottie.min.js"></script>
</head>
<body>
    <div class="content-main-container">

        <div class="navBar-container">
             <nav class="nav-links">
                <ul>
                    <a href="/">
                        <li><video autoplay loop muted playsinline>
                        <source src="{{ asset('icons/home.mp4') }}" type="video/mp4">
                        </video>
                        <span class="link">Home</span>
                        <li>
                    </a>
                    <a href="{{ url('/about') }}">
                        <li><video autoplay loop muted playsinline>
                        <source src="{{ asset('icons/info.mp4') }}" type="video/mp4">
                        </video>
                        <span class="links">About Us</span>
                        <li>
                    </a>
                    <a href="{{ url('/book') }}">
                        <li><video autoplay loop muted playsinline>
                        <source src="{{ asset('icons/book-now.mp4') }}" type="video/mp4">
                        </video>
                        <span class="links">Booking</span>
                        <li>
                    </a>
                    <a href="{{ url('/contact') }}">
                        <li><video autoplay loop muted playsinline>
                        <source src="{{ asset('icons/contact.mp4') }}" type="video/mp4">
                        </video>
                        <span class="links">Contact  Us</span>
                        <li>
                    </a>
                    <a href="{{ url('/services') }}">
                        <li><video autoplay loop muted playsinline>
                        <source src="{{ asset('icons/helpdesk.mp4') }}" type="video/mp4">
                        </video>
                        <span class="links">Services</span>
                        <li>
                    </a>
                </ul>
            </nav>
             <div class="menuBar">
                <video autoplay loop muted playsinline id="menuVideo">
                <source src="{{ asset('icons/list.mp4') }}" type="video/mp4">
                </video>
            </div>
            <div class="contentBtn" id="responsiveContentBtn">
                <a href="{{ url('/login') }}">
                    <button type="button" class="primBtn">Sign in</button>
                </a>
                <a href="{{ url('/signup') }}"><button type="button" class="primBtn">Sign Up</button></a>
            </div>
       </div>

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
                <h3>🏀 Court Booking</h3>
                <p>Reserve basketball courts quickly and easily through our online system—no more waiting in long lines.</p>
                <p>Secure your preferred time slot in advance and enjoy a smooth basketball experience without the hassle of walk-ins.</p>
            </div>
            <img src="{{ asset('system-images/s.png') }}" alt="Login Image" class="s-img">
            <div class="service-b">
                <h3>👥 Team Reservations</h3>
                <p>Ensure your team has a guaranteed court time, making coordination easier and games more enjoyable.</p>
                <p>Book slots for your whole team, whether it’s for practice, friendly matches, or official tournaments.</p>
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

    </div>

<script>
    const menuVideo = document.getElementById('menuVideo');
    const responsiveContent = document.getElementById('responsiveContentBtn');

    menuVideo.addEventListener('click', () => {
        if (responsiveContent.style.display === "flex") {
            responsiveContent.style.display = "none";
        } else {
            responsiveContent.style.display = "flex";
        }
    });
</script>
</body>
</html>