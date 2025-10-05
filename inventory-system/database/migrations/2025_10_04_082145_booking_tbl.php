<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        // ✅ Validate incoming data
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'starting_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:starting_date',
            'gym_id' => 'nullable|integer',
            'equipment_id' => 'nullable|integer',
        ]);

        // ✅ Compute total days and total price
        $start = Carbon::parse($validated['starting_date']);
        $end = Carbon::parse($validated['end_date']);
        $validated['total_days'] = $start->diffInDays($end) + 1;

        // Example: if you have gym price data
        $gym = \App\Models\Gym::find($validated['gym_id']);
        $validated['total_price'] = $gym ? $gym->price * $validated['total_days'] : 0;

        // ✅ Save booking
        Booking::create($validated);

        return redirect()->back()->with('success', 'Booking submitted successfully!');
    }
}
