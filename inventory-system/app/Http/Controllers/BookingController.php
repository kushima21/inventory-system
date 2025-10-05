<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Gym;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        // ✅ Validate incoming booking data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'starting_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:starting_date',
            'gym_id' => 'required|integer|exists:gym_table,id',
            'equipment_id' => 'nullable|integer|exists:gym_equipment,id',
        ]);

        // ✅ Get gym details (to calculate total price)
        $gym = Gym::find($validated['gym_id']);
        if (!$gym) {
            return back()->with('error', 'Invalid gym selection.');
        }

        // ✅ Compute total days (include start and end)
        $start = Carbon::parse($validated['starting_date']);
        $end = Carbon::parse($validated['end_date']);
        $totalDays = $start->diffInDays($end) + 1;

        // ✅ Compute total price
        $totalPrice = $gym->price * $totalDays;

        // ✅ Create booking record
        Booking::create([
            'user_id' => auth()->check() ? auth()->id() : session('user_id'),
            'name' => $validated['name'],
            'contact_number' => $validated['contact_number'],
            'address' => $validated['address'],
            'starting_date' => $validated['starting_date'],
            'end_date' => $validated['end_date'],
            'gym_id' => $validated['gym_id'],
            'equipment_id' => $validated['equipment_id'] ?? null,
            'total_days' => $totalDays,
            'total_price' => $totalPrice,
            'booking_status' => 'Pending',
        ]);

        // ✅ Redirect with success message
        return redirect()->back()->with('success', 'Booking submitted successfully!');
    }
}
