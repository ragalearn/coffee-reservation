@extends('layouts.app')

@section('content')
<style>
/* ================= SEATING AREAS (ADMIN) ================= */
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

/* ===== TOOLBAR ===== */
.toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 28px;
}

.search-box {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #fff;
    border: 1px solid #ddd;
    padding: 10px 14px;
    border-radius: 12px;
    width: 360px;
}

.search-box input {
    border: none;
    outline: none;
    width: 100%;
    font-size: 14px;
}

.add-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 18px;
    border: 1px solid #333;
    border-radius: 12px;
    background: #fff;
    cursor: pointer;
    font-weight: 600;
}

/* ===== CARDS ===== */
.cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
}

.card-area {
    background: #fff6f6;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,.1);
    padding: 18px;
    display: flex;
    flex-direction: column;
}

.card-area h3 {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 12px;
}

/* ===== IMAGE ===== */
.card-image img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 12px;
    margin-bottom: 14px;
}

.no-image {
    width: 100%;
    height: 150px;
    background: #ddd;
    border-radius: 12px;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #666;
    font-size: 14px;
}

.card-area p {
    font-size: 13px;
    color: #777;
    line-height: 1.4;
    margin-bottom: 14px;
}

.capacity {
    font-weight: 600;
    margin-bottom: 16px;
}

.card-actions {
    margin-top: auto;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.btn-delete {
    background: #f44336;
    color: #fff;
    border: none;
    padding: 6px 16px;
    border-radius: 999px;
    font-size: 13px;
    cursor: pointer;
}

.btn-edit {
    background: #8b9b4a;
    color: #fff;
    border: none;
    padding: 6px 18px;
    border-radius: 999px;
    font-size: 13px;
    cursor: pointer;
}

/* RESPONSIVE */
@media(max-width:1024px){
    .cards { grid-template-columns: 1fr; }
}
</style>

<div class="admin-dashboard">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    <!-- MAIN -->
    <main class="main">

        <!-- HEADER -->
        <div class="header">
            <h1>Seating Areas</h1>
            <div class="user">
                <span>Hi, Admin</span>
                <span class="material-icons">account_circle</span>
                <span class="material-icons">notifications</span>
            </div>
        </div>

        <!-- TOOLBAR -->
        <div class="toolbar">
            <div class="search-box">
                <span class="material-icons">search</span>
                <input type="text" placeholder="Search Area">
            </div>

            <a href="{{ route('admin.categories.create') }}" class="add-btn">
                <span class="material-icons">add</span>
                Add New Area
            </a>
        </div>

        <!-- CARDS -->
        <section class="cards">
            @foreach($categories as $category)
                <div class="card-area">

                    <h3>{{ $category->name }}</h3>

                    {{-- IMAGE --}}
                    <div class="card-image">
                        @if($category->image)
                            <img src="{{ asset('storage/'.$category->image) }}" alt="{{ $category->name }}">
                        @else
                            <div class="no-image">No Image</div>
                        @endif
                    </div>

                    <p>{{ $category->description ?? '—' }}</p>

                    <div class="capacity">
                        Capacity : {{ $category->min_capacity ?? '?' }} - {{ $category->max_capacity ?? '?' }}
                    </div>

                    <div class="card-actions">
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn-delete">Delete</button>
                        </form>

                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn-edit">
                            Edit
                        </a>
                    </div>

                </div>
            @endforeach
        </section>

    </main>
</div>
@endsection
