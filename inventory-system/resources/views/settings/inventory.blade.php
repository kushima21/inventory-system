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
                            <input type="number" name="quantity" id="supply_quantity" placeholder="Quantity..." required>
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
                <form method="GET" action="{{ route('inventory') }}" style="display: flex; gap: 10px;">
                    <input type="text" name="supply_search" placeholder="Search Supplies" value="{{ request('supply_search') }}">
                    <button type="submit" class="supplyBTn">Search</button>
                </form>
                <button class="supplyBTn" type="button" onclick="openSuppliesModal()">+ Add Stock</button>
            </div>

            {{-- SUPPLY TABLE --}}
            <div class="supply-wrapper-container">
                <table class="supply-table-container">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Total Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($groupedSupplies as $supply)
                            <tr>
                                <td>{{ $supply->supply_name }}</td>
                                <td>{{ $supply->quantity }}</td>
                                <td>
                                    <button type="button"
                                            class="editSupplyBtn"
                                            data-id="{{ $supply->id }}"
                                            data-name="{{ $supply->supply_name }}"
                                            data-quantity="{{ $supply->quantity }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('supplies.delete', $supply->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this supply?');" class="deleteBtn">Delete</button>
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
                            <input list="equipment-list" name="equipment" id="equipment_input" placeholder="Select Equipment..." required>
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
                            <input type="number" name="quantity" id="equipment_quantity" placeholder="Quantity..." required>
                        </div>

                        <div class="info-btn">
                            <button type="submit" name="submit" id="equipmentSubmitBtn">Create</button>
                            <button type="button" name="cancel" onclick="closeEquipmentModal()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- EQUIPMENT LIST TABLE --}}
            <div class="equipment-subheader-box">
                <form method="GET" action="{{ route('inventory') }}" style="display: flex; gap: 10px;">
                    <input type="text" name="equipment_search" placeholder="Search Equipments" value="{{ request('equipment_search') }}">
                    <button type="submit" class="equipmentBTn">Search</button>
                </form>
                <button class="equipmentBTn" type="button" onclick="showAddEquipment()">+ Add Equipment</button>
            </div>

            <div class="equipment-wrapper-container">
                <table class="equipment-table-container">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Total Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($groupedEquipment)
                            @forelse ($groupedEquipment as $equipment)
                                <tr>
                                    <td>{{ $equipment->equipment_name }}</td>
                                    <td>{{ $equipment->quantity }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" style="text-align:center;">No data available</td>
                                </tr>
                            @endforelse
                        @else
                            <tr>
                                <td colspan="2" style="text-align:center;">No data available</td>
                            </tr>
                        @endisset
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

    {{-- ======================= EQUIPMENT SUMMARY ======================= --}}
    <div class="equipment-inventory-wrapper">
        <h2 class="equipment-sum-header">Equipment Summary</h2>
        <table class="equipment-inventory-table">
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
                            <button type="button"
                                    class="editEquipmentBtn"
                                    data-equipment="{{ $equipment->equipment }}"
                                    data-quantity="{{ $equipment->quantity }}">
                                Edit
                            </button>
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

{{-- ======================= JAVASCRIPT SECTION ======================= --}}
<script>
    // ======================= SUPPLY MODAL =======================
    function openSuppliesModal() { document.querySelector('.add-supply-container').style.display = 'block'; }
    function closeSuppliesModal() { document.querySelector('.add-supply-container').style.display = 'none'; }

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

    document.querySelectorAll('.editSupplyBtn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const quantity = this.dataset.quantity;

            document.querySelector('.add-supply-container').style.display = 'block';
            document.getElementById('supplies').value = name;
            document.getElementById('supply_quantity').value = quantity;

            const form = document.getElementById('supplyForm');
            form.action = `/supplies/update/${id}`;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('submitBtn').textContent = 'Update';
            document.getElementById('supply_id').value = id;
        });
    });

    // ======================= EQUIPMENT MODAL =======================
    function showAddEquipment() { document.querySelector('.add-equipment-container').style.display = 'block'; }
    function closeEquipmentModal() { document.querySelector('.add-equipment-container').style.display = 'none'; }

    document.querySelectorAll('.editEquipmentBtn').forEach(button => {
        button.addEventListener('click', function() {
            const equipmentName = this.dataset.equipment;
            const quantity = this.dataset.quantity;

            const formContainer = document.querySelector('.add-equipment-container');
            const formHeader = formContainer.querySelector('.add-supply-header');
            const equipmentInput = document.getElementById('equipment_input');
            const quantityInput = document.getElementById('equipment_quantity');
            const form = formContainer.querySelector('form');

            formContainer.style.display = 'block';
            formHeader.textContent = 'Edit Equipment';
            equipmentInput.value = equipmentName;
            quantityInput.value = quantity;

            form.action = `/equipment/update/${encodeURIComponent(equipmentName)}`;
            form.querySelector('#equipmentSubmitBtn').textContent = 'Update';
        });
    });
</script>
<script>
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
</script>


@endsection
