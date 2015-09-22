<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! class_exists( 'WTR_Open_Hours_Widget' ) ) {

	/**
	 * Adds WTR_Open_Hours_Widget
	 */

	class WTR_Open_Hours_Widget extends WP_Widget {

		private $days_type	= array();

		/**
		 * Register widget with WordPress.
		 */
		function __construct() {

			$this->days_type = array(
					1 => __( 'Label ( Monday )', 'wtr_framework' ),
					2 => __( 'Label ( Tuesday )', 'wtr_framework' ),
					3 => __( 'Label ( Wednesday )', 'wtr_framework' ),
					4 => __( 'Label ( Thursday )', 'wtr_framework' ),
					5 => __( 'Label ( Friday )', 'wtr_framework' ),
					6 => __( 'Label ( Saturday )', 'wtr_framework' ),
					7 => __( 'Label ( Sunday )', 'wtr_framework' ),
				);
			parent::__construct(
				'wtrwidgetopenhours', // Base ID
				WTR_THEME_NAME . ' ' . __( 'open hours', 'wtr_framework' ),
				array( 'description' => __( 'Opening hours for a whole week', 'wtr_framework' ), )
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

			global $post_settings, $post;

			$title			= apply_filters( 'widget_title', $instance['title'] );
			$days			= $instance['days'];


			echo $args['before_widget'];

			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			echo '<div class="wtrWidgetOpenHoursContainer">';
				foreach ( $days as $day ) {
					if( ! empty( $day[4] ) ){
						$label					= $day[4];
						$opening_time			= $day[0];
						$opening_time_format	= ( 0 == $day[1] ) ? '' : ( ( 1 == $day[1] ) ? __( 'PM', WTR_THEME_NAME )  : __( 'AM', WTR_THEME_NAME ) );
						$closing_time			= $day[2];
						$closing_time_format	= ( 0 == $day[3] ) ? '' : ( ( 1 == $day[3] ) ? __( 'PM', WTR_THEME_NAME )  : __( 'AM', WTR_THEME_NAME ) );

						echo '<div class="wtrWidgetOpenHoursItem">';
							echo '<div class="wtrWidgetOpenHoursItemShedule clearfix">';
								echo '<i class="wtrWidgetOpenIcon fa fa-clock-o"></i>';
								echo '<div class="wtrWidgetOpenHoursMeta	 clearfix">';
									echo '<h5 class="wtrWidgetOpenHoursDay">' . $label . '</h5>';
									echo '<div class="wtrWidgetOpenHoursTime">' . $opening_time  . ' ' . $opening_time_format . ' - ' . $closing_time . '' . $closing_time_format . '</div>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
					}
				}
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

			$title				= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$days				= isset( $instance['days'] ) ? $instance['days'] : $this->set_days() ;

			?>
			<p><?php _e( 'Fields left blank will be ignored', 'wtr_framework' ) ?></a></p>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wtr_framework' ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>

			<?php foreach ( $days as $key => $value ) { ?>
				<hr>
				<p>
					<label for="<?php echo $this->get_field_id( 'days_' . $key . '4' ); ?>"><?php echo $this->days_type[ $key ] ?> : </label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'days_' . $key . '4' ); ?>" name="<?php echo $this->get_field_name( 'days' ); ?>[<?php echo $key ?>][4]" type="text" value="<?php echo esc_attr( $value[4] ); ?>" />
				</p>
				<p>
					<label><?php _e( 'Opening time', 'wtr_framework' ); ?></label>
					<label style=" padding-left: 60px;"><?php _e( 'Closing time', 'wtr_framework' ); ?></label>
				</p>
				<p>
					<input style="width:25%;vertical-align: middle;height:28px;" class="" id="<?php echo $this->get_field_id( 'days_' . $key . '0' ); ?>" name="<?php echo $this->get_field_name( 'days' ); ?>[<?php echo $key ?>][0]" type="text" value="<?php echo esc_attr( $value[0] ); ?>" />
					<select style="" class="" id="<?php echo esc_attr( $this->get_field_id( 'days_' . $key . '1' ) ); ?>" name="<?php echo $this->get_field_name( 'days' ); ?>[<?php echo $key ?>][1]" >
						<option value="0" <?php selected( $value[1], '0' ); ?> ><?php _e( '--', 'wtr_framework' ); ?></option>
						<option value="1" <?php selected( $value[1], '1' ); ?> ><?php _e( 'PM', 'wtr_framework' ); ?></option>
						<option value="2" <?php selected( $value[1], '2' ); ?> ><?php _e( 'AM', 'wtr_framework' ); ?></option>
					</select>
					-
					<input style="width:25%;vertical-align: middle;height:28px;" class="" id="<?php echo $this->get_field_id( 'days_' . $key . '3' ); ?>" name="<?php echo $this->get_field_name( 'days' ); ?>[<?php echo $key ?>][2]" type="text" value="<?php echo esc_attr( $value[2]  ); ?>" />
					<select style="" class="" id="'days_' . $key . '3'" name="<?php echo $this->get_field_name( 'days' ); ?>[<?php echo $key ?>][3]" >
						<option value="0" <?php selected( $value[3], '0' ); ?> ><?php _e( '--', 'wtr_framework' ); ?></option>
						<option value="1" <?php selected( $value[3], '1' ); ?> ><?php _e( 'PM', 'wtr_framework' ); ?></option>
						<option value="2" <?php selected( $value[3], '2' ); ?> ><?php _e( 'AM', 'wtr_framework' ); ?></option>
					</select>
					</br>
				</p>
			<?php }
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
			$instance['label_url']		= ( ! empty( $new_instance['label_url'] ) ) ? strip_tags( $new_instance['label_url'] ) : '';
			$instance['url']			= ( ! empty( $new_instance['url'] ) ) ? strip_tags( $new_instance['url'] ) : '';
			$instance['text']			= ( ! empty( $new_instance['text'] ) ) ? strip_tags( $new_instance['text'] ) : '';
			$instance['date_format']	= ( ! empty( $new_instance['date_format'] ) ) ? strip_tags( $new_instance['date_format'] ) : '';
			$instance['days']			= ( ! empty( $new_instance['days'] ) ) ? ( $new_instance['days'] ) : $this->set_days() ;

			return $instance;
		} // end update


		private function set_days(){
			$data = array_flip( range( 1, 7) );
			foreach ( $data as $key => $value) {
				$days[ $key ] = array( 0 => '', 1 => 'AM', 2 => '', 3 => 'PM', 4 => '' );
			}
			return $days;
		} // end set_days
	} // end WTR_Open_Hours_Widget
}