<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/default.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('resources/css/default.css') }}">
</head>
<body>
     @php
$user = \App\Models\User::find(session('user_id'));
@endphp
    <div class="container">

        <div class="sidebar-container">
            <div class="sidebar-header">
                <h2>Inventory Booking System</h2>
            </div>
            <div class="user-container" id="userContainer">
                <img src="{{ asset('system-images/user.png') }}" alt="" class="user-image">
                <div class="user-info">
                    <h2>{{ $user->name }}</h2>
                    <p>ID#: {{ $user->id }}</p>
                </div>
            </div>
            <div class="user-modified-modal" id="userModal">
                <div class="user-box-m">
                    <a href="#">
                        <div class="user-box">
                            <p>Profile Modification</p>
                        </div>
                    </a>
                    <a href="{{ route('logout') }}">
                        <div class="user-box">
                            <p>Logouts</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="overview-container">
                <a href="{{ url('/settings/dashboard') }}">
                    <h2>Dashboard Overview</h2>
                </a>
            </div>
            <div class="sidebar-links">
                <span class="link-title">MANAGE</span>
                <div class="">
                <a href="{{ url('/settings/requestSupply') }}">
                    <div class="link-item">
                        <i class="fa-solid fa-house"></i>
                        <span>Request Supplies</span>
                    </div>
                </a>
                <a href="{{ url('/settings/gym_reservation') }}">
                    <div class="link-item">
                        <i class="fa-solid fa-house"></i>
                        <span>Facilities Reservation</span>
                    </div>
                </a>
                 <a href="{{ url('/settings/inventory') }}">
                    <div class="link-item">
                        <i class="fa-solid fa-house"></i>
                        <span>Inventory</span>
                    </div>
                </a>
                <a href="{{ url('/settings/reports') }}">
                    <div class="link-item">
                        <i class="fa-solid fa-house"></i>
                        <span>Facilities Reports</span>
                    </div>
                </a>
                <a href="{{ url('/settings/supplyReports') }}">
                    <div class="link-item">
                        <i class="fa-solid fa-house"></i>
                        <span>Supply Reports</span>
                    </div>
                </a>
                <span class="link-title">SETTINGS</span>
                <a href="{{ url('/settings/gym') }}">
                    <div class="link-item">
                        <i class="fa-solid fa-house"></i>
                        <span>Facilities Section</span>
                    </div>
                </a>
                <a href="{{ url('/settings/equipment') }}">
                    <div class="link-item">
                        <i class="fa-solid fa-house"></i>
                        <span>Equipment Section</span>
                    </div>
                </a>
                <span class="link-title">ACCOUNT</span>
                <a href="{{ url('/settings/users') }}">
                    <div class="link-item">
                        <i class="fa-solid fa-house"></i>
                        <span>Personnels</span>
                    </div>
                </a>
                </div>
            </div>
        </div>

        <div class="content-container">
            <div class="content-header"></div>
            <div class="container-container-box">
                 @yield ('content')
            </div>
        </div>
        
    </div>
    <script>
document.addEventListener('DOMContentLoaded', () => {
    const userContainer = document.getElementById('userContainer');
    const userModal = document.getElementById('userModal');

    // Toggle modal visibility on click
    userContainer.addEventListener('click', () => {
        userModal.classList.toggle('active');
    });

    // Optional: hide modal when clicking outside
    document.addEventListener('click', (event) => {
        if (!userContainer.contains(event.target) && !userModal.contains(event.target)) {
            userModal.classList.remove('active');
        }
    });
});
</script>
</body>
</html>