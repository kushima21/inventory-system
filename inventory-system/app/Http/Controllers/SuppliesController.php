<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplies;
use App\Models\Equipment;
use App\Models\SupplyRequest;
use App\Models\Booking;
use App\Exports\SupplyReportsExport;
use Maatwebsite\Excel\Facades\Excel;

class SuppliesController extends Controller
{

    /* ============================================================
     |  DASHBOARD SECTION
     |============================================================ */
    public function dashboard()
    {
        // ✅ BOOKING STATS
        $bookings = Booking::with('gym', 'additionalEquipments')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue   = Booking::where('booking_status', 'Completed')->sum('total_price');
        $awaitingCount  = Booking::where('booking_status', 'Pending')->count();
        $confirmedCount = Booking::where('booking_status', 'Approved')->count();
        $cancelledCount = Booking::where('booking_status', 'Cancelled')->count();
        $completedCount = Booking::where('booking_status', 'Completed')->count();

        // ✅ Monthly revenue
        $monthlyRevenue = Booking::select(
                \DB::raw('MONTH(created_at) as month'),
                \DB::raw('SUM(total_price) as revenue')
            )
            ->where('booking_status', 'Completed')
            ->groupBy(\DB::raw('MONTH(created_at)'))
            ->orderBy(\DB::raw('MONTH(created_at)'))
            ->pluck('revenue', 'month')
            ->toArray();

        $revenues = [];
        for ($i = 1; $i <= 12; $i++) {
            $revenues[$i] = $monthlyRevenue[$i] ?? 0;
        }

        // ✅ SUPPLY STATS
        $completedRequests = SupplyRequest::where('request_status', 'Completed')
            ->orderBy('date_completed', 'desc')
            ->get();

        $recentRequests = SupplyRequest::where('request_status', 'Pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('settings.dashboard', compact(
            'bookings',
            'totalRevenue',
            'awaitingCount',
            'confirmedCount',
            'cancelledCount',
            'completedCount',
            'revenues',
            'completedRequests',
            'recentRequests'
        ));
    }

    /* ============================================================
     |  INVENTORY SECTION
     |============================================================ */
   public function inventory()
{
    // ✅ Get all data directly from supply_inventory table
    $groupedSupplies = \App\Models\SupplyInventory::select('id', 'supply_name', 'quantity')
        ->orderBy('created_at', 'desc')
        ->get();

    // ✅ Optional: still get original supplies + equipment for other sections
    $supplies = \App\Models\Supplies::orderBy('created_at', 'desc')->get();
    $equipmentList = \App\Models\Equipment::all();

    return view('settings.inventory', compact('groupedSupplies', 'supplies', 'equipmentList'));
}


    // ✅ ADD SUPPLY (with "Add Other Supply" option)
