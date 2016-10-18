<?php namespace AgreableTelemetryPlugin\Services;

class Endpoint
{
    public static function get()
    {
        $override = getenv('TELEMETRY_ENDPOINT');
        if ($override) {
            return $override;
        }
        $level = (getenv('WP_ENV') !== 'development')
            ? getenv('WP_ENV') : 'local';
        $protocol = (getenv('WP_ENV') !== 'development')
            ? 'https://' : 'http://';
        return $protocol.$level.".telemetry.report/";
    }
}
