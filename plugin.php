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

if (file_exists(__DIR__ . '/../../../../vendor/getherbert/')) {
	require_once __DIR__ . '/../../../../vendor/autoload.php';
} else {
	require_once __DIR__ . '/vendor/autoload.php';
}
if (file_exists(__DIR__ . '/../../../../vendor/getherbert/framework/bootstrap/autoload.php')) {
	require_once __DIR__ . '/../../../../vendor/getherbert/framework/bootstrap/autoload.php';
} else {
	require_once __DIR__ . '/vendor/getherbert/framework/bootstrap/autoload.php';
}


use AgreableWidgetService;
use AgreableTelemetryPlugin\Controllers\UpdateAcquisition;
use AgreableTelemetryPlugin\Controllers\RegisterAcquisition;
use AgreableTelemetryPlugin\Services\Endpoint;
use AgreableTelemetryPlugin\Controllers\DownloadEntries;
use AgreableTelemetryPlugin\Controllers\HandleDuplicate;


use add_action;
use TimberPost;
use get_field;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;

class AgreableTelemetryPlugin
{
	public function __construct()
	{
		$downloadEntries = new DownloadEntries;
		$handleDuplicate = new HandleDuplicate;
		add_action('save_post', array($this, 'registerOrUpdateAcquisition'), 10, 3);
		add_action('admin_enqueue_scripts', array($this, 'cssOverrides'), 10, 3);
		add_filter('acf/load_field/key=telemetry_options_telemetry_default_brand_id', array($this, 'loadBrands'), 11, 3);
		add_filter('acf/load_field/key=telemetry_acquisition_brand_ids', array($this, 'loadBrands'), 10, 3);
		add_filter('acf/load_field/key=telemetry_options_telemetry_team_id', array($this, 'loadTeam'), 10, 3);
		add_filter('acf/load_field/key=telemetry_acquisition_widget_brand_ids', array($this, 'setDefaultBrands'), 10, 3);
		add_filter('acf/load_field/key=telemetry_acquisition_thank_you_screen_title', array($this, 'setDefaultThankYouTitle'), 10, 3);
		add_filter('acf/load_field/key=telemetry_acquisition_thank_you_screen_body', array($this, 'setDefaultThankYouBodyText'), 10, 3);
		add_filter('acf/load_field/key=telemetry_acquisition_voucher_template_name', array($this, 'loadTemplateNames'), 10, 3);
		add_filter('timber_context', array($this, 'addConfigToContext'), 10, 1);
		add_action('wp_before_admin_bar_render', array($downloadEntries, 'enqueue'), 10, 1);
		add_action('dp_duplicate_post', array($handleDuplicate, 'handle'), 10, 2);
		add_action( 'wp_enqueue_scripts', array($this, 'input_admin_enqueue_scripts'), 10, 3);
		add_action( 'admin_enqueue_scripts', array($this, 'input_admin_enqueue_scripts'), 10, 3);
	}

