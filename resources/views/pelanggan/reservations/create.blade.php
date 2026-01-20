@extends('layouts.app')

@section('content')

{{-- LOGIC GAMBAR OTOMATIS --}}
@php
    $gambarPilihan = 'indoor.jpeg'; 
    if(isset($category)) {
        if($category->id == 1) $gambarPilihan = 'outdoor.jpeg';
        elseif($category->id == 2) $gambarPilihan = 'indoor.jpeg';
        elseif($category->id == 3) $gambarPilihan = 'semi-outdoor.jpeg';
    }
@endphp

<style>
    /* HILANGKAN NAV BAWAAN */
    nav, .min-h-screen > div:first-child, .min-h-screen > header { display: none !important; }
    
    * { box-sizing: border-box; }
    .reservation-page { background-color: #ffffff; min-height: 100vh; width: 100%; font-family: 'Instrument Sans', sans-serif; overflow-x: hidden; position: relative; }
    
    .header-curve { background-color: #B4C27C; height: 240px; width: 100%; position: relative; border-bottom-left-radius: 50% 30px; border-bottom-right-radius: 50% 30px; z-index: 1; }
    
    .image-circle {
        width: 280px; height: 280px; background-color: #fff;
        /* GAMBAR DINAMIS */
        background-image: url('{{ asset("assets/img/" . $gambarPilihan) }}');
        background-size: cover; background-position: center; border-radius: 50%; border: 8px solid #B4C27C;
        position: absolute; bottom: -100px; left: 50%; transform: translateX(-50%);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1); z-index: 10;
    }

    .content-wrapper { width: 100%; max-width: 500px; margin: 120px auto 60px; padding: 0 20px; text-align: center; position: relative; z-index: 5; }
    .seating-title { font-family: 'Inter', sans-serif; font-size: 32px; font-weight: 700; margin-bottom: 40px; color: #000; line-height: 1.2; }
    .form-flex { display: flex; flex-direction: column; gap: 15px; width: 100%; }
    .pill-input { width: 100%; padding: 16px 25px; border-radius: 50px; border: none; background-color: #E6EBCF; font-size: 15px; color: #000; outline: none; transition: all 0.3s ease; }
    .pill-input:focus { background-color: #dce2c0; box-shadow: 0 0 0 2px rgba(180, 194, 124, 0.5); }
    .btn-confirm-now { background-color: #728142; color: #fff; padding: 18px 45px; border-radius: 50px; border: none; font-size: 17px; font-weight: 700; cursor: pointer; margin-top: 20px; align-self: center; transition: transform 0.2s; }
    .btn-confirm-now:hover { transform: translateY(-2px); background-color: #63703a; }

    @media (max-width: 480px) { .header-curve { height: 160px; } .image-circle { width: 160px; height: 160px; bottom: -60px; border-width: 5px; } .content-wrapper { margin: 80px auto 40px; } .seating-title { font-size: 24px; } .pill-input { padding: 14px 20px; font-size: 14px; } .btn-confirm-now { width: 100%; margin-top: 10px; } }
</style>

<div class="reservation-page">
    <div class="header-curve">
        <div class="image-circle"></div>
    </div>
    <div class="content-wrapper">
        <h1 class="seating-title">{{ $category->name ?? 'Indoor Area' }}</h1>
        <form action="{{ route('reservations.review') }}" method="POST" class="form-flex">
            @csrf
            <input type="hidden" name="category_id" value="{{ $category->id ?? '' }}">
            <input type="text" name="customer_name" class="pill-input" value="{{ auth()->user()->name }}" placeholder="Customer Name" required>
            <input type="date" name="reservation_date" class="pill-input" required>
            <input type="time" name="reservation_time" class="pill-input" required>
            <input type="number" name="people_count" class="pill-input" placeholder="Number of Guests" min="1" required>
            <input type="tel" name="phone_number" class="pill-input" placeholder="Phone Number" required>
            <input type="text" name="special_request" class="pill-input" placeholder="Special Request (Optional)">
            <button type="submit" class="btn-confirm-now">Confirm Reservation</button>
        </form>
    </div>
</div>
@endsection