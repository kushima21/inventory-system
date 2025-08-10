@extends('layout.default')
@vite(['resources/css/settings.css', 'resources/js/app.js'])
@section('content')

    <div class="supplies-header-container">
        <h2 class="supplies-header">
            Supplies Section
        </h2>
        <div class="supplies-box-header">
            <form method="POST" action="">
                <input class="supplies-search" name="supplies_name" id="searchSupplies" placeholder="Search Supplies..."> 
            </form>
            <button class="addSupplies" type="button" onclick="openSuppliesModal()">
                + Add Supplies
            </button>
        </div>
    </div>

    <div class="supplies-modal-container" id="supplies-modal-container">
        <h2 class="header-create-supplies">Create Supplies</h2>

        <div class="supplies-form-container">
            <form method="POST" action="{{ route('supplies.store') }}">
                   @csrf
                <div class="info-container">
                    <label for="supplies">Supplies:</label>
                    <input list="supplies-list" name="supplies" id="supplies" placeholder="Select Supplies..." required>
                    <datalist id="supplies-list">
                        <option value="Exam Bondpaper">
                        <option value="Student Passbook">
                        <option value="Softbound">
                        <option value="School Uniform">
                        <option value="PE Uniform">
                        <option value="Printer">
                        <option value="Computer">
                    </datalist>
                </div>

                <div class="info-container">
                  <label for="quantity">Quantity:</label>
                  <input type="number" name="quantity" id="quantity" placeholder="Quantity..." required>
                </div>

                 <div class="info-btn">
                    <button type="submit" name="submit">Create</button>
                    <button type="button" name="cancel" onclick="closeSuppliesModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <h2 class="supplies-header-list">Supplies List</h2>

    <div class="supplies-list-container">
      <table class="supplies-list-table">
          <thead>
            <tr>
              <th>Supplies</th>
              <th>Quantity</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($supplies as $item)
            <tr>
              <td>{{ $item->supplies }}</td>
              <td>{{ $item->quantity }}</td>
              <td>
                <form action="{{ route('supplies.addMore', $item->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">+ Add More</button>
                </form>
                <span>or</span>
                <form action="{{ route('supplies.delete', $item->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure to delete this item?')">Delete</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
      </table>
    </div>


@endsection

<script>
  function openSuppliesModal() {
    document.getElementById('supplies-modal-container').style.display = 'block';
  }

  function closeSuppliesModal() {
    document.getElementById('supplies-modal-container').style.display = 'none';
  }

  // Personnel search handler
  document.getElementById('searchPersonnel').addEventListener('keyup', function () {
    const query = this.value;

    fetch(`/personnel_dashboard?name=${encodeURIComponent(query)}`)
      .then(response => response.text())
      .then(data => {
        document.getElementById('personnelTableBody').innerHTML = data;
      });
  });
</script>