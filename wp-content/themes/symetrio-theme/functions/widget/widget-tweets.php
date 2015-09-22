<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! class_exists( 'WTR_Widget_Tweets' ) ) {

	/**
	 * Adds WTR_Widget_Tweets
	 */

	class WTR_Widget_Tweets extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'wtrwidgettwitter', // Base ID
				WTR_THEME_NAME . ' ' . __( 'twitter', 'wtr_framework' ),
				array( 'description' => __( 'You can link Twitter account here to display your last twitts on site', 'wtr_framework' ), )
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
		function widget($args, $instance)
		{
			$title 				= apply_filters('widget_title', $instance['title']);
			$consumer_key 		= $instance['consumer_key'];
			$consumer_secret	= $instance['consumer_secret'];
			$access_token 		= $instance['access_token'];
			$access_token_secret= $instance['access_token_secret'];
			$twitter_id 		= $instance['twitter_id'];
			$count 				= $instance['count'];
			$refresh_time		= $instance['refresh_time'];
			$expiration 		= ( $refresh_time ) ? 60 * $refresh_time : 60;

			echo $args['before_widget'];

			if ( ! empty( $title ) )
				echo $args['before_title'] . $title . $args['after_title'];

			if( empty( $twitter_id ) OR empty( $consumer_key ) OR empty( $consumer_secret ) OR empty( $access_token ) OR empty( $access_token_secret ) OR empty( $count ) ) {
				if(  current_user_can('edit_theme_options') ){
					echo '<h2 style="font-family: HelveticaNeue,Helvetica,Arial,sans-serif; color: #5A95A7; font-size: 14px" >' . __( 'Fill all widget settings ' , WTR_THEME_NAME ) .'<h2>';
				}
				echo $args['after_widget'];
				return;
			}

			$transient	= 'wtr_tweets_' . $args['widget_id'];
			$tweets		= get_transient( $transient );

			if( false == $tweets){

				$connection = new TwitterOAuth( $consumer_key, $consumer_secret, $access_token, $access_token_secret );
				$tweets = $connection->get(
					'statuses/user_timeline',array(
						'screen_name'		=> $twitter_id,
						'count'				=> $count
					)
				);

				if( isset( $tweets->errors ) ){
					if( current_user_can('edit_theme_options') ){
						echo '<h2 style="font-family: HelveticaNeue,Helvetica,Arial,sans-serif; color: #5A95A7; font-size: 14px">' . $tweets->errors[0]->message . '</h2>';
					}
					echo $args['after_widget'];
					return;
				}
				set_transient( $transient, $tweets, $expiration );
			}
			if( $tweets ){
				echo '<ul class="wtrWidgetTwitterStream">';
					foreach( $tweets as $tweet ) {

						$tweetText = $tweet->text;
						$tweetText = preg_replace('/http:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '<a href="http://$1" target="_blank">http://$1</a>', $tweetText);
						$tweetText = preg_replace('/@([a-z0-9_]+)/i', '<a href="http://twitter.com/$1" target="_blank">@$1</a>', $tweetText);

						echo '<li class="wtrWidgetTwitterStreamItem">';
							echo '<div class="wtrWidgetTwitterStreamItemTittle">';
								echo $tweetText;
							echo '</div>';
							echo '<span class="wtrWidgetTwitterStreamItemDate">' . human_time_diff( strtotime( $tweet->created_at ), current_time('timestamp') ) . ' ' .   __( 'Ago', WTR_THEME_NAME ) . ' </span>';
						echo '</li>';
					}
				echo '</ul>';
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
		function form($instance)
		{
			$defaults = array('title' => __( 'Recent Tweets', WTR_THEME_NAME) , 'twitter_id' => '', 'count' => 3 );
			$instance = wp_parse_args((array) $instance, $defaults);

			$title				= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$consumer_key		= isset( $instance['consumer_key'] ) ? esc_attr( $instance['consumer_key'] ) : '';
			$consumer_secret	= isset( $instance['consumer_secret'] ) ? esc_attr( $instance['consumer_secret'] ) : '';
			$access_token		= isset( $instance['access_token'] ) ? esc_attr( $instance['access_token'] ) : '';
			$access_token_secret= isset( $instance['access_token_secret'] ) ? esc_attr( $instance['access_token_secret'] ) : '';
			$twitter_id			= isset( $instance['twitter_id'] ) ? esc_attr( $instance['twitter_id'] ) : '';
			$count				= isset( $instance['count'] ) ? esc_attr( $instance['count'] ) : '';
			$refresh_time		= isset( $instance['refresh_time'] ) ? esc_attr( $instance['refresh_time'] ) : 0;
			?>

			<p><a href="http://dev.twitter.com/apps"><?php _e( 'Find or Create your Twitter App', 'wtr_framework' ) ?></a></p>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title', 'wtr_framework' ); ?>:</label>
				<input class="widefat"  id="<?php echo $this->get_field_id('title'); ?>" type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('consumer_key'); ?>"><?php _e( 'Consumer Key', 'wtr_framework' ); ?>:</label>
				<input class="widefat"  id="<?php echo $this->get_field_id('consumer_key'); ?>" type="text"  name="<?php echo $this->get_field_name('consumer_key'); ?>" value="<?php echo esc_attr( $consumer_key ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('consumer_secret'); ?>"><?php _e( 'Consumer Secret', 'wtr_framework' ); ?>:</label>
				<input class="widefat"  id="<?php echo $this->get_field_id('consumer_secret'); ?>" type="text" name="<?php echo $this->get_field_name('consumer_secret'); ?>" value="<?php echo esc_attr( $consumer_secret ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('access_token'); ?>"><?php _e( 'Access Token', 'wtr_framework' ); ?>:</label>
				<input class="widefat"  id="<?php echo $this->get_field_id('access_token'); ?>" type="text" name="<?php echo $this->get_field_name('access_token'); ?>" value="<?php echo esc_attr( $access_token ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('access_token_secret'); ?>"><?php _e( 'Access Token Secret', 'wtr_framework' ); ?>:</label>
				<input class="widefat"  id="<?php echo $this->get_field_id('access_token_secret'); ?>" type="text" name="<?php echo $this->get_field_name('access_token_secret'); ?>" value="<?php  echo esc_attr( $access_token_secret ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('twitter_id'); ?>"><?php _e( 'Twitter username', 'wtr_framework' ); ?>:</label>
				<input class="widefat"  id="<?php echo $this->get_field_id('twitter_id'); ?>" type="text" name="<?php echo $this->get_field_name('twitter_id'); ?>" value="<?php  echo esc_attr( $twitter_id ); ?>" />
			</p>
				<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Number of Tweets', 'wtr_framework' ); ?>:</label>
				<input class="widefat"  id="<?php echo $this->get_field_id('count'); ?>" type="text" name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo esc_attr( $count ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('refresh_time'); ?>"><?php _e( 'Refresh time', 'wtr_framework' ); ?>:</label>
				<select id="<?php echo $this->get_field_id('refresh_time'); ?>" type="text" name="<?php echo $this->get_field_name('refresh_time'); ?>">
					<option value="0" <?php selected( '0', $refresh_time) ?> ><?php _e( '1 min', 'wtr_framework' ); ?></option>
					<option value="2" <?php selected( '2', $refresh_time) ?> ><?php _e( '2 min', 'wtr_framework' ); ?></option>
					<option value="5" <?php selected( '5', $refresh_time) ?> ><?php _e( '5 min', 'wtr_framework' ); ?></option>
					<option value="10" <?php selected( '10', $refresh_time) ?> ><?php _e( '10 min', 'wtr_framework' ); ?></option>
					<option value="15" <?php selected( '15', $refresh_time) ?> ><?php _e( '15 min', 'wtr_framework' ); ?></option>
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

			$instance						= array();
			$instance['title']				= ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['consumer_key']		= ( ! empty( $new_instance['consumer_key'] ) ) ? strip_tags( $new_instance['consumer_key'] ) : '';
			$instance['consumer_secret']	= ( ! empty( $new_instance['consumer_secret'] ) ) ? strip_tags( $new_instance['consumer_secret'] ) : '';
			$instance['access_token']		= ( ! empty( $new_instance['access_token'] ) ) ? strip_tags( $new_instance['access_token'] ) : '';
			$instance['access_token_secret']= ( ! empty( $new_instance['access_token_secret'] ) ) ? strip_tags( $new_instance['access_token_secret'] ) : '';
			$instance['twitter_id']			= ( ! empty( $new_instance['twitter_id'] ) ) ? strip_tags( $new_instance['twitter_id'] ) : '';
			$instance['count']				= ( ! empty( $new_instance['count'] ) ) ? absint( $new_instance['count'] ) : 0;
			$instance['refresh_time']		= ( ! empty( $new_instance['refresh_time'] ) ) ? absint( $new_instance['refresh_time'] ) : 0;


			$transient	= 'wtr_tweets_' . $this->id;
			$tweets		= delete_transient( $transient );
			return $instance;
		} // end update
	} // end class WTR_Widget_Tweets
}
?>