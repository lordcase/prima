<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

// Defining constants
define('PLUGIN_MCE_NAME', 'wonster_mce');
define('PLUGIN_MCE_URI', WTR_SHT_PLUGIN_ADMIN_URI .'/page-builder/tinymce/');

function checkCreateShortcodes() {

	$current_screen = get_current_screen();

	if( 'page' == $current_screen->post_type || 'post' == $current_screen->post_type ){

		global $page_handle;
		if ( ! current_user_can('edit_posts') || ! current_user_can('edit_pages') ) { return; };

		if ( get_user_option('rich_editing') == 'true') {
			add_filter("mce_external_plugins", 'wonster_mce_plugin' );
			add_filter('mce_buttons', 'wonster_mce_buttons' );
			add_filter('mce_external_languages', 'wonster_mce_languages');
		}
	}
} // end checkCreateShortcodes
add_action( 'admin_enqueue_scripts', 'checkCreateShortcodes');
//add_action( 'admin_init', 'wonster_mce_init' );


function wonster_mce_plugin( $array ) {
	$array['wonster_mce'] =  PLUGIN_MCE_URI .'js/plugin.js';
	return $array;
} // end wonster_mce_plugin


function wonster_mce_buttons( $buttons ) {
	array_push($buttons, '|', 'wonster_mce' );
	return $buttons;
} // end wonster_mce_buttons


function wonster_mce_languages( $array ) {
	$array['wonster_mce'] =  PLUGIN_MCE_URI .'js/langs.js';
	return $array;
} // end wonster_mce_languages