@extends('faculty.facultyDashboard')
{{-- resources/views/settings/supplies.blade.php --}}

@vite(['resources/css/request.css', 'resources/js/app.js'])

@section('content')
    <div class="request-second-header">
        <div class="header">
            <h2>Request Section</h2>
            <form method="POST" action="">
                <input type="text" name="supplies" id="searchSuplies" placeholder="Search....">
            </form>
        </div>
    </div>

    <div class="request-main-container">
        <div class="table-container">
            <table class="table-supplies-container"> 
                <thead>
                    <tr>
                    <th>Name</th>
                    <th>Available</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($supplies as $item)
                    <tr>
                        <td>{{ $item->supplies }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>
                        <button 
                    class="RequestBtn" 
                    type="button"
                    data-id="{{ $item->id }}"
                    data-name="{{ $item->supplies }}"
                    onclick="openForm(this)">
                    Request
                </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="request-form-container">
                <h2 class="request-header-form">Made a Request...</h2>
                <div class="requestForm">
                    <form action="{{ route('supplies.request', ['id' => 0]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="supply_id" id="supply_id" value="">
                        <input type="hidden" name="dateRequest" id="dateRequest" value="">
                        <div class="info-form">
                            <label for="supplies">Name</label>
                            <input type="text" name="supplies" id="supplies" readonly>
                        </div>
                        <div class="info-form">
                            <label for="quantity">Request Number</label>
                            <input type="number" name="quantity" id="quantity" value="" placeholder="Number of Request..." required>
                        </div>
                        
                        <div class="info-form">
                            <label for="requestedRelease">Date Needed</label>
                            <input type="date" name="requestedRelease" id="requestedRelease" value="" required>
                        </div>
                        <div class="info-form">
                            <label for="justification">Request Justification</label>
                            <textarea name="justification" class="comment" id="justification" placeholder="Request Justification..." required></textarea>
                        </div>
                        <div class="formBtn">
                            <button type="submit" class="submitBtn" name="submit">Submit</button>
                            <button type="button" class="cancelBtn" name="cancel" onclick="closeForm()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
<script>
    function openForm(button) {
        // kuhaon ang id ug name gikan sa data attributes
        const id = button.getAttribute("data-id");
        const name = button.getAttribute("data-name");

        // ibutang sa form inputs
        document.getElementById("supply_id").value = id;
        document.getElementById("supplies").value = name;

        // i-display ang form
        document.querySelector(".request-form-container").style.display = "block";
    }

    function closeForm() {
        document.querySelector(".request-form-container").style.display = "none";
    }
</script>


<script>
  // Kuhaon ang date karon
  const today = new Date();
  const todayStr = today.toISOString().split("T")[0];

  // I-set sa input nga ang min date kay today
  const dateInput = document.getElementById("requestedRelease");
  dateInput.setAttribute("min", todayStr);
</script>

