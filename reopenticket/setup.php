<?php

define('PLUGIN_REOPENTICKET_VERSION', '1.0.0');

function plugin_init_reopenticket()
{
    global $PLUGIN_HOOKS;

    $PLUGIN_HOOKS['csrf_compliant']['reopenticket'] = true;

    $PLUGIN_HOOKS['add_javascript']['reopenticket'] = [
        'js/reopenticket.js'
    ];
}

function plugin_version_reopenticket()
{
    return [
        'name'           => 'Reopen Ticket',
        'version'        => PLUGIN_REOPENTICKET_VERSION,
        'author'         => '',
        'license'        => 'GPLv2+',
        'homepage'       => '',
        'requirements'   => [
            'glpi' => [
                'min' => '10.0.0',
                'max' => '10.0.99'
            ]
        ]
    ];
}

function plugin_reopenticket_check_prerequisites()
{
    if (version_compare(GLPI_VERSION, '10.0.0', '<')) {
        echo "Questo plugin richiede GLPI >= 10.0.0";
        return false;
    }

    return true;
}

function plugin_reopenticket_check_config($verbose = false)
{
    return true;
}
