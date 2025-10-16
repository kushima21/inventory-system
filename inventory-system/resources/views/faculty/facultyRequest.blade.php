@extends('layout.faculty')
@vite(['resources/css/faculty.css', 'resources/js/app.js'])

@php
$user = \App\Models\User::find(session('user_id'));
@endphp

@section('content')
<div class="faculty-request-main-container">
    <h2 class="faculty-main-header">
        Welcome, {{ $user->name ?? '' }}!
    </h2>
    <h3 class="faculty-subheader">
        Need something? Send a Request!
    </h3>

    <!-- MODAL -->
    <div class="faculty-request-modal-container" id="requestModal">
        <h3 class="request-header-form">
            Supply Request Form
        </h3>
        <div class="request-form-box-container">
            <form method="POST" action="{{ route('faculty.request.store') }}">
                @csrf
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
                    <div class="request-info">
                        <label for="date_needed">Date Needed</label>
                        <input type="date" name="date_needed" id="date_needed" required>
                    </div>

                    <h3 class="request-subheader">
                        Requested Supply
                    </h3>

                    <div class="request-info">
                        <label for="supply_name">Supplies Name</label>
                        <input type="text" name="supply_name" id="supply_name" readonly>
                    </div>

                    <div class="request-info">
                        <label for="quantity">Supplies Requested (Qty)</label>
                        <input type="number" name="quantity" id="quantity">
                    </div>
                </div>

                <div class="request-btn-container">
                    <button type="submit" name="submit">Submit</button>
                    <button type="button" class="closeBtn">Close</button>
                </div>
            </form>
        </div>
    </div>

    <!-- SEARCH BAR -->
    <div class="faculty-request-search-container">
        <input type="text" name="searchSupplies" placeholder="Quick Search Supplies">
    </div>

    <h3 class="list-supplies-header">
        List of Supplies
    </h3>

    <div class="faculty-request-wrapper-container">
        <table class="faculty-table-container">
            <thead>
                <tr>
                    <th>Supply Name</th>
                    <th>Availability</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($supplies as $supply)
                    <tr>
                        <td>{{ $supply->supplies }}</td>
                        <td>{{ $supply->quantity }}</td>
                        <td>
                            <button type="button" 
                                    class="requestBtn" 
                                    data-supply="{{ $supply->supplies }}">
                                Request
                            </button>
                        </td>
                    </tr>
                @endforeach
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
    const requestButtons = document.querySelectorAll('.requestBtn');

    // open modal and set supply name
    requestButtons.forEach(button => {
        button.addEventListener('click', () => {
            const supplyName = button.getAttribute('data-supply');
            supplyInput.value = supplyName; // display supply name in input
            modal.classList.add('active');  // show modal
        });
    });

    // close modal
    closeBtn.addEventListener('click', () => {
        modal.classList.remove('active');
    });
});
</script>
@endsection
