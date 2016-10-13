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

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/vendor/getherbert/framework/bootstrap/autoload.php';

use add_action;
use TimberPost;
use AgreableWidgetService;
use AgreableTelemetryPlugin\Controllers\UpdateAcquisition;
use AgreableTelemetryPlugin\Controllers\RegisterAcquisition;

class AgreableTelemetryPlugin
{
    public function __construct()
    {
        add_action('save_post', array($this, 'registerOrUpdateAcquisition'), 10, 3);
        add_action('admin_enqueue_scripts', array($this, 'css_overrides'), 10, 3);
    }


    public function css_overrides()
    {
        wp_add_inline_style('custom-style', ".acf-hide, th.acf-th.acf-th-text[data-key='telemetry_acqusition_compeition_answers_answer_telemetry_id'] { display: none !important; }");
    }

    public function registerOrUpdateAcquisition($post_id, $post, $update)
    {
        if (wp_is_post_revision($post)) {
            return;
        }
        $post = new TimberPost($post_id);
        if ($telemetryData = $this->containsWidget($post)) {
            if (!empty($telemetryData['telemetry_id'])) {
                new UpdateAcquisition($telemetryData, $post);
            } else {
                new RegisterAcquisition($telemetryData, $post);
            }
        }
    }

    public function containsWidget($post)
    {
        if (!$widgets = $post->get_field('widgets')) {
            return;
        }
        $matched_widgets = [];
        foreach ($widgets as $widget) {
            if ($widget['acf_fc_layout'] === 'telemetry_acquisition') {
                $matched_widgets[] = $widget;
            }
        }

        if (count($matched_widgets) === 0) {
            return null;
        } else {
            return $matched_widgets[0];
        }
    }
}

new AgreableTelemetryPlugin();
