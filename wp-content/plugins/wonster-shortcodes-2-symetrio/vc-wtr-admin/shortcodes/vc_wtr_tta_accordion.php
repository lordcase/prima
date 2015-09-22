<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class VCExtendAddon_TTA_Accordion extends VCExtendAddonWtr{

	public $base				= 'vc_tta_accordion';
	public $base_child			= 'vc_tta_section_accordion';
	public $contener_fields		= array();
	public $fields_item			= array();

	//===FUNCTIONS
	public function __construct(){

		parent::__construct();

		// We safely integrate with VC with this hook
		add_action( 'init', array( &$this, 'integrateWithVC' ) );

		//Creating a shortcode addon
		add_shortcode( $this->base, array( &$this, 'renderContener' ), 10, 3 );
		add_shortcode( $this->base_child, array( &$this, 'renderItem' ), 10, 3  );
	}//end __construct


	public function integrateWithVC(){

		// removing unnecessary VC attributes
		$this->removeShortcodesParam(
			array(	$this->base => array( 'title', 'collapsible', 'active_tab', 'el_class', 'disable_keyboard', 'style',
										 'shape', 'color', 'no_fill', 'spacing', 'gap', 'c_align', 'autoplay',
										 'collapsible_all', 'c_icon', 'c_position', 'active_section' )
			)
		);

		// adding wtr attr
		$open = array(
				'param_name'	=> 'open',
				'heading'		=> __( 'Initial Open', 'wtr_sht_framework' ),
				'description'	=> __( 'Enter the number of the accordion Item that should be open initially,
										set to zero if all should be close on page load. <br/>', 'wtr_sht_framework' ),
				'type'		=> 'textfield',
				'value'			=> 1,
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_heading_class'
		);
		vc_add_param($this->base, $open );
		array_push( $this->contener_fields, $open );

		$behavior = array(
				'param_name'	=> 'behavior',
				'heading'		=> __( 'Behavior', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify behavior of your accordion', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Only one toggle open at a time (Accordion Mode)', 'wtr_sht_framework' )	=> 'true',
											__( 'Multiple toggles open allowed (Toggle Mode)', 'wtr_sht_framework' )		=> 'false' ),
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_behavior_class'
		);
		vc_add_param($this->base, $behavior );
		array_push( $this->contener_fields , $behavior );

		$el_class = $this->getDefaultVCfield( 'el_class' );
		vc_add_param($this->base, $el_class );
		array_push( $this->contener_fields , $el_class );

		// adding attributes "animation" to shortdcode
		$animate_effect = $this->shtAnimateAttrEffect( $this->shtCardName[ 'animate' ] );
		vc_add_param($this->base, $animate_effect );
		array_push( $this->contener_fields , $animate_effect );

		$animate_delay = $this->shtAnimateAttrDelay( $this->shtCardName[ 'animate' ] );
		vc_add_param($this->base, $animate_delay );
		array_push( $this->contener_fields , $animate_delay );

		//item data
		$this->fields_item = array(
			array(
				'param_name'	=> 'title',
				'type'			=> 'textfield',
				'value'			=> __( 'Section', 'wtr_sht_framework' ),
			),
		);

		// update map shortcode
		$setting = array (
			'name'			=> __( 'Accordion', 'wtr_sht_framework' ),
			'description'	=> '',
			'icon' 			=> 'vc_wtr_accordion_icon',
			'weight'		=> 40000,
		);
		vc_map_update($this->base, $setting );
	}//end integrateWithVC


	public function renderContener( $atts, $content = null, $sht ){

		$content = str_replace( 'vc_tta_section', $this->base_child, $content );

		$result				='';
		$atts['content']	= wpb_js_remove_wpautop( $content, false );
		$atts				= $this->prepareCorrectShortcode( $this->contener_fields, $atts );
		extract( $atts );

		$open = intval( $open );
		if( 0 > $open ){
			$open = 1;
		}

		$class_html_attr = 'wtrShtAccordion ' . $el_class;
		$result .= '<div data-mode="' . esc_attr( $behavior ) .'" data-open="' . esc_attr( $open ) .'" ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' >';
			$result .= '<ul class="wtrShtAccordionList">';
				$result .= $content;
			$result .= '</ul>';
		$result .= '</div>';

		return $result;
	}//end renderTabContener


	public function renderItem( $atts, $content = null, $sht ){

		$result				='';
		$atts['content']	= wpb_js_remove_wpautop( $content, false );
		$atts				= $this->prepareCorrectShortcode( VCExtendAddon_TTA_Section::get_fields_item(), $atts );

		extract( $atts );

		$section_icon = '';

		if( '1' == $icon_status ) {
			$section_icon = explode( "|", $icon );
			$section_icon = ( 2 == count( $section_icon ) ) ? '<i class="wtrAcIcon ' . esc_attr( $section_icon[1] ) . '"></i>' : '' ;
		}

		$result .= '<li class="wtrShtAccordionItem">';
			$result .= '<div class="wtrShtAccordionHeadline">' . $section_icon  . $title . '<span class="wtrShtAccordionNavi"></span></div>';
			$result .= '<div class="wtrShtAccordionItemContent">';
				$result .= $content;
			$result .= '</div>';
		$result .= '</li>';

		return $result;
	}//end renderTab

}//end VCExtendAddon_TTA_Accordion

if( version_compare( WPB_VC_VERSION, '4.6', '>=' ) ){
	new VCExtendAddon_TTA_Accordion();
}
