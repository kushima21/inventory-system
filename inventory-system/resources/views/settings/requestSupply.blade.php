@extends('layout.default')
@vite(['resources/css/settings.css', 'resources/js/app.js'])
@vite(['resources/css/reports.css', 'resources/js/app.js'])
     @php
$user = \App\Models\User::find(session('user_id'));
@endphp
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
                        <h3 class="number">{{ $totalCompleted }}</h3>
                    </div>
                </div>
                <div class="request-box">
                    <img src="{{ asset('icons/chart-line-up.png') }}" alt="Login Image" class="request-image">
                    <h3 class="request-subheader">Awaiting Request Confirmation</h3>
                    <div class="report-number">
                        <img src="{{ asset('icons/users.png') }}" alt="Login Image" class="r-image">
                        <h3 class="number">{{ $awaitingConfirmation }}</h3>
                    </div>
                </div>
                <div class="request-box">
                    <img src="{{ asset('icons/delete-user.png') }}" alt="Login Image" class="request-image">
                    <h3 class="request-subheader">Cancelled Supply Requests</h3>
                    <div class="report-number">
                        <img src="{{ asset('icons/circle-wrong.png') }}" alt="Login Image" class="r-image">
                        <h3 class="number">{{ $cancelledRequests }}</h3>
                    </div>
                </div>
                <div class="request-box">
                    <img src="{{ asset('icons/delete-document.png') }}" alt="Login Image" class="request-image">
                    <h3 class="request-subheader">Unapproved Supply Requests</h3>
                    <div class="report-number">
                        <img src="{{ asset('icons/user-forbidden-alt.png') }}" alt="Login Image" class="r-image">
                        <h3 class="number">{{ $unapprovedRequests }}</h3>
                    </div>
                </div>
            </div>

         <h3 class="list-f-header">
            Faculty Supply Request List
         </h3>
<form method="GET" action="{{ route('settings.requestSupply') }}">
    <select name="request_status" class="filter-r-status" onchange="this.form.submit()">
        <option value="">Filtering Request Status</option>
        <option value="Pending" {{ request('request_status') == 'Pending' ? 'selected' : '' }}>Pending Request</option>
        <option value="Approved" {{ request('request_status') == 'Approved' ? 'selected' : '' }}>Approved</option>
    </select>
</form>
         <div class="faculty-request-wrapper">
    <table class="faculty-table-container">
        <thead>
            <tr>
                <th>Faculty Name</th>
                <th>Email</th>
                <th>Supply Requested</th>
                <th>Supply (QTY)</th>

                {{-- Dynamic Date Label --}}
                <th>
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

                {{-- New Column for Date Needed --}}
                <th>Date Needed</th>

                <th>Request Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($requests as $request)
                <tr>
                    <td>{{ $request->name }}</td>
                    <td>{{ $request->email }}</td>
                    <td>{{ $request->supply_name }}</td>
                    <td>{{ $request->quantity }}</td>

                    {{-- Display date based on request_status --}}
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

                    {{-- New Date Needed column --}}
                    <td>
                        @if($request->date_needed)
                            {{ \Carbon\Carbon::parse($request->date_needed)->format('Y-m-d') }}
                        @else
                            <span style="color: gray; font-style: italic;">N/A</span>
                        @endif
                    </td>

                    <td>{{ $request->request_status }}</td>

                    <td>
                        @if($request->request_status == 'Approved')
                            {{-- If Approved, show "To Completed" button and disable Declined --}}
                            <form method="POST" action="{{ route('faculty.request.complete', $request->id) }}" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="actionBtn completedBtn">To Completed</button>
                            </form>

                            <button type="button" class="actionBtn" style="opacity: 0.5; cursor: not-allowed;" disabled>Declined</button>

                        @elseif(!in_array($request->request_status, ['Cancelled', 'Completed', 'Declined']))
                            {{-- Normal buttons for pending requests --}}
                            <form method="POST" action="{{ route('faculty.request.approve', $request->id) }}" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="actionBtn approvedBtn">Approved</button>
                            </form>
                            <form method="POST" action="{{ route('faculty.request.decline', $request->id) }}" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="actionBtn">Declined</button>
                            </form>

                        @else
                            {{-- For other statuses --}}
                            <span style="color: gray; font-style: italic;">No actions</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No supply requests found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>



    </div>
@endsection