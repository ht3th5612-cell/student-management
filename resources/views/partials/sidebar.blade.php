<aside class="sidebar" id="sidebar">
    <a href="{{ route('students.index') }}" class="sidebar-brand">
        <span class="brand-mark"><i class="bi bi-mortarboard-fill"></i></span>
        <span class="brand-text">
            Student MS
            <strong>Management</strong>
        </span>
    </a>

    <nav class="sidebar-nav">
        <div class="sidebar-title">Students</div>
        <a href="{{ route('students.index') }}" class="sidebar-link {{ request()->routeIs('students.index', 'students.edit') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Student List
        </a>
        <a href="{{ route('students.create') }}" class="sidebar-link {{ request()->routeIs('students.create') ? 'active' : '' }}">
            <i class="bi bi-person-plus"></i> Add Student
        </a>

        <div class="sidebar-title">Courses</div>
        <a href="{{ route('courses.index') }}" class="sidebar-link {{ request()->routeIs('courses.index', 'courses.edit') ? 'active' : '' }}">
            <i class="bi bi-journal-bookmark"></i> Course List
        </a>
        <a href="{{ route('courses.create') }}" class="sidebar-link {{ request()->routeIs('courses.create') ? 'active' : '' }}">
            <i class="bi bi-journal-plus"></i> Add Course
        </a>

        <div class="sidebar-title">Subjects</div>
        <a href="{{ route('subjects.index') }}" class="sidebar-link {{ request()->routeIs('subjects.index', 'subjects.edit') ? 'active' : '' }}">
            <i class="bi bi-book"></i> Subject List
        </a>
        <a href="{{ route('subjects.create') }}" class="sidebar-link {{ request()->routeIs('subjects.create') ? 'active' : '' }}">
            <i class="bi bi-bookmark-plus"></i> Add Subject
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <span class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</span>
            <div class="user-meta">
                <span class="user-name">{{ auth()->user()->name ?? 'User' }}</span>
                <span class="user-email">{{ auth()->user()->email ?? '' }}</span>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>
