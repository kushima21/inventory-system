@extends('layout.default')
@vite(['resources/css/equipment.css', 'resources/js/app.js'])
@if (session('success'))
    <script>alert("{{ session('success') }}");</script>
@endif

@if (session('error'))
    <script>alert("{{ session('error') }}");</script>
@endif

@section('content')
    <div class="additional-equipment-main-container">
        <h2 class="additional-equipment-header">
            Add Equipment Bundle
        </h2>
        <h3 class="list-equipment-bundle">
            List of Equipment Bundled
        </h3>
        <div class="addtional-container-box">
            <div class="additional-subheader-container">
                <input type="text" name="search" id="search-equipment" placeholder="Quick Search...">
                <button type="button" class="createBundle">
                    + Create Equipment Bundle
                </button>
            </div>
            <div class="additional-modal">
                <h3 class="additional-header-modal">
                    Add Equipment Bundle
                </h3>
                <div class="additional-form-container">
                    <form method="POST" action="{{ route('equipment.bundle.store') }}">
                        @csrf
                        <div class="additional-modal-info">
                            <label for="equipment">Select Equipment</label>
                            <select name="equipment" id="equipment">
                                <option value="">Select Equipment</option>
                                @foreach($equipmentList as $equipment)
                                    <option value="{{ $equipment->id }}">
                                        {{ $equipment->equipment }} — {{ $equipment->quantity }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="additional-modal-info">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" id="quantity" required>
                        </div>
                        <div class="additional-modal-info">
                            <label for="price">Price</label>
                            <input type="number" name="price" id="price" required>
                        </div>
                        <div class="additional-button-container">
                            <button type="submit" name="submit">Submit</button>
                            <button type="button" class="closeModal">Close</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="additional-wrapper-container-equipment">
    <table class="additional-equipment-table">
        <thead>
            <tr>
                <th>Created</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bundles as $bundle)
                <tr>
                    <td>{{ $bundle->created_at->format('Y-m-d') }}</td>
                    <td>{{ $bundle->equipment->equipment ?? 'N/A' }}</td>
                    <td>{{ $bundle->quantity }} Pieces</td>
                    <td>{{ number_format($bundle->price, 2) }}</td>
                    <td>
                        <button class="editBTn" type="button">Edit</button>
                        <form action="{{ route('equipment.bundle.delete', $bundle->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="deleteBTn" onclick="return confirm('Are you sure you want to delete this bundle?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">No bundles found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

        </div>
    </div>
    <script>
    // Get the buttons and modal
    const openBtn = document.querySelector('.createBundle');
    const closeBtn = document.querySelector('.closeModal');
    const modal = document.querySelector('.additional-modal');

    // Show modal on button click
    openBtn.addEventListener('click', () => {
        modal.style.display = 'block';
    });

    // Hide modal on close button click
    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Optional: hide modal if click outside the modal content
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
</script>
@endsection