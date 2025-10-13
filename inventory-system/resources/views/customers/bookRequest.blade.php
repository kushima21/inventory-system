@extends('partials.sideBar')
@vite(['resources/css/bookRequest.css', 'resources/js/app.js'])

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

<div class="cancel-modal-container" id="cancelModal">
    <div class="cancel-form-box">
        <h3 class="cancel-header">Cancellation Form</h3>
        <h3 class="select-reason">Select a reason</h3>
        <form>
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
                <button type="submit" class="cancel-btn">Submit Cancellation</button>
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
                    @if($booking->booking_status !== 'Completed' && $booking->booking_status !== 'Cancelled')
                        <button type="button" class="cancelBtn" data-id="{{ $booking->booking_id }}">Cancel Request</button>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>


<script>
document.addEventListener("DOMContentLoaded", function() {
    const buttons = {
        PendingBtn: 'Pending',
        ApprovedBtn: 'Approved',
        cancelBtn: 'Cancelled',
        historyBtn: 'Completed'
    };

    Object.keys(buttons).forEach(btnId => {
        document.getElementById(btnId).addEventListener('click', () => {
            const status = buttons[btnId];
            document.querySelectorAll('#bookingContainer .request-box-container').forEach(box => {
                box.style.display = (box.dataset.status === status) ? 'block' : 'none';
            });

            // If none matches, show "No package" message
            const visible = Array.from(document.querySelectorAll('#bookingContainer .request-box-container')).some(b => b.style.display === 'block');
            if(!visible){
                if(!document.getElementById('noPackageMessage')){
                    const msg = document.createElement('div');
                    msg.id = 'noPackageMessage';
                    msg.className = 'request-box-container';
                    msg.innerHTML = `<div class="request-box"><h3 class="r-h">No ${status.toLowerCase()} package</h3></div>`;
                    document.getElementById('bookingContainer').appendChild(msg);
                }
            } else {
                const msg = document.getElementById('noPackageMessage');
                if(msg) msg.remove();
            }
        });
    });

    // Cancel modal functionality
    document.querySelectorAll('.cancelBtn').forEach(btn => {
        const modal = document.getElementById("cancelModal");
        const closeBtn = document.querySelector(".closeBtn");

        btn.addEventListener("click", () => { modal.style.display = "flex"; });
        closeBtn.addEventListener("click", () => { modal.style.display = "none"; });
        window.addEventListener("click", (e) => { if(e.target === modal) modal.style.display = "none"; });
    });
});
</script>
@endsection
