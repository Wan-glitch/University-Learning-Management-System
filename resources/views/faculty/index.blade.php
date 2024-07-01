@extends('layout.app')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">

            <style>
                .search-button {
                    display: inline-flex;
                    align-items: center;
                    padding: 5px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    background-color: #fff;
                    cursor: pointer;
                }

                .search-icon {
                    margin-right: 5px;
                    color: #ecebeb;
                    /* Icon color */
                }


                .table-container {
                    max-height: 400px;
                    /* Set the maximum height for the scrollable container */
                    overflow-y: scroll;
                    /* Add vertical scrollbar when content exceeds max height */
                }

                .pagination {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    gap: 10px;
                    margin-top: 20px;
                }



                .pagination-divider {
                    padding: 0;
                    margin: 0;
                    border: none;
                    color: #777;

                }

                .pagination .page-item .page-link {
                    background-color: #fff;
                    /* Background color for inactive pages */
                    border-color: #ddd;
                    /* Border color for inactive pages */
                    color: #333;
                    /* Text color for inactive pages */
                }

                /* Styling for active page number */
                .pagination .page-item.active .page-link {
                    background-color: #007bff;
                    border-color: #007bff;
                    color: #fff;
                }

                /* Override Bootstrap's default focus outline */
                .pagination .page-item .page-link:focus {
                    box-shadow: none;
                }
            </style>


            <!-- Ticket info -->
            <div class="col-md-6 col-md-12 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="card-title m-0 me-2">Faculty List </h5>
                                </div>

                                <div class="col-md-4" style="float: right;">
                                    <div style="display: flex; flex-direction: column; align-items: flex-end;">
                                        <button type="button" class="btn btn-primary" style="margin-block:10px;"
                                            onclick="showModal()">
                                            <span class="tf-icons bx bx-plus"></span>&nbsp; Faculty
                                        </button>

                                        @include('faculty.modals.create_faculty_modal')

                                        <!-- Deleted List button -->
                                        {{-- <button type="button" class="btn btn-primary"  onclick="window.location='{{ route('setting.deletedLocation') }}';">
                                    <span class="fas fa-trash"></span>&nbsp; Deleted List
                                </button> --}}


                                    </div>

                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap mt-4">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Faculty</th>
                                        <th>PIC</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0" id="projectTable">
                                    @foreach ($paginatedProjects as $p)
                                    <tr onclick="window.location='{{ route('faculty.detail', ['faculty' => $p->id]) }}';"
                                        style="cursor: pointer;">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $p->title }}</td>
                                        <td>
                                            @if ($p->pic == NULL)
                                            NOT SET
                                            @else
                                            {{ $p->hasPIC->name }}
                                            <br><small class="text-muted">{{ $p->hasPIC->email }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($p->status == 1)
                                            <span class="badge bg-label-success me-1">Active</span>
                                            @else
                                            <span class="badge bg-label-secondary me-1">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <hr class="hr" />

                            <nav aria-label="...">
                                <ul class="pagination">
                                    @if($paginationData['current_page'] > 1)
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ route('faculty', ['page' => $paginationData['current_page'] - 1]) }}">Previous</a>
                                    </li>
                                    @endif

                                    @for ($i = 1; $i <= $paginationData['last_page']; $i++)
                                    <li class="page-item {{ $i === $paginationData['current_page'] ? 'active' : '' }}">
                                        <a class="page-link"
                                            href="{{ route('faculty', ['page' => $i]) }}">{{ $i }}</a>
                                    </li>
                                    @endfor

                                    @if($paginationData['current_page'] < $paginationData['last_page'])
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ route('faculty', ['page' => $paginationData['current_page'] + 1]) }}">Next</a>
                                    </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>

                <!--After Edit -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

            </div>


            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

            <script>
                function showModal() {
                    $('#facultyModal').modal('show');
                }

                function createFaculty() {
                    // Retrieve form data
                    var title = $('#title').val();
                    var description = $('#description').val();

                    // Send an AJAX request to create faculty
                    // Example:
                    // $.post('/create-faculty', {title: title, description: description}, function(response) {
                    //     // Handle response
                    //     console.log(response);
                    // });

                    // Close modal after faculty creation
                    $('#facultyModal').modal('hide');
                }

            </script>
        @endsection
