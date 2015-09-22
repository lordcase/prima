/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

(function($) {

	"use strict";

	$(document).ready(function(){
		var template = $( '<div style="margin-top: 20px; border: 2px solid #EADBA2;  padding: 10px;background: #FCF3CF; color: #AA7A49;border-radius: 3px;"> '+ wtr_customize_desc + ' </div>' );
		$( '#customize-info .site-title' ).after( template );
	});
})(jQuery);