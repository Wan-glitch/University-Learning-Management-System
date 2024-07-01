@can('Update Role')


@extends('layout.app')
@section('content')
    <!-- Content -->
    {{-- <script type="text/javascript" src="{{ URL::asset('js/district_state.js') }}"></script> --}}

    <script src="{{ mix('js/app.js') }}"></script>

    <!-- Include jstree CSS and JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Add Feather Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/themes/default/style.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="{{ asset('vendors/css/tables/datatable/buttons.bootstrap5.min.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Add Feather Icons JS -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>


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
                                <h5 class="m-0 me-2">Edit Role: {{ ucfirst($selectedRole->name) }}</h5>
                            </div>
                        </div>
                        {{-- <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('setting.managerole') }}"> Back</a>
                    </div> --}}
                        <div class="card-body">
                            <form action="{{ route('setting.update.role', ['id' => $selectedRole->id]) }}" method="POST" id="RoleForm">
                                @csrf
                                @method('PUT')
                                <div class="row">

                                    <div class="col-lg-7 col-md-12 col-12 mb-3 mt-3">
                                        <label class="form-label" for="role_name">Role Name</label>
                                        <input type="text" id="role_name" name="role_name"
                                            class="form-control phone-mask" placeholder="{{ ucfirst($selectedRole->name) }}"
                                            value="{{ ucfirst($selectedRole->name) }}" aria-label=""
                                            aria-describedby="basic-default-phone">
                                        <div class="form-group">
                                            <small class="alert alert-danger alert-dismissible fade show" id="name-error"
                                                style="display: none;"></small>
                                        </div>

                                    </div>

                                    <div class="col-lg-7 col-md-12 col-12 mb-3 mt-3">
                                        <label class="form-label" for="role_name">Description</label>

                                        <div class="col-12">
                                            <div class="form-floating mb-0">
                                                <textarea data-length="100" class="form-control char-textarea" id="textarea-counter" name="description"
                                                rows="3" placeholder="Description"style="height: 100px"> {{ $selectedRole->Description }}</textarea>

                                            </div>
                                            <small class="textarea-counter-value float-end"><span
                                                    class="char-count">0</span> / 100 </small>
                                        </div>
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
                                                                        <input class="form-check-input" type="checkbox"
                                                                            id="selectAll" />
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
                                                                        @if ($roleHasPerm->contains(function ($value, $key) use ($permission, $selectedRole) {
                                                                            return $value->permission_id == $permission->id && $value->role_id == $selectedRole->id;
                                                                        }))
                                                                            checked
                                                                        @endif
                                                                        type="checkbox" class="form-check-input">

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
                                    <div class="col-12 text-center mt-2">
                                        <button type="submit" class="btn btn-primary me-1">Submit</button>
                                    </div>
                            </form>
                        </div>
                        {{-- <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="status" name="status" checked=""
                        data-com.bitwarden.browser.user-edited="1">
                    <label class="form-check-label" for="status">Status</label>
                </div> --}}
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    @endif
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Form submission event
        document.getElementById('RoleForm').addEventListener('submit', function(event) {
            const Rolename = document.getElementById('role_name').value;

            // Clear previous error messages
            document.querySelectorAll('.error-text').forEach(errorText => {
                errorText.textContent = '';
                errorText.style.display = 'none'; // Hide error messages
            });

            let isValid = true;

            // Validate role_name
            if (Rolename.trim() === '') {
                const nameError = document.getElementById('name-error');
                nameError.textContent = 'Role name is required.';
                nameError.style.display = 'block'; // Show error message
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault(); // Prevent form submission
            }
        });

        $(function() {
            // Hide child elements by default
            $('.tree li:has(ul)').addClass('parent_li').find('> ul > li').hide();
            $('.tree li.parent_li > span').attr('title', 'Expand this branch');

            $('.tree li.parent_li > span').on('click', function(e) {
                var checkbox = $(this).find('.tree-checkbox');
                if (checkbox.length > 0) {
                    var isChecked = !checkbox.prop('checked');
                    checkbox.prop('checked', isChecked);

                    // Automatically select/deselect child checkboxes
                    var childrenCheckboxes = $(this).siblings('ul').find('.tree-checkbox');
                    childrenCheckboxes.prop('checked', isChecked);

                    // Check if all child checkboxes are unchecked
                    var allChildrenUnchecked = childrenCheckboxes.length === 0 ||
                        childrenCheckboxes.filter(':checked').length === 0;

                    // If all children are unchecked, unselect the parent as well
                    if (allChildrenUnchecked) {
                        checkbox.prop('checked', false);
                    }

                    // Check if all siblings are checked or unchecked
                    var siblings = $(this).closest('ul').find('.tree-checkbox');
                    var allSiblingsChecked = siblings.length > 0 && siblings.filter(':checked')
                        .length === siblings.length;
                    var allSiblingsUnchecked = siblings.filter(':checked').length === 0;

                    // Update parent checkboxes based on sibling checkboxes
                    var parentCheckbox = $(this).closest('ul').siblings('span').find(
                        '.tree-checkbox');
                    if (allSiblingsChecked) {
                        parentCheckbox.prop('checked', true);
                    } else if (allSiblingsUnchecked) {
                        parentCheckbox.prop('checked', false);
                    }
                }

                var children = $(this).parent('li.parent_li').find('> ul > li');
                if (children.is(':visible')) {
                    children.hide('fast');
                    $(this).attr('title', 'Expand this branch').find('> i').addClass(
                        'icon-plus-sign').removeClass('icon-minus-sign');
                } else {
                    children.show('fast');
                    $(this).attr('title', 'Collapse this branch').find('> i').addClass(
                        'icon-minus-sign').removeClass('icon-plus-sign');
                }
                e.stopPropagation();
            });

            // Handle checkbox click events
            $('.tree-checkbox').on('click', function(e) {
                e.stopPropagation(); // Prevent event propagation to parent elements
            });
        });


        $(document).ready(function() {
            // When the "Select All" checkbox is clicked
            $('#selectAll').change(function() {
                // Get the state of the "Select All" checkbox
                var isChecked = $(this).prop('checked');

                // Set all other checkboxes to the same state
                $('.form-check-input[type="checkbox"]').prop('checked', isChecked);
            });
        });



        feather.replace();





    const textarea = document.getElementById('textarea-counter');
    const charCount = document.querySelector('.char-count');

    textarea.addEventListener('input', function () {
        const textLength = this.value.length;
        charCount.textContent = textLength;

        if (textLength > 100) {
            charCount.style.color = 'red';
            charCount.innerHTML += ' <i class="bi bi-exclamation-circle"></i>';
        } else {
            charCount.style.color = 'initial';
            charCount.innerHTML = textLength;
        }
    });


    });
</script>
@endcan
