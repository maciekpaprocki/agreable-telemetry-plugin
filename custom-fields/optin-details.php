<?php
return array(
    'key' => 'telemetry_acquisition_optins',
    'label' => 'Optins',
    'name' => 'optins',
    'type' => 'repeater',
    'min' => 1,
    'max' => 3,
    'layout' => 'row',
    'button_label' => 'Add Optin',
    'sub_fields' => array(
        array(
            'key' => 'telemetry_acquisition_optin_optin_name',
            'label' => 'Name',
            'name' => 'optin_name',
            'type' => 'text',
            'placeholder' => 'Burger King',
			'required' => 1,
        ),
        array(
            'key' => 'telemetry_acquisition_optin_optin_label',
            'label' => 'Label',
            'name' => 'optin_label',
            'type' => 'text',
            'placeholder' => 'Would you like to receive updates from Burger King?',
			'required' => 1,
        ),
        array(
            'key' => 'telemetry_acqusition_optin_optin_telemetry_id',
            'name' => 'telemetry_id',
            'label' => 'Telemetry ID',
            'type' => 'text',
            'instructions' => 'DO NOT TOUCH, if you can see this, should be hidden',
            'wrapper' => array(
                'class' => 'acf-hide',
            ),
        ),
    ),
);
