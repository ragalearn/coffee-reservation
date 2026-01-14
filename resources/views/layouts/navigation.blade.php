<nav class="border-b p-4">
    <div class="flex justify-between">

        <div>
            <strong>Coffee Reservation</strong>
        </div>

        <div>
            @auth
                {{-- ADMIN MENU --}}
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a> |
                    <a href="{{ route('admin.categories.index') }}">Kategori</a> |
                    <a href="{{ route('admin.tables.index') }}">Meja</a> |
                    <a href="{{ route('admin.reservations.index') }}">Reservasi</a>
                @endif

                {{-- PELANGGAN MENU --}}
                @if (auth()->user()->role === 'pelanggan')
                    <a href="{{ route('reservations.index') }}">Reservasi Saya</a>
                @endif

                |
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @endauth
        </div>

    </div>
</nav>
