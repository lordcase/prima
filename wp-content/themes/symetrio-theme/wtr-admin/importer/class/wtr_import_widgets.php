<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( ! class_exists( 'WTR_Import_Widgets' ) ) {

	class WTR_Import_Widgets {

		private $data = 'wtr_widgets.php';


		public function import( $path, $path_uri ){

			$import_path		= $path . '/'. $this->data;
			$import_path_uri	= $path_uri . '/'. $this->data;

			if( ! file_exists( $import_path ) ){
				return false;
			}

			$widgets_json		= wp_remote_get( $import_path_uri );
			$wtr_import_wigets	= $widgets_json['body'];

			$wtr_import_wigets_settings	= json_decode( $wtr_import_wigets, true) ;
			$sidebars_widgets			= get_option( 'sidebars_widgets' ) ;


			// fix custom menu widget
			$menus			= wp_get_nav_menus();
			$menus_slugs	= array();

			foreach ( $menus as $menu ) {
				$menus_slugs[ $menu->slug ] = $menu->term_id;
			}

			if( ! empty( $wtr_import_wigets_settings['widgets']['widget_nav_menu'] ) ){
				foreach ( $wtr_import_wigets_settings['widgets']['widget_nav_menu'] as $widget_key => $widget ) {
					if( isset( $widget['nav_menu'] ) AND isset( $menus_slugs[ $widget['nav_menu'] ] ) ){
						$wtr_import_wigets_settings['widgets']['widget_nav_menu'][$widget_key]['nav_menu'] = $menus_slugs[ $widget['nav_menu'] ];
					}
				}
			}

			//import sidebars
			foreach ( $wtr_import_wigets_settings['sidebars_widgets'] as $widgets_key => $widgets ) {
				$sidebars_widgets[ $widgets_key ] = $widgets;
			}
			// update sidebar
			update_option( 'sidebars_widgets', $sidebars_widgets ) ;

			// update widgets
			foreach ( $wtr_import_wigets_settings['widgets'] as $widget_key => $widget ) {
				update_option( $widget_key, $widget );
			}

			return true;
		} // end import

	} // end WTR_Import_Widgets
}



