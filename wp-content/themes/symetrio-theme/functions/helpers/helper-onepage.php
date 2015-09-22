<?php
/**
 * OnePage functions
 *
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if( ! function_exists( 'wtr_one_page_pages' ) ){

	function wtr_one_page_pages(){

		global $post_settings;

		if( 'template-onepage.php' == $post_settings['template'] ){

			add_action( 'wp', 'wtr_one_page_remove_action' );
			add_action( 'wp_head', 'wtr_one_page_vc_front_css', 1000 );
			add_filter( 'body_class', 'wtr_one_page_body_class' );
			add_action( 'wp_enqueue_scripts', 'wtr_one_page_scripts_styles', 50 );
			remove_action('wtr_footer', 'wtr_footer_main' );
			remove_action('wtr_header', 'wtr_header_main' );

			if( 'none' == $post_settings['wtr_page_nav_menu'] ){
				return;
			}

			if( empty( $post_settings['wtr_page_nav_menu'] ) ){
				$locations		= get_theme_mod('nav_menu_locations');
				if( empty( $locations['primary'] ) ){
					return;
				}else{
					$menu_id	= $locations['primary'];
				}
			}else{
				$menu_id		= $post_settings['wtr_page_nav_menu'];
			}

			$args = array(
					'order'						=> 'ASC',
					'orderby'					=> 'menu_order',
					'post_type'					=> 'nav_menu_item',
					'post_status'				=> 'publish',
					'output'					=> ARRAY_A,
					'output_key'				=> 'menu_order',
					'nopaging'					=> true,
					'update_post_term_cache'	=> false
				);

			$menu_item	= wp_get_nav_menu_items( $menu_id, $args );

			$post_settings['one_page'] = array(
				'navigationTooltips'	=> array(),
				'sectionsColor'			=> array(),
				'pages'					=> array()
			);

			foreach ( $menu_item as $key => $value ) {
				if( 0 == $value->menu_item_parent AND 'custom' !== $value->object ) {

					$id													= $value->object_id;
					$menu_id											= $value->ID;
					$post_title											= $value->title;
					$selector_id										= get_post_meta( $id, '_wtr_OnePageSelectorID', true);
					$background_img										= get_post_meta( $id, '_wtr_OnePageBackgroundImg', true);
					$menu_class											= get_post_meta( $menu_id, '_menu_item_classes', true);
					$background_img_attributes							= wp_get_attachment_image_src( $background_img, 'full' );
					$style_background									= ( $background_img_attributes[0] ) ? 'style="background-image: url(\'' . $background_img_attributes[0] . '\')"' : '';
					$post_content										=  get_post_field( 'post_content', $id );
					$post_settings['one_page']['navigationClass'][]		= implode( " ",  $menu_class );
					$post_settings['one_page']['navigationTooltips'][]	= $post_title;
					$post_settings['one_page']['sectionsColor'][]		= get_post_meta( $id, '_wtr_OnePageBackgroundColor', true);
					$post_settings['one_page']['pages'][ $id ]			= array(
						'id'				=> $id,
						'post_title'		=> $post_title,
						'style_background'	=> $style_background,
						'post_content'		=> $post_content,
						'menu_class'		=> $menu_class,
						'selector_id'		=> $selector_id

					);
				}
			}
		}

	} // end wtr_one_page_ids
}
add_action( 'wp', 'wtr_one_page_pages' );


if( ! function_exists( 'wtr_one_page_content' ) ){

	function wtr_one_page_content(){

		global $post_settings;

		if( empty( $post_settings['one_page']['pages'] ) ){
			return;
		}

		echo '<div class="wtr_fullpage">';
			foreach ( $post_settings['one_page']['pages'] as $key => $value ) {

				$post_title				= $value['post_title'];
				$style_background		= $value['style_background'];
				$post_content			= $value['post_content'];
				$selecton_id			= trim( $value['selector_id'] );

				if( !strlen( $selecton_id ) ){
					$selecton_id = 'page-'. $key;
				}

				echo '<div class="section" id="section' . $key . '" ' . $style_background . ' data-anchor="' . $selecton_id . '">';
					echo '<div class="wrap">';
					echo '<main class="wtrMainContent">';
						echo '<div class="wtrContainer wtrContainerColor wtrPost wtrPage">';
							echo '<div class="wtrInner clearfix">';
								echo '<section class="wtrContentCol wtrContentNoSidebar clearfix">';
									echo '<div class="wtrPageContent clearfix">';
										echo apply_filters('the_content', $post_content );
									echo '</div>';
								echo '</section>';
							echo '</div>';
						echo '</div>';
					echo '</main>';
					echo '</div>';
				echo '</div>';
			}
		echo '</div>';

	} // end wtr_one_page_content
}


if( ! function_exists( 'wtr_one_page_script' ) ){

	function wtr_one_page_script(){
		global $post_settings;
		$post_settings['one_page']['verticalCentered'] = ( get_post_meta( get_the_id(), '_wtr_OnePageVertical', true) ) ? 'true': 'false';
		wp_localize_script( 'all_js', 'wtr_onepage_stettings', $post_settings['one_page'] );
	} // end wtr_one_page_script
}
add_action( 'wp_footer', 'wtr_one_page_script' );


if( ! function_exists( 'wtr_one_page_body_class' ) ){
	function wtr_one_page_body_class( $classes ){
		global $post_settings;
		$one_page_body_class = get_post_meta( get_the_id(), '_wtr_OnePageInvertNavigationColor', true) ? 'wtrInvertNavColors' : '';
		if( $one_page_body_class ){
			$classes[] = $one_page_body_class;
		}
		return $classes;
	} // end wtr_one_page_body_class
}


if( ! function_exists( 'wtr_one_page_scripts_styles' ) ){
	function wtr_one_page_scripts_styles( $classes ){
		global $post_settings;
		wp_enqueue_style( 'js_composer_front' );
		return $classes;
	} // end wtr_one_page_scripts_styles
}


if( ! function_exists( 'wtr_one_page_vc_front_css' ) ){

	function wtr_one_page_vc_front_css() {
		global $post_settings;
		if( ! empty( $post_settings['one_page']['pages'] ) ){

			$post_custom_css				= array();
			$shortcodes_custom_css[]		= array();

			foreach ( $post_settings['one_page']['pages'] as $pages ) {
				$id							= $pages['id'];
				$post_custom_css[]			= get_post_meta( $id, '_wpb_post_custom_css', true );
				$shortcodes_custom_css[]	= get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
			}

			$post_custom_css				= array_filter( $post_custom_css );
			$shortcodes_custom_css			= array_filter( $shortcodes_custom_css );

			if ( ! empty( $shortcodes_custom_css ) ) {
				echo '<style type="text/css" data-type="vc_shortcodes-custom-css">';
				echo implode( "\n", $shortcodes_custom_css );
				echo '</style>';
			}

			if ( ! empty( $post_custom_css ) ) {
				echo '<style type="text/css" data-type="vc_custom-css">';
				echo implode( "\n",$post_custom_css );
				echo '</style>';
			}
		}
	} // end wtr_one_page_vc_front_css
}


if( ! function_exists( 'wtr_one_page_custom_css_for_page' ) ){

	function wtr_one_page_custom_css_for_page( $output ){

		global $post_settings;
		if( ! empty( $post_settings['one_page']['pages'] ) ){

			foreach ( $post_settings['one_page']['pages'] as $pages ) {
				$id						= $pages['id'];
				$custom_css_page		= get_post_meta( $id, '_wtr_CustomCssForPage', true );
				if( $custom_css_page ){
					$output .= "\n" . $custom_css_page;
				}
			}
		}
		return $output;

	} // end  wtr_one_page_custom_css_for_page
}
add_filter( 'wtr_custom_css', 'wtr_one_page_custom_css_for_page');