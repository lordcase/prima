<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

global $post_settings;

if( 'setNone' != $post_settings['wtr_SidebarPosition'] ){

	echo '<aside class="' . $post_settings['wtr_ContentInClass']['sidebar'] . ' ">';
		echo '<div class="wtrSidebarInner">';
			if ( is_active_sidebar( $post_settings['wtr_Sidebar'] ) ) {
				dynamic_sidebar( $post_settings['wtr_Sidebar'] );
			}
		echo '</div>';
	echo '</aside>';
}
