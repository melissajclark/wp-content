<?php
/*
@author Eric King
@url http://phplug.in/
@date 2014-02-06
*/

if ( ! filter_has_var( INPUT_GET | INPUT_POST , 'output' ) ) {
    $_REQUEST['output'] = '';
}

switch ( strtolower( $_REQUEST['output'] ) ) {
    case 'json':

        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode(
            array(
                'ip' => $_SERVER['REMOTE_ADDR']
            )
        );

    break;
    case 'xml':

        header('Content-Type: application/xml; charset=UTF-8' );
        echo '<?xml version="1.0" encoding="UTF-8"?><ip>', $_SERVER['REMOTE_ADDR'] ,'</ip>';

    break;
    default:

        header('Content-Type: text/plain; charset=UTF-8');
        echo $_SERVER['REMOTE_ADDR'];

}
