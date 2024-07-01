<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bulletin Modal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="styles.css" />
</head>
<style>
    /* styles.css */
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
    }

    .sidebar {
        background: #f7f7f7;
        padding: 20px;
        border-right: 1px solid #e0e0e0;
    }

    .bulletin-list {
        list-style: none;
        padding: 0;
    }

    .bulletin-item.active {
        background: #e0e0f0;
    }

    .bulletin-header h5 {
        margin: 0;
        font-size: 16px;
    }

    .bulletin-header small {
        display: block;
        font-size: 14px;
        color: #666;
    }


    .main-content {
        padding: 20px;
    }

    .main-content h2 {
        margin-top: 0;
    }

    .main-content p {
        margin: 10px 0;
    }

    .button-group {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 20px;
    }

    .button-group .button {
        padding: 10px 20px;
        border: 1px solid #ccc;
        border-right: none;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
        flex: 1;
        text-align: center;
        color: #4a4a4a;
    }

    .button-group .button:last-child {
        border-right: 1px solid #ccc;
    }

    .button-group .button.active {
        background-color: #ebedff;
        color: #4a4eff;
    }

    .button-group .button:first-child {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    .button-group .button:last-child {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.7);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 100% !important;
        border-radius: 8px;
    }

    .update-btn {
        background-color: #ebedff;
        color: #4a4eff;
        border-bottom-left-radius: 10px;
        border-top-left-radius: 10px;
    }

    .delete-btn {
        background-color: #fff;
        color: #ff4a4a;
        border: 1px solid #ff4a4a;

        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .modal-dialog {
        max-width: initial !important;
    }
</style>

<body>

    <!-- Trigger the modal with a button (Optional) -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#bulletinModal">
        Open Bulletin Modal
    </button>

    <!-- Modal Structure -->
    <div class="modal fade" id="bulletinModal" tabindex="-1" role="dialog" aria-labelledby="bulletinModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-fullscreen" role="document" style="max-width:initial">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bulletinModalLabel">Bulletin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">

                        <div class="row">

                            <!-- Sidebar -->
                            <div class="col-md-4 sidebar">
                                <div class="button-group">
                                    <div class="button bulletin active" onclick="openTab(event, 'Bulletin')"
                                        id="defaultOpen">Bulletin</div>
                                    <div class="button fac" onclick="openTab(event, 'Faculty')">Faculty</div>
                                    <div class="button rem" onclick="openTab(event, 'Reminder')">Reminder</div>
                                </div>
                                <ul class="list-group bulletin-list">
                                    <li class="list-group-item bulletin-item active">
                                        <div class="bulletin-header">
                                            <h5>List of courses offered in 2024</h5>
                                            <small>by User 1</small><br />
                                            <small>25 Jun 2024</small>
                                        </div>
                                        <div class="bulletin-actions" style="display:flex">
                                            <button class="btn btn-primary update-btn">Update</button>
                                            <button class="btn btn-danger delete-btn">Delete</button>
                                        </div>
                                    </li>
                                    <!-- Repeat for other items -->
                                </ul>
                                <!-- Pagination -->
                                <nav class="mt-3">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item">
                                            <a class="page-link" href="#">Previous</a>
                                        </li>
                                        <li class="page-item active">
                                            <a class="page-link" href="#">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">3</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <!-- Main Content Area -->
                            <div class="col-md-8 main-content">
                                <h2>List of courses offered in 2024</h2>
                                <p>Posted by User 1</p>
                                <p>25 Jun 2024</p>
                                <p>Dear DIT students,</p>
                                <p>
                                    Please check your academic transcript and programme
                                    structure.
                                </p>
                                <p>
                                    Fill out this form if you need to retake OOP in the coming
                                    sem:
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // script.js
        document.addEventListener("DOMContentLoaded", () => {
            const bulletinItems = document.querySelectorAll(".bulletin-item");
            const mainContent = document.querySelector(".main-content");

            bulletinItems.forEach((item) => {
                item.addEventListener("click", () => {
                    bulletinItems.forEach((b) => b.classList.remove("active"));
                    item.classList.add("active");

                    // Update main content with the selected bulletin details
                    const title = item.querySelector(".bulletin-header h5").textContent;
                    const user = item.querySelector(
                        ".bulletin-header small:first-of-type"
                    ).textContent;
                    const date = item.querySelector(
                        ".bulletin-header small:last-of-type"
                    ).textContent;

                    mainContent.innerHTML = `
                <h2>${title}</h2>
                <p>${user}</p>
                <p>${date}</p>
                <p>Dear DIT students,</p>
                <p>Please check your academic transcript and programme structure.</p>
                <p>Fill out this form if you need to retake OOP in the coming sem:</p>
            `;
                });
            });
        });
    </script>
</body>

</html>
