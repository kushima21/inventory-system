<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/index.css', 'resources/js/app.js'])
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
        <div class="content-container">
             <div class="welcome-container">
                <h2 class="w-h">Welcome to LSSTI Basketball Gym Reservation!</h2>
                <p class="w-p">
                    Experience the convenience of reserving your basketball court anytime and anywhere. 
                    With just a few clicks, you can schedule your games, avoid conflicts, and focus on 
                    enjoying the sport you love. Whether for practice, friendly matches, or tournaments, 
                    LSSTI makes your hoop sessions smooth and hassle-free.
                </p>
                <a href="{{ url('/login') }}">
                    <button type="button" class="w-btn">Sign in</button>
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