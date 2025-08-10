<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplies;  // Import the model here

class SuppliesController extends Controller
{
    // Show the form view
    public function create()
    {
        $supplies = Supplies::all();  // get all supplies from DB
        return view('settings.supplies', compact('supplies'));
    }

    // Save supplies to DB
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
    $supply->quantity += $request->quantity_to_add; // add the input quantity
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
