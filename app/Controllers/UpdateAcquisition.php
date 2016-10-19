<?php namespace AgreableTelemetryPlugin\Controllers;

use AgreableTelemetryPlugin\Controllers\PayloadBuilder;
use AgreableTelemetryPlugin\Services\TelemetryResponseHandler;
use AgreableTelemetryPlugin\Services\WordPressMetaUpdater;
use AgreableTelemetryPlugin\Services\Endpoint;

use TimberPost;
use get_field;
use GuzzleHttp\Client;

class UpdateAcquisition
{
    public function __construct($telemetryData, $post, $index)
    {
        $this->post = $post;
        $this->index = $index;
        $this->telemetryData = $telemetryData;
        $baseUri = Endpoint::get();
        $this->payload = PayloadBuilder::build($telemetryData, $post);
        $this->client = new Client([
            'base_uri' => $baseUri,
            'timeout'  => 10.0
        ]);
        return $this->doUpdate();
    }

    public function doUpdate()
    {
        $token = get_field('telemetry_options_telemetry_api_key', 'telemetry-configuration');
        $response = $this->client->put(
            "api/v1/acquisitions",
            [
                'json' => $this->payload,
                'query' => ['api_token' => $token]
            ]
        );
        $body = (string) $response->getBody();
        $responseObject = json_decode($body, true, JSON_PRETTY_PRINT);
        $handler = new TelemetryResponseHandler($responseObject, $this->telemetryData);
        $telemetryDataToSave = $handler->getData();
        $updater = new WordPressMetaUpdater($telemetryDataToSave, $this->index, $this->post);
    }
}
