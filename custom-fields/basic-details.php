<?php

return array(
    array(
        'key' => 'telemetry_acquisition_data_to_capture',
        'label' => 'Data to capture with email',
        'name' => 'data_to_capture',
        'type' => 'checkbox',
        'instructions' => 'Check any additional data you\'d like to capture from the user',
        'choices' => array(
            'fullName' => 'Full Name',
            'address' => 'Address',
            'telephoneNumber' => 'Telephone Number',
            'competition' => 'Competition Answer',
        ),
        'layout' => 'horizontal',
        'wrapper' => array(
            'width' => '100%',
        ),
    ),
    array(
        'key' => 'telemetry_acqusition_telemetry_id',
        'name' => 'telemetry_id',
        'label' => 'Telemetry ID',
        'type' => 'text',
        'instructions' => 'DO NOT TOUCH, if you can see this, should be hidden',
        'wrapper' => array(
            'class' => 'acf-hide',
        ),
    ),
    array(
        'key' => 'telemetry_acquisition_start_time',
        'label' => 'Start Time',
        'name' => 'start_time',
        'type' => 'date_time_picker',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '47%',
        ),
        'display_format' => 'Y-m-d H:i:s',
        'return_format' => 'Y-m-d H:i:s',
        'first_day' => 1,
    ),
    array(
        'key' => 'telemetry_acquisition_end_time',
        'label' => 'End Time',
        'name' => 'end_time',
        'type' => 'date_time_picker',
        'instructions' => '',
        'required' => 0,
        'conditional_logic'=> 0,
        'wrapper' => array(
            'width' => '47%',
        ),
        'display_format' => 'Y-m-d H:i:s',
        'return_format' => 'Y-m-d H:i:s',
        'first_day' => 1,
    ),
    array(
     'key' => 'telemetry_acquisition_additional_features',
     'label' => 'Select additional features to reveal their configuration tabs',
     'name' => 'additional_feautres',
     'type' => 'checkbox',
     'choices' => array(
         'voucher' => 'Send Voucher',
         'optins' => 'Add third party optins'
     ),
     'layout' => 'horizontal',
     'wrapper' => array(
         'width' => '100%',
     ),
   ),
);
