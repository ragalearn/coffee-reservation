@extends('layouts.app')

@section('content')

{{-- =========================================
   LOGIC PENENTU GAMBAR & DESKRIPSI
========================================= --}}
@php
    $gambarReview = 'indoor.jpeg';
    $deskripsiSingkat = 'Comfortable & Air-Conditioned';

    if ($category->id == 1) {
        $gambarReview = 'outdoor.jpeg';
        $deskripsiSingkat = 'Fresh Air & Nature View';
    } elseif ($category->id == 3) {
        $gambarReview = 'semi-outdoor.jpeg';
        $deskripsiSingkat = 'Shaded & Breezy Area';
    }
@endphp

<style>
/* ===============================
   RESET & HILANGKAN NAVBAR
=============================== */
nav, header, .min-h-screen > div:first-child {
    display: none !important;
}

/* ===============================
   WRAPPER & CARD
=============================== */
.review-wrapper {
    background-color: #f8f9fa;
    min-height: 100vh;
    padding: 40px 20px;
    font-family: 'Instrument Sans', sans-serif;
}

.review-card {
    max-width: 620px;
    margin: 0 auto;
    background: #ffffff;
    border-radius: 32px;
    box-shadow: 0px 12px 40px rgba(0,0,0,0.06);
    padding: 45px 40px;
}

/* ===============================
   HEADER
=============================== */
.header-review {
    text-align: center;
    margin-bottom: 35px;
}

.header-review h1 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 8px;
}

.header-review p {
    font-size: 14px;
    color: #8a8a8a;
}

/* ===============================
   SEATING PREVIEW
=============================== */
.seating-preview {
    display: flex;
    align-items: center;
    gap: 18px;
    padding: 18px;
    border-radius: 22px;
    border: 1px solid #f0f0f0;
    background: #fff;
    margin-bottom: 35px;
}

.seating-img-box {
    width: 90px;
    height: 90px;
    border-radius: 18px;
    background-size: cover;
    background-position: center;
    flex-shrink: 0;
}

.seating-text h2 {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 4px;
}

.seating-text h3 {
    font-size: 14px;
    font-weight: 600;
    color: #728142;
    margin-bottom: 4px;
}

.seating-text p {
    font-size: 12px;
    color: #999;
}

/* ===============================
   DETAILS LIST (INI KUNCI RAPINYA)
=============================== */
.details-list {
    margin-bottom: 35px;
}

.detail-item {
    display: flex;
    align-items: center;
    padding: 16px 0;
    border-bottom: 1px solid #f1f1f1;
}

.detail-icon {
    width: 34px;
    font-size: 18px;
    color: #6c7a3f;
}

.detail-label {
    flex: 1;
    font-size: 14px;
    color: #555;
}

.detail-value {
    font-size: 14px;
    font-weight: 700;
    color: #000;
    text-align: right;
}

/* ===============================
   BUTTON
=============================== */
.btn-submit-review {
    width: 100%;
    padding: 18px;
    border-radius: 50px;
    background-color: #7a8742;
    color: #fff;
    border: none;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
}
</style>

<div class="review-wrapper">
    <div class="review-card">

        <div class="header-review">
            <h1>Review Reservation</h1>
            <p>Please review your reservation before confirming.</p>
        </div>

        <div class="seating-preview">
            <div class="seating-img-box"
                 style="background-image: url('{{ asset("assets/img/" . $gambarReview) }}');">
            </div>
            <div class="seating-text">
                <h2>{{ $category->name }}</h2>
                <h3>Maiway Coffee</h3>
                <p>{{ $deskripsiSingkat }}</p>
            </div>
        </div>

        <div class="details-list">
            <div class="detail-item">
                <span class="detail-icon">📅</span>
                <span class="detail-label">Reservation Date</span>
                <span class="detail-value">
                    {{ \Carbon\Carbon::parse($reservation_date)->format('d M Y') }}, {{ $reservation_time }}
                </span>
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

            @if($special_request)
            <div class="detail-item">
                <span class="detail-icon">📝</span>
                <span class="detail-label">Special Request</span>
                <span class="detail-value" style="font-style: italic;">
                    "{{ $special_request }}"
                </span>
            </div>
            @endif
        </div>

        <form action="{{ route('reservations.store') }}" method="POST">
            @csrf
            <input type="hidden" name="category_id" value="{{ $category_id }}">
            <input type="hidden" name="reservation_date" value="{{ $reservation_date }}">
            <input type="hidden" name="reservation_time" value="{{ $reservation_time }}">
            <input type="hidden" name="people_count" value="{{ $people_count }}">
            <input type="hidden" name="phone_number" value="{{ $phone_number }}">
            <input type="hidden" name="special_request" value="{{ $special_request }}">

            <button type="submit" class="btn-submit-review">
                Confirm Reservation
            </button>
        </form>

    </div>
</div>

@endsection
