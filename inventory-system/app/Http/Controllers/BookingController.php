<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Gym;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


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

    // Fetch all bookings for the user
    $bookings = Booking::with('gym')
        ->where('user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->get();

    // ✅ Count unread notifications for Approved or Completed bookings
    $unreadCount = Booking::where('user_id', $userId)
        ->where('is_read', false)
        ->whereIn('booking_status', ['Approved', 'Completed'])
        ->count();

    return view('partials.navbar', compact('bookings', 'unreadCount'));
}

/**
 * ✅ Mark all notifications as read
 */
public function markAsRead()
{
    $userId = auth()->check() ? auth()->id() : session('user_id');

    Booking::where('user_id', $userId)
        ->whereIn('booking_status', ['Approved', 'Completed','Declined'])
        ->update(['is_read' => true]);

    return response()->json(['success' => true]);
}

/**
 * ✅ Automatically mark notification as unread when booking_status updates
 */
public function updateBookingStatus(Request $request, $id)
{
    $booking = Booking::findOrFail($id);
    $booking->booking_status = $request->input('booking_status');

    // ✅ Automatically set notif as unread again when status changes
    if (in_array($booking->booking_status, ['Approved', 'Completed','Declined'])) {
        $booking->is_read = false;
    }

    $booking->save();

    return response()->json(['success' => true]);
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
public function showRequestReports(Request $request)
{
    $status = $request->get('status'); // get the selected status

    // ✅ Filter bookings if status is selected
    $bookingsQuery = Booking::with('gym', 'additionalEquipments')
        ->orderBy('created_at', 'desc');

    if (!empty($status)) {
        $bookingsQuery->where('booking_status', $status);
    }

    $bookings = $bookingsQuery->get();

    // ✅ Stats
    $totalRevenue   = Booking::where('booking_status', 'Completed')->sum('total_price');
    $awaitingCount  = Booking::where('booking_status', 'Pending')->count();
    $confirmedCount = Booking::where('booking_status', 'Approved')->count();
    $cancelledCount = Booking::where('booking_status', 'Cancelled')->count();
    $completedCount = Booking::where('booking_status', 'Completed')->count();

    // ✅ Package counts
    $packageCounts = Booking::select('gym_id', DB::raw('count(*) as total'))
        ->groupBy('gym_id')
        ->with('gym')
        ->get();

    // ✅ Monthly revenue
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
        'revenues',
        'status'
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
        'name'                  => 'required|string|max:255',
        'contact_number'        => 'required|string|max:20',
        'address'               => 'required|string|max:500',
        'starting_date'         => 'required|date',
        'end_date'              => 'required|date|after_or_equal:starting_date',
        'gym_id'                => 'required|integer|exists:gym_table,id',
        'equipment_id'          => 'nullable|integer|exists:equipment,id',
        'additional_equipments' => 'nullable|string',
        'final_total'           => 'nullable|numeric',
        'description'           => 'nullable|string|max:1000',
    ]);

    $gym = Gym::find($validated['gym_id']);
    if (!$gym) {
        return back()->with('error', 'Invalid gym selection.');
    }

    $start = Carbon::parse($validated['starting_date']);
    $end   = Carbon::parse($validated['end_date']);

    // Check for overlapping bookings
    $overlapExists = Booking::where('gym_id', $validated['gym_id'])
        ->whereIn('booking_status', ['Pending', 'Approved'])
        ->where(function ($query) use ($start, $end) {
            $query->whereBetween('starting_date', [$start, $end])
                  ->orWhereBetween('end_date', [$start, $end])
                  ->orWhere(function ($query) use ($start, $end) {
                      $query->where('starting_date', '<=', $start)
                            ->where('end_date', '>=', $end);
                  });
        })
        ->exists();

    if ($overlapExists) {
        return back()->with('error', '❌ The selected date range is not available for this gym. Please choose another date.');
    }

    // Calculate totals
    $totalDays = $start->diffInDays($end) + 1;
    $totalPrice = $gym->price * $totalDays;
    $additionalTotal = 0;

    // Create booking with is_read default to false (unread)
    $booking = Booking::create([
        'user_id'         => auth()->check() ? auth()->id() : session('user_id'),
        'name'            => $validated['name'],
        'contact_number'  => $validated['contact_number'],
        'address'         => $validated['address'],
        'starting_date'   => $validated['starting_date'],
        'end_date'        => $validated['end_date'],
        'gym_id'          => $validated['gym_id'],
        'equipment_id'    => $validated['equipment_id'] ?? null,
        'total_days'      => $totalDays,
        'total_price'     => $totalPrice,
        'description'     => $validated['description'] ?? null,
        'booking_status'  => 'Pending',
        'is_read'         => false, // ✅ default unread
    ]);

    // Handle additional equipments
    if (!empty($validated['additional_equipments'])) {
        $equipments = json_decode($validated['additional_equipments'], true);
        if (is_array($equipments)) {
            foreach ($equipments as $item) {
                $itemTotal = isset($item['total']) ? floatval($item['total']) : 0;

                \App\Models\AdditionalEquipment::create([
                    'booking_id'     => $booking->booking_id,
                    'equipment_name' => $item['name'] ?? 'Unknown',
                    'quantity'       => $item['quantity'] ?? 0,
                    'price'          => $item['price'] ?? 0,
                ]);

                $additionalTotal += $itemTotal;
            }
        }
    }

    // Update totals
    $grandTotal = !empty($validated['final_total'])
        ? $validated['final_total']
        : ($totalPrice + $additionalTotal);

    $booking->update([
        'total_price'      => $grandTotal,
        'additional_total' => $grandTotal - $totalPrice,
    ]);

    return redirect()->back()->with('success', '✅ Booking submitted successfully!');
}


