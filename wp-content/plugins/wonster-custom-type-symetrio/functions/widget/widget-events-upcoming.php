<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! class_exists( 'WTR_Events_Upcoming_Widget' ) ) {

	/**
	 * Adds WTR_Events_Upcoming_Widget
	 */

	class WTR_Events_Upcoming_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'wtrwidgeteventcountdown', // Base ID
				WTR_THEME_NAME . ' ' . __( ' upcoming events', 'wtr_ct_framework' ),
				array( 'description' => __( 'This section shows events', 'wtr_ct_framework' ), )
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
			$categorie		= $instance['categorie'];
			$tax_query		= null;

			if( $categorie ){
				$tax_query = array(
					array(
						'taxonomy'			=> 'events-category',
						'field'				=> 'slug',
						'terms'				=> $categorie,
						'include_children'	=> false
					)
				);
			}

			$query_args = array(
				'post_type'			=> 'events',
				'posts_per_page'	=> 1,
				'orderby'			=> 'meta_value',
				'order'				=> 'ASC',
				'meta_key'			=> '_wtr_event_time_start',
				'meta_query'		=> array(
					array(
						'key'		=> '_wtr_event_time_start',
						'value'		=> current_time( "timestamp" ),
						'compare'	=> '>=',
					),
				),
				'tax_query'			=> $tax_query,
			);

			// The Query
			$the_query = new WP_Query( $query_args );

			echo $args['before_widget'];

			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();

					$id					= get_the_id();
					$event_title		= get_the_title();
					$url				= esc_url( get_permalink() );
					$time_start			= get_post_meta( $id, '_wtr_event_time_start', true );
					$date				= date_i18n( $post_settings['wtr_EventDateFormat']['all'], $time_start );
					$price				= trim( get_post_meta( $id, '_wtr_event_price', true ) );
					$post_thumbnail_id	= get_post_thumbnail_id( $id );
					$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_2' );
					$image_alt			= esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) );
					$image				= ( $image_attributes[0] ) ? '<img class="wtrWidgetEventCountdownImg" alt="' . $image_alt . '" src="' . $image_attributes[0] . '">' : '';
					$class				= (! empty( $image ) ) ? '' : 'noPhoto';
					$time_format		= get_post_meta( $id, '_wtr_event_time_start_type', true );
					$time_m				= get_post_meta( $id, '_wtr_event_time_start_m', true );
					$time_h				= get_post_meta( $id, '_wtr_event_time_start_h', true );
					$time_h				= $this->convert_event_time( $time_format, $time_h );

					echo '<div class="wtrWidgetCountdownContainer ' . $class .' clearfix">';
						echo '<div class="wtrWidgetEventCountdownMetaContainer">';
							echo '<div class="wtrWidgetCountdownDate wtrWidgetAnimation">' . $date . '</div>';

							if( strlen( $price ) ){
								echo '<div class="wtrWidgetCountdownPrice ">' . $price . '</div>';
							}

							echo '<div class="wtrWidgetCountdown clearfix wtrWidgetAnimation" data-year="' . esc_attr( date( 'Y', $time_start ) ) . '" data-month="' . esc_attr( date( 'm', $time_start ) ) . '"  data-day="' . esc_attr( date( 'd', $time_start ) ) . '" data-hour="' . esc_attr( $time_h ) . '" data-minute="' . esc_attr( $time_m ) . '"></div>';
							echo $image;
							echo '<a href="' . $url . '" class="wtrWidgetCountdownOverlay wtrWidgetAnimation">';
								echo '<span></span>';
							echo '</a>';
						echo '</div>';
						echo '<div class="wtrWidgetCountdownHeadlineContainer">';
							echo '<h4 class="wtrWidgetCountdownHeadline">';
								echo '<a href="' . $url . '">' . $event_title  .'</a>';
							echo '</h4>';
						echo '</div>';
					echo '</div>';
				}

			}
			wp_reset_postdata();
			echo $args['after_widget'];
		} // end widget


		public function convert_event_time( $format, $hour ){
			$result = $hour;

			if( '0' != $format ){
				$time_f  = ( '1' == $format ) ? 'pm' : 'am' ;
				$x = date( 'H', strtotime( $hour . $time_f ) );
				$result = intval( $x );
			}
			return $result;
		}//end convert_event_time


		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {

			$title		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$categorie	= isset( $instance['categorie'] ) ? $instance['categorie'] : '';
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wtr_ct_framework' ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'categorie' ) ); ?>"><?php _e( 'Choose the categories you want to display (multiple selection possible)', 'wtr_ct_framework' ); ?> : </label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'categorie' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'categorie' ) ); ?>[]" size="6" multiple="multiple">
					<option value=""><?php _e( 'Select category', 'wtr_ct_framework' ); ?></option>
					<?php
						$events_category = get_terms( 'events-category');
						foreach ( $events_category as $category ){
							echo '<option  ';
							if( $categorie AND in_array(  $category->slug, $categorie  ) ){
								echo 'selected="selected"';
							}
							echo'value="' . $category->slug . '">' . $category->name . '</option>';
						}
					?>
				</select>
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

			$instance				= array();
			$instance['title']		= ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

			if(! empty( $new_instance['categorie'] )  AND is_array( $new_instance['categorie'] ) ) {

				$instance['categorie'] = $new_instance['categorie'];
				if( '' === $instance['categorie'][0] ){
					unset( $instance['categorie'][0] );
				}
			} else {
				$instance['categorie'] = '';
			}
			return $instance;
		} // end update
	} // end WTR_Events_Upcoming_Widget
}