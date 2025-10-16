@extends('layout.faculty')
@vite(['resources/css/faculty.css', 'resources/js/app.js'])

@section('content')
    <div class="facultyMyRequest-main-container">
        <h2 class="faculty-my-request-header">
            Request Overview
        </h2>
        <div class="my-request-box-container">
            <div class="my-request-box">

                <div class="my-request-header-container">
                    <button type="button" id="allBtn">
                        All Request
                    </button>
                    <button type="button" id="PendingBTn">
                        Pending Request
                    </button>
                    <button type="button" id="ApprovedBtn">
                        Approved Request
                    </button>
                    <button type="button" id="CompletedBtn">
                        Completed Request
                    </button>
                    <button type="button" id="CancelledBtn">
                        Cancelled
                    </button>
                </div>
                <div class="faculty-request-cancel-modal"  id="cancelModal">
                    <h3 class="cancel-request-header">
                        Cancel Request Supply Form
                    </h3>
                    <div class="cancel-form-supply-container">
                        <form method="POST" action="">
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

                <div class="my-request-box-main-container">
                    <div class="request-box">
                        <div class="r-header-container">
                            <h3 class="r-header">
                                Bondpaper
                            </h3>
                            <p class="date-request">Date Requested: <span>2025-10-15</span></p>
                        </div>
                            <h4 class="q-header">
                                Supply Requested (Qty):
                            </h4>
                         <div class="q-header-container">
                             <p class="q-subheader">
                                x20 Pieces
                            </p>
                            <div class="q-subcontainer">
                                <h3 class="r-status">
                                    Request Status:
                                    Pending
                                </h3>
                                <div class="r-btn-container">
                                    <button type="button" id="requestAgain" class="requestAgain">
                                        Request Again
                                    </button>
                                    <button type="button" class="open-cancel-btn" onclick="openCancelModal()">
                                        Cancel Request
                                    </button>
                                </div>
                            </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
function openCancelModal() {
    document.getElementById('cancelModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('cancelModal').style.display = 'none';
}
</script>
@endsection