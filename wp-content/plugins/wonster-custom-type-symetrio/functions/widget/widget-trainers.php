<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! class_exists( 'WTR_Trainers_Widget' ) ) {

	/**
	 * Adds WTR_Trainers_Widget
	 */

	class WTR_Trainers_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'wtrwidgettrainers', // Base ID
				WTR_THEME_NAME . ' ' . __( 'trainers', 'wtr_ct_framework' ),
				array( 'description' => __( 'This section shows trainers', 'wtr_ct_framework' ), )
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

			$title				= apply_filters( 'widget_title', $instance['title'] );
			$count				= $instance['count'];
			$order				= $instance['order'];
			$class				= $instance['class'];
			$functions			= $instance['functions'];
			$specializations	= $instance['specializations'];
			$tax_query			= null;
			$meta_key			= null;

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
					$query_orderby	= 'meta_value';
					$meta_key		= '_wtr_trainer_name';
					$query_order	= 'ASC';
					break;

				case 3:
					$query_orderby	= 'meta_value';
					$meta_key		= '_wtr_trainer_name';
					$query_order	= 'DESC';
					break;

				case 4:
					$query_orderby	= 'meta_value';
					$meta_key		= '_wtr_trainer_last_name';
					$query_order	= 'ASC';
					break;

				case 5:
					$query_orderby	= 'meta_value';
					$meta_key		= '_wtr_trainer_last_name';
					$query_order	= 'DESC';
					break;
			}

			if( $specializations AND $functions ){
				$tax_query['relation'] ='OR';
			}

			if( $specializations ){
				$tax_query[]	=  array(
						'taxonomy' 			=> 'trainer-specialization',
						'field' 			=> 'slug',
						'terms' 			=> $specializations,
						'include_children' 	=> false
					);
			}

			if( $functions ){
				$tax_query[]	=  array(
						'taxonomy' 			=> 'trainer-function',
						'field' 			=> 'slug',
						'terms' 			=> $functions,
						'include_children' 	=> false
					);
			}

			$query_args		= array(
				'post_type' 		=> 'trainer',
				'posts_per_page'	=> $count,
				'orderby'			=> $query_orderby,
				'order'				=> $query_order,
				'tax_query' 		=> $tax_query,
				'meta_key'			=> $meta_key
			);

			// The Query
			$the_query = new WP_Query( $query_args );

			echo $args['before_widget'];

			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			if ( $the_query->have_posts() ) {
				echo '<div class="wtrWidgetTrainersContainer clearfix">';
					echo '<ul class="wtrWidgetTrainersList">';
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							$id					= get_the_id();
							$url				= esc_url( get_permalink() );
							$name				= get_post_meta( $id, '_wtr_trainer_name', true);
							$last_name			= get_post_meta( $id, '_wtr_trainer_last_name', true);
							$trainer_name		= ( $name OR $last_name ) ? $name .' <br/> ' .$last_name : get_the_title();
							$post_thumbnail_id	= get_post_thumbnail_id( $id );
							$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_2' );
							$image_alt			= esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) );
							$image				= ( $image_attributes[0] ) ? '<img class="wtrWidgetTrainerImg" alt="' . $image_alt . '" src="' . $image_attributes[0] . '">' : '';

							echo '<li class="wtrWidgetTrainerItem clearfix">';
								if( $image ){
									echo '<div class="wtrWidgetTrainerImgContainer">';
										echo '<a class="wtrWidgetTrainerImgOverlay wtrWidgetAnimation" href="' . $url . '">';
											echo '<span></span>';
										echo '</a>';
										echo $image;
									echo '</div>';
								}
								echo '<div class="wtrWidgetTrainerMetaContainer">';
									echo '<div class="wtrWidgetTrainerHeadline">' . $post_settings['wtr_TranslateWidgetsSectionTrainerMeet'] . '</div>';
									echo '<a href="' . $url . '" class="wtrWidgetTrainersLink wrtAltFontCharacter">';
										echo $trainer_name;
									echo '</a>';
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

			$title				= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$count				= isset( $instance['count'] ) ? esc_attr( $instance['count'] ) : 5;
			$specializations	= isset( $instance['specializations'] ) ? $instance['specializations'] : '';
			$functions			= isset( $instance['functions'] ) ? $instance['functions'] : '';
			$order				= isset( $instance['order'] ) ? esc_attr( $instance['order'] ) : 0;
			$class				= isset( $instance['class'] ) ? esc_attr( $instance['class'] ) : 0;

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
				<label for="<?php echo esc_attr( $this->get_field_id( 'functions' ) ); ?>"><?php _e( 'Choose the functionss you want to display (multiple selection possible)', 'wtr_ct_framework' ); ?> : </label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'functions' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'functions' ) ); ?>[]" size="6" multiple="multiple">
					<option value=""><?php _e( 'Select category', 'wtr_ct_framework' ); ?></option>
					<?php
						$trainer_functions = get_terms( 'trainer-function');
						foreach ( $trainer_functions as $function ){
							echo '<option  ';
							if( $functions AND in_array(  $function->slug, $functions  ) ){
								echo 'selected="selected"';
							}
							echo'value="' . $function->slug . '">' . $function->name . '</option>';
						}
					?>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'specializations' ) ); ?>"><?php _e( 'Choose the specializations you want to display (multiple selection possible)', 'wtr_ct_framework' ); ?> : </label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'specializations' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'specializations' ) ); ?>[]" size="6" multiple="multiple">
					<option value=""><?php _e( 'Select category', 'wtr_ct_framework' ); ?></option>
					<?php
						$trainer_specializations = get_terms( 'trainer-specialization', array( 'hide_empty'    => false, ) );
						foreach ( $trainer_specializations as $specialization ){
							echo '<option  ';
							if( $specializations AND in_array(  $specialization->slug, $specializations  ) ){
								echo 'selected="selected"';
							}
							echo'value="' . $specialization->slug . '">' . $specialization->name . '</option>';
						}
					?>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php _e( 'Order ', 'wtr_ct_framework' ); ?> : </label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" >
					<option value="0" <?php selected( $order, '0' ); ?> ><?php _e( 'Order DESC', 'wtr_ct_framework' ); ?></option>
					<option value="1" <?php selected( $order, '1' ); ?> ><?php _e( 'Order ASC', 'wtr_ct_framework' ); ?></option>
					<option value="2" <?php selected( $order, '2' ); ?> ><?php _e( 'Name DESC', 'wtr_ct_framework' ); ?></option>
					<option value="3" <?php selected( $order, '3' ); ?> ><?php _e( 'Name ASC', 'wtr_ct_framework' ); ?></option>
					<option value="4" <?php selected( $order, '4' ); ?> ><?php _e( 'Last name DESC', 'wtr_ct_framework' ); ?></option>
					<option value="5" <?php selected( $order, '5' ); ?> ><?php _e( 'Last name ASC', 'wtr_ct_framework' ); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'class' ) ); ?>"><?php _e( 'Choose classes based on ', 'wtr_ct_framework' ); ?> : </label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'class' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'class' ) ); ?>" >
					<option value="0" <?php selected( $class, '0' ); ?> ><?php _e( 'Specialization', 'wtr_ct_framework' ); ?></option>
					<option value="1" <?php selected( $class, '1' ); ?> ><?php _e( 'Functions', 'wtr_ct_framework' ); ?></option>
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
			$instance['class']		= ( ! empty( $new_instance['count'] ) ) ? absint( $new_instance['class'] ) : 0;
			$instance['order']		= ( ! empty( $new_instance['order'] ) ) ? absint( $new_instance['order'] ) : 0;

			if(! empty( $new_instance['functions'] )  AND is_array( $new_instance['functions'] ) ) {
				$instance['functions'] = $new_instance['functions'];
				if( '' === $instance['functions'][0] ){
					unset( $instance['functions'][0] );
				}
			} else {
				$instance['functions'] = '';
			}

			if(! empty( $new_instance['specializations'] )  AND is_array( $new_instance['specializations'] ) ) {
				$instance['specializations'] = $new_instance['specializations'];
				if( '' === $instance['specializations'][0] ){
					unset( $instance['specializations'][0] );
				}
			} else {
				$instance['specializations'] = '';
			}

			return $instance;
		} // end update
	} // end WTR_Trainers_Widget
}