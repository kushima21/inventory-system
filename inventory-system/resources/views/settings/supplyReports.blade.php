@extends('layout.default')
@vite(['resources/css/supplyReports.css', 'resources/js/app.js'])
@vite(['resources/css/reports.css', 'resources/js/app.js'])

<link rel="stylesheet" href="{{ asset('/resources/css/supplyReports.css') }}">
<link rel="stylesheet" href="{{ asset('/resources/css/reports.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@section('content')
<div class="supply-main-container-reports">
    <h2 class="supply-reports-header">
        Supply Report Dashboard
    </h2>
    <p class="s-sub">Get an overview of current inventory levels, usage trends, and faculty requests.</p>

    <div class="supply-reports-box-container">
        <div class="supply-box">
            <img src="{{ asset('icons/users-alt.png') }}" alt="Login Image" class="report-image" style="margin:20px;">
                <h3 class="report-subheader" style="padding-left: 20px">Total Request Supplies</h3>
                <div class="report-number">
                <img src="{{ asset('icons/users.png') }}" alt="Login Image" class="peso-image" style="margin: 20px">
                <h3 class="number">55</h3>
            </div>
        </div>
        <div class="supply-box">
            <img src="{{ asset('icons/chart-line-up.png') }}" alt="Login Image" class="report-image" style="margin:20px;">
                <h3 class="report-subheader" style="padding-left: 20px">Awaiting Request Confirmation</h3>
                <div class="report-number">
                <img src="{{ asset('icons/users.png') }}" alt="Login Image" class="peso-image" style="margin: 20px">
                <h3 class="number">16</h3>
            </div>
        </div>
        <div class="supply-box">
            <img src="{{ asset('icons/circle-wrong.png') }}" alt="Login Image" class="report-image" style="margin:20px;">
                <h3 class="report-subheader" style="padding-left: 20px">Cancelled Request Supplies</h3>
                <div class="report-number">
                <img src="{{ asset('icons/users.png') }}" alt="Login Image" class="peso-image" style="margin: 20px">
                <h3 class="number">20</h3>
            </div>
        </div>
        <div class="supply-box">
            <img src="{{ asset('icons/user-forbidden-alt.png') }}" alt="Login Image" class="report-image" style="margin:20px;">
                <h3 class="report-subheader" style="padding-left: 20px">Unapproved Request</h3>
                <div class="report-number">
                <img src="{{ asset('icons/users.png') }}" alt="Login Image" class="peso-image" style="margin: 20px">
                <h3 class="number">60</h3>
            </div>
        </div>
    </div>

    <h3 class="supply-sum-header">
        Supply Tracking Overview
    </h3>
    <div class="supply-track-container">
        <div class="supply-track-box">
            <div class="supply-track-wrapper">
                <table class="supply-track-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Supply Requested</th>
                            <th>Supply (QTY)</th>
                            <th>Date Requested</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
    @forelse($reports as $report)
        @if(in_array($report->request_status, ['Pending', 'Approved']))
            <tr>
                <td>{{ $report->name ?? 'N/A' }}</td>
                <td>{{ $report->email ?? 'N/A' }}</td>
                <td>{{ $report->supply_name ?? 'N/A' }}</td>
                <td>{{ $report->quantity ?? '0' }}</td>
                <td>
                    @if($report->request_status === 'Completed')
                        {{ $report->updated_at->format('Y-m-d') }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $report->request_status }}</td>
            </tr>
        @endif
    @empty
        <tr>
            <td colspan="6" style="text-align:center;">No records found.</td>
        </tr>
    @endforelse
