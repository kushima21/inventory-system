@extends('partials.navbar') 

@vite(['resources/css/book.css', 'resources/js/app.js'])

@section('content')
    <div class="content-main-container">

         <div class="booking-modal-form-box" >
                <div class="m-view-modal">
                    <div class="form-header">
                        <h2 class="m-view-header">
                        All Star Premium Packages
                        </h2>
                        <button class="close-view-btn" type="button">&times;</button>
                    </div>
                    <h3 class="m-list-header">
                        Day(s) offer : 4 Days
                    </h3>
                    <h3 class="m-list-header">
                        List of Item Includes:
                    </h3>
                     <ul class="items-list">
                        <li>10 LED</li>
                        <li>10 Table</li>
                        <li>10 Chairs</li>
                        <li>20 Speaker</li>
                        <li>20 Fan</li>
                        <li>20 GameBoard</li>
                    </ul>
                    <div class="additional">
                    <h3 class="m-item-add">
                        /*Additional*/
                    </h3>
                        <ul>
                            <li>20 chairs</li>
                            <li>20 Table</li>
                            <li>50 LED</li>
                            <li>50 chairs</li>
                        </ul>
                    </div>
                    <div class="h-btn-container">
                        <h3 class="b-price">
                            Total Php: 3000.00
                        </h3>
                        <button class="add-more" type="button">Add More</button>
                    </div>
                </div>

               <div class="modal-box-1">
                    <div class="form-header">
                        <h3>Gym Booking Form</h3>
                        <button class="close-btn" type="button">&times;</button>
                    </div>
                   <form action="" method="POST">
                        <div class="form-m-modal-container">
                            <div class="f-container">
                                <label for="name">Name</label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="name" 
                                    placeholder="Enter your name..." 
                                    readonly
                                >
                            </div>

                            <div class="f-container">
                                <label for="contact_number">Contact Number</label>
                                <input 
                                    type="tel" 
                                    name="contact_number" 
                                    id="contact_number" 
                                    placeholder="Enter your phone number..." 
                                    required
                                >
                            </div>

                            <div class="f-container">
                                <label for="address">Address</label>
                                <textarea 
                                    name="address" 
                                    id="address" 
                                    placeholder="Enter your address..." 
                                    required
                                ></textarea>
                            </div>

                            <div class="f-container">
                                <label for="starting_date">Starting Date</label>
                                <input 
                                    type="date" 
                                    name="starting_date" 
                                    id="starting_date" 
                                    required
                                >
                            </div>

                            <div class="f-container">
                                <label for="end_date">End Date</label>
                                <input 
                                    type="date" 
                                    name="end_date" 
                                    id="end_date" 
                                    required
                                >
                            </div>

                            <div class="f-btn-form">
                                <button type="button" name="v-btn">
                                    View Packages..
                                </button>
                                <button type="submit" name="submit" class="s-btn">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
               </div>

         </div>

         <div class="main-booking-container">
             <h2 class="book-header">
                " Basketball Court Reservations Made Easy "
             </h2>
             <p class="book-p">Find the perfect time to play and secure your slot in just a few clicks.</p>
             <h2 class="offer-header">
                Play & Book Packages:
             </h2>
         </div>
        <div class="booking-box-container">

               <div class="booking-box">
                    <h2 class="book-h">All Star Premium Packages</h2>
                    <h3 class="b-h">
                        Day(s) offer : 4 Days
                    </h3>
                    <h3 class="list-item">List of Items Offer :</h3>
                    <ul class="items-list">
                        <li>2 LED</li>
                        <li>2 Table</li>
                        <li>2 Chairs</li>
                        <li>2 Speaker</li>
                        <li>2 Fan</li>
                        <li>2 GameBoard</li>
                    </ul>
                    <div class="book-btn">
                        <button type="button" id="openBookingBtn">Book Now</button>
                    </div>
                </div>
                <div class="booking-box">
                    <h2 class="book-h">All Star Premium Packages</h2>
                    <h3 class="b-h">
                        Day(s) offer : 4 Days
                    </h3>
                    <h3 class="list-item">List of Items Offer :</h3>
                    <ul class="items-list">
                        <li>2 LED</li>
                        <li>2 Table</li>
                        <li>2 Chairs</li>
                        <li>2 Speaker</li>
                        <li>2 Fan</li>
                        <li>2 GameBoard</li>
                    </ul>
                    <div class="book-btn">
                        <button type="button">Book Now</button>
                    </div>
                </div>
        </div>
    </div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const viewBtn = document.querySelector('button[name="v-btn"]');
    const modal = document.querySelector('.m-view-modal');
    const closeBtn = document.querySelector('.close-view-btn');

    // show modal
    viewBtn.addEventListener("click", () => {
        modal.style.display = "block";
    });

    // hide modal
    closeBtn.addEventListener("click", () => {
        modal.style.display = "none";
    });

    // optional: hide kung i-click outside modal
    window.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const openBtn = document.getElementById("openBookingBtn");
    const modalBox = document.querySelector(".booking-modal-form-box");
    const closeBtns = modalBox.querySelectorAll(".close-view-btn, .close-btn");

    // I-open ang modal
    openBtn.addEventListener("click", function () {
        modalBox.style.display = "flex";
    });

    // I-close ang modal kung i-click ang mga close buttons
    closeBtns.forEach(btn => {
        btn.addEventListener("click", function () {
            modalBox.style.display = "none";
        });
    });

    // Optional: i-close kung mo-click sa gawas sa modal
    window.addEventListener("click", function (e) {
        if (e.target === modalBox) {
            modalBox.style.display = "none";
        }
    });
});
</script>
@endsection