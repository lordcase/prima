<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

if ( ! class_exists( 'WTR_Tabs_TinyMCE ' ) ) {

	class WTR_Tabs_TinyMCE {

		// VARIABLES
		private $tabs = array();
		private $errors = array( 'wrong_param' => 'Incorrect parameters in the constructor. ' );

		// FUNCTIONS
		public function __construct( $tabs ){

			if( is_array( $tabs ) ){
				$this->tabs = $tabs;
			} else {
				throw new Exception( $this->errors[ 'wrong_param' ] );
			}
		}// end __construct


		public function drawHead(){

				$out = '<ul class="resp-tabs-list">';

				foreach ( $this->tabs as $key => $value ) {
					$out .= '
					<li> <span id="wtr_tab_shourtcut_' . $key . '" class="tabTitle wtr_mce_tabTitle">
						<span class="ico ' . $value[ 'icon' ] . '">' . $value[ 'name' ] . '</span>
						</span>
					</li>';
				}

			$out .= '</ul>';
			return $out;
		}// end drawHead


		public function drawContent(){
			$out = '';
			$elemInRow = 5;
			$flag = false;

			foreach ( $this->tabs as $key => $value ) {

				$i = $j = 0;

				$lastRow = ceil( count( $value[ 'shortcode' ] ) / $elemInRow );

				$out .= '
				<div>
					<div class="scrolableContent">';

						foreach ($value[ 'shortcode' ] as $elKey => $elObj ) {

							if( 0 == $i ) {
								++$j;
								$flag = true;

								if( $j == $lastRow ) {
									$lastR = ' shourtBtnSec-last ';
								} else {
									$lastR = '';
								}

								$out .= '<div class="shourtBtnSec ' . $lastR . '">';
							}

							if( 'self' == $elObj[ 'shortcode' ] ){
								$selfTarget		= 'wtr_shortcode_target_self';
								$shortcode_code	= ' data-shortcode-code="' . $elObj[ 'shortcode_code' ] . '" ';
								$widthMode		= '';
								$heightMode		= '';
								$w				= '';
								$h				= '';
							}else{
								$selfTarget		= 'wtr_shortcode_target_new_modal';
								$shortcode_code = ' data-shortcode-modal="' . $elObj[ 'shortcode' ] . '" ';
								$widthMode		= ' data-width-mode="' . (( isset( $elObj[ 'modal_size' ]['fullscreenW'] ) )? $elObj[ 'modal_size' ]['fullscreenW'] : 'yes' ) . '" ';
								$heightMode		= ' data-height-mode="' . (( isset( $elObj[ 'modal_size' ]['fullscreenH'] ) )? $elObj[ 'modal_size' ]['fullscreenH'] : 'yes' ) . '" ';
								$w				= ' data-modal-w="' . (isset($elObj[ 'modal_size' ]['width'])? $elObj[ 'modal_size' ]['width'] : '') . '" ';
								$h				= ' data-modal-h="' . (isset($elObj[ 'modal_size' ]['height'])? $elObj[ 'modal_size' ]['height'] : '') . '" ';
							}

							$out .= '
							<a href="#" class="srtBtn wtr_admin_Index_Ico_Btn '. $selfTarget.'">
								<div class="srtBtnIco darkBlue"' . $shortcode_code .' '. $heightMode .' ' . $h . ' '. $widthMode .' ' . $w . '>
									<span class="ico-button ' . $elObj[ 'icon' ] . '"></span>
								</div>
								<span class="srtBtnIcoDesc">' . $elObj[ 'name' ] . '</span>
							</a>';

							if ( 4 == $i ) {
								$out .= '</div>';
								$i = 0;
								$flag = false;
							}
							else{
								++$i;
							}
						}

						if($flag){
							$out .= '</div>';
						}

						$out .= '
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>';
			}
			return $out;
		} // end drawContent
	} // end WTR_Tabs_TinyMCE
}