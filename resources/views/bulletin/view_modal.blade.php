

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
