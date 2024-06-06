<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />


<style>
    .customLook {
    --tag-bg                  : #0052BF;
    --tag-hover               : #CE0078;
    --tag-text-color          : #FFF;
    --tags-border-color       : silver;
    --tag-text-color--edit    : #111;
    --tag-remove-bg           : var(--tag-hover);
    --tag-pad                 : .6em 1em;
    --tag-inset-shadow-size   : 1.4em; /* compensate for the larger --tag-pad value */
    --tag-remove-btn-color    : white;
    --tag-remove-btn-bg--hover: black;

    display: inline-block;
    min-width: 0;
    border: none;
}

.customLook .tagify__tag {
    margin-top: 0;
}

.customLook .tagify__tag>div {
    border-radius: 25px;
}

.customLook .tagify__tag:not(:only-of-type):not(.tagify__tag--editable):hover .tagify__tag-text {
    margin-inline-end: -1px;
}

/* Do not show the "remove tag" (x) button when only a single tag remains */
.customLook .tagify__tag:only-of-type .tagify__tag__removeBtn {
    display: none;
}

.customLook .tagify__tag__removeBtn {
    opacity: 0;
    transform: translateX(-100%) scale(.5);
    margin-inline: -20px 6px;
    /* very specific on purpose  */
    text-align: right;
    transition: .12s;
}

.customLook .tagify__tag:not(.tagify__tag--editable):hover .tagify__tag__removeBtn {
    transform: none;
    opacity: 1;
}

.customLook+button {
    color: #0052BF;
    font: bold 1.4em/1.65 Arial;
    border: 0;
    background: none;
    box-shadow: 0 0 0 2px inset currentColor;
    border-radius: 50%;
    width: 1.65em;
    height: 1.65em;
    cursor: pointer;
    outline: none;
    transition: .1s ease-out;
    margin: 0 0 0 5px;
    vertical-align: top;
}

.customLook+button:hover {
    box-shadow: 0 0 0 5px inset currentColor;
}

.customLook .tagify__input {
    display: none;
}
</style>
<!-- Create Announcement Modal -->
<div class="modal fade" id="createAnnouncementModal" tabindex="-1" role="dialog" aria-labelledby="createAnnouncementModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createAnnouncementModalLabel">Create Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <form id="announcementForm">
                    <div class="form-group">
                        <label for="announcementTitle">Title</label>
                        <input type="text" class="form-control" id="announcementTitle" required>
                    </div>
                    <div class="form-group">
                        <label for="announcementContent">Content</label>
                        <textarea class="form-control" id="announcementContent" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="announcementCategory">Category</label>
                        <select class="form-control" id="announcementCategory" required>
                            <option value="Bulletin">Bulletin</option>
                            <option value="Faculty">Faculty</option>
                            <option value="Reminder">Reminder</option>
                        </select>
                    </div>
                    <div class="form-group" id="userSelection" style="display: none;">
                        <label for="userTags">Users</label>
                        <input type="text" class="form-control tagify" id="userTags" placeholder="Tag users">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                      </div>


                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // generate random whilist items (for the demo)
var randomStringsArr = Array.apply(null, Array(100)).map(function () {
    return Array.apply(null, Array(~~(Math.random() * 10 + 3))).map(function () {
        return String.fromCharCode(Math.random() * (123 - 97) + 97)
    }).join('') + '@gmail.com'
})

var input = document.querySelector('.customLook'),
    button = input.nextElementSibling,
    tagify = new Tagify(input, {
        editTags: {
            keepInvalid: false, // better to auto-remove invalid tags which are in edit-mode (on blur)
        },
        // email address validation (https://stackoverflow.com/a/46181/104380)
        pattern: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
        whitelist: randomStringsArr,
        callbacks: {
            "invalid": onInvalidTag
        },
        dropdown: {
            position: 'text',
            enabled: 1 // show suggestions dropdown after 1 typed character
        }
    });  // "add new tag" action-button

button.addEventListener("click", onAddButtonClick)

function onAddButtonClick() {
    tagify.addEmptyTag()
}

function onInvalidTag(e) {
    console.log("invalid", e.detail)
}
</script>
