<?php namespace AgreableTelemetryPlugin;

/** @var \Herbert\Framework\Panel $panel */

// Main menu item
acf_add_options_page(array(
	/* (string) The title displayed on the options page. Required. */
	'page_title' => 'Telemetry',
	'menu_title' => 'Telemetry',
	'menu_slug' => 'telemetry',
	'capability' => 'manage_options',
	'position' => false,
	'parent_slug' => '',
	'icon_url' => 'dashicons-chart-area',
	'redirect' => true,
	'post_id' => 'telemetry',
	'autoload' => false,
));

// Configuration options
acf_add_options_page(array(
	/* (string) The title displayed on the options page. Required. */
	'page_title' => 'Telemetry Configuration',
	'menu_title' => 'Configuration',
	'menu_slug' => 'telemetry-configuration',
	'capability' => 'manage_options',
	'position' => false,
	'parent_slug' => 'telemetry',
	'icon_url' => '',
	'redirect' => true,
	'post_id' => 'telemetry-configuration',
	'autoload' => false,
));

// Acquisitions calender
acf_add_options_page(array(
	/* (string) The title displayed on the options page. Required. */
	'page_title' => 'Telemetry Calendar',
	'menu_title' => 'Calendar',
	'menu_slug' => 'telemetry-calendar',
	'capability' => 'publish_posts',
	'position' => false,
	'parent_slug' => 'telemetry',
	'icon_url' => '',
	'redirect' => true,
	'post_id' => 'telemetry-calendar',
	'autoload' => false,
));

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
        array(
            'key' => 'telemetry_options_telemetry_team_id',
            'label' => 'Team ID',
            'name' => 'telemetry_team_id',
            'type' => 'select',
            'instructions' => 'The default Telemetry Team ID for this site.',
            'wrapper' => array(
                'width' => '49%',
            ),
            'choices' => array(

            )
        ),
        array(
            'key' => 'telemetry_acquisition_brand_ids',
            'label' => 'Customise Brand Available',
            'name' => 'brand_ids',
            'type' => 'checkbox',
            'instructions' => 'Choose which brands are available for this site',
            'wrapper' => array(
                'width' => '49%',
            ),
            'choices' => array(

            ),
            'default_value' => array()
        ),
        array(
            'key' => 'telemetry_acquisition_thank_you_screen_title_default',
            'label' => 'Thank You Screen Default Title',
            'name' => 'thank_you_screen_title_deafault',
            'type' => 'strict_wysiwyg',
            'simplify' => true,
            'no_return' => true
        ),
        array(
            'key' => 'telemetry_acquisition_thank_you_screen_body_default',
            'label' => 'Thank You Screen Default Body Text',
            'name' => 'thank_you_screen_body_default',
            'type' => 'strict_wysiwyg',
            'simplify' => true,
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

acf_add_local_field_group(array(
    'key' => 'group_agreable_telemetry_calendar',
    'title' => 'Acquisitions Calendar',
    'fields' => array(),
    'location' => array(
        array(
            array(
        		'param' => 'options_page',
                'operator' => '==',
                'value' => 'telemetry-calendar',
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
