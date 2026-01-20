<nav class="border-b p-4">
    <div class="flex justify-between">

        <div>
            @if (!request()->routeIs('reservations.create'))
                <strong>Coffee Reservation</strong>
            @endif
        </div>


        <div>
            @auth
                @if (auth()->user()->role === 'pelanggan')
                    {{-- ENTRY POINT RESERVASI HARUS KE CATEGORY --}}
                    <a href="{{ route('categories.index') }}">Reservasi</a>
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
