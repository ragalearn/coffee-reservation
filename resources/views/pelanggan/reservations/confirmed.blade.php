@extends('layouts.app')

@section('content')
<style>
    /* 1. BASE LAYOUT */
    .confirmed-wrapper {
        background-color: #f8f9fa;
        min-height: 100vh;
        padding: 60px 20px;
        font-family: 'Instrument Sans', sans-serif;
    }

    /* 2. MAIN CARD (DESKTOP) */
    .confirmed-card {
        max-width: 600px;
        margin: 0 auto;
        background: #ffffff;
        border-radius: 30px;
        padding: 50px 40px;
        box-shadow: 0px 10px 40px rgba(0, 0, 0, 0.05);
        text-align: center;
    }

    /* 3. STATUS ICON & TEXT */
    .status-icon-box {
        width: 100px;
        height: 100px;
        background-color: #B4C27C; /* Hijau Maiway */
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px auto;
        box-shadow: 0px 8px 20px rgba(180, 194, 124, 0.3);
    }

    .status-icon-box svg {
        width: 50px;
        height: 50px;
        color: #ffffff;
    }

    .confirmed-title {
        color: #728142; /* Hijau Tua */
        font-family: 'Inter', sans-serif;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .confirmed-subtitle {
        color: #888;
        font-size: 15px;
        margin-bottom: 40px;
        line-height: 1.5;
    }

    /* 4. SEATING INFO CARD (HORIZONTAL) */
    .seating-card-confirmed {
        display: flex;
        align-items: center;
        gap: 15px;
        background: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 20px;
        padding: 15px;
        margin-bottom: 35px;
        text-align: left;
    }

    .seating-img-confirmed {
        width: 90px;
        height: 90px;
        border-radius: 15px;
        background-image: url('{{ asset("assets/img/v398_346.png") }}');
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .love-icon {
        position: absolute;
        top: 8px;
        right: 8px;
        color: #ff4d4d;
        font-size: 12px;
    }

    .seating-info-text h4 { font-size: 14px; color: #728142; margin-bottom: 4px; }
    .seating-info-text h2 { font-size: 18px; font-weight: 700; margin-bottom: 4px; }
    .seating-info-text p { font-size: 12px; color: #888; }

    /* 5. DETAILS LIST */
    .confirm-details-list {
        margin-bottom: 40px;
    }

    .confirm-detail-item {
        display: flex;
        align-items: center;
        padding: 18px 0;
        border-bottom: 1px solid #f5f5f5;
    }

    .confirm-detail-item:last-child { border-bottom: none; }

    .confirm-icon { width: 35px; color: #728142; font-size: 18px; text-align: left; }
    .confirm-label { flex: 1; text-align: left; font-size: 14px; color: #555; }
    .confirm-value { font-weight: 700; font-size: 14px; color: #000; text-align: right; }

    /* 6. ADDITIONAL INFO */
    .notice-text {
        font-size: 13px;
        color: #bbb;
        margin-bottom: 40px;
    }

    /* 7. ACTION BUTTON */
    .btn-back-home {
        display: block;
        width: 100%;
        background-color: #728142;
        color: #fff;
        padding: 18px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        font-size: 16px;
        transition: 0.3s;
        box-shadow: 0px 8px 15px rgba(114, 129, 66, 0.2);
    }

    .btn-back-home:hover { transform: translateY(-2px); filter: brightness(1.1); }

    /* 8. MOBILE RESPONSIVE */
    @media (max-width: 480px) {
        .confirmed-wrapper { background: #fff; padding: 20px; }
        .confirmed-card { box-shadow: none; padding: 20px 10px; }
        .confirmed-title { font-size: 26px; }
        .status-icon-box { width: 80px; height: 80px; }
        .status-icon-box svg { width: 40px; height: 40px; }
    }
</style>

<div class="confirmed-wrapper">
    <div class="confirmed-card">
        <div class="status-icon-box">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>

        <h1 class="confirmed-title">Reservation Confirmed!</h1>
        <p class="confirmed-subtitle">Your reservation at Maiway Coffee has been confirmed</p>

        <div class="seating-card-confirmed">
            <div class="seating-img-confirmed">
                <span class="love-icon">❤</span>
            </div>
            <div class="seating-info-text">
                <h4>Maiway Coffee</h4>
                <h2>{{ $reservation->category->name }}</h2>
                <p>Comfortable & Air-Conditioned</p>
            </div>
        </div>

        <div class="confirm-details-list">
            <div class="confirm-detail-item">
                <span class="confirm-icon">📅</span>
                <span class="confirm-label">Reservation Date</span>
                <span class="confirm-value">
                    {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d M Y') }} | {{ $reservation->reservation_time }}
                </span>
            </div>
            <div class="confirm-detail-item">
                <span class="confirm-icon">👥</span>
                <span class="confirm-label">Number of Guests</span>
                <span class="confirm-value">{{ $reservation->people_count }} Persons</span>
            </div>
            <div class="confirm-detail-item">
                <span class="confirm-icon">🪑</span>
                <span class="confirm-label">Seating Area</span>
                <span class="confirm-value">{{ $reservation->category->name }}</span>
            </div>
            <div class="confirm-detail-item">
                <span class="confirm-icon">👤</span>
                <span class="confirm-label">Customer Name</span>
                <span class="confirm-value">{{ auth()->user()->name }}</span>
            </div>
            <div class="confirm-detail-item">
                <span class="confirm-icon">📞</span>
                <span class="confirm-label">Phone Number</span>
                <span class="confirm-value">{{ $reservation->phone_number }}</span>
            </div>
        </div>

        <p class="notice-text">
            A confirmation message has been sent to your phone number
        </p>

        <a href="{{ route('home') }}" class="btn-back-home">Back to Home</a>
    </div>
</div>
@endsection