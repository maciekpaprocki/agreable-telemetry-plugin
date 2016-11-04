<?php namespace AgreableTelemetryPlugin\Controllers;

use TimberPost;
use AgreableTelemetryPlugin\Services\UsesTelemetry;
use AgreableTelemetryPlugin\Services\Endpoint;

class DownloadEntries
{
    public function enqueue($params)
    {
        $post = new TimberPost;
        $widgetIndexOrFalse = UsesTelemetry::check($post);
        if (!is_admin() && $widgetIndexOrFalse) {
            $this->widget = $post->get_field('widgets')[$widgetIndexOrFalse];
            $this->buildMenu();
        }
    }

    public function isCompetition()
    {
        return in_array('competition', $this->widget['data_to_capture'], true);
    }

    public function buildMenu()
    {
        global $wp_admin_bar;

        $this->token = get_field('telemetry_api_key', 'telemetry-configuration');

        $type = $this->isCompetition() ? 'competition' : 'promotion';

        $widget = $this->widget;
        $idIndex = "{$type}_telemetry_id";
        $id = $widget[$idIndex];


        $wp_admin_bar->add_menu(array(
            'id'    => 'promo-downloads',
            'title' => "Export ".ucwords($type)." Entries",
            'href'  => ''
        ));

        $wp_admin_bar->add_menu(array(
            'id'    => 'download-csv',
            'title' => "All",
            'target' => '_BLANK',
            'href'  => $this->getUrl($type, $id),
            'parent'=>'promo-downloads'
        ));

        if ($this->isCompetition()) {
            $wp_admin_bar->add_menu(array(
                'id'    => 'download-csv-correct',
                'title' => "Correct Answers Only",
                'target' => '_BLANK',
                'href'  => $this->getUrl($type, $id, true),
                'parent'=>'promo-downloads'
            ));
        }

        if (count($this->widget['optins'])) {
            foreach ($this->widget['optins'] as $optin) {
                $wp_admin_bar->add_menu(array(
                    'id'    => "download-csv-".$optin['telemetry_id'],
                    'title' => ucwords($optin['optin_name'])." Opt-ins",
                    'target' => '_BLANK',
                    'href'  => $this->getUrl('optin', $optin['telemetry_id']),
                    'parent'=>'promo-downloads'
                ));
            }
        }
    }

    public function getUrl($type, $id, $correct = false)
    {
        $token = $this->token;
        $correctSegment = $correct ? '/correct' : '';
        $url = $this->baseUrl()."/api/v1/";
        $url = $url.$type."s/".$id."/entries";
        $url = $url.$correctSegment;
        $url = $url."?api_token=".$token;
        return $url;
    }

    public function baseUrl()
    {
        return Endpoint::get();
    }
}