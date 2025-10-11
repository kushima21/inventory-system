@extends('layout.default')
@vite(['resources/css/dashboard.css', 'resources/js/app.js'])
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <h3 class="number">2500.00</h3>
              </div>
            </div>
            <div class="container-box">
              <img src="{{ asset('icons/chart-line-up.png') }}" alt="Login Image" class="dashboard-image">
              <h3 class="c-subheader">Awaiting Booking Confirmation</h3>
              <div class="c-number">
                <img src="{{ asset('icons/users.png') }}" alt="Login Image" class="dollar-image">
                <h3 class="number">50</h3>
              </div>
            </div>
            <div class="container-box">
              <img src="{{ asset('icons/dropdown-bar.png') }}" alt="Login Image" class="dashboard-image">
              <h3 class="c-subheader">Unapproved Supply Requests</h3>
              <div class="c-number">
                <img src="{{ asset('icons/users-alt.png') }}" alt="Login Image" class="dollar-image">
                <h3 class="number">50</h3>
              </div>
            </div>
            <div class="container-box">
              <img src="{{ asset('icons/total.png') }}" alt="Login Image" class="dashboard-image">
              <h3 class="c-subheader">Total Completed Bookings</h3>
              <div class="c-number">
                <img src="{{ asset('icons/confirmed-user.png') }}" alt="Login Image" class="dollar-image">
                <h3 class="number">50</h3>
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
                      <tbody>
                        <tr>
                          <td>Jane Smith</td>
                          <td>Standard Package</td>
                          <td>2025-10-15</td>
                          <td class="status pending">Pending</td>
                          <td>$300</td>
                        </tr>
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
                    <tr>
                      <td>John Doe</td>
                      <td>All Star Premium Package</td>
                      <td>2025-10-09</td>
                      <td>2025-10-12</td>
                      <td>4 days</td>
                      <td class="status completed">Completed</td>
                      <td>$450</td>
                    </tr>
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
      type: 'bar', // You can change to 'line' or 'pie'
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July','August','September','October','November','December'],
        datasets: [{
          label: 'Revenue (₱)',
          data: [12000, 15000, 10000, 17000, 19000, 22000, 25000],
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