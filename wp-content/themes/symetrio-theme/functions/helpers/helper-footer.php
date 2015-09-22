<?php
/**
 * footer functions
 *
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! function_exists( 'wtr_before_body_end' ) ){

	// adding the code from the settings "Space before </body>"
	function wtr_before_body_end(){
		global $post_settings;
		echo $post_settings['wtr_GlobalSpaceBeforeBody'] . "\n" ;;
	} // end wtr_before_head

}
add_action( 'wp_footer', 'wtr_before_body_end', 9999 );


if( ! function_exists( 'wtr_footer_copy' ) ){

	// generating section - copyright
	function wtr_footer_copy(){
		global $post_settings;

		if ( 0 == $post_settings['wtr_FooterSettings'] OR 1 == $post_settings['wtr_FooterSettings'] ) {
			return;
		}

		$SectionOne = $post_settings['wtr_FooterSectionOne'];
		$SectionTwo = $post_settings['wtr_FooterSectionTwo'];

		echo '<div class="wtrCopyright wtrCopyrightColor">';
			echo '<div class="wtrInner clearfix">';
				echo '<div class="wtrColOneTwo wtrCopyBoxOne">';
						echo $post_settings['wtr_FooterCoopyrightText'];
				echo '</div>';
			if( ! empty( $SectionOne ) OR !empty( $SectionTwo ) ){
				$class = ( ! empty( $SectionOne ) AND !empty( $SectionTwo ) ) ? '' : 'wtrFQCCol';
				echo '<div class="wtrColOneTwo wtrLastCol wtrAlignRight wtrCopyBoxTwo">';
					echo '<div class="wtrQuickContactInfo clearfix">';
						if( $SectionOne ) {
							echo '<div class="wtrColOneTwo ' . $class . ' wtrAlignRight wtrCopyBoxTwoOne">';
								echo $SectionOne;
							echo '</div>';
						}
						if( $SectionTwo ) {
							echo '<div class="wtrColOneTwo ' . $class . ' wtrLastCol wtrAlignRight wtrCopyBoxTwoTwo">';
								echo $SectionTwo;
							echo '</div>';
						}
					echo '</div>';
				echo '</div>';
			}
			echo '</div>';
		echo '</div>';

	} // end wtr_footer_copy
}


if( ! function_exists( 'wtr_footer_column' ) ){

	// generate footer and placing in the widgets
	function wtr_footer_column(){
		global $post_settings;

		if ( 0 == $post_settings['wtr_FooterSettings'] OR 2 == $post_settings['wtr_FooterSettings'] ) {
			return;
		}

		echo '<div class="wtrFooterContainer wtrFooterColor wtrFooterWdg ' . $post_settings['wtr_FooterContainerClass'] . ' ">';
			echo '<div class="wtrInner clearfix">';
				if ( $post_settings['wtr_FooterCenterColumn'] ) {
					echo '<div class="wtrColOne wtrFullWidthWidget">';
						dynamic_sidebar( $post_settings['wtr_FooterWidgets_4'] );
						if ( 1 == $post_settings['wtr_FooterDivider'] ) {
							echo '<div class="wtrFooterDivider"></div>';
						}
					echo '</div>';
				}

				for ( $i = 0; $i < $post_settings['wtr_FooterColumns']; $i++ ) {
					$class_last = ( $i + 1 ==  $post_settings['wtr_FooterColumns'] ) ? 'wtrLastCol' : '';
					echo '<div class="' . $post_settings['wtr_FooterClass'] . ' '.$class_last . '">';
						dynamic_sidebar( $post_settings['wtr_FooterWidgets_' . $i ] );
					echo '</div>';
				}

			echo '</div>';
		echo '</div>';

	} // end wtr_footer_column
}


if( ! function_exists( 'wtr_footer_main' ) ){

	function wtr_footer_main(){

		global $post_settings;

		echo '<footer class="wtrFooter clearfix ' . $post_settings['wtr_FooterClassImg'] . '"  ' . $post_settings['wtr_FooterStyle'] .' >';
			wtr_footer_column();
			wtr_footer_copy();
		echo '</footer>';
		echo $post_settings['wtr_Boxed_end'];
		wtr_wp_nav_smart_menu();
	}
}
add_action('wtr_footer', 'wtr_footer_main');