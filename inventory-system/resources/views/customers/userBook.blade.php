@extends('partials.navbar') 
@vite(['resources/css/book.css', 'resources/js/app.js'])

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
            <form action="" method="POST">
                <div class="form-m-modal-container">
                    <div class="f-container">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" placeholder="Enter your name..." readonly>
                    </div>
                    <div class="f-container">
                        <label for="contact_number">Contact Number</label>
                        <input type="tel" name="contact_number" id="contact_number" placeholder="Enter your phone number..." required>
                    </div>
                    <div class="f-container">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" placeholder="Enter your address..." required></textarea>
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
                        {{-- Pass data via attributes --}}
                        <button 
                            type="button" 
                            class="openBookingBtn"
                            data-package="{{ $gym->package }}"
                            data-days="{{ $gym->days }}"
                            data-price="{{ number_format($gym->price, 2) }}"
                            data-items='@json($gym->equipment->map(fn($e) => $e->pivot->quantity . " " . $e->equipment))'
                        >
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

    // Buttons for each package
    document.querySelectorAll(".openBookingBtn").forEach(btn => {
        btn.addEventListener("click", function () {
            // Fill modal with related data
            document.getElementById("modalPackage").innerText = this.dataset.package;
            document.getElementById("modalPrice").innerText = "Total Php: " + this.dataset.price;

            // Parse items array
            const items = JSON.parse(this.dataset.items);
            const itemsList = document.getElementById("modalItems");
            itemsList.innerHTML = "";
            if(items.length){
                items.forEach(i => {
                    const li = document.createElement("li");
                    li.textContent = i;
                    itemsList.appendChild(li);
                });
            } else {
                itemsList.innerHTML = "<li>No equipment included.</li>";
            }

            // Show booking form first
            modalBox.style.display = "flex";
            packageModal.style.display = "none";
        });
    });

    // When View Packages button clicked → show package modal
    viewBtn.addEventListener("click", () => {
        packageModal.style.display = "block";
    });

    // Close modals
    closeBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            modalBox.style.display = "none";
            packageModal.style.display = "none";
        });
    });

    // Optional: click outside to close
    window.addEventListener("click", (e) => {
        if (e.target === modalBox) {
            modalBox.style.display = "none";
            packageModal.style.display = "none";
        }
    });
});
</script>
@endsection
