<?php

namespace Tramite\Worker\Analyser\Logging;

class Logging
{
    public function findForLogsInServer()
    {
        $software           = $_POST['so'];
        $softuser           = array();
        $tried              = array();
        $found              = 0;
        $software_paths     = '../cfg/' . $software . '.paths.php';
        $software_pathsuser = '../cfg/' . $software . '.paths.user.php';
        $return[ 'notice' ] = '<h2>' . sprintf(__('Software <em>%s</em>'), $softwares_all[ $software ]['name']) . '</h2>';

        if (file_exists($software_pathsuser) ) {
            include $software_pathsuser;
            $software_paths = $software_pathsuser;
        }
        else if (file_exists($software_paths) ) {
            include $software_paths;
        }
        else {
            throw new Exception(sprintf(__('Files <code>%s</code> or <code>%s</code> do not exist. Please review your software configuration.'), $software_paths, $software_pathsuser));
        }

        foreach ( $paths as $userpath ) {

            $gpaths = glob($userpath, GLOB_MARK | GLOB_NOCHECK | GLOB_ONLYDIR);

            if (is_array($gpaths) ) {

                foreach( $gpaths as $path ) {

                    $tried[ $software ][ $path ] = false;

                    if (is_dir($path) ) {

                        $found = 1;
                        $tried[ $software ][ $path ] = true;

                        foreach ( $files as $type => $fpaths) {

                            foreach ( $fpaths as $userfile ) {

                                $gfiles   = glob($path . $userfile, GLOB_MARK | GLOB_NOCHECK);

                                if (is_array($gfiles) ) {

                                    foreach( $gfiles as $file ) {

                                        $file              = basename($file);
                                        $allfiles[ $file ] = $file;

                                        if (( is_readable($path . $file) ) && ( ! is_dir($path . $file) ) ) {

                                            if (! is_array($tried[ $software ][ $path ]) ) {
                                                $tried[ $software ][ $path ] = array();
                                            }

                                            $tried[ $software ][ $path ][ $type ][] = $file;
                                            $found = 2;
                                        }

                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $softuser[ $software ] = array();
        foreach ( $files as $type => $fpaths) {
            $softuser[ $software ][ $type ] = 1;
        }

        $return[ 'files' ]  = $tried;
        $return[ 'found' ]  = $found;

        if ($found == 0 ) {
            $return[ 'notice' ].= '<div class="alert alert-danger">' . __('Unable to find any directory.') . '</div>';
            $return[ 'notice' ].= __('Check in the following list if these directories are readable by the webserver user and refresh this page');
        }
        else if ($found == 1 ) {
            $return[ 'notice' ].= '<div class="alert alert-warning">' . __('Directories are available but unable to find files inside.') . '</div>';
            $return[ 'notice' ].= __('Check in the following list if these directories contain readable files by the webserver user and refresh this page.') . ' ';
            $return[ 'notice' ].= __('Don\'t forget that to read a file, ALL parent directories have to be accessible too!') . ' ';

            $allfiles  = array();
            foreach ( $files as $type => $fpaths) {
                foreach ( $fpaths as $file ) {
                    $allfiles[] = $file;
                }
            }
            $allfiles = '<code>' . json_encode($allfiles) . '</code>';

            $return[ 'notice' ].= sprintf(__('These files have been checked in all paths: %s '), $allfiles);
        }
        else {
            $return[ 'notice' ].= '<div class="alert alert-info">' . __('Log files have been found!') . '</div>';
            $return[ 'notice' ].= __('Check in the following list which files you want to configure.');
            $return[ 'notice' ].= '<br/>';
            $return[ 'notice' ].= __('If files or directories are missing, verify that they are readable by the webserver user');
        }

        $user = get_server_user();
        $return[ 'notice' ] .= ( $user == '' )
            ? ' (<em>' . __('unable to detect web server user') . '</em>):'
            : ' (<em>' . sprintf(__('web server user seems to be <code>%s</code>'), $user) . '</em>):';

        $return[ 'notice' ] .= '<br/><br/>';
        $return[ 'notice' ] .= '<div class="table-responsive"><table id="find"></table></div>';
        $return[ 'notice' ] .= __('You can also type log files path in the text area below separated by coma:');
        $return[ 'notice' ] .= '<br/><br/>';
        $return[ 'notice' ] .= '<div class="table-responsive"><table class="table table-striped table-bordered table-hover"><thead><tr><th>' . __('Type') . '</th><th>' . __('Custom paths') . '</th></tr></thead><tbody>';
        foreach( $softuser as $software => $types ) {
            foreach ( $types as $type => $dumb ) {
                $return[ 'notice' ] .= '<tr><td>' . $type . ' </td><td><textarea data-soft="' . $software . '" data-type="' . $type . '" class="userpaths form-control" rows="1"></textarea></td></tr>';
            }
        }
        $return[ 'notice' ] .= '</tbody></table></div>';

        $return[ 'next' ]   = true;
        $return[ 'reload' ] = true;

        return $return;
    }
}