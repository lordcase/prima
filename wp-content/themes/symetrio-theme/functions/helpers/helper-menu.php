<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! function_exists( 'wtr_wp_nav_menu' ) ){

	// set the parameters of the main menu
	function wtr_wp_nav_menu( $container_class = 'wtrNavigation', $menu_class = 'wtrMainNavigation clearfix' ) {
		global $post_settings;

		if( 'none' == $post_settings['wtr_page_nav_menu'] ){
			return;
		}

		$depth = apply_filters( 'wtr_wp_nav_menu_depth', 3 );
		$args = array(
			'theme_location'	=> 'primary',
			'menu'				=> $post_settings['wtr_page_nav_menu'],
			'container'			=> 'nav',
			'container_class'	=> $container_class,
			'container_id'		=> '',
			'menu_class'		=> $menu_class,
			'menu_id'			=> 'wtr-menu-1',
			'echo'				=> false,
			'fallback_cb'		=> 'WTR_Walker_Nav_Menu::fallback',
			'before'			=> '',
			'after'				=> '',
			'link_before'		=> '',
			'link_after'		=> '',
			'items_wrap'		=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'				=> $depth,
			'walker'			=> new WTR_Walker_Nav_Menu,
		);

		return wp_nav_menu( $args );
	} // end wtr_wp_nav_menu
}


if( ! function_exists( 'wtr_search_itme' ) ){

	// add search icon inside main navigation
	function wtr_search_itme ( $items, $args ) {

		global $post_settings;

		if ( 'primary' ==  $args->theme_location AND  0 == $post_settings['wtr_HeaderCleanMenuMod'] AND 1 == $post_settings['wtr_HeaderSearchStatus'] AND is_numeric( strpos($args->menu_class, 'wtrMainNavigation') ) ) {

			$items .= '<li class="wtrNaviItem wtrNaviSearchItem"><div class="wtrMenuLinkColor wtrDefaultLinkColor wtrSearchFormTrigger"><i class="fa fa-search"></i></div>';
			$items .= '<div class="wtrSearchContainer wtrMegaMenuContainerColorSecond clearfix ">';
			$items .= '<div class="wtrSearchContainerInner">';
			$items .= wtr_search_form( 'wtrSearchInput', 'wtrSearchForm', true );
			$items .= '</div>';
			$items .= '</div>';
			$items .= '</li>';
		}
		return $items;
	} // end wtr_search_itme
}
add_filter( 'wp_nav_menu_items', 'wtr_search_itme', 5, 2 );


if( ! function_exists( 'wtr_wp_nav_menu_depth' ) ){

	function wtr_wp_nav_menu_depth( $depth ){

		global  $post_settings;

		if( 'template-onepage.php' == $post_settings['template'] ) {
			$depth = 1 ;
		}

		return $depth;
	} // end wtr_wp_nav_menu_depth
}
add_filter( 'wtr_wp_nav_menu_depth', 'wtr_wp_nav_menu_depth');