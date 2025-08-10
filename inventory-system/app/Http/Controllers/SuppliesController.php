<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplies;  // Import the model here

class SuppliesController extends Controller
{
    // Show the form view
    public function create()
    {
        return view('settings.supplies'); // your form blade
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
}
