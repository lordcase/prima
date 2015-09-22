<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */


// LOAD LIBS

	// # wp
	include_once '../get_wp.php';

	if( ! is_user_logged_in() OR ! isset( $_GET['h'] ) OR ! isset( $_GET['wtr_sht_id_data'] ) ) {
		return ;
	}
	$height				= trim( strip_tags( $_GET['h'] ) );
	$wtr_sht_id_data	= $_GET['wtr_sht_id_data'];

	echo '<div class="container-shortcode wtr_data_properties">
		<div class="wtrWpModal">
			<div class="wtrWpModalIn roundBor">
				<div class="wtrModalFormTitle roundBor_smal">
					<div class="wtrModalTitleIn">
						<h6>'. __( 'shortcode preview', 'wtr_sht_framework' ) .'</h6>
						<a href="" class="tclose-properties wtrModalClose"></a>
						<div class="clear"></div>
					</div>
				</div>
				<div class="wtrModalForm roundBor_smal ui-form scrollWtr">
					<div class="wtrFieldsContainer wtrFieldsContainerProperties postInside" style="overflow-x:hidden !important; overflow-y: scroll !important; bottom:20px;">
						<form id="ShortcodeFieldsFormProperties">
							<iframe style="width:100%; height:' . $height . 'px;" style="overflow:hidden !important;" src="' . PLUGIN_MCE_URI . 'view/shortcodePrevElement.php?wtr_sht_id_data=' . $wtr_sht_id_data . '"></iframe>
						</form>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>';