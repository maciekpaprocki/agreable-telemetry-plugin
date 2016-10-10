<?php namespace AgreableTelemetryPlugin\Controllers;

use TimberPost;
use get_field;

class UpdateAcquisition
{
    public function __construct($telemetryData)
    {
        echo "<h1>Update</h1>";
        echo "<pre>";
        print_r($telemetryData);
        die;
    }
}
