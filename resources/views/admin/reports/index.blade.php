@extends('layouts.app')

@section('content')
<style>
/* ================= ADMIN REPORTS (FULLY CONSISTENT & FUNCTIONAL) ================= */

.admin-dashboard {
    display: flex;
    min-height: 100vh;
    background: #f6f6f6;
    font-family: 'Inter', sans-serif;
}

/* ===== MAIN (SAMA DENGAN DASHBOARD) ===== */
.main {
    flex: 1;
    padding: 32px 36px;
    background: #f6f6f6;
}

/* ===== HEADER ===== */
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

/* ===== ACTIONS ===== */
.header-actions {
    display: flex;
    gap: 12px;
}

.export-btn {
    background:#8b9b4a;
    color:#fff;
    padding:10px 18px;
    border-radius:10px;
    font-weight:600;
    text-decoration:none;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* ===== FILTER ===== */
.filter-form {
    display: flex;
    gap: 14px;
    margin-bottom: 28px;
}

.filter-form label {
    font-size: 13px;
    font-weight: 600;
}

.filter-form input,
.filter-form select {
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #ddd;
}

/* ===== SUMMARY (SAMA DENGAN DASHBOARD) ===== */
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
    color: #fff;
}

.card-summary p {
    font-size: 13px;
    font-weight: 600;
    opacity: 0.9;
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
.olive  { background:#9a9a2e; }
.purple { background:#5e3bdb; }
.red    { background:#f44336; }

/* ===== CARD ===== */
.card {
    background: #fff;
    border-radius: 14px;
    padding: 22px;
    box-shadow: 0 4px 12px rgba(0,0,0,.06);
    margin-bottom: 32px;
}

.card h3 {
    font-size: 16px;
    font-weight: 700;
}

/* ===== BAR CHART ===== */
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
    width: 100%;
    background:#5e3bdb;
    border-radius: 8px 8px 0 0;
}

.bar-label {
    font-size: 12px;
    color: #666;
    margin-top: 6px;
}

/* ===== TABLE ===== */
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

.status {
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

.confirmed { background:#d4edda; color:#155724; }
.pending { background:#fff3cd; color:#856404; }
.cancelled,
.rejected { background:#f8d7da; color:#721c24; }

/* RESPONSIVE */
@media(max-width:1024px){
    .summary { grid-template-columns: repeat(2,1fr); }
}
</style>

<div class="admin-dashboard">

    {{-- 🔥 SIDEBAR GLOBAL --}}
    @include('admin.partials.sidebar')

    {{-- MAIN --}}
    <main class="main">

        {{-- HEADER --}}
        <div class="header">
            <h1>Reports</h1>

            <div class="user">
                <span>Hi, Admin</span>
                <span class="material-icons">account_circle</span>
                <span class="material-icons">notifications</span>
            </div>
        </div>

        {{-- ACTIONS --}}
        <div class="header-actions" style="margin-bottom:28px;">
            <a href="{{ route('admin.reports.pdf', request()->query()) }}" class="export-btn">
                <span class="material-icons">picture_as_pdf</span>
                Export PDF
            </a>
            <a href="{{ route('admin.reports.excel', request()->query()) }}" class="export-btn">
                <span class="material-icons">table_view</span>
                Export Excel
            </a>
        </div>

        {{-- FILTER --}}
        <form method="GET" class="filter-form">
            <div>
                <label>From</label><br>
                <input type="date" name="start_date" value="{{ $startDate }}">
            </div>

            <div>
                <label>To</label><br>
                <input type="date" name="end_date" value="{{ $endDate }}">
            </div>

            <div>
                <label>Seating Area</label><br>
                <select name="category">
                    <option value="">All</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="export-btn" style="margin-top:22px;">
                <span class="material-icons">filter_alt</span>
                Filter
            </button>
        </form>

        {{-- SUMMARY (REAL DATA) --}}
        <section class="summary">
            <div class="card-summary yellow">
                <p>Total Reservations</p>
                <h3>{{ $totalReservations }}</h3>
                <span class="material-icons">event</span>
            </div>

            <div class="card-summary olive">
                <p>Pending</p>
                <h3>{{ $pending }}</h3>
                <span class="material-icons">hourglass_empty</span>
            </div>

            <div class="card-summary purple">
                <p>Confirmed</p>
                <h3>{{ $confirmed }}</h3>
                <span class="material-icons">check_circle</span>
            </div>

            <div class="card-summary red">
                <p>Cancelled / Rejected</p>
                <h3>{{ $cancelled + $rejected }}</h3>
                <span class="material-icons">cancel</span>
            </div>
        </section>

        {{-- BAR CHART (REAL QUERY DATA) --}}
        <div class="card">
            <h3>Reservation by Seating Area</h3>

            <div class="bar-chart">
                @foreach($categoryChart as $cat)
                    <div class="bar-group">
                        <div class="bar"
                             style="height:{{ $maxHeight ? ($cat->total / $maxHeight) * 100 : 0 }}%">
                        </div>
                        <div class="bar-label">
                            {{ $cat->name }}<br>
                            <strong>{{ $cat->total }}</strong>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- TABLE (REAL RESERVATIONS) --}}
        <div class="card">
            <h3>Detailed Reservation Report</h3>

            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Area</th>
                        <th>Guests</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $r)
                        <tr>
                            <td>{{ $r->reservation_date }}</td>
                            <td>{{ $r->user->name ?? '-' }}</td>
                            <td>{{ $r->category->name ?? '-' }}</td>
                            <td>{{ $r->people_count }}</td>
                            <td>
                                <span class="status {{ $r->status }}">
                                    {{ ucfirst($r->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </main>
</div>
@endsection
