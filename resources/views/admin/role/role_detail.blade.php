@can('Read Role')


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

@if (isset($roleid))
@php

    $roleIdToShow = request('id');
    $selectedRole = $roleid->firstWhere('id', $roleIdToShow);

@endphp
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <!-- Ticket list -->
      <div class="col-lg-12 col-md-12 col-12 mb-4">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between pb-0">
            <div class="card-title mb-0">
            <h5 class="m-0 me-2">Role Details</h5>
          </div>
        @can('Create Role')
          <div class="col-md-4" style="float: right;">
                <button type="button" class="btn btn-primary" style="float: right;" onclick="window.location='{{ route('setting.add_role') }}';">
                    <span class="tf-icons bx bx-plus"></span>&nbsp; Role
                </button>
            </div>
        @endcan

        </div>
        <div class="card-body">
          <div class="row">
            <!-- Contact info -->
            <div class="col-lg-6 col-md-6 col-12 mb-4">
                <div class="row mb-3 mt-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">Role Name</label>
                    <div class="col-sm-10">

                        {{ ucfirst($selectedRole->name) }}

                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-7 col-form-label" for="basic-default-phone">Description</label>
                    <div class="col-sm-10" style="text-align: justify;">
                        {{ $selectedRole->Description }}
                    </div>
                </div>



            </div>
            <div class="col-lg-6 col-md-6 col-12 mb-4">


                <div class="row mb-3 mt-3">
                    <label class="col-sm-6 col-form-label" for="basic-default-name">Created by</label>
                    <div class="col-sm-10">
                        {{ $selectedRole->createdByUser?->name ?? 'N/A' }}
                    </div>
                </div>
                <div class="row mb-3 mt-3">
                    <label class="col-sm-6 col-form-label" for="basic-default-name">Updated by</label>
                    <div class="col-sm-10">
                        {{ $selectedRole->updatedByUser?->name ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-6 col-form-label" for="basic-default-status">Status</label>
                    <div class="col-sm-10">
                        {!! $selectedRole->role_status == 1
                            ? '<span class="badge bg-label-success me-1">Active</span>'
                            : ($selectedRole->role_status == 0
                                ? '<span class="badge bg-label-secondary me-1">Inactive</span>'
                                : '<span class="badge bg-label-secondary me-1">Archived</span>') !!}
                    </div>
                </div>


                @can('Update Role')

                <div class="grid">
                    @if ($selectedRole->role_status == 1)
                        <div class="item">
                            <div class="content">
                                <form action="{{ route('setting.role.edit', ['id' => $selectedRole->id]) }}">
                                    <button type="submit" class="btn btn-success">Edit</button>
                                </form>
                            </div>
                        </div>
                    @endif

                    @if ($selectedRole->role_status == 1)
                        <div class="item">
                            <div class="content">
                                <form id="deleteLocationForm-{{ $selectedRole->id }}" action="{{ route('setting.role.delete', ['id' => $selectedRole->id]) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" id="deleteLocationId" name="location_id" value="{{ $selectedRole->id }}">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this Role?')">
                                        Delete <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                    @if ($selectedRole->role_status == 0)
                        <div class="item">
                            <div class="content">
                                <form id="recoverLocationForm-{{ $selectedRole->id }}" action="{{ route('setting.role.recover', ['id' => $selectedRole->id]) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" id="recoverLocationId" name="location_id" value="{{ $selectedRole->id }}">
                                    <button type="submit" data-mdb-ripple-color="dark" class="btn btn-primary" onclick="return confirm('Are you sure you want to Restore this Role?')">
                                        Recover
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
                @endcan

            </div>
          </div>
        </div>

        {{-- rwrwrer --}}




    </div>
</div>

    <!--/ Ticket list -->



    <div class="container">
        <div class="row">
          <!-- Ticket list -->
          <div class="col-lg-12 col-md-12 col-12 mb-4">
            <div class="card h-100">
              <div class="card-header d-flex align-items-center justify-content-between pb-0">
                <div class="card-title mb-0">
                <h5 class="m-0 me-2">Current Permission</h5>
              </div>

            </div>
            <div class="card-body">
              <div class="row">
                <!-- Contact info -->
                <div class="col-lg-12 col-md-12 col-12 mb-3 mt-3">
                    <div class="col-12" style="padding-bottom: 30px">
                        <h5 class="mt-2 pt-50">Role Permissions</h5>
                        <!-- Permission table -->
                        <div class="table">
                            <table class="table table-flush-spacing" style="width: 100%">
                                <tbody>
                                    @foreach ($permParents as $parent)
                                        @php
                                            $hasSelectedPermissions = false;
                                        @endphp
                                        @foreach ($parent->permissions as $permission)
                                            @if ($roleHasPerm->contains(function ($value, $key) use ($permission, $selectedRole) {
                                                return $value->permission_id == $permission->id && $value->role_id == $selectedRole->id;
                                            }))
                                                @php
                                                    $hasSelectedPermissions = true;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if ($hasSelectedPermissions)
                                        <tr>
                                            <td class="text-nowrap fw-bolder">{{ $parent->name }}</td>
                                            <td>
                                                <div class="row">
                                                    @foreach ($parent->permissions as $permission)
                                                        @if ($roleHasPerm->contains(function ($value, $key) use ($permission, $selectedRole) {
                                                            return $value->permission_id == $permission->id && $value->role_id == $selectedRole->id;
                                                        }))
                                                        <div class="col-4 col-md-4 col-lg-2">
                                                            {{ $permission->name }}
                                                        </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Permission table -->
                </div>


                </div>
              </div>
            </div>

            {{-- rwrwrer --}}




          </div>
        </div>















  </div>
</div>
@endif
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
@endcan
