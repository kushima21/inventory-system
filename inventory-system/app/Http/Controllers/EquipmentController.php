<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;

class EquipmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'equipment' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        Equipment::create([
            'equipment' => $request->equipment,
            'quantity' => $request->quantity,
        ]);

        return redirect()->back()->with('success', 'Equipment created successfully!');
    }

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

    public function delete($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();

        return redirect()->back()->with('success', 'Equipment deleted!');
    }
}