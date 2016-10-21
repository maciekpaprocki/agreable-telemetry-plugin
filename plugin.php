<?php

/**
* @wordpress-plugin
* Plugin Name: Agreable Telemetry Plugin
* Plugin URI: http://github.com/shortlist-digital/agreabele-telemetry-plugin
* Description: Add Telemetry integrations to a WordPress install
* Version: 1.0.0
* Author: Jon Sherrard
* Author URI: http://twitter.com/jshez
* License: GPL2
*/

if (file_exists(__DIR__ . '/../../../../vendor/getherbert/')) {
    require_once __DIR__ . '/../../../../vendor/autoload.php';
} else {
    require_once __DIR__ . '/vendor/autoload.php';
}
if (file_exists(__DIR__ . '/../../../../vendor/getherbert/framework/bootstrap/autoload.php')) {
    require_once __DIR__ . '/../../../../vendor/getherbert/framework/bootstrap/autoload.php';
} else {
    require_once __DIR__ . '/vendor/getherbert/framework/bootstrap/autoload.php';
}

use add_action;
use TimberPost;
use AgreableWidgetService;
use AgreableTelemetryPlugin\Controllers\UpdateAcquisition;
use AgreableTelemetryPlugin\Controllers\RegisterAcquisition;
use AgreableTelemetryPlugin\Services\Endpoint;
use get_field;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;

class AgreableTelemetryPlugin
{
    public function __construct()
    {
        add_action('save_post', array($this, 'registerOrUpdateAcquisition'), 10, 3);
        add_action('admin_enqueue_scripts', array($this, 'cssOverrides'), 10, 3);
        add_filter('acf/load_field/key=telemetry_options_telemetry_default_brand_id', array($this, 'loadBrands'), 11, 3);
        add_filter('acf/load_field/key=telemetry_acquisition_brand_ids', array($this, 'loadBrands'), 10, 3);
        add_filter('acf/load_field/key=telemetry_options_telemetry_team_id', array($this, 'loadTeam'), 10, 3);
        add_filter('acf/load_field/key=telemetry_acquisition_widget_brand_ids', array($this, 'setDefaultBrands'), 10, 3);
        add_filter('timber_context', array($this, 'addConfigToContext'), 10, 1);
    }


    public function cssOverrides()
    {
        wp_add_inline_style('custom-style', ".acf-hide, th.acf-th.acf-th-text[data-key='telemetry_acqusition_competition_answers_answer_telemetry_id'] { display: none !important; }");
    }

    public function registerOrUpdateAcquisition($post_id, $post, $update)
    {
        if (wp_is_post_revision($post)) {
            return;
        }
        $post = new TimberPost($post_id);
        if ($post->status !== 'publish') {
            return;
        }
        if (($widgetIndex = $this->containsWidget($post)) !== false) {
            $widgets = $post->get_field('widgets');
            $telemetryData = $widgets[$widgetIndex];
            if (!empty($telemetryData['telemetry_id'])) {
                new UpdateAcquisition($telemetryData, $post, $widgetIndex);
            } else {
                new RegisterAcquisition($telemetryData, $post, $widgetIndex);
            }
        }
    }

    public function containsWidget($post)
    {
        if (!$widgets = $post->get_field('widgets')) {
            return;
        }
        foreach ($widgets as $index => $widget) {
            if ($widget['acf_fc_layout'] === 'telemetry_acquisition') {
                return $index;
            }
        }
        return false;
    }

    public function loadBrands($field)
    {
        $baseUri = Endpoint::get();
        $token = get_field('telemetry_api_key', 'telemetry-configuration');
        if ($token) {
            $client = new Client([
                'base_uri' => $baseUri,
                'timeout'  => 10.0
            ]);
            try {
                $response = $client->get(
                    'api/v1/team/brand',
                    [
                        'query' => ['api_token' => $token]
                    ]
                );
                $body = (string) $response->getBody();
                $responseObject = json_decode($body, true, JSON_PRETTY_PRINT);
                foreach ($responseObject['data'] as $key => $brand) {
                    $field['choices'][$brand['id']] = $brand['name'];
                }
                if ($field['type'] == 'checkbox') {
                    foreach ($responseObject['data'] as $key => $brand) {
                        array_push($field['default_value'], $brand['id']);
                    }
                }
            } catch (ServerException $exception) {
                update_field('telemetry_api_key', '', 'telemetry-configuration');
            }
        }
        return $field;
    }

    public function loadTeam($field)
    {
        $baseUri = Endpoint::get();
        $token = get_field('telemetry_api_key', 'telemetry-configuration');
        if ($token) {
            $client = new Client([
                'base_uri' => $baseUri,
                'timeout'  => 10.0
            ]);
            try {
                $response = $client->get(
                    'api/v1/team',
                    [
                        'query' => ['api_token' => $token]
                    ]
                );
                $body = (string) $response->getBody();
                $responseObject = json_decode($body, true, JSON_PRETTY_PRINT);
                foreach ($responseObject['data'] as $key => $team) {
                    $field['choices'][$team['id']] = $team['name'];
                }
            } catch (ServerException $exception) {
                update_field('telemetry_api_key', '', 'telemetry-configuration');
            }
        }
        return $field;
    }

    public function addConfigToContext($context)
    {
        $fieldData = get_field_object('telemetry_acquisition_brand_ids', 'telemetry-acquisition');
        $brands = [];
        foreach ($fieldData['value'] as $value) {
            $brand = [
                'name' => $fieldData['choices'][$value],
                'id' => $value
            ];
            array_push($brands, $brand);
        }
        $context['telemetry'] = [
            'endpoint' => Endpoint::get(),
            'brands' => $brands
        ];
        return $context;
    }

    public function setDefaultbrands($field)
    {
        $fieldData = get_field_object('telemetry_acquisition_brand_ids', 'telemetry-acquisition');
        $defaultData = get_field('telemetry_acquisition_brand_ids', 'telemetry-configuration');
        foreach ($defaultData as $index => $value) {
            $field['choices'][$value] = $fieldData['choices'][$value];
            array_push($field['default_value'], $value);
        }
        return $field;
    }
}

new AgreableTelemetryPlugin();
