@extends('layouts.app')

@section('content')
<div class="admin-dashboard">
    @include('admin.partials.sidebar')

    <main class="main">
        <div class="header">
            <h1>Reservation Detail</h1>
        </div>

        <div class="card">
            <ul>
                <li><strong>Customer:</strong> {{ $reservation->user->name }}</li>
                <li><strong>Email:</strong> {{ $reservation->user->email }}</li>
                <li><strong>Date:</strong> {{ $reservation->reservation_date }}</li>
                <li><strong>Time:</strong> {{ $reservation->reservation_time }}</li>
                <li><strong>Category:</strong> {{ $reservation->category->name }}</li>
                <li><strong>People:</strong> {{ $reservation->people_count }}</li>
                <li><strong>Status:</strong> {{ ucfirst($reservation->status) }}</li>
            </ul>

            <br>
            <a href="{{ route('admin.reservations.index') }}">← Back</a>
        </div>
    </main>
</div>
@endsection
