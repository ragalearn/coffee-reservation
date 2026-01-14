<x-app-layout>
    <div class="container mx-auto px-4 py-6">

        <h1 class="text-2xl font-bold mb-6">
            Riwayat Reservasi Saya
        </h1>

        <a href="{{ route('reservations.create') }}"
           class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + Buat Reservasi
        </a>

        <div class="overflow-x-auto">
            <table class="table-auto w-full border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-3 py-2">Tanggal</th>
                        <th class="border px-3 py-2">Waktu</th>
                        <th class="border px-3 py-2">Meja</th>
                        <th class="border px-3 py-2">Jumlah Orang</th>
                        <th class="border px-3 py-2">Status</th>
                        <th class="border px-3 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reservations as $reservation)
                        <tr class="text-center">
                            <td class="border px-2 py-1">
                                {{ $reservation->reservation_date }}
                            </td>
                            <td class="border px-2 py-1">
                                {{ $reservation->reservation_time }}
                            </td>
                            <td class="border px-2 py-1">
                                {{ $reservation->table->table_number }}
                            </td>
                            <td class="border px-2 py-1">
                                {{ $reservation->people_count }}
                            </td>
                            <td class="border px-2 py-1">
                                <span class="capitalize">
                                    {{ $reservation->status }}
                                </span>
                            </td>
                            <td class="border px-2 py-1">
                                @if ($reservation->status === 'pending')
                                    <form method="POST"
                                          action="{{ route('reservations.destroy', $reservation->id) }}"
                                          onsubmit="return confirm('Batalkan reservasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline">
                                            Batalkan
                                        </button>
                                    </form>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">
                                Belum ada reservasi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