public function getBookedDates()
{
    $bookings = \App\Models\Booking::whereIn('booking_status', ['Pending', 'Approved'])
        ->select('starting_date', 'end_date')
        ->get();

    $disabledDates = [];

    foreach ($bookings as $booking) {
        $period = new \DatePeriod(
            new \DateTime($booking->starting_date),
            new \DateInterval('P1D'),
            (new \DateTime($booking->end_date))->modify('+1 day')
        );

        foreach ($period as $date) {
            $disabledDates[] = $date->format('Y-m-d');
        }
    }

    return response()->json(array_values(array_unique($disabledDates)));
}





    /**
     * Approve a booking.
     */public function approveBooking($id)
{
    $booking = Booking::find($id);
    if (!$booking) {
        return response()->json(['status' => 'error', 'message' => 'Booking not found.']);
    }

    $booking->update([
        'booking_status' => 'Approved',
        'date_approved'  => now(),
        'is_read' => false, // ✅ mark unread when approved
    ]);

    return response()->json(['status' => 'success', 'message' => 'Booking approved successfully.']);
}

public function completeBooking($id)
{
    $booking = Booking::find($id);
    if (!$booking) {
        return response()->json(['status' => 'error', 'message' => 'Booking not found.']);
    }

    $booking->update([
        'booking_status' => 'Completed',
        'date_completed' => now(),
        'is_read' => false, // ✅ mark unread when completed
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

    public function generateInvoice($id)
{
    $booking = Booking::with(['gym', 'additionalEquipments'])->findOrFail($id);

    $pdf = Pdf::loadView('pdf.invoice', compact('booking'))
              ->setPaper('A4', 'portrait');

    return $pdf->download('Invoice_Booking_'.$booking->booking_id.'.pdf');
}


public function downloadReport(Request $request)
{
    $status = $request->get('status');

    // ✅ Filter bookings by status if provided
    $bookingsQuery = \App\Models\Booking::with('gym')->orderBy('created_at', 'desc');
    if (!empty($status)) {
        $bookingsQuery->where('booking_status', $status);
    }

    $bookings = $bookingsQuery->get();

    // ✅ Recalculate summary values based on the filtered bookings
    $totalRevenue   = \App\Models\Booking::where('booking_status', 'Completed')->sum('total_price');
    $cancelledCount = \App\Models\Booking::where('booking_status', 'Cancelled')->count();
    $completedCount = \App\Models\Booking::where('booking_status', 'Completed')->count();
    $totalBookings  = $bookings->count();

    // ✅ Generate PDF (only for the filtered data)
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.reports', compact(
        'bookings',
        'totalRevenue',
        'cancelledCount',
        'completedCount',
        'totalBookings',
        'status' // optional: show current filter on the PDF header
    ))->setPaper('A4', 'landscape');

    return $pdf->download('Booking_Report_' . ($status ? $status . '_' : '') . now()->format('Y-m-d') . '.pdf');
}

}
