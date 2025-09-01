<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/index.css', 'resources/js/app.js'])
    @vite(['resources/css/about.css', 'resources/js/app.js'])
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
                    <a href="#">
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
