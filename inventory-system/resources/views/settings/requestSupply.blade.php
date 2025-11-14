@extends('layout.default')

{{-- ✅ Include CSS & JS assets --}}
@vite(['resources/css/settings.css', 'resources/js/app.js'])
@vite(['resources/css/reports.css', 'resources/js/app.js'])
<link rel="stylesheet" href="{{ asset('resources/css/reports.css') }}">
<link rel="stylesheet" href="{{ asset('resources/css/settings.css') }}">
@php
    // ✅ Fetch logged-in user from session
    $user = \App\Models\User::find(session('user_id'));
@endphp
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@section('content')
<div class="main-request-overview-dashbaord-c">

    {{-- ✅ PAGE HEADER --}}
    <h2 class="request-main-header">Faculty Request Dashboard</h2>
    <p class="p-head">View and manage all faculty supply requests in one place.</p>

    {{-- ✅ STATISTICS CARDS --}}
    <div class="request-main-box-container">
        {{-- 🔹 Total Completed Requests --}}
        <div class="request-box">
            <img src="{{ asset('icons/total.png') }}" alt="Total Icon" class="request-image">
            <h3 class="request-subheader">Total Supply Request</h3>
            <div class="report-number">
                <img src="{{ asset('icons/confirmed-user.png') }}" alt="User Icon" class="r-image">
                <h3 class="number">{{ $totalCompleted }}</h3>
            </div>
        </div>

        {{-- 🔹 Pending Requests --}}
        <div class="request-box">
            <img src="{{ asset('icons/chart-line-up.png') }}" alt="Pending Icon" class="request-image">
            <h3 class="request-subheader">Awaiting Request Confirmation</h3>
            <div class="report-number">
                <img src="{{ asset('icons/users.png') }}" alt="Users Icon" class="r-image">
                <h3 class="number">{{ $awaitingConfirmation }}</h3>
            </div>
        </div>

        {{-- 🔹 Cancelled Requests --}}
        <div class="request-box">
            <img src="{{ asset('icons/delete-user.png') }}" alt="Cancelled Icon" class="request-image">
            <h3 class="request-subheader">Cancelled Supply Requests</h3>
            <div class="report-number">
                <img src="{{ asset('icons/circle-wrong.png') }}" alt="Wrong Icon" class="r-image">
                <h3 class="number">{{ $cancelledRequests }}</h3>
            </div>
        </div>

        {{-- 🔹 Declined Requests --}}
        <div class="request-box">
            <img src="{{ asset('icons/delete-document.png') }}" alt="Declined Icon" class="request-image">
            <h3 class="request-subheader">Unapproved Supply Requests</h3>
            <div class="report-number">
                <img src="{{ asset('icons/user-forbidden-alt.png') }}" alt="Forbidden Icon" class="r-image">
                <h3 class="number">{{ $unapprovedRequests }}</h3>
            </div>
        </div>
    </div>

    {{-- ✅ REQUEST LIST HEADER --}}
    <h3 class="list-f-header">Faculty Supply Request List</h3>

    {{-- ✅ FILTER DROPDOWN --}}
    <form method="GET" action="{{ route('settings.requestSupply') }}">
        <select name="request_status" class="filter-r-status" onchange="this.form.submit()">
            <option value="">Filtering Request Status</option>
            <option value="Pending" {{ request('request_status') == 'Pending' ? 'selected' : '' }}>Pending Request</option>
            <option value="Approved" {{ request('request_status') == 'Approved' ? 'selected' : '' }}>Approved</option>
        </select>
    </form>

    {{-- ✅ REQUEST TABLE --}}
  <div class="facultyRequestSearch">
    <form method="GET" action="">
        <input type="text" name="searchFacultyRequest" placeholder="Quick Search..." >
    </form>
</div>
    <div class="faculty-request-wrapper">
        <table class="faculty-table-container">
            <thead>
                <tr>
                    <th>Faculty Name</th>
                    <th>Email</th>
                    <th>Supply Requested</th>
                    <th>Supply (QTY)</th>
                    <th>
                        {{-- 🔹 Dynamically set date header based on request status --}}
                        @if($requests->isNotEmpty())
                            @php
                                $status = $requests->first()->request_status;
                                switch($status) {
                                    case 'Pending': $thLabel = 'Date Requested'; break;
                                    case 'Approved': $thLabel = 'Date Approved'; break;
                                    case 'Completed': $thLabel = 'Date Completed'; break;
                                    case 'Cancelled': $thLabel = 'Date Cancelled'; break;
                                    case 'Declined': $thLabel = 'Date Declined'; break;
                                    default: $thLabel = 'Date';
                                }
                            @endphp
                            {{ $thLabel }}
                        @else
                            Date
                        @endif
                    </th>
                    <th>Request Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($requests as $request)
                    <tr>
                        {{-- 🔹 Faculty info --}}
                        <td>{{ $request->name }}</td>
                        <td>{{ $request->email }}</td>
                        <td>{{ $request->supply_name }}</td>
                        <td>{{ $request->quantity }}</td>

                        {{-- 🔹 Show date based on status --}}
                        <td>
                            @if($request->request_status === 'Pending' && $request->created_at)
                                {{ $request->created_at->format('Y-m-d') }}
                            @elseif($request->request_status === 'Approved' && $request->date_approved)
                                {{ \Carbon\Carbon::parse($request->date_approved)->format('Y-m-d') }}
                            @elseif($request->request_status === 'Completed' && $request->date_completed)
                                {{ \Carbon\Carbon::parse($request->date_completed)->format('Y-m-d') }}
                            @elseif($request->request_status === 'Cancelled' && $request->date_cancelled)
                                {{ \Carbon\Carbon::parse($request->date_cancelled)->format('Y-m-d') }}
                            @elseif($request->request_status === 'Declined' && $request->date_declined)
                                {{ \Carbon\Carbon::parse($request->date_declined)->format('Y-m-d') }}
                            @else
                                <span style="color: gray; font-style: italic;">N/A</span>
                            @endif
                        </td>

                        {{-- 🔹 Status display --}}
                        <td>{{ $request->request_status }}</td>

                        {{-- 🔹 ACTION BUTTONS --}}
                        <td>
    @if($request->request_status == 'Approved')
        {{-- ✅ If Approved: show "To Completed" button and disable Declined --}}
        <form method="POST" action="{{ route('faculty.request.complete', $request->id) }}" style="display:inline-block; margin-right: 5px;">
            @csrf
            <button type="submit" class="actionBtn completedBtn">
                To Completed
            </button>
        </form>

        <button type="button" class="actionBtn" style="opacity: 0.5; cursor: not-allowed;" disabled>
            Declined
        </button>

    @elseif(!in_array($request->request_status, ['Cancelled', 'Completed', 'Declined']))
        {{-- ✅ If Pending: show Approve and Decline buttons --}}
        <form method="POST" action="{{ route('faculty.request.approve', $request->id) }}" style="display:inline-block; margin-right: 5px;">
            @csrf
            <button type="submit" class="actionBtn approvedBtn">
                Approved
            </button>
        </form>

        <form method="POST" action="{{ route('faculty.request.decline', $request->id) }}" style="display:inline-block;">
            @csrf
            <button type="submit" class="actionBtn">
                Declined
            </button>
        </form>

    @else
        {{-- ✅ For Completed, Cancelled, or Declined requests --}}
        <span style="color: gray; font-style: italic;">
            No actions
        </span>
    @endif
</td>

                    </tr>

                @empty
                    {{-- 🔹 No data fallback --}}
                    <tr>
                        <td colspan="7">No supply requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