	/*
	 *  input_admin_enqueue_scripts()
	 *
	 *  This action is called in the admin_enqueue_scripts action on the edit  screen where your field is created.
	 *  Use this action to add CSS + JavaScript to assist your render_field()  action.
	 *
	 *  @type	action (admin_enqueue_scripts)
	 *  @since	3.6
	 *  @date	23/01/13
	 *
	 *  @param	n/a
	 *  @return	n/a
	 */
	public function input_admin_enqueue_scripts() {
		$dir = WP_PLUGIN_DIR;
		$dir = explode('/', $dir);
		$last = array_pop($dir);
		$next_last = array_pop($dir);
		$folder = basename(dirname(__FILE__));
		$base_url = get_bloginfo('url');
		$dir = "$base_url/$next_last/$last/$folder/";

		// register & include JS
		wp_register_script( 'agreable-telemetry-plugin-script', "{$dir}resources/assets/js/main.js", array('jquery') );
		wp_enqueue_script('agreable-telemetry-plugin-script');
		wp_register_script('agreable-telemetry-plugin-dep-moment', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js');
		wp_enqueue_script('agreable-telemetry-plugin-dep-moment');
		wp_register_script('agreable-telemetry-plugin-dep-fallcalendar', 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js');
		wp_enqueue_script('agreable-telemetry-plugin-dep-fallcalendar', array('jquery'));
		wp_localize_script('agreable-telemetry-plugin-dep-fallcalendar', 'telemetry_config', array(
			'team_id' => get_field('telemetry_team_id', 'telemetry-configuration'),
			'token' => get_field('telemetry_api_key', 'telemetry-configuration'),
			'endpoint' => Endpoint::get()
		));
		wp_enqueue_script('telemetry-config');
	}

	public function setDefaultThankYouTitle($field)
	{
		$title = get_field('telemetry_acquisition_thank_you_screen_title_default', 'telemetry-configuration');
		$field['default_value'] = $title;
		return $field;
	}

	public function setDefaultThankYouBodyText($field)
	{
		$bodyText = get_field('telemetry_acquisition_thank_you_screen_body_default', 'telemetry-configuration');
		$field['default_value'] = $bodyText;
		return $field;
	}


	public function cssOverrides()
	{
		wp_add_inline_style('custom-style', ".acf-hide, th.acf-th.acf-th-text[data-key='telemetry_acqusition_competition_answers_answer_telemetry_id'] { display: none !important; }");
		wp_add_inline_style('custom-style', ".telemetry_page_telemetry-calendar #post-body.columns-2 #postbox-container-1 {display: none;} .telemetry_page_telemetry-calendar #poststuff #post-body.columns-2 {margin-right: 0;} .fc-day-grid-event .fc-content {padding: 3px 5px;font-size: 13px;} .fc-scroller { height: auto !important; overflow: visible !important; }");
	}

	public function registerOrUpdateAcquisition($post_id, $post, $update)
	{
		if (wp_is_post_revision($post)) {
			return;
		}
		$post = new TimberPost($post_id);
		if ($post->status !== 'publish') {
			return;
		}
		if ($post->post_type !== 'post') {
			return;
		}

		$widgetIndex = $this->containsWidget($post);
		if (!($widgetIndex === false)) {
			$widgets = $post->get_field('widgets');
			$telemetryData = $widgets[$widgetIndex];
			if (!empty($telemetryData['telemetry_id'])) {
				new UpdateAcquisition($telemetryData, $post, $widgetIndex);
			} else {
				new RegisterAcquisition($telemetryData, $post, $widgetIndex);
			}
		}
	}

	public function containsWidget($post)
	{
		$widgets = $post->get_field('widgets');
		if (empty($widgets)) {
			return;
		}
		foreach ($widgets as $index => $widget) {
			if ($widget['acf_fc_layout'] === 'telemetry_acquisition') {
				return $index;
			}
		}
		return false;
	}

	public function loadBrands($field)
	{
		$baseUri = Endpoint::get();
		$token = get_field('telemetry_api_key', 'telemetry-configuration');
		if ($token) {
			$client = new Client([
				'base_uri' => $baseUri,
				'timeout'  => 10.0
			]);
			try {
				$response = $client->get(
					'api/v1/team/brand',
					[
						'query' => ['api_token' => $token]
					]
				);
				$body = (string) $response->getBody();
				$responseObject = json_decode($body, true, JSON_PRETTY_PRINT);
				foreach ($responseObject['data'] as $key => $brand) {
					$field['choices'][$brand['id']] = $brand['name'];
				}
				if ($field['type'] == 'checkbox') {
					foreach ($responseObject['data'] as $key => $brand) {
						array_push($field['default_value'], $brand['id']);
					}
				}
			} catch (ServerException $exception) {
				update_field('telemetry_api_key', '', 'telemetry-configuration');
			}
		}
		return $field;
	}

	public function loadTeam($field)
	{
		$baseUri = Endpoint::get();
		$token = get_field('telemetry_api_key', 'telemetry-configuration');
		if ($token) {
			$client = new Client([
				'base_uri' => $baseUri,
				'timeout'  => 10.0
			]);
			try {
				$response = $client->get(
					'api/v1/team',
					[
						'query' => ['api_token' => $token]
					]
				);
				$body = (string) $response->getBody();
				$responseObject = json_decode($body, true, JSON_PRETTY_PRINT);
				foreach ($responseObject['data'] as $key => $team) {
					$field['choices'][$team['id']] = $team['name'];
				}
			} catch (ServerException $exception) {
				update_field('telemetry_api_key', '', 'telemetry-configuration');
			}
		}
		return $field;
	}

	public function loadTemplateNames($field)
	{
		$client = new Client(['timeout'  => 10.0]);
		try {
			$response = $client->get(
				'http://sortingofficeapi.com/templates'
			);
			$body = (string) $response->getBody();
			$responseObject = json_decode($body, true, JSON_PRETTY_PRINT);
			foreach ($responseObject['templates'] as $key => $template) {
				$field['choices'][$template] = $template;
			}
		} catch (ServerException $exception) {
			throw new Error($exception);
		}
		return $field;
	}

	public function addConfigToContext($context)
	{
		$fieldData = get_field_object('telemetry_acquisition_brand_ids', 'telemetry-acquisition');
		$defaultData = get_field('telemetry_acquisition_brand_ids', 'telemetry-configuration');
		$brands = [];
		foreach ($defaultData as $value) {
			$brand = [
				'name' => $fieldData['choices'][$value],
				'id' => $value
			];
			array_push($brands, $brand);
		}
		$context['telemetry'] = [
			'endpoint' => Endpoint::get(),
			'brands' => $brands
		];
		return $context;
	}

	public function setDefaultbrands($field)
	{
		$fieldData = get_field_object('telemetry_acquisition_brand_ids', 'telemetry-acquisition');
		$defaultData = get_field('telemetry_acquisition_brand_ids', 'telemetry-configuration');
		foreach ($defaultData as $index => $value) {
			$field['choices'][$value] = $fieldData['choices'][$value];
			array_push($field['default_value'], $value);
		}
		return $field;
	}
}

new AgreableTelemetryPlugin();
