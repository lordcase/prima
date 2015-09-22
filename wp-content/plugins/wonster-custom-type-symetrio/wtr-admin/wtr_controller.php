<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1');}


if ( ! class_exists( 'WTR_CT_Controler' ) ) {

	class WTR_CT_Controler{
		private $config		= array();


		public function __construct(){
			$this->config			= array(
				'wtr_theme_disable'	=> true,
			);

			add_action( 'after_setup_theme', array( &$this, 'check_theme') );
		} // end __construct


		public function check_theme(){

			//I'm checking does Wonster theme is active and whether Wonster Custom post  can be activated
			$this->config['wtr_theme_disable'] = ( ! defined( 'WTR_THEME_VERSION' ) AND ! defined( 'WTR_THEME_NAME' ) );

			if( $this->config['wtr_theme_disable'] ){
				add_action( 'admin_notices', array( &$this, 'admin_notice') );
			} else{
				$this->loadPluginData();
			}
		}// end check_theme


		public static function admin_notice() {
			$plugin_data = get_plugin_data( WTR_CP_PLUGIN_MAIN_FILE );

			echo '<div class="error"  style="margin-left: 0;" >';
				echo '<p>'. sprintf( __( '<strong>%s</strong> - This plugin works only with Symetrio theme created by
								 Wonster Team', 'wtr_ct_framework' ), $plugin_data[ 'Name' ] ) .
					'.</p>';
			echo '</div>';

		}//end admin_notice


		private function loadPluginData(){

			//meta
			require_once( WTR_CP_META_DIR . '/meta-testimonials.php' );
			require_once( WTR_CP_META_DIR . '/meta-gallery.php' );
			require_once( WTR_CP_META_DIR . '/meta-clients.php' );
			require_once( WTR_CP_META_DIR . '/meta-gym-location.php' );
			require_once( WTR_CP_META_DIR . '/meta-pass.php' );
			require_once( WTR_CP_META_DIR . '/meta-rooms.php' );
			require_once( WTR_CP_META_DIR . '/meta-trainers.php' );
			require_once( WTR_CP_META_DIR . '/meta-classes.php' );
			require_once( WTR_CP_META_DIR . '/meta-events.php' );
			require_once( WTR_CP_META_DIR . '/meta-events-organizers.php' );
			require_once( WTR_CP_META_DIR . '/meta-events-locations.php' );

			//registration widgets
			require_once( WTR_CP_WIDGET_DIR . '/register-widget.php' );
			require_once( WTR_CP_WIDGET_DIR . '/widget-recent-gallery.php' );
			require_once( WTR_CP_WIDGET_DIR . '/widget-testimonials.php' );
			require_once( WTR_CP_WIDGET_DIR . '/widget-pass.php' );
			require_once( WTR_CP_WIDGET_DIR . '/widget-trainers.php' );
			require_once( WTR_CP_WIDGET_DIR . '/widget-events.php' );
			require_once( WTR_CP_WIDGET_DIR . '/widget-events-upcoming.php' );

			//Plugins
			require_once( WTR_CP_PLUGINS_DIR . '/pagetemplater.php' );

		}//end loadPluginData

	}//end WTR_CT_Controler
}