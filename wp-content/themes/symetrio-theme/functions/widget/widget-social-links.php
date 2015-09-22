<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! class_exists( 'WTR_Social_Links_Widget' ) ) {

	/**
	 * Adds WTR_Social_Links_Widget
	 */

	class WTR_Social_Links_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'wtrwidgetsocialicons', // Base ID
				WTR_THEME_NAME . ' ' . __( 'social links ', 'wtr_framework' ),
				array( 'description' => __( 'You can link Your social profiles here', 'wtr_framework' ), )
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

			global  $wtr_social_media;
			$title = apply_filters( 'widget_title', $instance['title'] );

			echo $args['before_widget'];

			if ( ! empty( $title ) ){
				echo $args['before_title'] . $title . $args['after_title'];
			}

			echo '<div class="wtrWidgetSocialIconsContainer clearfix">';
				echo '<ul class="wtrWidgetSocialIconsList clearfix">';
				foreach ( $wtr_social_media as $key => $value) {
					if( ! empty( $instance[ $key ] ) ) {
						echo '<li class="wtrWidgetSocialIconItem">';
							echo '<a href="' . esc_url( $instance[ $key ] ) . '" target="_blank" class="wtrWidgetSocialIconLink">';
								echo '<i class="' . esc_attr( $value['icon'] ) . '"></i>';
							echo '</a>';
						echo '</li>';
					}
				}
				echo '</ul>';
			echo '</div>';
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

			global $WTR_Opt, $wtr_social_media;

			$title 		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';

			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', WTR_THEME_NAME ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<?php
				foreach ( $wtr_social_media as $key => $value) {
					$social_media_link = isset( $instance[ $key ] ) ? esc_attr( $instance[ $key ] ) : $WTR_Opt->getopt( $key );
					?>
					<p>
						<label for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $value['title'] ?> : </label>
						<input class="widefat" id="<?php echo $this->get_field_id( $key ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" type="text" value="<?php echo esc_attr( $social_media_link ); ?>" />
					</p>
					<?php
				}
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
			global  $wtr_social_media;
			$instance['title']	= ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			foreach ( $wtr_social_media as $key => $value) {
				$instance[ $key ]	= ( ! empty( $new_instance[ $key ] ) ) ? strip_tags( $new_instance[ $key ] ) : '';
			}
			return $instance;
		} // end update
	} // end Foo_Widget
}