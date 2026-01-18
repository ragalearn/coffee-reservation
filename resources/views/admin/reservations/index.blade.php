<x-app-layout>
    <div class="container mx-auto px-4 py-6">

        <h1 class="text-xl font-bold mb-4">Data Reservasi</h1>

        {{-- FILTER --}}
        <form method="GET" class="mb-4">
            <select name="status">
                <option value="">-- Semua Status --</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>

            <input type="date" name="date" value="{{ request('date') }}">

            <button type="submit">Filter</button>
        </form>

        <table border="1" cellpadding="5" width="100%">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Pelanggan</th>
                    <th>Seating Area</th>
                    <th>Jumlah Orang</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->reservation_date }}</td>
                        <td>{{ $reservation->reservation_time }}</td>
                        <td>{{ $reservation->user->name }}</td>
                        <td>{{ $reservation->category->name }}</td>
                        <td>{{ $reservation->people_count }}</td>
                        <td>{{ ucfirst($reservation->status) }}</td>
                        <td>
                            <a href="{{ route('admin.reservations.show', $reservation) }}">
                                Detail
                            </a>

                            {{-- 🔐 AKSI ADMIN --}}
                            @can('process', App\Models\Reservation::class)
                                @if ($reservation->status === 'pending')
                                    <form method="POST"
                                          action="{{ route('admin.reservations.confirm', $reservation) }}"
                                          style="display:inline">
                                        @csrf
                                        @method('PATCH')
                                        <button>Confirm</button>
                                    </form>

                                    <form method="POST"
                                          action="{{ route('admin.reservations.reject', $reservation) }}"
                                          style="display:inline">
                                        @csrf
                                        @method('PATCH')
                                        <button>Reject</button>
                                    </form>
                                @endif
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center">
                            Tidak ada data reservasi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</x-app-layout>
