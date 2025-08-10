<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;

class EquipmentController extends Controller
{
    // Show the form + list of equipment
    public function create()
    {
        $equipmentList = Equipment::all();
        return view('settings.equipment', compact('equipmentList'));
    }

    // Store new equipment
    public function store(Request $request)
    {
        $request->validate([
            'equipment' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        Equipment::create([
            'equipment' => $request->input('equipment'),  // or 'name' if that is your column name
            'quantity' => $request->input('quantity'),
        ]);

        return redirect()->route('equipment.create')->with('success', 'Equipment created successfully!');
    }

    // Add more quantity to existing equipment
    public function addMore(Request $request, $id)
    {
        $request->validate([
            'quantity_to_add' => 'required|integer|min:1',
        ]);

        $equipment = Equipment::findOrFail($id);
        $equipment->quantity += $request->quantity_to_add;
        $equipment->save();

        return redirect()->back()->with('success', 'Quantity updated!');
    }

    // Delete equipment
    public function delete($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();

        return redirect()->back()->with('success', 'Equipment deleted!');
    }
}
