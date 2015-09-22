<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! class_exists( 'WTR_Todays_Open_Hours_Widget' ) ) {

	/**
	 * Adds WTR_Todays_Open_Hours_Widget
	 */

	class WTR_Todays_Open_Hours_Widget extends WP_Widget {

		private $date_type	= array();
		private $days_type	= array();

		/**
		 * Register widget with WordPress.
		 */
		function __construct() {

			$this->date_type = array(
					'd.m' => __( '20.10', 'wtr_framework' ),
					'm.d' => __( '10.20', 'wtr_framework' ),
					'd/m' => __( '20/10', 'wtr_framework' ),
					'm/d' => __( '10/20', 'wtr_framework' ),
					'd M' => __( '19 Oct', 'wtr_framework' ),
					'M d' => __( 'Oct 19', 'wtr_framework' ),
					'd F' => __( '19 October', 'wtr_framework' ),
					'F d' => __( 'October 19', 'wtr_framework' ),
				);

			$this->days_type = array(
					1 => __( 'Monday', 'wtr_framework' ),
					2 => __( 'Tuesday', 'wtr_framework' ),
					3 => __( 'Wednesday', 'wtr_framework' ),
					4 => __( 'Thursday', 'wtr_framework' ),
					5 => __( 'Friday', 'wtr_framework' ),
					6 => __( 'Saturday', 'wtr_framework' ),
					7 => __( 'Sunday', 'wtr_framework' ),
				);

			parent::__construct(
				'wtrwidgettodayis', // Base ID
				WTR_THEME_NAME . ' ' . __( 'todays open hours', 'wtr_framework' ),
				array( 'description' => __( 'Opening hours for the current day of the week', 'wtr_framework' ), )
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
			$label_url		= $instance['label_url'];
			$url			= $instance['url'];
			$text			= $instance['text'];
			$date_format	= $instance['date_format'];
			$date			= date_i18n( $date_format );
			$days			= $instance['days'];
			$date_title		= '<span class="wtrWidgetTodayIsADay wtrDefFontCharacter">' . date_i18n( $date_format ) .'</span>';


			$current_day			= date("N");
			$opening_time			= $days[ $current_day ][0];
			$opening_time_format	= ( 0 == $days[ $current_day ][1] ) ? '' : '<span>' . ( ( 1 == $days[ $current_day ][1] ) ? __( 'PM', WTR_THEME_NAME )  : __( 'AM', WTR_THEME_NAME ) ) . '</span>';
			$closing_time			= $days[ $current_day ][2];
			$closing_time_format	= ( 0 == $days[ $current_day ][3] ) ? '' : '<span>' .( ( 1 == $days[ $current_day ][3] ) ? __( 'PM', WTR_THEME_NAME )  : __( 'AM', WTR_THEME_NAME ) ). '</span>';

			echo $args['before_widget'];

			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . ' '. $date_title .$args['after_title'];
			}


			echo '<div class="wtrWidgetTodayIsContainer clearfix">';
				if( $opening_time OR $closing_time ){
					echo '<div class="wtrWidgetTodayIsOpenHours">';
						echo '<i class="fa fa-clock-o"></i>';
						if( $opening_time ){
							echo '<span class="wtrWidgetTodayIsOpenHoursTime">' . $opening_time . '' . $opening_time_format . '</span>';
						}
						if( $closing_time ){
							echo ' <span class="wtrWidgetTodayIsOpenHoursTime">' . $closing_time . '' . $closing_time_format . '</span>';
						}
					echo '</div>';
				}
				if( $text ){
					echo '<p class="wtrWidgetTodayIsDesc">';
						echo $text;
					echo '</p>';
				}
				if( ! empty( $url )  AND ! empty( $label_url ) ){
					echo '<a class="wtrWidgetTodayIsLink" href="' . esc_url( $url ) . '">'. $label_url .'</a>';
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
			$label_url			= isset( $instance['label_url'] ) ? esc_attr( $instance['label_url'] ) : '';
			$url				= isset( $instance['url'] ) ? esc_attr( $instance['url'] ) : '';
			$text				= isset( $instance['text'] ) ? esc_attr( $instance['text'] ) : '';
			$date_format		= isset( $instance['date_format'] ) ? esc_attr( $instance['date_format'] ) : '';
			$days				= isset( $instance['days'] ) ? $instance['days'] : $this->set_days() ;

			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wtr_framework' ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'label_url' ); ?>"><?php _e( 'Label URL', 'wtr_framework' ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'label_url' ); ?>" name="<?php echo $this->get_field_name( 'label_url' ); ?>" type="text" value="<?php echo esc_attr( $label_url ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'URL', 'wtr_framework' ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_url( $url ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Text', 'wtr_framework' ); ?> : </label>
			</p>
			<textarea id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"  cols="20" rows="5" class="widefat"><?php echo esc_attr( $text ); ?></textarea>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'date_format' ) ); ?>"><?php _e( 'Date format', 'wtr_framework' ); ?> : </label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'date_format' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date_format' ) ); ?>" >
					<?php
					foreach ( $this->date_type as $key => $value ){
						echo '<option value="'. esc_attr( $key ) . '"  ' . selected( $date_format, $key ) . '> ' . $value . '</option>';
					} ?>
				</select>
			</p>

			<?php foreach ( $days as $key => $value ) { ?>
				<hr>
				<p>
					<label><?php echo $this->days_type[ $key ] ?> : </label>
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
				$days[ $key ] = array( 0 => '', 1 => 'AM', 2 => '', 3 => 'PM' );
			}
			return $days;
		} // end set_days
	} // end WTR_Todays_Open_Hours_Widget
}