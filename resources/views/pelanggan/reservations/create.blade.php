<x-app-layout>
    <div class="container mx-auto px-4 py-6">

        <h1 class="text-xl font-bold mb-4">
            Buat Reservasi
        </h1>

        {{-- tampilkan error validasi --}}
        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('reservations.store') }}">
            @csrf

            <div class="mb-3">
                <label>Meja</label>
                <select name="table_id" required>
                    <option value="">-- Pilih Meja --</option>
                    @foreach ($tables as $table)
                        <option value="{{ $table->id }}">
                            Meja {{ $table->table_number }}
                            (Kapasitas {{ $table->capacity }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Tanggal Reservasi</label>
                <input type="date"
                       name="reservation_date"
                       required>
            </div>

            <div class="mb-3">
                <label>Waktu Reservasi</label>
                <input type="time"
                       name="reservation_time"
                       required>
            </div>

            <div class="mb-3">
                <label>Jumlah Orang</label>
                <input type="number"
                       name="people_count"
                       min="1"
                       required>
            </div>

            <button type="submit">
                Simpan Reservasi
            </button>
        </form>

    </div>
</x-app-layout>
