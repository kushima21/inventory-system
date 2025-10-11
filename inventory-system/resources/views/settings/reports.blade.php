@extends('layout.default')
@vite(['resources/css/reports.css', 'resources/js/app.js'])
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 @section('content')
    <div class="main-reports-container">
        <h2 class="reports-header">
            Reports Overview
        </h2>

        <div class="reports-container-box">
            <!-- Report content will go here -->
            <div class="report-box"></div>
            <div class="report-box"></div>
            <div class="report-box"></div>
            <div class="report-box"></div>
        </div>

        <div class="chart-top-package-container">
            <div class="chart-container"></div>
            <div class="top-package-container">
                <h3 class="top-package-header">
                    Top Packages
                </h3>

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
 @endsection