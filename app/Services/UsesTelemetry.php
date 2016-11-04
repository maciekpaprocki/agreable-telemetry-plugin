<?php namespace AgreableTelemetryPlugin\Services;

use TimberPost;

class UsesTelemetry
{
    public static function check(TimberPost $post)
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
}