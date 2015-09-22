<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! class_exists( 'WTR_Tag_Cloud_Widget' ) ) {


	/**
	 * Adds WTR_Tag_Cloud_Widget
	 */
	class WTR_Tag_Cloud_Widget extends WP_Widget {

		function __construct() {
				parent::__construct(
					'wtrwidgettags', // Base ID
					WTR_THEME_NAME . ' ' . __( 'tag cloud ', 'wtr_framework' ),
					array( 'description' => __( 'This section shows used tags ', 'wtr_framework' ), )
				);
		} // end __construct


		function widget( $args, $instance ) {
			extract($args);
			$current_taxonomy = $this->_get_current_taxonomy($instance);
			if ( !empty($instance['title']) ) {
				$title = $instance['title'];
			} else {
				if ( 'post_tag' == $current_taxonomy ) {
					$title = __('Tags', WTR_THEME_NAME );
				} else {
					$tax = get_taxonomy($current_taxonomy);
					$title = $tax->labels->name;
				}
			}
			$title = apply_filters('widget_title', $title, $instance, $this->id_base);

			echo $before_widget;
			if ( $title ){
				echo $before_title . $title . $after_title;
			}

			$tags = get_terms( $current_taxonomy ) ;
			if( $tags){
				echo '<ul class="wtrWidgetTagsContainer clearfix">';
				foreach ($tags as $tag ) {
					$link = esc_url( get_term_link( $tag, $current_taxonomy ) );
					echo '<li class="wtrWidgetTagItem"><a class="wtrWidgetTagItemLink wtrRadius2 wtrAnimate" href="' . $link . '">' . $tag->name . '</a></li>';
				}
				echo '</ul>';
			}
			echo $after_widget;
		} // end widget


		function update( $new_instance, $old_instance ) {
			$instance['title'] = strip_tags(stripslashes($new_instance['title']));
			$instance['taxonomy'] = stripslashes($new_instance['taxonomy']);
			return $instance;
		} // end update


		function form( $instance ) {
			$current_taxonomy = $this->_get_current_taxonomy($instance);
			?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wtr_framework' ) ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if (isset ( $instance['title'])) {echo esc_attr( $instance['title'] );} ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e('Taxonomy:', 'wtr_framework' ) ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>">
		<?php foreach ( get_taxonomies() as $taxonomy ) :
					$tax = get_taxonomy($taxonomy);
					if ( !$tax->show_tagcloud || empty($tax->labels->name) )
						continue;
		?>
			<option value="<?php echo esc_attr($taxonomy) ?>" <?php selected($taxonomy, $current_taxonomy) ?>><?php echo $tax->labels->name; ?></option>
		<?php endforeach; ?>
		</select></p><?php
		} // end form


		function _get_current_taxonomy($instance) {
			if ( !empty($instance['taxonomy']) && taxonomy_exists($instance['taxonomy']) )
				return $instance['taxonomy'];
			return 'post_tag';
		} // end _get_current_taxonomy
	} // end WTR_Tag_Cloud_Widget
}