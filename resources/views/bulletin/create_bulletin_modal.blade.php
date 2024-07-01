
<!-- Create Bulletin Modal -->
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>

<style>
    /* Suggestions and tags styling for Tagify */
    :root {
        --tagify-dd-item-pad: .5em .7em;
    }
    .tagify__dropdown.users-list .tagify__dropdown__item {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 0 1em;
        grid-template-areas: "avatar name" "avatar email";
    }
    .tagify__dropdown.users-list .tagify__dropdown__item__avatar-wrap {
        grid-area: avatar;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        overflow: hidden;
        background: #EEE;
        transition: .1s ease-out;
    }
    .tagify__dropdown.users-list img {
        width: 100%;
        vertical-align: top;
    }
    .tagify__dropdown.users-list .tagify__dropdown__item__addAll {
        border-bottom: 1px solid #DDD;
        gap: 0;
    }
    .users-list .tagify__tag .tagify__tag__avatar-wrap {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: silver;
        margin-right: 5px;
        transition: .12s ease-out;
    }
</style>


<div class="modal fade" id="createBulletinModal" tabindex="-1" role="dialog" aria-labelledby="createBulletinModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createBulletinModalLabel">Create Bulletin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createBulletinForm" action="{{ route('bulletins.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" id="category" name="category" required>
                            <option value="Bulletin">Bulletin</option>
                            <option value="Faculty">Faculty</option>
                            <option value="Reminder">Reminder</option>
                        </select>
                    </div>
                    <div class="form-group" id="faculty_id_group" style="display: none;">
                        <label for="faculty_id">Faculty</label>
                        <select class="form-control" id="faculty_id" name="faculty_id">
                            <option selected disabled>Choose Faculty</option>
                            @foreach($faculties as $faculty)
                                <option value="{{ $faculty->id }}">{{ $faculty->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="recipients_group" style="display: none;">
                        <label for="recipients">Recipients</label>
                        <select class="form-control" id="recipients" name="recipients[]" multiple>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="attachments">Attachments</label>
                        <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Bulletin</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.tiny.cloud/1/5yc3pzzvtzt1jtr3njpjcuif9i0swn4zrkndnu3sxmdanqit/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate mentions tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss markdown',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
    });

    $(document).ready(function() {
        $('#category').on('change', function() {
            var category = $(this).val();
            switch(category) {
                case 'Faculty':
                    $('#faculty_id_group').show();
                    $('#recipients_group').hide();
                    break;
                case 'Reminder':
                    $('#faculty_id_group').hide();
                    $('#recipients_group').show();
                    break;
                default:
                    $('#faculty_id_group').hide();
                    $('#recipients_group').hide();
                    break;
            }
        });

        $('#createBulletinForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission
            tinymce.triggerSave(); // Synchronize the content

            if (tinymce.get('content').getContent() === '') {
                alert('The content field is required.');
                return;
            }

            var formData = new FormData(this);
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('Success:', response);
                    window.location.reload();
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        });
    });
</script>
