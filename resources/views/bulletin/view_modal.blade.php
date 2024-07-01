{{-- <style>
    /* Suggestions items */
    .nav-tabs .nav-item {
        flex: 1;
        text-align: center;
    }


    .nav-tabs .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
    }

    .nav-tabs .nav-link.active {
        border-bottom-color: #3a3a3a;
        color: #3a3a3a;
        font-weight: bold;
    }

    .tab-content {
        padding-top: 10px;
    }

    .item {
        border-bottom: 1px solid #ddd;
        padding: 15px 0;
    }

    .item:last-child {
        border-bottom: none;
    }

    .title {
        font-size: 18px;
        font-weight: bold;
        color: #3a3a3a;
        margin: 0;
    }

    .date {
        color: #888;
        font-size: 14px;
        margin-top: 5px;
    }

    .view-all {
        text-align: center;
        padding: 20px;
        color: #3a3a3a;
        text-decoration: none;
        display: block;
        cursor: pointer;
    }

    .tasks-card .card-title {
        font-size: 16px;
        font-weight: bold;
        color: #3a3a3a;
        margin: 0;
    }

    .list-group-item a {
        text-decoration: none;
        color: #3a3a3a;
        font-weight: bold;
    }

    .list-group-item .float-end {
        color: #888;
        font-size: 14px;
    }

    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 10000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: white;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-height: 80%;
        overflow-y: auto;
    }

    .close-btn {
        color: #aaa;
        float: left;
        font-size: 28px;
        font-weight: bold;
    }

    .close-btn:hover,
    .close-btn:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .button-group {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px;
        }
        .button-group .button {
            padding: 10px 20px;
            border: 1px solid #ccc;
            border-right: none;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
            flex: 1;
            text-align: center;
            color: #4a4a4a;
        }
        .button-group .button:last-child {
            border-right: 1px solid #ccc;
        }
        .button-group .button.active {
            background-color: #ebedff;
            color: #4a4eff;
        }
.button-group .button:first-child {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }
        .button-group .button:last-child {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }
</style>

    <div id="allBulletinsModal" class="modal" role="dialog">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>All Bulletins</h2>
            <div class="sidebar">
                <div class="tab-container">
                    <div class="button-group">
                      <div class="button bulletin active" onclick="openTab(event, 'Bulletin')" id="defaultOpen">Bulletin</div>
                      <div class="button fac" onclick="openTab(event, 'Faculty')">Faculty</div>
                      <div class="button rem" onclick="openTab(event, 'Reminder')">Reminder</div>
                    </div>
                </div>

            @foreach ($bulletins as $bulletin)
                <div class="item mb-3">
                    <p class="title">{{ $bulletin->title }}</p>
                    <p class="date">{{ $bulletin->created_at->format('d M Y') }}</p>
                    <div class="actions">
                        <button class="btn btn-sm btn-warning" onclick="loadEditBulletin({{ $bulletin }})">Edit</button>
                        <form action="{{ route('bulletins.destroy', $bulletin->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div> --}}
{{--
<style>
    /* styles.css */


    button {
        cursor: pointer;
    }


    .modal-content {
        background-color: white;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 90%;
        display: flex;
        height: 90%;
    }

    .close-btn {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close-btn:hover,
    .close-btn:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .sidebar {
        width: 25%;

        padding: 20px;
        box-sizing: border-box;
    }




    .update-btn,
    .delete-btn {
        padding: 5px 10px;
        margin-right: 10px;
        border: none;
        border-radius: 3px;
    }

    .update-btn {
        background-color: #4CAF50;
        color: white;
    }

    .delete-btn {
        background-color: #f44336;
        color: white;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .page-btn {
        background-color: inherit;
        border: 1px solid #ddd;
        margin: 0 5px;
        padding: 5px 10px;
        cursor: pointer;
    }

    .page-btn.active {
        background-color: #4CAF50;
        color: white;
    }

    .main-content {
        width: 75%;
        padding: 20px;
        box-sizing: border-box;
        overflow-y: auto;
    }

    .main-content h1 {
        margin-top: 0;
    }

    hr {
        border: 0;
        border-top: 1px solid #eee;
        margin: 20px 0;
    }

    .tab-container {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 20px;
    }

    .tab {
        padding: 10px 20px;
        border-radius: 30px;
        border: 1px solid #ccc;
        margin: 0 5px;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .tab.active {
        background-color: #ebedff;
        color: #4a4eff;
    }

    .card {
        padding: 10px !important;
    }

    .card .date {
        display: flex;
        align-items: center;
        color: #999;
        margin-bottom: 15px;

    }

    .card .date img {
        margin-right: 5px;
    }

    .card .buttons {
        display: flex;

    }

    .card .buttons .btn {
        padding: 10px 20px;
        border: 1px solid #ccc;
        border-radius: 30px;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
        font-size: 0.9em;
        width: 45%;
        text-align: center;
    }

    .card .buttons .btn.update {
        background-color: #ebedff;
        color: #4a4eff;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .card .buttons .btn.delete {
        background-color: #fff;
        color: #ff4a4a;
        border: 1px solid #ff4a4a;
        border-bottom-left-radius: 0;
        border-top-left-radius: 0;
    }

    .button-group {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 20px;
    }

    .button-group .button {
        padding: 10px 20px;
        border: 1px solid #ccc;
        border-right: none;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
        flex: 1;
        text-align: center;
        color: #4a4a4a;
    }

    .button-group .button:last-child {
        border-right: 1px solid #ccc;
    }

    .button-group .button.active {
        background-color: #ebedff;
        color: #4a4eff;
    }

    .button-group .button:first-child {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    .button-group .button:last-child {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }
</style>

<!-- Modal Structure -->
<div id="courseModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <div class="sidebar">
            <div class="tab-container">
                <div class="button-group">
                    <div class="button bulletin active" onclick="openTab(event, 'Bulletin')" id="defaultOpen">Bulletin
                    </div>
                    <div class="button fac" onclick="openTab(event, 'Faculty')">Faculty</div>
                    <div class="button rem" onclick="openTab(event, 'Reminder')">Reminder</div>
                </div>
            </div>


            <div class="card">
                <h3>List of courses offered in 2024</h3>
                <p>by User 1</p>
                <div class="date">
                    <img src="https://img.icons8.com/ios-glyphs/30/999999/calendar.png" alt="calendar icon"
                        width="15">
                    <span>25 Jun 2024</span>
                </div>
                <div class="buttons" style="box-sizing: initial;">
                    <div class="btn update">Update</div>
                    <div class="btn delete">Delete</div>
                </div>
            </div>
            <!-- Repeat .post as needed -->
        </div>
        <div id="Faculty" class="tabcontent">
            <!-- Faculty content -->
        </div>
        <div id="Reminder" class="tabcontent">
            <!-- Reminder content -->
        </div>

    </div>

</div>
</div>

<script src="script.js"></script>
<script>
    // script.js

    document.getElementById('openModalBtn').addEventListener('click', function() {
        document.getElementById('courseModal').style.display = 'block';
    });

    document.querySelector('.close-btn').addEventListener('click', function() {
        document.getElementById('courseModal').style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target == document.getElementById('courseModal')) {
            document.getElementById('courseModal').style.display = 'none';
        }
    });

    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName('tabcontent');
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = 'none';
        }
        tablinks = document.getElementsByClassName('tablinks');
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(' active', '');
        }
        document.getElementById(tabName).style.display = 'block';
        evt.currentTarget.className += ' active';
    }

    // Set default tab open
    document.getElementById('defaultOpen').click();
</script> --}}

