<!-- resources/views/calendar/modals/event_modal.blade.php -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Add New Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('calendar.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="time" class="form-label">Time</label>
                        <input type="time" class="form-control" id="time" name="time" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="TagifyUserList">Add guests</label>
                        <div class="tagify-wrapper">
                            <input id="TagifyUserList" name="TagifyUserList" class="form-control" value="" tabindex="-1">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Color</label>
                        <input type="color" class="form-control" id="color" name="color" required>
                    </div>
                    <input type="hidden" id="TagifyUserListHidden" name="TagifyUserListHidden">
                    <button type="submit" class="btn btn-primary">Create</button>
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
                    <strong>${tagData.name} </strong>
                    <span>(${tagData.email})</span>
                </div>
            `;
        }

        // Fetch initial suggestions using AJAX
        $.ajax({
            url: '{{ route('get-initial-suggestions') }}',
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
                maxTags: 20,
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

            function updateHiddenInput() {
                var selectedUsers = tagify.value.map(function(tagData) {
                    return tagData.value; // Use user ID from the value property
                });

                // Update the hidden input value with the selected user IDs
                document.querySelector('#TagifyUserListHidden').value = selectedUsers.join(',');
            }

            // Fetch dynamic suggestions based on user input
            input.addEventListener('input', function(e) {
                const query = e.target.value.trim();
                if (query) {
                    $.ajax({
                        url: '{{ route('get-user') }}',
                        method: 'GET',
                        data: { query: query },
                        success: function(response) {
                            var suggestions = response.map(user => ({
                                value: user.id,
                                name: user.name,
                                email: user.email,
                                // avatar: `path_to_avatar/${user.id}.jpg`, // Uncomment and modify this line when avatars are available
                            }));
                            tagify.settings.whitelist = suggestions;
                            tagify.dropdown.show.call(tagify, query); // show the suggestions dropdown
                        },
                        error: function(xhr) {
                            console.error('Error fetching user suggestions:', xhr);
                        }
                    });
                }
            });
        }
    });
</script>
