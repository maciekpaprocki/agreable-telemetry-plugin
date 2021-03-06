<?php
return array(
    array(
        'key' => 'telemetry_acquisition_competition_question',
        'label' => 'Question',
        'name' => 'competition_question',
        'type' => 'strict_wysiwyg',
        'simplify' => true,
        'no_return' => true,
        'placeholder' => 'What is the new Burger King burger called?',
		'required' => 1,
    ),
    array(
        'key' => 'telemetry_acqusition_competition_question_telemetry_id',
        'label' => 'Telemetry ID',
        'name' => 'competition_telemetry_id',
        'type' => 'text',
        'instructions' => 'DO NOT TOUCH, if you can see this, should be hidden',
        'wrapper' => array(
            'width' => '0%',
            'class' => 'acf-hide',
        ),
    ),
    array(
        'key' => 'telemetry_acquisition_competition_answers',
        'label' => 'Answers',
        'name' => 'competition_answers',
        'type' => 'repeater',
        'instructions' => 'Add your answers',
        'min' => 2,
        'max' => 5,
        'layout' => 'table',
        'button_label' => 'Add Answer',
        'sub_fields' => array(
            array(
                'key' => 'telemetry_acquisition_competition_answers_answer_text',
                'label' => 'Answer Text',
                'name' => 'answer_text',
                'type' => 'text',
				'required' => 1,
            ),
            array(
                'key' => 'telemetry_acquisition_competition_answers_answer_correct',
                'label' => 'Correct?',
                'name' => 'answer_correct',
                'type' => 'true_false',
                'instructions' => 'Tick one of these boxes to represent the correct answer',
            ),
            array(
                'key' => 'telemetry_acqusition_competition_answers_answer_telemetry_id',
                'label' => 'Telemetry ID',
                'name' => 'telemetry_id',
                'type' => 'text',
                'instructions' => 'DO NOT TOUCH, if you can see this, should be hidden',
                'wrapper' => array(
                    'width' => '0%',
                    'class' => 'acf-hide',
                ),
            )
        ),
    ),
);
