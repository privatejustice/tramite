<?php
/*! pimpmylog - 1.7.14 - 025d83c29c6cf8dbb697aa966c9e9f8713ec92f1*/
/*
 * pimpmylog
 * http://pimpmylog.com
 *
 * Copyright (c) 2017 Potsky, contributors
 * Licensed under the GPLv3 license.
 */


namespace Tramite\Worker\Analyser\Logging;

use Tramite\Worker\Logging\Plugins\Apache;
use Tramite\Worker\Logging\Plugins\Iis;
use Tramite\Worker\Logging\Plugins\Nginx;
use Tramite\Worker\Logging\Plugins\Php;

class ConfigPlugins
{

    public function getSoftwares()
    {
        $softwaresList = array( 'Apache' , 'Iis' , 'Nginx' , 'Php' );
        $softwaresAll  = array();

        foreach ( $softwaresList as $sfw ) {
            $sfwInstance = new $sfw;
            $cfg = $sfwInstance->loadSoftware();
            if (is_array($cfg) ) {
                $softwaresAll[ $sfw ] = $cfg;
            }
        }


        /*
        You can add your own softwares in file software.user.inc.php, it will not be erased on update (git pull).
        Just add a new software like this :

        $softwaresAll[ 'my_software' ] = array(
            'name' => __('My Super Software'),
            'desc' => __('My Super Software build with love for you users which are installing Pimp my Log !'),
            'home' => __('http://www.example.com'),
            'note' => __('All versions 2.x are supported but 1.x too in fact.'),
        );

        Just modify an existing software like this :
        $softwaresAll[ 'apache' ][ 'name' ] = 'Apache HTTPD';

        You have to add these files too :
        - my_software.config.user.php (which defines function my_software_get_config)
        - my_software.paths.user.php
        */
        // if ( file_exists( '../cfg/softwares.inc.user.php' ) ) {
        //     include_once '../cfg/softwares.inc.user.php';
        // }


        return $softwaresAll;
    }
}
