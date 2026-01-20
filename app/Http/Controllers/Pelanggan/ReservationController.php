<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function index()
    {
        return redirect()->route('categories.index');
    }

    public function create(Request $request)
    {
        $categoryId = $request->query('category');
        $category = Category::findOrFail($categoryId);

        return view('pelanggan.reservations.create', compact('category'));
    }

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

        /* ===============================
           🔒 MAX GUEST VALIDATION
        =============================== */
        $maxGuest = DB::table('settings')
            ->where('key', 'max_guest_per_reservation')
            ->value('value') ?? 10;

        if ($validated['people_count'] > $maxGuest) {
            return back()->withErrors(
                'Jumlah tamu melebihi batas maksimal '.$maxGuest.' orang'
            );
        }

        /* ===============================
           ⏰ OPENING HOURS (FIX MIDNIGHT BUG)
        =============================== */
        $opening = DB::table('settings')
            ->where('key', 'opening_hours')
            ->value('value') ?? '09:00 - 00:00';

        [$open, $close] = array_map('trim', explode('-', $opening));

        $time = Carbon::parse($validated['reservation_time']);
        $openTime = Carbon::parse($open);
        $closeTime = Carbon::parse($close);

        // 🔥 FIX: jika tutup lewat tengah malam
        if ($closeTime->lessThanOrEqualTo($openTime)) {
            $closeTime->addDay();
        }

        if (! $time->between($openTime, $closeTime)) {
            return back()->withErrors(
                'Reservasi hanya tersedia pukul '.$opening
            );
        }

        /* ===============================
           🪑 SEATING AREA CAPACITY CHECK
        =============================== */
        $category = Category::findOrFail($validated['category_id']);

        $bookedPeople = Reservation::where('category_id', $category->id)
            ->whereDate('reservation_date', $validated['reservation_date'])
            ->where('reservation_time', $validated['reservation_time'])
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->sum('people_count');

        if ($bookedPeople + $validated['people_count'] > $category->max_capacity) {
            return back()->withErrors(
                'Seating area sudah penuh untuk waktu tersebut'
            );
        }

        return view('pelanggan.reservations.review', array_merge(
            $validated,
            ['category' => $category]
        ));
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

        /* ===============================
           🔒 MAX GUEST VALIDATION
        =============================== */
        $maxGuest = DB::table('settings')
            ->where('key', 'max_guest_per_reservation')
            ->value('value') ?? 10;

        if ($validated['people_count'] > $maxGuest) {
            return back()->withErrors(
                'Jumlah tamu melebihi batas maksimal '.$maxGuest.' orang'
            );
        }

        /* ===============================
           ⏰ OPENING HOURS (FIX MIDNIGHT BUG)
        =============================== */
        $opening = DB::table('settings')
            ->where('key', 'opening_hours')
            ->value('value') ?? '09:00 - 00:00';

        [$open, $close] = array_map('trim', explode('-', $opening));

        $time = Carbon::parse($validated['reservation_time']);
        $openTime = Carbon::parse($open);
        $closeTime = Carbon::parse($close);

        if ($closeTime->lessThanOrEqualTo($openTime)) {
            $closeTime->addDay();
        }

        if (! $time->between($openTime, $closeTime)) {
            return back()->withErrors(
                'Reservasi hanya tersedia pukul '.$opening
            );
        }

        /* ===============================
           🪑 SEATING AREA CAPACITY CHECK
        =============================== */
        $category = Category::findOrFail($validated['category_id']);

        $bookedPeople = Reservation::where('category_id', $category->id)
            ->whereDate('reservation_date', $validated['reservation_date'])
            ->where('reservation_time', $validated['reservation_time'])
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->sum('people_count');

        if ($bookedPeople + $validated['people_count'] > $category->max_capacity) {
            return back()->withErrors(
                'Seating area sudah penuh untuk waktu tersebut'
            );
        }

        /* ===============================
           ✅ AUTO CONFIRM
        =============================== */
        $autoConfirm = DB::table('settings')
            ->where('key', 'auto_confirm_reservation')
            ->value('value') ?? 0;

        $status = $autoConfirm == 1 ? 'confirmed' : 'pending';

        $reservation = Reservation::create([
            'user_id'          => auth()->id(),
            'category_id'      => $validated['category_id'],
            'reservation_date' => $validated['reservation_date'],
            'reservation_time' => $validated['reservation_time'],
            'people_count'     => $validated['people_count'],
            'phone_number'     => $validated['phone_number'],
            'special_request'  => $validated['special_request'],
            'status'           => $status,
        ]);

        return view('pelanggan.reservations.confirmed', compact('reservation'));
    }

    public function destroy(Reservation $reservation)
    {
        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        $reservation->update(['status' => 'cancelled']);

        return back()->with('success', 'Reservasi dibatalkan');
    }
}
