


@extends('layout.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
        <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>

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
        color: #ecebeb; /* Icon color */
      }


    .table-container {
        max-height: 400px; /* Set the maximum height for the scrollable container */
        overflow-y: scroll; /* Add vertical scrollbar when content exceeds max height */
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
    background-color: #fff; /* Background color for inactive pages */
    border-color: #ddd; /* Border color for inactive pages */
    color: #333; /* Text color for inactive pages */
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

@include('faculty.modals.create_faculty_modal')
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

                                <!-- Location button -->
                                {{-- <button type="button" class="btn btn-primary" style="margin-block:10px;" onclick="window.location='{{ route('setting.add') }}';">
                                    <span class="tf-icons bx bx-plus"></span>&nbsp; Location
                                </button> --}}
                                <button type="button" class="btn btn-primary" style="margin-block:10px;" onclick="showModal()">
                                    <span class="tf-icons bx bx-plus"></span>&nbsp; Faculty
                                </button>



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
            <div class="input-group input-group-merge float-right">
                <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Search Faculty..."
                  aria-label="Search Faculty..."
                  aria-describedby="basic-addon-search31"
                  id="searchInput"
                />
            </div>
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
                    <tbody class="table-border-bottom-0" id="FacultyTableBody">
                        @foreach ($faculties as $faculty)
                        <tr>
                            <td>{{ $faculty->id }}</td>
                            <td>{{ $faculty->title }}</td>
                            {{-- <td>{{ $faculty->pic }}</td> <!-- Assuming you have a 'pic' column in your Faculty model -->
                            <td>{{ $faculty->status }}</td> <!-- Assuming you have a 'status' column in your Faculty model --> --}}
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <hr class="hr" />

            </div>
        </div>
    </div>
    <!--After Edit -->
    @if(session('success'))
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
