@extends('faculty.facultyDashboard')

@vite(['resources/css/request.css', 'resources/js/app.js'])

@section('content')
    <div class="request-second-header">
        <div class="header">
            <h2>Request Section</h2>
            <form method="POST" action="">
                <input type="text" name="supplies" id="searchSuplies" placeholder="Search....">
            </form>
        </div>
    </div>
    <div class="request-main-container-box">
        <div class="supplies-main-container-box">
            
        </div>
    </div>
@endsection