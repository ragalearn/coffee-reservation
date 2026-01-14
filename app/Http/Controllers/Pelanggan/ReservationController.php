<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Tampilkan daftar reservasi milik user login.
     */
    public function index()
    {
        $reservations = auth()->user()
            ->reservations()
            ->with('table')
            ->orderBy('reservation_date')
            ->orderBy('reservation_time')
            ->get();

        return view('pelanggan.reservations.index', compact('reservations'));
    }

    /**
     * Form buat reservasi.
     */
    public function create()
    {
        $tables = Table::where('status', 'available')->get();

        return view('pelanggan.reservations.create', compact('tables'));
    }

    /**
     * Simpan reservasi baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'table_id'         => 'required|exists:tables,id',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'people_count'     => 'required|integer|min:1',
        ]);

        // 1️⃣ Tolak tanggal lampau
        if (Carbon::parse($request->reservation_date)->isPast()) {
            return back()->withErrors([
                'reservation_date' => 'Tanggal reservasi tidak boleh di masa lalu'
            ])->withInput();
        }

        // 2️⃣ Jam operasional (09:00 - 22:00)
        $time = Carbon::parse($request->reservation_time);
        if ($time->hour < 9 || $time->hour >= 22) {
            return back()->withErrors([
                'reservation_time' => 'Reservasi hanya bisa antara jam 09:00 - 22:00'
            ])->withInput();
        }

        $table = Table::findOrFail($request->table_id);

        // 3️⃣ Validasi kapasitas meja
        if ($request->people_count > $table->capacity) {
            return back()->withErrors([
                'people_count' => 'Jumlah orang melebihi kapasitas meja'
            ])->withInput();
        }

        // 4️⃣ Cek double booking
        $conflict = Reservation::where('table_id', $table->id)
            ->where('reservation_date', $request->reservation_date)
            ->where('reservation_time', $request->reservation_time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($conflict) {
            return back()->withErrors([
                'reservation_time' => 'Meja sudah dipesan pada waktu tersebut'
            ])->withInput();
        }

        // 5️⃣ Simpan reservasi
        Reservation::create([
            'user_id'          => auth()->id(),
            'table_id'         => $table->id,
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $request->reservation_time,
            'people_count'     => $request->people_count,
            'status'           => 'pending',
        ]);

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Reservasi berhasil dibuat dan menunggu konfirmasi');
    }

    /**
     * Batalkan reservasi (authorization via Policy).
     */
    public function destroy(Reservation $reservation)
    {
        // 🔐 Authorization via ReservationPolicy
        $this->authorize('cancel', $reservation);

        $reservation->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Reservasi dibatalkan');
    }
}
