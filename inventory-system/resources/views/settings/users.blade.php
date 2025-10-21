@extends('layout.default')
@vite(['resources/css/users.css', 'resources/js/app.js'])
    @php
$user = \App\Models\User::find(session('user_id'));
@endphp
@section('content')
    <div class="main-users-container">

       <h2 class="user-main-header">Faculty and Personnel Overview</h2>
        <p class="users-p-header">Get to know the dedicated educators and staff members who contribute to the success of our institution.</p>

        <div class="users-modal-container"  id="addUserModal">
            <h3 class="user-modal-header">
                Create New Account Form
            </h3>
            <div class="users-form-container">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="users-form-box">
                        <label for="name">
                            Fullname
                        </label>
                        <input type="text" name="name" id="name" placeholder="Enter your fullname.." required>
                    </div>
                     <div class="users-form-box">
                        <label for="phone-number">
                            Phone Number
                        </label>
                        <input type="text" name="phone_number" id="phone_number" placeholder="Enter your Phone Number.." required>
                    </div>
                     <div class="users-form-box">
                        <label for="email">
                            Email
                        </label>
                        <input type="text" name="email" id="email" placeholder="Enter your Email Address.." required>
                    </div>
                    <div class="users-form-box">
                        <label for="password">
                            Password
                        </label>
                        <input type="password" name="password" id="password" placeholder="Enter your Password.." required>
                    </div>
                    <div class="users-from-box">
                        <label for="roles">
                            Select Roles
                        </label>
                        <select name="roles">
                            <option value="">Select Roles</option>
                            <option value="Admin">Admin</option>
                            <option value="Faculty">Faculty</option>
                            <option value="Custodian">Custodian</option>
                        </select>
                    </div>
                    <div class="user-form-btn">
                        <button type="submit" name="submit">
                            Submit
                        </button>
                        <button type="button" id="closeModalBtn" name="close">
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="users-modal-container"  id="UpdateUserModal">
            <h3 class="user-modal-header">
                Update Users Account Details
            </h3>
            <div class="users-form-container">
                <form method="POST" action="">
                    @csrf
                      @method('PUT')
                    <div class="users-form-box">
                        <label for="name">
                            Fullname
                        </label>
                        <input type="text" name="name" id="name" placeholder="Enter your fullname.." required>
                    </div>
                     <div class="users-form-box">
                        <label for="phone-number">
                            Phone Number
                        </label>
                        <input type="text" name="phone_number" id="phone_number" placeholder="Enter your Phone Number.." required>
                    </div>
                     <div class="users-form-box">
                        <label for="email">
                            Email
                        </label>
                        <input type="text" name="email" id="email" placeholder="Enter your Email Address.." required>
                    </div>
                    <div class="users-form-box">
                        <label for="password">
                            Password
                        </label>
                        <input type="password" name="password" id="password" placeholder="Enter your Password.." required>
                    </div>
                    <div class="users-from-box">
                        <label for="roles">
                            Select Roles
                        </label>
                        <select name="roles">
                            <option value="">Select Roles</option>
                            <option value="Admin">Admin</option>
                            <option value="Faculty">Faculty</option>
                            <option value="Custodian">Custodian</option>
                        </select>
                    </div>
                    <div class="user-form-btn">
                        <button type="submit" name="submit">
                            Update
                        </button>
                        <button type="button" id="closeModalBtn" name="close">
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        {{-- Account List --}}
        <div class="users-box-container">
            <h3 class="users-subheader">Faculty and Personnel Account List</h3>
            <div class="c-account-container">
                <form method="GET" action="{{ route('users.search') }}">
                    <input class="personnelForm" name="name" type="text" id="searchPersonnel" placeholder="Quick Search Personnel...">
                </form>
                <button type="button" class="add-usersBtn" id="openModalBtn">+ Create New Account</button>
            </div>
        </div>

        {{-- Users Table --}}
        <div class="users-form-container">
            <div class="users-wrapper-container">
                <table class="users-table-container">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Contact Number</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            @if ($user->roles !== 'Customers')
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->phone_number }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->roles }}</td>
                                    <td>
                                        <button type="button" name="edit" class="edit" data-id="{{ $user->id }}">Edit</button>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" name="delete" class="delete">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center;">No faculty or personnel accounts found.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

    </div>
    <!-- ✅ Modal Show/Hide Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // CREATE MODAL FUNCTIONALITY
    const addModal = document.getElementById('addUserModal');
    const openAddBtn = document.getElementById('openModalBtn');
    const closeAddBtn = addModal.querySelector('button[name="close"]');

    // Hide modal by default
    addModal.style.display = 'none';

    // Open modal
    openAddBtn.addEventListener('click', () => {
        addModal.style.display = 'block';
    });

    // Close modal
    closeAddBtn.addEventListener('click', () => {
        addModal.style.display = 'none';
    });



    // UPDATE MODAL FUNCTIONALITY
    const updateModal = document.getElementById('UpdateUserModal');
    const updateCloseBtn = updateModal.querySelector('button[name="close"]');

    // Hide modal by default
    updateModal.style.display = 'none';

    // Select all edit buttons
    const editButtons = document.querySelectorAll('.edit');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            const name = row.children[0].textContent.trim();
            const phone = row.children[1].textContent.trim();
            const email = row.children[2].textContent.trim();
            const role = row.children[3].textContent.trim();
            const userId = this.getAttribute('data-id');

            // Get input fields inside Update modal
            const nameInput = updateModal.querySelector('input[name="name"]');
            const phoneInput = updateModal.querySelector('input[name="phone_number"]');
            const emailInput = updateModal.querySelector('input[name="email"]');
            const passwordInput = updateModal.querySelector('input[name="password"]');
            const rolesSelect = updateModal.querySelector('select[name="roles"]');
            const form = updateModal.querySelector('form');

            // Fill in the values
            nameInput.value = name;
            phoneInput.value = phone;
            emailInput.value = email;
            rolesSelect.value = role;
            passwordInput.value = ""; // keep empty unless admin wants to change

            // Update form action dynamically
            form.action = `/settings/users/update/${userId}`;

            // Show modal
            updateModal.style.display = 'block';
        });
    });

    // Close update modal
    updateCloseBtn.addEventListener('click', () => {
        updateModal.style.display = 'none';
    });
});
</script>


@endsection