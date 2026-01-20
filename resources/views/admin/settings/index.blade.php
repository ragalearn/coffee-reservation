@extends('layouts.app')

@section('content')
<style>
.admin-dashboard {
    display: flex;
    min-height: 100vh;
    background: #f6f6f6;
    font-family: 'Inter', sans-serif;
}

.main {
    flex: 1;
    padding: 32px 36px;
}

.header {
    margin-bottom: 32px;
}

.header h1 {
    font-size: 24px;
    font-weight: 700;
}

.subtitle {
    color: #777;
    margin-top: 6px;
}

.settings-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 28px;
}

.settings-card {
    background: #fff;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 12px rgba(0,0,0,.08);
    display: flex;
    flex-direction: column;
}

.settings-card h3 {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 18px;
    margin-bottom: 8px;
}

.settings-card p {
    font-size: 14px;
    color: #666;
    margin-bottom: 20px;
}

.settings-card input {
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #ddd;
    margin-bottom: 14px;
}

.settings-card label {
    font-size: 14px;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.settings-card button {
    align-self: flex-end;
    background: #8b9b4a;
    color: #fff;
    border: none;
    padding: 10px 18px;
    border-radius: 999px;
    font-weight: 600;
    cursor: pointer;
}

.alert-success {
    margin-bottom: 24px;
    padding: 14px 18px;
    background: #e6f4ea;
    color: #256029;
    border-radius: 12px;
    font-weight: 600;
}
</style>

<div class="admin-dashboard">

    @include('admin.partials.sidebar')

    <main class="main">

        <div class="header">
            <h1>Settings</h1>
            <p class="subtitle">
                Manage account preferences, reservations settings, notifications, and system configurations.
            </p>
        </div>

        {{-- ✅ SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <section class="settings-grid">

            {{-- PROFILE --}}
            <form method="POST" action="{{ route('admin.settings.store') }}" class="settings-card">
                @csrf
                <h3>
                    <span class="material-icons">person</span>
                    Profile & Preferences
                </h3>
                <p>Update admin profile information and dashboard preferences</p>

                <input type="text"
                       name="admin_name"
                       value="{{ $settings['admin_name'] ?? 'Admin' }}"
                       placeholder="Admin Name">

                <button type="submit">Edit Profile</button>
            </form>

            {{-- NOTIFICATIONS --}}
            <form method="POST" action="{{ route('admin.settings.store') }}" class="settings-card">
                @csrf
                <h3>
                    <span class="material-icons">notifications</span>
                    Notifications
                </h3>
                <p>Manage system notifications for new reservations and alerts</p>

                <input type="text"
                       name="notification_email"
                       value="{{ $settings['notification_email'] ?? '' }}"
                       placeholder="Notification Email">

                <button type="submit">Settings</button>
            </form>

            {{-- RESERVATION SETTINGS --}}
            <form method="POST" action="{{ route('admin.settings.store') }}" class="settings-card">
                @csrf
                <h3>
                    <span class="material-icons">verified_user</span>
                    Reservation Settings
                </h3>
                <p>Configure reservation policies and auto-confirm rules</p>

                {{-- 🔥 WAJIB: hidden agar uncheck tersimpan --}}
                <input type="hidden" name="auto_confirm_reservation" value="0">

                <label>
                    <input type="checkbox"
                           name="auto_confirm_reservation"
                           value="1"
                           {{ ($settings['auto_confirm_reservation'] ?? '0') == '1' ? 'checked' : '' }}>
                    Auto Confirm Reservation
                </label>

                <input type="number"
                       name="max_guest_per_reservation"
                       value="{{ $settings['max_guest_per_reservation'] ?? 10 }}"
                       placeholder="Max Guest">

                <button type="submit">Settings</button>
            </form>

            {{-- OPENING HOURS --}}
            <form method="POST" action="{{ route('admin.settings.store') }}" class="settings-card">
                @csrf
                <h3>
                    <span class="material-icons">schedule</span>
                    Opening Hours
                </h3>
                <p>Set operating hours for reservations</p>

                <input type="text"
                       name="opening_hours"
                       value="{{ $settings['opening_hours'] ?? '09:00 - 00:00' }}"
                       placeholder="Opening Hours">

                <button type="submit">Update</button>
            </form>

        </section>

    </main>
</div>
@endsection
