<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
     @vite(['resources/css/index.css', 'resources/js/app.js'])
     @vite(['resources/css/contact.css', 'resources/js/app.js'])
         @vite(['resources/css/responsived.css', 'resources/js/app.js'])
         <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.10.1/lottie.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
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

        <div class="contact-header-container">
            <h2 class="contact-h">Contact Us</h2>
            <div class="icon-c">
                <img src="{{ asset('icons/facebook.png') }}" alt="Login Image" class="icon-img">
                <img src="{{ asset('icons/youtube.png') }}" alt="Login Image" class="icon-img">
                <img src="{{ asset('icons/facebook-messenger.png') }}" alt="Login Image" class="icon-img">
                <img src="{{ asset('icons/github.png') }}" alt="Login Image" class="icon-img">
                <img src="{{ asset('icons/clip-mail.png') }}" alt="Login Image" class="icon-img">
                <img src="{{ asset('icons/instagram.png') }}" alt="Login Image" class="icon-img">
            </div>
        </div>

        <div class="email-form-container">
            <img src="{{ asset('system-images/email.png') }}" alt="Login Image" class="form-img">
            <div class="form-c">
                <form method="POST" action="">
                    @csrf
                    <label for="fullname">Full Name*</label>
                    <input type="text" name="fullname" id="fullname" placeholder="Enter your name..." required>

                    <label for="email">Email Address*</label>
                    <input type="text" name="email" id="email" placeholder="Enter your email address..." required>

                    <label for="cnum">Contact Number*</label>
                    <input type="tel" name="cnum" id="cnum" placeholder="Enter your contact number..." required> 

                    <label for="message">Message*</label>
                    <textarea name="message" id="message" placeholder="Type your message here..." required></textarea>

                    <button type="submit" class="formBTn">Sent message <i class="fas fa-arrow-right"></i></button>
                </form>
            </div>
            <div class="form-details">
                <h2 class="d-header">We are here to help!</h2>
                <p class="d-description">
                Need a place to play? Our basketball gym is available for your games, practice sessions, and events. Whether you’re organizing a friendly match or hosting a tournament, we make reservations quick and easy. Book your spot now and enjoy a well-maintained court designed for the ultimate basketball experience!
                </p>
                <img src="{{ asset('system-images/bb.png') }}" alt="Login Image" class="f-img">

            </div>
        </div>

    <div class="map-main-box">
        <img src="{{ asset('system-images/cc.png') }}" alt="Login Image" class="c-img">
        <div class="map-container">
            <h2 class="o-location">Our Location!</h2>
            <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d251.335879241891!2d123.7733437!3d7.9362892!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x325434e454c9e4c1%3A0xe9997d895253d797!2sAbaga%20Central%20Elementary%20School!5e1!3m2!1sen!2sph!4v1692354000000!5m2!1sen!2sph"
            width="100%"
            height="400"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
            </iframe>
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
<script>
  function initMap() {
    const location = { lat: 7.9359997, lng: 123.7738628 }; // Abaga Central Elementary School

    const map = new google.maps.Map(document.getElementById('map'), {
      center: location,
      zoom: 18
    });

    new google.maps.Marker({
      position: location,
      map: map,
      title: "Abaga Central Elementary School"
    });
  }
</script>

</body>
</html>