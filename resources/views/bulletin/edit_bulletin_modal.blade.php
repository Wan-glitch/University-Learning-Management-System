<!-- Edit Bulletin Modal -->
<div class="modal fade" id="editBulletinModal" tabindex="-1" role="dialog" aria-labelledby="editBulletinModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBulletinModalLabel">Edit Bulletin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBulletinForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="content">Content:</label>
                        <textarea name="content" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="category">Category:</label>
                        <select name="category" class="form-control" required>
                            <option value="Bulletin">Bulletin</option>
                            <option value="Faculty">Faculty</option>
                            <option value="Reminder">Reminder</option>
                        </select>
                    </div>
                    <div class="form-group" id="edit_faculty_id_group" style="display: none;">
                        <label for="faculty_id">Faculty:</label>
                        <select name="faculty_id" class="form-control">
                            @foreach($faculties as $faculty)
                                <option value="{{ $faculty->id }}">{{ $faculty->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="edit_recipients_group" style="display: none;">
                        <label for="recipients">Recipients:</label>
                        <input name='recipients[]' placeholder='Select recipients' class='form-control tagify' data-blacklist='[]'>
                    </div>
                    <div class="form-group">
                        <label for="files">Upload Files:</label>
                        <input type="file" name="files[]" class="form-control" multiple>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Bulletin</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('select[name="category"]').on('change', function () {
            var category = $(this).val();
            if (category === 'Faculty') {
                $('#edit_faculty_id_group').show();
                $('#edit_recipients_group').hide();
            } else if (category === 'Reminder') {
                $('#edit_faculty_id_group').hide();
                $('#edit_recipients_group').show();
            } else {
                $('#edit_faculty_id_group').hide();
                $('#edit_recipients_group').hide();
            }
        });

        var input = document.querySelector('input[name=recipients[]]');
        new Tagify(input, {
            whitelist: @json($users->pluck('name')),
            dropdown: {
                maxItems: 20,
                classname: "tags-look",
                enabled: 0,
                closeOnSelect: false
            }
        });
    });

    function loadEditBulletin(bulletin) {
        $('#editBulletinForm').attr('action', '/bulletins/' + bulletin.id);
        $('#editBulletinForm input[name=title]').val(bulletin.title);
        $('#editBulletinForm textarea[name=content]').val(bulletin.content);
        $('#editBulletinForm select[name=category]').val(bulletin.category).change();
        $('#editBulletinForm select[name=faculty_id]').val(bulletin.faculty_id);
        var tagifyInput = new Tagify(document.querySelector('#editBulletinForm input[name="recipients[]"]'));
        tagifyInput.removeAllTags();
        tagifyInput.addTags(bulletin.users.map(user => user.name));
        $('#editBulletinModal').modal('show');
    }
</script>
