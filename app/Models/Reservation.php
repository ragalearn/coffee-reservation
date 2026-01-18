<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'reservation_date',
        'reservation_time',
        'people_count',
        'phone_number',   
        'special_request',
        'status',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Category (PENTING: Agar {{ $reservation->category->name }} tidak error)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}