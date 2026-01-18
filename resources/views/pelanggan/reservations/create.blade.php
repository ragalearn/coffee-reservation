@extends('layouts.app')

@section('content')
<style>
    /* DESAIN ASLI */
    .reservation-page {
        background-color: #ffffff;
        min-height: 100vh;
        width: 100%;
        margin-top: -1.5rem;
        font-family: 'Instrument Sans', sans-serif;
    }

    .header-curve {
        background-color: #B4C27C;
        height: 240px;
        width: 100%;
        position: relative;
        border-bottom-left-radius: 50% 30px;
        border-bottom-right-radius: 50% 30px;
        display: flex;
        justify-content: center;
        z-index: 1;
    }

    .image-circle {
        width: 280px;
        height: 280px;
        background-color: #fff;
        background-image: url('{{ asset("assets/img/v447_409.png") }}');
        background-size: cover;
        background-position: center;
        border-radius: 50%;
        border: 8px solid #B4C27C;
        position: absolute;
        bottom: -100px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        z-index: 10;
    }

    .content-wrapper {
        max-width: 500px;
        margin: 120px auto 60px;
        padding: 0 20px;
        text-align: center;
    }

    .seating-title {
        font-family: 'Inter', sans-serif;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 40px;
        color: #000;
    }

    .form-flex {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .pill-input {
        width: 100%;
        padding: 16px 25px;
        border-radius: 50px;
        border: none;
        background-color: #E6EBCF;
        font-size: 15px;
        color: #000;
        outline: none;
    }

    .btn-confirm-now {
        background-color: #728142;
        color: #fff;
        padding: 18px 45px;
        border-radius: 50px;
        border: none;
        font-size: 17px;
        font-weight: 700;
        cursor: pointer;
        margin-top: 20px;
        align-self: center;
    }
</style>

<div class="reservation-page">
    <div class="header-curve">
        <div class="image-circle"></div>
    </div>

    <div class="content-wrapper">
        <h1 class="seating-title">
            {{ $category->name ?? 'Indoor Area' }}
        </h1>

        {{-- FORM KE HALAMAN REVIEW --}}
        <form action="{{ route('reservations.review') }}" method="POST" class="form-flex">
            @csrf

            <input type="hidden" name="category_id" value="{{ $category->id ?? '' }}">

            <input
                type="text"
                name="customer_name"
                class="pill-input"
                value="{{ auth()->user()->name }}"
                placeholder="Customer Name"
                required
            >

            <input
                type="date"
                name="reservation_date"
                class="pill-input"
                required
            >

            <input
                type="time"
                name="reservation_time"
                class="pill-input"
                required
            >

            <input
                type="number"
                name="people_count"
                class="pill-input"
                placeholder="Number of Guests"
                min="1"
                required
            >

            <input
                type="tel"
                name="phone_number"
                class="pill-input"
                placeholder="Phone Number"
                required
            >

            <input
                type="text"
                name="special_request"
                class="pill-input"
                placeholder="Special Request (Optional)"
            >

            <button type="submit" class="btn-confirm-now">
                Confirm Reservation
            </button>
        </form>
    </div>
</div>
@endsection
