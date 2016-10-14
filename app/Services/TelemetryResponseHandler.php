<?php namespace AgreableTelemetryPlugin\Services;

class TelemetryResponseHandler
{
    public function __construct($responseObject, $telemetryData)
    {
        $this->response = $responseObject;
        $this->telemetryData = $telemetryData;
        if ($this->response['status'] == 200) {
            return $this->mergeData($responseObject['data'], $telemetryData);
        } else {
            echo "<h1>Unsuccessful response</h1>";
            echo "<pre>";
            print_r($$his->response);
            die;
        }
    }

    public function mergeData($responseData, $telemetryData)
    {
        //Set telemetry ID
        echo "<pre>";
        print_r($telemetryData);
        die;
        $telemetryData['id'] = $responseData['acquisition_id'];
    }
}
