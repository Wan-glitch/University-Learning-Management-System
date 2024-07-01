@can('Update Role')
<link rel="stylesheet" href="{{ asset('css/tagify.css') }}">
<script src="{{ asset('js/Livesearch.js') }}"></script>

<div class="modal fade" id="assignRoleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 pb-5">
                <div class="text-center mb-2">
                    <h1 class="mb-1">Assign Role</h1>
                    <p>Roles you may use and assign to your users.</p>
                </div>
                <form id="addPermissionForm" action="{{ route('setting.assign_role') }}" method="post">
                    @csrf
                    <div class="col-12">
                        <label class="form-label" for="TagifyUserList">Selected Users</label>
                        <div class="tagify-wrapper">
                            <input id="TagifyUserList" name="TagifyUserList" class="form-control" value="" tabindex="-1">
                        </div>
                    </div>
                    <input type="hidden" id="TagifyUserListHidden" name="TagifyUserList">
                    <div class="col-12">
                        <label class="form-label" for="roleSelect">Roles Selection</label>
                        <select class="form-select" id="roleSelect" name="roleSelect">
                            <option value="">Select Roles</option>
                            @foreach ($ractive as $ra)
                                <option value="{{ $ra->id }}">{{ ucfirst($ra->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 text-center">
                        <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">Discard</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    // Initialize Tagify on your input element
    var input = document.querySelector('#TagifyUserList');
    var tagify = new Tagify(input, {
        duplicates: false,  // Disable duplicate tags
    });

    // When tags change, update the hidden input
    tagify.on('add', function(e) {
        updateHiddenInput();
    });

    tagify.on('remove', function(e) {
        updateHiddenInput();
    });

    function updateHiddenInput() {
        var selectedUserIds = tagify.value.map(function(tagData) {
            return tagData.label; // Use user ID from the label property
        });

        // Update the hidden input value with the selected user IDs
        document.querySelector('#TagifyUserListHidden').value = selectedUserIds.join(',');
    }
</script>
@endcan
