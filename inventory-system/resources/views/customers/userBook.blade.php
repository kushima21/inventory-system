@extends('partials.navbar')
@vite(['resources/css/book.css', 'resources/js/app.js'])

@php
    $user = \App\Models\User::find(session('user_id'));
@endphp


@section('content')
<div class="content-main-container">

    {{-- Booking modal (default hidden) --}}
    <div class="booking-modal-form-box" style="display:none;">
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
                    {{-- Hidden IDs --}}
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

                    <div class="f-btn-form">
                        <button type="button" name="v-btn">View Packages..</button>
                        <button type="submit" name="submit" class="s-btn">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Displaying packages --}}
    <div class="main-booking-container">
        <div class="ball-image">
            <img src="{{ asset('icons/basket-ball.png') }}" alt="basket Image" class="ball-img">
            <h2 class="book-header">" Basketball Court Reservations Made Easy "</h2>
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

{{-- JS --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const modalBox = document.querySelector(".booking-modal-form-box");
    const packageModal = document.querySelector(".m-view-modal");
    const viewBtn = document.querySelector('button[name="v-btn"]');
    const closeBtns = modalBox.querySelectorAll(".close-view-btn, .close-btn");

    // Open Booking Modal and populate hidden inputs
    document.querySelectorAll(".openBookingBtn").forEach(btn => {
        btn.addEventListener("click", function () {
            const packageName = this.dataset.package || "Unknown Package";
            const price = this.dataset.price || "0";
            const items = JSON.parse(this.dataset.items || "[]");
            const gymId = this.dataset.gymId;
            const equipmentId = this.dataset.equipmentId;

            // ✅ Set modal info
            document.getElementById("modalPackage").innerText = packageName;
            document.getElementById("modalPrice").innerText = "Total Php: " + price;

            // ✅ Save hidden IDs for submission
            document.getElementById("gym_id").value = gymId;
            document.getElementById("equipment_id").value = equipmentId;

            // ✅ List items
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

            // ✅ Show booking modal
            modalBox.style.display = "flex";
            packageModal.style.display = "none";
        });
    });

    // View Packages
    viewBtn.addEventListener("click", () => {
        packageModal.style.display = "block";
    });

    // Close modal
    closeBtns.forEach(btn => btn.addEventListener("click", () => {
        modalBox.style.display = "none";
        packageModal.style.display = "none";
    }));

    // Click outside to close
    window.addEventListener("click", (e) => {
        if (e.target === modalBox || e.target === packageModal) {
            modalBox.style.display = "none";
            packageModal.style.display = "none";
        }
    });
});
</script>
@endsection
