@extends('layout.default')
@vite(['resources/css/gym.css', 'resources/js/app.js'])

@section('content')

    <div class="gym-header-container">


        <h2 class="gym-header">Gym Section</h2>

        <div class="gymModal-container" id="gymModal" >
            <h2 class="header-create-gym">
            Add Basketball Gym Offer
            </h2>

            <div class="b-gym-offer-form">
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
                        <label for="days">Days</label>
                        <input type="number" name="days" placeholder="Days Duration" required>
                    </div>

                @forelse($equipmentList as $equipment)
                    <div class="info-container" style="display:none;" id="equipment-{{ $equipment->id }}">
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
                            placeholder="Enter Quantity..." 
                            style="display:none; margin-left:10px;" 
                            min="1" 
                            max="{{ $equipment->quantity }}">
                    </div>
                    @empty
                        <p>No equipment added yet.</p>
                    @endforelse

                    <div class="info-container">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="price" placeholder="Enter Price..." required>
                    </div>
                    <div class="info-btn">
                        <button type="button" id="addEquipmentBtn">Add Equipment</button>
                        <button type="button" name="cancel" onclick="closeEquipmentModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="gym-box-header">
            <form method="POST" action="">
                <select name="" class="gymSearch">
                    <option value="" disabled selected>Quick Search...</option>
                    <option value="All-Star Premium Package">All-Star Premium Package</option>
                    <option value="Slam Dunk Package">Slam Dunk Package</option>
                    <option value="Standard Game Package">Standard Game Package</option>
                    <option value="Basic Play Package">Basic Play Package</option>
                </select>
            </form>

            <button class="gymBtn" type="button" onclick="openGymModal()">
                + Create Gym Offer
            </button>
        </div>

    </div> 

    <h2 class="gym-offer-header">
        List of Gym Offers
    </h2>

    <div class="gym-offer-box-container">

      <div class="box-gym-offer-modal" id="offerModal" style="display:none;">
    <h2 class="m-g-header" id="modalPackage"></h2>
    <h3 class="e-header">Includes:</h3>
    <ul class="u-list" id="modalEquipmentList"></ul>

    <div class="b-p-container">
        <h3 class="p-header">Total Price: </h3>
        <h3 class="p-amount" id="modalPrice"></h3>
        <button class="closeBtn" onclick="closeModal()">Close</button>
    </div>
</div>

       <table class="product-table">
    <thead>
        <tr>
            <th>Package Name</th>
            <th>Package Price</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($gyms as $gym)
            <tr>
                <td>{{ $gym->package }}</td>
                <td>₱ {{ number_format($gym->price, 2) }}</td>
                <td>
                    <button class="action-btn"
                        type="button"
                        onclick="openModal({{ $gym->id }})"
                        data-id="{{ $gym->id }}"
                        data-package="{{ $gym->package }}"
                        data-price="{{ number_format($gym->price, 2) }}"
                        data-equipment='@json($gym->equipment->map(fn($e) => [
                            "name" => $e->equipment,
                            "qty"  => $e->pivot->quantity
                        ]))'>
                        View More
                    </button>

                    <form action="{{ route('gym.destroy', $gym->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="action-btn delete" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">No packages available.</td>
            </tr>
        @endforelse
    </tbody>
</table>


    </div>  



<script>
function openGymModal() {
    document.getElementById('gymModal').style.display = 'block'; // show modal
}

function closeEquipmentModal() {
    // i-hide ang modal
    document.getElementById('gymModal').style.display = 'none';

    // i-reset ang form (kung naa siya sulod nga <form> tag)
    const form = document.querySelector('#gymModal form');
    if (form) form.reset();

    // i-hide balik ang tanan dynamic equipment fields
    const equipmentDivs = document.querySelectorAll('[id^="equipment-"]');
    equipmentDivs.forEach(div => {
        div.style.display = 'none';
    });

    // i-hide ug i-clear ang tanan quantity inputs
    const qtyInputs = document.querySelectorAll('[id^="quantity-"]');
    qtyInputs.forEach(input => {
        input.style.display = 'none';
        input.value = "";
    });

    // i-reset balik ang Add Equipment button
    const addBtn = document.getElementById('addEquipmentBtn');
    addBtn.textContent = "Add Equipment";
    addBtn.type = "button"; 

    // refresh ang page
    location.reload();
}

// Handle Add Equipment → Create
document.getElementById('addEquipmentBtn').addEventListener('click', function() {
    const addBtn = this;

    if (addBtn.textContent === "Add Equipment") {
        // show equipment fields
        const equipmentDivs = document.querySelectorAll('[id^="equipment-"]');
        equipmentDivs.forEach(div => {
            div.style.display = 'flex';
            div.style.alignItems = 'center';
        });

        // change to Create
        addBtn.textContent = "Create";
        addBtn.type = "submit"; 
    }
    // if "Create" → form will submit automatically since type=submit
});

// Listen for checkbox changes (Table & Chairs only)
document.querySelectorAll('input[type="checkbox"][name="equipment[]"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const equipmentName = this.getAttribute('data-equipment');
        const qtyInput = document.getElementById('quantity-' + this.value);

        if ((equipmentName === "Table" || equipmentName === "Chairs") && this.checked) {
            qtyInput.style.display = 'block';
        } else {
            qtyInput.style.display = 'none';
            qtyInput.value = ""; // clear value when hidden
        }
    });
});
</script>
<script>
function openModal(gymId) {
    let btn = document.querySelector(`button[onclick="openModal(${gymId})"]`);
    
    // kuhaon data gikan sa button
    let packageName = btn.getAttribute("data-package");
    let price = btn.getAttribute("data-price");
    let equipment = JSON.parse(btn.getAttribute("data-equipment"));

    // butang sa modal
    document.getElementById("modalPackage").textContent = packageName;
    document.getElementById("modalPrice").textContent = "₱ " + price;

    let ul = document.getElementById("modalEquipmentList");
    ul.innerHTML = ""; // clear old list

    if (equipment.length > 0) {
        equipment.forEach(item => {
            let li = document.createElement("li");
            li.classList.add("e-list");
            li.textContent = item.qty + " " + item.name;
            ul.appendChild(li);
        });
    } else {
        let li = document.createElement("li");
        li.classList.add("e-list");
        li.textContent = "No equipment included.";
        ul.appendChild(li);
    }

    document.getElementById("offerModal").style.display = "block";
}

function closeModal() {
    document.getElementById("offerModal").style.display = "none";
}

</script>


@endsection