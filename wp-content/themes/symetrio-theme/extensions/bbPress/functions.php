<?php
/**
 * WooCommerce compatibility
 *
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

function wtr_bbpress_detect_activation( $plugin, $network_activation ) {
	if( 'bbpress/bbpress.php' == $plugin ){
		update_option( 'wtr_bbpress_activation', 1 );
	}
} // end wtr_bbpress_detect_activation
add_action( 'activated_plugin', 'wtr_bbpress_detect_activation', 10, 2 );


function wtr_bbpress_update_settings(){
	$status	= get_option( 'wtr_bbpress_activation' );
	if( 1 == $status ){
		global $WTR_Opt;
		$WTR_Opt->update_options();
		delete_option( 'wtr_bbpress_activation');
	}
} // end wtr_bbpress_update_settings
add_action( 'after_setup_theme', 'wtr_bbpress_update_settings' );


if( ! function_exists( 'is_bbpress' ) ) {
	return false;
}


if( ! function_exists( 'wtr_bbpress_init' ) ) {

	function wtr_bbpress_init( $option ) {


		//bbpress: wtr_bbpressSidebarSection
		$wtr_SidebarPositionOnSbbpress= new WTR_Radio_Img( array(
				'id'			=> 'wtr_SidebarPositionOnSbbpress',
				'title'			=> __( 'Sidebar position on bbPress', 'wtr_framework' ),
				'desc'			=> '',
				'value'			=> '',
				'default_value' => 'setNone',
				'info'			=> '',
				'allow'			=> 'all',
				'checked' 		=> 'sideChecked',
				'class' 		=> 'sideSetter',
				'option'		=> array( 'setLeftSide' , 'setRightSide', 'setNone' ),
			)
		);

		$wtr_bbpressSidebarSection = new WTR_Section( array(
				'id'		=> 'wtr_bbpressSidebarSection',
				'title'		=> __( 'Sidebar', 'wtr_framework' ),
				'fields'	=> array(
					$wtr_SidebarPositionOnSbbpress
				),
			)
		);

		$wtr_bbpressGroup = new WTR_Group( array(
				'title'		=> __( 'bbPress', 'wtr_framework' ),
				'class'		=> 'wtr_bbPressGroup',
				'sections'	=> array(
					$wtr_bbpressSidebarSection,
				),
			)
		);
		$option[] = $wtr_bbpressGroup;
		return $option;
	} // end wtr_bbpress_init
}
add_filter( 'wtr_init', 'wtr_bbpress_init' );


if( ! function_exists( 'wtr_bbpress_post_settings' ) ) {

	function wtr_bbpress_post_settings( $post_settings ){

		if( is_bbpress() ) {
			$post_settings['wtr_SidebarPosition']		= $post_settings['wtr_SidebarPositionOnSbbpress'];
			$post_settings['wtr_Sidebar']				= 'bbpress';
			$post_settings['wtr_BreadCrumbsContainer']	= 0;
		}

		return $post_settings;
	} // end wtr_bbpress_post_settings
}
add_filter( 'wtr_post_settings', 'wtr_bbpress_post_settings');


if( ! function_exists( 'wtr_bbpress_register_sidebars' ) ) {
	// register custom sidebars
	function wtr_bbpress_register_sidebars() {

		$bbpress = array(
			array('name' => __( 'bbPress', WTR_THEME_NAME ), 'id' => 'custom-sidebar-bbpress'),
		);

		foreach ( $bbpress as $key => $value) {
			register_sidebar( array(
			'name'			=> $value['name'],
			'id'			=> $value['id'],
			'description'	=> '',
			'class'			=> '',
			'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h6>',
			'after_title'	=> '</h6>',
			));
		}

	} // end wtr_bbpress_register_sidebars
}
add_action( 'widgets_init', 'wtr_bbpress_register_sidebars', 20 );


if( ! function_exists( 'wtr_bbpress_styles' ) ) {

	function wtr_bbpress_styles(){
		wp_enqueue_style( 'wtr_bbpress_css', WTR_EXTENSIONS_URI . '/bbPress/assets/css/bbPress.css' );
	} // end wtr_bbpress_styles
}
add_action( 'wp_enqueue_scripts', 'wtr_bbpress_styles', 100 );