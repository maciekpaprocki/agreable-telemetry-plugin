<?php


return [

    /**
     * The Herbert version constraint.
     */
    'constraint' => '~0.9.9',

    /**
     * Auto-load all required files.
     */
    'requires' => [
    ],

    /**
     * The tables to manage.
     */
    'tables' => [
    ],


    /**
     * The routes to auto-load.
     */
    'routes' => [
        'AgreableTelemetryPlugin' => __DIR__ . '/app/routes.php'
    ],

    /**
     * The panels to auto-load.
     */
    'panels' => [
        'AgreableTelemetryPlugin' => __DIR__ . '/app/panels.php'
    ],

    /**
     * The APIs to auto-load.
     */
    'apis' => [
        'AgreableTelemetryPlugin' => __DIR__ . '/app/api.php'
    ],

    /**
     * The view paths to register.
     *
     * E.G: 'AgreableTelemetryPlugin' => __DIR__ . '/views'
     * can be referenced via @AgreableTelemetryPlugin/
     * when rendering a view in twig.
     */
    'views' => [
        'AgreableTelemetryPlugin' => __DIR__ . '/resources/views'
    ],

    /**
     * The view globals.
     */
    'viewGlobals' => [

    ],

    /**
     * The asset path.
     */
    'assets' => '/resources/assets/'

];
