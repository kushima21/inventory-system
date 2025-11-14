@extends('partials.navbar')
@vite(['resources/css/book.css', 'resources/js/app.js'])
@php
    $user = \App\Models\User::find(session('user_id'));
@endphp
<link rel="stylesheet" href="{{ asset('resources/css/book.css') }}">
@if ($errors->any())
    <div style="background:#ffb3b3; padding:10px; margin-bottom:10px; border-radius:5px;">
        <strong>⚠️ There are errors:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('error'))
    <div style="background:#ffcccc; padding:10px; border-radius:5px;">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div style="background:#c2f0c2; padding:10px; border-radius:5px;">
        {{ session('success') }}
    </div>
@endif
@section('content')
<div class="content-main-container">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    {{-- Booking modal (default hidden) --}}
    <div class="booking-modal-form-box" style="display:none;">

            {{-- Additional Equipment Modal --}}
            <div class="additonal-modal-container">
                <div class="form-header">
                    <h2 class="m-view-header">Add More Equipment</h2>
                    <button class="close-additional-btn" type="button">&times;</button>
                </div>
                <h2 class="add-subheader">List of Equipment</h2>
               <div class="list-of-equipment-bundle-container">
                    @forelse($bundles as $bundle)
                        <div class="list-bundle-box" data-defaultqty="{{ $bundle->quantity }}">
                            <label>
                                <input 
                                    type="checkbox" 
                                    name="selected_bundles[]" 
                                    value="{{ $bundle->id }}" 
                                    class="bundle-checkbox"
                                >
                                {{ $bundle->equipment->equipment ?? 'Unknown Equipment' }} 
                                <span>- {{ $bundle->quantity }} {{ $bundle->quantity > 1 ? 'bundles' : 'bundle' }}</span>
                            </label>
                            <p>Price: {{ number_format($bundle->price, 2) }}</p>
                            <input 
                                type="number" 
                                name="bundle_quantity[{{ $bundle->id }}]" 
                                id="quantity_{{ $bundle->id }}" 
                                placeholder="Qty" 
                                min="1"
                                disabled
                            >
                        </div>
                    @empty
                        <p>No equipment bundles available.</p>
                    @endforelse
                </div>
                <div class="total-list-equipment-container">
                    <button type="button" class="add-equipment-btn">Add Equipment</button>
                </div>
                </div>

            {{-- Package view modal --}}
            <div class="m-view-modal" style="display:none;">
                <div class="form-header">
                    <h2 class="m-view-header" id="modalPackage">All Star Premium Packages</h2>
                    <button class="close-view-btn" type="button">&times;</button>
                </div>
                <h3 class="m-list-header">List of Item Includes:</h3>
                <ul class="items-list" id="modalItems">
                    <li>No equipment</li>
                </ul>

                <p class="additional-list-head">Additional List</p>
                <ul class="additional-list"></ul>
                <p class="additional-payment">Total Addional Payment</p>
                <span class="total-add-pay"></span>

                <div class="h-btn-container">
                    <h3 class="b-price" id="modalPrice">Total Php: 0.00</h3>
                    <button class="add-more" type="button">Add More</button>
                </div>
        </div>

        {{-- Booking form modal --}}
        <div class="modal-box-1">
            <div class="form-header">
                <h3>Gym Booking Form</h3>
                <button class="close-btn" type="button">&times;</button>
            </div>
            <form action="{{ route('booking.store') }}" method="POST">
                @csrf
                <div class="form-m-modal-container">
                    <input type="hidden" name="additional_equipments" id="additional_equipments">
                    <input type="hidden" name="user_id" value="{{ $user ? $user->id : '' }}">
                    <input type="hidden" name="gym_id" id="gym_id">
                    <input type="hidden" name="equipment_id" id="equipment_id">

                    <div class="f-container">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name"
                            value="{{ $user ? $user->name : '' }}" readonly>
                    </div>

                    <div class="f-container">
                        <label for="contact_number">Contact Number</label>
                        <input type="tel" name="contact_number" id="contact_number"
                            placeholder="Enter your phone number..." required>
                    </div>

                    <div class="f-container">
                        <label for="address">Address</label>
                        <textarea name="address" id="address"
                            placeholder="Enter your address..." required></textarea>
                    </div>

                    <div class="f-container">
                        <label for="starting_date">Starting Date</label>
                        <input type="date" name="starting_date" id="starting_date" required>
                    </div>

                    <div class="f-container">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" id="end_date" required>
                    </div>

                    <div class="f-container">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="3" placeholder="Add Description...(Optional)" style="resize: none;"></textarea>
                    </div>


                    <div class="f-btn-form">
                        <button type="button" name="v-btn">View Packages..</button>
                        <button type="submit" name="submit" id="submit" class="s-btn">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Displaying packages --}}
    <div class="main-booking-container">
        <div class="ball-image">
            <img src="{{ asset('icons/basket-ball.png') }}" alt="basket Image" class="ball-img">
            <h2 class="book-header">" Facilities Reservations Made Easy "</h2>
            <p class="book-p">Find the perfect time to play and secure your slot in just a few clicks.</p>
            <h2 class="offer-header">Play & Book Packages:</h2>
        </div>
    </div>

    <div class="booking-box-container">
        @if(isset($gyms) && $gyms->count())
            @foreach($gyms as $gym)
                <div class="booking-box">
                    <h2 class="book-h">{{ $gym->package }}</h2>
                    <h3 class="list-item">List of Items Offer :</h3>
                    <ul class="items-list">
                        @forelse($gym->equipment as $equipment)
                            <li>{{ $equipment->pivot->quantity }} {{ $equipment->equipment }}</li>
                        @empty
                            <li>No equipment included.</li>
                        @endforelse
                    </ul>
                    <div class="book-btn">
                        <h3 class="b-h">Price Php: {{ number_format($gym->price, 2) }}</h3>
                        <button 
                            type="button" 
                            class="openBookingBtn"
                            data-gym-id="{{ $gym->id }}"
                            data-equipment-id="{{ optional($gym->equipment->first())->id }}"
                            data-package="{{ $gym->package }}"
                            data-days="{{ $gym->days }}"
                            data-price="{{ number_format($gym->price, 2) }}"
                            data-items='@json($gym->equipment->map(fn($e) => $e->pivot->quantity . " " . $e->equipment))'>
                            Book Now
                        </button>
                    </div>
                </div>
            @endforeach
        @else
            <p>No packages available.</p>
        @endif
    </div>
