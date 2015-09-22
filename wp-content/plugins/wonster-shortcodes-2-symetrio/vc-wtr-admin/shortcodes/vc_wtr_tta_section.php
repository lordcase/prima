<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class VCExtendAddon_TTA_Section extends VCExtendAddonWtr{

	public $base				= 'vc_tta_section';

	public $contener_fields		= array();
	public static $fields_item	= array();

	//===FUNCTIONS
	public function __construct(){

		parent::__construct();

		// We safely integrate with VC with this hook
		add_action( 'init', array( &$this, 'integrateWithVC' ) );
	}//end __construct


	public static function get_fields_item(){
		return self::$fields_item;
	}//end get_fields_item

	public function integrateWithVC(){

		// removing unnecessary VC attributes
		vc_remove_param( 'vc_tta_section', 'i_position' );
		vc_remove_param( 'vc_tta_section', 'i_type' );
		vc_remove_param( 'vc_tta_section', 'i_icon_entypo' );
		vc_remove_param( 'vc_tta_section', 'i_icon_fontawesome' );
		vc_remove_param( 'vc_tta_section', 'i_icon_openiconic' );
		vc_remove_param( 'vc_tta_section', 'i_icon_typicons' );
		vc_remove_param( 'vc_tta_section', 'i_icon_linecons' );
		vc_remove_param( 'vc_tta_section', 'add_icon' );

		$icon_status = array(
			'param_name'	=> 'icon_status',
			'heading'		=> __( 'Tab icon', 'wtr_sht_framework' ),
			'description'	=> __( 'Specify the visibility of an icon (icon will display on the left before text)', 'wtr_sht_framework' ),
			'type'			=> 'dropdown',
			'value'			=> array(	__( 'No icon', 'wtr_sht_framework' )			=> '0',
										__( 'Yes ,display icon', 'wtr_sht_framework' )	=> '1'
									),
			'admin_label' 	=> false,
			'class'			=> $this->base . '_icon_status_class',
		);
		vc_add_param($this->base, $icon_status );
		array_push( self::$fields_item, $icon_status );

		$icon = array(
			'param_name'	=> 'icon',
			'heading'		=> __( 'Icon', 'wtr_sht_framework' ),
			'description'	=> __( 'Select the icon set', 'wtr_sht_framework' ),
			'type'			=> 'wtr_icons_set',
			'value'			=> 'web|fa fa-check-circle-o', // group | icon
			'admin_label' 	=> false,
			'class'			=> $this->base . '_icon_class',
			'dependency' => array(	'element' => 'icon_status',
									'value' => array( '1' ) )
		);
		vc_add_param($this->base, $icon );
		array_push( self::$fields_item, $icon );
	}//end integrateWithVC
}//end VCExtendAddon_TTA_Section

if( version_compare( WPB_VC_VERSION, '4.6', '>=' ) ){
	new VCExtendAddon_TTA_Section();
}