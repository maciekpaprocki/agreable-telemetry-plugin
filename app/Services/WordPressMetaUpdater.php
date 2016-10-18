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
        $this->saveCompetitionAnswers($this->data['competition_answers']);
        $this->saveOptins($this->data['optins']);
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
