<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

require_once('../get_wp.php');

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

require_once( '../class/wtr_tabs_tinymce.php' );
require_once('../../wtr_init_shortcodes.php');
?>

<div class="container">

	<div class="wtrWpModal">
		<div class="wtrWpModalIn roundBor">
			<div class="wtrModalFormTabs">
				<a href="" class="tclose wtrModalClose"></a>
			<div id="wtrModalTabs">
				<ul class="resp-tabs-list">
					<?php
						// draw head tabs
						echo $wtr_shortcode_obj->drawHead();
					?>
				</ul>
				<div class="resp-tabs-container">
					<?php
						// draw content tabs
						echo $wtr_shortcode_obj->drawContent();
					?>
					<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>