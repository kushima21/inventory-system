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
            <div class="container-box"></div>
            <div class="container-box"></div>
            <div class="container-box"></div>
            <div class="container-box"></div>
        </div>
        <div class="booking-over-container">
            <div class="chart-container">
                <h2>Monthly Revenue</h2>
                <canvas id="revenueChart"></canvas>
            </div>
            <div class="overview-booking-box"></div>
        </div>

        <div class="recent-booking-container">
          <div class="recent-booking-box">
            <h3 class="recent-header">
              Recent Bookings
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
                      <td class="status active">Completed</td>
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
                Recent Supply Requests
              </h3>
            </div>
            <div class="supply-request-box"></div>
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