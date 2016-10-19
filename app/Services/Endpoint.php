<?php namespace AgreableTelemetryPlugin\Services;

class Endpoint
{
    public static function get()
    {
        $protocol = (getenv('WP_ENV') !== 'development')
            ? 'https://' : 'http://';

        $override = getenv('TELEMETRY_ENDPOINT');
        if ($override) {
            return "https://".$override;
        }
        $level = (getenv('WP_ENV') !== 'development')
            ? getenv('WP_ENV') : 'local';

        return $protocol.$level.".telemetry.report/";
    }
}
