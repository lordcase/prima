<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

if ( ! class_exists( 'WTR_Shortcode_Tpl' ) ) {

	class WTR_Shortcode_Tpl {

		// VARIABLES
		private $obj;
		private $fullscreenModeW;
		private $fullscreenModeH;
		private $width;
		private $height;
		private $data;
		private $drawContent;


		// FUNCTIONS
		public function __construct( $obj, $data ){

			$this->obj				= $obj;
			$this->optionGroup		= $this->obj->getGroupFields();
			$modal_size				= $this->obj->get( 'modal_size' );
			$this->fullscreenModeW	= ( isset( $modal_size[ 'fullscreenW' ] ) )? $modal_size[ 'fullscreenW' ] : 'yes';
			$this->fullscreenModeH	= ( isset( $modal_size[ 'fullscreenH' ] ) )? $modal_size[ 'fullscreenH' ] : 'yes';
			$this->width			= ( 'yes' != $this->fullscreenModeW )? '' : 'width: auto;';
			$this->height			= ( 'yes' != $this->fullscreenModeH )? '' : 'height: auto;';

			$this->data = json_decode( $data, true ) ;

		}// end __construct


		public function drawModal( $opt ){

			$this->drawContent = '<div class="container-shortcode wtr_data_shortcodes" data-width-mode="' . $this->fullscreenModeW . '"  data-height-mode="' . $this->fullscreenModeH . '" style="' . $this->width . '">
					<div class="wtrWpModal">
						<div class="wtrWpModalIn roundBor">
							<div class="wtrModalFormTitle roundBor_smal">
								<div class="wtrModalTitleIn">';

									if( '0' == $opt ){
										$this->drawContent .= '<a href="" class="wtrModalBack"></a>';
									}

									$this->drawContent .= '<h6>' . __( 'Shortcode', 'wtr_sht_framework' ) . ' - ' . $this->obj->get( 'name' ) . '</h6>
									<ul class="wtrTabs">' . $this->createGrupOptionTab( ). '</ul>
									<span class="tclose wtrModalClose"></span>
									<div class="clear"></div>
								</div>
							</div>
							<div class="wtrModalForm roundBor_smal ui-form scrollWtr" style="' . $this->height .  '">
								<div class="wtrFieldsContainer wtrFieldsContainerShortcodes" type="' . $this->obj->get( 'shortcode_id' ) . '" end_el="' . $this->obj->get( 'end_el' ) . '">
									<form id="ShortcodeFieldsFormShortcodes">
										' . $this->obj->draw( $this->data ) . '
									</form>
								</div>
								<div class="clear"></div>
							</div>
							<div class="footBtns onTheLine">';

								if( false == $this->obj->get( 'no_prev' ) ){
									$this->drawContent .= '<a href="" class="WonButton blue wonBtnPreview ">' . __( 'Preview shortcode', 'wtr_sht_framework' ) . '</a>';
								}

								$this->drawContent .= '
								<a href="" class="WonButton yellow savebtn wtrInsertSortcut">';

									if( '0' == $opt ){
										$this->drawContent .= __( '&nbsp;&nbsp;&nbsp;Insert sortcode&nbsp;&nbsp;&nbsp;', 'wtr_sht_framework' );
									} else {
										$this->drawContent .= __( 'Save changes', 'wtr_sht_framework' );
									}

								$this->drawContent .= '</a>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>';
		}// end drawModal


		public  function drawModalProperties(){
			$this->drawContent = '<div class="container-shortcode wtr_data_properties" data-width-mode="' . $this->fullscreenModeW . '"  data-height-mode="' . $this->fullscreenModeH . '" style="' . $this->width . '">
					<div class="wtrWpModal">
						<div class="wtrWpModalIn roundBor">
							<div class="wtrModalFormTitle roundBor_smal">
								<div class="wtrModalTitleIn">
									<h6>' . $this->obj->get( 'name' ) . ' - ' . __('Edit Item',  'wtr_sht_framework' ) . '</h6>
									<span  class="tclose-properties wtrModalClose"></span>
									<div class="clear"></div>
								</div>
							</div>
							<div class="wtrModalForm roundBor_smal ui-form scrollWtr" style="' . $this->height . '">
								<div class="wtrFieldsContainer wtrFieldsContainerProperties" type="' . $this->obj->get( 'shortcode_id' ) . '" end_el="' . $this->obj->get( 'end_el' ) . '">
									<form id="ShortcodeFieldsFormProperties">
										' . $this->obj->draw( $this->data ) . '
									</form>
								</div>
								<div class="clear"></div>
							</div>
							<div class="footBtns onTheLine">
								<a href="" class="WonButton yellow savebtn wtrInsertSortcut  wtrInsertSortcutProperties">' . __('Save changes',  'wtr_sht_framework' ) . '</a>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>';
		} // end drawModalProperties


		public function Show(){
			echo $this->drawContent;
		}// Show


		public function createGrupOptionTab(){

			$result = '';
			$counterItem = 0;
			foreach( $this->optionGroup as $group => $name ){

				if( 0 == $counterItem ){
					$display = 'activeWtrTab';
					++$counterItem;
				}
				else{
					$display = 'nonActiveWtrTab';
				}

				$result .= '<li><span data-group="wtr_sht_subform_detal_' . $group . '" class="' . $display . ' wtrGroupOptionTabs wtrGroupDisplayTrigger">' . $name . '</span></li>';
			}

			return $result;
		}// end createGrupOptionTab
	} // WTR_Shortcode_Tpl
}