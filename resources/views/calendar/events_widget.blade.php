


<style>
    .event-details-widget {
    border-radius: 15px !important;
    overflow: hidden !important;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
    border: 2px solid #E3E3E3 !important;
    }

</style>
<div class="col-lg-4 mb-4">
    <div class="event-details-widget">
        <button class="add-new-appointment" data-bs-toggle="modal" data-bs-target="#eventModal">+ Add New Event</button>
        @include('calendar.modals.event_modal')
        <h3>You are going to</h3>
        <div id="events-list">
            <!-- Events will be populated by JavaScript -->
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
            // const tag = $('#tag').val();

            // AJAX request to create a new event
            $.ajax({
                url: '/calendar/create-event',
                method: 'POST',
                data: {
                    title: title,
                    date: date,
                    time: time,
                    color: color,
                    // tag: tag,
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
