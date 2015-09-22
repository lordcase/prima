<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */




header( 'Content-type: text/css;' );

$url = dirname( __FILE__ );
$strpos = strpos( $url, 'wp-content' );
$base = substr( $url, 0, $strpos );

require_once( $base .'wp-load.php' );

global $WTR_Opt;
echo $WTR_Opt->save_css();