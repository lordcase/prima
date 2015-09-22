<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1');}


if ( ! class_exists( 'WTR_Shortcodes_Controller' ) ) {

	class WTR_Shortcodes_Controller{
		private $objectVC	= null;
		private $config		= array();


		public function __construct( &$vcController = null ){

			$this->objectVC = $vcController;
			$this->config			= array(
				'vc_must_enable'	=> true,
				'vc_enable'			=> false,
			);

			add_action( 'init', array( &$this, 'check_theme') );
		} // end __construct


		public function check_theme(){

			if( $this->config[ 'vc_must_enable' ] ){
				if( null != $this->objectVC && $this->objectVC->getStatus( 'vc_enable' ) ){
					$this->loadPluginData();
				}
			}
			else{
				$this->loadPluginData();
			}
		}// end check_theme


		private function loadPluginData(){

			$this->libs_loader();

			add_action('admin_init', array( &$this, 'shortcodes_scripts' ) );
			add_action('add_meta_boxes', array( &$this, 'init_enqueue' ) );

			// a list of shortcodes
			add_action( 'admin_init', array( &$this, 'update_sht_list' ) );
		}//end loadPluginData


		private function libs_loader() {
			// tinymce
			require_once( WTR_SHT_PLUGIN_ADMIN_DIR . '/page-builder/tinymce/tinymce_init.php' );

			//admin customizer init
			require_once( WTR_SHT_PLUGIN_CUSTOMIZER_DIR . '/wtr_customizer_init.php' );

			require_once( WTR_SHT_PLUGIN_ADMIN_DIR . '/page-builder/tinymce/tinymce_init.php' );

			//shortcodes
			require_once( WTR_SHT_PLUGIN_ADMIN_DIR . '/page-builder/wtr_shortcode_public.php' );
		}//end libs_loader


		public function shortcodes_scripts(){

			//Register Stylesheets
			wp_register_style( 'site_tinymce', trailingslashit( WTR_SHT_PLUGIN_ADMIN_URI ) . 'page-builder/tinymce/css/site.css' );
			wp_register_style( 'easy_responsive_tabs', trailingslashit( WTR_SHT_PLUGIN_ADMIN_URI ) . 'page-builder/tinymce/css/easy-responsive-tabs.css' );

			//Register Scripts
			wp_register_script( 'tinybox', trailingslashit( WTR_SHT_PLUGIN_ADMIN_URI ) . 'page-builder/tinymce/js/tinybox.js', false );
			wp_register_script( 'obj_shortcodeIndex', trailingslashit( WTR_SHT_PLUGIN_ADMIN_URI ) . 'page-builder/tinymce/js/obj.shortcodeIndex.js', true );
			wp_register_script( 'easyResponsiveTabs', trailingslashit( WTR_SHT_PLUGIN_ADMIN_URI ) . 'page-builder/tinymce/js/easyResponsiveTabs.js', false );
			wp_register_script( 'mousewheel', trailingslashit( WTR_SHT_PLUGIN_ADMIN_URI ) . 'page-builder/tinymce/js/jquery.mousewheel.js', false );

		}//end wtr_shortcodes_scripts


		public function init_enqueue(){

			//Enqueue Stylesheets
			wp_enqueue_style( 'site_tinymce' );
			wp_enqueue_style( 'easy_responsive_tabs' );
			wp_enqueue_style( 'font_awesome' );

			//Enqueue Scripts
			wp_enqueue_script('tinybox' ) ;
			wp_enqueue_script('obj_shortcodeIndex' );
			wp_enqueue_script('easyResponsiveTabs' );
			wp_enqueue_script('mousewheel' );
		}


		public function update_sht_list(){

			$wtr_sht_obj	= array();
			$wtr_sht_list	= array();

			foreach ( glob( WTR_SHT_PLUGIN_ADMIN_DIR .'/page-builder/wtr-shortcodes/shortcodes/wtr_shortcode_*.php' ) as $lib ){
				include_once $lib;

				$libC	= explode( '/', str_replace( '.php', '', $lib ) );
				$libC	= str_replace( 'wtr', 'WTR', end( $libC ) );
				$libC	= str_replace( ' ', '_', ucwords( str_replace( '_', ' ',  $libC ) ) );

				// Set standard info about shortcode
				$wtr_sht_obj[ $libC ] = call_user_func( $libC.'::sht_button' );

				if( isset( $wtr_sht_obj[ $libC ][ 'shortcode_id' ] ) ){
					if( is_array( $wtr_sht_obj[ $libC ][ 'shortcode_id' ] ) ){
						foreach( $wtr_sht_obj[ $libC ][ 'shortcode_id' ] as $el ){
							array_push( $wtr_sht_list, $el );
						}
					}else {
						if( 'wtr_columns' ==  $wtr_sht_obj[$libC ][ 'shortcode_id' ] ){
							foreach( $wtr_sht_obj[$libC ][ 'shordcode_extra_id' ] as $cols_elem ){
								if( FALSE === array_search(  $cols_elem, $wtr_sht_list ) ){
									array_push( $wtr_sht_list, $cols_elem );
								}
							}
						}
						else {
							array_push( $wtr_sht_list, $wtr_sht_obj[$libC ][ 'shortcode_id' ] );
						}
					}

					// whether inside extra shortcodes
					if( isset( $wtr_sht_obj[ $libC ][ 'shordcode_extra_id' ] ) ){
						foreach( $wtr_sht_obj[ $libC ][ 'shordcode_extra_id' ] as $el ){
							array_push( $wtr_sht_list, $el );
						}
					}
				}

				$obj = new $libC( '0' );
				$wtr_sht_obj[$libC ]['fields'] = ( isset( $wtr_sht_obj[$libC ][ 'shortcode' ] ) && 'self' != $wtr_sht_obj[$libC ][ 'shortcode' ] && null != $wtr_sht_obj[$libC ][ 'shortcode' ] )? $obj->fieldsValue() : array();
			}

			//params for shortcode_obj
			$params = array(
				'uri'			=> WTR_SHT_PLUGIN_ADMIN_URI,
				'default_sht'	=> $wtr_sht_obj,
				'page_builder'	=> array(),
				'lang'			=> '',
			);
			$params = apply_filters( 'wtr_shortcod_param', $params );

			wp_localize_script( 'obj_shortcodeIndex', 'wtr_shr_param', $params );

			update_option( WTR_Settings::get_WP_SHT_LIST_OPT_NAME(), $wtr_sht_list );
		}// end update_sht_list

	}//end WTR_Shortcodes_Controller
}