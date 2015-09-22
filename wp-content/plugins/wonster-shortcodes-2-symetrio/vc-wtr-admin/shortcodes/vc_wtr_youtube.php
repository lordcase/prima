<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class VCExtendAddonYoutube extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_youtube';
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
				'description'	=> __( 'Working example: http://www.youtube.com/watch?v=<b>G0k3kHtyoqc</b>.
										Please insert only: <b>G0k3kHtyoqc</b>', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> true,
				'class'			=> $this->base . '_url_class',
			),


			array(
				'param_name'	=> 'size',
				'heading'		=> __( 'Movie size', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Super big ( 960 x 720 )', 'wtr_sht_framework' )	=> '960-720',
											__( 'Big ( 640 x 480 )', 'wtr_sht_framework' )			=> '640-480',
											__( 'Medium ( 480 x 360 )', 'wtr_sht_framework' )		=> '480-360',
											__( 'Small ( 420 x 315 )', 'wtr_sht_framework' )		=> '420-315',
											__( 'Custom', 'wtr_sht_framework' )						=> 'custom'
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_size_class',
			),

			array(
				'param_name'	=> 'width',
				'heading'		=> __( 'Video width', 'wtr_sht_framework' ),
				'description'	=> __( 'Enter a value for the width. <b>Please, use only numeric signs</b>', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> 480,
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
				'value'			=> 360,
				'admin_label' 	=> false,
				'class'			=> $this->base . '_height_class',
				'dependency' 	=> array(	'element'	=> 'size',
											'value'		=> array( 'custom' ) )
			),

			array(
				'param_name'	=> 'resolution',
				'heading'		=> __( 'Movie resolution', 'wtr_sht_framework' ),
				'description'	=> __( 'If you select a higher resolution than available for this film,
										YouTube automatically select the highest available resolution', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Small - 240p', 'wtr_sht_framework' )		=> 'small',
											__( 'Medium - 360p', 'wtr_sht_framework' )		=> 'medium',
											__( 'Large - 480p', 'wtr_sht_framework' )		=> 'large',
											__( 'HD Ready - 720p', 'wtr_sht_framework' )	=> 'hd720',
											__( 'Full HD - 1080p', 'wtr_sht_framework' )	=> 'hd1080'
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_resolution_class',
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

			array(
				'param_name'	=> 'theme',
				'heading'		=> __( 'Theme', 'wtr_sht_framework' ),
				'description'	=> __( 'This parameter indicates whether the embedded player will display player
										controls (like a \'play\' button or volume control) within a dark or light
										control bar', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Dark theme', 'wtr_sht_framework' )		=> 'dark',
											__( 'Light theme', 'wtr_sht_framework' )	=> 'light'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_theme_class',
			),

			array(
				'param_name'	=> 'color',
				'heading'		=> __( 'Color', 'wtr_sht_framework' ),
				'description'	=> __( 'This parameter specifies the color that will be used in the player\'s video
										progress bar to highlight the amount of the video that the viewer has already
										seen', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Red', 'wtr_sht_framework' )	=> 'c_red',
											__( 'White', 'wtr_sht_framework' )	=> 'c_white'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_color_class',
			),

			$this->getDefaultVCfield( 'el_class' ),

			array(
				'param_name'	=> 'autoplay',
				'heading'		=> __( 'Autoplay', 'wtr_sht_framework' ),
				'description'	=> __( 'Play the video automatically on load. <b>Note that this won’t work on some
										devices</b>', 'wtr_sht_framework' ),
				'group'			=> $this->shtCardName[ 'advanced' ],
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'On', 'wtr_sht_framework' )	 => '1',
											__( 'Off', 'wtr_sht_framework' ) => '0'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_autoplay_class',
			),

			array(
				'param_name'	=> 'controls',
				'heading'		=> __( 'Show controls', 'wtr_sht_framework' ),
				'description'	=> __( 'This parameter indicates whether the video player controls will
										display', 'wtr_sht_framework' ),
				'group'			=> $this->shtCardName[ 'advanced' ],
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'On', 'wtr_sht_framework' )	 => '1',
											__( 'Off', 'wtr_sht_framework' ) => '0'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_controls_class',
			),

			array(
				'param_name'	=> 'showinfo',
				'heading'		=> __( 'Show info about author', 'wtr_sht_framework' ),
				'description'	=> __( 'If you set the parameter value to "Off", then the player will not display
										information like the video title and uploader before the video starts
										playing', 'wtr_sht_framework' ),
				'group'			=> $this->shtCardName[ 'advanced' ],
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'On', 'wtr_sht_framework' )	 => '1',
											__( 'Off', 'wtr_sht_framework' ) => '0'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_showinfo_class',
			),

			array(
				'param_name'	=> 'rel',
				'heading'		=> __( 'Show related videos', 'wtr_sht_framework' ),
				'description'	=> __( 'This parameter indicates whether the player should show related videos when
										playback of the initial video ends', 'wtr_sht_framework' ),
				'group'			=> $this->shtCardName[ 'advanced' ],
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'On', 'wtr_sht_framework' )	 => '1',
											__( 'Off', 'wtr_sht_framework' ) => '0'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_rel_class',
			),

		);

		vc_map( array(
			'name'			=> __( 'Youtube', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'media' ],
			'params'		=> $this->fields,
			'weight'		=> 10000,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result		='';
		$preFixAttr	= array( 'url' => array( 'bad_value' => array( '' ), 'replace' => 'G0k3kHtyoqc' ) );
		$atts		= $this->prepareCorrectShortcode( $this->fields, $atts, $preFixAttr );
		extract( $atts );

		if( 'custom' != $size ){
			$size_tmp = explode( '-', $size );
			if( 2 == count( $size_tmp ) ) {
				$width	= $size_tmp[0];
				$height	= $size_tmp[1];
			}
		}

		$color			= substr( $color, 2 );
		$classCenter	= ( 'none' == $align ) ? '' : 'wtrCenterVideo';

		$result  = '<div class="video-sizer '. $classCenter .' ' . esc_attr( $el_class ) . ' " style="max-width:' . intval( $width ) . 'px; max-height:' . intval( $height ) . 'px;" >';
		$result .= '<div class="video-container">';
		$result .= '<iframe style="border:0;" src="http://www.youtube.com/embed/' . esc_attr( $url ) . '?autoplay=' . intval( $autoplay ) . '&amp;controls=' . intval( $controls ) . '&amp;showinfo=' . intval( $showinfo ) . '&amp;rel=' . intval( $rel ) . '&amp;theme=' . esc_attr( $theme ) . '&amp;color=' . esc_attr( $color ) . '&amp;vq=' . esc_attr( $resolution ) . ' " height="' . intval( $height ) . '" width="' . intval( $width ) . '" allowfullscreen=""></iframe>';
		$result .= '</div>';
		$result .= '</div>';

		return $result;
	}//end Render

}//end VCExtendAddonYoutube

new VCExtendAddonYoutube();