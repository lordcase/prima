<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class VCExtendAddonTextBlock extends VCExtendAddonWtr{

	public $base		= 'vc_column_text';
	public $fields		= array();

	//===FUNCTIONS
	public function __construct(){

		parent::__construct();

		// We safely integrate with VC with this hook
		add_action( 'init', array( &$this, 'integrateWithVC' ) );

		//Creating a shortcode addon
		add_shortcode( $this->base, array( &$this, 'render' ), 10, 3 );
	}//end __construct


	public function integrateWithVC(){

		// removing unnecessary VC attributes
		$this->removeShortcodesParam(
			array( $this->base => array( 'css_animation', 'css' ) )
		);

		// adding attributes "animation" to shortdcode
		$animate_effect = $this->shtAnimateAttrEffect( $this->shtCardName[ 'animate' ] );
		vc_add_param($this->base, $animate_effect );
		array_push( $this->fields , $animate_effect );

		$animate_delay = $this->shtAnimateAttrDelay( $this->shtCardName[ 'animate' ] );
		vc_add_param($this->base, $animate_delay );
		array_push( $this->fields , $animate_delay );

		$el_class = $this->getDefaultVCfield( 'el_class' );
		vc_add_param($this->base, $el_class );
		array_push( $this->fields, $el_class );

		// update map shortcode
		$setting = array (
			'icon'			=> 'vc_wtr_text_block_icon',
			'description'	=> '',
			'weight'		=> 65000,
		);
		vc_map_update($this->base, $setting );
	}//end integrateWithVC


	public function render( $atts, $content = null, $sht ){
		$result				= '';
		$atts['content']	= wpb_js_remove_wpautop( $content, WPBMap::getTagsRegexp() );
		$atts				= $this->prepareCorrectShortcode( $this->fields, $atts );
		//
		extract( $atts );

		$class_html_attr = 'wpb_text_column wpb_content_element ' . esc_attr( $el_class );
		$result .= "\n\t" . '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . '>';
		$result .= "\n\t\t" . '<div class="wpb_wrapper">';
		$result .= "\n\t\t\t" . $content;
		$result .= "\n\t\t" . '</div> ';
		$result .= "\n\t" . '</div> ';

		return $result;
	}//end renderTabContener

}//end VCExtendAddonTextBlock

new VCExtendAddonTextBlock();