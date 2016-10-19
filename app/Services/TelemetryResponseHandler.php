<?php namespace AgreableTelemetryPlugin\Services;

class TelemetryResponseHandler
{
    public function __construct($responseObject, $telemetryData)
    {
        $this->response = $responseObject;
        $this->telemetryData = $telemetryData;
        if ($this->response['status'] == 200) {
            $this->dataToSave = $this->mergeData($responseObject['data'], $telemetryData);
        } else {
            echo "<h1>Unsuccessful response</h1>";
            echo "<pre>";
            print_r($this->response);
            die;
        }
    }

    public function getdata()
    {
        return $this->dataToSave;
    }

    public function mergeData($responseData, $telemetryData)
    {
        //Set telemetry ID
        $telemetryData['telemetry_id'] = $responseData['acquisition_id'];
        if ($responseData['promotion'] && $responseData['promotion']['id']) {
            $telemetryData['promotion_telemetry_id'] = $responseData['promotion']['id'];
        }
        if ($responseData['promotion'] && $responseData['promotion']['competition']) {
            $telemetryData['competition_telemetry_id'] = $responseData['promotion']['competition']['id'];
            foreach ($telemetryData['competition_answers'] as $index => &$answer) {
                $answer['telemetry_id'] = $responseData['promotion']['competition']['answers'][$index]['id'];
            }
        }
        if ($responseData['optins']) {
            foreach ($telemetryData['optins'] as $index => &$optin) {
                $optin['telemetry_id'] = $responseData['optins'][$index]['id'];
            }
        }
        return $telemetryData;
    }
}
