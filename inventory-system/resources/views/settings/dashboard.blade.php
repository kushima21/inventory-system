@extends('layout.default')
@vite(['resources/css/dashboard.css', 'resources/js/app.js'])
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 @php
$user = \App\Models\User::find(session('user_id'));
@endphp
@section('content')
    <div class="dashboard-main-container">
        <h2 class="dashboard-header">
            Dashboard Overview
        </h2>
        <h3 class="dashboard-subheader">
            Welcome to your inventory management dashboard!
        </h3>
        <div class="dashboard-box-container">
            <div class="container-box">
              <img src="{{ asset('icons/chart.png') }}" alt="Login Image" class="dashboard-image">
              <h3 class="c-subheader">Total Revenue</h3>
              <div class="c-number">
                <img src="{{ asset('icons/peso-sign.png') }}" alt="Login Image" class="dollar-image">
                <h3 class="number">{{ number_format($totalRevenue, 2) }}</h3>
              </div>
            </div>
            <div class="container-box">
              <img src="{{ asset('icons/chart-line-up.png') }}" alt="Login Image" class="dashboard-image">
              <h3 class="c-subheader">Awaiting Booking Confirmation</h3>
              <div class="c-number">
                <img src="{{ asset('icons/users.png') }}" alt="Login Image" class="dollar-image">
                <h3 class="number">{{ $awaitingCount  }}</h3>
              </div>
            </div>
            <div class="container-box">
              <img src="{{ asset('icons/dropdown-bar.png') }}" alt="Login Image" class="dashboard-image">
              <h3 class="c-subheader">Unapproved Supply Requests</h3>
              <div class="c-number">
                <img src="{{ asset('icons/users-alt.png') }}" alt="Login Image" class="dollar-image">
                <h3 class="number">{{ $awaitingCount  }}</h3>
              </div>
            </div>
            <div class="container-box">
              <img src="{{ asset('icons/total.png') }}" alt="Login Image" class="dashboard-image">
              <h3 class="c-subheader">Total Completed Bookings</h3>
              <div class="c-number">
                <img src="{{ asset('icons/confirmed-user.png') }}" alt="Login Image" class="dollar-image">
                <h3 class="number">{{ number_format($completedCount, 2) }}</h3>
            </div>
        </div>
        <div class="booking-over-container">
            <div class="chart-container">
                <h2>Monthly Revenue</h2>
                <canvas id="revenueChart"></canvas>
            </div>
            <div class="overview-booking-box">
    <h3 class="recent-header">
        Recent Bookings
    </h3>
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

        <div class="recent-booking-container">
          <div class="recent-booking-box">
            <h3 class="recent-header">
              Confirmed Bookings
            </h3>
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
        <div class="recent-supply-request-container">
            <div class="recent-request-box">
              <h3 class="recent-request-subheader">
                Fulfilled Supply Orders
              </h3>
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
                    <tr>
                      <td>Printer Paper</td>
                      <td>10 packs</td>
                      <td>Alice Smith</td>
                      <td>2024-10-01</td>
                      <td class="status completed">Completed</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="supply-request-box">
                <h3 class="recent-request-subheader">
                  Recent Supply Requests
                </h3>
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
                      <tr>
                        <td>Ink Cartridges</td>
                        <td>5 units</td>
                        <td>Bob Johnson</td>
                        <td>2024-10-05</td>
                        <td class="status pending">Pending</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>

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
                legend: {
                    display: true,
                    position: 'bottom'
                },
                tooltip: {
                    enabled: true
                }
            }
        }
    });
</script>
@endsection