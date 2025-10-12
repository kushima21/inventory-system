@extends('layout.default')
@vite(['resources/css/gym.css', 'resources/js/app.js'])

@section('content')
    <div class="gym-main-container">
        <h2 class="gym-header">
            Gym Section
        </h2>
        <div class="gym-main-box-container">
            <div class="gym-box"></div>
            <div class="gym-box"></div>
            <div class="gym-box"></div>
            <div class="gym-box"></div>
        </div>
        <div class="list-header-container">
            <h3 class="list-header">
                List Of Packages
            </h3>
            <button type="button" class="addPackageBtn">
                + Create Package
            </button>
        </div>
        <div class="search-package">
            <input type="text" name="search_package" placeholder="Search Package">
        </div>
       <div class="add-package-modal-container" id="packageModal">
            <h3 class="add-package-header">Create Packages</h3>
            <form action="{{ route('gym.store') }}" method="POST">
            @csrf
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

            <div class="list-item-info">
                <h3 class="list-head">List Items</h3>

                <div class="list-box-container-items">
                    @forelse($equipmentList as $equipment)
                        <div class="item-group" id="equipment-{{ $equipment->id }}">
                            <label>
                                <input type="checkbox" 
                                    name="equipment[]" 
                                    value="{{ $equipment->id }}" 
                                    data-equipment="{{ $equipment->equipment }}">
                                {{ $equipment->equipment }} ({{ $equipment->quantity }})
                            </label>

                            {{-- Hidden quantity input (mo-show lang if Table or Chairs ang gi-check) --}}
                            <input type="number" 
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

            <div class="add-bottom-container">
                <div class="price">
                    <label for="price">Price:</label>
                    <input type="number" name="price" id="price" placeholder="Enter Price" required>
                </div>
                <div class="add-btn-container">
                    <button type="submit" name="submit">Submit</button>
                    <button type="button" id="closeModalBtn">Close</button>
                </div>
            </div>
            </form>
        </div>

        <div class="package-main-container">
            <div class="package-main-box-container">
    @forelse ($gyms as $gym)
        <div class="package-box">
            <h2 class="package-header">
                {{ $gym->package }}
            </h2>

            <h3 class="package-subheader">
                List of Items
            </h3>

            <div class="list-item-container">
                <ul>
                    @foreach ($gym->equipment as $equipment)
                        <li>{{ $equipment->pivot->quantity }} {{ $equipment->equipment }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="package-bottom-container">
                <h3 class="total-header">
                    Price: ₱ {{ number_format($gym->price, 2) }}
                </h3>

                <div class="edit-delete-container">
                    {{-- Edit / View Button --}}
                    <img src="{{ asset('icons/edit.png') }}" 
                         alt="Edit Package" 
                         class="edit-image" 
                         style="cursor:pointer;"
                         onclick="openModal({{ $gym->id }})"
                         data-id="{{ $gym->id }}"
                         data-package="{{ $gym->package }}"
                         data-price="{{ number_format($gym->price, 2) }}"
                         data-equipment='@json($gym->equipment->map(fn($e) => [
                             "name" => $e->equipment,
                             "qty"  => $e->pivot->quantity
                         ]))'>

                    {{-- Delete Form --}}
                    <form action="{{ route('gym.destroy', $gym->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="border:none; background:none; padding:0;">
                            <img src="{{ asset('icons/trash.png') }}" 
                                 alt="Delete Package" 
                                 class="edit-image" 
                                 style="cursor:pointer;">
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
    <script>
document.querySelector('.addPackageBtn').addEventListener('click', function() {
    document.getElementById('packageModal').style.display = 'block';
});

document.getElementById('closeModalBtn').addEventListener('click', function() {
    document.getElementById('packageModal').style.display = 'none';
});
</script>
@endsection