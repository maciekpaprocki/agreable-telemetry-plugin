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

class AgreableTelemetryPlugin
{
    public function __construct()
    {
        add_action('save_post', array($this, 'registerOrUpdateAcquisition'));
    }

    public function registerOrUpdateAcquisition()
    {
    }
}

new AgreableTelemetryPlugin();
