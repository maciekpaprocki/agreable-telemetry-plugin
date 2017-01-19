<?php

return array(
	array(
		'key' => 'telemetry_acquisition_voucher_telemetry_id',
		'label' => 'Telemetry ID',
		'name' => 'voucher_telemetry_id',
		'type' => 'text',
		'instructions' => 'DO NOT TOUCH, if you can see this, should be hidden',
		'wrapper' => array(
			'width' => '0%',
			'class' => 'acf-hide',
		),
	),
	array(
		'key' => 'telemetry_acquisition_voucher_template_name',
		'label' => 'Template',
		'instructions' => 'The name of the template to use with this email. Lowercase and no spaces.',
		'name' => 'voucher_template_name',
		'type' => 'text',
		'required' => true
	),
	array(
		'key' => 'telemetry_acquisition_voucher_email_subject',
		'label' => 'Email Subject',
		'name' => 'voucher_email_subject',
		'type' => 'text'
	),
	array(
		'key' => 'telemetry_acquisition_voucher_brand_header',
		'label' => 'Brand Header Image',
		'name' => 'voucher_brand_header',
		'type' => 'image',
		'return_format' => 'url',
		'preview_size' => 'full',
	),
	array(
		'key' => 'telemetry_acquisition_voucher_hero_image',
		'label' => 'Hero Image',
		'name' => 'voucher_hero_image',
		'type' => 'image',
		'return_format' => 'url',
		'preview_size' => 'full',
	),
	array(
		'key' => 'telemetry_acquisition_voucher_heading',
		'label' => 'Heading',
		'name' => 'voucher_heading',
		'type' => 'text'
	),
	array(
		'key' => 'telemetry_acquisition_voucher_description',
		'label' => 'Description',
		'name' => 'voucher_description',
		'type' => 'strict_wysiwyg'
	),
	array(
		'key' => 'telemetry_acquisition_voucher_gen_code',
		'label' => 'Automatically generate voucher code',
		'name' => 'voucher_generate_code',
		'type' => 'true_false',
		'instructions' => 'Automatically generate a voucher code. Uncheck to manually enter.',
		'default_value' => 1,
	),
	array(
		'key' => 'telemetry_acquisition_voucher_man_code',
		'label' => 'Enter voucher code',
		'name' => 'voucher_manual_code',
		'instructions' => 'Manually enter a voucher code.',
		'type' => 'text',
		'conditional_logic' => array (
			array (
				array (
					'field' => 'telemetry_acquisition_voucher_gen_code',
					'operator' => '!=',
					'value' => 1,
				),
			),
		),
	),
	array(
		'key' => 'telemetry_acquisition_voucher_information',
		'label' => 'Other voucher information',
		'name' => 'voucher_information',
		'instructions' => 'e.g.<br>Valid until: 25/12/2015<br>Only valid on Tuesday evenings',
		'type' => 'strict_wysiwyg'
	),
	array(
		'key' => 'telemetry_acquisition_voucher_terms',
		'label' => 'Voucher Terms and Conditions',
		'name' => 'voucher_terms',
		'type' => 'strict_wysiwyg'
	),
);
