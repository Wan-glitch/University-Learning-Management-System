
@if(Auth::check() && Auth::user()->role=='1')



<ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item {{ 'home' == request()->path() ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="menu-link ">
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

@else
    <ul class="menu-inner py-1">
        <li class="menu-item {{ 'home' == request()->path() ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link ">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Layouts -->
        <li class="menu-item {{ Request::is('courses') || Request::is('courses/*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle"
                onclick="expandMenuAndRedirect('{{ route('courses.index') }}')">
                <i class="menu-icon tf-icons bx bx-book"></i>
                <div data-i18n="Misc">Courses</div>
            </a>
            <ul class="menu-sub">
                @foreach ($courses as $course)
                    <li class="menu-item {{ Request::is('courses/' . $course->slug) ? 'active' : '' }}">
                        <a href="{{ route('courses.show', ['course' => $course->id]) }}" class="menu-link">
                            <div>{{ $course->name }}</div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>

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


        <li class="menu-item {{ 'calendar' == request()->path() ? 'active' : '' }}">
            <a href="{{ route('calendar.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar-star"></i>
                <div data-i18n="Analytics">Calendar</div>
            </a>
        </li>

        {{-- <li class="menu-item {{'ticket' == request()->path() ? 'active' : ''}}">
        <a href="{{ route('ticket') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-layout"></i>
            <div data-i18n="Analytics">Appointment</div>
        </a>
    </li>
    <li class="menu-item {{'ticket' == request()->path() ? 'active' : ''}}">
        <a href="{{ route('ticket') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-layout"></i>
            <div data-i18n="Analytics">Industrial Training</div>
        </a>
    </li> --}}
        {{-- <li class="menu-item {{'ticketnew' == request()->path() ? 'active' : ''}}">
        <a href="{{ route('newticket') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-layout"></i>
            <div data-i18n="Analytics">Open a New Ticket</div>
        </a>
    </li> --}}
        {{-- @can('Read Role')
    <li class="menu-item {{ Request::is('setting/*') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-crown"></i>
            <div data-i18n="Misc">Roles & Permission</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ 'setting/roles' == request()->path() ? 'active' : '' }}">
                <a href="{{ route('setting.managerole') }}" class="menu-link">
                    <div data-i18n="Error">Roles</div>
                </a>
            </li>
        </ul>
    </li>
    @endcan --}}

        {{-- <li class="menu-item {{Request::is('setting/*') ? 'active open':'' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-cube-alt"></i>
            <div data-i18n="Misc">Settings</div>
        </a>
        <ul class="menu-sub">
            @can('Read Agency')
                <li class="menu-item {{'setting/agency' == request()->path() ? 'active' : ''}}">
                    <a href="{{ route('setting.agency') }}" class="menu-link">
                    <div data-i18n="Error">Agency</div>
                    </a>
                </li>
            @endcan
            @can('Read Project')
                <li class="menu-item {{'setting/project' == request()->path() ? 'active' : ''}}">
                    <a href="{{ route('setting.project') }}" class="menu-link">
                    <div data-i18n="Error">Projects</div>
                    </a>
                </li>
            @endcan
            <li class="menu-item {{'setting/cat' == request()->path() ? 'active' : ''}}">
                <a href="{{ route('setting.cat') }}" class="menu-link">
                <div data-i18n="Error">Categories</div>
                </a>
            </li>

            @can('Read Asset')
                <li class="menu-item {{'setting/asset' == request()->path() ? 'active' : ''}}">
                    <a href="{{ route('setting.asset') }}" class="menu-link">
                    <div data-i18n="Error">Assets</div>
                    </a>
                </li>
             @endcan

            @can('Read User')
                <li class="menu-item {{'setting/user' == request()->path() ? 'active' : ''}}">
                    <a href="{{ route('setting.user') }}" class="menu-link">
                    <div data-i18n="Error">Users</div>
                    </a>
                </li>
            @endcan

            @can('Read Role')
                <li class="menu-item">
                    <a href="{{ route('setting.managerole') }}" class="menu-link">
                    <div data-i18n="Error">Roles</div>
                    </a>
                </li>
            @endcan

            @can('Read Location')
                <li class="menu-item {{'setting/location' == request()->path() ? 'active' : ''}}">
                    <a href="{{ route('setting.location') }}" class="menu-link ">
                    <div data-i18n="Error">Station Code</div>
                    </a>
                </li>
            @endcan

            <li class="menu-item {{'setting/pic' == request()->path() ? 'active' : ''}}">
                <a href="{{ route('setting.pic') }}" class="menu-link ">
                <div data-i18n="Error">Person In Charge</div>
                </a>
            </li>
        </ul>
    </li> --}}
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
@endif
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
