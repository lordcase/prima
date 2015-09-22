<?php
/**
 * Yoast SEO compatibility
 *
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if( defined('WPSEO_VERSION' ) ) {

	if( ! function_exists( 'wtr_wordpress_seo_public_settings' ) ) {

		function wtr_wordpress_seo_public_settings(){
			$current_screen = get_current_screen();
			$post_types		= get_post_types( array( 'public' => true ) );

			if( in_array( $current_screen->post_type, $post_types ) ) {
				wtr_public_settings();
			}
		} // end wtr_wordpress_seo_public_settings
	}
	add_action( 'load-post.php', 'wtr_wordpress_seo_public_settings' );
}