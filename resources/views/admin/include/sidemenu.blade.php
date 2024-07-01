<ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item {{ 'home' == request()->path() ? 'active' : '' }}">
        <a href="{{ route('admin.dashboard') }}" class="menu-link ">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">Dashboard</div>
        </a>
    </li>

    <li class="menu-item {{ request()->is('admin/users*') ? 'active' : '' }}">
        <a href="{{ route('admin.users.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-user"></i>
            <div data-i18n="User Management">User Management</div>
        </a>
    </li>


    <li class="menu-item {{ 'admin/faculties' == request()->path() ? 'active' : '' }}">
        <a href="{{ route('admin.faculties.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-building"></i>
            <div data-i18n="Analytics">Faculty Management</div>
        </a>
    </li>
    <li class="menu-item {{ request()->is('admin/courses*') ? 'active' : '' }}">
        <a href="{{ route('admin.courses.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-book"></i>
            <div data-i18n="Course Management">Course Management</div>
        </a>
    </li>

    <li class="menu-item {{ request()->is('admin/bulletins*') ? 'active' : '' }}">
        <a href="{{ route('admin.bulletins.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-news"></i>
            <div data-i18n="Bulletin Management">Bulletin Management</div>
        </a>
    </li>
    <li class="menu-item {{ Request::is('admin/roles-permissions*') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-shield"></i>
            <div data-i18n="Misc">Roles & Permission</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ request()->is('roles') ? 'active' : '' }}">
                <a href="{{ route('admin.roles.index') }}" class="menu-link">
                    <div data-i18n="Error">Roles</div>
                </a>
            </li>
        </ul>
    </li>

    <li class="menu-item {{ request()->is('admin/slideshow*') ? 'active' : '' }}">
        <a href="{{ route('admin.slideshow.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-carousel"></i>
            <div data-i18n="Slideshow Management">Slideshow Management</div>
        </a>
    </li>

    <li class="menu-item {{ 'calendar' == request()->path() ? 'active' : '' }}">
        <a href="{{ route('calendar.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-calendar-star"></i>
            <div data-i18n="Analytics">Calendar</div>
        </a>
    </li>

    <li class="menu-item">
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="menu-link" style="cursor: pointer;">
                <i class="menu-icon tf-icons bx bx-power-off"></i>
                <div data-i18n="Analytics">Logout</div>
            </button>
        </form>
    </li>




</ul>
<script>
    function expandMenuAndRedirect(url) {
        // Expand the menu
        const menuSub = document.querySelector('.menu-sub');
        if (menuSub) {
            menuSub.style.display = 'block';
        }
        // Redirect to the desired page after a short delay to allow the menu to expand
        setTimeout(() => {
            window.location.href = url;
        }, 300);
    }
</script>
