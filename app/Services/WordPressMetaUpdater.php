<?php namespace AgreabletelemetryPlugin\Services;

class WordPressMetaUpdater
{
	public function __construct($data, $index, $post)
	{
		$this->data = $data;
		$this->index = $index;
		$this->post = $post;
		$this->save();
	}

	public function save()
	{
		$this->updateField('telemetry_id');
		$this->updateField('promotion_telemetry_id');
		$this->updateField('competition_telemetry_id');
		$this->updateField('voucher_telemetry_id');
		if (!empty($this->data['competition_answers'])) {
			$this->saveCompetitionAnswers($this->data['competition_answers']);
		}
		if (!empty($this->data['optins'])) {
			$this->saveOptins($this->data['optins']);
		}
	}

	public function updateField($name)
	{
		return update_sub_field(
			array('widgets', $this->index+1, $name),
			$this->data[$name],
			$this->post->id
		);
	}

	public function saveOptins($optins)
	{
		foreach ($optins as $index => $optin) {
			$this->updateSubfieldTelemetryId(
				'optins',
				'telemetry_acqusition_competition_answers_answer_telemetry_id',
				$index,
				$optin['telemetry_id']);
		}
	}

	public function saveCompetitionAnswers($answers)
	{
		foreach ($answers as $index => $answer) {
			$this->updateSubfieldTelemetryId(
				'competition_answers',
				'telemetry_acqusition_competition_answers_answer_telemetry_id',
				$index,
				$answer['telemetry_id']);
		}
	}

	public function updateSubfieldTelemetryId($type, $property, $index, $value)
	{
		$acfKey = "widgets_{$this->index}_{$type}_{$index}_telemetry_id";
		update_post_meta($this->post->id, $acfKey, $value);
		update_post_meta($this->post->id, '_' . $acfKey, $property);
	}
}
