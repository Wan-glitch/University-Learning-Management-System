@extends('layout.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title">Edit Role</h5>
        </div>
        <div class="card-body">
            @if (isset($role))
            <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3" style="margin-top: 10px">
                    <label for="name">Role Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
                </div>
                <div class="col-lg-12 col-md-12 col-12 mb-3 mt-3">
                    <div class="col-12" style="padding-bottom: 30px">
                        <h5 class="mt-2 pt-50">Role Permissions</h5>
                        <!-- Permission table -->
                        <div class="table">
                            <table class="table table-flush-spacing" style="width: 100%">
                                <tbody>
                                    <tr>
                                        <td class="text-nowrap fw-bolder">
                                            Administrator Access
                                            <span data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                title="Allows full access to the system">
                                                <i data-feather="info" class="bi bi-info-circle"
                                                    style="color: ##696cff; font-size: 16px; vertical-align: middle;"></i>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="selectAll" />
                                                    <label class="form-check-label" for="selectAll">
                                                        Select All </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @foreach ($permParents as $parent)
                                    <tr>
                                        <td class="text-nowrap fw-bolder">{{ $parent->name }}</td>
                                        <td>
                                            <div class="row">
                                                @foreach ($parent->permissions as $permission)
                                                <div class="col-4 col-md-4 col-lg-2 form-check">
                                                    <input id="permission{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}"
                                                    @if ($roleHasPerm->contains(function ($value, $key) use ($permission, $role) {
                                                        return $value->permission_id == $permission->id && $value->role_id == $role->id;
                                                    }))
                                                        checked
                                                    @endif
                                                    type="checkbox" class="form-check-input permission-checkbox">
                                                    <label class="form-check-label" for="permission{{ $permission->id }}">{{ $permission->name }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Permission table -->
                </div>
                <button type="submit" class="btn btn-primary">Update Role</button>
            </form>
            @else
                <p>No role found</p>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('selectAll');
        const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');

        selectAllCheckbox.addEventListener('change', function () {
            permissionCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        permissionCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                if (!checkbox.checked) {
                    selectAllCheckbox.checked = false;
                } else if (Array.from(permissionCheckboxes).every(cb => cb.checked)) {
                    selectAllCheckbox.checked = true;
                }
            });
        });
    });
</script>
@endsection
