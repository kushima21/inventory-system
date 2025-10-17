@extends('layout.default')
@vite(['resources/css/settings.css', 'resources/js/app.js'])
@vite(['resources/css/reports.css', 'resources/js/app.js'])
@section('content')
    <div class="main-request-overview-dashbaord-c">
        <h2 class="request-main-header">
            Faculty Request Dashboard
        </h2>
         <p class="p-head">View and manage all faculty supply requests in one place.</p>
         <div class="request-main-box-container">
            <div class="request-box">
                <img src="{{ asset('icons/total.png') }}" alt="Login Image" class="request-image">
                 <h3 class="request-subheader">Total Supply Request</h3>
                 <div class="report-number">
                    <img src="{{ asset('icons/confirmed-user.png') }}" alt="Login Image" class="r-image">
                    <h3 class="number">14.00</h3>
                 </div>
            </div>
            <div class="request-box">
                <img src="{{ asset('icons/chart-line-up.png') }}" alt="Login Image" class="request-image">
                 <h3 class="request-subheader">Awaiting Request Confirmation</h3>
                 <div class="report-number">
                    <img src="{{ asset('icons/users.png') }}" alt="Login Image" class="r-image">
                    <h3 class="number">14.00</h3>
                 </div>
            </div>
            <div class="request-box">
                <img src="{{ asset('icons/delete-user.png') }}" alt="Login Image" class="request-image">
                 <h3 class="request-subheader">Cancelled Supply Requests</h3>
                 <div class="report-number">
                    <img src="{{ asset('icons/circle-wrong.png') }}" alt="Login Image" class="r-image">
                    <h3 class="number">14.00</h3>
                 </div>
            </div>
            <div class="request-box">
                <img src="{{ asset('icons/delete-document.png') }}" alt="Login Image" class="request-image">
                 <h3 class="request-subheader">Unapproved Supply Requests</h3>
                 <div class="report-number">
                    <img src="{{ asset('icons/user-forbidden-alt.png') }}" alt="Login Image" class="r-image">
                    <h3 class="number">14.00</h3>
                 </div>
            </div>
         </div>
         <h3 class="list-f-header">
            Faculty Supply Request List
         </h3>
         <select name="" class="filter-r-status">
            <option value="">Filtering Request Status</option>
            <option value="Pending">Pending Request</option>
            <option value="Approved">Approved</option>
            <option value="Completed">Completed</option>
            <option value="Cancelled">Cancelled</option>
            <option value="Declined">Declined</option>
         </select>
         <div class="faculty-request-wrapper">
            <table class="faculty-table-container">
                <thead>
                    <tr>
                        <th>Faculty Name</th>
                        <th>Email</th>
                        <th>Supply Requested</th>
                        <th>Supply (QTY)</th>
                        <th>Date Requested</th>
                        <th>Request Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Hondrada John Mark</td>
                        <td>johnhondrada@ckcm.edu.ph</td>
                        <td>Bondpaper</td>
                        <td>12</td>
                        <td>2025-25-10</td>
                        <td>Pending</td>
                        <td>
                            <button type="submit" name="submit" class="actionBtn">
                                Approved
                            </button>
                            <button type="submit" name="submit" class="actionBtn">
                                Declined
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
         </div>
    </div>
@endsection