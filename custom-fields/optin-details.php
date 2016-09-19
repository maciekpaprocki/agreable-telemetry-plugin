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
        ),
        array(
            'key' => 'telemetry_acquisition_optin_optin_label',
            'label' => 'Label',
            'name' => 'optin_label',
            'type' => 'text',
            'placeholder' => 'Would you like to receive updates from Burger King?',
        ),
    ),
);
