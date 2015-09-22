<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

$ext_patch = __FILE__;
$path_file = explode( 'wp-content', $ext_patch );
$path_to_wp = $path_file[0];
require_once( $path_to_wp . '/wp-load.php' );