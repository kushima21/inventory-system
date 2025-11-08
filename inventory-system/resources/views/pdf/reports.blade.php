<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Reports</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; color: #5a0000; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #999;
            padding: 6px;
            text-align: center;
        }
        th {
            background: #5a0000;
            color: white;
        }
        .summary {
            margin-top: 20px;
            border: 1px solid #aaa;
            padding: 10px;
        }
    </style>
</head>
<body>
    <h2>📊 Booking Report Summary</h2>

    <div class="summary">
        <p><strong>Total Revenue:</strong> ₱{{ number_format($totalRevenue, 2) }}</p>
        <p><strong>Total Bookings:</strong> {{ $totalBookings }}</p>
        <p><strong>Completed:</strong> {{ $completedCount }}</p>
        <p><strong>Cancelled:</strong> {{ $cancelledCount }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Contact Number</th>
                <th>Package</th>
                <th>Date Requested</th>
                <th>Day(s)</th>
                <th>Total Price</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @forelse($bookings as $booking)
            <tr>
                <td>{{ $booking->name }}</td>
                <td>{{ $booking->contact_number }}</td>
                <td>{{ $booking->gym->package ?? 'N/A' }}</td>
                <td>{{ \Carbon\Carbon::parse($booking->created_at)->format('Y-m-d') }}</td>
                <td>{{ $booking->total_days }}</td>
                <td>₱{{ number_format($booking->total_price, 2) }}</td>
                <td>{{ $booking->booking_status }}</td>
            </tr>
        @empty
            <tr><td colspan="7">No data available</td></tr>
        @endforelse
        </tbody>
    </table>

    <p style="text-align:center; margin-top: 40px;">Generated on {{ now()->format('F d, Y - h:i A') }}</p>
</body>
</html>
