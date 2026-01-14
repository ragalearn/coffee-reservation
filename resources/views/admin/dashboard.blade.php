<x-app-layout>
    <div class="container py-4">
        <h1 class="mb-4">Dashboard Admin</h1>

        <div class="mb-4">
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Total User:</strong> {{ $totalUsers }}
                </li>
                <li class="list-group-item">
                    <strong>Total Reservasi:</strong> {{ $totalReservations }}
                </li>
                <li class="list-group-item">
                    <strong>Reservasi Hari Ini:</strong> {{ $todayReservations }}
                </li>
            </ul>
        </div>

        <h3>Status Reservasi</h3>
        <ul class="list-group">
            <li class="list-group-item">
                Pending: {{ $pending }}
            </li>
            <li class="list-group-item">
                Dikonfirmasi: {{ $confirmed }}
            </li>
            <li class="list-group-item">
                Ditolak: {{ $rejected }}
            </li>
            <li class="list-group-item">
                Dibatalkan: {{ $cancelled }}
            </li>
        </ul>
    </div>
</x-app-layout>
