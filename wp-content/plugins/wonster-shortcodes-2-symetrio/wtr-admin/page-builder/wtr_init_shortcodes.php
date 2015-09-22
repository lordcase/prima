<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

// include libs
foreach ( glob( SHORTCODES_URL."/shortcodes/wtr_shortcode_*.php") as $lib )
	include_once( $lib );

// elements of builder shortcodes
$indexModalSht = array();
$indexModalSht['elements'] = array(
	'name' 		=> 'Elements',
	'icon'		=> 'elements',
	'shortcode' => array(
			'animation'		=> WTR_Shortcode_Animation::sht_button(),
			'divider'		=> WTR_Shortcode_Divider::sht_button(),
			'button'		=> WTR_Shortcode_Button::sht_button(),
			'custom_list'	=> WTR_Shortcode_List::sht_button(),
			'gallery'		=> WTR_Shortcode_Gallery::sht_button(),
			/*'google_font'	=> WTR_Shortcode_Google_Font::sht_button(),*/
			'highlight'		=> WTR_Shortcode_Highlight::sht_button(),
			'icon'			=> WTR_Shortcode_Icon::sht_button(),
			'notification'	=> WTR_Shortcode_Notification::sht_button(),
			'vimeo'			=> WTR_Shortcode_Vimeo::sht_button(),
			'youtube'		=> WTR_Shortcode_Youtube::sht_button(),
		)
	);
// create obj

if ( !defined( 'WTR_CP_PLUGIN_MAIN_FILE' ) ) {
	unset( $indexModalSht['elements'][ 'shortcode' ][ 'gallery' ] );
}

$wtr_shortcode_obj = new WTR_Tabs_TinyMCE( $indexModalSht );