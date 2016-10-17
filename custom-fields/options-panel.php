<?php namespace AgreableTelemetryPlugin;

/** @var \Herbert\Framework\Panel $panel */

$args = array(
  /* (string) The title displayed on the options page. Required. */
  'page_title' => 'Telemetry Configuration',
  'menu_title' => 'Telemetry',
  'menu_slug' => 'telemetry-configuration',
  'capability' => 'manage_options',
  'position' => false,
  'parent_slug' => '',
  'icon_url' => 'dashicons-chart-area',
  'redirect' => true,
  'post_id' => 'telemetry-configuration',
  'autoload' => false,
);

acf_add_options_page($args);

if (function_exists('acf_add_local_field_group')):

acf_add_local_field_group(array(
    'key' => 'group_agreable_telemetry_configuration',
    'title' => 'Telemetry Configurations',
    'fields' => array(
        array(
            'key' => 'telemetry_options_telemetry_api_key',
            'label' => 'Telemetry API Key',
            'name' => 'telemetry_api_key',
            'type' => 'text',
            'instructions' => 'The Telemetry API key for this top level account/team',
            'placeholder' => 'ABCDEFGHI123456789',
            'wrapper' => array(
                'width' => '49%',
            ),
        ),
        array(
            'key' => 'telemetry_options_telemetry_default_brand_id',
            'label' => 'Default Brand ID',
            'name' => 'telemetry_default_brand_id',
            'type' => 'select',
            'instructions' => 'The default Telemetry Brand ID for this site.',
            'wrapper' => array(
                'width' => '49%',
            ),
            'choices' => array(

            )
        ),
    ),
    'location' => array(
        array(
            array(
        'param' => 'options_page',
                'operator' => '==',
                'value' => 'telemetry-configuration',
            ),
        ),
    ),
    'menu_order' => 11,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
));

endif;
