<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = auth()->user()
            ->reservations()
            ->with('category')
            ->orderBy('reservation_date', 'desc')
            ->get();

        return view('pelanggan.reservations.index', compact('reservations'));
    }

    public function create(Request $request)
    {
        $categoryId = $request->query('category');
        $category = Category::find($categoryId);

        return view('pelanggan.reservations.create', compact('category'));
    }

    // METHOD INI YANG TADI DILAPORKAN HILANG/ERROR
    public function review(Request $request)
    {
        $validated = $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'customer_name'    => 'required|string',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'people_count'     => 'required|integer|min:1',
            'phone_number'     => 'required|string',
            'special_request'  => 'nullable|string',
        ]);

        $category = Category::find($validated['category_id']);

        return view('pelanggan.reservations.review', array_merge($validated, [
            'category' => $category
        ]));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'people_count'     => 'required|integer|min:1',
            'phone_number'     => 'required|string',
            'special_request'  => 'nullable|string',
        ]);

        $reservation = Reservation::create([
            'user_id'          => auth()->id(),
            'category_id'      => $validated['category_id'],
            'reservation_date' => $validated['reservation_date'],
            'reservation_time' => $validated['reservation_time'],
            'people_count'     => $validated['people_count'],
            'phone_number'     => $validated['phone_number'],
            'special_request'  => $validated['special_request'],
            'status'           => 'pending',
        ]);

        return view('pelanggan.reservations.confirmed', compact('reservation'));
    }

    public function destroy(Reservation $reservation)
    {
        // Pastikan model Reservation memiliki relasi user
        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }
        
        $reservation->update(['status' => 'cancelled']);
        return back()->with('success', 'Reservasi dibatalkan');
    }
}