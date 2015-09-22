<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class VCExtendAddonNotification extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_notification';
	public $fields	= array();

	//===FUNCTIONS
	public function __construct(){

		parent::__construct();

		// We safely integrate with VC with this hook
		add_action( 'init', array( &$this, 'integrateWithVC' ) );

		//Creating a shortcode addon
		add_shortcode( $this->base, array( &$this, 'render' ) );
	}//end __construct


	public function integrateWithVC(){
		// Map fields

		$this->fields = array(

			array(
				'param_name'	=> 'info',
				'heading'		=> __( 'Your message', 'wtr_sht_framework' ),
				'description'	=> __( 'Notification message', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> __( 'Information', 'wtr_sht_framework' ),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_info_class',
			),

			array(
				'param_name'	=> 'color',
				'heading'		=> __( 'Color', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the color for your notification message', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Green', 'wtr_sht_framework' )	=> 'c_green',
											__( 'Yellow', 'wtr_sht_framework' )	=> 'c_yellow',
											__( 'Blue', 'wtr_sht_framework' )	=> 'c_blue',
											__( 'Red', 'wtr_sht_framework' )	=> 'c_red',
											__( 'Grey', 'wtr_sht_framework' )	=> 'c_grey',
											__( 'White', 'wtr_sht_framework' )	=> 'c_transparent'
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_color_class',
			),

			array(
				'param_name'	=> 'align',
				'heading'		=> __( 'Text alignment', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the alignment for your message', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Left', 'wtr_sht_framework' )	=> 'wtrShtAlignLeft',
											__( 'Right', 'wtr_sht_framework' )	=> 'wtrShtAlignRight',
											__( 'Center', 'wtr_sht_framework' )	=> 'wtrShtAlignCenter'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_align_class',
			),

			array(
				'param_name'	=> 'icon_status',
				'heading'		=> __( 'Notification icon', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the visibility of an icon (icon will display on the left before text)', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'No icon', 'wtr_sht_framework' )			=> '0',
											__( 'Yes ,display icon', 'wtr_sht_framework' )	=> '1'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_icon_status_class',
			),
				/* icons */
				array(
					'param_name'	=> 'icon',
					'heading'		=> __( 'Icon', 'wtr_sht_framework' ),
					'description'	=> __( 'Select the icon set', 'wtr_sht_framework' ),
					'type'			=> 'wtr_icons_set',
					'value'			=> 'web|fa fa-check-circle-o', // group | icon
					'admin_label' 	=> false,
					'class'			=> $this->base . '_icon_class',
					'dependency' => array(	'element' => 'icon_status',
											'value' => array( '1' ) )
				),

			array(
				'param_name'	=> 'link_status',
				'heading'		=> __( 'Notification link', 'wtr_sht_framework' ),
				'description'	=> __( 'Is the notification message will contain a link?', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'No', 'wtr_sht_framework' )		=> '0',
											__( 'Yes', 'wtr_sht_framework' )	=> '1'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_link_status_class',
			),
				/* link */
				array(
					'param_name'	=> 'anhor',
					'heading'		=> __( 'Link title', 'wtr_sht_framework' ),
					'description'	=> __( 'This is the text that appears on your link', 'wtr_sht_framework' ),
					'type'			=> 'textfield',
					'value'			=> __( 'Click me', 'wtr_sht_framework' ),
					'admin_label' 	=> false,
					'class'			=> $this->base . '_anhor_class',
					'dependency' => array(	'element' => 'link_status',
											'value' => array( '1' ) )
				),

				array(
					'param_name'	=> 'url',
					'heading'		=> __( 'Link URL', 'wtr_sht_framework' ),
					'description'	=> __( 'Where should notification link to?', 'wtr_sht_framework' ),
					'type'			=> 'vc_link',
					'value'			=> '',
					'admin_label' 	=> false,
					'class'			=> $this->base . '_url_class',
					'dependency' => array(	'element' => 'link_status',
											'value' => array( '1' ) )
				),

				$this->getDefaultVCfield( 'el_class' ),
			);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );

		vc_map( array(
			'name'			=> __( 'Notification', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'elements' ],
			'params'		=> $this->fields,
			'weight'		=> 24000,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result	='';
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract( $atts );


		$class_color		= substr( $color, 2 );
		$icon_element		= '';
		$link				= '';

		if( 1 == $icon_status ){
			$icon_element	= explode( "|", $icon );
			$icon_element	= ( ! empty( $icon_element[1] ) ) ? '<i class="' . esc_attr( $icon_element[1] ) . '"></i>' : '';
		}

		if( 1 == $link_status ){
			$url_str		= ( ( 0 == substr_count( $url, '|' ) ) AND isset( $target ) ) ? $url . '|target:'. esc_attr( $target ) : $url;
			$url_str		= str_replace("|", "&", $url_str );
			$url_str		= str_replace(":", "=", $url_str );
			parse_str( $url_str, $url_attr );

			extract(shortcode_atts(array(
				'url'		=> '',
				'target'	=> '',
			), $url_attr) );

			$target			= ( empty( $target ) ) ? '' : 'target="_blank"';
			$link			= ' <a href="' . esc_url( $url ) . '" ' . $target .'>' . $anhor . '</a>';
		}

		$class_html_attr = 'wtrNotification ' . $class_color . ' ' . $align . ' ' . $el_class ;
		$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . '>';
			$result .= $icon_element;
			$result .= $info;
			$result .= $link;
		$result .= '</div>';

		return $result;
	}//end Render

}//end VCExtendAddonNotification

new VCExtendAddonNotification();