</tbody>

                </table>
            </div>
        </div>

        <div class="supply-track-calendar">
            <div class="calendar-header">
                <button id="prevMonth">&lt;</button>
                <span id="monthYear"></span>
                <button id="nextMonth">&gt;</button>
            </div>
            <div class="calendar-days"></div>
        </div>
    </div>

    <h2 class="summary-supply">
        Supply Management Summary
    </h2>

    {{-- ✅ Filter Form --}}
  <form method="GET" action="{{ route('settings.supplyReports') }}" class="sum-filter-container" id="filterForm">
    <select name="request_status" class="filter-select" onchange="this.form.submit()">
        <option value="">Filter Supply Status</option>
        <option value="Completed" {{ request('request_status') == 'Completed' ? 'selected' : '' }}>Completed</option>
        <option value="Cancelled" {{ request('request_status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
        <option value="Declined" {{ request('request_status') == 'Declined' ? 'selected' : '' }}>Declined</option>
        <option value="Pending" {{ request('request_status') == 'Pending' ? 'selected' : '' }}>Pending</option>
    </select>

    <input type="hidden" name="start_date" id="start_date" value="{{ request('start_date') }}">
    <input type="hidden" name="end_date" id="end_date" value="{{ request('end_date') }}">

    <button type="button" class="exportBtn">Export Reports</button>
</form>

    <div class="summary-container">
        <div class="summary-wrapper-container">
            <table class="summary-table-contaier">
                <thead>
                    <tr>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Supply Requested</td>
                        <td>Quantity</td>
                        <td>Date Completed</td>
                        <td>Status</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td>{{ $report->name ?? 'N/A' }}</td>
                            <td>{{ $report->email ?? 'N/A' }}</td>
                            <td>{{ $report->supply_name ?? 'N/A' }}</td>
                            <td>{{ $report->quantity ?? '0' }}</td>
                            <td>
                                @if($report->request_status === 'Completed')
                                    {{ $report->updated_at->format('Y-m-d') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $report->request_status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;">No records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const monthYear = document.getElementById("monthYear");
    const calendarDays = document.querySelector(".calendar-days");
    const prevMonthBtn = document.getElementById("prevMonth");
    const nextMonthBtn = document.getElementById("nextMonth");
    const filterForm = document.getElementById("filterForm");
    const startInput = document.getElementById("start_date");
    const endInput = document.getElementById("end_date");

    let currentDate = new Date();
    let startDate = startInput.value ? new Date(startInput.value) : null;
    let endDate = endInput.value ? new Date(endInput.value) : null;

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

        // Empty cells before first day
        for (let i = 0; i < firstDay; i++) {
            const emptyCell = document.createElement("div");
            calendarDays.appendChild(emptyCell);
        }

        // Render days
        for (let i = 1; i <= lastDate; i++) {
            const day = document.createElement("div");
            day.textContent = i;

            const cellDate = new Date(year, month, i);
            const today = new Date();

            // Highlight today's date
            if (i === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                day.classList.add("today");
            }

            // Highlight selected dates and range
            if (startDate && cellDate.getTime() === startDate.getTime()) day.classList.add("selected");
            if (endDate && cellDate.getTime() === endDate.getTime()) day.classList.add("selected");
            if (startDate && endDate && cellDate > startDate && cellDate < endDate) day.classList.add("in-range");

            // Handle clicks
            day.addEventListener("click", () => handleDateClick(cellDate));

            calendarDays.appendChild(day);
        }
    }

    function handleDateClick(selectedDate) {
        if (!startDate || (startDate && endDate)) {
            // Start new selection
            startDate = selectedDate;
            endDate = null;
        } else if (selectedDate < startDate) {
            // If earlier date clicked
            endDate = startDate;
            startDate = selectedDate;
        } else {
            // Set as end date
            endDate = selectedDate;
        }

        renderCalendar(currentDate);

        // When both dates are selected, auto-submit the filter
        if (startDate && endDate) {
            const start = startDate.toISOString().split("T")[0];
            const end = endDate.toISOString().split("T")[0];
            startInput.value = start;
            endInput.value = end;

            const status = document.querySelector(".filter-select").value;
            if (status === "Completed") {
                filterForm.submit();
            }
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

    // Initialize
    renderCalendar(currentDate);
</script>

@endsection
