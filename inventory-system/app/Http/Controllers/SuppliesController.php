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
public function inventory(Request $request)
{
    // ✅ Get search inputs
    $supplySearch = $request->input('supply_search');
    $equipmentSearch = $request->input('equipment_search');

    // ✅ SUPPLIES: Search and filter
    $supplyQuery = \App\Models\SupplyInventory::select('id', 'supply_name', 'quantity')
        ->orderBy('created_at', 'desc');

    if (!empty($supplySearch)) {
        $supplyQuery->where('supply_name', 'like', "%{$supplySearch}%");
    }

    $groupedSupplies = $supplyQuery->get();

    // ✅ EQUIPMENT: Search and filter
    $equipmentQuery = \App\Models\EquipmentInventory::select('equipment_name', 'quantity');

    if (!empty($equipmentSearch)) {
        $equipmentQuery->where('equipment_name', 'like', "%{$equipmentSearch}%");
    }

    $equipmentInventory = $equipmentQuery->get();

    // ✅ Group equipment quantities
    $groupedEquipment = $equipmentInventory->groupBy('equipment_name')->map(function ($group) {
        return (object) [
            'equipment_name' => $group->first()->equipment_name,
            'quantity' => $group->sum('quantity'),
        ];
    })->values();

    // ✅ Other data for modal dropdowns
    $supplies = \App\Models\Supplies::orderBy('created_at', 'desc')->get();
    $equipmentList = \App\Models\Equipment::select('equipment', 'quantity', 'created_at')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('settings.inventory', compact(
        'groupedSupplies',
        'supplies',
        'equipmentList',
        'groupedEquipment'
    ));
}






    // ✅ ADD SUPPLY (with "Add Other Supply" option)
