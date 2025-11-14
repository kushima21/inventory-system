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
<link rel="stylesheet" href="{{ asset('resources/css/responsived.css') }}">
<link rel="stylesheet" href="{{ asset('resources/css/book.css') }}">
<link rel="stylesheet" href="{{ asset('resources/css/index.css') }}">

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
            <div class="ball-image">
                <img src="{{ asset('icons/basket-ball.png') }}" alt="basket Image" class="ball-img">
                <h2 class="book-header">
                " Facilities Reservations Made Easy "
                </h2>
                <p class="book-p">Find the perfect time to play and secure your slot in just a few clicks.</p>
                <h2 class="offer-header">
                    Play & Book Packages:
                </h2>
            </div>

                <div class="booking-box-container">

                @foreach($gyms as $gym)
                        <div class="booking-box">
                            <h2 class="book-h">{{ $gym->package }}</h2>
                            <h3 class="b-h">
                                Price : ₱{{ number_format($gym->price, 2) }}
                        </h3>
                        <h3 class="list-item">List of Items Offer :</h3>
                        <ul class="items-list">
                            @forelse($gym->equipment as $equipment)
                                <li>
                                    {{ $equipment->pivot->quantity }}
                                    <span>-</span>
                                    {{ $equipment->equipment }}
                                </li>
                            @empty
                                <li>No equipment included in this packa ge.</li>
                            @endforelse
                        </ul>
                        <a href="{{ url('/login') }}">
                            <div class="b-btn">
                                <button type="button">Book Now</button>
                            </div>
                        </a>
                    </div>
                @endforeach

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