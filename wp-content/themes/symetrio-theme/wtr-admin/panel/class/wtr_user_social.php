<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( ! class_exists( 'WTR_User_Social' ) ) {

	class WTR_User_Social extends WTR_Core {

		public function __construct( ){

			add_action( 'show_user_profile', array( $this, 'edit_user_profile' ) );
			add_action( 'edit_user_profile', array( $this, 'edit_user_profile' ) );
			add_action( 'personal_options_update', array( $this, 'edit_user_profile_update' ) );
			add_action( 'edit_user_profile_update', array( $this, 'edit_user_profile_update' ) );
		}// end __construct


		public function edit_user_profile( $profileuser ){

			global $wtr_social_media;

			echo '<h3>' . __( 'Social media ', WTR_THEME_NAME). '</h3>';
			echo '<table class="form-table">';

				foreach ( $wtr_social_media as $key => $value) {

					$social_media_link = isset( $profileuser->wtr_social[ $key ] ) ? esc_attr( $profileuser->wtr_social[ $key ] ) : '';

					echo '<tr>';
						echo '<th><label for="' . $key . '">' . $value['title'] . '</label></th>';
						echo '<td><input type="text" class="regular-text code" value="' . esc_attr( $social_media_link ) . '" id="' . $key . '" name="wtr_social[' . $key. ']"></td>';
					echo '</tr>';
				}

			echo '</table>';
		}// end edit_user_profile


		public function edit_user_profile_update( $user_id  ){

			if( ! isset( $_POST['wtr_social'] ) ){
				return;
			}

			update_user_meta( $user_id, 'wtr_social', $_POST['wtr_social']);
		}// end edit_user_profile_update
	}// end WTR_Avatar
}