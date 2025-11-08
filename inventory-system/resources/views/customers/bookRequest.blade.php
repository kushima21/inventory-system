@extends('partials.sideBar')
@vite(['resources/css/bookRequest.css', 'resources/js/app.js'])
<link rel="stylesheet" href="{{ asset('resources/css/bookRequest.css') }}">
@php
$user = \App\Models\User::find(session('user_id'));
@endphp
@section('Sidecontent')
<h2 class="profile-header">Booking Request</h2>

<div class="requestTab-container">
    <div class="tab-btn">
        <button type="button" class="requestBtn" id="PendingBtn">Pending Booking Request</button>
        <button type="button" class="requestBtn" id="ApprovedBtn">Approved Booking Request</button>
        <button type="button" class="requestBtn" id="cancelBtn">Cancelled Booking Request</button>
        <button type="button" class="requestBtn" id="historyBtn">Booking History Request</button>
    </div>
</div>

<div class="cancel-modal-container" id="cancelModal" style="display:none;">
    <div class="cancel-form-box">
        <h3 class="cancel-header">Cancellation Form</h3>
        <h3 class="select-reason">Select a reason</h3>
        <form id="cancelForm" action="{{ route('booking.cancel') }}" method="POST">
            @csrf
            <input type="hidden" name="booking_id" id="cancelBookingId"> <!-- ✅ booking_id holder -->

            <div class="checkbox-group">
                <label><input type="checkbox" name="reason[]" value="change_of_plans"> Change of plans</label>
                <label><input type="checkbox" name="reason[]" value="found_better_option"> Found a better option</label>
                <label><input type="checkbox" name="reason[]" value="personal_emergency"> Personal emergency</label>
                <label><input type="checkbox" name="reason[]" value="schedule_conflict"> Schedule conflict</label>
                <label><input type="checkbox" name="reason[]" value="high_cost"> Too expensive</label>
                <label><input type="checkbox" name="reason[]" value="other"> Other</label>
            </div>

            <div class="form-actions">
                <button class="closeBtn" type="button">Cancel</button>
                <button type="submit" name="submit" class="cancel-btn">Submit Cancellation</button>
            </div>
        </form>
    </div>
</div>


<div id="bookingContainer">
    @foreach($bookings as $booking)
        <div class="request-box-container" data-status="{{ $booking->booking_status }}">
            <div class="request-box">
                <div class="r-box-details">
                    {{-- Gym Package --}}
                    <h3 class="r-h">{{ $booking->gym->package ?? 'N/A' }}</h3>

                    {{-- Default Equipment List --}}
                    <div class="list-item-c">
                        <h3 class="m-list-header">List of Item Includes:</h3>
                        <ul class="items-list">
                            @if(!empty($booking->gym->equipment))
                                @foreach($booking->gym->equipment as $equip)
                                    <li>{{ $equip->equipment }} <span>{{ $equip->pivot->quantity ?? 1 }}</span></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>

                    {{-- Additional Equipments --}}
                    <div class="additional">
                        <h3 class="m-item-add">Additional</h3>
                        <ul>
                            @foreach($booking->additionalEquipments as $additional)
                                <li>{{ $additional->equipment_name }} <span>{{ $additional->quantity }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- Bottom details --}}
                <div class="r-bottom-container">
                    <h3 class="b-list-header">Day(s) offer: {{ $booking->total_days }} Day(s)</h3>
                    <h3 class="b-status">Status Request: ({{ $booking->booking_status }})</h3>
                    <h3 class="b-price">Total Php: {{ number_format($booking->total_price, 2) }}</h3>

                    {{-- Show Cancel button only if status is not Completed or Cancelled --}}
                </div>
                <div class="btn-container">
                     @if($booking->booking_status !== 'Completed' && $booking->booking_status !== 'Cancelled')
                        <button type="button" class="cancelBtn" data-id="{{ $booking->booking_id }}">Cancel Request</button>
                    @endif
                    @if(!in_array($booking->booking_status, ['Cancelled', 'Completed', 'Pending']))
                        <button type="button" class="cancelBtn" 
                            onclick="window.location.href='{{ route('booking.invoice', $booking->booking_id) }}'">
                            Print Invoice
                        </button>
                    @endif

                </div>
            </div>
        </div>
    @endforeach
</div>


<script>
document.addEventListener("DOMContentLoaded", function() {
    // --- Filter Button Logic ---
    const buttons = {
        PendingBtn: 'Pending',
        ApprovedBtn: 'Approved',
        cancelBtn: 'Cancelled',
        historyBtn: 'Completed'
    };

    Object.keys(buttons).forEach(btnId => {
        const button = document.getElementById(btnId);
        if (!button) return; // skip if button doesn't exist

        button.addEventListener('click', () => {
            const status = buttons[btnId];
            const boxes = document.querySelectorAll('#bookingContainer .request-box-container');

            boxes.forEach(box => {
                box.style.display = (box.dataset.status === status) ? 'block' : 'none';
            });

            // Show message if no packages found
            const visible = Array.from(boxes).some(b => b.style.display === 'block');
            const messageId = 'noPackageMessage';
            const existingMsg = document.getElementById(messageId);

            if (!visible) {
                if (!existingMsg) {
                    const msg = document.createElement('div');
                    msg.id = messageId;
                    msg.className = 'request-box-container';
                    msg.innerHTML = `<div class="request-box"><h3 class="r-h">No ${status.toLowerCase()} package</h3></div>`;
                    document.getElementById('bookingContainer').appendChild(msg);
                }
            } else if (existingMsg) {
                existingMsg.remove();
            }
        });
    });

    // --- Cancel Modal Logic ---
    const cancelButtons = document.querySelectorAll(".cancelBtn");
    const cancelModal = document.getElementById("cancelModal");
    const closeBtn = document.querySelector(".closeBtn");
    const bookingIdField = document.getElementById("cancelBookingId");

    cancelButtons.forEach(btn => {
        btn.addEventListener("click", function() {
            const bookingId = this.getAttribute("data-id");
            bookingIdField.value = bookingId; // ✅ Pass booking_id to hidden input
            cancelModal.style.display = "flex"; // Show modal
        });
    });

    // Close modal on button click
    closeBtn.addEventListener("click", () => {
        cancelModal.style.display = "none";
    });

    // Close modal when clicking outside
    window.addEventListener("click", (e) => {
        if (e.target === cancelModal) {
            cancelModal.style.display = "none";
        }
    });
});
</script>

@endsection
