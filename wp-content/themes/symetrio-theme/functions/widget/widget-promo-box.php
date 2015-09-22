<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! class_exists( 'WTR_Promo_Box_Widget' ) ) {

	/**
	 * Adds WTR_Promo_Box_Widget
	 */

	class WTR_Promo_Box_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		function __construct() {

			parent::__construct(
				'wtrwidgetpromo', // Base ID
				WTR_THEME_NAME . ' ' . __( 'promo box', 'wtr_framework' ),
				array( 'description' => __( 'You can Use this section to write some conspicuous text', 'wtr_framework' ), )
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

			$title 			= apply_filters( 'widget_title', $instance['title'] );
			$subtitle 		= $instance['subtitle'] ;
			$button_link 	= $instance['button_link'];
			$button_label 	= $instance['button_label'];
			$target 		=  ( 1 == $instance['button_target'] ) ? 'target="_blank"': '';

			echo $args['before_widget'];

			if ( ! empty( $title ) ){
				echo $args['before_title'] . $title . $args['after_title'];
			}

			if( $subtitle ){
				echo '<p>' . $subtitle . '</p>';
			}

			if( !empty( $button_link ) AND !empty( $button_label ) ) {
				echo '<div class="wtrWidgetPromoButton">';
					echo '<a  ' . $target . ' href="' . esc_url( $button_link ) . '" class="wtrDefStdButton"> ' . $button_label . '</a>';
				echo '</div>';
			}

			echo $args['after_widget'];
		} // emd widget


		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {

			$title 			= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$subtitle		= isset( $instance['subtitle'] ) ? esc_attr( $instance['subtitle'] ) : '';

			$button_link	= isset( $instance['button_link'] ) ? esc_attr( $instance['button_link'] ) : '';
			$button_label	= isset( $instance['button_label'] ) ? esc_attr( $instance['button_label'] ) : '';
			$button_target	= isset( $instance['button_target'] ) ? esc_attr( $instance['button_target'] ) : '0';
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', WTR_THEME_NAME ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php _e( 'Subtitle', WTR_THEME_NAME ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" type="text" value="<?php echo esc_attr( $subtitle ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'button_link' ); ?>"><?php _e( 'Button Link', WTR_THEME_NAME ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'button_link' ); ?>" name="<?php echo $this->get_field_name( 'button_link' ); ?>" type="text" value="<?php echo esc_attr( $button_link ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'button_label' ); ?>"><?php _e( 'Button Label', WTR_THEME_NAME ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'button_label' ); ?>" name="<?php echo $this->get_field_name( 'button_label' ); ?>" type="text" value="<?php echo esc_attr( $button_label ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'button_target' ) ); ?>"><?php _e( 'Open Link in new Window', WTR_THEME_NAME ); ?> : </label>
				<br/>
				<input id="<?php echo esc_attr( $this->get_field_id( 'button_target_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_target' ) ); ?>" type="radio" value="1" <?php checked( $button_target, 1 ) ?>" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'button_target_2' ) ); ?>"><?php _e( 'Yes', WTR_THEME_NAME ); ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'button_target_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_target' ) ); ?>" type="radio" value="0" <?php checked( $button_target, 0 ) ?>" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'button_target_3' ) ); ?>"><?php _e( 'No', WTR_THEME_NAME ); ?></label>
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

			$instance					= array();
			$instance['title']			= ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['subtitle']		= ( ! empty( $new_instance['subtitle'] ) ) ? strip_tags( $new_instance['subtitle'] ) : '';
			$instance['button_link']	= ( ! empty( $new_instance['button_link'] ) ) ? strip_tags( $new_instance['button_link'] ) : '';
			$instance['button_label']	= ( ! empty( $new_instance['button_label'] ) ) ? strip_tags( $new_instance['button_label'] ) : '';
			$instance['button_target']	= ( ! empty( $new_instance['button_target'] ) ) ? strip_tags( $new_instance['button_target'] ) : '0';

			return $instance;
		} // end update
	} // class Foo_Widget
}