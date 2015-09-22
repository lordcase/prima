<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( ! class_exists( 'WTR_Import_Widgets' ) ) {

	class WTR_Import_Others_Settings {

		private $data = 'others_settings.php';


		public function import( $path, $path_uri ){

			$import_path		= $path . '/'. $this->data;
			$import_path_uri	= $path_uri . '/'. $this->data;

			if( ! file_exists( $import_path ) ){
				return false;
			}

			require_once $import_path ;

			update_option( 'show_on_front', $wtr_show_on_front );
			update_option( 'page_on_front', $wtr_page_on_front );
			update_option( 'page_for_posts', $wtr_page_for_posts );


			// menud
			$export_locations	= unserialize( $wtr_menu_locations );
			$menus				= wp_get_nav_menus();
			$locations			= get_theme_mod('nav_menu_locations');
			$import_menu		= array();

			if( empty( $locations ) ) {
				$import_menu	= $export_locations;
			} else {
				foreach ( $locations as $location_key => $location ) {
					foreach ( $menus as $menu ) {
						if( isset( $export_locations[ $location_key ] ) ){
							$import_menu[ $location_key ] = $export_locations[ $location_key ];
						}
					}
				}
			}
			set_theme_mod( 'nav_menu_locations', $import_menu );

			return true;
		} // end import

	} // end WTR_Import_Others_Settings
}