<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - Booking #{{ $booking->booking_id }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            color: maroon;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }
        .list, .additional {
            margin: 10px 0;
        }
        .list ul, .additional ul {
            list-style: none;
            padding: 0;
        }
        .list li, .additional li {
            padding: 6px 0;
            border-bottom: 1px dashed #ddd;
            display: flex;
            justify-content: space-between;
        }
        .summary {
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        .summary h4 {
            margin: 5px 0;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 11px;
            color: gray;
        }
        .highlight {
            color: maroon;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>LSSTI Basketball Gym</h2>
        <p>Booking Invoice</p>
        <small>Date Issued: {{ now()->format('F d, Y') }}</small>
    </div>

    <div class="section">
        <h3>Booking Information</h3>
        <p><strong>Package:</strong> {{ $booking->gym->package ?? 'N/A' }}</p>
        <p><strong>Customer:</strong> {{ $booking->name }}</p>
        <p><strong>Contact:</strong> {{ $booking->contact_number }}</p>
        <p><strong>Address:</strong> {{ $booking->address }}</p>
        <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($booking->starting_date)->format('F d, Y') }}</p>
        <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($booking->end_date)->format('F d, Y') }}</p>
    </div>

    <div class="section list">
        <h3>Default Equipment Included</h3>
        <ul>
            @foreach($booking->gym->equipment ?? [] as $equip)
                <li>
                    <span>{{ $equip->equipment }}</span>
                    <span>x{{ $equip->pivot->quantity ?? 1 }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="section additional">
        <h3>Additional Equipments</h3>
        <ul>
            @forelse($booking->additionalEquipments as $add)
                <li>
                    <span>{{ $add->equipment_name }}</span>
                    <span>x{{ $add->quantity }}</span>
                </li>
            @empty
                <li>No additional equipment.</li>
            @endforelse
        </ul>
    </div>

    <div class="summary">
        <h4>Day(s) Duration: <span class="highlight">{{ $booking->total_days }}</span></h4>
        <h4>Status: <span class="highlight">{{ $booking->booking_status }}</span></h4>
        <h4>Total Amount: <span class="highlight">₱{{ number_format($booking->total_price, 2) }}</span></h4>
    </div>

    <div class="footer">
        <p>Thank you for choosing LSSTI Basketball Gym!</p>
    </div>

</body>
</html>
