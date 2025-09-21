<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/index.css', 'resources/js/app.js'])
    @vite(['resources/css/book.css', 'resources/js/app.js'])
    @vite(['resources/css/responsived.css', 'resources/js/app.js'])

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


       <!-- Nav close -->

       <div class="main-booking-container">
            <h2 class="book-header">
                " Basketball Court Reservations Made Easy "
            </h2>
            <p class="book-p">Find the perfect time to play and secure your slot in just a few clicks.</p>
            <h2 class="offer-header">
                Play & Book Packages:
            </h2>

            <div class="booking-box-container">

               <div class="booking-box">
                    <h2 class="book-h">All Star Premium Packages</h2>
                    <h3 class="list-item">List of Items Offer :</h3>
                    <ul class="items-list">
                        <li>LED - <span>10 pieces</span></li>
                        <li>Table - <span>10 pieces</span></li>
                        <li>Chairs - <span>10 pieces</span></li>
                        <li>Speaker - <span>10 pieces</span></li>
                        <li>Fan - <span>10 pieces</span></li>
                        <li>GameBoard - <span>10 pieces</span></li>
                    </ul>
                    <a href="{{ url('/login') }}">
                    <div class="book-btn">
                        <button type="button">Book Now</button>
                    </div>
                    </a>
                </div>
                <div class="booking-box">
                    <h2 class="book-h">All Star Premium Packages</h2>
                    <h3 class="list-item">List of Items Offer :</h3>
                    <ul class="items-list">
                        <li>LED - <span>10 pieces</span></li>
                        <li>Table - <span>10 pieces</span></li>
                        <li>Chairs - <span>10 pieces</span></li>
                        <li>Speaker - <span>10 pieces</span></li>
                        <li>Fan - <span>10 pieces</span></li>
                        <li>GameBoard - <span>10 pieces</span></li>
                    </ul>
                    <a href="{{ url('/login') }}">
                    <div class="book-btn">
                        <button type="button">Book Now</button>
                    </div>
                    </a>
                </div>
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