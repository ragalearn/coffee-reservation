<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Maiway</title>
    <link href="https://fonts.googleapis.com/css?family=Inter:wght@400;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Instrument+Sans:wght@500;700&display=swap" rel="stylesheet" />
    
    <style>
        /* 1. RESET & BASE */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            background-color: #B4C27C; 
            font-family: 'Instrument Sans', sans-serif;
            min-height: 100vh;
            color: #000;
        }

        /* 2. SPLASH SCREEN (Konsisten dengan Home) */
        #splash-screen {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-color: #B4C27C;
            display: flex; justify-content: center; align-items: center;
            z-index: 9999; transition: opacity 0.8s ease, visibility 0.8s;
        }
        .splash-logo { font-family: 'Inter', sans-serif; font-weight: 700; font-size: 42px; color: white; letter-spacing: 2px; }
        .fade-out { opacity: 0; visibility: hidden; }

        /* 3. HEADER & NAVBAR */
        header { width: 100%; background-color: #B4C27C; position: sticky; top: 0; z-index: 1000; }
        @media (min-width: 481px) { header { border-bottom: 1.5px solid rgba(0, 0, 0, 0.1); } }

        .header-container {
            max-width: 1200px; margin: 0 auto; padding: 20px;
            display: flex; justify-content: space-between; align-items: center; position: relative;
        }

        .brand-logo { color: #000; font-family: 'Inter', sans-serif; font-weight: 700; font-size: 24px; text-decoration: none; }

        .nav-wrapper { display: flex; gap: 30px; }
        .nav-link { text-decoration: none; color: #000; font-size: 16px; font-weight: 500; transition: 0.3s; }
        .nav-link.active { font-weight: 700; border-bottom: 2px solid #000; }

        .user-section { display: flex; align-items: center; gap: 10px; }
        .icon-svg { width: 22px; height: 22px; stroke: black; stroke-width: 2; fill: none; }
        .mobile-only { display: none; }

        /* 4. MAIN CONTENT */
        .main-container {
            max-width: 1200px; margin: 0 auto; padding: 40px 20px;
            text-align: center;
        }

        .page-title {
            font-size: 24px; font-weight: 500; margin-bottom: 80px; line-height: 1.4;
        }

        /* 5. CATEGORY CARDS GRID */
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-top: 50px;
            align-items: start;
        }

        .category-card {
            background-color: #728142; /* Hijau Tua sesuai PNG */
            border-radius: 25px;
            padding: 80px 25px 30px 25px;
            position: relative;
            color: white;
            text-align: center;
            box-shadow: 0px 10px 30px rgba(0,0,0,0.15);
            transition: transform 0.3s ease;
        }

        .category-card:hover { transform: translateY(-10px); }

        /* Lingkaran Gambar Overlapping */
        .category-image {
            width: 130px; height: 130px;
            border-radius: 50%;
            background-color: #fff;
            position: absolute;
            top: -65px; left: 50%;
            transform: translateX(-50%);
            border: 5px solid #B4C27C;
            background-size: cover;
            background-position: center;
            box-shadow: 0px 5px 15px rgba(0,0,0,0.1);
        }

        .category-name { font-size: 22px; font-weight: 700; margin-bottom: 15px; display: block; }
        .category-desc { font-size: 14px; opacity: 0.9; line-height: 1.5; margin-bottom: 25px; min-height: 60px; }

        /* Badge Kapasitas */
        .capacity-badge {
            background-color: #B4C27C;
            color: #000;
            padding: 8px 15px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
            display: inline-block;
        }

        /* Tombol Plus di Kanan Bawah */
        .btn-add {
            position: absolute;
            bottom: 20px; right: 20px;
            width: 35px; height: 35px;
            background-color: #B4C27C;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            text-decoration: none; color: #000; font-size: 24px; font-weight: bold;
            box-shadow: 0px 3px 10px rgba(0,0,0,0.2);
        }

        /* 6. RESPONSIVE MOBILE */
        @media (max-width: 480px) {
            .nav-wrapper { display: none; }
            .mobile-only { display: block; }
            .user-section span { display: none; }
            
            .brand-logo { position: absolute; left: 50%; transform: translateX(-50%); }

            .page-title { font-size: 18px; margin-bottom: 100px; padding: 0 20px; }

            /* Stack Vertikal di Mobile sesuai permintaan kerapian */
            .categories-grid {
                grid-template-columns: 1fr;
                gap: 100px; /* Jarak lebih besar karena ada overlapping image */
                padding-bottom: 50px;
            }

            .category-card { max-width: 320px; margin: 0 auto; }
        }
    </style>
</head>
<body>

    <div id="splash-screen">
        <div class="splash-logo">Maiway</div>
    </div>

    <header>
        <div class="header-container">
            <div class="mobile-only">
                <svg class="icon-svg" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
            </div>

            <a href="{{ route('home') }}" class="brand-logo">Maiway</a>
            
            <nav class="nav-wrapper">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
                <a href="{{ route('admin.categories.index') }}" class="nav-link active">Categories</a>
                <a href="{{ route('reservations.index') }}" class="nav-link">Reservation</a>
            </nav>

            <div class="user-section">
                <span style="font-weight: 500;">Hi, {{ Auth::user()->name }}</span>
                <svg class="icon-svg" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
        </div>
    </header>

    <div class="main-container">
        <h1 class="page-title">Please choose your preferred<br>seating area</h1>

        <div class="categories-grid">
            <div class="category-card">
                <div class="category-image" style="background-image: url('{{ asset('assets/img/v446_329.png') }}')"></div>
                <span class="category-name">Outdoor</span>
                <p class="category-desc">Fresh air and natural scenery for a more relaxed dining experience.</p>
                <div class="capacity-badge">Capacity: 2–4 guests</div>
                <a href="{{ route('reservations.create', ['category' => 'outdoor']) }}" class="btn-add">+</a>
            </div>

            <div class="category-card">
                <div class="category-image" style="background-image: url('{{ asset('assets/img/v446_295.png') }}')"></div>
                <span class="category-name">Indoor Area</span>
                <p class="category-desc">Comfortable indoor seating with air conditioning, suitable for working and meetings.</p>
                <div class="capacity-badge">Capacity: 4–6 guests</div>
                <a href="{{ route('reservations.create', ['category' => 'indoor']) }}" class="btn-add">+</a>
            </div>

            <div class="category-card">
                <div class="category-image" style="background-image: url('{{ asset('assets/img/v446_316.png') }}')"></div>
                <span class="category-name">Semi Outdoor</span>
                <p class="category-desc">The best of both worlds, shaded but still enjoying the outside breeze.</p>
                <div class="capacity-badge">Capacity: 4–6 guests</div>
                <a href="{{ route('reservations.create', ['category' => 'semi-outdoor']) }}" class="btn-add">+</a>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('load', () => {
            setTimeout(() => {
                const splash = document.getElementById('splash-screen');
                splash.classList.add('fade-out');
            }, 1000); 
        });
    </script>
</body>
</html>