<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

if ( ! class_exists( 'WTR_Modal_Tpl' ) ) {

	class WTR_Modal_Tpl {

		// VARIABLES
		private $obj;
		private $fullscreenModeW;
		private $fullscreenModeH;
		private $width;
		private $height;
		private $data;
		private $drawContent;
		private $nonce;

		// FUNCTIONS
		public function __construct( $obj, $data, $view, $mode ){

			$this->obj				= $obj;
			$modal_size				= $this->obj->get( 'modal_size' );
			$this->fullscreenModeW	= ( isset( $modal_size[ 'fullscreenW' ] ) )? $modal_size[ 'fullscreenW' ] : 'yes';
			$this->fullscreenModeH	= ( isset( $modal_size[ 'fullscreenH' ] ) )? $modal_size[ 'fullscreenH' ] : 'yes';
			$this->width			= ( 'yes' != $this->fullscreenModeW )? '' : 'width: auto;';
			$this->height			= ( 'yes' != $this->fullscreenModeH )? '' : 'height: auto;';
			$this->data				= $data;

			//nonce field
			$this->nonce = $view . '_' . $mode . '_opt_nonce';
		}

		public  function drawModal(){
			return $this->drawContent = '<div class="container-shortcode wtr_data_properties" data-width-mode="' .
					esc_attr( $this->fullscreenModeW ) . '"  data-height-mode="' . esc_attr( $this->fullscreenModeH ) . '" style="' . $this->width . '">
					<div class="wtrWpModal">
						<div class="wtrWpModalIn roundBor">
							<div class="wtrModalFormTitle roundBor_smal">
								<div class="wtrModalTitleIn">
									<h6>' . $this->obj->get( 'name' ) . ' - ' . $this->obj->get( 'title' ) . '</h6>
									<span  class="tclose-properties wtrModalClose"></span>
									<div class="clear"></div>
								</div>
							</div>
							<div class="wtrModalForm roundBor_smal ui-form scrollWtr" style="' . $this->height . '">
								<div class="wtrFieldsContainer wtrFieldsContainerProperties">
									<form id="ShortcodeFieldsFormProperties">
										' . wp_nonce_field( $this->nonce, $this->nonce ) . '
										' . $this->obj->draw( $this->data ) . '
									</form>
								</div>
								<div class="clear"></div>
							</div>
							<div class="footBtns onTheLine">
								<span class="WonButton yellow savebtn wtrUpdateClassesSchedule">'
									. __('Save changes',  'wtr_cs_framework' ) .
								'</span>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>';
		}// end drawModal


		public function Show(){
			echo $this->drawModal();
		}//end  Show
	}//end WTR_Modal_Tpl
}