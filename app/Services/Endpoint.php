<?php namespace AgreableTelemetryPlugin\Services;

class Endpoint
{
    public static function get()
    {
        $override = getenv('TELEMETRY_ENDPOINT');
        if ($override) {
            return $override;
        }
        return "https://staging.telemetry.report/";
    }
}
