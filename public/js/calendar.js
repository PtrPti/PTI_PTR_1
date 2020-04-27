document.addEventListener('DOMContentLoaded', function () {
    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendarInteraction.Draggable;

    /* initialize the external events
    -----------------------------------------------------------------*/

    var containerEl = document.getElementById('external-events-list');
    new Draggable(containerEl, {
        itemSelector: '.fc-event',
        eventData: function (eventEl) {
            return {
                title: eventEl.innerText.trim()
            }
        }
    });

    /* initialize the calendar
   -----------------------------------------------------------------*/

    var calendarEl = document.getElementById('calendar');

    var calendar = new Calendar(calendarEl, {
        plugins: ['interaction', 'dayGrid', 'timeGrid'],
        defaultView: 'dayGridMonth',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        editable: true,
        droppable: true,
        eventDurationEditable: true,
        eventReceive: function (ev) {
            ev.event.setProp('color', ev.draggedEl.dataset.color);
        },
        eventClick: function (ev) {
            ev.event.remove();
        },
        dateClick: function (day) {
            calendar.changeView("timeGridDay", day.date);
        }
    });

    calendar.render();
});

function ShowCalendar() {
    if ($('#calendarContainer').css('visibility') === 'visible') {
        $('#calendarContainer').css('visibility', 'hidden');
    }
    else {
        $('#calendarContainer').css('visibility', 'visible');
    }
}