@extends('layout.default')
@vite(['resources/css/gym_reservation.css', 'resources/js/app.js'])
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 @section('content')
    <div class="main-gym-reservation-container">
         <h2 class="gym-header">
            Gym Booking Reservation
        </h2>
        <div class="gym-reservation-box-container">
            <div class="gym-box">
                <img src="{{ asset('icons/chart-line-up.png') }}" alt="Login Image" class="dashboard-image">
                <h3 class="c-subheader">Awaiting Booking Confirmation</h3>
                <div class="c-number">
                    <img src="{{ asset('icons/users.png') }}" alt="Login Image" class="dollar-image">
                    <h3 class="number">50</h3>
                </div>
            </div>
            <div class="gym-box">
                <img src="{{ asset('icons/list-check.png') }}" alt="Login Image" class="dashboard-image">
                <h3 class="c-subheader">Confirmed Booking Request</h3>
                <div class="c-number">
                    <img src="{{ asset('icons/user-salary.png') }}" alt="Login Image" class="dollar-image">
                    <h3 class="number">50</h3>
                </div>
            </div>
            <div class="gym-box">
                <img src="{{ asset('icons/document-circle-wrong.png') }}" alt="Login Image" class="dashboard-image">
                <h3 class="c-subheader">Cancelled Booking Request</h3>
                <div class="c-number">
                    <img src="{{ asset('icons/delete-user.png') }}" alt="Login Image" class="dollar-image">
                    <h3 class="number">50</h3>
                </div>
            </div>
            <div class="gym-box">
                <img src="{{ asset('icons/chart.png') }}" alt="Login Image" class="dashboard-image">
                <h3 class="c-subheader">Total Revenue</h3>
                <div class="c-number">
                    <img src="{{ asset('icons/chart-pie-simple-circle-dollar.png') }}" alt="Login Image" class="dollar-image">
                    <h3 class="number">5,000.00</h3>
                </div>
            </div>
            <div class="view-container" id="viewContainer">
                <h2 class="view-header">
                    View Booking Summary
                </h2>
                <div class="view-box-container">
                    <div class="customers-details-container">
                        <h3 class="customer-header">
                            Customer Details
                        </h3>
                        <label for="name">Customer Name</label>
                        <input type="text" id="name" name="name" value="" readonly>
                        <label for="phone">Phone Number</label>
                        <input type="text" id="phone" name="phone" value="" readonly>
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email" value="" readonly>
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" value="" readonly>
                    </div>
                    <div class="customers-details-container">
                        <h2 class="package-header">
                            All Star Premium Package
                        </h2>
                        <div class="package-details-container">
                            <div class="book-box">
                                <h3 class="customer-subheader">Booking Details</h3>

                                <div class="detail-item">
                                <label for="Date Request">Date Request</label>
                                <p>2023-10-01 - 7:20am</p>
                                </div>

                                <div class="detail-item">
                                <label for="check-in">Check-in</label>
                                <p>2023-15-02</p>
                                </div>

                                <div class="detail-item">
                                <label for="check-out">Check-out</label>
                                <p>2023-15-02</p>
                                </div>

                                <div class="detail-item">
                                <label for="days">Day(s)</label>
                                <p>4 Day(s)</p>
                                </div>
                            </div>

                            <div class="package-box">
                                <h3 class="customer-subheader">List Package Items</h3>
                                <ul>
                                <li>1 LED</li>
                                <li>2 Speaker</li>
                                <li>2 Gameboard</li>
                                <li>1 Fan</li>
                                <li>120 Chairs</li>
                                <li>50 Table(s)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bottom-container">
                    <div class="total-container">
                        <h3 class="total-header">Total</h3>
                        <h3 class="total-amount">Php: 2500.00</h3>
                    </div>
                    <div class="status-container">
                        <h3 class="status-header">Request Status</h3>
                        <span class="status pending">Pending</span>
                    </div>
                    <div class="viewBTn-container">
                        <button class="action-button Approved">Approved</button>
                        <button class="action-button Declined">Declined</button>
                        <button class="action-button Close" type="button" id="closeBtn">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="gym-reservation-overview-container">
            <div class="gym-r-overview-box">
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
                        <th>Check-out</th>
                        <th>Day('s)</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>John Doe</td>
                        <td>All Star Premium Package</td>
                        <td>2023-10-01</td>
                        <td>2023-10-31</td>
                        <td>4 Days</td>
                        <td>Php: 2500.00</td>
                        <td><span class="status pending">Pending</span></td>
                        <td>
                            <button class="action-button Approved">Approved</button>
                            <button class="action-button Declined">Declined</button>
                            <button class="action-button View" type="button" id="viewBtn">View</button>
                        </td>
                      </tr>
                      
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
        <div class="gym-complete-cancel-container">
            <div class="gym-box-c">
                <h3 class="recent-header">
                  Approved Bookings Request
                </h3>
                <div class="approved-wrapper-container">
                    <table class="approved-table-container">
                        <thead>
                          <tr>
                            <th>Customer</th>
                            <th>Package</th>
                            <th>Date Request</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>John Doe</td>
                            <td>All Star Premium Package</td>
                            <td>2023-10-01</td>
                            <td>Php: 2500.00</td>
                            <td><span class="status approved">Approved</span></td>
                            <td>
                                <button class="action-button Completed">To Complete</button>
                            </td>
                          </tr>
                          
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="gym-box-c">
                <h3 class="recent-header">
                  Cancelled Bookings Request
                </h3>
                <div class="cancelled-wrapper-container">
                    <table class="cancelled-table-container">
                        <thead>
                          <tr>
                            <th>Customer</th>
                            <th>Package</th>
                            <th>Date Cancelled</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>John Doe</td>
                            <td>All Star Premium Package</td>
                            <td>2023-10-01</td>
                            <td>Php: 2500.00</td>
                            <td><span class="status cancelled">Cancelled</span></td>
                            <td>
                                <button class="action-button View">View</button>
                            </td>
                          </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="complete-container">
            <div class="completed-container-box">
                <h3 class="recent-header">
                  Booking Successful Summary
                </h3>
                <div class="summary-wrapper-container">
                    <table class="summary-table-container">
                        <thead>
                            <tr>
                                <th>Customers</th>
                                <th>Package</th>
                                <th>Date Completed</th>
                                <th>Day('s)</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John Mark Hondrada</td>
                                <td>All Star Premium Package</td>
                                <td>2025-10-25</td>
                                <td>4 Day('s)</td>
                                <td>Php: 2,500.00</td>
                                <td><span class="status Completed">Completed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<script>
  // Get elements
  const viewBtn = document.getElementById('viewBtn');
  const closeBtn = document.getElementById('closeBtn');
  const viewContainer = document.getElementById('viewContainer');

  // Show the container when "View" is clicked
  viewBtn.addEventListener('click', () => {
    viewContainer.style.display = 'block';
  });

  // Hide the container when "Close" is clicked
  closeBtn.addEventListener('click', () => {
    viewContainer.style.display = 'none';
  });
</script>

 @endsection