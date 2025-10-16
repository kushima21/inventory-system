@extends('layout.faculty')
@vite(['resources/css/faculty.css', 'resources/js/app.js'])

@section('content')
    <div class="faculty-profile-main-container">
        <h2 class="faculty-profile-header">
            Welcome, Hondrada
        </h2>
        <h3 class="faculty-date-header">
            Tuesday, 15 October 2025
        </h3>
        <div class="faculty-container-main-box">
            <div class="faculty-container-box">
                <div class="faculty-header-box-container">
                    <img src="{{ asset('system-images/user.png') }}" alt="Login Image" class="img-c">
                    <div class="faculty-name-c">
                        <h3 class="name-header">
                            John Mark Hondrada
                        </h3>
                        <p class="email-header">johnmarkhondrada@ckcm.edu.ph</p>
                    </div>
                </div>
                <div class="faculty-form-modification-container">
                    <form action="" method="POST">
                        @csrf
                        <div class="form-modification-container">
                            <div class="form-box">
                                <div class="faculty-info">
                                    <label for="name">Full Name</label>
                                    <input type="text" name="name" id="name">
                                </div>
                                <div class="faculty-info">
                                    <label for="name">Address</label>
                                    <input type="text" name="name" id="name">
                                </div>
                                <div class="faculty-info">
                                    <label for="name">Password</label>
                                    <input type="text" name="name" id="name">
                                </div>
                            </div>
                            <div class="form-box">
                                <div class="faculty-info">
                                    <label for="name">Phone Number</label>
                                    <input type="text" name="name" id="name">
                                </div>
                                <div class="faculty-info">
                                    <label for="name">Email</label>
                                    <input type="text" name="name" id="name">
                                </div>
                                <div class="faculty-info">
                                    <button type="button" name="submit" >
                                        Edit 
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <h3 class="e-subheader">
                    My Email Address
                </h3>
                <div class="e-container">
                    <video autoplay loop muted playsinline class="email-g">
                        <source src="{{ asset('icons/email.mp4') }}" type="video/mp4">
                    </video>
                    <h3 class="email">johnmarkhondrada@ckcm.edu.ph</h3>
                </div>
            </div>
        </div>
    </div>
@endsection