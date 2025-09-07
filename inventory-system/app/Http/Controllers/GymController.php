<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gym;
use App\Models\Equipment;

class GymController extends Controller
{
    public function store(Request $request)
    {
        // validate inputs
        $request->validate([
            'packages' => 'required|string',
            'price' => 'required|numeric|min:0',
            'equipment' => 'nullable|array',
            'equipment.*' => 'exists:equipment,id',
        ]);

        // save gym reservation
        $reservation = Gym::create([
            'package' => $request->packages,
            'price'   => $request->price,
        ]);

        // save selected equipment with quantity
        if ($request->has('equipment')) {
            foreach ($request->equipment as $equipmentId) {
                $quantity = $request->equipment_quantity[$equipmentId] ?? 1;

                $reservation->equipment()->attach($equipmentId, [
                    'quantity' => $quantity
                ]);
            }
        }

        return redirect()->back()->with('success', 'Reservation saved successfully!');
    }

   public function index()
    {
        // kuhaon tanan package with equipment
        $gyms = Gym::with('equipment')->get();

        // kuhaon pud tanan available equipment para sa form
        $equipmentList = Equipment::all();

        return view('settings.gym', compact('gyms', 'equipmentList'));
    }

}
