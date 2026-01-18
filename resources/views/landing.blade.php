<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Maiway</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Instrument+Sans:wght@500;700&display=swap" rel="stylesheet" />
    <style>
        /* RESET & BASE */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body, html { width: 100%; height: 100%; font-family: 'Inter', sans-serif; background: #fff; overflow-x: hidden; }

        /* ANIMASI */
        @keyframes vPop {
            0% { transform: scale(0.8); opacity: 0; }
            70% { transform: scale(1.05); }
            100% { transform: scale(1); opacity: 1; }
        }

        @keyframes vSlideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* STEP 1: SPLASH SCREEN */
        #step1 {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: #b5c37c; display: flex; flex-direction: column;
            justify-content: center; align-items: center; z-index: 9999;
            transition: opacity 0.8s ease-in-out;
        }
        .s1-img { width: 85%; max-width: 594px; height: auto; animation: vPop 1s ease-out; }
        .s1-txt { color: #fff; font-size: clamp(28px, 6vw, 48px); font-weight: 500; margin-top: 20px; text-align: center; }

        /* STEP 2: LANDING CONTENT */
        #step2 {
            display: none; opacity: 0; transition: opacity 0.8s ease-in-out;
            min-height: 100vh; width: 100%;
            flex-direction: column; align-items: center; justify-content: center;
            padding: 40px 20px;
        }

        .v-container-img {
            position: relative;
            width: 100%;
            max-width: 533px;
            aspect-ratio: 533 / 538;
            display: flex;
            justify-content: center;
            animation: vPop 1.2s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }

        .v-shadow {
            position: absolute;
            width: 89.5%;
            height: auto;
            aspect-ratio: 477 / 538;
            background: #D9D9D9;
            border-radius: 50%;
            filter: blur(10px);
            z-index: 1;
            right: 0;
        }

        .v-photo {
            position: absolute;
            width: 88.3%;
            height: auto;
            aspect-ratio: 471 / 493;
            border-radius: 50%;
            z-index: 2;
            left: 0;
            top: 23px;
            object-fit: cover;
        }

        .v-title {
            max-width: 486px;
            text-align: center;
            color: #000;
            font-size: clamp(22px, 5vw, 36px);
            font-weight: 500;
            margin: 40px 0;
            line-height: 1.2;
            animation: vSlideUp 1s ease-out 0.3s both;
        }

        /* --- PERUBAHAN TOMBOL: WARNA TETAP B5C37C --- */
        .v-btn-link { 
            text-decoration: none; 
            animation: vSlideUp 1s ease-out 0.6s both;
            display: inline-block;
        }

        .v-btn {
            background-color: #B5C37C; /* Warna Hijau Sesuai Permintaan */
            color: #fff; /* Teks Putih agar kontras dengan hijau */
            padding: 12px 12px 12px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 18px;
            font-family: 'Instrument Sans', sans-serif;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0px 4px 15px rgba(181, 195, 124, 0.3);
            transition: all 0.3s ease;
            height: auto; /* Reset height lama */
        }

        .v-btn:hover {
            transform: translateY(-8px);
            box-shadow: 0px 12px 30px rgba(181, 195, 124, 0.5);
            filter: brightness(1.05); /* Sedikit lebih terang saat hover */
        }

        .arrow-circle {
            background: #000; /* Lingkaran tetap Hitam agar ikon panah menonjol */
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
        /* --------------------------------------- */

        @media (max-width: 480px) {
            #step2 { padding: 20px 10px; justify-content: flex-start; }
            .v-container-img { max-width: 300px; margin-top: 20px; }
            .v-title { margin: 30px 0; }
            .v-btn { width: 90vw; justify-content: space-between; }
        }
    </style>
</head>
<body>

    <div id="step1">
        <img src="{{ asset('assets/img/step1-building.png') }}" class="s1-img">
        <p class="s1-txt">Reservasi Maiway</p>
    </div>

    <div id="step2">
        <div class="v-container-img">
            <img src="{{ asset('assets/img/step2-shadow.png') }}" class="v-shadow">
            <img src="{{ asset('assets/img/step2-photo.png') }}" class="v-photo">
        </div>

        <h1 class="v-title">Reserve Your Seat, Enjoy the Moment Book your table in advance and experience the perfect blend of coffee, comfort, and atmosphere.</h1>

        <a href="{{ route('login') }}" class="v-btn-link">
            <div class="v-btn">
                <span class="v-btn-text">Get Started</span>
                <div class="arrow-circle">
                    <div class="custom-arrow"></div>
                </div>
            </div>
        </a>
    </div>

    <script>
        setTimeout(function() {
            const s1 = document.getElementById('step1');
            const s2 = document.getElementById('step2');

            s1.style.opacity = '0';
            setTimeout(function() {
                s1.style.display = 'none';
                s2.style.display = 'flex';
                setTimeout(() => { s2.style.opacity = '1'; }, 50);
            }, 800);
        }, 2000);
    </script>
</body>
</html> 