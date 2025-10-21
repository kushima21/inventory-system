@extends('layout.default')

{{-- ✅ Include Styles & JS --}}
@vite(['resources/css/inventory.css', 'resources/js/app.js'])
<link rel="stylesheet" href="{{ asset('/resources/css/inventory.css') }}">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@section('content')
<div class="main-inventory-system">

    {{-- ======================= PAGE HEADER ======================= --}}
    <h2 class="inventory-header">Inventory Overview</h2>

    {{-- ======================= SUPPLY STOCK SECTION ======================= --}}
    <div class="supply-stock-container">
        <div class="supply-stock-box">

            {{-- SUPPLY STOCK HEADER --}}
            <h3 class="supply-stock-header">Supply Stocks</h3>

            {{-- ✅ ADD SUPPLY MODAL --}}
            <div class="add-supply-container">
                <h3 class="add-supply-header">Add Supplies</h3>
                <div class="form-add-container">
                    <form id="supplyForm" method="POST" action="{{ route('supplies.store') }}">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">
                        <input type="hidden" name="supply_id" id="supply_id">

                        <div class="info-container">
                            <label for="supplies">Supplies:</label>
                            <input list="supplies-list" name="supplies" id="supplies" placeholder="Select Supplies..." required oninput="checkOtherSupply()">
                            <datalist id="supplies-list">
                                <option value="Exam Bondpaper">
                                <option value="Student Passbook">
                                <option value="Softbound">
                                <option value="School Uniform">
                                <option value="PE Uniform">
                                <option value="Printer">
                                <option value="Computer">
                                <option value="Add Other Supply">
                            </datalist>
                        </div>

                        <div class="info-container" id="other-supply-container" style="display: none; margin-top: 20px;">
                            <label for="other_supply">Enter Other Supply:</label>
                            <input type="text" name="other_supply" id="other_supply" placeholder="Enter custom supply...">
                        </div>

                        <div class="info-container">
                            <label for="quantity">Quantity:</label>
                            <input type="number" name="quantity" id="quantity" placeholder="Quantity..." required>
                        </div>

                        <div class="info-btn">
                            <button type="submit" name="submit" id="submitBtn">Create</button>
                            <button type="button" name="cancel" onclick="closeSuppliesModal()">Cancel</button>
                        </div>
                    </form>

                </div>
            </div>

            {{-- SEARCH & ADD BUTTON --}}
            <div class="supply-subheader-box">
                <input type="text" name="search" id="search" placeholder="Search Supplies">
                <button class="supplyBTn" type="button" onclick="openSuppliesModal()">+ Add Stock</button>
            </div>


            {{-- SUPPLY TABLE --}}
            <div class="supply-wrapper-container">
                <table class="supply-table-container">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Total Quantity</th>
                        </tr>
                    </thead>
                  <tbody>
            @forelse($groupedSupplies as $supply)
                <tr>
                    <td>{{ $supply->supply_name }}</td>
                    <td>{{ $supply->quantity }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align:center;">No supplies found.</td>
                </tr>
            @endforelse
        </tbody>
                </table>
            </div>
        </div>

        {{-- ======================= RECENT SUPPLIES ADDED ======================= --}}
        <div class="supply-top-box">
            <h3 class="supply-stock-header">Recent Add Supplies</h3>
            <div class="recent-wrapper-box">
                <table class="recent-table-container">
                    <thead>
                        <tr>
                            <th>Created</th>
                            <th>Name</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($supplies as $supply)
                            <tr>
                                <td>{{ $supply->created_at }}</td>
                                <td>{{ $supply->supplies }}</td>
                                <td>{{ $supply->quantity }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align:center;">No supplies found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ======================= SUPPLY SUMMARY ======================= --}}
    <div class="supply-all-overview-container">
        <div class="supply-overall-box">
            <h3 class="supply-summary-header">Supply Summary</h3>
            <div class="supply-summary-wrapper-container">
                <table class="supply-table-summary">
                    <thead>
                        <tr>
                            <th>Created</th>
                            <th>Name</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($supplies as $supply)
                            <tr>
                                <td>{{ $supply->created_at }}</td>
                                <td>{{ $supply->supplies }}</td>
                                <td>{{ $supply->quantity }}</td>
                                <td>
                        <form action="{{ route('supplies.delete', $supply->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                    class="editBtn" 
                                    data-id="{{ $supply->id }}" 
                                    data-name="{{ $supply->supply }}" 
                                    data-quantity="{{ $supply->quantity }}">
                                Edit
                            </button>
                            <button type="submit" class="deleteBtn">Delete</button>
                        </form>
                    </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align:center;">No supplies found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ======================= EQUIPMENT SECTION ======================= --}}
    <div class="equipment-main-container">
        <div class="equipment-main-box">

            {{-- EQUIPMENT HEADER --}}
            <h3 class="supply-stock-header">Equipment Stocks</h3>

            {{-- ADD EQUIPMENT FORM --}}
            <div class="add-equipment-container">
                <h3 class="add-supply-header">Add Equipment</h3>
                <div class="equipment-form-container">
                    <form method="POST" action="{{ route('equipment.store') }}">
                        @csrf
                        <div class="info-container">
                            <label for="equipment">Equipment:</label>
                            <input list="equipment-list" name="equipment" id="equipment" placeholder="Select Equipment..." required>
                            <datalist id="equipment-list">
                                <option value="LED">
                                <option value="Chairs">
                                <option value="Table">
                                <option value="Fan">
                                <option value="Gameboard">
                                <option value="Speaker">
                            </datalist>
                        </div>

                        <div class="info-container">
                            <label for="quantity">Quantity:</label>
                            <input type="number" name="quantity" id="quantity" placeholder="Quantity..." required>
                        </div>

                        <div class="info-btn">
                            <button type="submit" name="submit">Create</button>
                            <button type="button" name="cancel" onclick="closeEquipmentModal()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- EQUIPMENT LIST TABLE --}}
            <div class="equipment-subheader-box">
                <input type="text" name="search" id="search" placeholder="Search Equipments">
                <button class="equipmentBTn" type="button" onclick="showAddEquipment()">+ Add Equipment</button>
            </div>

            <div class="equipment-wrapper-container">
                <table class="equipment-table-container">
                    <thead>
                        <tr>
                            <th>Created</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($equipmentList as $equipment)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($equipment->latest_created)->format('Y-m-d') }}</td>
                                <td>{{ $equipment->equipment }}</td>
                                <td>{{ $equipment->quantity }}</td>
                                <td>
                                    <form action="{{ route('equipment.deleteByName', $equipment->equipment) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="deleteBtn" onclick="return confirm('Delete all records of {{ $equipment->equipment }}?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align:center;">No equipment available</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

        {{-- ======================= CALENDAR SECTION ======================= --}}
        <div class="calendar-equipment-box">
            <div class="calendar-header">
                <button id="prevMonth">&lt;</button>
                <h2 id="monthYear"></h2>
                <button id="nextMonth">&gt;</button>
            </div>
            <div class="calendar-days-header">
                <div>Sun</div>
                <div>Mon</div>
                <div>Tue</div>
                <div>Wed</div>
                <div>Thu</div>
                <div>Fri</div>
                <div>Sat</div>
            </div>
            <div class="calendar-days"></div>
        </div>
    </div>
</div>

{{-- ======================= JAVASCRIPT SECTION ======================= --}}
<script>
    // ✅ SUPPLY MODAL HANDLERS
    function openSuppliesModal() {
        document.querySelector('.add-supply-container').style.display = 'block';
    }

    function closeSuppliesModal() {
        document.querySelector('.add-supply-container').style.display = 'none';
    }

    // ✅ EQUIPMENT MODAL HANDLERS
    function showAddEquipment() {
        document.querySelector('.add-equipment-container').style.display = 'block';
    }

    function closeEquipmentModal() {
        document.querySelector('.add-equipment-container').style.display = 'none';
    }

    // ✅ CALENDAR SCRIPT
    const monthYear = document.getElementById("monthYear");
    const calendarDays = document.querySelector(".calendar-days");
    const prevMonthBtn = document.getElementById("prevMonth");
    const nextMonthBtn = document.getElementById("nextMonth");

    let date = new Date();
    let startDate = null;
    let endDate = null;

    function renderCalendar() {
        const year = date.getFullYear();
        const month = date.getMonth();

        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);

        const startDay = firstDay.getDay();
        const totalDays = lastDay.getDate();

        monthYear.textContent = `${date.toLocaleString("default", { month: "long" })} ${year}`;
        calendarDays.innerHTML = "";

        // Empty boxes before start
        for (let i = 0; i < startDay; i++) {
            const emptyDiv = document.createElement("div");
            calendarDays.appendChild(emptyDiv);
        }

        // Create days
        for (let day = 1; day <= totalDays; day++) {
            const dayDiv = document.createElement("div");
            dayDiv.textContent = day;

            const currentDate = new Date(year, month, day);

            // Highlight today's date
            const today = new Date();
            if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                dayDiv.classList.add("today");
            }

            // Highlight selected range
            if (startDate && endDate && currentDate >= startDate && currentDate <= endDate) {
                dayDiv.classList.add("in-range");
            }

            // Highlight start & end dates
            if (startDate && currentDate.getTime() === startDate.getTime()) {
                dayDiv.classList.add("start-date");
            }
            if (endDate && currentDate.getTime() === endDate.getTime()) {
                dayDiv.classList.add("end-date");
            }

            // Click event for range selection
            dayDiv.addEventListener("click", () => handleDateClick(currentDate));
            calendarDays.appendChild(dayDiv);
        }
    }

    function handleDateClick(selectedDate) {
        if (!startDate || (startDate && endDate)) {
            startDate = selectedDate;
            endDate = null;
        } else if (selectedDate < startDate) {
            endDate = startDate;
            startDate = selectedDate;
        } else {
            endDate = selectedDate;
        }

        renderCalendar();

        if (startDate && endDate) {
            console.log("🗓️ Date Range Selected:", startDate.toDateString(), "→", endDate.toDateString());
        }
    }

    prevMonthBtn.addEventListener("click", () => {
        date.setMonth(date.getMonth() - 1);
        renderCalendar();
    });

    nextMonthBtn.addEventListener("click", () => {
        date.setMonth(date.getMonth() + 1);
        renderCalendar();
    });

    renderCalendar();

    // ✅ SHOW OTHER SUPPLY FIELD IF SELECTED
    function checkOtherSupply() {
        const supplyInput = document.getElementById('supplies');
        const otherContainer = document.getElementById('other-supply-container');
        const otherInput = document.getElementById('other_supply');

        if (supplyInput.value === 'Add Other Supply') {
            otherContainer.style.display = 'block';
            otherInput.required = true;
            otherInput.focus();
        } else {
            otherContainer.style.display = 'none';
            otherInput.required = false;
            otherInput.value = '';
        }
    }


    // ✅ Edit Button Function
document.querySelectorAll('.editBtn').forEach(button => {
    button.addEventListener('click', function () {
        const id = this.dataset.id;
        const name = this.dataset.name;
        const quantity = this.dataset.quantity;

        // Open modal
        document.querySelector('.add-supply-container').style.display = 'block';

        // Fill form fields
        document.getElementById('supplies').value = name;
        document.getElementById('quantity').value = quantity;

        // Update form to edit mode
        const form = document.getElementById('supplyForm');
        const methodInput = document.getElementById('formMethod');
        const submitBtn = document.getElementById('submitBtn');
        const supplyIdInput = document.getElementById('supply_id');

        form.action = `/supplies/update/${id}`;
        methodInput.value = 'PUT';
        submitBtn.textContent = 'Update';
        supplyIdInput.value = id;
    });
});
</script>

@endsection

