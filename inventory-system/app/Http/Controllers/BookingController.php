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
        // ✅ Validate booking form
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'starting_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:starting_date',
            'gym_id' => 'required|integer|exists:gym_table,id',
            'equipment_id' => 'nullable|integer|exists:gym_equipment,id',
            'additional_equipments' => 'nullable|string',
            'final_total' => 'nullable|numeric',
        ]);

        // ✅ Get gym and compute total days
        $gym = \App\Models\Gym::find($validated['gym_id']);
        if (!$gym) {
            return back()->with('error', 'Invalid gym selection.');
        }

        $start = \Carbon\Carbon::parse($validated['starting_date']);
        $end = \Carbon\Carbon::parse($validated['end_date']);
        $totalDays = $start->diffInDays($end) + 1;

        // ✅ Base total from gym
        $totalPrice = $gym->price * $totalDays;
        $additionalTotal = 0;

        // ✅ Create booking first
        $booking = \App\Models\Booking::create([
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

        // ✅ Save Additional Equipments (if any)
        if (!empty($validated['additional_equipments'])) {
            $equipments = json_decode($validated['additional_equipments'], true);

            if (is_array($equipments)) {
                foreach ($equipments as $item) {
                    $itemTotal = isset($item['total']) ? floatval($item['total']) : 0;

                    \App\Models\AdditionalEquipment::create([
                        'booking_id' => $booking->booking_id, // ✅ FIXED HERE
                        'equipment_name' => $item['name'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);

                    $additionalTotal += $itemTotal;
                }
            }
        }

        // ✅ Add additional total to booking total
        $grandTotal = $totalPrice + $additionalTotal;

        // ✅ Update booking total (use JS total if provided)
        if (!empty($validated['final_total'])) {
            $grandTotal = $validated['final_total'];
        }

        $booking->update(['total_price' => $grandTotal]);

        return redirect()->back()->with('success', 'Booking submitted successfully!');
    }
}
