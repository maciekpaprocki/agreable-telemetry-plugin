export default class AgreableTelemetryCalendar {

    constructor() {
        if (!$('body').hasClass('telemetry_page_telemetry-calendar')) {
            return false;
        }

        this.insertDependencies();
    }

    insertDependencies() {
        $.getScript('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js');
        $.getScript('https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js')
            .done(() => {
                this.initialize()
            })
        ;

        let fcStyle = document.createElement('link');
        fcStyle.rel = 'stylesheet';
        fcStyle.href = 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css';
        let firstStyleTag = document.getElementsByTagName('link')[0];
        firstStyleTag.parentNode.insertBefore(fcStyle, firstStyleTag);
    }

    initialize() {
        // insert container div
        $('#acf-group_agreable_telemetry_calendar .acf-fields').append($('<div id="calendar" />'));

        $('#calendar').fullCalendar({
            events: [
                {
                    title  : 'event1',
                    start  : '2017-02-01'
                },
                {
                    title  : 'event2',
                    start  : '2017-02-05',
                    end    : '2017-02-07'
                },
                {
                    title  : 'event3',
                    start  : '2017-03-09T12:30:00',
                    allDay : false // will make the time show
                }
            ]
        });
    }

};
