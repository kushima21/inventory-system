<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplies;
use App\Models\Equipment;
use App\Models\SupplyRequest;
use App\Models\Booking;

class SuppliesController extends Controller
{
    // ✅ INVENTORY DISPLAY
    public function inventory()
    {
        $supplies = Supplies::all();
        $equipmentList = Equipment::all();
        return view('settings.inventory', compact('supplies', 'equipmentList'));
    }

    public function create()
    {
        $supplies = Supplies::all();
        return view('settings.inventory', compact('supplies'));
    }

    // ✅ FACULTY REQUEST PAGE
    public function facultySupplyDisplay()
    {
        $supplies = Supplies::all();
        $equipmentList = Equipment::all();
        return view('faculty.facultyRequest', compact('supplies', 'equipmentList'));
    }

    // ✅ FACULTY SUBMIT REQUEST
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
            'request_status' => 'Pending',
        ]);

        return redirect()->back()->with('success', 'Supply request submitted successfully!');
    }

    // ✅ FACULTY REQUEST LIST
    public function facultyRequestDisplay()
    {
        $requests = SupplyRequest::orderBy('created_at', 'desc')->get();
        return view('faculty.facultyMyRequest', compact('requests'));
    }

    // ✅ ADMIN OVERVIEW (REQUEST SUPPLY)
    public function facultyRequesOverview(Request $request)
    {
        $status = $request->input('request_status');
        $requestsQuery = SupplyRequest::query()->orderBy('created_at', 'desc');

        if (!empty($status)) {
            $requestsQuery->where('request_status', $status);
        }

        $requests = $requestsQuery->get();

        $totalCompleted = SupplyRequest::where('request_status', 'Completed')->count();
        $awaitingConfirmation = SupplyRequest::where('request_status', 'Pending')->count();
        $cancelledRequests = SupplyRequest::where('request_status', 'Cancelled')->count();
        $unapprovedRequests = SupplyRequest::where('request_status', 'Declined')->count();

        return view('settings.requestSupply', compact(
            'requests',
            'totalCompleted',
            'awaitingConfirmation',
            'cancelledRequests',
            'unapprovedRequests',
            'status'
        ));
    }

    // ✅ CANCEL FACULTY REQUEST
    public function cancelFacultyRequest(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|array|min:1',
        ]);

        $supplyRequest = SupplyRequest::findOrFail($id);
        $supplyRequest->update([
            'request_status' => 'Cancelled',
            'reason' => implode(', ', $request->reason),
            'date_cancelled' => now(),
        ]);

        return redirect()->back()->with('success', 'Supply request cancelled successfully!');
    }

    // ✅ ADD SUPPLY
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

    // ✅ ADD MORE QUANTITY
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

    // ✅ DELETE SUPPLY
    public function delete($id)
    {
        $supply = Supplies::findOrFail($id);
        $supply->delete();

        return redirect()->back()->with('success', 'Supply deleted!');
    }

    // ✅ APPROVE REQUEST
    public function approveRequest($id)
    {
        $request = SupplyRequest::findOrFail($id);
        $request->update([
            'request_status' => 'Approved',
            'date_approved' => now()
        ]);
        return redirect()->back()->with('success', 'Request approved!');
    }

    // ✅ DECLINE REQUEST
    public function declineRequest($id)
    {
        $request = SupplyRequest::findOrFail($id);
        $request->update([
            'request_status' => 'Declined',
            'date_declined' => now()
        ]);
        return redirect()->back()->with('success', 'Request declined!');
    }

    public function completeRequest($id)
{
    $request = SupplyRequest::findOrFail($id);

    // Update status to Completed
    $request->update([
        'request_status' => 'Completed',
        'date_completed' => now()
    ]);

    return redirect()->back()->with('success', 'Request marked as completed!');
}
}
