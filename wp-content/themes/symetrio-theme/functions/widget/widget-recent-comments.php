<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! class_exists( 'WTR_Recent_Comments_Widget' ) ) {

	/**
	 * Adds WTR_Recent_Comments_Widget
	 */

	class WTR_Recent_Comments_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress
		 */
		function __construct() {
			parent::__construct(
				'wtrwidgetrecentcomm', // Base ID
				WTR_THEME_NAME . ' ' . __( 'recent comments', 'wtr_framework' ),
				array( 'description' => __( 'This section shows  last comments', 'wtr_framework' ), )
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

			global $comments, $comment, $post_settings;
			$title = apply_filters( 'widget_title', $instance['title'] );

			echo $args['before_widget'];

			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			$comments_args	= array(
				'number'		=> $instance['count'],
				'status'		=> 'approve',
				'post_status'	=> 'publish',
				'post_type'		=> 'post',
			);

			$comments		= get_comments(  $comments_args );

			if ( $comments ) {
				echo '<div class="wtrWidgetRecentCommContainer clearfix">';
					echo '<ul class="wtrWidgetRecentCommList">';
					foreach ( $comments as $comment ) {
						$title	= get_the_title( $comment->comment_post_ID );
						$author	= get_comment_author();
						$url	= esc_url( get_comment_link( $comment->comment_ID) );
						$date	= mysql2date( get_the_time( $post_settings['wtr_BlogDateFormat']['all'] ), $comment->comment_date );

						echo'<li class="wtrWidgetRecentCommItem">';
							echo '<div class="wtrWidgetRecentCommWriter">';
								echo '<span>' . $author . '</span><i class="fa fa-comment-o"></i><span>on</span>';
							echo '</div>';
							echo '<h4 class="wtrWidgetRecentCommLink"><a href="' . $url . '" >';
								echo $title;
							echo '</a></h4>';
							echo '<div class="wtrWidgetRecentCommDate">';
								echo $date;
							echo '</div>';
						echo '</li>';
					}
					echo '</ul>';
				echo '</div>';
			}

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
			$count 		= isset( $instance['count'] ) ? absint( $instance['count'] ) : 5;
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wtr_framework' ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Number of comments to show', 'wtr_framework' ); ?> : </label>
				<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="2" />
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
			$instance['title'] 		= ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['count'] 		= ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '0';
			return $instance;
		} // end update
	} // class Foo_Widget

}