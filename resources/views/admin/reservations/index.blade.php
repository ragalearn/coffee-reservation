@extends('layouts.app')

@section('content')
<style>
.admin-dashboard {
    display: flex;
    min-height: 100vh;
    background: #f6f6f6;
    font-family: 'Inter', sans-serif;
}

.main {
    flex: 1;
    padding: 32px 36px;
}

.header h1 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 20px;
}

.card {
    background: #fff;
    border-radius: 14px;
    padding: 22px;
    box-shadow: 0 4px 12px rgba(0,0,0,.06);
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    font-size: 13px;
    color: #777;
    text-align: left;
    padding-bottom: 12px;
}

td {
    padding: 14px 0;
    border-bottom: 1px solid #eee;
    font-size: 14px;
}

.status {
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

.pending { background:#fff3cd; color:#856404; }
.confirmed { background:#d4edda; color:#155724; }
.rejected { background:#f8d7da; color:#721c24; }
.cancelled { background:#e2e3e5; color:#383d41; }

.actions {
    display: flex;
    gap: 8px;
}

.btn {
    border: none;
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 12px;
    cursor: pointer;
    font-weight: 600;
}

.btn-confirm { background:#28a745; color:#fff; }
.btn-reject { background:#dc3545; color:#fff; }
.btn-cancel { background:#6c757d; color:#fff; }
.btn-delete { background:#343a40; color:#fff; }
</style>

<div class="admin-dashboard">
    @include('admin.partials.sidebar')

    <main class="main">
        <div class="header">
            <h1>Reservations</h1>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $reservation)
                    <tr>
                        <td>#{{ $reservation->id }}</td>
                        <td>{{ $reservation->user->name ?? '-' }}</td>
                        <td>{{ $reservation->reservation_date }}</td>
                        <td>{{ $reservation->reservation_time }}</td>
                        <td>
                            <span class="status {{ $reservation->status }}">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="actions">

                                @if($reservation->status === 'pending')
                                    <form method="POST" action="{{ route('admin.reservations.confirm', $reservation) }}">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-confirm">Confirm</button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.reservations.reject', $reservation) }}">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-reject">Reject</button>
                                    </form>
                                @endif

                                @if($reservation->status === 'confirmed')
                                    <form method="POST" action="{{ route('admin.reservations.cancel', $reservation) }}">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-cancel">Cancel</button>
                                    </form>
                                @endif

                                {{-- 🔥 DELETE --}}
                                <form method="POST"
                                      action="{{ route('admin.reservations.destroy', $reservation) }}"
                                      onsubmit="return confirm('Yakin ingin menghapus reservasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-delete">Delete</button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </main>
</div>
@endsection
