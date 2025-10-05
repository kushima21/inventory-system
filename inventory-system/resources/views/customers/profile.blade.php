@extends('partials.sideBar')
@vite(['resources/css/profile.css', 'resources/js/app.js'])
@php
    $user = \App\Models\User::find(session('user_id'));
@endphp

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
                            <button type="submit" name="submit" class="edit-Btn">Edit</button>
                        </div>
                        <div class="form-modification-container">
                            <form action="">
                                <div class="f-m-container">
                                    <div class="info-user">
                                        <label for="name">Fullname</label>
                                        <input type="text" name="name" id="name" placeholder="Name" value="{{ $user->name ?? '' }}">
                                    </div>
                                    <div class="info-user">
                                        <label for="phone_number">Phone Number</label>
                                        <input type="text" name="name" id="name" placeholder="Name" value="{{ $user->phone_number ?? '' }}">
                                    </div>
                                    <div class="info-user">
                                        <label for="address">Address</label>
                                        <input type="text" name="address" id="address" placeholder="Address">
                                    </div>
                                    <div class="info-user">
                                        <label for="email">Email</label>
                                        <input type="text" name="name" id="name" placeholder="Name" value="{{ $user->email ?? '' }}">

                                    </div>
                                    <div class="info-user">
                                        <label for="password">Password</label>
                                        <input type="text" name="name" id="name" placeholder="Name" value="{{ $user->password ?? '' }}">
                                    </div>
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
                             <h3>{{ $user->password ?? '' }}</h3>
                        </div>
                </div>
@endsection