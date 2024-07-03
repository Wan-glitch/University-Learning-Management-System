<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<style>
    .notification-dropdown {
        display: none;
        position: absolute;
        right: 0;
        top: 50px;

        background-color: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 4px;
        z-index: 1000;
    }

    .notification-header {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .notification-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .notification-item {
        padding: 10px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .notification-item:last-child {
        border-bottom: none;
    }

    .notification-item img {
        border-radius: 50%;
        width: 40px;
        height: 40px;
        margin-right: 10px;
    }

    .notification-item button {
        margin-left: 10px;
    }

</style>

<!-- Navbar -->
<nav x-data="{ open: false }"
    class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme custom-navbar"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    {{-- <div class="navbar-nav-right d-flex align-items-center w-100" id="navbar-collapse"> --}}
    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        {{-- @if ($title)
                <div><strong>{{ $title }}</strong></div>
            @endif --}}

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Notification -->
            <li class="nav-item dropdown">
                <a class="nav-link" href="javascript:void(0);" id="notificationsDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bx bx-bell bx-sm"></i>
                    <span class="badge bg-danger" id="notificationCount"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown"
                    id="notificationsMenu">
                    <li class="dropdown-header">
                        <h6>Notification</h6>
                        <a href="javascript:void(0);" class="float-end" id="clearAll">Clear All</a>
                    </li>
                    <!-- Notifications will be populated by JavaScript -->
                </ul>
            </li>

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow d-flex align-items-center" href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ $user->profile_photo_url }}" alt="w-px-40 h-auto rounded-circle"
                            class="rounded-circle" />

                    </div>
                    <span class="ms-2"
                        style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        {{-- <img src="/assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" /> --}}
                                        <img src="{{ $user->profile_photo_url }}" alt="w-px-40 h-auto rounded-circle"
                                            class="rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                                    <small class="text-muted">{{ Auth::user()->email }}</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">My Profile</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Log Out</span>
                            </a>
                        </form>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>
<!-- / Navbar -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchNotifications();

        function fetchNotifications() {
            $.ajax({
                url: '{{ route("notifications.index") }}',
                method: 'GET',
                success: function(response) {
                    const notificationsMenu = $('#notificationsMenu');
                    const notificationCount = $('#notificationCount');
                    notificationsMenu.find('.notification-item').remove();

                    if (response.length > 0) {
                        notificationCount.text(response.length);
                        response.forEach(notification => {
                            const creatorImageUrl = notification.event.creator.profile_photo_url;
                            const notificationItem = `<li class="notification-item">
                                <a class="dropdown-item" href="#">
                                    <div class="d-flex align-items-center">
                                        <img src="${creatorImageUrl}" alt="User" class="rounded-circle" width="40" height="40">
                                        <div class="ms-3">
                                            <h6>${notification.event.title}</h6>
                                            <p>You've new appointment request</p>
                                            <div class="d-flex">
                                                <button class="btn btn-success btn-sm me-1" onclick="respondToInvitation(${notification.id}, 'accepted')">Accept</button>
                                                <button class="btn btn-danger btn-sm" onclick="respondToInvitation(${notification.id}, 'declined')">Reject</button>
                                            </div>
                                            <small class="text-muted">${notification.created_at}</small>
                                        </div>
                                        <button class="btn btn-link ms-auto" onclick="removeNotification(${notification.id})">&times;</button>
                                    </div>
                                </a>
                            </li>`;
                            notificationsMenu.append(notificationItem);
                        });
                    } else {
                        notificationCount.text('');
                        notificationsMenu.append('<li class="dropdown-item text-center notification-item">No notifications</li>');
                    }
                }
            });
        }

        window.respondToInvitation = function(id, response) {
            $.ajax({
                url: '{{ url("/calendar/invitation") }}/' + id + '/' + response,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    fetchNotifications();
                    Swal.fire('Success', 'Invitation ' + response + ' successfully', 'success');
                },
                error: function() {
                    Swal.fire('Error', 'Error responding to invitation', 'error');
                }
            });
        };

        window.removeNotification = function(id) {
            $.ajax({
                url: '{{ url("/notifications/remove") }}/' + id,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    fetchNotifications();
                },
                error: function() {
                    Swal.fire('Error', 'Error removing notification', 'error');
                }
            });
        };

        $('#clearAll').on('click', function() {
            $.ajax({
                url: '{{ url("/notifications/clear") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    fetchNotifications();
                    Swal.fire('Success', 'All notifications cleared', 'success');
                },
                error: function() {
                    Swal.fire('Error', 'Error clearing notifications', 'error');
                }
            });
        });
    });
</script>
