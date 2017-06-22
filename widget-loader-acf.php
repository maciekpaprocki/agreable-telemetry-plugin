<?php

$basic_details_config = include('custom-fields/basic-details.php');
$optin_details_config = include('custom-fields/optin-details.php');
$competition_details_config = include('custom-fields/competition-details.php');
$voucher_details_config = include('custom-fields/voucher-details.php');

$competition_conditional_logic = array(
	array(
		array(
			'field' => 'telemetry_acquisition_data_to_capture',
			'operator' => '==',
			'value' => 'competition',
		),
	),
);

$voucher_conditional_logic = array(
	array(
		array(
			'field' => 'telemetry_acquisition_additional_features',
			'operator' => '==',
			'value' => 'voucher',
		),
	),
);

$optins_conditional_logic = array(
	array(
		array(
			'field' => 'telemetry_acquisition_additional_features',
			'operator' => '==',
			'value' => 'optins',
		),
	),
);


$widget_config = array(
	'key' => 'widget_telemetry_acquisition',
	// The 'name' will define the directory that the parent theme looks
	// for our plugin template in. e.g. views/widgets/promo_plugin/template.twig.
	'name' => 'telemetry_acquisition',
	'label' => 'Telemetry Acquisition',
	'display' => 'block',
	'sub_fields' => array(
		array(
			'key' => 'telemetry_acquisition_basic_details_tab',
			'label' => 'Basic Details',
			'type' => 'tab',
			'placement' => 'left',
		),
		$basic_details_config[0],
		$basic_details_config[1],
		$basic_details_config[2],
		$basic_details_config[3],
		$basic_details_config[4],
		$basic_details_config[5],
		array(
			'key' => 'telemetry_acquisition_competition_details_tab',
			'label' => 'Competition Details',
			'type' => 'tab',
			'placement' => 'left',
			'conditional_logic' => $competition_conditional_logic
		),
		$competition_details_config[0],
		$competition_details_config[1],
		$competition_details_config[2],
		array(
			'key' => 'telemetry_acquisition_optin_details_tab',
			'label' => 'Optin Details',
			'type' => 'tab',
			'placement' => 'left',
			'conditional_logic' => $optins_conditional_logic
		),
		$optin_details_config,
		array(
			'key' => 'telemetry_acquisition_voucher_details_tab',
			'label' => 'Voucher Details',
			'type' => 'tab',
			'placement' => 'left',
			'conditional_logic' => $voucher_conditional_logic
		),
		$voucher_details_config[0],
		$voucher_details_config[1],
		$voucher_details_config[2],
		$voucher_details_config[3],
		$voucher_details_config[4],
		$voucher_details_config[5],
		$voucher_details_config[6],
		$voucher_details_config[7],
		$voucher_details_config[8],
		$voucher_details_config[9],
		$voucher_details_config[10],
		array(
			'key' => 'telemetry_acquisition_terms_and_conditions_tab',
			'label' => 'Terms & Conditions',
			'type' => 'tab',
			'placement' => 'left',
		),
		array(
			'key' => 'telemetry_acquisition_terms_and_conditions_label',
			'label' => 'Terms & Conditions Label',
			'name' => 'terms_and_conditions_label',
			'type' => 'strict_wysiwyg',
			'simplify' => true,
			'no_return' => true,
			'default_value' => 'I accept the terms and conditions'
		),
		array(
			'key' => 'telemetry_acquisition_terms_and_conditions',
			'label' => 'Terms & Conditions',
			'name' => 'terms_and_conditions',
			'type' => 'strict_wysiwyg',
			'simplify' => true,
		),
		array(
			'key' => 'telemetry_acquisition_thank_you_screen_tab',
			'label' => 'Thank You Screen',
			'type' => 'tab',
			'placement' => 'left',
		),
		array(
			'key' => 'telemetry_acquisition_thank_you_screen_title',
			'label' => 'Title',
			'name' => 'thank_you_screen_title',
			'type' => 'strict_wysiwyg',
			'simplify' => true,
			'no_return' => true
		),
		array(
			'key' => 'telemetry_acquisition_thank_you_screen_body',
			'label' => 'Body text',
			'name' => 'thank_you_screen_body',
			'type' => 'strict_wysiwyg',
			'simplify' => true,
		),
		array(
			'key' => 'telemetry_acquisition_advanced_details_tab',
			'label' => 'Advanced Details',
			'name'=> 'terms_and_conditions',
			'type' => 'tab',
			'placement' => 'left',
		),
		array(
			'key' => 'telemetry_acquisition_widget_brand_ids',
			'label' => 'Customise Brand Available',
			'name' => 'brand_ids',
			'type' => 'checkbox',
			'instructions' => 'Choose which brands are available for this acquisition',
			'required' => true,
			'wrapper' => array(
				'width' => '49%',
			),
			'choices' => array(

			),
			'default_value' => array()
		),
	),
);
// echo "<pre>";
// print_r($widget_config);die;

$widget_config['content-types'] = array('post', 'partnership'); // section, article
$widget_config['content-sizes'] = array('main'); // main, main-full-bleed, sidebar
