<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/login.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


</head>
<body>
    <div class="login-main-container">
        <div class="login-main-box">
            <p class="created">Just Shipped v1.2025.01 <span class="arrow">></span></p>
            <div class="login-header">
                <h2 class="first-header">Sign in to your LSSTI Booking</h2>
                <h2  class="second-header">Account</h2>

                <div class="login-form-container">
                    <div class="login-form-box">
                        <form method="POST" action="">
                            @csrf 
                            <div class="form-info">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" placeholder="Email" required>
                            </div>
                            <div class="form-info">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" placeholder="Password" required>
                            </div>
                            <div class="formBtn">
                                <button type="submit" name="submit">Sign in now</button>
                            </div>
                            <p class="or">--------or create account--------</p>
                            <div class="createBtn">
                                <a href="{{ url('/signup') }}"><button type="button">Sign up now</button></a>
                            </div>
                            <div class="home">
                            <a href="{{ route('home') }}" class="home-link">
                                <i class="fa-solid fa-arrow-left"></i>
                                Go back Home
                            </a>
                            </div>
                            <div class="term-condition">
                                <p>By clicking “Sign in”, you agree to our <span>Terms of Service</span> and <span> Statement</span> . We’ll occasionally send you account related emails.</p>
                            </div>
                            <div class="footer">
                                <p>
                                <span>LSSTI Network</span> is a trademark of group choy
                                Copyright © 2025-2026 LSSTI Technologies...</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
        <div class="login-image">
            <img src="{{ asset('system-images/login_image.png') }}" alt="Login Image">
        </div>
    </div>
</body>
</html>