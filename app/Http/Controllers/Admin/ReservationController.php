<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('reservation_date', $request->date);
        }

        $reservations = $query
            ->orderBy('reservation_date', 'desc')
            ->orderBy('reservation_time', 'desc')
            ->get();

        return view('admin.reservations.index', compact('reservations'));
    }

    public function show(Reservation $reservation)
    {
        $reservation->load('user');
        return view('admin.reservations.show', compact('reservation'));
    }

    public function confirm(Reservation $reservation)
    {
        $reservation->update(['status' => 'confirmed']);
        return back()->with('success', 'Reservasi dikonfirmasi');
    }

    public function reject(Reservation $reservation)
    {
        $reservation->update(['status' => 'rejected']);
        return back()->with('success', 'Reservasi ditolak');
    }

    public function cancel(Reservation $reservation)
    {
        $reservation->update(['status' => 'cancelled']);
        return back()->with('success', 'Reservasi dibatalkan');
    }

    // 🔥 DELETE FINAL
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return back()->with('success', 'Reservasi berhasil dihapus');
    }
}
