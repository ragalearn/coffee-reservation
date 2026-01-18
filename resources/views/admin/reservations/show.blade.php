<x-app-layout>
    <div class="container mx-auto px-4 py-6">

        <h1 class="text-xl font-bold mb-4">Detail Reservasi</h1>

        <ul>
            <li><strong>Pelanggan:</strong> {{ $reservation->user->name }}</li>
            <li><strong>Email:</strong> {{ $reservation->user->email }}</li>
            <li><strong>Tanggal:</strong> {{ $reservation->reservation_date }}</li>
            <li><strong>Waktu:</strong> {{ $reservation->reservation_time }}</li>
            <li><strong>Seating Area:</strong> {{ $reservation->category->name }}</li>
            <li><strong>Jumlah Orang:</strong> {{ $reservation->people_count }}</li>
            <li><strong>Status:</strong> {{ ucfirst($reservation->status) }}</li>
        </ul>

        <a href="{{ route('admin.reservations.index') }}">
            ← Kembali
        </a>

    </div>
</x-app-layout>
