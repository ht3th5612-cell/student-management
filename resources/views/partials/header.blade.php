<header class="top-header">
    <button type="button" class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle menu">
        <i class="bi bi-list"></i>
    </button>

    <div class="header-title">@yield('title', 'Dashboard')</div>

    <div class="header-user">
        <span class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</span>
        <span class="user-name">{{ auth()->user()->name ?? 'User' }}</span>
    </div>
</header>
