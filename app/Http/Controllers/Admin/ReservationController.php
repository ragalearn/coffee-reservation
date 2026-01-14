<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of all reservations (with filter).
     */
    public function index(Request $request)
    {
        $query = Reservation::with(['user', 'table.category']);

        // 🔎 Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 📅 Filter tanggal
        if ($request->filled('date')) {
            $query->whereDate('reservation_date', $request->date);
        }

        $reservations = $query
            ->orderBy('reservation_date', 'desc')
            ->orderBy('reservation_time', 'desc')
            ->get();

        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Display detail reservation.
     */
    public function show(Reservation $reservation)
    {
        $reservation->load(['user', 'table.category']);

        return view('admin.reservations.show', compact('reservation'));
    }

    /**
     * Confirm a reservation.
     */
    public function confirm(Reservation $reservation)
    {
        // 🔐 Authorization via Policy (admin only)
        $this->authorize('process', Reservation::class);

        // Cegah proses ulang
        if ($reservation->status !== 'pending') {
            return back()->withErrors('Reservasi sudah diproses');
        }

        // Cegah double booking (confirmed only)
        $conflict = Reservation::where('table_id', $reservation->table_id)
            ->where('reservation_date', $reservation->reservation_date)
            ->where('reservation_time', $reservation->reservation_time)
            ->where('status', 'confirmed')
            ->exists();

        if ($conflict) {
            return back()->withErrors(
                'Tidak bisa konfirmasi, meja sudah dikonfirmasi di waktu tersebut'
            );
        }

        $reservation->update([
            'status' => 'confirmed'
        ]);

        return back()->with('success', 'Reservasi berhasil dikonfirmasi');
    }

    /**
     * Reject a reservation.
     */
    public function reject(Reservation $reservation)
    {
        // 🔐 Authorization via Policy (admin only)
        $this->authorize('process', Reservation::class);

        // Cegah proses ulang
        if ($reservation->status !== 'pending') {
            return back()->withErrors('Reservasi sudah diproses');
        }

        $reservation->update([
            'status' => 'rejected'
        ]);

        return back()->with('success', 'Reservasi berhasil ditolak');
    }
}
