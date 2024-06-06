<!-- resources/views/calendar/create-event-modal.blade.php -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="eventModalLabel">Create New Event</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="eventForm">
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
              <label for="date">Date</label>
              <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="form-group">
              <label for="time">Time</label>
              <input type="time" class="form-control" id="time" name="time" required>
            </div>
            <div class="form-group">
              <label for="color">Color</label>
              <input type="color" class="form-control" id="color" name="color" required>
            </div>
            <div class="form-group">
              <label for="tag">Tag User</label>
              <input type="text" class="form-control" id="tag" name="tag">
            </div>
            <button type="submit" class="btn btn-primary">Add Event</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
