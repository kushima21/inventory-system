@extends('layout.faculty')
@vite(['resources/css/faculty.css', 'resources/js/app.js'])
<link rel="stylesheet" href="{{ asset('resources/css/faculty.css') }}">
@php
    $user = \App\Models\User::find(session('user_id'));
@endphp

@section('content')
<div class="faculty-request-main-container">

    <!-- Header -->
    <h2 class="faculty-main-header">Welcome, {{ $user->name ?? '' }}!</h2>
    <h3 class="faculty-subheader">Need something? Send a Request!</h3>

    <!-- MODAL -->
    <div class="faculty-request-modal-container" id="requestModal">
        <h3 class="request-header-form">Supply Request Form</h3>
        <div class="request-form-box-container">
            <form method="POST" action="{{ route('faculty.request.store') }}" id="facultyRequestForm">
                @csrf
                <input type="hidden" name="category" id="category">

                <!-- User Information -->
                <div class="form-request-box-container">
                    <div class="request-info">
                        <label for="name">Fullname</label>
                        <input type="text" name="name" id="name" value="{{ $user->name ?? '' }}">
                    </div>

                    <div class="request-info">
                        <label for="phone_number">Phone Number</label>
                        <input type="number" name="phone_number" id="phone_number" value="{{ $user->phone_number ?? '' }}">
                    </div>

                    <div class="request-info">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" value="{{ $user->email ?? '' }}">
                    </div>

                    <!-- Dates -->
                    <div class="request-info">
                        <label for="date_needed">Date Needed</label>
                        <input type="date" name="date_needed" id="date_needed" required>
                    </div>

                    <div class="request-info" id="return-date-container" style="display:none;">
                        <label for="date_return">Return Date</label>
                        <input type="date" name="date_return" id="date_return">
                    </div>

                    <!-- Supply Request -->
                    <h3 class="request-subheader">Requested Supply</h3>

                    <div class="request-info">
                        <label for="supply_name">Supplies Name</label>
                        <input type="text" name="supply_name" id="supply_name" readonly>
                    </div>

                    <div class="request-info">
                        <label for="quantity">Supplies Requested (Qty)</label>
                        <input type="number" name="quantity" id="quantity">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="request-btn-container">
                    <button type="submit" name="submit">Submit</button>
                    <button type="button" class="closeBtn">Close</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="faculty-request-search-container">
        <input type="text" name="searchSupplies" placeholder="Quick Search Supplies">
    </div>

    <!-- Supplies List -->
    <h3 class="list-supplies-header">List of Supplies</h3>
    <div class="faculty-request-wrapper-container">
        <table class="faculty-table-container">
            <thead>
                <tr>
                    <th>Supply Name</th>
                    <th>Availability</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($supplies as $supply)
                    <tr>
                        <td>{{ $supply->supply_name }}</td>
                        <td>{{ $supply->quantity }}</td>
                        <td>{{ $supply->category }}</td>
                        <td>
                          <button type="button"
    class="requestBtn"
    data-supply="{{ $supply->supply_name }}"
    data-category="{{ $supply->category }}"
    data-available="{{ $supply->quantity }}">
    Request
</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;">No supplies available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<!-- SCRIPT SECTION -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('requestModal');
    const closeBtn = document.querySelector('.closeBtn');
    const supplyInput = document.getElementById('supply_name');
    const categoryInput = document.getElementById('category');
    const returnDateContainer = document.getElementById('return-date-container');
    const returnDateInput = document.getElementById('date_return');
    const requestButtons = document.querySelectorAll('.requestBtn');
    const form = document.getElementById('facultyRequestForm');
    const qtyInput = document.getElementById('quantity');

    // 🔴 CSS Class (auto added when exceed)
    const errorClass = "input-error";

    // 🔽 CLICKING REQUEST BUTTON
    requestButtons.forEach(button => {
        button.addEventListener('click', () => {
            const supplyName = button.dataset.supply;
            const category = button.dataset.category;
            const available = button.dataset.available; // ← GET AVAILABLE STOCK

            supplyInput.value = supplyName;
            categoryInput.value = category;

            // ⚠️ Store available stock inside quantity input
            qtyInput.dataset.available = available;
            qtyInput.classList.remove(errorClass); // remove red when opening modal
            qtyInput.value = "";

            if (category.toLowerCase() === 'equipment') {
                returnDateContainer.style.display = 'block';
                returnDateInput.required = true;
                returnDateInput.disabled = false;
            } else {
                returnDateContainer.style.display = 'none';
                returnDateInput.required = false;
                returnDateInput.disabled = true;
                returnDateInput.value = '';
            }

            modal.classList.add('active');
        });
    });

    // 🔽 CLOSE BUTTON
    closeBtn.addEventListener('click', () => {
        modal.classList.remove('active');
    });

    // 🔴 QUANTITY EXCEED CHECKER
    qtyInput.addEventListener('input', function () {
        const typed = parseInt(this.value);
        const max = parseInt(this.dataset.available);

        if (typed > max) {
            this.classList.add(errorClass); // 🔴 turn red
        } else {
            this.classList.remove(errorClass); // ✔ remove red
        }
    });

    // 🔽 FORM VALIDATION
    form.addEventListener('submit', (e) => {
        const categoryValue = categoryInput.value.trim().toLowerCase();

        if (!categoryValue) {
            e.preventDefault();
            alert('Category not detected. Please click Request again.');
            return;
        }

        if (qtyInput.classList.contains(errorClass)) {
            e.preventDefault();
            alert('Quantity exceeds available stock.');
            return;
        }

        if (categoryValue === 'equipment' && !returnDateInput.value) {
            e.preventDefault();
            alert('Please select a return date for equipment.');
            return;
        }
    });
});
</script>


@endsection
