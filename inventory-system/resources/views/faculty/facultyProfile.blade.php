@extends('layout.faculty')
@vite(['resources/css/faculty.css', 'resources/js/app.js'])
<link rel="stylesheet" href="{{ asset('resources/css/faculty.css') }}">
@php
$user = \App\Models\User::find(session('user_id'));
@endphp
@section('content')
    <div class="faculty-profile-main-container">
        <h2 class="faculty-profile-header">
            Welcome, {{ $user->name ?? '' }}
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
                           {{ $user->name ?? '' }}
                        </h3>
                        <p class="email-header">{{ $user->email ?? '' }}</p>
                    </div>
                </div>
                <div class="faculty-form-modification-container">
    <form action="{{ route('faculty.updateProfile', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-modification-container">
            <div class="form-box">
                <div class="faculty-info">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ $user->name ?? '' }}">
                </div>
                <div class="faculty-info">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Leave blank to keep current password">
                </div>
            </div>
            <div class="form-box">
                <div class="faculty-info">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" name="phone_number" id="phone_number" value="{{ $user->phone_number ?? '' }}">
                </div>
                <div class="faculty-info">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" value="{{ $user->email ?? '' }}">
                </div>
                <div class="faculty-info">
                    <button type="submit" name="submit">
                        Save Changes
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
                    <h3 class="email">{{ $user->email ?? '' }}</h3>
                </div>
            </div>
        </div>
    </div>
@endsection