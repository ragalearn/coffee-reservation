@extends('layouts.app')

@section('content')
<style>
    /* ===============================
       1. RESET & HILANGKAN NAV BAWAAN
    =============================== */
    .min-h-screen > nav, nav.border-b, nav.bg-white, .min-h-screen > header { 
        display: none !important; 
    }

    body { background-color: #B4C27C; font-family: 'Instrument Sans', sans-serif; }

    /* ===============================
       2. HEADER CUSTOM
    =============================== */
    header.custom-header { 
        width: 100%; background-color: #B4C27C; position: sticky; top: 0; z-index: 1000; 
        border-bottom: 1.5px solid rgba(0, 0, 0, 0.1); display: block !important; 
    }
    .header-container { max-width: 1200px; margin: 0 auto; padding: 20px; display: flex; justify-content: space-between; align-items: center; }
    .brand-logo { color: #000; font-family: 'Inter', sans-serif; font-weight: 700; font-size: 24px; text-decoration: none; }
    .nav-wrapper { display: flex; gap: 30px; }
    .nav-link { text-decoration: none; color: #000; font-size: 16px; font-weight: 500; transition: 0.3s; position: relative; }
    .nav-link.active { font-weight: 700; }
    .nav-link.active::after { content: ''; display: block; width: 100%; height: 2px; background: black; position: absolute; bottom: -4px; left: 0; }
    .user-section { display: flex; align-items: center; gap: 10px; font-family: 'Inter', sans-serif; }

    /* ===============================
       3. MAIN CONTENT
    =============================== */
    .main-container { max-width: 1200px; margin: 0 auto; padding: 40px 20px; text-align: center; min-height: 80vh; }
    .page-title { font-size: 24px; font-weight: 500; margin-bottom: 80px; line-height: 1.4; }

    /* ===============================
       4. CATEGORY CARD STYLE
    =============================== */
    .categories-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; }
    
    .category-card {
        background-color: #728142;
        border-radius: 25px;
        /* Padding bawah dikurangi sedikit karena ada wrapper baru */
        padding: 80px 25px 30px; 
        position: relative;
        color: white;
        text-align: center;
        box-shadow: 0px 10px 30px rgba(0,0,0,0.15);
        transition: transform 0.3s ease;
        
        /* Flexbox agar footer selalu di bawah rapi */
        display: flex;
        flex-direction: column;
    }
    .category-card:hover { transform: translateY(-10px); }

    .category-image {
        width: 130px; height: 130px;
        border-radius: 50%;
        background-color: #fff;
        position: absolute;
        top: -65px; left: 50%; transform: translateX(-50%);
        border: 5px solid #B4C27C;
        background-size: cover; background-position: center;
    }

    .category-name { font-size: 22px; font-weight: 700; margin-bottom: 15px; }
    .category-desc { font-size: 14px; opacity: 0.9; margin-bottom: 25px; min-height: 60px; }

    /* --- WRAPPER BAWAH (PENYELAMAT PRESISI) --- */
    .card-footer-row {
        position: relative;
        display: flex;
        justify-content: center; /* Badge di tengah */
        align-items: center;     /* Tombol dan Badge sejajar vertikal (tengah) */
        width: 100%;
        margin-top: auto;        /* Dorong ke paling bawah */
    }

    .capacity-badge {
        background-color: #B4C27C;
        color: #000;
        padding: 8px 18px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        display: inline-block;
        font-family: 'Inter', sans-serif;
    }

    .btn-add {
        /* Posisi absolute relatif terhadap .card-footer-row */
        position: absolute; 
        right: 0; /* Tempel di kanan lurus */
        
        width: 35px; height: 35px;
        background-color: #B4C27C;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        text-decoration: none; color: #000;
        font-size: 24px; font-weight: bold;
        box-shadow: 0px 3px 10px rgba(0,0,0,0.2);
        transition: transform 0.2s;
    }
    .btn-add:hover { transform: scale(1.1); }

    /* RESPONSIVE */
    @media (max-width: 480px) {
        .nav-wrapper, .user-section span { display: none; }
        .categories-grid { grid-template-columns: 1fr; gap: 100px; }
    }
</style>

<header class="custom-header">
    <div class="header-container">
        <a href="{{ route('home') }}" class="brand-logo">Maiway</a>
        <nav class="nav-wrapper">
            <a href="{{ route('home') }}" class="nav-link">Home</a>
            <a href="{{ route('categories.index') }}" class="nav-link active">Categories</a>
            <a href="{{ route('reservations.index') }}" class="nav-link">Reservation</a>
        </nav>
        <div class="user-section">
            <span>Hi, {{ Auth::user()->name }}</span>
        </div>
    </div>
</header>

<div class="main-container">
    <h1 class="page-title">Please choose your preferred<br>seating area</h1>

    <div class="categories-grid">
        @foreach($categories as $category)
        <div class="category-card">
            <div class="category-image" 
                 style="background-image:url('{{ asset('storage/'.$category->image) }}')"></div>

            <div class="category-name">{{ $category->name }}</div>
            <p class="category-desc">{{ $category->description }}</p>

            <div class="card-footer-row">
                <div class="capacity-badge">
                    Capacity: {{ $category->min_capacity }}–{{ $category->max_capacity }} guests
                </div>

                <a href="{{ route('reservations.create', ['category' => $category->id]) }}" 
                   class="btn-add">+</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection