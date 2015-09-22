<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! class_exists( 'WTR_Events_Widget' ) ) {

	/**
	 * Adds WTR_Events_Widget
	 */

	class WTR_Events_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'wtrwidgetupcomingevents', // Base ID
				WTR_THEME_NAME . ' ' . __( 'events', 'wtr_ct_framework' ),
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

			global $post_settings, $wtr_date_format;

			$title			= apply_filters( 'widget_title', $instance['title'] );
			$count			= $instance['count'];
			$order			= $instance['order'];
			$show			= $instance['show'];
			$categorie		= $instance['categorie'];
			$tax_query		= null;
			$meta_key		= null;
			$meta_query		= null;

			switch ( $order ) {
				case 0:
				default:
					$query_orderby	= 'menu_order';
					$query_order	= 'DESC';
					break;

				case 1:
					$query_orderby	= 'menu_order';
					$query_order	= 'ASC';
					break;

				case 2:
					$meta_key		= '_wtr_event_time_start';
					$query_orderby	= 'meta_value';
					$query_order	= 'DESC';
					break;

				case 3:
					$meta_key		= '_wtr_event_time_start';
					$query_orderby	= 'meta_value';
					$query_order	= 'ASC';
					break;
				case 4:
					$query_orderby	= 'title';
					$query_order	= 'DESC';
					break;

				case 5:
					$query_orderby	= 'title';
					$query_order	= 'ASC';
					break;
			}

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

			if( $show ){
				$meta_query = array(
					array(
						'key'		=> '_wtr_event_time_end',
						'value'		=> current_time( "timestamp" ),
						'compare'	=> '>=',
					)
				);
			}

			$query_args = array(
				'post_type'			=> 'events',
				'posts_per_page'	=> $count,
				'orderby'			=> $query_orderby,
				'order'				=> $query_order,
				'meta_key'			=> $meta_key,
				'tax_query'			=> $tax_query,
				'meta_query'		=> $meta_query
			);

			// The Query
			$the_query = new WP_Query( $query_args );

			echo $args['before_widget'];

			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			if ( $the_query->have_posts() ) {
				echo '<div class="wtrWidgetUpcomingEventsContainer clearfix">';
					echo '<div class="wtrWidgetUpcomingEventsRotator">';
						while ( $the_query->have_posts() ) {
							$the_query->the_post();

							$id					= get_the_id();
							$titile				= get_the_title();
							$url				= esc_url( get_permalink() );
							$time_start			= get_post_meta( $id, '_wtr_event_time_start', true );
							$date				= date_i18n( $post_settings['wtr_EventDateFormat']['all'], $time_start );
							$price				= get_post_meta( $id, '_wtr_event_price', true );
							$post_thumbnail_id	= get_post_thumbnail_id( $id );
							$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_2' );
							$image_alt			= esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) );
							$image				= ( $image_attributes[0] ) ? '<img class="wtrWidgetUpcomingEventsImg" alt="' . $image_alt . '" src="' . $image_attributes[0] . '">' : '';

							echo '<div>';
								echo '<div class="wtrWidgetCountdownDate wtrWidgetAnimation">' . $date . '</div>';
								echo '<div class="wtrWidgetCountdownPrice ">' . $price . '</div>';
								echo '<h4 class="wtrWidgetUpcomingEventsHeadline">';
									echo '<a href="' . $url . '">';
										echo $titile;
									echo '</a>';
								echo '</h4>';
								echo $image;
							echo '</div>';
						}
					echo '</div>';
				echo '</div>';
			}
			wp_reset_postdata();
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

			$title		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$count		= isset( $instance['count'] ) ? esc_attr( $instance['count'] ) : 5;
			$categorie 	= isset( $instance['categorie'] ) ? $instance['categorie'] : '';
			$order		= isset( $instance['order'] ) ? esc_attr( $instance['order'] ) : 0;
			$show		= isset( $instance['show'] ) ? esc_attr( $instance['show'] ) : 0;

			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wtr_ct_framework' ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Count', 'wtr_ct_framework' ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" />
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
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php _e( 'Order ', 'wtr_ct_framework' ); ?> : </label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" >
					<option value="4" <?php selected( $order, '4' ); ?> ><?php _e( 'Name DESC', 'wtr_ct_framework' ); ?></option>
					<option value="5" <?php selected( $order, '5' ); ?> ><?php _e( 'Name ASC', 'wtr_ct_framework' ); ?></option>
					<option value="0" <?php selected( $order, '0' ); ?> ><?php _e( 'Order DESC', 'wtr_ct_framework' ); ?></option>
					<option value="1" <?php selected( $order, '1' ); ?> ><?php _e( 'Order ASC', 'wtr_ct_framework' ); ?></option>
					<option value="2" <?php selected( $order, '2' ); ?> ><?php _e( 'Date event DESC', 'wtr_ct_framework' ); ?></option>
					<option value="3" <?php selected( $order, '3' ); ?> ><?php _e( 'Date event ASC', 'wtr_ct_framework' ); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'show' ) ); ?>"><?php _e( 'Show ', 'wtr_ct_framework' ); ?> : </label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show' ) ); ?>" >
					<option value="0" <?php selected( $show, '0' ); ?> ><?php _e( 'All', 'wtr_ct_framework' ); ?></option>
					<option value="1" <?php selected( $show, '1' ); ?> ><?php _e( 'Upcoming', 'wtr_ct_framework' ); ?></option>
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
			$instance['count']		= ( ! empty( $new_instance['count'] ) ) ? absint( $new_instance['count'] ) : 0;
			$instance['order']		= ( ! empty( $new_instance['order'] ) ) ? absint( $new_instance['order'] ) : 0;
			$instance['show']		= ( ! empty( $new_instance['show'] ) ) ? absint( $new_instance['show'] ) : 0;


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
	} // end WTR_Events_Widget
}