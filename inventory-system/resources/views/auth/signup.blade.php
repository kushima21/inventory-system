<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/signup.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.10.1/lottie.min.js"></script>
</head>
<body>
    <div class="signup-container">
        <div class="signup-box-container">
            <p class="created">Just Shipped v1.2025.01 <span class="arrow">></span></p>
            <div class="signup-header">
                <h2 class="first-header">Create your LSSTI Booking </h2>
                <h2  class="second-header">Account</h2>
            </div>
            <div class="login-form-box">
                    <form method="POST" action="{{ route('signup.store') }}">
                        @csrf
                        <div class="form-info">
                            <label for="fullname">Full Name</label>
                            <input type="text" name="name" id="name" placeholder="Enter your full name..." required>
                        </div>
                        <div class="form-info">
                            <label for="phone_number">Phone Number:</label>
                            <input type="text" name="phone_number" id="phone_number" placeholder="Enter your phone number..." maxlength="11" pattern="\d{11}" required>
                        </div>
                        <div class="form-info">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" placeholder="Enter your email..." required>
                        </div>
                        <div class="form-info">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" placeholder="Enter your password..." required> 
                        </div>
                        <div class="form-info">
                            <label for="password">Confirm Password</label>
                           <input type="password" name="password_confirmation" id="confirm_password" placeholder="Confirm password..." required>
                            <p id="password-error" style="color:red; display:none; font-size:14px;">Passwords do not match</p>
                        </div>
                        <input type="hidden" name="roles" id="roles" value="Customers">
                        <div class="formBtn">
                            <button type="submit" name="submit">Create Account</button>
                        </div>
                            <p class="or">--------or sign in your account--------</p>
                        <div class="createBtn">
                            <a href="{{ url('/login') }}"><button type="button">Sign in now</button></a>
                        </div>
                        
                        {{-- Success Message --}}
                        @if (session('success'))
                            <div class="success-message" style="margin-top:10px; font-size: 11px; padding:10px; color:#155724;">
                                {{ session('success') }}
                            </div>
                        @endif
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
        <div class="signup-img">
            <img src="{{ asset('system-images/signup.png') }}" alt="Login Image" class="sign-img">
        </div>
    </div>
<script>
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm_password");
    const errorMsg = document.getElementById("password-error");
    const submitBtn = document.getElementById("submitBtn");

    confirmPassword.addEventListener("input", function () {
        if (confirmPassword.value !== password.value) {
            confirmPassword.style.borderColor = "red";
            errorMsg.style.display = "block";
            submitBtn.disabled = true;
        } else {
            confirmPassword.style.borderColor = "green";
            errorMsg.style.display = "none";
            submitBtn.disabled = false;
        }
    });
</script>
</body>
</html>