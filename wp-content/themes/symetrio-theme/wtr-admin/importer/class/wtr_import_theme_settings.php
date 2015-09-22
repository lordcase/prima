<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( ! class_exists( 'WTR_Import_Theme_Settings' ) ) {

	class WTR_Import_Theme_Settings {

		private $data = 'wtr_theme_settings.php';


		public function import( $path, $path_uri ){

			$import_path		= $path . '/'. $this->data;
			$import_path_uri	= $path_uri . '/'. $this->data;

			if( ! file_exists( $import_path ) ){
				return false;
			}

			require_once $import_path ;

			$option_name	= WTR_Settings::get_WP_OPT_NAME();
			$data			= wtr_decode_theme_settings( $wtr_import_theme_settings );
			update_option( $option_name, $data );
			update_option( WP_CUSTOMIZER_OPT_NAME, $data['wtr_symetrio_option_customizer'] );

			return true;

		} // end import

	} // end WTR_Import_Theme_Settings
}