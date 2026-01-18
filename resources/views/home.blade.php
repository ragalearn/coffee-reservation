<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Maiway</title>
    <link href="https://fonts.googleapis.com/css?family=Inter:wght@400;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Instrument+Sans:wght@500;700&display=swap" rel="stylesheet" />
    
    <style>
        /* 1. RESET & BASE */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            background-color: #B4C27C; 
            font-family: 'Instrument Sans', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            color: #000;
        }

        /* 2. SPLASH SCREEN */
        #splash-screen {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-color: #B4C27C;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.8s ease, visibility 0.8s;
        }
        .splash-logo { font-family: 'Inter', sans-serif; font-weight: 700; font-size: 42px; color: white; letter-spacing: 2px; }
        .fade-out { opacity: 0; visibility: hidden; }

        /* 3. HEADER & NAVBAR */
        header {
            width: 100%;
            background-color: #B4C27C;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        @media (min-width: 481px) {
            header { border-bottom: 1.5px solid rgba(0, 0, 0, 0.1); }
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        .brand-logo { 
            color: #000; font-family: 'Inter', sans-serif; font-weight: 700; font-size: 24px; text-decoration: none; 
        }

        /* Nav Menu (Desktop Only) */
        .nav-wrapper { display: flex; gap: 30px; }
        .nav-link { 
            text-decoration: none; 
            color: #000; 
            font-size: 16px; 
            font-weight: 500; 
            transition: 0.3s;
        }
        .nav-link:hover { opacity: 0.6; }
        .nav-link.active { font-weight: 700; border-bottom: 2px solid #000; }

        /* User & Dropdown Section */
        .user-section { position: relative; display: flex; align-items: center; gap: 10px; }
        .icon-svg { width: 22px; height: 22px; cursor: pointer; }
        .mobile-only { display: none; }

        /* Dropdown Styling */
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 40px;
            background-color: #FCF9F2;
            min-width: 130px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.1);
            border-radius: 12px;
            z-index: 1100;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
        }
        .dropdown-content.show { display: block; animation: fadeIn 0.2s ease; }
        .logout-btn {
            width: 100%; padding: 12px 15px; border: none; background: none;
            display: flex; align-items: center; gap: 10px; color: #ff4d4d;
            font-family: 'Instrument Sans', sans-serif; font-weight: 700;
            cursor: pointer; text-align: left; transition: 0.2s;
        }
        .logout-btn:hover { background-color: #f0ede4; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* 4. MAIN CONTENT */
        .main-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
            text-align: center;
        }

        .greeting-box h1 { 
            font-size: clamp(20px, 5vw, 32px); 
            font-weight: 500; 
            margin-bottom: 50px; 
            line-height: 1.3;
        }

        /* 5. IMAGE PREVIEW */
        .image-preview-wrap {
            position: relative;
            width: 100%;
            max-width: 450px;
            height: 320px;
            margin-bottom: 80px; 
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .img-card {
            position: absolute;
            background-size: cover;
            background-position: center;
            border-radius: 15px;
            box-shadow: 0px 10px 25px rgba(0,0,0,0.18);
        }
        .img-main { width: 190px; height: 260px; z-index: 30; background-image: url("{{ asset('assets/img/dashboard-main.png') }}"); }
        .img-left { width: 160px; height: 220px; left: 5%; z-index: 10; background-image: url("{{ asset('assets/img/dashboard-left.png') }}"); }
        .img-right { width: 160px; height: 220px; right: 5%; z-index: 10; background-image: url("{{ asset('assets/img/dashboard-right.png') }}"); }

        /* 6. BUTTON RESERVE NOW */
        .cta-reserve {
            background-color: #FCF9F2;
            color: #000;
            padding: 12px 12px 12px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            margin-top: 30px; 
        }
        .cta-reserve:hover {
            transform: translateY(-8px);
            box-shadow: 0px 12px 30px rgba(0,0,0,0.2);
            background-color: #ffffff;
        }
        .arrow-circle {
            background: #000;
            width: 38px; height: 38px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
        }
        .custom-arrow {
            width: 10px; height: 10px;
            border-top: 2.5px solid #fff;
            border-right: 2.5px solid #fff;
            transform: rotate(45deg);
            margin-left: -4px;
        }

        /* 7. RESPONSIVE MOBILE */
        @media (max-width: 480px) {
            header { border-bottom: none; }
            .nav-wrapper { display: none; } 
            .header-container {
                display: flex;
                justify-content: space-between; 
                padding: 15px 20px;
            }
            .brand-logo {
                position: absolute;
                left: 50%;
                transform: translateX(-50%);
                font-size: 22px;
                z-index: 1;
            }
            .mobile-only { display: block; z-index: 2; } 
            .user-section { z-index: 2; }
            .user-section span { display: none; } 

            .image-preview-wrap { max-width: 320px; height: 240px; margin-bottom: 100px; }
            .img-main { width: 140px; height: 190px; }
            .img-left { width: 115px; height: 160px; left: 0; }
            .img-right { width: 115px; height: 160px; right: 0; }
            .cta-reserve { width: 90%; justify-content: space-between; }
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
                <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
            </div>

            <a href="{{ route('home') }}" class="brand-logo">Maiway</a>
            
            <nav class="nav-wrapper">
                <a href="{{ route('home') }}" class="nav-link active">Home</a>
                <a href="{{ route('categories.index') }}" class="nav-link">Categories</a>
                <a href="{{ route('reservations.index') }}" class="nav-link">Reservation</a>
            </nav>

            <div class="user-section">
                <span>Hi, {{ Auth::user()->name }}</span>
                <div id="user-menu-trigger" style="cursor: pointer; display: flex; align-items: center;">
                    <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>

                <div id="logout-dropdown" class="dropdown-content">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="main-container">
        <section class="greeting-box">
            <h1>Welcome back, {{ Auth::user()->name }}!<br>Ready to reserve your favorite spot today?</h1>
        </section>

        <section class="image-preview-wrap">
            <div class="img-card img-left"></div>
            <div class="img-card img-right"></div>
            <div class="img-card img-main"></div>
        </section>

        <a href="{{ route('categories.index') }}" class="cta-reserve">
            Reserve Now
            <div class="arrow-circle">
                <div class="custom-arrow"></div>
            </div>
        </a>
    </div>

    <script>
        // Splash Screen Logic
        window.addEventListener('load', () => {
            setTimeout(() => {
                const splash = document.getElementById('splash-screen');
                splash.classList.add('fade-out');
            }, 1000); 
        });

        // Logout Dropdown Logic
        const trigger = document.getElementById('user-menu-trigger');
        const dropdown = document.getElementById('logout-dropdown');

        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.classList.toggle('show');
        });

        window.addEventListener('click', () => {
            if (dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        });
    </script>
</body>
</html>