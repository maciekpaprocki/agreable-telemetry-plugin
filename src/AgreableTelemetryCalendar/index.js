import randomColor from 'randomcolor';

export default class AgreableTelemetryCalendar {

    constructor() {
        if (!$('body').hasClass('telemetry_page_telemetry-calendar')) {
            return false;
        }

        this.insertDependencies();
    }

    insertDependencies() {
        let fcStyle = document.createElement('link');
        fcStyle.rel = 'stylesheet';
        fcStyle.href = 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css';
        let firstStyleTag = document.getElementsByTagName('link')[0];
        firstStyleTag.parentNode.insertBefore(fcStyle, firstStyleTag);

        // add sweet alert to page as it's not an npm package
        $.getScript('https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.2/sweetalert.min.js');
        let saStyle = document.createElement('link');
        saStyle.rel = 'stylesheet';
        saStyle.href = 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css';
        firstStyleTag.parentNode.insertBefore(saStyle, firstStyleTag);

        this.initialize();
    }

    initialize() {
        // insert container div
        $('#acf-group_agreable_telemetry_calendar .acf-fields').append($('<div id="calendar" />'));

        this.initCalendar();
    }

    refreshData(view, element) {
        let currentDate = $('#calendar').fullCalendar('getDate').format('YYYY-MM-DD');
        let start = moment(currentDate).subtract(1, 'months').date(1).format('YYYY-MM-DD');
        let end = moment(currentDate).add(2, 'months').date(0).format('YYYY-MM-DD');

        $.ajax({
            url: telemetry_config.endpoint + '/api/v1/team/' + telemetry_config.team_id + '/acquisitions?api_token=' + telemetry_config.token + '&start=' + start + '&end=' + end,
            success: (data) => {
                data.acquisitions.map((acquisition) => {
                    acquisition['backgroundColor'] = randomColor({
                        luminosity: 'dark',
                        seed: acquisition.title
                    });
                });
                $('#calendar').fullCalendar('renderEvents', data.acquisitions);
            }
        });
    }

    initCalendar(/*data*/) {
        $('#calendar').fullCalendar({
            // events: data,
            eventClick: (calEvent) => {
                this.getAcquisitionInformation(calEvent.id);
            },
            viewRender: (view, element) => {
                this.refreshData(view, element);
            }
        });
    }

    getAcquisitionInformation(id) {
        $.ajax({
            url: telemetry_config.endpoint + '/api/v1/acquisitions/' + id + '/promotion/metadata?api_token=' + telemetry_config.token,
            success: (data) => {
                sweetAlert({
                    title: '<span style="color:#000">' + data.title + '</span>',
                    text: '<ul style="color:#000;text-align:left;">'
                        + '<li><b>URL:</b> <a href="' + data.url + '">' + data.url + '</a></li>'
                        + '<li><b>Entries:</b> ' + data.totalEntries + '</li>'
                        + (data.corrects ? '<li><b>Correct entries:</b> ' + data.corrects + '</li>' : '')
                        + '<li><b>New subscribers:</b> ' + data.newSubscribers + '</li>'
                        + '</ul>',
                    html: true,
                    type: 'info'
                });
            },
            error: () => {
                sweetAlert({
                    title: '<span style="color:#000">There was a problem getting the data for this promotion</span>',
                    text: '<p style="color:#000">Something went a bit wrong, but we\'re not sure what. Drop us an email at <a href="mailto:jon.sherrard@shortlist.com">jon.sherrard@shortlist.com</a> and we\'ll take a look into it for you.</p>',
                    html: true,
                    type: 'error'
                });
            }
        });
    }

};
