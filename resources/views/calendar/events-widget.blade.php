<!-- events_widget.blade.php -->
<div class="col-lg-4 mb-4">

    <div class="event-details-widget">
        <button class="add-new-appointment">+ Add New Event</button>
        @include('calendar.modals.event-modal')
        <h3>You are going to</h3>
        <div class="event-item">
            <img src="https://via.placeholder.com/40" alt="Event">
            <div class="event-details">
                <h4>Final Year Exam 1</h4>
                <p>16 October 2019 at 5:00 PM</p>
            </div>
        </div>
        <div class="event-item">
            <img src="https://via.placeholder.com/40" alt="Event">
            <div class="event-details">
                <h4>Meeting with Mr. Smith and others</h4>
                <p>16 October 2019 at 5:00 PM - Online meeting</p>
                <div>
                    <img src="https://via.placeholder.com/40" alt="Person" style="width: 20px; height: 20px;">
                    <img src="https://via.placeholder.com/40" alt="Person" style="width: 20px; height: 20px;">
                    <img src="https://via.placeholder.com/40" alt="Person" style="width: 20px; height: 20px;">
                    <span>14+</span>
                </div>
            </div>
        </div>
        <button class="add-new-appointment">See More</button>
    </div>
</div>

<script>
    $(document).ready(function() {
        const form = $('#eventForm');

        // Open the modal when the button is clicked
        $('.add-new-appointment').click(function() {
            $('#eventModal').modal('show');
        });

        // Handle form submission
        form.submit(function(event) {
            event.preventDefault();

            const title = $('#title').val();
            const date = $('#date').val();
            const time = $('#time').val();
            const color = $('#color').val();
            const tag = $('#tag').val();

            // AJAX request to create a new event
            $.ajax({
                url: '/calendar/create-event',
                method: 'POST',
                data: {
                    title: title,
                    date: date,
                    time: time,
                    color: color,
                    tag: tag,
                    _token: '{{ csrf_token() }}' // Laravel CSRF token
                },
                success: function(response) {
                    alert('Event created successfully!');
                    $('#eventModal').modal('hide');
                    form[0].reset();
                    renderCalendar(new Date(date)); // Update calendar to highlight the new event
                    renderEvents(); // Update the events list
                },
                error: function(error) {
                    alert('Error creating event. Please try again.');
                }
            });
        });
    });
    </script>
