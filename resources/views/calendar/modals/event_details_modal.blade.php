<div class="modal fade" id="eventDetailsModal" tabindex="-1" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventDetailsModalLabel">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="eventDetailsForm">
                    @csrf
                    <div class="mb-3">
                        <label for="eventTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="eventTitle" name="title" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="eventDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="eventDate" name="date" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="eventTime" class="form-label">Time</label>
                        <input type="time" class="form-control" id="eventTime" name="time" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="eventColor" class="form-label">Color</label>
                        <input type="color" class="form-control" id="eventColor" name="color" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="eventTag" class="form-label">Tag</label>
                        <input type="text" class="form-control" id="eventTag" name="tag" readonly>
                    </div>
                    <button type="button" class="btn btn-danger" id="deleteEventButton">Delete Event</button>
                </form>
            </div>
        </div>
    </div>
</div>
