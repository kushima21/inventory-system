@extends('layout.default')
@vite(['resources/css/gym.css', 'resources/js/app.js'])

@section('content')
<div class="gym-main-container">
    
    {{-- 🔹 Page Header --}}
    <h2 class="gym-header">Basketball Gym Reservation Packages</h2>
    <p style="padding: 20px;">
        Customize your reservation to match your needs — from casual games to professional tournaments.
    </p>

    {{-- 🔹 Placeholder for future gym-related boxes or banners --}}
    <div class="gym-main-box-container"></div>

    {{-- 🔹 Header for package list section --}}
    <div class="list-header-container">
        <h3 class="list-header">List Of Packages</h3>
        <button type="button" class="addPackageBtn">+ Create Package</button>
    </div>

    {{-- 🔹 Modal for Create / Edit Package --}}
    <div class="add-package-modal-container" id="packageModal" style="display:none;">
        <h3 class="add-package-header" id="modalTitle">Create Packages</h3>

        {{-- ✅ Same form used for Create and Update --}}
        <form id="packageForm" action="{{ route('gym.store') }}" method="POST">
            @csrf
            <input type="hidden" name="gym_id" id="gym_id"> {{-- Hidden ID for edit mode --}}

            {{-- 🔸 Suggested Package Dropdown --}}
            <div class="info-container">
                <label for="packages">Suggested Packages</label>
                <input list="packages-list" name="package" id="packages" placeholder="Select Package..." required>
                <datalist id="packages-list">
                    <option value="All-Star Premium Package">
                    <option value="Slam Dunk Package">
                    <option value="Standard Game Package">
                    <option value="Basic Play Package">
                </datalist>
            </div>

            {{-- 🔸 List of available equipment items --}}
            <div class="list-item-info">
                <h3 class="list-head">List Items</h3>

                <div class="list-box-container-items">
                    @forelse($equipmentList as $equipment)
                        <div class="item-group" id="equipment-{{ $equipment->id }}">
                            {{-- Checkbox --}}
                            <label>
                                <input 
                                    type="checkbox" 
                                    name="equipment[]" 
                                    value="{{ $equipment->id }}" 
                                    data-equipment="{{ $equipment->equipment }}">
                                {{ $equipment->equipment }} ({{ $equipment->quantity }})
                            </label>

                            {{-- Quantity input --}}
                            <input 
                                type="number" 
                                name="equipment_quantity[{{ $equipment->id }}]" 
                                id="quantity-{{ $equipment->id }}" 
                                placeholder="Qty" 
                                min="1" 
                                max="{{ $equipment->quantity }}">
                        </div>
                    @empty
                        <p>No equipment added yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- 🔸 Price input and action buttons --}}
            <div class="add-bottom-container">
                <div class="price">
                    <label for="price">Price:</label>
                    <input type="number" name="price" id="price" placeholder="Enter Price" required>
                </div>

                <div class="add-btn-container">
                    <button type="submit" id="submitBtn">Submit</button>
                    <button type="button" id="closeModalBtn">Close</button>
                </div>
            </div>
        </form>
    </div>

    {{-- 🔹 Display existing packages --}}
    <div class="package-main-container">
        <div class="package-main-box-container">

            @forelse ($gyms as $gym)
                <div class="package-box">
                    {{-- Package name --}}
                    <h2 class="package-header">{{ $gym->package }}</h2>

                    {{-- Equipment list --}}
                    <h3 class="package-subheader">List of Items</h3>
                    <div class="list-item-container">
                        <ul>
                            @foreach ($gym->equipment as $equipment)
                                <li>{{ $equipment->pivot->quantity }} {{ $equipment->equipment }}</li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Price + Actions --}}
                    <div class="package-bottom-container">
                        <h3 class="total-header">Price: ₱ {{ number_format($gym->price, 2) }}</h3>

                        <div class="edit-delete-container">
                            {{-- ✏️ Edit Button --}}
                            <img 
                                src="{{ asset('icons/edit.png') }}" 
                                alt="Edit Package" 
                                class="edit-image" 
                                style="cursor:pointer;"
                                data-id="{{ $gym->id }}"
                                data-package="{{ $gym->package }}"
                                data-price="{{ $gym->price }}"
                                data-equipment='@json($gym->equipment->map(fn($e) => [
                                    "id" => $e->id,
                                    "name" => $e->equipment,
                                    "qty"  => $e->pivot->quantity
                                ]))'
                            >

                            {{-- 🗑️ Delete Form --}}
                            <form action="{{ route('gym.destroy', $gym->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="border:none; background:none; padding:0;">
                                    <img src="{{ asset('icons/trash.png') }}" alt="Delete Package" class="edit-image" style="cursor:pointer;">
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p>No packages available.</p>
            @endforelse

        </div>
    </div>
</div>

{{-- 🔹 Modal Script --}}
<script>
    const packageModal = document.getElementById('packageModal');
    const packageForm = document.getElementById('packageForm');
    const modalTitle = document.getElementById('modalTitle');
    const submitBtn = document.getElementById('submitBtn');

    // 🔸 Create New Package
    document.querySelector('.addPackageBtn').addEventListener('click', () => {
        modalTitle.textContent = 'Create Packages';
        submitBtn.textContent = 'Submit';
        packageForm.action = "{{ route('gym.store') }}"; // default create route
        packageForm.reset();
        packageModal.style.display = 'block';
    });

    // 🔸 Close Modal
    document.getElementById('closeModalBtn').addEventListener('click', () => {
        packageModal.style.display = 'none';
    });

    // 🔸 Edit Existing Package
    document.querySelectorAll('.edit-image').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const packageName = this.dataset.package;
            const price = this.dataset.price;
            const equipment = JSON.parse(this.dataset.equipment);

            // Change form to update mode
            modalTitle.textContent = 'Edit Package';
            submitBtn.textContent = 'Update';
            packageModal.style.display = 'block';

            // Set the package name and price
            document.getElementById('packages').value = packageName;
            document.getElementById('price').value = price;
            document.getElementById('gym_id').value = id;

            // Clear all checkboxes first
            document.querySelectorAll('input[name="equipment[]"]').forEach(checkbox => {
                checkbox.checked = false;
                const qtyInput = document.getElementById('quantity-' + checkbox.value);
                if (qtyInput) qtyInput.value = '';
            });

            // Check and fill selected equipment
            equipment.forEach(item => {
                const checkbox = document.querySelector('input[name="equipment[]"][value="' + item.id + '"]');
                const qtyInput = document.getElementById('quantity-' + item.id);
                if (checkbox) checkbox.checked = true;
                if (qtyInput) qtyInput.value = item.qty;
            });

            // Change form action to update route (you'll add this in routes/web.php)
            packageForm.action = `/settings/gym/update/${id}`;
        });
    });
</script>
@endsection
