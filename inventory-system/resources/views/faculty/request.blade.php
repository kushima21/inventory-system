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

    <div class="request-main-container">
        <div class="table-container">
            <table class="table-supplies-container">
                <thead>
                <tr>
                    <th>Supplies</th>
                    <th>Available</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Bondpaper</td>
                        <td>12</td>
                        <td>
                            <button class="RequestBtn" type="button">
                                Request Supplied
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection