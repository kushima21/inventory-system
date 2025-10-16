@extends('layout.faculty')
@vite(['resources/css/faculty.css', 'resources/js/app.js'])

@section('content')
    <div class="faculty-request-main-container">
        <h2 class="faculty-main-header">
           Welcome, Hondrada John Mark!
        </h2>
        <h3 class="faculty-subheader">
            Need something? Send a Request!
        </h3>
        <div class="faculty-request-modal-container" id="requestModal">
            <h3 class="request-header-form">
                Supply Request Form
            </h3>
            <div class="request-form-box-container">
                <form method="POST" action="">
                    <div class="form-request-box-container">
                        <div class="request-info">
                            <label for="name">Fullname</label>
                            <input type="text" name="name" id="name">
                        </div>
                         <div class="request-info">
                            <label for="name">Contact Number</label>
                            <input type="number" name="name" id="contact_number">
                        </div>
                         <div class="request-info">
                            <label for="name">Email</label>
                            <input type="text" name="email" id="email">
                        </div>
                         <div class="request-info">
                            <label for="name">Date Needed</label>
                            <input type="date" name="date_needed" id="date_needed">
                        </div>
                        <h3 class="request-subheader">
                            Requested Supply
                        </h3>
                         <div class="request-info">
                            <label for="name">Supplies Name</label>
                            <input type="text" name="name" id="name">
                        </div>
                        <div class="request-info">
                            <label for="name">Supplies Requested (Qty)</label>
                            <input type="number" name="quantity" id="quantity">
                        </div>
                    </div>
                    <div class="request-btn-container">
                        <button type="submit" name="submit">
                            Submit
                        </button>
                        <button type="button" class="closeBtn">
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="faculty-request-search-container">
            <input type="text" name="searchSupplies" placeholder="Quick Search Supplies">
        </div>
        <h3 class="list-supplies-header">
            List of Supplies
        </h3>
        <div class="faculty-request-wrapper-container">
            <table class="faculty-table-container">
                <thead>
                    <tr>
                        <th>Supply Name</th>
                        <th>Availability</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Bondpaper</td>
                        <td>12</td>
                        <td>
                            <button type="button" class="requestBtn" >
                                Request
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<!-- all your HTML elements here -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const requestBtn = document.querySelector('.requestBtn');
    const modal = document.getElementById('requestModal');
    const closeBtn = document.querySelector('.closeBtn');

    if (requestBtn && modal && closeBtn) {
        requestBtn.addEventListener('click', () => {
            modal.classList.add('active');
        });

        closeBtn.addEventListener('click', () => {
            modal.classList.remove('active');
        });
    } else {
        console.error('⚠ Missing elements: check class or ID names');
    }
});
</script>

@endsection