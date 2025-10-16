@extends('layout.faculty')
@vite(['resources/css/faculty.css', 'resources/js/app.js'])

@php
    $user = \App\Models\User::find(session('user_id'));
@endphp

@section('content')
<div class="facultyMyRequest-main-container">
    <h2 class="faculty-my-request-header">Request Overview</h2>

    <div class="my-request-box-container">
        <div class="my-request-box">

            {{-- Header Buttons --}}
            <div class="my-request-header-container">
                <button type="button" id="allBtn" class="active">All Request</button>
                <button type="button" id="PendingBtn">Pending Request</button>
                <button type="button" id="ApprovedBtn">Approved Request</button>
                <button type="button" id="CompletedBtn">Completed Request</button>
                <button type="button" id="CancelledBtn">Cancelled</button>
            </div>

            {{-- Cancel Request Modal --}}
            <div class="faculty-request-cancel-modal" id="cancelModal" style="display: none;">
                <h3 class="cancel-request-header">Cancel Request Supply Form</h3>
                <div class="cancel-form-supply-container">
                    <form method="POST" id="cancelForm" action="">
                        @csrf

                        <div class="cancel-r-info">
                            <label class="checkbox-option"><input type="checkbox" name="reason[]" value="Change of Plan"> Change of Plan</label>
                            <label class="checkbox-option"><input type="checkbox" name="reason[]" value="Wrong Request Supply"> Wrong Request Supply</label>
                            <label class="checkbox-option"><input type="checkbox" name="reason[]" value="Wrong Quantity"> Wrong Quantity</label>
                            <label class="checkbox-option"><input type="checkbox" name="reason[]" value="Other Reason"> Other Reason</label>
                        </div>

                        <div class="cancel-btn-container">
                            <button type="submit" class="cancel-btn">Submit</button>
                            <button type="button" class="back-btn" onclick="closeModal()">Close</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Request List --}}
            <div class="my-request-box-main-container">
                @foreach($requests as $request)
                    <div class="request-box" data-status="{{ $request->request_status }}">
                        <div class="r-header-container">
                            <h3 class="r-header">{{ $request->supply_name }}</h3>

                            @if($request->request_status == 'Cancelled' && $request->date_cancelled)
                                <p class="date-request">
                                    Cancelled Date:
                                    <span>{{ \Carbon\Carbon::parse($request->date_cancelled)->format('Y-m-d') }}</span>
                                </p>
                            @else
                                <p class="date-request">
                                    Date Requested:
                                    <span>{{ $request->created_at->format('Y-m-d') }}</span>
                                </p>
                            @endif
                        </div>

                        <h4 class="q-header">Supply Requested (Qty):</h4>

                        <div class="q-header-container">
                            <p class="q-subheader">x{{ $request->quantity }} Items</p>

                            <div class="q-subcontainer">
                                <h3 class="r-status">
                                    Request Status:
                                    <span style="color:
                                        @if($request->request_status == 'Pending') orange
                                        @elseif($request->request_status == 'Approved') green
                                        @elseif($request->request_status == 'Cancelled') red
                                        @else gray
                                        @endif;
                                    ">
                                        {{ $request->request_status }}
                                    </span>
                                </h3>

                                <div class="r-btn-container">
                                    <a href="{{ url('/faculty/facultyRequest') }}">
                                        <button type="button" id="requestAgain" class="requestAgain">
                                            Request Again
                                        </button>
                                    </a>

                                    @if($request->request_status == 'Pending')
                                        <button type="button" class="open-cancel-btn" onclick="openCancelModal({{ $request->id }})">
                                            Cancel Request
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Empty State Message --}}
                <p id="noRequestMessage" class="no-request-message" style="display: none;">No Request Found</p>
            </div>

        </div>
    </div>
</div>

{{-- JavaScript Section --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        filterRequests("default");

        document.getElementById("allBtn").addEventListener("click", () => filterRequests("default"));
        document.getElementById("PendingBtn").addEventListener("click", () => filterRequests("Pending"));
        document.getElementById("ApprovedBtn").addEventListener("click", () => filterRequests("Approved"));
        document.getElementById("CompletedBtn").addEventListener("click", () => filterRequests("Completed"));
        document.getElementById("CancelledBtn").addEventListener("click", () => filterRequests("Cancelled"));
    });

    function filterRequests(status) {
        const boxes = document.querySelectorAll(".request-box");
        const message = document.getElementById("noRequestMessage");
        let visibleCount = 0;

        boxes.forEach(box => {
            const reqStatus = box.getAttribute("data-status");

            if (status === "default") {
                if (reqStatus === "Completed" || reqStatus === "Cancelled") {
                    box.style.display = "block";
                    visibleCount++;
                } else {
                    box.style.display = "none";
                }
            } else if (reqStatus === status) {
                box.style.display = "block";
                visibleCount++;
            } else {
                box.style.display = "none";
            }
        });

        // Show no-request message if nothing is visible
        if (visibleCount === 0) {
            message.style.display = "block";
            if (status === "default") message.textContent = "No Completed or Cancelled Request";
            else message.textContent = "No " + status + " Request";
        } else {
            message.style.display = "none";
        }

        // Highlight active button
        document.querySelectorAll(".my-request-header-container button").forEach(btn => btn.classList.remove("active"));
        if (status === "default") document.getElementById("allBtn").classList.add("active");
        else document.getElementById(status + "Btn").classList.add("active");
    }

    // Cancel modal
    function openCancelModal(id) {
        const modal = document.getElementById('cancelModal');
        const form = document.getElementById('cancelForm');
        form.action = `/faculty/facultyMyRequest/cancel/${id}`;
        modal.style.display = 'block';
    }

    function closeModal() {
        document.getElementById('cancelModal').style.display = 'none';
    }
</script>

{{-- Optional Styles --}}
<style>
    .my-request-header-container button.active {
        background-color: #2b4eff;
        color: white;
        font-weight: bold;
    }

    .no-request-message {
        text-align: center;
        font-size: 18px;
        color: #777;
        margin-top: 20px;
        font-style: italic;
    }
</style>
@endsection
