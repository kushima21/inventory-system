@extends('layout.default')
@vite(['resources/css/equipment.css', 'resources/js/app.js'])
@section('content')

    <div class="ict-header-container">
        <h2 class="ict-header">Equipment Section</h2>

        <div class="ict-box-header">
            <form method="POST" action="">
                <input type="text" name="equipment" class="equipmentSearch"  id="searchEquipment" placeholder="Search Equipment...">
            </form>

            <button class="equipmentBtn" type="button" onclick="openEquipmentModal()">
                + Equipment
            </button>
        </div>
    </div>

    <div class="equipment-modal-container" id="equipment-modal-container">
        <h2 class="header-create-equipment">
            Create Equipment
        </h2>

        <div class="equipment-form-container">
            <form method="POST" action="{{ route('equipment.store') }}">
                @csrf 
                <div class="info-container">
                    <label for="">Equipment</label>
                    <input list="equipment-list" name="equipment" id="equipment" placeholder="Select Equipment..." required>
                    <datalist id="equipment-list">
                        <option value="LED">
                        <option value="Chairs">
                        <option value="Table">
                        <option value="Fan">
                        <option value="Gameboard">
                        <option value="Speaker">
                        <option value="Fan">
                    </datalist>
                </div>

                <div class="info-container">
                  <label for="quantity">Quantity:</label>
                  <input type="number" name="quantity" id="quantity" placeholder="Quantity..." required>
                </div>

                 <div class="info-btn">
                    <button type="submit" name="submit">Create</button>
                    <button type="button" name="cancel" onclick="closeEquipmentModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div class="equipment-modal-container" id="addMoreModal">
        <h2 class="header-create-equipment">
            Add More Equipment Quantity
        </h2>

        <div class="equipment-form-container">
            <form method="POST" action="" id="addMoreForm">
                @csrf
                <div class="info-container">
                    <label for="equipment_name">Equipment</label>
                    <input type="text" name="equipment" id="equipment_name" readonly>
                </div>

                <div class="info-container">
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity_to_add" id="quantity" placeholder="Quantity..." min="1" required>
                </div>

                <div class="info-btn">
                    <button type="submit" name="submit">+ Add</button>
                    <button type="button" name="cancel" onclick="closeAddMoreModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <h2 class="equipment-header-list">Equipment List</h2>

    <div class="equipment-list-container">
        <table class="equipment-list-table">
            <thead>
                <tr>
                    <th>Equipment</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($equipmentList as $equipment)
                <tr>
                    <td>{{ $equipment->equipment }}</td>
                    <td>{{ $equipment->quantity }}</td>
                    <td>
                        <button type="button" onclick="openAddMoreModal('{{ $equipment->id }}', '{{ $equipment->equipment }}', {{ $equipment->quantity }})">+ Add More</button>
                        <span>or</span>
                       <form action="{{ route('equipment.delete', $equipment->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure to delete this equipment?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">No equipment found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    

@endsection
<script>
  function openEquipmentModal() {
    document.getElementById('equipment-modal-container').style.display = 'block';
  }

  function closeEquipmentModal() {
    document.getElementById('equipment-modal-container').style.display = 'none';
  }
</script>
<script>
function openAddMoreModal(id, equipmentName, currentQuantity) {
    // Show modal
    document.getElementById('addMoreModal').style.display = 'block';

    // Set equipment name in readonly input
    document.getElementById('equipment_name').value = equipmentName;

    // Clear quantity input
    document.getElementById('quantity').value = '';

    // Set form action URL dynamically with the equipment id
    document.getElementById('addMoreForm').action = `/equipment/${id}/add-more`;
}

function closeAddMoreModal() {
    document.getElementById('addMoreModal').style.display = 'none';
}
</script>