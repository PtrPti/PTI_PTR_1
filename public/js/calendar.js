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
                url: '/projetosAluno/createEvent/' + ev.event.title + '/' + moment(ev.event.start).format("DD-MM-YYYY HH:mm:ss") + '/' + end + '/' + ev.event.allDay + '/' + $("input[name=grupoId]").val(),
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                    // console.log('received_ajax')
                }
            });
        },
        eventClick: function (ev) {
            $.ajax({
                url: '/projetosAluno/deleteEvents/' + ev.event.id,
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
            $.ajax({
                url: '/projetosAluno/updateEvents/' + ev.event.id + '/' + ev.event.title + '/' + moment(ev.event.start).format("DD-MM-YYYY HH:mm:ss") + '/' + end + '/' + ev.event.allDay,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                    // console.log('updated')
                }
            });
        },
        eventResize: function (ev) { //quando altera a data do evento -> update
            var end = ev.event.end == null ? null : moment(ev.event.end).format("DD-MM-YYYY HH:mm:ss");
            $.ajax({
                url: '/projetosAluno/updateEvents/' + ev.event.id + '/' + ev.event.title + '/' + moment(ev.event.start).format("DD-MM-YYYY HH:mm:ss") + '/' + end + '/' + ev.event.allDay,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                    // console.log('updated')
                }
            });
        },
        events: "/projetosAluno/loadEvents/" + $("input[name=grupoId]").val()
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