</div>

{{-- ✅ JS --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const bookingModal = document.querySelector(".modal-box-1");
    const packageModal = document.querySelector(".m-view-modal");
    const modalBox = document.querySelector(".booking-modal-form-box");
    const viewBtn = document.querySelector('button[name="v-btn"]');
    const closeBookingBtn = bookingModal.querySelector(".close-btn");
    const closeViewBtn = packageModal.querySelector(".close-view-btn");

    const additionalModal = document.querySelector(".additonal-modal-container");
    const addMoreBtn = document.querySelector(".add-more");
    const closeAdditionalBtn = document.querySelector(".close-additional-btn");
    const addEquipmentBtn = document.querySelector(".add-equipment-btn");

    const additionalList = document.querySelector(".m-view-modal .additional-list");
    const totalAdditionalPay = document.querySelector(".total-add-pay");
    const totalPriceElement = document.getElementById("modalPrice");

    const startDateInput = document.getElementById("starting_date");
    const endDateInput = document.getElementById("end_date");

    // 🆕 Hidden input to save total price to database
    let totalHidden = document.createElement("input");
    totalHidden.type = "hidden";
    totalHidden.name = "final_total";
    document.querySelector("form").appendChild(totalHidden);

    let gymPrice = 0;
    let totalAdditional = 0;

    // ✅ Open Booking Modal
    document.querySelectorAll(".openBookingBtn").forEach(btn => {
        btn.addEventListener("click", function () {
            const packageName = this.dataset.package || "Unknown Package";
            const price = parseFloat(this.dataset.price.replace(/,/g, "")) || 0;
            const items = JSON.parse(this.dataset.items || "[]");
            const gymId = this.dataset.gymId;
            const equipmentId = this.dataset.equipmentId;

            gymPrice = price;

            document.getElementById("modalPackage").innerText = packageName;
            totalPriceElement.innerText = "Total Php: " + price.toFixed(2);
            document.getElementById("gym_id").value = gymId;
            document.getElementById("equipment_id").value = equipmentId;

            const itemsList = document.getElementById("modalItems");
            itemsList.innerHTML = "";
            if (items.length) {
                items.forEach(i => {
                    const li = document.createElement("li");
                    li.textContent = i;
                    itemsList.appendChild(li);
                });
            } else {
                itemsList.innerHTML = "<li>No equipment included.</li>";
            }

            modalBox.style.display = "flex";
            packageModal.style.display = "none";
            additionalModal.style.display = "none";
        });
    });

    // ✅ View Modals
    viewBtn.addEventListener("click", () => packageModal.style.display = "block");
    closeViewBtn.addEventListener("click", () => packageModal.style.display = "none");
    closeBookingBtn.addEventListener("click", () => modalBox.style.display = "none");

    // ✅ Additional Equipment Modal
    addMoreBtn?.addEventListener("click", () => additionalModal.style.display = "block");
    closeAdditionalBtn?.addEventListener("click", () => additionalModal.style.display = "none");

    // ✅ Enable quantity input when checkbox checked
    document.querySelectorAll('.bundle-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const qtyInput = this.closest('.list-bundle-box').querySelector('input[type="number"]');
            qtyInput.disabled = !this.checked;
            if (!this.checked) qtyInput.value = '';
        });
    });

    // 🧮 Compute total including days
    function calculateDays() {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);

        if (!startDate || !endDate || endDate < startDate) return 0;

        // Count number of days between
        const diffTime = endDate - startDate;
        return Math.ceil(diffTime / (1000 * 60 * 60 * 24)); // days
    }

    // 🧮 Compute total price
    function updateTotals() {
        totalAdditional = 0;

        additionalList.querySelectorAll("li").forEach(li => {
            const qty = parseInt(li.dataset.qty) || 0;
            const price = parseFloat(li.dataset.price) || 0;
            const defaultQty = parseInt(li.dataset.defaultQty) || 1;
            const itemTotal = (qty / defaultQty) * price;

            totalAdditional += itemTotal;

            const priceDisplay = li.querySelector(".item-total");
            if (priceDisplay) {
                priceDisplay.textContent = `₱${itemTotal.toFixed(2)}`;
            } else {
                li.insertAdjacentHTML("beforeend", 
                    `<span class="item-total" style="margin-left:8px;color:#555;">₱${itemTotal.toFixed(2)}</span>`);
            }
        });

        const numDays = calculateDays();
        const totalGym = gymPrice * (numDays > 0 ? numDays : 1);
        const finalTotal = totalGym + totalAdditional;

        totalAdditionalPay.textContent = "Php: " + totalAdditional.toFixed(2);
        totalPriceElement.textContent = `Total Php: ${finalTotal.toFixed(2)}`;
        totalHidden.value = finalTotal.toFixed(2); // save to DB
    }

    // 🧹 Remove item
    function attachRemoveEvent(button) {
        button.addEventListener("click", () => {
            button.parentElement.remove();
            updateTotals();
        });
    }

    // ✅ Add Equipment
    addEquipmentBtn?.addEventListener("click", () => {
        const selectedBundles = document.querySelectorAll('.bundle-checkbox:checked');
        if (!selectedBundles.length) {
            alert('Please select at least one equipment.');
            return;
        }

        selectedBundles.forEach(checkbox => {
            const listBox = checkbox.closest('.list-bundle-box');
            const qtyInput = listBox.querySelector('input[type="number"]');
            const qty = parseInt(qtyInput.value.trim());
            if (!qty || qty <= 0) return;

            const label = listBox.querySelector('label');
            const equipmentName = label.textContent.split('-')[0].trim();
            const lowerName = equipmentName.toLowerCase();

            const priceText = listBox.querySelector('p').textContent.replace("Price:", "").trim();
            const price = parseFloat(priceText.replace(/,/g, "")) || 0;
            const defaultQty = parseInt(listBox.dataset.defaultqty) || 1;

            let existingItem = Array.from(additionalList.querySelectorAll('li'))
                .find(li => li.dataset.name === lowerName);

            if (existingItem) {
                existingItem.dataset.qty = qty;
                existingItem.querySelector("span").textContent = qty;
            } else {
                const li = document.createElement('li');
                li.dataset.name = lowerName;
                li.dataset.qty = qty;
                li.dataset.price = price;
                li.dataset.defaultQty = defaultQty;

                li.innerHTML = `
                    ${equipmentName} - ₱${price.toFixed(2)} × <span>${qty}</span>
                    <button type="button" class="remove-item-btn" style="
                        border:none;background:none;color:red;font-weight:bold;
                        margin-left:8px;cursor:pointer;">&times;</button>
                `;
                additionalList.appendChild(li);
                attachRemoveEvent(li.querySelector(".remove-item-btn"));
            }

            qtyInput.value = '';
            checkbox.checked = false;
            qtyInput.disabled = true;
        });

        additionalModal.style.display = "none";
        updateTotals();
    });

    // 🔄 Recalculate when dates change
    startDateInput.addEventListener("change", updateTotals);
    endDateInput.addEventListener("change", updateTotals);

    // ✅ Prepare data before submit
    document.querySelector('.s-btn').addEventListener('click', function () {
        const equipmentData = [];

        document.querySelectorAll('.m-view-modal .additional-list li').forEach(li => {
            equipmentData.push({
                name: li.dataset.name,
                quantity: li.dataset.qty,
                price: li.dataset.price,
                total: (li.dataset.qty / li.dataset.defaultQty) * li.dataset.price
            });
        });

        document.getElementById('additional_equipments').value = JSON.stringify(equipmentData);
        updateTotals(); // ensure latest total is stored
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const startDateInput = document.getElementById("starting_date");
    const endDateInput = document.getElementById("end_date");
    let startPicker, endPicker;

    // ✅ Function to load all booked dates (no longer gym-specific)
    function loadDisabledDates() {
        fetch(`/booked-dates`)
            .then(response => response.json())
            .then(disabledDates => {
                if (startPicker) startPicker.destroy();
                if (endPicker) endPicker.destroy();

                // 🧱 Initialize flatpickr with locked dates across all packages
                startPicker = flatpickr(startDateInput, {
                    dateFormat: "Y-m-d",
                    minDate: "today",
                    disable: disabledDates,
                    onDayCreate: function(_, __, ___, dayElem) {
                        if (dayElem.classList.contains("flatpickr-disabled")) {
                            dayElem.style.backgroundColor = "#ffb3b3";
                            dayElem.style.color = "#000";
                            dayElem.style.borderRadius = "5px";
                            dayElem.style.cursor = "not-allowed";
                            dayElem.title = "❌ Already booked";
                        }
                    },
                    onChange: function(selectedDates) {
                        if (selectedDates.length > 0) {
                            endPicker.set('minDate', selectedDates[0]);
                        }
                    }
                });

                endPicker = flatpickr(endDateInput, {
                    dateFormat: "Y-m-d",
                    minDate: "today",
                    disable: disabledDates,
                    onDayCreate: function(_, __, ___, dayElem) {
                        if (dayElem.classList.contains("flatpickr-disabled")) {
                            dayElem.style.backgroundColor = "#ffb3b3";
                            dayElem.style.color = "#000";
                            dayElem.style.borderRadius = "5px";
                            dayElem.style.cursor = "not-allowed";
                            dayElem.title = "❌ Already booked";
                        }
                    }
                });
            })
            .catch(err => console.error("Error fetching booked dates:", err));
    }

    // ✅ Load locked dates when any "Book Now" button is clicked
    document.querySelectorAll(".openBookingBtn").forEach(btn => {
        btn.addEventListener("click", function () {
            loadDisabledDates(); // load globally locked booked dates
        });
    });
});
</script>




@endsection
