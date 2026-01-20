@extends('layouts.app')

@section('content')

{{-- =========================================
   LOGIC PENENTU GAMBAR & DESKRIPSI
========================================= --}}
@php
    $gambarConfirmed = 'indoor.jpeg';
    $deskripsiSingkat = 'Comfortable & Air-Conditioned';

    if ($reservation->category_id == 1) {
        $gambarConfirmed = 'outdoor.jpeg';
        $deskripsiSingkat = 'Fresh Air & Nature View';
    } elseif ($reservation->category_id == 3) {
        $gambarConfirmed = 'semi-outdoor.jpeg';
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
   WRAPPER & CARD (SAMA DENGAN REVIEW)
=============================== */
.confirmed-wrapper {
    background-color: #f8f9fa;
    min-height: 100vh;
    padding: 40px 20px;
    font-family: 'Instrument Sans', sans-serif;
}

.confirmed-card {
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
.header-confirm {
    text-align: center;
    margin-bottom: 35px;
}

.status-icon-box {
    width: 80px;
    height: 80px;
    background-color: #B4C27C;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    box-shadow: 0 5px 15px rgba(180,194,124,0.4);
}

.status-icon-box svg {
    width: 40px;
    height: 40px;
    color: #fff;
}

.header-confirm h1 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 8px;
    color: #728142;
}

.header-confirm p {
    font-size: 14px;
    color: #8a8a8a;
}

/* ===============================
   SEATING PREVIEW (IDENTIK)
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
   DETAILS LIST (IDENTIK REVIEW)
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
.btn-home {
    width: 100%;
    padding: 18px;
    border-radius: 50px;
    background-color: #7a8742;
    color: #fff;
    border: none;
    font-size: 16px;
    font-weight: 700;
    text-align: center;
    text-decoration: none;
    display: block;
}
</style>

<div class="confirmed-wrapper">
    <div class="confirmed-card">

        <div class="header-confirm">
            <div class="status-icon-box">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
            <h1>Reservation Confirmed!</h1>
            <p>Your booking has been successfully secured.</p>
        </div>

        <div class="seating-preview">
            <div class="seating-img-box"
                 style="background-image: url('{{ asset("assets/img/" . $gambarConfirmed) }}');">
            </div>
            <div class="seating-text">
                <h2>{{ $reservation->category->name }}</h2>
                <h3>Maiway Coffee</h3>
                <p>{{ $deskripsiSingkat }}</p>
            </div>
        </div>

        {{-- DETAIL IDENTIK DENGAN REVIEW --}}
        <div class="details-list">

            <div class="detail-item">
                <span class="detail-icon">📅</span>
                <span class="detail-label">Reservation Date</span>
                <span class="detail-value">
                    {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d M Y') }},
                    {{ $reservation->reservation_time }}
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-icon">👥</span>
                <span class="detail-label">Number of Guests</span>
                <span class="detail-value">
                    {{ $reservation->people_count }} Persons
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-icon">👤</span>
                <span class="detail-label">Customer Name</span>
                <span class="detail-value">
                    {{ $reservation->user->name }}
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-icon">📞</span>
                <span class="detail-label">Phone Number</span>
                <span class="detail-value">
                    {{ $reservation->phone_number }}
                </span>
            </div>

            @if($reservation->special_request)
            <div class="detail-item">
                <span class="detail-icon">📝</span>
                <span class="detail-label">Special Request</span>
                <span class="detail-value" style="font-style: italic;">
                    "{{ $reservation->special_request }}"
                </span>
            </div>
            @endif

        </div>

        <a href="{{ route('home') }}" class="btn-home">
            Back to Home
        </a>

    </div>
</div>

@endsection
