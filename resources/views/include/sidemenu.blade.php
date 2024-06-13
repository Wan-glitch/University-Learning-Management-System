<ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item {{'home' == request()->path() ? 'active' : ''}}">
        <a href="{{ route('dashboard') }}" class="menu-link ">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">Dashboard</div>
        </a>
    </li>

    <!-- Layouts -->
    <li class="menu-item {{ Request::is('courses') || Request::is('courses/*') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle" onclick="expandMenuAndRedirect('{{ route('courses.index') }}')">
            <i class="menu-icon tf-icons bx bx-crown"></i>
            <div data-i18n="Misc">Courses</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ Request::is('courses/programming-fundamentals') ? 'active' : '' }}">
                <a href="{{ route('courses.programming') }}" class="menu-link">
                    <div data-i18n="Error">Programming Fundamentals</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('courses/machine-learning') ? 'active' : '' }}">
                <a href="{{ route('courses.machine-learning') }}" class="menu-link">
                    <div data-i18n="Error">Machine Learning</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('courses/web-development') ? 'active' : '' }}">
                <a href="{{ route('courses.web-development') }}" class="menu-link">
                    <div data-i18n="Error">Web Development Application</div>
                </a>
            </li>
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





<li class="menu-item {{'faculty' == request()->path() ? 'active' : ''}}">
    <a href="{{ route('faculty') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-layout"></i>
        <div data-i18n="Analytics">Faculty</div>
    </a>
</li>

    <li class="menu-item {{'calendar' == request()->path() ? 'active' : ''}}">
        <a href="{{ route('calendar.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-layout"></i>
            <div data-i18n="Analytics">Calendar</div>
        </a>
    </li>

    <li class="menu-item {{ 'users' == request()->path() ? 'active' : '' }}">
        <a href="{{ route('users.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-user"></i>
            <div data-i18n="User Management">User Management</div>
        </a>
    </li>
    <li class="menu-item {{ 'users' == request()->path() ? 'active' : '' }}">
        <a href="{{ route('users.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-user"></i>
            <div data-i18n="User Management">Course Management</div>
        </a>
    </li>
    {{-- <li class="menu-item {{ Request::is('courses/*') ? 'active open' : '' }}">
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
    </li>  --}}
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
    {{-- <li class="menu-item">
        <a href="{{ route('logouts') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-power-off"></i>
        <div data-i18n="Analytics">Logout</div>
        </a>
    </li> --}}

</ul>
