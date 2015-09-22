<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! class_exists( 'WTR_Recent_Gallery_Widget' ) ) {

	/**
	 * Adds WTR_Recent_Gallery_Widget
	 */

	class WTR_Recent_Gallery_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'wtrwidgetrecentgallery', // Base ID
				WTR_THEME_NAME . ' ' . __( 'recent gallery', 'wtr_ct_framework' ),
				array( 'description' => __( 'This section shows  last gallery', 'wtr_ct_framework' ), )
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
			$order		= $instance['order'];
			$i			= 0;
			$items		= 3;
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

			$meta_query = array(
				array(
					'key'		=> '_wtr_portfolio_gallery_item',
					'value'		=> array(''),
					'compare'	=> 'NOT IN'
				)
			);

			$query_args	= array(
				'post_type'			=> 'gallery',
				'posts_per_page'	=> $count,
				'orderby'			=> $query_orderby,
				'order'				=> $query_order,
				'offset'			=> 0,
				'suppress_filters'	=> false,
				'meta_query'		=> $meta_query
			);

			// The Query
			$the_query	= new WP_Query( $query_args );

			echo $args['before_widget'];

			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			if ( $the_query->have_posts() ) {
				echo '<div class="wtrWidgetRecentGalleryContainer clearfix">';
				while ( $the_query->have_posts() ) {
					$the_query->the_post();

					if( $i == 0 ){
						echo '<ul class="wtrWidgetRecentGallerys wtrWidgetRecentGalleryRow gallery clearfix">';
					}


					$gallery_items		= get_post_meta( get_the_id(), '_wtr_portfolio_gallery_item', true );
					$gallery_items		= ( is_array( $gallery_items ) ) ? $gallery_items :array( ) ;
					$url				= get_permalink();
					$post_thumbnail_id	= get_post_thumbnail_id( get_the_id() );
					$gallery_items		= ( $post_thumbnail_id ) ? array_merge( array( array( $post_thumbnail_id => '' ) ), $gallery_items ): $gallery_items;


					if( $gallery_items ){
						$i++;
						echo '<li class="wtrWidgetRecentGalleryItem">';
								echo '<ul class="wtrWidgetGallery">';
									$j = 0;
									foreach ( $gallery_items as $item ) {
										$j++;
										$key	= (key ( $item ) );
										$post	= get_post( $key );
										if( ! empty( $post ) ) {

											setup_postdata( $post );
											$title					= get_the_title();
											$desc					= esc_attr( get_the_excerpt() );
											$thumbnail_attributes	= wp_get_attachment_image_src( $key , 'size_2' );
											$thumbnail				= $thumbnail_attributes[0];
											$image_attributes		= wp_get_attachment_image_src( $key , 'full' );
											$image					= $image_attributes[0];
											$image_alt				= esc_attr( get_post_meta( $key, '_wp_attachment_image_alt', true ) );

											if( $image AND $thumbnail ){
												if( 1 == $j ){
													echo '<li data-title="' . esc_attr( $title ) . '" data-desc="' . esc_attr( $desc ) . '" data-src="' . $image . '" data-thumb="' . $thumbnail . '" class="">';
														echo '<a class="wtrWidgetRecentGalleryOverlay wtrWidgetAnimation" href="">';
															echo '<span class="wtrWidgetAnimation"></span>';
														echo '</a>';
														echo '<img class="wtrWidgetRecentGalleryImg" src="' . $thumbnail . '" alt="' . $image_alt . '">';
													echo '</li>';
												}else {
													echo '<li data-title="' . esc_attr( $title ) . '" data-desc="' . esc_attr( $desc ) . '" data-src="' . $image . '" data-thumb="' . $thumbnail . '" class=""></li>';
												}
											}
										}
									}

							echo'</ul>';
						echo '</li>';

						if( $items <=  $i ){
							echo '</ul>';
							$i = 0;
						}
					}
				}
				if( $i != 0 ) {
					echo '</ul>';
				}

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

			$instance 				= array();
			$instance['title']		= ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['count']		= ( ! empty( $new_instance['count'] ) ) ? absint( $new_instance['count'] ) : 0;
			$instance['order']		= ( ! empty( $new_instance['order'] ) ) ? absint( $new_instance['order'] ) : 0;

			return $instance;
		} // end update
	} // end WTR_Recent_Gallery_Widget
}