<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! class_exists( 'WTR_Facebook_Like_Box_Widget' ) ) {

	/**
	 * Adds WTR_Facebook_Like_Box_Widget
	 */

	class WTR_Facebook_Like_Box_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'wtr_facebook_like_box', // Base ID
				WTR_THEME_NAME . ' ' . __( 'facebook like box ', 'wtr_framework' ),
				array( 'description' => __( 'You can link You Facebook fanpage here', 'wtr_framework' ), )
			);

			if ( is_active_widget( false, false, $this->id_base, true ) ) {
				add_action( 'wp_enqueue_scripts', array( &$this, 'js'), 30 );
			}
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

			$title 				= apply_filters( 'widget_title', $instance['title'] );
			$page_url 			= $instance['page_url'];
			$show_faces 		= $instance['show_faces'];
			$show_stream 		= $instance['show_stream'];
			$show_header 		= $instance['show_header'];
			$cover_photo 		= isset( $instance['cover_photo'] ) ? $instance['cover_photo'] : 'false';
			$container_width	= isset( $instance['container_width'] ) ? $instance['container_width'] : 'false';
			$width 				= $instance['width'];
			$height 			= isset( $instance['height'] ) ? $instance['height'] : '';


			echo $args['before_widget'];

			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			if($page_url): ?>
				<div class="fb-page"
				data-href="<?php echo urldecode($page_url); ?>"
				data-width="<?php echo $width; ?>"
				data-height="<?php echo $height; ?>"
				data-small-header="<?php echo $show_header; ?>"
				data-adapt-container-width="<?php echo $container_width; ?>"
				data-hide-cover="<?php echo $cover_photo; ?>"
				data-show-facepile="<?php echo $show_faces; ?>"
				data-show-posts="<?php echo $show_stream; ?>">
				></div>
			<?php endif;
			echo $args['after_widget'];
		} // end widget


		/**
		 * Include Facebook SDK for JavaScript
		 */
		public function js() {
			wp_enqueue_script( 'facebook-dsk', WTR_THEME_URI . '/assets/js/facebook-dsk.js', null, WTR_THEME_VERSION, true );
			$param = array(
				'locale' => get_locale(),
			);
			wp_localize_script( 'facebook-dsk', 'wtr_facebook_data', $param );
		} //end js


		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {

			$title 				= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$height 			= isset( $instance['height'] ) ? esc_attr( $instance['height'] ) : '';
			$width 				= isset( $instance['width'] ) ? esc_attr( $instance['width'] ) : '292';
			$page_url			= isset( $instance['page_url'] ) ? esc_attr( $instance['page_url'] ) : '';
			$show_faces			= isset( $instance['show_faces'] ) ? esc_attr( $instance['show_faces'] ) : '';
			$show_stream		= isset( $instance['show_stream'] ) ? esc_attr( $instance['show_stream'] ) : '';
			$show_header		= isset( $instance['show_header'] ) ? esc_attr( $instance['show_header'] ) : '';
			$container_width	= isset( $instance['container_width'] ) ? esc_attr( $instance['container_width'] ) : '';
			$cover_photo		= isset( $instance['cover_photo'] ) ? esc_attr( $instance['cover_photo'] ) : '';
			?>

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wtr_framework' ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('page_url'); ?>"><?php _e( 'Facebook Page URL', 'wtr_framework' ); ?> :</label>
				<input class="widefat" id="<?php echo $this->get_field_id('page_url'); ?>" name="<?php echo $this->get_field_name('page_url'); ?>" type="text" value="<?php echo $page_url; ?>" />
				
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e( 'Height', 'wtr_framework' ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" type="text" value="<?php echo esc_attr( $height ); ?>" />
				<small><?php _e('The pixel height of the embed (Min. 70)', 'wtr_framework' ) ?></small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e( 'Width', 'wtr_framework' ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo esc_attr( $width ); ?>" />
				<small><?php _e('The pixel width of the embed (Min. 180 to Max. 500)', 'wtr_framework' ) ?></small>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $container_width, 'true'); ?> value="true" id="<?php echo $this->get_field_id('container_width'); ?>" name="<?php echo $this->get_field_name('container_width'); ?>" />
				<label for="<?php echo $this->get_field_id('container_width'); ?>"><?php _e('Adapt to plugin container width', 'wtr_framework' ); ?></label>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $cover_photo, 'true'); ?> value="true" id="<?php echo $this->get_field_id('cover_photo'); ?>" name="<?php echo $this->get_field_name('cover_photo'); ?>" />
				<label for="<?php echo $this->get_field_id('cover_photo'); ?>"><?php _e('Hide Cover Photo', 'wtr_framework' ); ?></label>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $show_faces , 'true'); ?> value="true" id="<?php echo $this->get_field_id('show_faces'); ?>" name="<?php echo $this->get_field_name('show_faces'); ?>" />
				<label for="<?php echo $this->get_field_id('show_faces'); ?>"><?php _e('Show faces', 'wtr_framework' ); ?></label>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $show_stream, 'true'); ?> value="true" id="<?php echo $this->get_field_id('show_stream'); ?>" name="<?php echo $this->get_field_name('show_stream'); ?>" />
				<label for="<?php echo $this->get_field_id('show_stream'); ?>"><?php _e('Show stream', 'wtr_framework' ); ?></label>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $show_header, 'true'); ?> value="true" id="<?php echo $this->get_field_id('show_header'); ?>" name="<?php echo $this->get_field_name('show_header'); ?>" />
				<label for="<?php echo $this->get_field_id('show_header'); ?>"><?php _e('Use Small Header', 'wtr_framework' ); ?></label>
			</p>
			<?php
		} // end form

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

			$instance 						= array();
			$instance['title']				= ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['page_url'] 			= ( ! empty( $new_instance['page_url'] ) ) ? strip_tags( $new_instance['page_url'] ) : '';
			$instance['width'] 				= ( ! empty( $new_instance['width'] ) ) ? strip_tags( $new_instance['width'] ) : '';
			$instance['height'] 			= ( ! empty( $new_instance['height'] ) ) ? strip_tags( $new_instance['height'] ) : '';
			$instance['show_faces']			= ( ! empty( $new_instance['show_faces'] ) ) ? strip_tags( $new_instance['show_faces'] ) : 'false';
			$instance['show_stream']		= ( ! empty( $new_instance['show_stream'] ) ) ? strip_tags( $new_instance['show_stream'] ) : 'false';
			$instance['show_header']		= ( ! empty( $new_instance['show_header'] ) ) ? strip_tags( $new_instance['show_header'] ) : 'false';
			$instance['cover_photo']		= ( ! empty( $new_instance['cover_photo'] ) ) ? strip_tags( $new_instance['cover_photo'] ) : 'false';
			$instance['container_width']	= ( ! empty( $new_instance['container_width'] ) ) ? strip_tags( $new_instance['container_width'] ) : 'false';

			return $instance;
		} // end update

	} // class Foo_Widget
}