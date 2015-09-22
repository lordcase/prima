<?php
/**
 * WPML compatibility
 *
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if( defined('ICL_SITEPRESS_VERSION' ) AND  defined( 'ICL_LANGUAGE_CODE' ) ){


	if( ! function_exists( 'wtr_wpml_styles' ) ) {

		function wtr_wpml_styles(){
			wp_enqueue_style( 'wtr_wpml_css', WTR_EXTENSIONS_URI . '/wpml/assets/css/wpml.css' );
		} // end wtr_wpml_styles
	}
	add_action( 'wp_enqueue_scripts', 'wtr_wpml_styles', 100 );


	if( ! function_exists( 'wtr_wpml_page_404' ) ){

		// Id 404 pages for the current language
		function wtr_wpml_page_404( $page ){

			$page = icl_object_id( $page , 'page', false, ICL_LANGUAGE_CODE ) ;
			return $page;
		} // end wtr_wpml_page_404
	}
	add_filter( 'wtr_page_404', 'wtr_wpml_page_404' );


	if( ! function_exists( 'wtr_wpml_search_form_output' ) ){

		// adding language to the search form
		function wtr_wpml_search_form_output( $output ){

			$output .= '<input type="hidden"  name="lang" value="' . ICL_LANGUAGE_CODE . '"/>';
			return $output;
		} // end wtr_wpml_search_form_output
	}
	add_filter( 'wtr_search_form_output', 'wtr_wpml_search_form_output' );


	if( ! function_exists( 'wtr_wpml_search_link' ) ){

		//adding language to the search link
		function wtr_wpml_search_link( $url ){

			global $sitepress;
			$url = $sitepress->convert_url( $url );
			$url = str_replace('&amp;', '&', $url );
			return $url;
		} // end wtr_wpml_search_link
	}
	add_filter( 'wtr_search_link', 'wtr_wpml_search_link' );


	if( ! function_exists( 'wtr_wpml_modern_search_link' ) ){

		// adding language to the url modern search
		function wtr_wpml_modern_search_link( $url ){

			$lang 			= ICL_LANGUAGE_CODE;
			$last_char_url	= $url[ strlen( $url ) -1 ];

			if( '/' == $last_char_url ) {
				$permastruct = '?';
			} else {
				$permastruct = '&';
			}

			if( ! empty( $lang ) ) {
				$url .= $permastruct . "lang=" . $lang;
			}
			return $url;
		} // end wtr_wpml_modern_search_link
	}
	add_filter( 'wtr_modern_search_link', 'wtr_wpml_modern_search_link' );


	if( ! function_exists( 'wtr_wpml_notices_page_404' ) ){

		// notices page 404 - as no equivalent in other languages
		function wtr_wpml_notices_page_404( ){

			global $WTR_Opt;
			$page_404 	= $WTR_Opt->getOpt('wtr_Global404Page') ;

			if( empty( $page_404) ) {
				return;
			}


			$languages 	= icl_get_languages('skip_missing=1');
			$langs 		= array();
			$out 		= '';

			if( 1 < count( $languages ) ) {
				foreach( $languages as $l ) {
					$page = icl_object_id( $page_404 , 'page', false, $l['language_code'] );
					if( empty( $page )  OR  'publish' != get_post_status ( $page ) ) {
						$langs[] = $l['translated_name'];
					}
				}
				$out .= join(', ', $langs );
			}
			if( $out ){
				echo '<div class="error">';
					echo '<p> ' . __( '404 is a "Page" now, there are missing translations in languages:', 'wtr_framework' ) .' <b>'. $out . ' </b></p>';
					echo '<p> <b><a href="' . get_edit_post_link( $page_404 ) . '"> Edit 404 Page</a></b></p>';
				echo '</div>';
			}
		} // end wtr_wpml_notices_page_404
	}
	add_action( 'admin_notices', 'wtr_wpml_notices_page_404' );


	if( ! function_exists( 'wtr_wpml_shortcod_param' ) ){

		// shortcod language param
		function wtr_wpml_shortcod_param( $params ){

			$params['lang'] = ICL_LANGUAGE_CODE;
			return $params;
		} // end wtr_wpml_shortcod_param
	}
	add_action( 'wtr_shortcod_param', 'wtr_wpml_shortcod_param' );


	if( ! function_exists( 'wtr_wpml_icl_import_xml_start' ) ){

		function wtr_wpml_icl_import_xml_start() {

			global $sitepress;
			$langs = $sitepress->get_active_languages();
			if (empty($langs)) {
				return;
			}
			$_POST['icl_post_language'] = $sitepress->get_default_language();
		} // end wtr_wpml_icl_import_xml_start
	}
	add_action('wtr_import_start', 'wtr_wpml_icl_import_xml_start', 10);


	if( ! function_exists( 'wtr_wpml_translate_admin_options_init' ) ){

		function wtr_wpml_translate_admin_options_init() {
			global $post_settings_wpml;

			$post_settings_wpml = array(
				"wtr_GlobalSpaceBeforeHead",
				"wtr_GlobalSpaceBeforeBody",
				"wtr_AnaliticsCode",
				"wtr_SeoTitleHome",
				"wtr_SeoDescription",
				"wtr_SeoKeywords",
				"wtr_HeaderSectionOne",
				"wtr_HeaderSectionTwo",
				"wtr_FooterCoopyrightText",
				"wtr_FooterSectionOne",
				"wtr_FooterSectionTwo",
			);

		} // end wtr_wpml_translate_admin_options_init
	}
	add_action('init', 'wtr_wpml_translate_admin_options_init', 100);


	if( ! function_exists( 'wtr_wpml_translate_admin_options_register' ) ){

		function wtr_wpml_translate_admin_options_register() {
			global $post_settings, $post_settings_wpml;

			foreach ($post_settings_wpml as $wpml) {
				icl_register_string( WTR_ADMIN_TRANSLATE_NAME, $wpml, $post_settings[ $wpml ] );
			}

		} // end wtr_wpml_translate_admin_options_register
	}


	if( ! function_exists( 'wtr_wpml_translate_admin' ) ){

		function wtr_wpml_translate_admin( $post_settings ) {
			global $post_settings_wpml;

			foreach ($post_settings_wpml as $wpml) {
				$post_settings[ $wpml ] = icl_translate( WTR_ADMIN_TRANSLATE_NAME, $wpml, $post_settings[ $wpml ] );
			}
			return $post_settings;
		} // end wtr_wpml_translate_admin
	}


	if( function_exists( 'icl_register_string' ) ){
		add_filter( 'wtr_post_settings', 'wtr_wpml_translate_admin' );
		add_action( 'init', 'wtr_wpml_translate_admin_options_register', 200);
	}
}
