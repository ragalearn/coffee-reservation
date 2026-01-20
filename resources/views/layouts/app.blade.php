<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Coffee Reservation') }}</title>

    {{-- ==================================================== 
         TAMBAHAN: LOGO FAVICON
         (Pastikan file ada di public/assets/img/logo.png)
    ==================================================== --}}
    <link rel="icon" href="{{ asset('assets/img/logo.jpeg') }}" type="image/jpeg">
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.jpeg') }}" type="image/jpeg">

    <link href="https://fonts.googleapis.com/css?family=Inter:wght@300;400;500;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Instrument+Sans:wght@500;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="font-sans antialiased" style="margin: 0; padding: 0;">

    {{-- 
        LOGIKA REVISI (TETAP AMAN): 
        Navigasi hanya muncul untuk Guest atau Pelanggan.
        Admin tidak akan melihat navigasi ini.
    --}}
    @if(!auth()->check() || (auth()->check() && auth()->user()->role !== 'admin'))
        @include('layouts.navigation')
    @endif

    <main>
        {{-- Konten Dashboard --}}
        @yield('content')
    </main>

</body>
</html>