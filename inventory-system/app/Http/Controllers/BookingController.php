<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Gym;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Show bookings for the logged-in user.
     */
public function showUserBookings()
{
    $userId = auth()->check() ? auth()->id() : session('user_id');

    if (!$userId) {
        return redirect('/login')->with('error', 'Please log in to view bookings.');
    }

    $bookings = Booking::with('gym', 'additionalEquipments')
        ->where('user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->get();

    // Count unread bookings
    $unreadCount = Booking::where('user_id', $userId)
        ->where('is_read', false)
        ->count();

    return view('customers.bookRequest', compact('bookings', 'unreadCount'));
}




public function showNotifBookings()
{
    $userId = auth()->check() ? auth()->id() : session('user_id');

    if (!$userId) {
        return redirect('/login')->with('error', 'Please log in to view bookings.');
    }

    $bookings = Booking::with('gym')
        ->where('user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->get();

    // Mark as read once user opens notifications
    Booking::where('user_id', $userId)
        ->where('is_read', false)
        ->update(['is_read' => true]);

    return view('partials.navbar', compact('bookings'));
}



    /**
     * Show all booking requests for admin dashboard.
     */
    public function showRequestBooking()
    {
        $bookings = Booking::with('gym', 'additionalEquipments')
            ->orderBy('created_at', 'desc')
            ->get();

        // ✅ Total revenue (Completed only)
        $totalRevenue = Booking::where('booking_status', 'Completed')->sum('total_price');

        // ✅ Count bookings by status
        $awaitingCount  = Booking::where('booking_status', 'Pending')->count();
        $confirmedCount = Booking::where('booking_status', 'Approved')->count();
        $cancelledCount = Booking::where('booking_status', 'Cancelled')->count();
        $completedCount = Booking::where('booking_status', 'Completed')->count();

        return view('settings.gym_reservation', compact(
            'bookings',
            'totalRevenue',
            'awaitingCount',
            'confirmedCount',
            'cancelledCount',
            'completedCount'
        ));
    }

    /**
     * Show booking reports with monthly revenue and package counts.
     */
public function showRequestReports()
{
    $bookings = Booking::with('gym', 'additionalEquipments')
        ->orderBy('created_at', 'desc')
        ->get();

    $totalRevenue   = Booking::where('booking_status', 'Completed')->sum('total_price');
    $awaitingCount  = Booking::where('booking_status', 'Pending')->count();
    $confirmedCount = Booking::where('booking_status', 'Approved')->count();
    $cancelledCount = Booking::where('booking_status', 'Cancelled')->count();
    $completedCount = Booking::where('booking_status', 'Completed')->count();

    $packageCounts = Booking::select('gym_id', DB::raw('count(*) as total'))
        ->groupBy('gym_id')
        ->with('gym')
        ->get();

    $monthlyRevenue = Booking::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as revenue')
        )
        ->where('booking_status', 'Completed')
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy(DB::raw('MONTH(created_at)'))
        ->pluck('revenue', 'month')
        ->toArray();

    $revenues = [];
    for ($i = 1; $i <= 12; $i++) {
        $revenues[$i] = $monthlyRevenue[$i] ?? 0;
    }

    return view('settings.reports', compact(
        'bookings',
        'totalRevenue',
        'awaitingCount',
        'confirmedCount',
        'cancelledCount',
        'completedCount',
        'packageCounts',
        'revenues'
    ));
}


    /**
     * Show dashboard summary and charts.
     */
    public function showRequestDashboard()
    {
        $bookings = Booking::with('gym', 'additionalEquipments')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue   = Booking::where('booking_status', 'Completed')->sum('total_price');
        $awaitingCount  = Booking::where('booking_status', 'Pending')->count();
        $confirmedCount = Booking::where('booking_status', 'Approved')->count();
        $cancelledCount = Booking::where('booking_status', 'Cancelled')->count();
        $completedCount = Booking::where('booking_status', 'Completed')->count();

        $packageCounts = Booking::select('gym_id', DB::raw('count(*) as total'))
            ->groupBy('gym_id')
            ->with('gym')
            ->get();

        $monthlyRevenue = Booking::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_price) as revenue')
            )
            ->where('booking_status', 'Completed')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->pluck('revenue', 'month')
            ->toArray();

        $revenues = [];
        for ($i = 1; $i <= 12; $i++) {
            $revenues[$i] = $monthlyRevenue[$i] ?? 0;
        }

        return view('settings.dashboard', compact(
            'bookings',
            'totalRevenue',
            'awaitingCount',
            'confirmedCount',
            'cancelledCount',
            'completedCount',
            'packageCounts',
            'revenues'
        ));
    }

    /**
     * Store a new booking.
     */
    public function store(Request $request)
    {
       $validated = $request->validate([
    'name'                 => 'required|string|max:255',
    'contact_number'       => 'required|string|max:20',
    'address'              => 'required|string|max:500',
    'starting_date'        => 'required|date',
    'end_date'             => 'required|date|after_or_equal:starting_date',
    'gym_id'               => 'required|integer|exists:gym_table,id',
    'equipment_id' => 'nullable|integer|exists:equipment,id',

    'additional_equipments'=> 'nullable|string',
    'final_total'          => 'nullable|numeric',
]);

        $gym = Gym::find($validated['gym_id']);
        if (!$gym) return back()->with('error', 'Invalid gym selection.');

        $start       = Carbon::parse($validated['starting_date']);
        $end         = Carbon::parse($validated['end_date']);
        $totalDays   = $start->diffInDays($end) + 1;
        $totalPrice  = $gym->price * $totalDays;
        $additionalTotal = 0;

        $booking = Booking::create([
            'user_id'        => auth()->check() ? auth()->id() : session('user_id'),
            'name'           => $validated['name'],
            'contact_number' => $validated['contact_number'],
            'address'        => $validated['address'],
            'starting_date'  => $validated['starting_date'],
            'end_date'       => $validated['end_date'],
            'gym_id'         => $validated['gym_id'],
            'equipment_id'   => $validated['equipment_id'] ?? null,
            'total_days'     => $totalDays,
            'total_price'    => $totalPrice,
            'booking_status' => 'Pending',
        ]);

        if (!empty($validated['additional_equipments'])) {
            $equipments = json_decode($validated['additional_equipments'], true);

            if (is_array($equipments)) {
                foreach ($equipments as $item) {
                    $itemTotal = isset($item['total']) ? floatval($item['total']) : 0;

                    \App\Models\AdditionalEquipment::create([
                        'booking_id'      => $booking->booking_id,
                        'equipment_name'  => $item['name'],
                        'quantity'        => $item['quantity'],
                        'price'           => $item['price'],
                    ]);

                    $additionalTotal += $itemTotal;
                }
            }
        }

        $grandTotal = !empty($validated['final_total'])
            ? $validated['final_total']
            : ($totalPrice + $additionalTotal);

        $additionalTotal = $grandTotal - $totalPrice;

        $booking->update([
            'total_price'      => $grandTotal,
            'additional_total' => $additionalTotal,
        ]);

        return redirect()->back()->with('success', 'Booking submitted successfully!');
    }

    /**
     * Approve a booking.
     */
    public function approveBooking($id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['status' => 'error', 'message' => 'Booking not found.']);
        }

        $booking->update([
            'booking_status' => 'Approved',
            'date_approved'  => now(),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Booking approved successfully.']);
    }

    /**
     * Mark booking as completed.
     */
    public function completeBooking($id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['status' => 'error', 'message' => 'Booking not found.']);
        }

        $booking->update([
            'booking_status' => 'Completed',
            'date_completed' => now(),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Booking marked as completed.']);
    }

    /**
     * Cancel a booking with reason.
     */
    public function cancelBooking(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:booking_tbl,booking_id',
            'reason'     => 'required|array|min:1',
        ]);

        $booking = Booking::find($request->booking_id);
        if (!$booking) {
            return back()->with('error', 'Booking not found.');
        }

        $reasonText = implode(', ', $request->reason);

        $booking->update([
            'booking_status' => 'Cancelled',
            'date_cancelled' => now(),
            'cancel_reason'  => $reasonText,
        ]);

        return redirect()->back()->with('success', 'Booking cancelled successfully.');
    }
}
