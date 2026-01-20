<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Customer</th>
            <th>Seating Area</th>
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
