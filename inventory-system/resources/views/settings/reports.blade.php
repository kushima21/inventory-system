@extends('layout.default')
@vite(['resources/css/reports.css', 'resources/js/app.js'])
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 @section('content')
    <div class="main-reports-container">
        <h2 class="reports-header">
            Reports Overview
        </h2>

        <div class="reports-container-box">
            <!-- Report content will go here -->
            <div class="report-box">
                 <img src="{{ asset('icons/chart-mixed-up-circle-dollar.png') }}" alt="Login Image" class="report-image">
                 <h3 class="report-subheader">Total Revenue</h3>
                 <div class="report-number">
                    <img src="{{ asset('icons/peso-sign.png') }}" alt="Login Image" class="peso-image">
                    <h3 class="number">2500.00</h3>
                 </div>
            </div>
            <div class="report-box">
                <img src="{{ asset('icons/newspaper.png') }}" alt="Login Image" class="report-image">
                <h3 class="report-subheader">Total Booking</h3>
                 <div class="report-number">
                    <img src="{{ asset('icons/career-growth.png') }}" alt="Login Image" class="peso-image">
                    <h3 class="number">50</h3>
                 </div>
            </div>
            <div class="report-box">
                 <img src="{{ asset('icons/delete-user.png') }}" alt="Login Image" class="report-image">
                 <h3 class="report-subheader">Cancelled Booking</h3>
                 <div class="report-number">
                    <img src="{{ asset('icons/document-circle-wrong.png') }}" alt="Login Image" class="peso-image">
                    <h3 class="number">50</h3>
                 </div>
            </div>
            <div class="report-box">
                <img src="{{ asset('icons/users-medical.png') }}" alt="Login Image" class="report-image">
                 <h3 class="report-subheader">Total Supplies Request</h3>
                <div class="report-number">
                    <img src="{{ asset('icons/team-check-alt.png') }}" alt="Login Image" class="peso-image">
                    <h3 class="number">50</h3>
                 </div>
            </div>
        </div>

        <div class="chart-top-package-container">
            <div class="chart-container">
                <h3 class="chart-title">Monthly Revenue Overview</h3>
                <canvas id="revenueChart"></canvas>
            </div>

            <div class="top-package-container">
                <h3 class="top-package-header">
                    Top Packages
                </h3>
                <div class="top-package-box">
                    <div class="package-item">
                        <span class="package-name">All Star Premium Package</span>
                        <span class="package-count">150 Booked</span>
                    </div>
                    <div class="package-item">
                        <span class="package-name">All Star Basic Package</span>
                        <span class="package-count">120 Booked</span>
                    </div>
                    <div class="package-item">
                        <span class="package-name">All Star Standard Package</span>
                        <span class="package-count">100 Booked</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="booking-transaction-container">

            <div class="calendar-container">
                <div class="calendar-header">
                    <button id="prevMonth">&#8249;</button>
                    <h2 id="monthYear"></h2>
                    <button id="nextMonth">&#8250;</button>
                </div>
                <div class="calendar">
                    <div class="calendar-days"></div>
                </div>
            </div>

            <div class="completed-container">
                <div class="completed-header-box">
                    <h3 class="completed-header">
                     Booked Summary
                    </h3>
                    <div class="filter-container">
                        <select name="status">
                            <option value="">Filtered Status</option>
                            <option value="Completed">Completed</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                        <button type="button" class="exportBTn">
                            Export Report
                        </button>
                    </div>
                </div>
                <div class="booked-summary-wrapper">
                    <table class="booked-summary-table">
                        <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Contact Number</th>
                                <th>Package</th>
                                <th>Date Request Booking</th>
                                <th>Day('s)</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John Mark Hondrada</td>
                                <td>09073387882</td>
                                <td>All Star Premium Package</td>
                                <td>2025-25-01</td>
                                <td>4 Day's</td>
                                <td>Php: 2,500.00</td>
                                <td><span class="status Completed">Completed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="faculty-supplies-container">

            <div class="faculty-supplies-box">
                <div class="faculty-header-container">
                    <h3 class="faculty-header">
                        Faculty Recent Request
                    </h3>
                    <div class="filtering-request-supply-container">
                        <select name="select status" class="selectStatus">
                            <option value="">Filtered Request Status</option>
                            <option value="Completed">Completed</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                        <button type="button" class="requestBTn">
                            Export Reports
                        </button>
                    </div>
                </div>
                <div class="faculty-request-wrapper">
                    <table class="faculty-request-table">
                        <thead>
                            <tr>
                                <th>Faculty Name</th>
                                <th>Request Supply</th>
                                <th>Quantity</th>
                                <th>Date Requested</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John Mark Hondrada</td>
                                <td>Bond Papers</td>
                                <td>2 Pieces</td>
                                <td>2025-25-05</td>
                                <td><span class="status Completed">Completed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
<!--calendar script-->

<script>
const monthYear = document.getElementById("monthYear");
const calendarDays = document.querySelector(".calendar-days");
const prevMonthBtn = document.getElementById("prevMonth");
const nextMonthBtn = document.getElementById("nextMonth");

let currentDate = new Date();
let startDate = null;
let endDate = null;

function renderCalendar(date) {
    const year = date.getFullYear();
    const month = date.getMonth();

    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();

    const monthNames = [
        "January","February","March","April","May","June",
        "July","August","September","October","November","December"
    ];

    monthYear.textContent = `${monthNames[month]} ${year}`;
    calendarDays.innerHTML = "";

    for (let i = 0; i < firstDay; i++) {
        const emptyCell = document.createElement("div");
        calendarDays.appendChild(emptyCell);
    }

    for (let i = 1; i <= lastDate; i++) {
        const day = document.createElement("div");
        day.textContent = i;

        const cellDate = new Date(year, month, i);

        // Highlight today's date
        const today = new Date();
        if (
            i === today.getDate() &&
            month === today.getMonth() &&
            year === today.getFullYear()
        ) {
            day.classList.add("today");
        }

        // Highlight selected range
        if (startDate && cellDate.getTime() === startDate.getTime()) {
            day.classList.add("selected");
        }
        if (endDate && cellDate.getTime() === endDate.getTime()) {
            day.classList.add("selected");
        }
        if (startDate && endDate && cellDate > startDate && cellDate < endDate) {
            day.classList.add("in-range");
        }

        // Click event to select start and end
        day.addEventListener("click", () => handleDateClick(cellDate));

        calendarDays.appendChild(day);
    }
}

function handleDateClick(selectedDate) {
    if (!startDate || (startDate && endDate)) {
        // Reset and set new start date
        startDate = selectedDate;
        endDate = null;
    } else if (selectedDate < startDate) {
        // If user clicks earlier date, make it new start
        endDate = startDate;
        startDate = selectedDate;
    } else {
        // Set as end date
        endDate = selectedDate;
    }
    renderCalendar(currentDate);

    if (startDate && endDate) {
        console.log(`Filter from ${startDate.toDateString()} to ${endDate.toDateString()}`);
        // You can trigger your filter function here
    }
}

prevMonthBtn.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar(currentDate);
});

nextMonthBtn.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar(currentDate);
});

renderCalendar(currentDate);
</script>
<script>
const ctx = document.getElementById('revenueChart').getContext('2d');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Revenue (₱)',
            data: [12000, 15000, 9000, 18000, 22000, 25000, 20000, 27000, 23000, 29000, 31000, 35000],
            backgroundColor: 'rgba(128, 0, 0, 0.7)',   // maroon (semi-transparent)
            borderColor: 'rgba(128, 0, 0, 1)',         // solid maroon border
            borderWidth: 2,
            borderRadius: 6,
            hoverBackgroundColor: 'rgba(101, 0, 0, 0.9)', // darker maroon when hovered
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)'
                },
                ticks: {
                    color: '#333'
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    color: '#333'
                }
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    color: '#5a0000', // maroon text for legend
                    font: {
                        size: 13,
                        weight: 'bold'
                    }
                }
            },
            title: {
                display: false
            },
            tooltip: {
                backgroundColor: '#5a0000', // maroon tooltip background
                titleColor: '#fff',
                bodyColor: '#fff',
                cornerRadius: 8,
                padding: 10
            }
        }
    }
});
</script>

 @endsection