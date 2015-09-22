<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! class_exists( 'WTR_Testimonials_Widget' ) ) {

	/**
	 * Adds WTR_Testimonials_Widget
	 */

	class WTR_Testimonials_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'wtrwidgettestimonial', // Base ID
				WTR_THEME_NAME . ' ' . __( 'testimonials', 'wtr_ct_framework' ),
				array( 'description' => __( 'This section shows testimonials', 'wtr_ct_framework' ), )
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
			$count			= $instance['count'];
			$delay			= $instance['delay'];
			$order			= $instance['order'];
			$categorie		= $instance['categorie'];
			$tax_query		= null;

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
					$query_orderby	= 'date';
					$query_order	= 'DESC';
					break;

				case 3:
					$query_orderby	= 'date';
					$query_order	= 'ASC';
					break;
			}

			if( $categorie ){
				$tax_query = array(
					array(
						'taxonomy' 			=> 'testimonial-category',
						'field' 			=> 'slug',
						'terms' 			=> $categorie,
						'include_children' 	=> false
					)
				);
			}

			$query_args	= array(
				'post_type' 		=> 'testimonial',
				'posts_per_page'	=> $count,
				'orderby'			=> $query_orderby,
				'order'				=> $query_order,
				'tax_query' 		=> $tax_query,
			);

			// The Query
			$the_query	= new WP_Query( $query_args );

			echo $args['before_widget'];

			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}


			if ( $the_query->have_posts() ) {
				echo '<div class="wtrWidgetTestimonialContainer clearfix">';
					echo '<div data-interval="'. ( intval( $delay ) * 1000 ) .'" class="wtrSht wtrShtTestimonialRotWidget wtrShtTestimonialRot ">';
						while ( $the_query->have_posts() ) {
							$the_query->the_post();

							$id			= get_the_id();
							$author		= get_post_meta( $id, '_wtr_testimonial_author', true );
							$desc		= get_post_meta( $id, '_wtr_testimonial_desc', true );

							echo '<div class="wtrShtTestimonialStdItem">';
								echo '<p class="wtrWidgetTestimonialRotItemDesc wrtSecAltFontCharacter">';
									echo $desc;
								echo '</p>';
								if( $author ){
									echo '<span class="wtrWidgetTestimonialRotItemAuthor">' . $author . '</span>';
								}
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
			$delay		= isset( $instance['delay'] ) ? esc_attr( $instance['delay'] ) : 1;
			$categorie 	= isset( $instance['categorie'] ) ? $instance['categorie'] : '';
			$order		= isset( $instance['order'] ) ? esc_attr( $instance['order'] ) : 0;

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
				<label for="<?php echo $this->get_field_id( 'delay' ); ?>"><?php _e( 'Slide delay', 'wtr_ct_framework' ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'delay' ); ?>" name="<?php echo $this->get_field_name( 'delay' ); ?>" type="text" value="<?php echo esc_attr( $delay ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'categorie' ) ); ?>"><?php _e( 'Choose the categories you want to display (multiple selection possible)', 'wtr_ct_framework' ); ?> : </label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'categorie' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'categorie' ) ); ?>[]" size="6" multiple="multiple">
					<option value=""><?php _e( 'Select category', 'wtr_ct_framework' ); ?></option>
					<?php
						$testimonial_category = get_terms( 'testimonial-category');
						foreach ( $testimonial_category as $category ){
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
					<option value="0" <?php selected( $order, '0' ); ?> ><?php _e( 'Order DESC', 'wtr_ct_framework' ); ?></option>
					<option value="1" <?php selected( $order, '1' ); ?> ><?php _e( 'Order ASC', 'wtr_ct_framework' ); ?></option>
					<option value="2" <?php selected( $order, '2' ); ?> ><?php _e( 'Date add DESC', 'wtr_ct_framework' ); ?></option>
					<option value="3" <?php selected( $order, '3' ); ?> ><?php _e( 'Date add ASC', 'wtr_ct_framework' ); ?></option>
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
			$instance['delay']		= ( ! empty( $new_instance['delay'] ) ) ? absint( $new_instance['delay'] ) : '';
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
	} // end WTR_Testimonials_Widget
}