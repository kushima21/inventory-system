@extends('layout.default')

@vite(['resources/css/personnel.css', 'resources/js/app.js'])


@section('content')
   <div class="personnel-header-container">
        <h2 class="personnel-header">Personnels</h2>
        <div class="personnel-box">
           <form method="GET" action="{{ route('users.search') }}">
                <input class="personnelForm" name="name" type="text" id="searchPersonnel" placeholder="Quick Search Personnel...">
            </form>
            <button class="addPersonel" type="button" onclick="openAddPersonnelModal()">
                + Create Personnel
            </button>
        </div>
   </div>

   <div class="addPersonelModal" id="addPersonnelModal">
        <h2 class="AP-header">Create Personnel Account</h2>
        <div class="AP-form-container">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="info-container">
                    <label for="name">Personnel Name:</label>
                    <input type="text" name="name" id="name" placeholder="Fullname..." required>
                </div>
                <div class="info-container">
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email" placeholder="Email" required>
                </div>
                 <div class="info-container">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                </div>
               <div class="info-container">
                    <label for="roles">Roles:</label>
                    <input list="role-options" name="roles" id="roles" placeholder="Select role..." required>
                    <datalist id="role-options">
                        <option value="Instructor">
                        <option value="Custodian">
                        <option value="Admin">
                    </datalist>
                </div>

                <div class="info-btn">
                    <button type="submit" name="submit">Create</button>
                    <button type="button" name="cancel" onclick="closeAddPersonnelModal()">Cancel</button>
                </div>

            </form>
        </div>
   </div>

   <h2 class="personnel-list-header">Personnel List</h2>
   
    <div class="personnel-list-container">
     <table class="personnel-list-table">
    <thead>
        <tr>
            <th>Full Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="personnelTableBody">
        @forelse ($users as $user)
          @include('personnel.partials.personnel_table_rows')
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->roles }}</td>
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                <td>
                    <button>Edit</button>
                    <button>Delete</button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No personnel found.</td>
            </tr>
        @endforelse
    </tbody>
</table>


    </div>


@endsection
<script>
    function openAddPersonnelModal() {
        document.getElementById('addPersonnelModal').style.display = 'block';
    }

    function closeAddPersonnelModal() {
        document.getElementById('addPersonnelModal').style.display = 'none';
    }

    document.getElementById('searchPersonnel').addEventListener('keyup', function () {
        const query = this.value;

        fetch(`/personnel_dashboard?name=${encodeURIComponent(query)}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById('personnelTableBody').innerHTML = data;
            });
    });
</script>




