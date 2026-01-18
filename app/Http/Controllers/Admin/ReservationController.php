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
        // HAPUS AUTHORIZE AGAR TIDAK ERROR 403
        // $this->authorize('process', Reservation::class);

        if ($reservation->status !== 'pending') {
            return back()->withErrors('Reservasi sudah diproses');
        }

        $reservation->update(['status' => 'confirmed']);

        return back()->with('success', 'Reservasi berhasil dikonfirmasi');
    }

    public function reject(Reservation $reservation)
    {
        // HAPUS AUTHORIZE AGAR TIDAK ERROR 403
        // $this->authorize('process', Reservation::class);

        if ($reservation->status !== 'pending') {
            return back()->withErrors('Reservasi sudah diproses');
        }

        $reservation->update(['status' => 'rejected']);

        return back()->with('success', 'Reservasi berhasil ditolak');
    }
}