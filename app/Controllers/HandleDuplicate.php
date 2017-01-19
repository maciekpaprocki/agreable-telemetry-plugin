<?php namespace AgreableTelemetryPlugin\Controllers;

use TimberPost;
use AgreableTelemetryPlugin\Services\UsesTelemetry;

class HandleDuplicate
{
	public function handle($newPostId, $postObject)
	{
		$post = new TimberPost($newPostId);
		$check = UsesTelemetry::check($post);
		if ($check) {
			$index = UsesTelemetry::getIndex($post);
			$fieldsToClear = [
				'telemetry_id',
				'promotion_telemetry_id',
				'competition_telemetry_id',
				'voucher_telemetry_id',
				'competition_question',
				'competition_answers',
				'optins'
			];
			foreach ($fieldsToClear as $field) {
				update_sub_field(
					array('widgets', ($index+1), $field),
					'',
					$newPostId
				);
			}
		}
	}
}