public function store(Request $request) 
{
    $request->validate([
        'supplies' => 'required|string|max:255',
        'quantity' => 'required|integer|min:1',
    ]);

    // ✅ Determine kung nag-add ba ug "Other Supply"
    $supplyName = $request->supplies === 'Add Other Supply' && !empty($request->other_supply)
        ? $request->other_supply
        : $request->supplies;

    // ✅ 1. I-save ang supply sa main Supplies table
    $supply = \App\Models\Supplies::create([
        'supplies' => $supplyName,
        'quantity' => $request->quantity,
    ]);

    // ✅ 2. Check kung existing na ang supply name sa supply_inventory
    $existingInventory = \App\Models\SupplyInventory::where('supply_name', $supplyName)->first();

    if ($existingInventory) {
        // 🔁 Kung existing, i-update ang quantity (add new quantity)
        $existingInventory->quantity += $request->quantity;
        $existingInventory->save();
    } else {
        // 🆕 Kung wala pa, i-create bagong record
        \App\Models\SupplyInventory::create([
            'supply_id' => $supply->id,
            'supply_name' => $supplyName,
            'quantity' => $request->quantity,
        ]);
    }

    return redirect()->back()->with('success', 'Supply added successfully and reflected in inventory!');
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

    // ✅ UPDATE SUPPLY
    public function update(Request $request, $id)
    {
        $request->validate([
            'supplies' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        $supply = Supplies::findOrFail($id);
        $supply->update([
            'supplies' => $request->supplies,
            'quantity' => $request->quantity,
        ]);

        return redirect()->back()->with('success', 'Supply updated successfully!');
    }

    // ✅ DELETE SUPPLY
    public function delete($id)
    {
        $supply = Supplies::findOrFail($id);
        $supply->delete();

        return redirect()->back()->with('success', 'Supply deleted!');
    }


    /* ============================================================
     |  FACULTY SECTION
     |============================================================ */

    // ✅ FACULTY SUPPLY REQUEST PAGE
 public function facultySupplyDisplay()
{
    // ✅ Get all supplies from supply_inventory table
    $supplies = \App\Models\SupplyInventory::select('id', 'supply_name', 'quantity')
        ->orderBy('supply_name', 'asc')
        ->get();

    // ✅ Optional: retain equipment list if still needed
    $equipmentList = \App\Models\Equipment::all();

    return view('faculty.facultyRequest', compact('supplies', 'equipmentList'));
}


    // ✅ FACULTY SUBMITS REQUEST
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
   public function facultyRequestDisplay(Request $request)
{
    // Get logged-in user's email from session
    $user_id = $request->session()->get('user_id');

    if (!$user_id) {
        // Optional: redirect to login if session expired
        return redirect()->route('login')->with('error', 'Please login first.');
    }

    $user = \App\Models\User::find($user_id);

    // Only fetch requests for this user's email
    $requests = \App\Models\SupplyRequest::where('email', $user->email)
                    ->orderBy('created_at', 'desc')
                    ->get();

    return view('faculty.facultyMyRequest', compact('requests'));
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


    /* ============================================================
     |  ADMIN SECTION
     |============================================================ */

    // ✅ ADMIN OVERVIEW (Pending + Approved Requests)
    public function facultyRequesOverview(Request $request)
    {
        $status = $request->input('request_status');

        $requestsQuery = SupplyRequest::query()
            ->whereIn('request_status', ['Pending', 'Approved'])
            ->orderBy('created_at', 'desc');

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

    // ✅ COMPLETE REQUEST (deducts from inventory)
// ✅ COMPLETE REQUEST (Admin marks a request as completed and deducts inventory)
public function completeRequest($id)
{
    // 🔍 Find the supply request
    $request = SupplyRequest::findOrFail($id);

    // 🔍 Find the corresponding supply in supply_inventory
    $inventory = \App\Models\SupplyInventory::where('supply_name', $request->supply_name)->first();

    if (!$inventory) {
        return redirect()->back()->with('error', 'Supply not found in inventory!');
    }

    // ⚠️ Check if there's enough stock
    if ($inventory->quantity < $request->quantity) {
        return redirect()->back()->with('error', 'Not enough stock to complete this request!');
    }

    // 📉 Deduct from inventory
    $inventory->quantity -= $request->quantity;
    $inventory->save();

    // ✅ Mark the request as completed
    $request->update([
        'request_status' => 'Completed',
        'date_completed' => now(),
    ]);

    return redirect()->back()->with('success', 'Request marked as Completed and stock updated!');
}



    /* ============================================================
     |  REPORTS SECTION
     |============================================================ */

    // ✅ VIEW REPORTS
    public function facultyReports(Request $request)
    {
        $status = $request->input('request_status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $requestsQuery = SupplyRequest::query()->orderBy('created_at', 'desc');

        // Filter by status
        if (!empty($status)) {
            $requestsQuery->where('request_status', $status);
        }

        // Filter by date range (Completed only)
        if ($status === 'Completed' && !empty($startDate) && !empty($endDate)) {
            $requestsQuery->whereBetween('updated_at', [$startDate, $endDate]);
        }

        $reports = $requestsQuery->get();

        $totalCompleted = SupplyRequest::where('request_status', 'Completed')->count();
        $awaitingConfirmation = SupplyRequest::where('request_status', 'Pending')->count();
        $cancelledRequests = SupplyRequest::where('request_status', 'Cancelled')->count();
        $unapprovedRequests = SupplyRequest::where('request_status', 'Declined')->count();

        return view('settings.supplyReports', compact(
            'reports',
            'totalCompleted',
            'awaitingConfirmation',
            'cancelledRequests',
            'unapprovedRequests',
            'status',
            'startDate',
            'endDate'
        ));
    }

    // ✅ EXPORT REPORTS (Excel)
    public function exportSupplyReports(Request $request)
    {
        $status = $request->input('request_status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $fileName = 'supply_report_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new SupplyReportsExport($status, $startDate, $endDate), $fileName);
    }
}
