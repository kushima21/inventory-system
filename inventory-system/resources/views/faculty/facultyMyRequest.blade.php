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
                <button type="button" id="allBtn">All Request</button>
                <button type="button" id="PendingBTn">Pending Request</button>
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
                            <label class="checkbox-option">
                                <input type="checkbox" name="reason[]" value="Change of Plan">
                                Change of Plan
                            </label>
                            <label class="checkbox-option">
                                <input type="checkbox" name="reason[]" value="Wrong Request Supply">
                                Wrong Request Supply
                            </label>
                            <label class="checkbox-option">
                                <input type="checkbox" name="reason[]" value="Wrong Quantity">
                                Wrong Quantity
                            </label>
                            <label class="checkbox-option">
                                <input type="checkbox" name="reason[]" value="Other Reason">
                                Other Reason
                            </label>
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
                    <div class="request-box">
                        <div class="r-header-container">
                            <h3 class="r-header">{{ $request->supply_name }}</h3>
                            <p class="date-request">
                                Date Requested:
                                <span>{{ $request->created_at->format('Y-m-d') }}</span>
                            </p>
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
                                    <button type="button" id="requestAgain" class="requestAgain">
                                        Request Again
                                    </button>

                                    @if($request->request_status == 'Pending')
                                        <button
                                            type="button"
                                            class="open-cancel-btn"
                                            onclick="openCancelModal({{ $request->id }})"
                                        >
                                            Cancel Request
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>

{{-- JavaScript Section --}}
<script>
    function openCancelModal(id) {
        const modal = document.getElementById('cancelModal');
        const form = document.getElementById('cancelForm');
        form.action = `/faculty/facultyMyRequest/cancel/${id}`; // ✅ Correct URL
        modal.style.display = 'block';
    }

    function closeModal() {
        document.getElementById('cancelModal').style.display = 'none';
    }
</script>
@endsection
