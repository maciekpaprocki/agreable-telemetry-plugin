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

        $wp_admin_bar->add_menu(array(
            'id'    => 'promo-downloads',
            'title' => 'Export Promo Entries',
            'href'  => ''
        ));

        $wp_admin_bar->add_menu(array(
            'id'    => 'download-csv',
            'title' => "Download ".ucwords($type)." Entries - CSV",
            'target' => '_BLANK',
            'href'  => $this->getUrl($type),
            'parent'=>'promo-downloads'
        ));
    }

    public function getUrl($type)
    {
        $widget = $this->widget;
        $token = $this->token;
        $idIndex = "{$type}_telemetry_id";
        $id = $widget[$idIndex];
        return $this->baseUrl()."/api/v1/".$type."s/".$id."/entries?api_token=".$token;
    }

    public function baseUrl()
    {
        return Endpoint::get();
    }
}
