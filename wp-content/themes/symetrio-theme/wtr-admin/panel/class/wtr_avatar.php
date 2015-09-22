<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( ! class_exists( 'WTR_Avatar' ) ) {

	class WTR_Avatar extends WTR_Core {

		public function __construct( ){

			add_action( 'init', array( $this, 'init' ) );

		}// end __construct


		public function init(){

			global $WTR_Opt;

			if( 0 ==  $WTR_Opt->getopt( 'wtr_GlobalAvatarStatus' ) ) {
				return ;
			}

			add_filter( 'get_avatar', array( $this, 'get_avatar' ), 10, 5 );

			if( current_user_can( 'upload_files' ) ){

				add_filter( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
				add_action( 'show_user_profile', array( $this, 'edit_user_profile' ) );
				add_action( 'edit_user_profile', array( $this, 'edit_user_profile' ) );
				add_action( 'personal_options_update', array( $this, 'edit_user_profile_update' ) );
				add_action( 'edit_user_profile_update', array( $this, 'edit_user_profile_update' ) );
				add_filter( 'avatar_defaults', array( $this, 'avatar_defaults' ) );
			}
		}// end init

		public function admin_enqueue_scripts( $hook_suffix ) {

			if ( 'profile.php' != $hook_suffix && 'user-edit.php' != $hook_suffix ){
				return;
			}

			// ==== Enqueue Stylesheets
				wp_enqueue_style( 'site' );

				// Enqueue Scripts
				//wp_enqueue_script('jquery-mini');
				wp_enqueue_media();
				wp_enqueue_script( 'jquery' );
				wp_enqueue_script( 'jqueryForm' );
				wp_enqueue_script( 'obj_loader' );
				wp_enqueue_script( 'admin_panel_j' );

				//params for admin_panel_j
				$params = array(
					'uri' => WTR_ADMIN_URI,
					'uri_class' => WTR_ADMIN_CLASS_URI
				);
				wp_localize_script( 'admin_panel_j', 'wp_param_admin_panel', $params );
		}// end admin_enqueue_scripts


		public function edit_user_profile( $profileuser ){

			require_once( WTR_ADMIN_CLASS_DIR . '/fields/wtr_upload.php' );

				$value		= $profileuser->wtr_avatar_img;

				$wtr_avatar_img = new WTR_Upload( array(
					'id'			=> 'wtr_avatar_img',
					'title'			=> __( 'Image', 'wtr_framework' ),
					'desc'			=> '',
					'value'			=> $value,
					'default_value'	=> '',
					'default_size'	=> 'thumbnail',
					'mod'			=>'avatar',
					'info'			=> '',
					'allow'			=> 'all',
				),
				array( 'title_modal' => __( 'Insert image', 'wtr_framework' ) )
			);
			$wtr_avatar_img->draw();
		}// end edit_user_profile


		public function edit_user_profile_update( $user_id  ){

			if( !isset( $_POST['wtr_avatar_img'] )){
				return;
			}

			update_user_meta( $user_id, 'wtr_avatar_img', $_POST['wtr_avatar_img'] );
		}// end edit_user_profile_update


		public function get_avatar( $avatar = '', $id_or_email, $size = 96, $default = '', $alt = '' ) {

			if ( is_numeric( $id_or_email ) ){
				$user_id = (int) $id_or_email;
			} elseif ( is_string( $id_or_email ) && ( $user = get_user_by( 'email', $id_or_email ) ) ){
				$user_id = $user->ID;
			} elseif ( is_object( $id_or_email ) && ! empty( $id_or_email->user_id ) ){
				$user_id = (int) $id_or_email->user_id;
			}

			if ( empty( $user_id ) ){
				return $avatar;
			}

			if ( false === $alt){
				$safe_alt = '';
			} else {
				$safe_alt = esc_attr( $alt );
			}

			if ( !is_numeric($size) ){
				$size = '96';
			}

			$default = get_user_meta( $user_id, 'wtr_avatar_img', true );
			$default = wp_get_attachment_image_src( $default, 'full' );
			$default = $default[ 0 ];

			if( $default ){
				$avatar = "<img alt='{$safe_alt}' src='{$default}' class='avatar avatar-{$size} photo avatar-default' height='{$size}' width='{$size}' />";
			}
			return $avatar;
		}// end get_avatar


		/**
		 * remove the custom get_avatar hook for the default avatar list output on options-discussion.php
		 */
		public function avatar_defaults( $avatar_defaults ) {
			remove_action( 'get_avatar', array( $this, 'get_avatar' ) );
			return $avatar_defaults;
		}// end avatar_defaults
	}// end WTR_Avatar
}