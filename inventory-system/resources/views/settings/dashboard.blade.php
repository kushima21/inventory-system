@extends('layout.default')
@vite(['resources/css/dashboard.css', 'resources/js/app.js'])

<!-- ✅ Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@php
    $user = \App\Models\User::find(session('user_id'));
@endphp

@section('content')
<div class="dashboard-main-container">

    <!-- 🏷️ DASHBOARD HEADER -->
    <h2 class="dashboard-header">Dashboard Overview</h2>
    <h3 class="dashboard-subheader">Welcome to your inventory management dashboard!</h3>

    <!-- 📊 DASHBOARD STAT BOXES -->
    <div class="dashboard-box-container">

        <!-- 💰 Total Revenue -->
        <div class="container-box">
            <img src="{{ asset('icons/chart.png') }}" alt="Total Revenue" class="dashboard-image">
            <h3 class="c-subheader">Total Revenue</h3>
            <div class="c-number">
                <img src="{{ asset('icons/peso-sign.png') }}" alt="Peso Icon" class="dollar-image">
                <h3 class="number">{{ number_format($totalRevenue, 2) }}</h3>
            </div>
        </div>

        <!-- ⏳ Awaiting Booking Confirmation -->
        <div class="container-box">
            <img src="{{ asset('icons/chart-line-up.png') }}" alt="Pending Icon" class="dashboard-image">
            <h3 class="c-subheader">Awaiting Booking Confirmation</h3>
            <div class="c-number">
                <img src="{{ asset('icons/users.png') }}" alt="User Icon" class="dollar-image">
                <h3 class="number">{{ $awaitingCount }}</h3>
            </div>
        </div>

        <!-- 📦 Unapproved Supply Requests -->
        <div class="container-box">
            <img src="{{ asset('icons/dropdown-bar.png') }}" alt="Supply Icon" class="dashboard-image">
            <h3 class="c-subheader">Unapproved Supply Requests</h3>
            <div class="c-number">
                <img src="{{ asset('icons/users-alt.png') }}" alt="Users Icon" class="dollar-image">
                <h3 class="number">{{ $awaitingCount }}</h3>
            </div>
        </div>

        <!-- ✅ Total Completed Bookings -->
        <div class="container-box">
            <img src="{{ asset('icons/total.png') }}" alt="Completed Icon" class="dashboard-image">
            <h3 class="c-subheader">Total Completed Bookings</h3>
            <div class="c-number">
                <img src="{{ asset('icons/confirmed-user.png') }}" alt="Confirmed Icon" class="dollar-image">
                <h3 class="number">{{ number_format($completedCount, 2) }}</h3>
            </div>
        </div>
    </div>

    <!-- 📅 BOOKING OVERVIEW -->
    <div class="booking-over-container">

        <!-- 📈 Monthly Revenue Chart -->
        <div class="chart-container">
            <h2>Monthly Revenue</h2>
            <canvas id="revenueChart"></canvas>
        </div>

        <!-- 🧾 Recent Pending Bookings -->
        <div class="overview-booking-box">
            <h3 class="recent-header">Recent Bookings</h3>
            <div class="overview-recent-wrapper">
                <table class="overview-recent-request-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Package</th>
                            <th>Check-in</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings->where('booking_status', 'Pending') as $booking)
                            <tr>
                                <td>{{ $booking->name }}</td>
                                <td>{{ $booking->gym->package ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->starting_date)->format('Y-m-d') }}</td>
                                <td class="status pending">{{ $booking->booking_status }}</td>
                                <td>₱{{ number_format($booking->total_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 📋 CONFIRMED BOOKINGS -->
    <div class="recent-booking-container">
        <div class="recent-booking-box">
            <h3 class="recent-header">Confirmed Bookings</h3>
            <div class="table-wrapper">
                <table class="booking-table-container">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Package</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Total Days</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td>{{ $booking->name }}</td>
                                <td>{{ $booking->gym->package ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->starting_date)->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->end_date)->format('Y-m-d') }}</td>
                                <td>{{ $booking->total_days }} days</td>
                                <td class="status {{ strtolower($booking->booking_status) }}">
                                    {{ $booking->booking_status }}
                                </td>
                                <td>₱{{ number_format($booking->total_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 📦 SUPPLY REQUESTS SECTION -->
    <div class="recent-supply-request-container">

        <!-- ✅ Fulfilled Supply Orders -->
        <div class="recent-request-box">
            <h3 class="recent-request-subheader">Fulfilled Supply Orders</h3>
            <div class="supply-wrapper">
                <table class="supply-table-container">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Requested By</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($completedRequests as $request)
                            <tr>
                                <td>{{ $request->supply_name }}</td>
                                <td>{{ $request->quantity }}</td>
                                <td>{{ $request->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($request->date_completed)->format('Y-m-d') }}</td>
                                <td class="status completed">{{ $request->request_status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center;">No completed supply requests yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 🕓 Recent Pending Supply Requests -->
        <div class="supply-request-box">
            <h3 class="recent-request-subheader">Recent Supply Requests</h3>
            <div class="recent-s-request-container">
                <table class="supply-request-table-container">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Requested By</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentRequests as $request)
                            <tr>
                                <td>{{ $request->supply_name }}</td>
                                <td>{{ $request->quantity }}</td>
                                <td>{{ $request->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($request->created_at)->format('Y-m-d') }}</td>
                                <td class="status pending">{{ $request->request_status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center;">No pending supply requests.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- 📊 CHART.JS SCRIPT -->
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'bar', // Change to 'line' if preferred
        data: {
            labels: [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ],
            datasets: [{
                label: 'Revenue (₱)',
                data: [
                    @foreach($revenues as $month => $amount)
                        {{ $amount }},
                    @endforeach
                ],
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Revenue in ₱'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                }
            },
            plugins: {
                legend: { display: true, position: 'bottom' },
                tooltip: { enabled: true }
            }
        }
    });
</script>
@endsection
