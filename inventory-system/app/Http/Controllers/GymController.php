<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gym;
use App\Models\Equipment;

class GymController extends Controller
{
    /**
     * Store a new gym reservation/package.
     */
    public function store(Request $request)
    {
        // Validate inputs
        $request->validate([
            'package' => 'required|string',
            'price' => 'required|numeric|min:0',
            'equipment' => 'nullable|array',
            'equipment.*' => 'exists:equipment,id',
            'equipment_quantity' => 'nullable|array',
        ]);

        // Create gym reservation
        $reservation = Gym::create([
            'package' => $request->package,
            'price' => $request->price,
        ]);

        // Attach selected equipment with quantity
        if ($request->filled('equipment')) {
            foreach ($request->equipment as $equipmentId) {
                $quantity = $request->equipment_quantity[$equipmentId] ?? 1;
                $reservation->equipment()->attach($equipmentId, ['quantity' => $quantity]);
            }
        }

        return redirect()->back()->with('success', 'Reservation saved successfully!');
    }

    /**
     * Display all gym packages with equipment.
     */
    public function index()

    {

        
        $gyms = Gym::with('equipment')->get();
        $equipmentList = Equipment::all();

        return view('settings.gym', compact('gyms', 'equipmentList'));
    }

    /**
     * Delete a gym package/reservation.
     */
    public function destroy($id)
    {
        $gym = Gym::findOrFail($id);

        // Detach equipment before deleting to avoid foreign key issues
        $gym->equipment()->detach();

        $gym->delete();

        return redirect()->back()->with('success', 'Package deleted successfully!');
    }

    public function BookIndex()
    {
        $gyms = Gym::with('equipment')->get();
        $equipmentList = Equipment::all();

        // ibalik ang book.blade.php
        return view('book', compact('gyms', 'equipmentList'));
    }

      public function BookRequest()
    {
        $gyms = Gym::with('equipment')->get();
        $equipmentList = Equipment::all();

        // ibalik ang book.blade.php
        return view('settings.gym_resevations', compact('gyms', 'equipmentList'));
    }

      public function BookReserved()
    {
        $gyms = Gym::with('equipment')->get();
        $equipmentList = Equipment::all();

        // ibalik ang book.blade.php
        return view('customers.userBook', compact('gyms', 'equipmentList'));
    }

    

public function userBook()
{
    $gyms = Gym::with('equipment')->orderBy('created_at', 'desc')->get();
    $bundles = \App\Models\EquipmentBundle::with('equipment')->orderBy('created_at', 'desc')->get();

    return view('customers.userBook', compact('gyms', 'bundles'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'package' => 'required|string',
        'price' => 'required|numeric|min:0',
        'equipment' => 'nullable|array',
        'equipment.*' => 'exists:equipment,id',
        'equipment_quantity' => 'nullable|array',
    ]);

    $gym = Gym::findOrFail($id);
    $gym->update([
        'package' => $request->package,
        'price' => $request->price,
    ]);

    // ✅ Prepare updated data (replace quantity)
    $syncData = [];
    if ($request->filled('equipment')) {
        foreach ($request->equipment as $equipmentId) {
            $newQty = (int)($request->equipment_quantity[$equipmentId] ?? 1);
            $syncData[$equipmentId] = ['quantity' => $newQty];
        }
    }

    // ✅ Sync — replaces existing pivot quantities instead of adding
    $gym->equipment()->sync($syncData);

    return redirect()->back()->with('success', 'Package updated successfully!');
}



}
