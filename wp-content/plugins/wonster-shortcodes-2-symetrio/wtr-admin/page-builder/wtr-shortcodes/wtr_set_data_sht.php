<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

// LOAD LIBS

// # wp
include_once '../tinymce/get_wp.php';

if( ! is_user_logged_in() OR ! isset( $_POST[ 'wtr_sht_id_data' ] ) OR ! isset( $_POST[ 'wtr_sht_data' ] ) ) {
	return ;
}

$wtr_sht_id_data	= strip_tags( trim ( $_POST[ 'wtr_sht_id_data' ] ) );
$wtr_sht_data		= trim( $_POST[ 'wtr_sht_data' ] );

set_transient( $wtr_sht_id_data, stripcslashes( $wtr_sht_data ), 60 * 2 );
