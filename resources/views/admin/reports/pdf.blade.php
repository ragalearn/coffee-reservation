<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #ddd; padding:8px; }
        th { background:#f2f2f2; }
    </style>
</head>
<body>

<h2>Reservation Report</h2>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Customer</th>
            <th>Area</th>
            <th>Guests</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reservations as $r)
        <tr>
            <td>{{ $r->reservation_date }}</td>
            <td>{{ $r->user->name }}</td>
            <td>{{ $r->category->name }}</td>
            <td>{{ $r->people_count }}</td>
            <td>{{ ucfirst($r->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
