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
			if (in_array('voucher', $telemetryData['additional_features'])) {
                $payload['voucher'] = self::buildVoucher($telemetryData);
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
            'team_id' => get_field('telemetry_acquisition_telemetry_team_id', 'telemetry-configuration'),
            'brand_id' => $telemetryData['brand_ids'],
            'url' => get_permalink($post->ID),
            'end_time' => $telemetryData['end_time'],
            'start_time' => $telemetryData['start_time']
        ];
    }

    public static function buildCompetition($telemetryData)
    {
        return [
            'id' => $telemetryData['competition_telemetry_id'],
            'question' => $telemetryData['competition_question'],
            'answers' => self::buildAnswers($telemetryData['competition_answers'])
        ];
    }
    public static function buildVoucher($telemetryData)
    {
        return [
			'template' => $telemetryData['voucher_template_name'],
			'email_subject' => $telemetryData['voucher_email_subject'],
			'brand_header_url' => $telemetryData['voucher_brand_header'],
			'hero_url' => $telemetryData['voucher_hero_image'],
			'heading' => $telemetryData['voucher_heading'],
			'description' => $telemetryData['voucher_description'],
			'voucher_code' => $telemetryData['voucher_manual_code'],
			'voucher_info' => $telemetryData['voucher_information'],
			'terms' => $telemetryData['voucher_terms']
        ];
    }
    public static function buildAnswers($answers)
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

    public static function buildOptins($optins)
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
