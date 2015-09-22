<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! class_exists( 'WTR_Menu_Widget' ) ) {

	/**
	 * Adds WTR_Menu_Widget
	 */

	class WTR_Menu_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		function __construct() {

			parent::__construct(
				'wtrwidgetnavigation', // Base ID
				WTR_THEME_NAME . ' ' . __( 'menu', 'wtr_framework' ),
				array( 'description' => __( 'You can create custome navigation', 'wtr_framework' ), )
			);
		} // end __construct

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {

			global $post;
			$title				= ( 1 == $instance['page_title'] ) ? wp_title( '', false ) :  $instance['title'] ;
			$title				= apply_filters( 'widget_title', $title );
			$pages				= array();
			$exclude			= ( ! empty( $instance['exclude'] ) ) ? $instance['exclude'] : '';
			$exclude_children	= ( ! empty( $instance['exclude_children'] ) ) ? false : true;

			echo $args['before_widget'];

			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			// sibling
			if( 0 == $instance['menu_type'] ){
				$parent_id	=  is_page( ) ? $post->post_parent : 0;
			// children
			}else  if( 1 == $instance['menu_type'] OR 2 == $instance['menu_type'] ){
				$parent_id	=  is_page( ) ? $post->ID : false;
			}

			$attr = array(
				'title_li'			=> '',
				'depth'				=> $instance['depth'],
				'child_of'			=> $parent_id,
				'echo'				=> 0,
				'exclude'			=> $exclude,
				'exclude_children'	=> $exclude_children,
				'walker'			=> new WTR_Walker_Page,
			);

			if( false !== $parent_id ){
				$pages = wp_list_pages( $attr );
			}

			if( 2 == $instance['menu_type'] AND empty( $pages ) ){
				$attr['child_of'] = is_page( ) ? $post->post_parent : 0;;
				$pages = wp_list_pages( $attr );
			}

			if( $pages ) {
				echo '<ul class="wtrWidgetNavigationFirstLvl">';
					echo $pages;
				echo '</ul>';
			}

			echo $args['after_widget'];
		} // end widget

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {

			$title				= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$page_title			= isset( $instance['page_title'] ) ? absint( $instance['page_title'] ) : 0;
			$menu_type			= isset( $instance['menu_type'] ) ? absint( $instance['menu_type'] ) : 0;
			$depth				= isset( $instance['depth'] ) ? absint( $instance['depth'] ) : 1;
			$exclude			= isset( $instance['exclude'] ) ? esc_attr( $instance['exclude'] ) : '';
			$exclude_children	= isset( $instance['exclude_children'] ) ? absint( $instance['exclude_children'] ) : 0;

			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wtr_framework' ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'page_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'page_title' ) ); ?>" type="checkbox" value="1" <?php if( esc_attr( $page_title ) ) { echo "checked='checked'";} ?>" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'page_title' ) ); ?>"><?php _e( 'Use current page title', 'wtr_framework' ); ?></label>
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'menu_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'menu_type' ) ); ?>" type="radio" value="0" <?php checked( $menu_type, 0 ) ?>" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'menu_type' ) ); ?>"><?php _e( 'Show page siblings', 'wtr_framework' ); ?></label>
				<br/>
				<input id="<?php echo esc_attr( $this->get_field_id( 'menu_type_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'menu_type' ) ); ?>" type="radio" value="1" <?php checked( $menu_type, 1 ) ?>" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'menu_type_2' ) ); ?>"><?php _e( 'Show page children', 'wtr_framework' ); ?></label>
				<br/>
				<input id="<?php echo esc_attr( $this->get_field_id( 'menu_type_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'menu_type' ) ); ?>" type="radio" value="2" <?php checked( $menu_type, 2 ) ?>" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'menu_type_3' ) ); ?>"><?php _e( 'Show page children (if there is no children, show siblings)', 'wtr_framework' ); ?></label>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'depth' ) ); ?>"><?php _e( 'Enable nested menu', 'wtr_framework' ); ?> : </label>
				<br/>
				<input id="<?php echo esc_attr( $this->get_field_id( 'depth_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'depth' ) ); ?>" type="radio" value="0" <?php checked( $depth, 0 ) ?>" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'depth_2' ) ); ?>"><?php _e( 'Yes', 'wtr_framework' ); ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'depth_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'depth' ) ); ?>" type="radio" value="1" <?php checked( $depth, 1 ) ?>" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'depth_3' ) ); ?>"><?php _e( 'No', 'wtr_framework' ); ?></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'exclude' ); ?>"><?php _e( 'Exclude', 'wtr_framework' ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'exclude' ); ?>" name="<?php echo $this->get_field_name( 'exclude' ); ?>" type="text" value="<?php echo esc_attr( $exclude ); ?>" />
				<br>
				<small><?php _e( 'Page IDs, separated by commas.' ); ?> </small>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'exclude_children' ) ); ?>"><?php _e( 'Exclude page childrens ', 'wtr_framework' ); ?> : </label>
				<br/>
				<input id="<?php echo esc_attr( $this->get_field_id( 'exclude_children_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'exclude_children' ) ); ?>" type="radio" value="0" <?php checked( $exclude_children, 0 ) ?>" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'exclude_children_2' ) ); ?>"><?php _e( 'Yes', 'wtr_framework' ); ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'exclude_children_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'exclude_children' ) ); ?>" type="radio" value="1" <?php checked( $exclude_children, 1 ) ?>" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'exclude_children_3' ) ); ?>"><?php _e( 'No', 'wtr_framework' ); ?></label>
				<br>
				<small><?php _e( 'If nested menu is enabled' ); ?> </small>
			</p>
			<?php
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {

			$instance						= array();
			$instance['title']				= ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['page_title']			= ( ! empty( $new_instance['page_title'] ) ) ? strip_tags( $new_instance['page_title'] ) : '';
			$instance['menu_type']			= ( ! empty( $new_instance['menu_type'] ) ) ? strip_tags( $new_instance['menu_type'] ) : '';
			$instance['depth']				= ( ! empty( $new_instance['depth'] ) ) ? strip_tags( $new_instance['depth'] ) : 0;
			$instance['exclude']			= ( ! empty( $new_instance['exclude'] ) ) ? strip_tags( $new_instance['exclude'] ) : '';
			$instance['exclude_children']	= ( ! empty( $new_instance['exclude_children'] ) ) ? strip_tags( $new_instance['exclude_children'] ) : 0;


			return $instance;
		} // end form
	} // end WTR_Menu_Widget
}


class WTR_Walker_Page extends Walker_Page {
	/**
	 * Display array of elements hierarchically.
	 *
	 * Does not assume any existing order of elements.
	 *
	 * $max_depth = -1 means flatly display every element.
	 * $max_depth = 0 means display all levels.
	 * $max_depth > 0 specifies the number of display levels.
	 *
	 * @since 2.1.0
	 *
	 * @param array $elements  An array of elements.
	 * @param int   $max_depth The maximum hierarchical depth.
	 * @return string The hierarchical item output.
	 */
	public function walk( $elements, $max_depth) {

		$args = array_slice(func_get_args(), 2);
		$output = '';
		if(! empty( $args[0]['exclude'] ) AND ! empty( $args[0]['exclude_children'] ) ){
			$exclude			= explode(',', $args[0]['exclude']);
			$exclude_elements	= array();
			foreach ($exclude as $e) {
				$childs = get_page_children( $e, $elements );
				if( $childs ){
					foreach ($childs as $ch) {
						$exclude_elements[ $ch->ID ] = $ch->ID;
					}
				}
			}
			if( ! empty( $exclude_elements ) ){
				foreach ( $elements as $key => $e ){
					if( isset($exclude_elements[ $e->ID ])){
						unset($elements[$key]);
					}
				}
			}
		}

		if ($max_depth < -1) //invalid parameter
			return $output;

		if (empty($elements)) //nothing to walk
			return $output;

		$parent_field = $this->db_fields['parent'];

		// flat display
		if ( -1 == $max_depth ) {
			$empty_array = array();
			foreach ( $elements as $e )
				$this->display_element( $e, $empty_array, 1, 0, $args, $output );
			return $output;
		}

		/*
		 * Need to display in hierarchical order.
		 * Separate elements into two buckets: top level and children elements.
		 * Children_elements is two dimensional array, eg.
		 * Children_elements[10][] contains all sub-elements whose parent is 10.
		 */
		$top_level_elements = array();
		$children_elements  = array();
		foreach ( $elements as $e) {
			if ( 0 == $e->$parent_field )
				$top_level_elements[] = $e;
			else
				$children_elements[ $e->$parent_field ][] = $e;
		}

		/*
		 * When none of the elements is top level.
		 * Assume the first one must be root of the sub elements.
		 */
		if ( empty($top_level_elements) ) {

			$first = array_slice( $elements, 0, 1 );
			$root = $first[0];

			$top_level_elements = array();
			$children_elements  = array();
			foreach ( $elements as $e) {
				if ( $root->$parent_field == $e->$parent_field )
					$top_level_elements[] = $e;
				else
					$children_elements[ $e->$parent_field ][] = $e;
			}
		}

		foreach ( $top_level_elements as $e )
			$this->display_element( $e, $children_elements, $max_depth, 0, $args, $output );

		/*
		 * If we are displaying all levels, and remaining children_elements is not empty,
		 * then we got orphans, which should be displayed regardless.
		 */
		if ( ( $max_depth == 0 ) && count( $children_elements ) > 0 ) {
			$empty_array = array();
			foreach ( $children_elements as $orphans )
				foreach( $orphans as $op )
					$this->display_element( $op, $empty_array, 1, 0, $args, $output );
		 }

		 return $output;
	}

