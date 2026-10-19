<aside class="sidebar">
    <!-- အပေါ်ပိုင်း: Menu လင့်ခ်များ -->
    <div class="sidebar-top">
        <div class="sidebar-title">MENU</div>
        <a href="{{ route('students.index') }}"> Student List </a>
        <a href="{{ route('students.create') }}"> Add Student </a>
        <a href="{{ route('courses.index') }}"> Course List </a>
        <a href="{{ route('courses.create') }}"> Add Course </a>
        <a href="{{ route('subjects.index') }}"> Subject List </a>
        <a href="{{ route('subjects.create') }}"> Add Subject </a>
    </div>

    <!-- အောက်ပိုင်း: Logout ခလုတ် သီးသန့် -->
    <div class="sidebar-bottom">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
        </form>
    </div>
</aside>