<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class VCExtendAddon_TTA_Tabs extends VCExtendAddonWtr{

	public $base				= 'vc_tta_tabs';
	public $base_child			= 'vc_tta_section_tabs';
	public $contener_fields		= array();
	public $fields_item			= array();

	private static $type_mod		= '';
	private static $count_full_tabs	= 0;
	private static $tabs_items		= '';
	private static $items_count		= 1;

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
			array(	$this->base => array(	'title', 'no_fill_content_area', 'tab_position', 'tab_position', 'pagination_style',
											'style', 'shape', 'color', 'spacing', 'gap' , 'autoplay', 'active_section',
											'alignment', 'el_class', 'pagination_color' )
			)
		);

		// adding wtr attr
		$type_mod = array(
				'param_name'	=> 'type_mod',
				'heading'		=> __( 'Presentation style', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Standard', 'wtr_sht_framework' )	=> 'standard',
											__( 'Full width', 'wtr_sht_framework' )	=> 'full_width'
										),
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_type_mod_class'
		);
		vc_add_param($this->base, $type_mod );
		array_push( $this->contener_fields, $type_mod );

		$open = array(
				'param_name'	=> 'open',
				'heading'		=> __( 'Initial Open', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify a <b>number</b>, which tab item should be open initially', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> 1,
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_heading_class'
		);
		vc_add_param($this->base, $open );
		array_push( $this->contener_fields, $open );

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
			'name'			=> __( 'Tabs', 'wtr_sht_framework' ),
			'description'	=> '',
			'icon' 			=> 'vc_wtr_tabs_icon',
			'weight'		=> 17000,
		);
		vc_map_update($this->base, $setting );
	}//end integrateWithVC


	public function renderContener( $atts, $content = null, $sht ){

		$atts				= $this->prepareCorrectShortcode( $this->contener_fields, $atts );

		self::$tabs_items	= '';
		self::$type_mod		= $atts['type_mod'];
		self::$items_count	= 1;

		$content = str_replace( 'vc_tta_section', $this->base_child, $content );

		$result				= '';
		$atts['content']	= wpb_js_remove_wpautop( $content, false );

		extract( $atts );

		$open = intval( $open );
		if( 0 >= $open ){
			$open = 1;
		}

		if( 'standard' == $type_mod ){

			$class_html_attr = 'wtrSht wtrShtTabs ' . $el_class;

			$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' >';
				 $result .= '<div data-open="' . $open . '" class="wtrShtHorizontalTab">';
					$result .= '<ul class="wtrShtTabList resp-tabs-list clearfix">';
						$result .= $content;
					$result .= '</ul>';
					$result .= '<div class="wtrShtTabsContainer resp-tabs-container">';
						$result .= self::$tabs_items;
					$result .= '</div>';
				$result .= '</div>';
			$result .= '</div>';

		} else if( 'full_width' ==  self::$type_mod ) {

			$class_html_attr = 'wtrSht wtrShtFullWidthTabs ' .  $el_class;

			$result .= '<div data-open="' . $open . '" id="wtrFullWidthTabs-' . self::$count_full_tabs++ . '" ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' >';
				$result .= '<nav class="wtrShtFWT">';
					$result .= '<ul class="wtrShtFullWidthTabsLits clearfix">';
						$result .= $content;
					$result .= '</ul>';
				$result .= '</nav>';
				$result .= '<div class="wtrShtFullWidthTabContent">';
					$result .= self::$tabs_items;
				$result .= '</div>';
			$result .= '</div>';

		}

		return $result;
	}//end renderTabContener


	public function renderItem( $atts, $content = null, $sht ){

		$result				='';
		$atts['content']	= wpb_js_remove_wpautop( $content, false );
		$atts				= $this->prepareCorrectShortcode( VCExtendAddon_TTA_Section::get_fields_item(), $atts );
		extract( $atts );

		$tab_icon = '';

		if( '1' == $icon_status ) {
			$tab_icon = explode( "|", $icon );
			$tab_icon = ( 2 == count( $tab_icon ) ) ? '<i class="' . esc_attr( $tab_icon[1] ) . '"></i>' : '' ;
		}

		if( 'standard' ==  self::$type_mod ){

				self::$tabs_items .= '<div class="wtrShtTabItem">';
					self::$tabs_items .= '<div class="wtrShtTabItemContainer wtrTabAnimationInside">';
						self::$tabs_items .= $content;
					self::$tabs_items .= '</div>';
				self::$tabs_items .= '</div>';

			$result .= '<li class="wtrTabAnimation">' . $tab_icon . $title . '</li>';

		} else if( 'full_width' ==  self::$type_mod  ) {
			self::$tabs_items .= '<section id="section-' . self::$items_count . '" class="wtrShtFullWidthTabSection">';
				self::$tabs_items .= '<div class="wtrInner ">';
					self::$tabs_items .= '<div class="wtrPageContent clearfix">';
						self::$tabs_items .= $content;
					self::$tabs_items .= '</div>';
				self::$tabs_items .= '</div>';
			self::$tabs_items .= '</section>';

			$result .= '<li><a href="#section-' . self::$items_count . '" class="wtrShtFullWidthTabsAnimate">' . $tab_icon . '<span class="wrtAltFontCharacter">' . $title . '</span></a></li>';
		}

		self::$items_count++;
		return $result;
	}//end renderTab

}//end VCExtendAddon_TTA_Tabs

if( version_compare( WPB_VC_VERSION, '4.6', '>=' ) ){
	new VCExtendAddon_TTA_Tabs();
}