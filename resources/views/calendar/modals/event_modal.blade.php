
<style>
:root {
    --tagify-dd-item-pad: .5em .7em;
}

.tagify__dropdown.users-list .tagify__dropdown__item {
    display: grid;
    grid-template-columns: auto 1fr;
    gap: 0 1em;
    grid-template-areas: "avatar name"
                         "avatar email";
}

.tagify__dropdown.users-list header.tagify__dropdown__item {
    grid-template-areas: "add remove-tags"
                         "remaining .";
}

.tagify__dropdown.users-list .tagify__dropdown__item:hover .tagify__dropdown__item__avatar-wrap {
    transform: scale(1.2);
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

.tagify__dropdown.users-list header.tagify__dropdown__item>div,
.tagify__dropdown.users-list .tagify__dropdown__item strong {
    grid-area: name;
    width: 100%;
    align-self: center;
}

.tagify__dropdown.users-list span {
    grid-area: email;
    width: 100%;
    font-size: .9em;
    opacity: .6;
}

.tagify__dropdown.users-list .tagify__dropdown__item__addAll {
    border-bottom: 1px solid #DDD;
    gap: 0;
}

.tagify__dropdown.users-list .remove-all-tags {
    grid-area: remove-tags;
    justify-self: self-end;
    font-size: .8em;
    padding: .2em .3em;
    border-radius: 3px;
    user-select: none;
}

.tagify__dropdown.users-list .remove-all-tags:hover {
    color: white;
    background: salmon;
}


/* Tags items */
.users-list .tagify__tag {
    white-space: nowrap;
}

.users-list .tagify__tag img {
    width: 100%;
    vertical-align: top;
    pointer-events: none;
}


.users-list .tagify__tag:hover .tagify__tag__avatar-wrap {
    transform: scale(1.6) translateX(-10%);
}

.users-list .tagify__tag .tagify__tag__avatar-wrap {
    width: 16px;
    height: 16px;
    white-space: normal;
    border-radius: 50%;
    background: silver;
    margin-right: 5px;
    transition: .12s ease-out;
}

.users-list .tagify__dropdown__itemsGroup:empty {
    display: none;
}

.users-list .tagify__dropdown__itemsGroup::before {
    content: attr(data-title);
    display: inline-block;
    font-size: .9em;
    padding: 4px 6px;
    margin: var(--tagify-dd-item-pad);
    font-style: italic;
    border-radius: 4px;
    background: #00ce8d;
    color: white;
    font-weight: 600;
}

.users-list .tagify__dropdown__itemsGroup:not(:first-of-type) {
    border-top: 1px solid #DDD;
}


</style>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/nano.min.css"/> <!-- 'nano' theme -->

<!-- Modern or es5 bundle -->
<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.es5.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>

<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Add New Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUsersForm" action="{{ route('calendar.store') }}" method="POST">
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
                            <input id="TagifyUserList" name="users-list-tags" class="users-list form-control" value="">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="color" class="form-label">Color</label>
                        <div id="color-picker"></div>
                        <input type="hidden" id="color" name="color" required>
                    </div>
                    <input type="hidden" id="TagifyUserListHidden" name="TagifyUserListHidden">
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const pickr = Pickr.create({
            el: '#color-picker',
            theme: 'nano', // or 'monolith', or 'classic'
            default: '#42445a',

            components: {
                // Main components
                preview: true,
                opacity: true,
                hue: true,

                // Input / output Options
                interaction: {
                    hex: true,
                    rgba: true,
                    hsla: true,
                    hsva: true,
                    cmyk: true,
                    input: true,
                    clear: true,
                    save: true
                }
            }
        });

        pickr.on('change', (color, instance) => {
            const rgbaColor = color.toRGBA().toString();
            document.getElementById('color').value = rgbaColor;
        });

        pickr.on('save', (color, instance) => {
            const rgbaColor = color.toRGBA().toString();
            document.getElementById('color').value = rgbaColor;
            pickr.hide();
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        var inputElm = document.querySelector('input[name=users-list-tags]');

        function tagTemplate(tagData) {
            return `
                <tag title="${tagData.email}"
                        contenteditable='false'
                        spellcheck='false'
                        tabIndex="-1"
                        class="tagify__tag ${tagData.class ? tagData.class : ""}"
                        ${this.getAttributes(tagData)}>
                    <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
                    <div>
                        <div class='tagify__tag__avatar-wrap'>
                            <img onerror="this.style.visibility='hidden'" src="${tagData.avatar}">
                        </div>
                        <span class='tagify__tag-text'>${tagData.name}</span>
                    </div>
                </tag>
            `
        }



        function suggestionItemTemplate(tagData) {
            return `
                <div ${this.getAttributes(tagData)}
                    class='tagify__dropdown__item ${tagData.class ? tagData.class : ""}'
                    tabindex="0"
                    role="option">
                    ${tagData.avatar ? `
                        <div class='tagify__dropdown__item__avatar-wrap'>
                            <img onerror="this.style.visibility='hidden'" src="${tagData.avatar}">
                        </div>` : ''
                    }
                    <strong>${tagData.name}</strong>
                    <span>${tagData.email}</span>
                </div>
            `
        }

        function dropdownHeaderTemplate(suggestions) {
            return `
                <header data-selector='tagify-suggestions-header' class="${this.settings.classNames.dropdownItem} ${this.settings.classNames.dropdownItem}__addAll">
                    <strong style='grid-area: add'>${this.value.length ? `Add Remaining` : 'Add All'}</strong>
                    <span style='grid-area: remaining'>${suggestions.length} members</span>
                    <a class='remove-all-tags'>Remove all</a>
                </header>
            `
        }


        var tagify = new Tagify(inputElm, {
            tagTextProp: 'name', // very important since a custom template is used with this property as text
            skipInvalid: true, // do not temporarily add invalid tags
            dropdown: {
                closeOnSelect: false,
                enabled: 0,
                classname: 'users-list',
                searchKeys: ['name', 'email']  // very important to set by which keys to search for suggestions when typing
            },
            templates: {
                tag: tagTemplate,
                dropdownItem: suggestionItemTemplate,
                dropdownHeader: dropdownHeaderTemplate
            },
            whitelist: [
                @foreach($UserList as $user)
                    {
                        "value": {{ $user->id }},
                        "name": "{{ $user->name }}",

                        "avatar": "{{$user->profile_photo_url}}",
                        "email": "{{ $user->email }}",
                        "team": "{{ $user->HasFaculty->title }}"
                    },


                @endforeach
            ],
            transformTag: (tagData, originalData) => {
                var { name, email } = parseFullValue(tagData.name)
                tagData.name = name
                tagData.email = email || tagData.email
            },
            validate({ name, email }) {
                // when editing a tag, there will only be the "name" property which contains name + email (see 'transformTag' above)
                if (!email && name) {
                    var parsed = parseFullValue(name)
                    name = parsed.name
                    email = parsed.email
                }

                if (!name) return "Missing name"
                if (!validateEmail(email)) return "Invalid email"

                return true
            }
        });


        // Handle form submission
        document.querySelector('#addUsersForm').addEventListener('submit', function(e) {
            // Get the selected student IDs
            var selectedStudents = tagify.value.map(item => item.value);

            // Set the selected IDs in a hidden input
            var hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'TagifyUserList';
            hiddenInput.value = JSON.stringify(selectedStudents);

            this.appendChild(hiddenInput);
        });

        // attach events listeners
        tagify.on('dropdown:select', onSelectSuggestion) // allows selecting all the suggested (whitelist) items
              .on('edit:start', onEditStart)  // show custom text in the tag while in edit-mode

        function onSelectSuggestion(e) {
            if (e.detail.event.target.matches('.remove-all-tags')) {
                tagify.removeAllTags()
            }

            // custom class from "dropdownHeaderTemplate"
            else if (e.detail.elm.classList.contains(`${tagify.settings.classNames.dropdownItem}__addAll`))
                tagify.dropdown.selectAll();
        }

        function onEditStart({ detail: { tag, data } }) {
            tagify.setTagTextNode(tag, `${data.name} <${data.email}>`)
        }


        // The below code is printed as escaped, so please copy this function from:
        // https://github.com/yairEO/tagify/blob/master/src/parts/helpers.js#L89-L97
        function escapeHTML(s) {
            return typeof s == 'string' ? s
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/`|'/g, "&#039;")
                : s;
        }


        // The below part is only if you want to split the users into groups, when rendering the suggestions list dropdown:
        // (since each user also has a 'team' property)
        tagify.dropdown.createListHTML = suggestionsList => {
            const teamsOfUsers = suggestionsList.reduce((acc, suggestion) => {
                const team = suggestion.team || 'Not Assigned';

                if (!acc[team])
                    acc[team] = [suggestion]
                else
                    acc[team].push(suggestion)

                return acc
            }, {})

            const getUsersSuggestionsHTML = teamUsers => teamUsers.map((suggestion, idx) => {
                if (typeof suggestion == 'string' || typeof suggestion == 'number')
                    suggestion = { value: suggestion }

                var value = tagify.dropdown.getMappedValue.call(tagify, suggestion)

                suggestion.value = value && typeof value == 'string' ? escapeHTML(value) : value

                return tagify.settings.templates.dropdownItem.apply(tagify, [suggestion]);
            }).join("")

            // assign the user to a group
            return Object.entries(teamsOfUsers).map(([team, teamUsers]) => {
                return `<div class="tagify__dropdown__itemsGroup" data-title="Faculty ${team}:">${getUsersSuggestionsHTML(teamUsers)}</div>`
            }).join("")
        }


        // https://stackoverflow.com/a/9204568/104380
        function validateEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)
        }

        function parseFullValue(value) {
            // https://stackoverflow.com/a/11592042/104380
            var parts = value.split(/<(.*?)>/g),
                name = parts[0].trim(),
                email = parts[1]?.replace(/<(.*?)>/g, '').trim();

            return { name, email }
        }
    });



</script>
