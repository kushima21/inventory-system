<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/default.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container">

        <div class="sidebar-container">
            <div class="sidebar-header">
                <h2>Inventory Booking System</h2>
            </div>
            <div class="user-container">
                <img src="{{ asset('system-images/user.png') }}" alt="" class="user-image">
                <div class="user-info">
                    <h2>Hondrada John Mark</h2>
                    <p>ID#: 0211</p>
                </div>
            </div>
            <div class="overview-container">
                <a href="#">
                    <h2>Dashboard Overview</h2>
                </a>
            </div>
            <div class="sidebar-links">
                <span class="link-title">MANAGE</span>
                <div class="">
                <a href="#">
                    <div class="link-item">
                        <i class="fa-solid fa-house"></i>
                        <span>Request Supplies</span>
                    </div>
                </a>
                <a href="#">
                    <div class="link-item">
                        <i class="fa-solid fa-house"></i>
                        <span>Gym Reservation</span>
                    </div>
                </a>
                 <a href="#">
                    <div class="link-item">
                        <i class="fa-solid fa-house"></i>
                        <span>Inventory</span>
                    </div>
                </a>
                <a href="#">
                    <div class="link-item">
                        <i class="fa-solid fa-house"></i>
                        <span>Reports</span>
                    </div>
                </a>
                <span class="link-title">SETTINGS</span>
                <a href="#">
                    <div class="link-item">
                        <i class="fa-solid fa-house"></i>
                        <span>Supplies Section</span>
                    </div>
                </a>
                <a href="#">
                    <div class="link-item">
                        <i class="fa-solid fa-house"></i>
                        <span>Gym Section</span>
                    </div>
                </a>
                <a href="#">
                    <div class="link-item">
                        <i class="fa-solid fa-house"></i>
                        <span>ICT Section</span>
                    </div>
                </a>
                <span class="link-title">ACCOUNT</span>
                <a href="#">
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
</body>
</html>