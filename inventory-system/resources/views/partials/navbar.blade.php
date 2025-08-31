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
    <div class="navBar-container">
        <nav class="nav-links">
            <ul>
                <li><a href="{{ url('/home') }}">
                    <video autoplay loop muted playsinline>
                        <source src="{{ asset('icons/home.mp4') }}" type="video/mp4">
                    </video>
                    <span class="link">Home</span>
                </a></li>
                
                <li><a href="{{ url('/userAbout') }}">
                    <video autoplay loop muted playsinline>
                        <source src="{{ asset('icons/info.mp4') }}" type="video/mp4">
                    </video>
                    <span class="links">About Us</span>
                </a></li>
                
                <li><a href="#">
                    <video autoplay loop muted playsinline>
                        <source src="{{ asset('icons/book-now.mp4') }}" type="video/mp4">
                    </video>
                    <span class="links">Booking</span>
                </a></li>
                
                <li><a href="{{ url('/userContact') }}">
                    <video autoplay loop muted playsinline>
                        <source src="{{ asset('icons/contact.mp4') }}" type="video/mp4">
                    </video>
                    <span class="links">Contact Us</span>
                </a></li>
                
                <li><a href="{{ url('/userServices') }}">
                    <video autoplay loop muted playsinline>
                        <source src="{{ asset('icons/helpdesk.mp4') }}" type="video/mp4">
                    </video>
                    <span class="links">Services</span>
                </a></li>
                
                <li>
                    <img src="{{ asset('icons/notification.png') }}" alt="Notif Image" class="notif-img">
                    <div class="notif-modal"></div>
                </li>
                
                <li>
                    <img src="{{ asset('icons/profile.png') }}" alt="Profile Image" class="profile-img">
                </li>
            </ul>
        </nav>
    </div>
    <div class="modal-background">
        <div class="profile-modal">
        </div>
    </div>
    <div class="main-content-container-box">
        @yield ('content')
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const profileImg = document.querySelector(".profile-img");
    const profileModal = document.querySelector(".profile-modal");

    // Toggle modal on profile image click
    profileImg.addEventListener("click", function (e) {
        e.stopPropagation();
        const isVisible = profileModal.style.display === "block";
        profileModal.style.display = isVisible ? "none" : "block";
    });

    // Hide modal when clicking outside
    document.addEventListener("click", function (e) {
        if (!profileModal.contains(e.target) && !profileImg.contains(e.target)) {
            profileModal.style.display = "none";
        }
    });
});
</script>
</body>
</html>