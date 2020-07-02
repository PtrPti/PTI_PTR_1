document.addEventListener('DOMContentLoaded', function () {
    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendarInteraction.Draggable;

    /* initialize the external events
    -----------------------------------------------------------------*/

    var containerEl = document.getElementById('external-events-list');
    new Draggable(containerEl, {
        itemSelector: '.draggable',
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
        eventReceive: function (ev) { //quando recebe um external event -> create
            ev.event.setProp('color', ev.draggedEl.dataset.color);
            var end = ev.event.end == null ? null : moment(ev.event.end).format("DD-MM-YYYY HH:mm:ss");
            $.ajax({
                url: '/calendar/createEvent/' + ev.event.title + '/' + moment(ev.event.start).format("DD-MM-YYYY HH:mm:ss") + '/' + end + '/' + ev.event.allDay + '/' + $("input[name=grupo_id]").val(),
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                    ev.event.setExtendedProp('db_id', data.id);
                }
            });
        },
        eventClick: function (ev) {
            var evId = ev.event.id == "" ? ev.event.extendedProps.db_id : ev.event.id;
            $.ajax({
                url: '/calendar/deleteEvents/' + evId,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                    ev.event.remove();
                }
            });
        },
        dateClick: function (day) {
            calendar.changeView("timeGridDay", day.date);
        },
        eventDrop: function (ev) { //quando altera a data do evento -> update
            var end = ev.event.end == null ? null : moment(ev.event.end).format("DD-MM-YYYY HH:mm:ss");
            var evId = ev.event.id == "" ? ev.event.extendedProps.db_id : ev.event.id;
            $.ajax({
                url: '/calendar/updateEvents/' + evId + '/' + ev.event.title + '/' + moment(ev.event.start).format("DD-MM-YYYY HH:mm:ss") + '/' + end + '/' + ev.event.allDay,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                }
            });
        },
        eventResize: function (ev) { //quando altera a duracao do evento -> update
            var end = ev.event.end == null ? null : moment(ev.event.end).format("DD-MM-YYYY HH:mm:ss");
            var evId = ev.event.id == "" ? ev.event.extendedProps.db_id : ev.event.id;
            $.ajax({
                url: '/calendar/updateEvents/' + evId + '/' + ev.event.title + '/' + moment(ev.event.start).format("DD-MM-YYYY HH:mm:ss") + '/' + end + '/' + ev.event.allDay,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                }
            });
        },
        events: "/calendar/loadEvents/" + $("input[name=grupo_id]").val()
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