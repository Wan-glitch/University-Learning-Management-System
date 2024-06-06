@extends('layout.app')

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        .calendar {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .calendar-header h2 {
            margin: 0;
            font-size: 24px;
        }

        .calendar-header .buttons {
            display: flex;
            align-items: center;
        }

        .calendar-header .buttons button {
            background-color: #696cff;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 15px;
            margin-left: 10px;
            cursor: pointer;
        }

        .calendar-header .buttons button:disabled {
            background-color: #ccc;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }

        .calendar-grid .day {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 10px;
            text-align: center;
            position: relative;
            min-height: 100px;
        }

        .calendar-grid .day span {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .calendar-grid .day.today {
            border: 2px solid #696cff;
            background-color: #f0f0ff;
        }

        .calendar-grid .event {
            background-color: #ff4081;
            color: white;
            border-radius: 8px;
            padding: 5px;
            margin-bottom: 5px;
            text-align: center;
            font-size: 12px;
        }

        .events-widget {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }

        .events-widget h3 {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .event-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .event-item img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .event-item .event-details {
            flex-grow: 1;
        }

        .event-item .event-details h4 {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
        }

        .event-item .event-details p {
            margin: 0;
            font-size: 12px;
            color: #999;
        }

        .productivity-widget {
            background-color: #333;
            color: white;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            position: relative;
        }

        .productivity-widget h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .productivity-widget .progress {
            display: flex;
            align-items: center;
        }

        .productivity-widget .progress span {
            font-size: 14px;
        }

        .productivity-widget .progress div {
            height: 6px;
            background-color: #4caf50;
            width: 100%;
            border-radius: 3px;
            margin-left: 10px;
        }

        .productivity-widget .settings {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .add-new-appointment {
            background-color: #696cff;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 25px;
            display: block;
            margin: 0 auto 20px auto;
            text-align: center;
        }

        .event-details-widget {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .event-details-widget .event-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .event-details-widget .event-item img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .event-details-widget .event-details {
            flex-grow: 1;
        }

        .event-details-widget .event-details h4 {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
        }

        .event-details-widget .event-details p {
            margin: 0;
            font-size: 12px;
            color: #999;
        }
    </style>

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="calendar">
                        <div class="calendar-header">
                            <h2 id="calendar-title"></h2>
                            <div class="buttons">
                                <button id="today-btn">Today</button>
                                <button id="prev-btn">&lt;</button>
                                <button id="next-btn">&gt;</button>
                            </div>
                        </div>
                        <div class="calendar-grid" id="calendar-grid">
                            <!-- Calendar grid will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
                @include('calendar.events-widget')
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const calendarGrid = $('#calendar-grid');
            const calendarTitle = $('#calendar-title');
            const todayBtn = $('#today-btn');
            const prevBtn = $('#prev-btn');
            const nextBtn = $('#next-btn');
            const eventsList = $('#events-list');

            let currentDate = new Date();

            function renderCalendar(date) {
                const year = date.getFullYear();
                const month = date.getMonth();
                const today = new Date();

                // Set calendar title
                calendarTitle.text(date.toLocaleString('default', {
                    month: 'long'
                }) + ' ' + year);

                // Clear previous calendar grid
                calendarGrid.empty();

                // Get first day of the month
                const firstDay = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                // Add empty slots for previous month's days
                for (let i = 0; i < firstDay; i++) {
                    calendarGrid.append('<div class="day"></div>');
                }

                // Add days of the month
                for (let day = 1; day <= daysInMonth; day++) {
                    const dayDiv = $('<div class="day"></div>');
                    dayDiv.append('<span>' + day + '</span>');

                    // Highlight today
                    if (year === today.getFullYear() && month === today.getMonth() && day === today.getDate()) {
                        dayDiv.addClass('today');
                    }

                    // Fetch events for the day
                    const fullDate = year + '-' + ('0' + (month + 1)).slice(-2) + '-' + ('0' + day).slice(-2);
                    $.ajax({
                        url: '/calendar/event',
                        method: 'GET',
                        data: {
                            date: fullDate
                        },
                        success: function(events) {
                            events.forEach(event => {
                                const eventDiv = $('<div class="event"></div>');
                                eventDiv.css('background-color', event.color);
                                eventDiv.text(event.title);
                                dayDiv.append(eventDiv);
                            });
                        }
                    });

                    calendarGrid.append(dayDiv);
                }
            }

            function renderEvents() {
                $.ajax({
                    url: '/calendar/events',
                    method: 'GET',
                    success: function(events) {
                        eventsList.empty();
                        events.forEach(event => {
                            const eventItem = $('<div class="event-item"></div>');
                            eventItem.append(
                                '<img src="https://via.placeholder.com/40" alt="Event">');
                            const eventDetails = $('<div class="event-details"></div>');
                            eventDetails.append('<h4>' + event.title + '</h4>');
                            eventDetails.append('<p>' + event.date + '</p>');
                            eventItem.append(eventDetails);
                            eventsList.append(eventItem);
                        });
                    }
                });
            }

            todayBtn.click(function() {
                currentDate = new Date();
                renderCalendar(currentDate);
                renderEvents();
            });

            prevBtn.click(function() {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar(currentDate);
                renderEvents();
            });

            nextBtn.click(function() {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar(currentDate);
                renderEvents();
            });

            renderCalendar(currentDate);
            renderEvents();
        });
    </script>
@endsection
