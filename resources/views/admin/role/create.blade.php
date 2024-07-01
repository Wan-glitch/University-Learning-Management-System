@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title">Create New Role</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.roles.store') }}" method="POST">
                    @csrf
                    <div class="col-lg-7 col-md-12 col-12 mb-3 mt-3">
                        <label for="name">Role Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-lg-7 col-md-12 col-12 mb-3 mt-3">
                        <label class="form-label" for="role_name">Description</label>

                        <div class="col-12">
                            <div class="form-floating mb-0">
                                <textarea data-length="100" class="form-control char-textarea" id="description" name="description" rows="3"
                                    placeholder="Description" style="height: 100px"></textarea>

                            </div>
                            <small class="textarea-counter-value float-end"><span class="char-count">0</span> / 100 </small>
                        </div>
                    </div>
                    {{-- <div class="form-group mb-3">
                    <label for="permissions">Permissions</label>
                    <select name="permissions[]" class="form-select" multiple>
                        @foreach ($permissions as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                        @endforeach
                    </select>
                </div> --}}
                    <div class="col-12" style="padding-bottom: 30px">
                        <h4 class="mt-2 pt-50">Role Permissions</h4>
                        <!-- Permission table -->
                        <div class="table">
                            <table class="table table-flush-spacing">

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
                                                    <label class="form-check-label" for="selectAll"> Select All </label>
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
                                                            <input class="form-check-input" type="checkbox"
                                                                id="permission{{ $permission->id }}" name="permissions[]"
                                                                value="{{ $permission->id }}" />
                                                            <label class="form-check-label"
                                                                for="permission{{ $permission->id }}">{{ $permission->name }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <button type="submit" class="btn btn-primary">Create Role</button>
                </form>
            </div>
        </div>
    </div>
@endsection
