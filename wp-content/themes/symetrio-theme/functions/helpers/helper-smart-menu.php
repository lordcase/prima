<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! function_exists( 'wtr_wp_nav_smart_menu' ) ){

	// set the parameters of the main mobile menu
	function wtr_wp_nav_smart_menu() {
		global $post_settings;

		if( 'none' == $post_settings['wtr_page_nav_menu'] OR 2 != $post_settings['wtr_HeaderNavigationType'] ){
			return;
		}

		$depth = apply_filters( 'wtr_wp_nav_menu_depth', 3 );
		$args = array(
			'theme_location'	=> 'primary',
			'menu'				=> $post_settings['wtr_page_nav_menu'],
			'container'			=> 'div',
			'container_class'	=> 'dl-menuwrapper',
			'container_id'		=> 'dl-menu',
			'menu_class'		=> 'dl-menu',
			'menu_id'			=> '',
			'echo'				=> true,
			'fallback_cb'		=> 'WTR_Walker_Nav_Smart_Menu::fallback',
			'fallback_cb'		=> 'wtr_page_menu',
			'before'			=> '',
			'after'				=> '',
			'link_before'		=> '',
			'link_after'		=> '',
			'items_wrap'		=> '<ul id="%1$s" class="%2$s">%3$s</ul><a class="dl-trigger wtrAnimation wtrRadius2"><i class="fa fa-bars"></i></a>',
			'depth'				=> $depth,
			'walker'			=> new WTR_Walker_Nav_Smart_Menu,
		);
		echo '<div class="wtrSmartNavigation">';
						wp_nav_menu( $args );

			echo ' </div>';
	} // end wtr_wp_nav_smart_menu
}


if( ! class_exists( 'WTR_Walker_Nav_Smart_Menu' ) ) {

	class WTR_Walker_Nav_Smart_Menu extends Walker_Nav_Menu {

		private $menu_no_generate_link	= '';


		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<ul class=\"dl-submenu sub-menu\">\n";
		} // end start_lvl


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

			$this->menu_no_generate_link = trim( $item->wtr_menu_no_generate_link );

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
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= ( "enabled" == $this->menu_no_generate_link AND ! $args->has_children ) ? '</span>' : '</a>';
			$item_output .= $args->after;

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

	} // WTR_Walker_Nav_Smart_Menu
}