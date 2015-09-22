<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! class_exists( 'WTR_Recent_Posts_Widget' ) ) {

	/**
	 * Adds WTR_Recent_Posts_Widget
	 */

	class WTR_Recent_Posts_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'wtrwidgetrecentpost', // Base ID
				WTR_THEME_NAME . ' ' . __( 'recent post', 'wtr_framework' ),
				array( 'description' => __( 'This section shows  last posts', 'wtr_framework' ), )
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

			$title		= apply_filters( 'widget_title', $instance['title'] );
			$count		= $instance['count'];
			$order		= ( 1 == $instance['order'] ) ? 'comment_count' : 'post_date';
			$categorie	= ( is_array( $instance['categorie'] ) ) ? implode( ',', $instance['categorie'] ) : '';


			$query_args		= array(
				'post_type'			=> 'post',
				'posts_per_page'	=> $count,
				'offset'			=> 0,
				'category_name'		=> $categorie,
				'orderby'			=> $order,
				'order'				=> 'DESC',
			);

			// The Query
			$the_query	= new WP_Query( $query_args );

			echo $args['before_widget'];

			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			if ( $the_query->have_posts() ) {
				echo '<div class="wtrWidgetRecentPostContainer clearfix">';
					echo '<ul class="wtrWidgetRecentPostList">';
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							$post_thumbnail_id	= get_post_thumbnail_id( get_the_id() );
							$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_3' );
							$thumbnail			= ( $image_attributes[0] ) ? 'style="background-image: url(\'' . $image_attributes[0] . '\')"' : '';
							$title				= get_the_title();
							$url				= esc_url( get_permalink() );
							$date				= get_the_time( $post_settings['wtr_BlogDateFormat']['all'] );

							echo '<li class="wtrWidgetRecentPostItem">';
								if( $thumbnail ) {
									echo '<div class="wtrWidgetRecentPostImgContainer clearfix">';
										echo '<a href="' . $url . '" class="wtrWidgetRecentPostImgOverlay wtrWidgetAnimation">';
											echo '<span class="wtrWidgetAnimation"></span>';
										echo '</a>';
										echo '<div class="wtrWidgetRecentPostImg" ' . $thumbnail . ' ></div>';
									echo '</div>';
								}
								echo '<div class="wtrWidgetRecentPostMeta">';
									echo '<h4 class="wtrWidgetRecentPostHeadline"><a href="' . $url . '">' . $title . '</a></h4>';
									echo '<div class="wtrWidgetRecentPostDate">' . $date . '</div>';
								echo '</div>';
							echo '</li>';
						}
					echo '</ul>';
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

			$title 		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$count 		= isset( $instance['count'] ) ? esc_attr( $instance['count'] ) : 5;
			$categorie 	= isset( $instance['categorie'] ) ? $instance['categorie'] : '';
			$order		= isset( $instance['order'] ) ? esc_attr( $instance['order'] ) : 0;

			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wtr_framework' ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Count', 'wtr_framework' ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'categorie' ) ); ?>"><?php _e( 'Choose the categories you want to display (multiple selection possible)', 'wtr_framework' ); ?> : </label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'categorie' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'categorie' ) ); ?>[]" size="6" multiple="multiple">
					<option value=""><?php _e( 'Select category', 'wtr_framework' ); ?></option>
					<?php
						foreach ( get_categories( ) as $category ){
							echo '<option  ';
							if( $categorie AND in_array(  $category->slug,$categorie  ) ){
								echo 'selected="selected"';
							}
							echo'value="' . $category->slug . '">' . $category->name . '</option>';
						}
					?>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php _e( 'Order ', 'wtr_framework' ); ?> : </label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" >
					<option value="0" <?php selected( $order, '0' ); ?> ><?php _e( 'Last', 'wtr_framework' ); ?></option>
					<option value="1" <?php selected( $order, '1' ); ?> ><?php _e( 'Number of comments', 'wtr_framework' ); ?></option>
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
	} // end WTR_Recent_Posts_Widget
}