public function store(Request $request) 
{
    $request->validate([
        'supplies'   => 'required|string|max:255',
        'quantity'   => 'required|integer|min:1',
        'category'   => 'required|string', // ✅ Validate category
    ]);

    // ✅ Determine kung nag-add ba ug "Other Supply"
    $supplyName = $request->supplies === 'Add Other Supply' && !empty($request->other_supply)
        ? $request->other_supply
        : $request->supplies;

    $category = $request->category; // ✅ Get category from request

    // ✅ 1. I-save ang supply sa main Supplies table
    $supply = \App\Models\Supplies::create([
        'supplies'   => $supplyName,
        'quantity'   => $request->quantity,
        'category'   => $category, // ✅ Save category
    ]);

    // ✅ 2. Check kung existing na ang supply name sa supply_inventory
    $existingInventory = \App\Models\SupplyInventory::where('supply_name', $supplyName)->first();

    if ($existingInventory) {
        // 🔁 Kung existing, i-update ang quantity (add new quantity)
        $existingInventory->quantity += $request->quantity;
        $existingInventory->category = $category; // ✅ Update category too
        $existingInventory->save();
    } else {
        // 🆕 Kung wala pa, i-create bagong record
        \App\Models\SupplyInventory::create([
            'supply_id'   => $supply->id,
            'supply_name' => $supplyName,
            'quantity'    => $request->quantity,
            'category'    => $category, // ✅ Save category in inventory
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



    /* ============================================================
     |  FACULTY SECTION
     |============================================================ */

    // ✅ FACULTY SUPPLY REQUEST PAGE
public function facultySupplyDisplay()
{
    // ✅ Get all supplies from supply_inventory table including category
    $supplies = \App\Models\SupplyInventory::select('id', 'supply_name', 'quantity', 'category') // ✅ include category
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
        'category' => 'required|string',
        'date_return' => 'nullable|date',
    ]);

    // ✅ Keep original case (e.g. "Equipment" or "Supplies")
    $category = trim($request->category);

    // ✅ Case-insensitive check for 'Equipment'
    $dateReturn = (strcasecmp($category, 'Equipment') === 0) ? $request->date_return : null;

    SupplyRequest::create([
        'name' => $request->name,
        'phone_number' => $request->phone_number,
        'email' => $request->email,
        'date_needed' => $request->date_needed,
        'supply_name' => $request->supply_name,
        'quantity' => $request->quantity,
        'category' => $category, // keep original capitalization
        'date_return' => $dateReturn,
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
    $search = $request->input('searchFacultyRequest');

    $requestsQuery = SupplyRequest::query()
        ->whereIn('request_status', ['Pending', 'Approved'])
        ->orderBy('created_at', 'desc');

    // 🔍 Filter by request status if selected
    if (!empty($status)) {
        $requestsQuery->where('request_status', $status);
    }

    // 🔍 SEARCH FUNCTION (Name, Email, Supply Name)
    if (!empty($search)) {
        $requestsQuery->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%$search%")
              ->orWhere('email', 'LIKE', "%$search%")
              ->orWhere('supply_name', 'LIKE', "%$search%");
        });
    }

    $requests = $requestsQuery->get();

    // Counts
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

    // IF CATEGORY IS EQUIPMENT → DON'T DEDUCT STOCK
    if ($request->category === 'Equipment') {

        $request->update([
            'request_status' => 'Completed',
            'date_completed' => now(),
        ]);

        return redirect()->back()->with('success', 'Equipment request marked as Completed.');
    }

    // BELOW ONLY RUNS IF CATEGORY = ITEM
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

    // ✅ Mark completed
    $request->update([
        'request_status' => 'Completed',
        'date_completed' => now(),
    ]);

    return redirect()->back()->with('success', 'Item request completed and stock updated!');
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
    $search = $request->input('searchfaculty'); // ⭐ Get search input

    $requestsQuery = SupplyRequest::query()->orderBy('created_at', 'desc');

    // 🔍 Search filter
    if (!empty($search)) {
        $requestsQuery->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('supply_name', 'like', "%{$search}%");
        });
    }

    // Filter by status
    if (!empty($status)) {
        $requestsQuery->where('request_status', $status);
    }

    // Filter by date range
    if ($status === 'Completed' && !empty($startDate) && !empty($endDate)) {
        $requestsQuery->whereBetween('updated_at', [$startDate, $endDate]);
    }

    $reports = $requestsQuery->get();

    // Counts
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
        'endDate',
        'search'
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

    public function inventorySearch(Request $request)
{
    $search = $request->input('search');

    // ✅ Filter supplies based on search
    $query = \App\Models\SupplyInventory::select('id', 'supply_name', 'quantity')
        ->orderBy('created_at', 'desc');

    if (!empty($search)) {
        $query->where('supply_name', 'like', "%{$search}%");
    }

    $groupedSupplies = $query->get();

    // ✅ Other existing data
    $supplies = \App\Models\Supplies::orderBy('created_at', 'desc')->get();
    $equipmentList = \App\Models\Equipment::select('equipment', 'quantity', 'created_at')
        ->orderBy('created_at', 'desc')
        ->get();

    $equipmentInventory = \App\Models\EquipmentInventory::select('equipment_name', 'quantity')->get();
    $groupedEquipment = $equipmentInventory->groupBy('equipment_name')->map(function ($group) {
        return (object) [
            'equipment_name' => $group->first()->equipment_name,
            'quantity' => $group->sum('quantity'),
        ];
    })->values();

    return view('settings.inventory', compact('groupedSupplies', 'supplies', 'equipmentList', 'groupedEquipment'));
}


public function searchSupplies(Request $request)
{
    $query = $request->input('query');

    $supplies = \App\Models\SupplyInventory::where('supply_name', 'like', "%{$query}%")
        ->select('supply_name', 'quantity')
        ->orderBy('supply_name', 'asc')
        ->get();

    return response()->json($supplies);
}
// ✅ UPDATE SUPPLY
public function update(Request $request, $id)
{
    $request->validate([
        'supplies' => 'required|string|max:255',
        'quantity' => 'required|integer|min:1',
    ]);

    // 1️⃣ Update supply_inventory record
    $inventory = \App\Models\SupplyInventory::findOrFail($id);
    $oldName = $inventory->supply_name;

    $inventory->update([
        'supply_name' => $request->supplies,
        'quantity' => $request->quantity,
    ]);

    // 2️⃣ Update main supplies table using the old name
    \App\Models\Supplies::where('supplies', $oldName)
        ->update([
            'supplies' => $request->supplies,
            'quantity' => $request->quantity,
        ]);

    // 3️⃣ Redirect back to the same page
    return redirect()->back()->with('success', 'Supply updated successfully in both inventory and main supplies!');
}



// SuppliesController.php
// SuppliesController.php
public function destroy($id)
{
    // 1️⃣ Get the supply_inventory record
    $inventory = \App\Models\SupplyInventory::find($id);

    if ($inventory) {
        // 2️⃣ Delete from supplies table using the same name
        $supplyName = $inventory->supply_name;
        \App\Models\Supplies::where('supplies', $supplyName)->delete();

        // 3️⃣ Delete from supply_inventory table
        $inventory->delete();
    }

    // 4️⃣ Redirect back to the same page
    return redirect()->back()
                     ->with('success', 'Supply deleted successfully from both inventory and main supplies!');
}

}
