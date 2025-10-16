<?php

namespace App\Http\Controllers;
use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Models\Supplies;  // Import the model here

class SuppliesController extends Controller
{
    // ✅ Unified inventory display for both supplies and equipment
    public function inventory()
    {
        $supplies = Supplies::all();
        $equipmentList = Equipment::all();
        return view('settings.inventory', compact('supplies', 'equipmentList'));
    }

    // existing create() method (optional, can be removed)
    public function create()
    {
        $supplies = Supplies::all();
        return view('settings.inventory', compact('supplies'));
    }

     public function facultySupplyDisplay()
    {
        $supplies = Supplies::all();
        $equipmentList = Equipment::all();
        return view('faculty.facultyRequest', compact('supplies', 'equipmentList'));
    }

    // Save supplies
    public function store(Request $request)
    {
        $request->validate([
            'supplies' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        Supplies::create([
            'supplies' => $request->supplies,
            'quantity' => $request->quantity,
        ]);

        return redirect()->back()->with('success', 'Supplies added successfully!');
    }

    public function addMore(Request $request, $id)
    {
        $request->validate([
            'quantity_to_add' => 'required|integer|min:1',
        ]);

        $supply = Supplies::findOrFail($id);
        $supply->quantity += $request->quantity_to_add;
        $supply->save();

        return redirect()->back()->with('success', 'Quantity updated!');
    }

    public function delete($id)
    {
        $supply = Supplies::findOrFail($id);
        $supply->delete();

        return redirect()->back()->with('success', 'Supply deleted!');
    }
}