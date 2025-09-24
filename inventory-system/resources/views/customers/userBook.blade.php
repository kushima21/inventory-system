@extends('partials.navbar') 

@vite(['resources/css/book.css', 'resources/js/app.js'])

@section('content')
    <div class="content-main-container">

         <div class="booking-modal-form-box">
                
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
                                <button type="submit" name="v-btn">
                                    View Packages..
                                </button>
                                <button type="button" name="s-btn">
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
                    <h3 class="list-item">List of Items Offer :</h3>
                    <ul class="items-list">
                        <li>LED - <span>10 pieces</span></li>
                        <li>Table - <span>10 pieces</span></li>
                        <li>Chairs - <span>10 pieces</span></li>
                        <li>Speaker - <span>10 pieces</span></li>
                        <li>Fan - <span>10 pieces</span></li>
                        <li>GameBoard - <span>10 pieces</span></li>
                    </ul>
                    <div class="book-btn">
                        <button type="button">Book Now</button>
                    </div>
                </div>
                <div class="booking-box">
                    <h2 class="book-h">All Star Premium Packages</h2>
                    <h3 class="list-item">List of Items Offer :</h3>
                    <ul class="items-list">
                        <li>LED - <span>10 pieces</span></li>
                        <li>Table - <span>10 pieces</span></li>
                        <li>Chairs - <span>10 pieces</span></li>
                        <li>Speaker - <span>10 pieces</span></li>
                        <li>Fan - <span>10 pieces</span></li>
                        <li>GameBoard - <span>10 pieces</span></li>
                    </ul>
                    <div class="book-btn">
                        <button type="button">Book Now</button>
                    </div>
                </div>
        </div>
    </div>
@endsection