@extends('layout.default')
@vite(['resources/css/gym.css', 'resources/js/app.js'])

@section('content')

    <div class="gym-header-container">
        <h2 class="gym-header">Gym Section</h2>

        <div class="gym-box-header">
            <form method="POST" action="">
                <input type="text" class="gymSearch" placeholder="Quick Search...">
            </form>

            <button class="gymBtn" type="button" onclick="openGymModal()">
                + Create Gym Offer
            </button>
        </div>

    </div> 

@endsection