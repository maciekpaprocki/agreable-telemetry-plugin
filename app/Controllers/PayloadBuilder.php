<?php namespace AgreableTelemetryPlugin\Controllers;

class PayloadBuilder
{
    public static function build($telemetryData, $post)
    {
        $payload = self::buildPayloadBase($telemetryData, $post);
        if (!empty($telemetryData['data_to_capture'])) {
            if (in_array('competition', $telemetryData['data_to_capture'])) {
                $payload['competition'] = self::buildCompetition($telemetryData);
            }
        }
        $payload['promotion'] = [
            'name' => $post->title,
            'id' => $telemetryData['promotion_telemetry_id']
        ];
        if (!empty($telemetryData['additional_features'])) {
            if (in_array('optins', $telemetryData['additional_features'])) {
                $payload['third_party_optins'] = self::buildOptins($telemetryData['optins']);
            }
        }
        return $payload;
    }

    public static function buildPayloadBase($telemetryData, $post)
    {
        return [
            'id' => $telemetryData['telemetry_id'],
            'type' => (!empty($telemetryData['data_to_capture'])
                && in_array('competition', $telemetryData['data_to_capture']))
                ? 'competition' : 'promotion',
            'team_id' => 1,
            'brand_id' => [
                9
            ],
            'url' => get_permalink($post->ID),
            'end_time' => $telemetryData['end_time'],
            'start_time' => $telemetryData['start_time']
        ];
    }

    public function buildCompetition($telemetryData)
    {
        return [
            'id' => $telemetryData['competition_telemetry_id'],
            'question' => $telemetryData['competition_question'],
            'answers' => self::buildAnswers($telemetryData['competition_answers'])
        ];
    }

    public function buildAnswers($answers)
    {
        $formattedAnswers = [];
        foreach ($answers as $answer) {
            $formattedAnswer = [
                'name' => $answer['answer_text'],
                'correct' => $answer['answer_correct'],
                'id' => $answer['telemetry_id']
            ];
            array_push($formattedAnswers, $formattedAnswer);
        }
        return $formattedAnswers;
    }

    public function buildOptins($optins)
    {
        $formattedOptins = [];
        foreach ($optins as $optin) {
            $formattedOptin = [
                'id' => $optin['telemetry_id'],
                'name' => $optin['optin_name']
            ];
            array_push($formattedOptins, $formattedOptin);
        }
        return $formattedOptins;
    }
}