	/**
	 * @see Walker::start_lvl()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 * @param array $args
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);

		$class = 'children';

		if( 1 == $depth ) {
			$class .= ' wtrWidgetNavigationSecondLvl';
		} else {
			$class .= 'wtrWidgetNavigationThirdLvl';
		}

		$output .= "\n$indent<ul class='" . $class . "''>\n";
	}

	/**
	 * @see Walker::start_el()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $page Page data object.
	 * @param int $depth Depth of page. Used for padding.
	 * @param int $current_page Page ID.
	 * @param array $args
	 */
	function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {
		if ( $depth )
			$indent = str_repeat("\t", $depth);
		else
			$indent = '';

		extract($args, EXTR_SKIP);
		$css_class = array('page_item', 'page-item-'.$page->ID);

		if( isset( $args['pages_with_children'][ $page->ID ] ) )
			$css_class[] = 'page_item_has_children';

		if ( !empty($current_page) ) {
			$_current_page = get_post( $current_page );
			if ( in_array( $page->ID, $_current_page->ancestors ) )
				$css_class[] = 'current_page_ancestor';
			if ( $page->ID == $current_page )
				$css_class[] = 'current_page_item';
			elseif ( $_current_page && $page->ID == $_current_page->post_parent )
				$css_class[] = 'current_page_parent';
		} elseif ( $page->ID == get_option('page_for_posts') ) {
			$css_class[] = 'current_page_parent';
		}

		/**
		 * Filter the list of CSS classes to include with each page item in the list.
		 *
		 * @since 2.8.0
		 *
		 * @see wp_list_pages()
		 *
		 * @param array   $css_class    An array of CSS classes to be applied
		 *                             to each list item.
		 * @param WP_Post $page         Page data object.
		 * @param int     $depth        Depth of page, used for padding.
		 * @param array   $args         An array of arguments.
		 * @param int     $current_page ID of the current page.
		 */

		if( 0 == $depth ) {
			$css_class[] = 'wtrWidgetNavigationFirstLvlItem';
		} else if( 1 == $depth ) {
			$css_class[] = 'wtrWidgetNavigationSecondLvl';
		} else {
			$css_class[] = 'wtrWidgetNavigationThirdLvlItem';
		}

		$css_class = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );

		if ( '' === $page->post_title ){
			$page->post_title = sprintf( __( '#%d (no title)', WTR_THEME_NAME ), $page->ID );
		}

		/** This filter is documented in wp-includes/post-template.php */
		$output .= $indent . '<li class="' . $css_class . '"><a href="' . get_permalink($page->ID) . '">' . $link_before . apply_filters( 'the_title', $page->post_title, $page->ID ) . $link_after . '</a>';

		if ( !empty($show_date) ) {
			if ( 'modified' == $show_date )
				$time = $page->post_modified;
			else
				$time = $page->post_date;

			$output .= " " . mysql2date($date_format, $time);
		}
	}

}