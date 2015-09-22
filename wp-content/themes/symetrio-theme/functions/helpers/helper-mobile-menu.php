<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! function_exists( 'wtr_wp_nav_mobile_menu' ) ){

	// set the parameters of the main mobile menu
	function wtr_wp_nav_mobile_menu() {
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

		$search	= ( 1 == $post_settings['wtr_HeaderSearchStatus'] ) ? wtr_search_form( 'wtrMobileSearchInput wtrRadius2', 'wtrMobileSearchForm', false ) : '';
		$depth	= apply_filters( 'wtr_wp_nav_menu_depth', 3 );
		$args	= array(
			'theme_location'	=> 'primary',
			'menu'				=> $post_settings['wtr_page_nav_menu'],
			'container'			=> 'nav',
			'container_class'	=> 'mp-menu',
			'container_id'		=> 'mp-menu',
			'menu_class'		=> '',
			'menu_id'			=> '',
			'echo'				=> true,
			'fallback_cb'		=> 'WTR_Walker_Nav_Mobile_Menu::fallback',
			'before'			=> '',
			'after'				=> '',
			'link_before'		=> '',
			'link_after'		=> '',
			'items_wrap'		=> '<div class="mp-level">'. $search . '<ul id="%1$s" class="%2$s">%3$s</ul></div>',
			'depth'				=> $depth,
			'walker'			=> new WTR_Walker_Nav_Mobile_Menu,
		);
		wp_nav_menu( $args );
	} // end wtr_wp_nav_mobile_menu
}


if( ! function_exists( 'wp_nav_menu_args_mobile_trigger' ) ){

	function wp_nav_menu_args_mobile_trigger( $args ) {
		global $post_settings;
		
		if( 'primary' == $args['theme_location']  AND  is_object( $args['walker'] ) AND 'WTR_Walker_Nav_Menu' == get_class( $args['walker'] ) AND 1 == $post_settings['wtr_HeaderMobileNavigationType'] ){
			$menu_trigger = '<a href="#"  class=" wtrMobileNaviTriger wtrDefaultLinkColor wtrTriggerMobileMenu"><i class="fa fa-bars"></i></a>';
			$args['items_wrap'] = $menu_trigger . $args['items_wrap'];

		}
		return $args;
	} // end wp_nav_menu_args_mobile_trigger
}
add_filter( 'wp_nav_menu_args', 'wp_nav_menu_args_mobile_trigger' );


if( ! class_exists( 'WTR_Walker_Nav_Mobile_Menu' ) ) {

	class WTR_Walker_Nav_Mobile_Menu extends Walker_Nav_Menu {

		private $menu_no_generate_link	= '';


		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<ul class=\"sub-menu\">\n";
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
		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "$indent</ul></div>\n";
		} // end end_lvl


		/**
		 * Start the element output.
		 *
		 * @see Walker::start_el()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item   Menu item data object.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 * @param int    $id     Current item ID.
		 */
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$this->menu_no_generate_link	= trim( $item->wtr_menu_no_generate_link );

			// <li> class
			if( $args->has_children ){
				$item->classes[] = 'icon icon-arrow-left';
			}

			$class_names = '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			/**
			 * Filter the CSS class(es) applied to a menu item's <li>.
			 *
			 * @since 3.0.0
			 *
			 * @see wp_nav_menu()
			 *
			 * @param array  $classes The CSS classes that are applied to the menu item's <li>.
			 * @param object $item    The current menu item.
			 * @param array  $args    An array of wp_nav_menu() arguments.
			 */
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			/**
			 * Filter the ID applied to a menu item's <li>.
			 *
			 * @since 3.0.1
			 *
			 * @see wp_nav_menu()
			 *
			 * @param string $menu_id The ID that is applied to the menu item's <li>.
			 * @param object $item    The current menu item.
			 * @param array  $args    An array of wp_nav_menu() arguments.
			 */
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $class_names .'>';

			$atts = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
			$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
			$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

			/**
			 * Filter the HTML attributes applied to a menu item's <a>.
			 *
			 * @since 3.6.0
			 *
			 * @see wp_nav_menu()
			 *
			 * @param array $atts {
			 *     The HTML attributes applied to the menu item's <a>, empty strings are ignored.
			 *
			 *     @type string $title  Title attribute.
			 *     @type string $target Target attribute.
			 *     @type string $rel    The rel attribute.
			 *     @type string $href   The href attribute.
			 * }
			 * @param object $item The current menu item.
			 * @param array  $args An array of wp_nav_menu() arguments.
			 */
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$item_output = $args->before;
			$item_output .= ( "enabled" == $this->menu_no_generate_link AND ! $args->has_children ) ? '<span>' : '<a'. $attributes .'>';
			/** This filter is documented in wp-includes/post-template.php */
			$title = apply_filters( 'the_title', $item->title, $item->ID );
			$item_output .= $args->link_before . $title . $args->link_after;
			$item_output .= ( "enabled" == $this->menu_no_generate_link AND ! $args->has_children ) ? '</span>' : '</a>';
			$item_output .= $args->after;


			if( $args->has_children ){
				$item_output .= '<div class="mp-level"><h2 class="wtrNavHeadline">' . $title . '<a class="mp-back wtrNavBack" href="#"></a></h2>';
			}
			/**
			 * Filter a menu item's starting output.
			 *
			 * The menu item's starting output only includes $args->before, the opening <a>,
			 * the menu item's title, the closing </a>, and $args->after. Currently, there is
			 * no filter for modifying the opening and closing <li> for a menu item.
			 *
			 * @since 3.0.0
			 *
			 * @see wp_nav_menu()
			 *
			 * @param string $item_output The menu item's starting HTML output.
			 * @param object $item        Menu item data object.
			 * @param int    $depth       Depth of menu item. Used for padding.
			 * @param array  $args        An array of wp_nav_menu() arguments.
			 */

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		} // end start_el


		/**
		 * Ends the element output, if needed.
		 *
		 * @see Walker::end_el()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item   Page data object. Not used.
		 * @param int    $depth  Depth of page. Not Used.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		function end_el( &$output, $item, $depth = 0, $args = array() ) {
			$output .= "</li>\n";
		} // end end_el


		/**
		 * Traverse elements to create list from elements.
		 *
		 * Display one element if the element doesn't have any children otherwise,
		 * display the element and its children. Will only traverse up to the max
		 * depth and no ignore elements under that depth. It is possible to set the
		 * max depth to include all depths, see walk() method.
		 *
		 * This method should not be called directly, use the walk() method instead.
		 *
		 * @since 2.5.0
		 *
		 * @param object $element           Data object.
		 * @param array  $children_elements List of elements to continue traversing.
		 * @param int    $max_depth         Max depth to traverse.
		 * @param int    $depth             Depth of current element.
		 * @param array  $args              An array of arguments.
		 * @param string $output            Passed by reference. Used to append additional content.
		 * @return null Null on failure with no changes to parameters.
		 */
		function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

			if ( ! $element ){
				return;
			}

			$id_field = $this->db_fields['id'];

			//display this element
			if ( is_object( $args[0] ) ){
				$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
			}

			parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		} // end display_element


		// The function used when the menu does not exist
		public static function fallback( $args ) {
			return null;
		} // end fallback

	} // WTR_Walker_Nav_Mobile_Menu
}