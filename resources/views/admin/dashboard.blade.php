@extends('layouts.app')

@section('content')
<style>
/* ================= ADMIN DASHBOARD FINAL POLISH ================= */
.admin-dashboard {
    display: flex;
    min-height: 100vh;
    background: #f6f6f6;
    font-family: 'Inter', sans-serif;
}

/* ===== MAIN ===== */
.main {
    flex: 1;
    padding: 32px 36px;
    background: #f6f6f6;
}

/* HEADER */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 28px;
}

.header h1 {
    font-size: 24px;
    font-weight: 700;
}

.user {
    display: flex;
    align-items: center;
    gap: 14px;
    color: #444;
}

.user .material-icons {
    font-size: 22px;
}

/* ===== SUMMARY ===== */
.summary {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 32px;
}

.card-summary {
    padding: 22px 24px;
    border-radius: 14px;
    box-shadow: 0 4px 12px rgba(0,0,0,.08);
    position: relative;
}

.card-summary p {
    font-size: 13px;
    font-weight: 600;
    opacity: 0.85;
}

.card-summary h3 {
    font-size: 34px;
    margin-top: 6px;
    font-weight: 700;
}

.card-summary .material-icons {
    position: absolute;
    right: 16px;
    bottom: 16px;
    font-size: 30px;
    opacity: 0.35;
}

.yellow { background:#f2b705; }
.olive  { background:#9a9a2e; color:#fff; }
.purple { background:#5e3bdb; color:#fff; }
.red    { background:#f44336; color:#fff; }

/* ===== CHART ===== */
.charts {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 22px;
    margin-bottom: 32px;
}

.card {
    background: #fff;
    border-radius: 14px;
    padding: 20px 22px;
    box-shadow: 0 4px 12px rgba(0,0,0,.06);
}

.card h3 {
    font-size: 16px;
    font-weight: 700;
}

/* BAR CHART */
.bar-chart {
    display: flex;
    align-items: flex-end;
    height: 220px;
    gap: 14px;
    margin-top: 18px;
}

.bar-group {
    flex: 1;
    text-align: center;
}

.bar {
    width: 14px;
    margin: 0 auto;
    border-radius: 6px;
}

.bar.indoor { background:#5e3bdb; }
.bar.outdoor { background:#4cc3d9; margin-top: 4px; }

.bar-label {
    font-size: 12px;
    color: #666;
    margin-top: 6px;
}

/* PIE */
.pie {
    width: 190px;
    height: 190px;
    border-radius: 50%;
    margin: 28px auto;
    position: relative;
}

.pie-center {
    position: absolute;
    inset: 0;
    margin: auto;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: #fff;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-weight: 700;
}

/* ===== BOTTOM ===== */
.bottom {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 22px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    font-size: 13px;
    color: #777;
    text-align: left;
    padding-bottom: 10px;
}

td {
    padding: 12px 0;
    border-bottom: 1px solid #eee;
    font-size: 14px;
}

/* RESPONSIVE */
@media(max-width:1024px){
    .summary { grid-template-columns: repeat(2,1fr); }
    .charts, .bottom { grid-template-columns: 1fr; }
}
</style>

<div class="admin-dashboard">

    {{-- 🔥 SIDEBAR DIPINDAH KE PARTIAL --}}
    @include('admin.partials.sidebar')

    <!-- MAIN -->
    <main class="main">

        <!-- HEADER -->
        <div class="header">
            <h1>Dashboard</h1>
            <div class="user">
                <span>Hi, Admin</span>
                <span class="material-icons">account_circle</span>
                <span class="material-icons">notifications</span>
            </div>
        </div>

        <!-- SUMMARY -->
        <section class="summary">
            <div class="card-summary yellow">
                <p>Total Reservation Today</p>
                <h3>{{ $todayReservations }}</h3>
                <span class="material-icons">calendar_today</span>
            </div>

            <div class="card-summary olive">
                <p>Pending Reservation</p>
                <h3>{{ $pending }}</h3>
                <span class="material-icons">hourglass_empty</span>
            </div>

            <div class="card-summary purple">
                <p>Confirmed Reservation</p>
                <h3>{{ $confirmed }}</h3>
                <span class="material-icons">check_circle</span>
            </div>

            <div class="card-summary red">
                <p>Rejected / Cancelled</p>
                <h3>{{ $rejected_combined }}</h3>
                <span class="material-icons">cancel</span>
            </div>
        </section>

        <!-- CHART -->
        <section class="charts">
            <div class="card">
                <h3>Reservations This Week</h3>
                <div class="bar-chart">
                    @foreach($weeklyData as $day)
                        <div class="bar-group">
                            <div class="bar indoor" style="height:{{ ($day['indoor']/$maxHeight)*100 }}%"></div>
                            <div class="bar outdoor" style="height:{{ ($day['outdoor']/$maxHeight)*100 }}%"></div>
                            <div class="bar-label">{{ $day['day'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <h3>Reservation Status</h3>
                <div class="pie" style="background:conic-gradient(
                    #5e3bdb 0 {{ $percConfirmed }}%,
                    #f2b705 {{ $percConfirmed }}% {{ $percConfirmed + $percPending }}%,
                    #f44336 {{ $percConfirmed + $percPending }}% 100%
                );">
                    <div class="pie-center">
                        {{ $percConfirmed }}%
                        <small>Confirmed</small>
                    </div>
                </div>
            </div>
        </section>

        <!-- BOTTOM -->
        <section class="bottom">
            <div class="card">
                <h3>Recent Reservation</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\Reservation::latest()->take(3)->get() as $r)
                        <tr>
                            <td>#{{ $r->id }}</td>
                            <td>{{ $r->user->name ?? '-' }}</td>
                            <td>{{ $r->reservation_date }}</td>
                            <td>{{ $r->reservation_time }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card">
                <h3>Information</h3>
                <p><strong>Opening Hours</strong><br>09.00 - 00.00</p>
                <p style="margin-top:12px;font-size:14px;color:#555">
                    Reservations are automatically cancelled if the customer is 15 minutes late.
                </p>
            </div>
        </section>

    </main>
</div>
@endsection
