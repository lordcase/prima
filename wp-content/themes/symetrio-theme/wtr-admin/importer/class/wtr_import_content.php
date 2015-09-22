<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( ! class_exists( 'WTR_Import_Content' ) ) {

	class WTR_Import_Content {

		private $data = 'wtr_content.xml';

		public function import( $path, $path_uri ){

			$import_path			= $path . '/'. $this->data;
			$import_path_uri		= $path_uri . '/'. $this->data;
			$wtr_importer_status	= $this->load_wp_importer();

			if( false == $wtr_importer_status OR ! file_exists( $import_path ) ){
				return false;
			}

			$wp_import = new WP_Import();
			$wp_import->fetch_attachments = true;

			ob_start();
				$wp_import->import( $import_path );
			ob_end_clean();

			return true;
		} // end import

		private function load_wp_importer( ) {


			if ( !defined('WP_LOAD_IMPORTERS') )
			define('WP_LOAD_IMPORTERS', true);

			$wtr_importer_status = true;

			// Load Importer API
			require_once ABSPATH . 'wp-admin/includes/import.php';

			//load main importer class
			if ( !class_exists( 'WP_Importer' ) ) {
				$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
				if ( file_exists( $class_wp_importer ) ) {
					require_once($class_wp_importer);
				} else  {
					$wtr_importer_status = false;
				}
			}

			//load wp import class
			if ( !class_exists( 'WP_Import' ) ) {
				$class_wp_import = WTR_IMPORTER_CLASS_DIR . '/wordpress-importer/wordpress-importer.php';
				if ( file_exists( $class_wp_import ) ) {
					require_once($class_wp_import);
				} else  {
					$wtr_importer_status = false;
				}
			}
			return $wtr_importer_status;

		}// end __construct

	} // end WTR_Import_Content
}