<style>
    .button-group {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 20px;
    }

    .button-group .button {
        padding: 10px 20px;
        border: 1px solid #ccc;
        border-right: none;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
        flex: 1;
        text-align: center;
        color: #4a4a4a;
    }

    .button-group .button:last-child {
        border-right: 1px solid #ccc;
    }

    .button-group .button.active {
        background-color: #ebedff;
        color: #4a4eff;
    }

    .button-group .button:first-child {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    .button-group .button:last-child {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }
</style>
<div class="modal fade" id="bulletinModal" tabindex="-1" role="dialog" aria-labelledby="bulletinModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulletinModalLabel">Bulletin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Sidebar -->
                        <div class="col-md-4 sidebar">
                            <div class="button-group">
                                <div class="button bulletin active" onclick="openTab(event, 'Bulletin')" id="defaultOpen">Bulletin</div>
                                <div class="button fac" onclick="openTab(event, 'Faculty')">Faculty</div>
                                <div class="button rem" onclick="openTab(event, 'Reminder')">Reminder</div>
                            </div>
                            <div id="bulletin-list" class="bulletin-list">
                                <!-- Bulletin List as Cards will be loaded here -->
                            </div>
                            <!-- Pagination -->
                            <nav class="mt-3">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item">
                                        <a class="page-link" href="#">Previous</a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <!-- Main Content Area -->
                        <div class="col-md-8 main-content">
                            <div class="card bulletin-card">
                                <div class="card-body" id="bulletin-detail">
                                    <!-- Bulletin details will be loaded here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function openTab(evt, tabName) {
        $('.button-group .button').removeClass('active');
        $(evt.currentTarget).addClass('active');
        loadBulletins(tabName);
    }

    function loadBulletins(category) {
        $.ajax({
            url: "{{ route('bulletins.filter') }}",
            type: "GET",
            data: {
                category: category,
                faculty_id: "{{ auth()->user()->faculty }}" // Pass the faculty ID
            },
            success: function(data) {
                $('#bulletin-list').html(data);
            }
        });
    }

    $(document).ready(function() {
        loadBulletins('Bulletin'); // Load bulletins by default

        $(document).on('click', '.bulletin-item', function() {
            var bulletinId = $(this).data('id');
            $.ajax({
                url: "{{ route('bulletins.show', '') }}/" + bulletinId,
                type: "GET",
                success: function(data) {
                    $('#bulletin-detail').html(data);
                }
            });
        });
    });
</script>
