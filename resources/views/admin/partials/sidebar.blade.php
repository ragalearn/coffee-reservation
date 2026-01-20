<aside class="sidebar">
    <div class="brand">Maiway Admin</div>

    <nav class="menu">
        <a href="{{ route('admin.dashboard') }}"
           class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="material-icons">dashboard</span>
            Dashboard
        </a>

        <a href="{{ route('admin.categories.index') }}"
           class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <span class="material-icons">event_seat</span>
            Seating Areas
        </a>

        <a href="{{ route('admin.reservations.index') }}"
           class="{{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}">
            <span class="material-icons">event</span>
            Reservations
        </a>

        <a href="{{ route('admin.reports.index') }}"
           class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
            <span class="material-icons">bar_chart</span>
            Reports
        </a>

        <a href="{{ route('admin.settings.index') }}"
            class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <span class="material-icons">settings</span>
            Settings
        </a>
    </nav>

    <form method="POST" action="{{ route('logout') }}" class="logout">
        @csrf
        <button type="submit">
            <span class="material-icons">logout</span>
            Log Out
        </button>
    </form>
</aside>
