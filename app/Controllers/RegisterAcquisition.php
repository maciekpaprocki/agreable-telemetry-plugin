<?php namespace AgreableTelemetryPlugin\Controllers;

use AgreableTelemetryPlugin\Controllers\PayloadBuilder;
use TimberPost;
use get_field;
use GuzzleHttp\Client;

class RegisterAcquisition
{
    public function __construct($telemetryData, $post)
    {
        $baseUri = "http://local.telemetry.report/";
        $this->payload = PayloadBuilder::build($telemetryData, $post);
        $this->client = new Client([
            'base_uri' => $baseUri,
            'timeout'  => 20.0
        ]);
        $this->doRegister();
    }

    public function doRegister()
    {
        $token = "LvZ7R9Oyv9IROinatzJaJyX11fkXh4AsCe1x0ats7W1hnjxUpneE5O1Zq72H";
        $response = $this->client->post(
            "api/v1/acquisitions",
            [
                'json' => $this->payload,
                'query' => ['api_token' => $token]
            ]
        );
        print_r($response->getBody());
        die;
    }
}
