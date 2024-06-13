

@extends('layout.app')
@section('content')
<!-- Content -->

<style>
.grid {
    display: inline-flex;
    grid-template-columns: 1fr 1fr;

    column-gap: 10px;
    row-gap: 10px;
  }

  .content {
    color: #242424;
    font-weight: 600;
    box-sizing: border-box;
    height: 100%;
    padding: 10px;
  }

</style>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <!-- Ticket list -->
      <div class="col-lg-12 col-md-12 col-12 mb-4">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between pb-0">
            <div class="card-title mb-0">
            <h5 class="m-0 me-2">Faculty Details</h5>
          </div>
          <div class="col-md-4" style="float: right;">
                {{-- <button type="button" class="btn btn-primary" style="float: right;" onclick="window.location='{{ route('setting.add') }}';">
                    <span class="tf-icons bx bx-plus"></span>&nbsp; Location
                </button> --}}
            </div>

        </div>
        <div class="card-body">
          <div class="row">
            <!-- Contact info -->
            <div class="col-lg-12 col-md-6 col-12 mb-4">
                <div class="row mb-3 mt-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">Faculty Name</label>
                    <div class="col-sm-10">



                    </div>
                </div>
                <div class="row mb-3 mt-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">Faculty Description</label>
                    <div class="col-sm-10">


                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-phone">Faculty's Person-in-Charge</label>
                    <div class="col-sm-10">

                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12 mb-4">


                <div class="row mb-3 mt-3">
                    <label class="col-sm-6 col-form-label" for="basic-default-name">Created by</label>
                    <div class="col-sm-10">

                    </div>
                </div>
                <div class="row mb-3 mt-3">
                     @if ($faculty->status == 0)
                    <label class="col-sm-6 col-form-label" for="basic-default-name">Deleted by</label>
                    @else
                    <label class="col-sm-6 col-form-label" for="basic-default-name">Updated by</label>
                    @endif

                    <div class="col-sm-10">
                        {{ $faculty->updatedByUser?->name ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-6 col-form-label" for="basic-default-status">Status</label>
                     <div class="col-sm-10">
                        {!! $faculty->status == 1
                            ? '<span class="badge bg-label-success me-1">Active</span>'
                            : ($faculty->status == 0
                                ? '<span class="badge bg-label-secondary me-1">Inactive</span>'
                                : '<span class="badge bg-label-secondary me-1">Archived</span>') !!}
                    </div>
                </div>


            {{-- @can('Update Location')

                <div class="grid">
                    @if ($location->location_status == 1)
                        <div class="item">
                            <div class="content">
                                <form action="{{ route('setting.edit.location', ['id' => $location->id]) }}">
                                    <button type="submit" class="btn btn-success">Edit</button>
                                </form>
                            </div>
                        </div>
                    @endif
                    @if ($location->location_status == 1)
                        <div class="item">
                            <div class="content">
                                <form id="deleteLocationForm-{{ $location->id }}" action="{{ route('setting.location.delete', ['id' => $location->id]) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" id="deleteLocationId" name="location_id" value="{{ $location->id }}">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this Location?')">
                                        Delete <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                    @if ($location->location_status == 0)
                        <div class="item">
                            <div class="content">
                                <form id="recoverLocationForm-{{ $location->id }}" action="{{ route('setting.location.recover', ['id' => $location->id]) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" id="recoverLocationId" name="location_id" value="{{ $location->id }}">
                                    <button type="submit" data-mdb-ripple-color="dark" class="btn btn-primary" onclick="return confirm('Are you sure you want to Restore this Location?')">
                                        Recover
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            @endcan --}}
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ Ticket list -->
  </div>
</div>
<!-- / Content -->
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/assets/vendor/libs/popper/popper.js"></script>
    <script src="/assets/vendor/js/bootstrap.js"></script>
    <script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="/assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>


      $(document).on('click','#onBehalfOf',function() {
       if($("#onBehalfOf").is(':checked')){
        $('#tempId2').show();
       }});
       $(document).on('click','#selfReport',function() {
       if($("#selfReport").is(':checked')){
        $('#tempId2').hide();
      }});

    document.addEventListener('DOMContentLoaded', function () {
      var msg = '{{Session::get('alert')}}';
      var exist = '{{Session::has('alert')}}';
      if (exist) {
        alert(msg);
      }
    }

    const deleteLocationForm = document.getElementById('deleteLocationForm');
    const deleteLocationIdInput = document.getElementById('deleteLocationId');
    const deleteButtons = document.querySelectorAll('.btn-danger[data-location-id]');

    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            const locationId = button.getAttribute('data-location-id');
            deleteLocationIdInput.value = locationId;

            // Submit the form
            deleteLocationForm.submit();
        });
    })
    );


    document.addEventListener('DOMContentLoaded', function () {
        const recoverButtons = document.querySelectorAll('.recover-button');
        recoverButtons.forEach(button => {
            button.addEventListener('click', function () {
                const locationId = button.getAttribute('data-location-id');
                const confirmation = confirm('Are you sure you want to recover this location?');

                if (confirmation) {
                    const form = document.getElementById('recoverLocationForm-' + locationId);
                    form.submit();
                }
            });
        });
    });


  </script>

@endsection

