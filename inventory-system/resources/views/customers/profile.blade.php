@extends('partials.sideBar')
@vite(['resources/css/profile.css', 'resources/js/app.js'])
@php
    $user = \App\Models\User::find(session('user_id'));
@endphp
<link rel="stylesheet" href="{{ asset('resources/css/profile.css') }}">
@section('Sidecontent')
<h2 class="profile-header">
    Profile Modification
</h2>
<div class="profile-information-c">
    <div class="profile-head-c">
        <div class="p-header-m-container">
            <img src="{{ asset('icons/profile.png') }}" alt="Profile Image" class="p-edit-image">

            <div class="f-email-container">
                @if($user)
                <h3 class="f-header">{{ $user->name }}</h3>
                <p>{{ $user->email }}</p>
                @else
                    <h3 class="f-header">Guest</h3>
                    <p>No account info available</p>
                @endif
            </div>
        </div>
    </div>

    <div class="form-modification-container">
        <form action="{{ route('user.update', ['id' => $user->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="f-m-container">
                <div class="info-user">
                    <label for="name">Fullname</label>
                    <input type="text" name="name" id="name" placeholder="Name" value="{{ $user->name ?? '' }}" required>
                </div>
                <div class="info-user">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" name="phone_number" id="phone_number" placeholder="Phone Number" value="{{ $user->phone_number ?? '' }}" required>
                </div>
                <div class="info-user">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email" value="{{ $user->email ?? '' }}" required>
                </div>
                <div class="info-user">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="New Password (leave blank to keep)">
                </div>
            </div>

            <div class="info-btn">
                <button type="submit" class="edit-Btn" name="submit">Save Changes</button>
            </div>
        </form>
    </div>

    <h3 class="my-email">
        My email Address
    </h3>
    <div class="m-email-c">
         <video autoplay loop muted playsinline class="email-g">
            <source src="{{ asset('icons/email.mp4') }}" type="video/mp4">
         </video>
         <h3>{{ $user->email ?? '' }}</h3>
    </div>
</div>
@endsection
