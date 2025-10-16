<?php

namespace App\Http\Controllers;
use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Models\Supplies;  // Import the model here
use App\Models\SupplyRequest;


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

public function storeFacultyRequest(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone_number' => 'required|string|max:20',
        'email' => 'required|email|max:255',
        'date_needed' => 'required|date',
        'supply_name' => 'required|string|max:255',
        'quantity' => 'required|integer|min:1',
    ]);

    SupplyRequest::create([
        'name' => $request->name,
        'phone_number' => $request->phone_number,
        'email' => $request->email,
        'date_needed' => $request->date_needed,
        'supply_name' => $request->supply_name,
        'quantity' => $request->quantity,
        'request_status' => 'Pending', // Default status
        'date_approved' => null,
        'date_completed' => null,
        'date_cancelled' => null,
        'reason' => null,
    ]);

    return redirect()->back()->with('success', 'Supply request submitted successfully!');
}

public function facultyRequestDisplay()
{
    // Fetch all supply requests ordered by most recent
    $requests = \App\Models\SupplyRequest::orderBy('created_at', 'desc')->get();

    // Pass the data to the view
    return view('faculty.facultyMyRequest', compact('requests'));
}


public function cancelFacultyRequest(Request $request, $id)
{
    $request->validate([
        'reason' => 'required|array|min:1',
    ]);

    $supplyRequest = SupplyRequest::findOrFail($id);

    // Update the request
    $supplyRequest->update([
        'request_status' => 'Cancelled',
        'reason' => implode(', ', $request->reason), // Combine multiple reasons
        'date_cancelled' => now(),
    ]);

    return redirect()->back()->with('success', 'Supply request cancelled successfully!');
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