@extends('partials.navbar')
@vite(['resources/css/sideBar.css', 'resources/js/app.js'])
@php
$user = \App\Models\User::find(session('user_id'));
@endphp
@section('content')
    <div class="sideBar-main-Container">
        <div class="main-bar-container">
            <div class="left-b-container">
                <div class="l-h-container">
                    <img src="{{ asset('icons/basket-ball.png') }}" alt="basket Image" class="ball-img">
                    <h3 class="l-header">
                        LSSTI Basketball Gym Reservation
                    </h3>
                </div>
                <div class="l-m-container">
                    <div class="link-c">
                        <a href="{{ url('/customers/profile') }}">
                            <div class="link-box">
                                <img src="{{ asset('icons/profile.png') }}" alt="Profile Image" class="user-image">
                                <h3>Profile Modification</h3>
                               
                            </div>
                        </a>
                        <a href="{{ route('bookings.list') }}">
                            <div class="link-box">
                                <img src="{{ asset('icons/booking.png') }}" alt="Profile Image" class="user-image">
                                <h3>Booking Request</h3>
                            </div>
                        </a>

                    </div>
                </div>

            </div>
            <div class="right-b-container">
                @yield ('Sidecontent')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const logoutBtn = document.getElementById('logoutBtn');
    const logoutForm = document.getElementById('logoutForm');

    logoutBtn.addEventListener('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure you want to logout?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, logout'
        }).then((result) => {
            if (result.isConfirmed) {
                logoutForm.submit(); // submit POST logout
            }
        });
    });
</script>
@endsection