<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reservation;

class ReservationPolicy
{
    /**
     * Admin boleh melihat semua reservasi
     * Pelanggan hanya boleh melihat reservasi miliknya sendiri
     */
    public function view(User $user, Reservation $reservation): bool
    {
        return $user->role === 'admin'
            || $reservation->user_id === $user->id;
    }

    /**
     * Pelanggan hanya boleh membatalkan reservasi miliknya sendiri
     * dan hanya jika status masih pending
     */
    public function cancel(User $user, Reservation $reservation): bool
    {
        return $user->role === 'pelanggan'
            && $reservation->user_id === $user->id
            && $reservation->status === 'pending';
    }

    /**
     * Admin boleh memproses reservasi (confirm / reject)
     */
    public function process(User $user): bool
    {
        return $user->role === 'admin';
    }
}
