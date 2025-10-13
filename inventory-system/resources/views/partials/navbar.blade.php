<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/navbar.css', 'resources/js/app.js'])
    @vite(['resources/css/responsived.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.10.1/lottie.min.js"></script>
</head>
<body>
 <div class="content-main-container">
    @php
$user = \App\Models\User::find(session('user_id'));
@endphp

    <div class="navBar-container">
        <nav class="nav-links">
            <ul>
                <li><a href="{{ url('/customers/home') }}">
                    <video autoplay loop muted playsinline>
                        <source src="{{ asset('icons/home.mp4') }}" type="video/mp4">
                    </video>
                    <span class="link">Home</span>
                </a></li>
                
                <li><a href="{{ url('/customers/userAbout') }}">
                    <video autoplay loop muted playsinline>
                        <source src="{{ asset('icons/info.mp4') }}" type="video/mp4">
                    </video>
                    <span class="links">About Us</span>
                </a></li>
                
                <li><a href="{{ url('/customers/userBook') }}">
                    <video autoplay loop muted playsinline>
                        <source src="{{ asset('icons/book-now.mp4') }}" type="video/mp4">
                    </video>
                    <span class="links">Booking</span>
                </a></li>
                
                <li><a href="{{ url('/customers/userContact') }}">
                    <video autoplay loop muted playsinline>
                        <source src="{{ asset('icons/contact.mp4') }}" type="video/mp4">
                    </video>
                    <span class="links">Contact Us</span>
                </a></li>
                
                <li><a href="{{ url('/customers/userServices') }}">
                    <video autoplay loop muted playsinline>
                        <source src="{{ asset('icons/helpdesk.mp4') }}" type="video/mp4">
                    </video>
                    <span class="links">Services</span>
                </a></li>
                
                <li>
                    <img src="{{ asset('icons/notification.png') }}" alt="Notif Image" class="notif-img">
                </li>
                
                <li>
                    <img src="{{ asset('icons/profile.png') }}" alt="Profile Image" class="profile-img">
                </li>
            </ul>
        </nav>
    </div>
    <div class="notif-modal-container">
        <div class="notif-modal">
            <h2>dadad</h2>
        </div>
    </div>
    <div class="modal-background">
        <div class="profile-modal">
            <div class="profile-container">
                <ul class="p-list">
                    <li>
                        <a href="{{ url('/customers/profile') }}">
                            Profile Modification
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/customers/bookRequest') }}">
                            Booking Request
                        </a>
                    </li>
                    <li>
                        <form id="logoutForm" method="POST" action="{{ route('navLogout') }}">
                        @csrf
                        <button type="submit" class="link-box" style="background:none; border:none; cursor:pointer;">
                            <h3>Logout</h3>
                        </button>
                    </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-content-container-box">
        @yield ('content')
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const notifImg = document.querySelector(".profile-img");
    const notifModal = document.querySelector(".modal-background");

    notifImg.addEventListener("click", function () {
        // toggle display
        if (notifModal.style.display === "flex") {
            notifModal.style.display = "none";
        } else {
            notifModal.style.display = "flex";
        }
    });

    // i-close kung mo-click sa gawas sa modal
    window.addEventListener("click", function (e) {
        if (e.target === notifModal) {
            notifModal.style.display = "none";
        }
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const notifImg = document.querySelector(".notif-img");
    const notifModal = document.querySelector(".notif-modal-container");

    notifImg.addEventListener("click", function () {
        // toggle display
        if (notifModal.style.display === "flex") {
            notifModal.style.display = "none";
        } else {
            notifModal.style.display = "flex";
        }
    });

    // i-close kung mo-click sa gawas sa modal
    window.addEventListener("click", function (e) {
        if (e.target === notifModal) {
            notifModal.style.display = "none";
        }
    });
});
</script>

</body>
</html>