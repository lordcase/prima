<?php
/**
 * qTranslate-X compatibility
 *
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */


if( function_exists( 'qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage' ) ){

	function wtr_qtranslate_post_settings_final( $post_settings ){
		$post_settings = array_map("qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage", $post_settings);
		return $post_settings;
	} // end wtr_public_settings_qtranslate
	add_action( 'wtr_post_settings_final', 'wtr_qtranslate_post_settings_final', 100);
}