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

use add_action;

class AgreableTelemetryPlugin
{
    public function __construct()
    {
        add_action('init', array($this, 'register_custom_fields'));
    }
    public function register_custom_fields()
    {
        include_once('custom-fields/options-panel.php');
    }
}
new AgreableTelemetryPlugin();
