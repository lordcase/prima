<?php
/**
 * footer functions
 *
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! function_exists( 'wtr_helper_classes_skill_dot' ) ){

	function wtr_helper_classes_skill_dot( $lvl ){

		global $post_settings;
		$result = '';

		if( 5 == $lvl ){
			$result .= str_repeat( '<li class="wtrShtBoxedClassesSkillDot active wtrRadius100"></li>', 4 );
			$result .= '<li class="wtrShtBoxedClassesSkillDot active wtrLastSkillDot wtrRadius100"></li>';
		} else {
			$result .= str_repeat( '<li class="wtrShtBoxedClassesSkillDot active wtrRadius100"></li>', $lvl );
			$result .= str_repeat( '<li class="wtrShtBoxedClassesSkillDot wtrRadius100"></li>', 4 - $lvl );
			$result .= '<li class="wtrShtBoxedClassesSkillDot wtrLastSkillDot wtrRadius100"></li>';
		}
		$result .= '<li class="wtrTooltip wtrRadius3"><span class="wtrTooltipContent">' . $post_settings['wtr_TranslateClassesLevel_' . $lvl ] . '</span></li>';
		return $result;
	}//end wtr_helper_classes_skill_dot
}


if( ! function_exists( 'wtr_helper_hex2rgba' ) ){

	function wtr_helper_hex2rgba( $hex , $alpha_channel = 1 ) {

		if( is_numeric( strpos( $hex, 'rgba' ) ) ){
			return $hex;
		}

		$hex = str_replace("#", "", $hex);

		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}

		$rgba = "rgba( $r, $g, $b, $alpha_channel)";
		return $rgba;
	} // end wtr_helper_hex2rgba
}