<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Coffee Reservation') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Inter:wght@300;400;500;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Instrument+Sans:wght@500;700&display=swap" rel="stylesheet" />
</head>
<body style="margin: 0; padding: 0;">

    @include('layouts.navigation')

    <main>
        @yield('content')
    </main>

</body>
</html>