<?php

define( 'WTR_IMPORTER_DATA_URI', WTR_IMPORTER_URI . '/data' );
define( 'WTR_IMPORTER_DATA_DIR', WTR_IMPORTER_DIR . '/data' );

define( 'WTR_IMPORTER_CLASS_URI', WTR_IMPORTER_URI . '/class' );
define( 'WTR_IMPORTER_CLASS_DIR', WTR_IMPORTER_DIR . '/class' );


if(!function_exists('wtr_one_click_import')) {
	function wtr_one_click_import() {


		check_ajax_referer('wtr_one_click_import_nonce');

		require_once( WTR_IMPORTER_CLASS_DIR . '/wtr_importer.php' );
		require_once( WTR_IMPORTER_CLASS_DIR . '/wtr_import_content.php' );
		require_once( WTR_IMPORTER_CLASS_DIR . '/wtr_import_others_settings.php' );
		require_once( WTR_IMPORTER_CLASS_DIR . '/wtr_import_theme_settings.php' );
		require_once( WTR_IMPORTER_CLASS_DIR . '/wtr_import_widgets.php' );
		require_once( WTR_IMPORTER_CLASS_DIR . '/wtr_import_revslider.php' );

		global  $wtr_theme_skins_defaul, $wtr_theme_skins_custome_defaul ;
		$import_type  = ( empty( $_POST['wtr_import_type'] ) OR ! isset( $wtr_theme_skins_defaul[ $_POST['wtr_import_type'] ] ) ) ? $wtr_theme_skins_custome_defaul : $_POST['wtr_import_type'];

		$content		= new WTR_Import_Content;
		$other			= new WTR_Import_Others_Settings;
		$theme_settings	= new WTR_Import_Theme_Settings;
		$widgets		= new WTR_Import_Widgets;
		$revslider		= new WTR_Import_Revslider;

		$data = array(
			$content,
			$other,
			$theme_settings,
			$widgets,
			$revslider,
		);

		$data_dir = WTR_IMPORTER_DATA_DIR . '/'. $import_type;
		$data_uri = WTR_IMPORTER_DATA_URI . '/'. $import_type;

		ob_start();
		$WTR_Importer = new WTR_Importer( $data, $data_dir,$data_uri );
		do_action( 'wtr_import_start' );
		$WTR_Importer->import( true );
		do_action( 'wtr_import_end' );
		$output = ob_get_clean();
		echo json_encode( array( 'status' => $WTR_Importer->checkStatusProces() ) );
		die();
	}

	//hook into wordpress admin.php
	add_action('wp_ajax_wtr_one_click_import', 'wtr_one_click_import');
} // end wtr_one_click_import