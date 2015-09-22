<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! function_exists( 'wtr_wp_nav_mobile_menu_classic' ) ){

	// set the parameters of the main mobile classic menu
	function wtr_wp_nav_mobile_menu_classic() {
		global $post_settings;

		if( isset( $_SERVER['HTTP_USER_AGENT'] ) ){
			preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);

			if ( count( $matches ) > 1 ){
				$version = $matches[ 1 ];
				if( $version==9 ){
					$version_info = 1;
				}
				else{
					$version_info = 0;
				}
			}else{
				$version_info = 0;
			}
		}else{
			$version_info = 0;
		}


		if( 'none' == $post_settings['wtr_page_nav_menu'] || 0 == $post_settings[ 'wtr_HeaderSettings' ] || 1 == $version_info){
			return;
		}

		$depth	= apply_filters( 'wtr_wp_nav_menu_depth', 3 );
		$args	= array(
			'theme_location'	=> 'primary',
			'menu'				=> $post_settings['wtr_page_nav_menu'],
			'container'			=> 'div',
			'container_class'	=> 'wtrSimpleMobileNav',
			'container_id'		=> '',
			'menu_class'		=> 'wtrMainNaviList',
			'menu_id'			=> '',
			'echo'				=> false,
			'fallback_cb'		=> 'WTR_Walker_Nav_Mobile_Classic_Menu::fallback',
			'before'			=> '',
			'after'				=> '',
			'link_before'		=> '',
			'link_after'		=> '',
			'items_wrap'		=> '<div class="wtrMobileMenu wtrBelowedMenu"><span>' . $post_settings['wtr_TranslateHomeMobileMenu'] . '</span></div><div class="wtrSimpleMobileHeader">' . $post_settings['wtr_TranslateHomeMobileMenu'] . '</div><ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'				=> $depth,
			'walker'			=> new WTR_Walker_Nav_Mobile_Classic_Menu,
		);

		$menu	= wp_nav_menu( $args );

		if( ! empty( $menu ) ) {
			echo '<div class="wtrSimpleMobileNavContainer">';
				echo $menu;
			echo '</div>';
			echo '<div class="wtrSimpleNavOverlay"></div>';
		}

	} // end wtr_wp_nav_mobile_menu_classic
}


if( ! class_exists( 'WTR_Walker_Nav_Mobile_Classic_Menu' ) ) {

	class WTR_Walker_Nav_Mobile_Classic_Menu extends Walker_Nav_Menu {

		private $menu_no_generate_link	= '';

		/**
		 * Starts the list before the elements are added.
		 *
		 * @see Walker::start_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<div class=\"wtrExpander wtrPlus\"><span>Menu</span></div><ul class=\"sub-menu\">\n";
		} // end start_lvl


		/**
		 * Ends the list of after the elements are added.
		 *
		 * @see Walker::end_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		public function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "$indent</ul>\n";
		} // end end_lvl


		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

			$this->menu_no_generate_link	= trim( $item->wtr_menu_no_generate_link );
			$indent 						= ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$classes 						= empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] 						= 'menu-item-' . $item->ID;

			/**
			 * Filter the CSS class(es) applied to a menu item's list item element.
			 *
			 * @since 3.0.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
			 * @param object $item    The current menu item.
			 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth   Depth of menu item. Used for padding.
			 */
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			/**
			 * Filter the ID applied to a menu item's list item element.
			 *
			 * @since 3.0.1
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
			 * @param object $item    The current menu item.
			 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth   Depth of menu item. Used for padding.
			 */
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $class_names .'>';

			$atts = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
			$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
			$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

			/**
			 * Filter the HTML attributes applied to a menu item's anchor element.
			 *
			 * @since 3.6.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array $atts {
			 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
			 *
			 *     @type string $title  Title attribute.
			 *     @type string $target Target attribute.
			 *     @type string $rel    The rel attribute.
			 *     @type string $href   The href attribute.
			 * }
			 * @param object $item  The current menu item.
			 * @param array  $args  An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth Depth of menu item. Used for padding.
			 */
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$item_output = $args->before;
			$item_output .= ( "enabled" == $this->menu_no_generate_link ) ? '<span>' : '<a'. $attributes .'>';
			/** This filter is documented in wp-includes/post-template.php */
			$title = apply_filters( 'the_title', $item->title, $item->ID );
			$item_output .= $args->link_before . $title . $args->link_after;
			$item_output .= ( "enabled" == $this->menu_no_generate_link ) ? '</span>' : '</a>';
			$item_output .= $args->after;

			/**
			 * Filter a menu item's starting output.
			 *
			 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
			 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
			 * no filter for modifying the opening and closing `<li>` for a menu item.
			 *
			 * @since 3.0.0
			 *
			 * @param string $item_output The menu item's starting HTML output.
			 * @param object $item        Menu item data object.
			 * @param int    $depth       Depth of menu item. Used for padding.
			 * @param array  $args        An array of {@see wp_nav_menu()} arguments.
			 */
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}


		// The function used when the menu does not exist
		public static function fallback( $args ) {
			return null;
		} // end fallback

	} // WTR_Walker_Nav_Mobile_Classic_Menu
}