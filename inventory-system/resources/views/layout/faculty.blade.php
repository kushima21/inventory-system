<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/faculty.css', 'resources/js/app.js'])
</head>
<body>
    @php
    $user = \App\Models\User::find(session('user_id'));
    @endphp
    <div class="faculty-main-container">
        <div class="left-side-container">
            <div class="side-bar-header">
                <h2>Inventory Booking System</h2>
            </div>
            <div class="user-container" onclick="toggleUserSettings()">
                <img src="{{ asset('system-images/user.png') }}" alt="" class="user-image">
                <div class="user-info">
                    @if($user)
                        <h2>{{ $user->name }}</h2>
                        <p>#ID: {{ $user->id }}</p>
                    @else
                        <h3 class="f-header">Guest</h3>
                        <p>No account info available</p>
                    @endif
                </div>  
            </div>
            <div class="user-settings" id="userSettings">
                <a href="{{ url('/faculty/facultyProfile') }}">
                    <div class="setting-info">Profile Modification</div>
                </a>
                 <a href="{{ route('logout') }}">
                    <div class="setting-info">Sign-out</div>
                </a>
            </div>
            <div class="overview-container">
                <a href="{{ url('/faculty/facultyDashboard') }}">
                    <i class="fa-solid fa-house"></i>
                    <h2>Dashboard Overview</h2>
                </a>
            </div>
            <div class="sidebar-links">
                <span class="link-title">MANAGE</span>
                <a href="{{ url('/faculty/facultyRequest') }}">
                    <div class="link-item">
                        <i class="fa-solid fa-box-open"></i>
                        <span>Request Supplies</span>
                    </div>
                </a>
                <a href="{{ url('/faculty/facultyMyRequest') }}">
                    <div class="link-item">
                        <i class="fa-solid fa-file-lines"></i>
                        <span>My Request</span>
                    </div>
                </a>
            </div>
        </div>

        <div class="right-side-container">
            <div class="right-header"></div>
            <div class="request-main-container">
                 @yield ('content')
            </div>
        </div>

    </div>
    <script>
function toggleUserSettings() {
    const settings = document.getElementById("userSettings");
    settings.style.display = (settings.style.display === "flex") ? "none" : "flex";
}
</script>
</body>
</html>