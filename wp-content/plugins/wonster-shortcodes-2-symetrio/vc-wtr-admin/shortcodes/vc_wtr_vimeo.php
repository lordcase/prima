<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class VCExtendAddonVimeo extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_vimeo';
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
				'param_name'	=> 'url',
				'heading'		=> __( 'Movie ID', 'wtr_sht_framework' ),
				'description'	=> __( 'Working example: http://vimeo.com/<b>75746181</b><br/>
										Please insert only: <b>75746181</b>', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> true,
				'class'			=> $this->base . '_url_class',
			),

			array(
				'param_name'	=> 'color',
				'heading'		=> __( 'Color', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the color of the video controls.', 'wtr_sht_framework' ),
				'type'			=> 'colorpicker',
				'value'			=> '#00adef',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_color_class',
			),

			array(
				'param_name'	=> 'size',
				'heading'		=> __( 'Movie size', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Big ( 750 x 422 )', 'wtr_sht_framework' )		=> '750-422',
											__( 'Medium ( 500 x 281 )', 'wtr_sht_framework' )	=> '500-281',
											__( 'Small ( 360 x 202 )', 'wtr_sht_framework' )	=> '360-202',
											__( 'Custom', 'wtr_sht_framework' )					=> 'custom'
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_size_class',
			),

			array(
				'param_name'	=> 'width',
				'heading'		=> __( 'Video width', 'wtr_sht_framework' ),
				'description'	=> __( 'Enter a value for the width. <b>Please, use only numeric signs</b>', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> 750,
				'admin_label' 	=> false,
				'class'			=> $this->base . '_width_class',
				'dependency' 	=> array(	'element'	=> 'size',
											'value'		=> array( 'custom' ) )
			),

			array(
				'param_name'	=> 'height',
				'heading'		=> __( 'Video height', 'wtr_sht_framework' ),
				'description'	=> __( 'Enter a value for the height. <b>Please, use only numeric signs</b>', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> 422,
				'admin_label' 	=> false,
				'class'			=> $this->base . '_height_class',
				'dependency' 	=> array(	'element'	=> 'size',
											'value'		=> array( 'custom' ) )
			),

			array(
				'param_name'	=> 'align',
				'heading'		=> __( 'Element alignment', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the alignment for your movie', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'None', 'wtr_sht_framework' )	=> 'none',
											__( 'Center', 'wtr_sht_framework' )	=> 'center'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_align_class',
			),

			$this->getDefaultVCfield( 'el_class' ),

			array(
				'param_name'	=> 'autoplay',
				'heading'		=> __( 'Autoplay', 'wtr_sht_framework' ),
				'description'	=> __( 'Play the video automatically on load.<b>Note that this won’t work on some devices</b>', 'wtr_sht_framework' ),
				'group'			=> $this->shtCardName[ 'advanced' ],
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'On', 'wtr_sht_framework' )	 => '1',
											__( 'Off', 'wtr_sht_framework' ) => '0'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_autoplay_class',
			),

			array(
				'param_name'	=> 'autor',
				'heading'		=> __( 'Portrait', 'wtr_sht_framework' ),
				'description'	=> __( 'Show the user’s portrait on the Video', 'wtr_sht_framework' ),
				'group'			=> $this->shtCardName[ 'advanced' ],
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'On', 'wtr_sht_framework' )	 => '1',
											__( 'Off', 'wtr_sht_framework' ) => '0'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_autor_class',
			),

			array(
				'param_name'	=> 'title',
				'heading'		=> __( 'Title', 'wtr_sht_framework' ),
				'description'	=> __( 'Show the title on the video', 'wtr_sht_framework' ),
				'group'			=> $this->shtCardName[ 'advanced' ],
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'On', 'wtr_sht_framework' )	 => '1',
											__( 'Off', 'wtr_sht_framework' ) => '0'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_title_class',
			),

			array(
				'param_name'	=> 'byline',
				'heading'		=> __( 'User’s byline', 'wtr_sht_framework' ),
				'description'	=> __( 'Show the user’s byline on the video', 'wtr_sht_framework' ),
				'group'			=> $this->shtCardName[ 'advanced' ],
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'On', 'wtr_sht_framework' )	 => '1',
											__( 'Off', 'wtr_sht_framework' ) => '0'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_byline_class',
			),

			array(
				'param_name'	=> 'loop',
				'heading'		=> __( 'Play video in loop', 'wtr_sht_framework' ),
				'description'	=> __( 'Play the video again when it reaches the end', 'wtr_sht_framework' ),
				'group'			=> $this->shtCardName[ 'advanced' ],
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'On', 'wtr_sht_framework' )	 => '1',
											__( 'Off', 'wtr_sht_framework' ) => '0'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_loop_class',
			),
		);

		vc_map( array(
			'name'			=> __( 'Vimeo', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'media' ],
			'params'		=> $this->fields,
			'weight'		=> 12000,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result		='';
		$preFixAttr	= array( 'url' => array( 'bad_value' => array( '' ), 'replace' => '75746181' ) );
		$atts		= $this->prepareCorrectShortcode( $this->fields, $atts, $preFixAttr );
		extract( $atts );

		if( 'custom' != $size ){
			$size_tmp = explode( '-', $size );
			if( 2 == count( $size_tmp ) ) {
				$width	= $size_tmp[0];
				$height	= $size_tmp[1];
			}
		}

		$color			= substr( $color, 1 );
		$classCenter	= ( 'none' == $align ) ? '' : 'wtrCenterVideo';

		$result  = '<div class="video-sizer '. $classCenter .'" style="max-width:' . intval( $width ) . 'px; max-height:' . intval( $height ) . 'px;" >';
		$result .= '<div class="video-container">';
		$result .= '<iframe style="border: 0;" src="http://player.vimeo.com/video/' . esc_attr( $url ) . '?portrait=' . esc_attr( $autor ) . '&amp;color=' . esc_attr( $color ) . '&amp;byline=' . intval( $byline ) . '&amp;loop=' . intval( $loop ) . '&amp;autoplay=' . intval( $autoplay ) . '&amp;title=' . esc_attr( $title ) . '" width="' . intval( $width ) . '" height="' . intval( $height ) . '" allowFullScreen></iframe>';
		$result .= '</div>';
		$result .= '</div>';

		return $result;
	}//end Render

}//end VCExtendAddonVimeo

new VCExtendAddonVimeo();