<?php
/**
 * portfolio functiions
 *
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

// clean data
	$cln	= array();

	foreach( $_GET as $l => $r )
		$cln[$l] =  trim( $r );

	if( !isset( $cln[ 'lib' ] ) || !isset( $cln[ 'w' ] )  || !isset( $cln[ 'h' ] ) || !isset( $cln[ 'mode' ] ) || !isset( $_GET[ 'wtr_sht_id_data' ] ) )
		return false;


// LOAD LIBS

	// # wp
	include_once '../get_wp.php';

	// # template
	include_once '../class/wtr_shortcode_tpl.php';

	// # shortcode lib
	$lib = strtolower( $cln[ 'lib' ] );
	include_once '../../wtr-shortcodes/shortcodes/' . $lib . '.php';

	// # fields libs
	foreach ( glob( WTR_ADMIN_CLASS_DIR . "/fields/wtr_*.php" ) as $lib )
		include_once $lib;


$data = get_transient( $_GET[ 'wtr_sht_id_data' ] );
delete_transient( $_GET[ 'wtr_sht_id_data' ] );

// create modal object
	$obj 	= new $cln[ 'lib' ]( $cln[ 'mode' ] );
	//$modal 	= new WTR_Shortcode_Tpl( $obj,  ( !get_magic_quotes_gpc() )? $data : stripslashes( $data ) );
	$modal 	= new WTR_Shortcode_Tpl( $obj, $data );

// shortcode modal
	if( '0' == $cln[ 'mode' ] || 'pb' == $cln[ 'mode' ] )
		$modal->drawModal( $cln[ 'mode' ] );

// the properties of the shortcode window
	else if( 'properties' == $cln[ 'mode' ] || 'properties' == substr( $cln[ 'mode' ], 0, 10) )
		$modal->drawModalProperties();

$modal->Show();
