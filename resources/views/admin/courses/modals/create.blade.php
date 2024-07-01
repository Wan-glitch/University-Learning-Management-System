<div class="modal fade" id="createCourseModal" tabindex="-1" aria-labelledby="createCourseLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCourseLabel">Create new course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Single user creation form -->
                <form id="singleUserForm" method="POST" action="{{ route('admin.courses.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Course Title</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="SelectFaculty" class="form-label">Assign Faculty</label>
                        <select id="SelectFaculty" name="faculty_id" class="form-select text-capitalize" required>
                            <option value="">Select Faculty</option>
                            @foreach ($faculties as $faculty)
                                <option value="{{ $faculty->id }}">{{ $faculty->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="TagifyUserList">Person-in-Charge</label>
                        <div class="tagify-wrapper">
                            <input id="TagifyUserList" name="TagifyUserList" class="form-control" value="" tabindex="-1">
                        </div>
                    </div>
                    <input type="hidden" id="TagifyUserListHidden" name="TagifyUserListHidden">
                    <button type="submit" class="btn btn-primary">Create Course</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />

<script>
    $(document).ready(function() {
        var input = document.querySelector('#TagifyUserList');

        function tagTemplate(tagData) {
            return `
                <tag title="${tagData.email}"
                        contenteditable='false'
                        spellcheck='false'
                        tabIndex="-1"
                        class="tagify__tag ${tagData.class ? tagData.class : ''}"
                        ${this.getAttributes(tagData)}>
                    <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
                    <div>
                        <div class='tagify__tag__avatar-wrap'>
                            <!-- Avatar can be added here -->
                        </div>
                        <span class='tagify__tag-text'>${tagData.name}</span>
                    </div>
                </tag>
            `;
        }

        function suggestionItemTemplate(tagData) {
            return `
                <div ${this.getAttributes(tagData)}
                    class='tagify__dropdown__item ${tagData.class ? tagData.class : ''}'
                    tabindex="0"
                    role="option">
                    <!-- Avatar can be added here -->
                    <strong>${tagData.name}</strong>
                     <span>(${tagData.email})</span>
                </div>
            `;
        }

        // Fetch initial suggestions using AJAX
        $.ajax({
            url: '{{ route('admin.admin-course-suggestion') }}',
            method: 'GET',
            success: function(response) {
                var suggestions = response.map(user => ({
                    value: user.id,
                    name: user.name,
                    email: user.email
                }));
                initializeTagify(suggestions);
            },
            error: function(xhr) {
                console.error('Error fetching initial suggestions:', xhr);
            }
        });

        function initializeTagify(suggestions) {
            var tagify = new Tagify(input, {
                whitelist: suggestions,
                maxTags: 1,
                dropdown: {
                    maxItems: 20,
                    classname: 'tags-look',
                    enabled: 0,
                    closeOnSelect: false
                },
                templates: {
                    tag: tagTemplate,
                    dropdownItem: suggestionItemTemplate
                }
            });

            tagify.on('add', updateHiddenInput);
            tagify.on('remove', updateHiddenInput);

            function updateHiddenInput(e) {
                var selectedUser = tagify.value[0]; // Since maxTags is 1, there should be only one item
                if (selectedUser) {
                    var selectedUserId = selectedUser.value;
                    document.querySelector('#TagifyUserListHidden').value = selectedUserId;
                    console.log('Selected User ID:', selectedUserId);
                } else {
                    document.querySelector('#TagifyUserListHidden').value = '';
                    console.log('No user selected');
                }
            }
        }
    });
</script>
