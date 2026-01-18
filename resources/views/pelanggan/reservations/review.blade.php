@extends('layouts.app')

@section('content')
<style>
    /* DESAIN ASLI KAMU TETAP DI SINI */
    .review-wrapper { background-color: #f8f9fa; min-height: 100vh; padding: 40px 20px; font-family: 'Instrument Sans', sans-serif; }
    .review-card { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 30px; box-shadow: 0px 10px 40px rgba(0, 0, 0, 0.05); padding: 40px; position: relative; }
    .header-review { text-align: center; margin-bottom: 30px; }
    .seating-preview { display: flex; align-items: center; gap: 15px; background-color: #fff; border: 1px solid #f0f0f0; border-radius: 20px; padding: 15px; margin-bottom: 30px; }
    .detail-item { display: flex; align-items: center; padding: 15px 0; border-bottom: 1px solid #f5f5f5; }
    .detail-icon { width: 35px; color: #728142; }
    .detail-label { flex: 1; font-size: 14px; color: #555; }
    .detail-value { font-size: 14px; font-weight: 700; color: #000; text-align: right; }
    .btn-submit-review { display: block; width: 100%; background-color: #728142; color: #fff; padding: 18px; border-radius: 50px; border: none; font-size: 16px; font-weight: 700; cursor: pointer; text-align: center; text-decoration: none; }
</style>

<div class="review-wrapper">
    <div class="review-card">
        <div class="header-review">
            <h1>Review Reservation</h1>
            <p>Please review your reservation before confirming.</p>
        </div>

        <div class="seating-preview">
            <div class="seating-img-box" style="width: 100px; height: 100px; border-radius: 15px; background-image: url('{{ asset("assets/img/v446_295.png") }}'); background-size: cover;"></div>
            <div class="seating-text">
                <h2>{{ $category->name }}</h2>
                <h3>Maiway Coffee</h3>
                <p>Comfortable & Air-Conditioned</p>
            </div>
        </div>

        <div class="details-list">
            <div class="detail-item">
                <span class="detail-icon">📅</span>
                <span class="detail-label">Reservation Date</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($reservation_date)->format('d M Y') }}, {{ $reservation_time }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-icon">👥</span>
                <span class="detail-label">Number of Guests</span>
                <span class="detail-value">{{ $people_count }} Persons</span>
            </div>
            <div class="detail-item">
                <span class="detail-icon">👤</span>
                <span class="detail-label">Customer Name</span>
                <span class="detail-value">{{ $customer_name }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-icon">📞</span>
                <span class="detail-label">Phone Number</span>
                <span class="detail-value">{{ $phone_number }}</span>
            </div>
        </div>

        {{-- FORM FINAL - Membawa semua data secara tersembunyi --}}
        <form action="{{ route('reservations.store') }}" method="POST">
            @csrf
            <input type="hidden" name="category_id" value="{{ $category_id }}">
            <input type="hidden" name="customer_name" value="{{ $customer_name }}">
            <input type="hidden" name="reservation_date" value="{{ $reservation_date }}">
            <input type="hidden" name="reservation_time" value="{{ $reservation_time }}">
            <input type="hidden" name="people_count" value="{{ $people_count }}">
            <input type="hidden" name="phone_number" value="{{ $phone_number }}">
            <input type="hidden" name="special_request" value="{{ $special_request }}">
            
            <button type="submit" class="btn-submit-review">Confirm Reservation</button>
        </form>
    </div>
</div>
@endsection 