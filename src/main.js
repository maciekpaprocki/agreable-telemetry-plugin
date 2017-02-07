window.$ = window.$ || jQuery || window.jQuery;

import AgreableTelemetryDataExport from './AgreableTelemetryDataExport';
import AgreableTelemetryCalendar from './AgreableTelemetryCalendar';

window.onload = () => {
    let exportPlugin = new AgreableTelemetryDataExport();

    let acquisitionCalendar = new AgreableTelemetryCalendar();
}
