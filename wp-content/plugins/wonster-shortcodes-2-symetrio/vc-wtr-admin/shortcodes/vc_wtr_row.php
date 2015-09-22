<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class VCExtendAddonRow extends VCExtendAddonWtr{

	public $base			= 'vc_row';
	public $base_inner		= 'vc_row_inner';
	public $fields			= array();
	public $fields_inner	= array();

	private static $yt_player		= 0;
	private static $vimeo_player	= 0;

	//===FUNCTIONS
	public function __construct(){

		parent::__construct();

		self::$sht_list[] = $this->base;
		self::$sht_list[] = $this->base_inner;

		// We safely integrate with VC with this hook
		add_action( 'init', array( &$this, 'integrateWithVC' ) );

		//Creating a shortcode addon
		add_shortcode( $this->base, array( &$this, 'render' ), 10, 3 );
		add_shortcode( $this->base_inner, array( &$this, 'render_inner' ), 10, 3 );
	}//end __construct


	public function integrateWithVC(){

		// removing unnecessary VC attributes

		if( version_compare( WPB_VC_VERSION, '4.6', '>=' ) ){
			$this->removeShortcodesParam(
				array(
					$this->base			=> array( 'font_color', 'el_class', 'el_id', 'full_width', 'full_height', 'video_bg', 'video_bg_url', 'video_bg_parallax', 'content_placement' ),
					$this->base_inner	=> array( 'font_color', 'el_class', 'el_id', 'full_width', 'full_height', 'video_bg', 'video_bg_url', 'video_bg_parallax', 'content_placement' ),
				)
			);
		}else{
			$this->removeShortcodesParam(
				array(
					$this->base			=> array( 'font_color', 'el_class', 'el_id', 'full_width' ),
					$this->base_inner	=> array( 'font_color', 'el_class', 'el_id', 'full_width' ),
				)
			);
		}

		// adding wtr attr
		$row_type = array(
				'param_name'	=> 'row_type',
				'heading'		=> __( 'Row type', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Boxed', 'wtr_sht_framework' )								=> 'boxed',
											__( 'Full width with inner container', 'wtr_sht_framework' )	=> 'full_width_grid',
											__( 'Full width', 'wtr_sht_framework' )							=> 'full_width'
										),
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_row_type_class'
		);
		vc_add_param($this->base, $row_type );
		array_push( $this->fields, $row_type );

		$columns_type = array(
				'param_name'	=> 'columns_type',
				'heading'		=> __( 'Columns type', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Spacing between columns', 'wtr_sht_framework' )		=> 'wtrMargin',
											__( 'No spacing between the columns', 'wtr_sht_framework' )	=> 'wtrNoMargin',
										),
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_columns_type_class'
		);
		vc_add_param($this->base, $columns_type );
		array_push( $this->fields, $columns_type );
		vc_add_param($this->base_inner, $columns_type );
		array_push( $this->fields_inner, $columns_type );

		$columns_autohight = array(
				'param_name'	=> 'columns_autohight',
				'heading'		=> __( 'Auto height columns', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'No', 'wtr_sht_framework' )		=> 'wtrNoAutoHeightColumns',
											__( 'Yes', 'wtr_sht_framework' )	=> 'wtrAutoHeightColumns',
										),
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_columns_autohight_class'
		);
		vc_add_param($this->base, $columns_autohight );
		array_push( $this->fields, $columns_autohight );
		vc_add_param($this->base_inner, $columns_autohight );
		array_push( $this->fields_inner, $columns_autohight );


		$menu_above = array(
				'param_name'	=> 'menu_above',
				'heading'		=> __( 'Place this row above the navigation', 'wtr_sht_framework' ),
				'description'	=> __( 'Do not use this option if on this page  transparent navigation is enabled', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'No', 'wtr_sht_framework' )		=> 'wtrNoAboveMenuRow',
											__( 'Yes', 'wtr_sht_framework' )	=> 'wtrAboveMenuRow',
										),
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_menu_above_class'
		);
		vc_add_param($this->base, $menu_above );
		array_push( $this->fields, $menu_above );

		$el_class = $this->getDefaultVCfield( 'el_class' );
		vc_add_param($this->base, $el_class );
		array_push( $this->fields, $el_class );
		vc_add_param($this->base_inner, $el_class );
		array_push( $this->fields_inner, $el_class );

		$el_id = $this->getDefaultVCfield( 'el_id' );
		vc_add_param($this->base, $el_id );
		array_push( $this->fields, $el_id );
		vc_add_param($this->base_inner, $el_id );
		array_push( $this->fields_inner, $el_id );

		$bg_type = array(
				'param_name'	=> 'bg_type',
				'heading'		=> __( 'Type section', 'wtr_sht_framework' ),
				'description'	=> '',
				'group'			=> $this->shtCardName[ 'background' ],
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Color background', 'wtr_sht_framework' )		=> 'color',
											__( 'Transparent background', 'wtr_sht_framework' )	=> 'standard',
											__( 'Image background', 'wtr_sht_framework' )		=> 'image',
											__( 'Video background', 'wtr_sht_framework' )		=> 'video',
										),
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_bg_type_class'
		);
		vc_add_param($this->base, $bg_type );
		array_push( $this->fields, $bg_type );

		//color
		$color_bg = array(
				'param_name'	=> 'color_bg',
				'heading'		=> __( 'Background color', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the color of your background', 'wtr_sht_framework' ),
				'group'			=> $this->shtCardName[ 'background' ],
				'type'			=> 'colorpicker',
				'value'			=> '#ffffff',
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_color_bg_class',
				'dependency' 	=> array(	'element'	=> 'bg_type',
											'value'		=> array( 'color' ) )
		);
		vc_add_param($this->base, $color_bg );
		array_push( $this->fields, $color_bg );

		//image
		$img = array(
				'param_name'	=> 'img',
				'heading'		=> __( 'Backgorund image', 'wtr_sht_framework' ),
				'description'	=> '',
				'group'			=> $this->shtCardName[ 'background' ],
				'type'			=> 'attach_image',
				'value'			=> '',
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_img_style',
				'dependency' 	=> array(	'element'	=> 'bg_type',
											'value'		=> array( 'image' ) )
		);
		vc_add_param($this->base, $img );
		array_push( $this->fields, $img );

		//image
		$img_attr = array(
				'param_name'	=> 'img_attr',
				'heading'		=> __( 'Backgorund image attribute', 'wtr_sht_framework' ),
				'description'	=> '',
				'group'			=> $this->shtCardName[ 'background' ],
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Default', 'wtr_sht_framework' )	=> 'default',
											__( 'Cover', 'wtr_sht_framework' )		=> 'cover',
											__( 'Contain', 'wtr_sht_framework' )	=> 'contain',
											__( 'No Repeat', 'wtr_sht_framework' )	=> 'no_repeat',
											__( 'Repeat', 'wtr_sht_framework' )		=> 'repeat',
										),
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_img_attr_style',
				'dependency' 	=> array(	'element'	=> 'bg_type',
											'value'		=> array( 'image' ) )
		);
		vc_add_param($this->base, $img_attr );
		array_push( $this->fields, $img_attr );

		$color_overlay_opt = array(
				'param_name'	=> 'color_overlay_opt',
				'heading'		=> __( 'Overlay', 'wtr_sht_framework' ),
				'description'	=> '',
				'group'			=> $this->shtCardName[ 'background' ],
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Off', 'wtr_sht_framework' )	=> 'off',
											__( 'On', 'wtr_sht_framework' )		=> 'on',
										),
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_color_overlay_opt_class',
				'dependency' 	=> array(	'element'	=> 'bg_type',
											'value'		=> array( 'image', 'video' ) )
		);
		vc_add_param($this->base, $color_overlay_opt );
		array_push( $this->fields, $color_overlay_opt );

		$color_overlay = array(
				'param_name'	=> 'color_overlay',
				'heading'		=> __( 'Overlay color', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the color of your overlay', 'wtr_sht_framework' ),
				'group'			=> $this->shtCardName[ 'background' ],
				'type'			=> 'colorpicker',
				'value'			=> 'rgba(31,206,109,0.60)',
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_color_overlay_class',
				'dependency' 	=> array(	'element'	=> 'color_overlay_opt',
											'value'		=> array( 'on' ) )
		);
		vc_add_param($this->base, $color_overlay );
		array_push( $this->fields, $color_overlay );

		$parallax = array(
				'param_name'	=> 'parallax',
				'heading'		=> __( 'Background image effect', 'wtr_sht_framework' ),
				'description'	=> '',
				'group'			=> $this->shtCardName[ 'background' ],
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'None', 'wtr_sht_framework' )				=> 'none',
											__( 'True parallax', 'wtr_sht_framework' )		=> 'true_parallax',
											__( 'Static parallax', 'wtr_sht_framework' )	=> 'static_parallax',
										),
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_parallax_class',
				'dependency' 	=> array(	'element'	=> 'img_attr',
											'value'		=> array( 'default' ) )
		);
		vc_add_param($this->base, $parallax );
		array_push( $this->fields, $parallax );

		//video
		$type_video = array(
				'param_name'	=> 'type_video',
				'heading'		=> __( 'Type of the video', 'wtr_sht_framework' ),
				'description'	=> '',
				'group'			=> $this->shtCardName[ 'background' ],
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Local video', 'wtr_sht_framework' )		=> 'local',
											__( 'Video from YouTube', 'wtr_sht_framework' )	=> 'youtube',
											__( 'Video from Vimeo', 'wtr_sht_framework' )	=> 'vimeo',
										),
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_type_video_class',
				'dependency' 	=> array(	'element'	=> 'bg_type',
											'value'		=> array( 'video' ) )
		);
		vc_add_param($this->base, $type_video );
		array_push( $this->fields, $type_video );

		$mp4 = array(
				'param_name'	=> 'mp4',
				'heading'		=> __( 'Video - MP4 file', 'wtr_sht_framework' ),
				'description'	=> __( 'Insert full url', 'wtr_sht_framework' ),
				'group'			=> $this->shtCardName[ 'background' ],
				'type'			=> 'textfield',
				'value'			=> '',
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_mp4_class',
				'dependency' 	=> array(	'element'	=> 'type_video',
											'value'		=> array( 'local' ) )
		);
		vc_add_param($this->base, $mp4 );
		array_push( $this->fields, $mp4 );

		$ogg = array(
				'param_name'	=> 'ogg',
				'heading'		=> __( 'Video - OGG file', 'wtr_sht_framework' ),
				'description'	=> __( 'Insert full url', 'wtr_sht_framework' ),
				'group'			=> $this->shtCardName[ 'background' ],
				'type'			=> 'textfield',
				'value'			=> '',
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_ogg_class',
				'dependency' 	=> array(	'element'	=> 'type_video',
											'value'		=> array( 'local' ) )
		);
		vc_add_param($this->base, $ogg );
		array_push( $this->fields, $ogg );

		$webm = array(
				'param_name'	=> 'webm',
				'heading'		=> __( 'Video - WEBM file', 'wtr_sht_framework' ),
				'description'	=> __( 'Insert full url', 'wtr_sht_framework' ),
				'group'			=> $this->shtCardName[ 'background' ],
				'type'			=> 'textfield',
				'value'			=> '',
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_webm_class',
				'dependency' 	=> array(	'element'	=> 'type_video',
											'value'		=> array( 'local' ) )
		);
		vc_add_param($this->base, $webm );
		array_push( $this->fields, $webm );

		$youtube_video = array(
				'param_name'	=> 'youtube_video',
				'heading'		=> __( 'Movie ID', 'wtr_sht_framework' ),
				'description'	=> __( 'Working example: http://www.youtube.com/watch?v=<b>G0k3kHtyoqc</b>.
										Please insert only: <b>G0k3kHtyoqc</b>', 'wtr_sht_framework' ),
				'group'			=> $this->shtCardName[ 'background' ],
				'type'			=> 'textfield',
				'value'			=> '',
				'holder'		=> 'hidden',
				'admin_label'	=> false,
				'class'			=> $this->base . '_youtube_video_class',
				'dependency'	=> array(	'element'	=> 'type_video',
											'value'		=> array( 'youtube' ) )
		);
		vc_add_param($this->base, $youtube_video );
		array_push( $this->fields, $youtube_video );

		$vimeo_video = array(
				'param_name'	=> 'vimeo_video',
				'heading'		=> __( 'Movie ID', 'wtr_sht_framework' ),
				'description'	=> __( 'Working example: http://vimeo.com/<b>75746181</b><br/>
										Please insert only: <b>75746181</b>', 'wtr_sht_framework' ),
				'group'			=> $this->shtCardName[ 'background' ],
				'type'			=> 'textfield',
				'value'			=> '',
				'holder'		=> 'hidden',
				'admin_label'	=> false,
				'class'			=> $this->base . '_vimeo_video_class',
				'dependency'	=> array(	'element'	=> 'type_video',
											'value'		=> array( 'vimeo' ) )
		);
		vc_add_param($this->base, $vimeo_video );
		array_push( $this->fields, $vimeo_video );

		$sound_video = array(
				'param_name'	=> 'sound_video',
				'heading'		=> __( 'Sound', 'wtr_sht_framework' ),
				'description'	=> '',
				'group'			=> $this->shtCardName[ 'background' ],
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Off', 'wtr_sht_framework' )	=> 'off',
											__( 'On', 'wtr_sht_framework' )		=> 'on',
										),
				'holder'		=> 'hidden',
				'admin_label'	=> false,
				'class'			=> $this->base . '_sound_video_class',
				'dependency'	=> array(	'element'	=> 'type_video',
											'value'		=> array( 'vimeo', 'youtube' ) )
		);
		vc_add_param($this->base, $sound_video );
		array_push( $this->fields, $sound_video );

		$control_video = array(
				'param_name'	=> 'control_video',
				'heading'		=> __( 'Show control video film', 'wtr_sht_framework' ),
				'description'	=> '',
				'group'			=> $this->shtCardName[ 'background' ],
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Off', 'wtr_sht_framework' )	=> 'off',
											__( 'On', 'wtr_sht_framework' )		=> 'on',
										),
				'holder'		=> 'hidden',
				'admin_label'	=> false,
				'class'			=> $this->base . '_control_video_class',
				'dependency'	=> array(	'element'	=> 'type_video',
											'value'		=> array( 'vimeo', 'youtube' ) )
		);
		vc_add_param($this->base, $control_video );
		array_push( $this->fields, $control_video );

		$mobile_img_poster = array(
				'param_name'	=> 'mobile_img_poster',
				'heading'		=> __( 'Poster', 'wtr_sht_framework' ),
				'description'	=> __( 'Displayed only on mobile devices', 'wtr_sht_framework' ),
				'group'			=> $this->shtCardName[ 'background' ],
				'type'			=> 'attach_image',
				'value'			=> '',
				'holder'		=> 'hidden',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_mobile_img_poster_class',
				'dependency' 	=> array(	'element'	=> 'bg_type',
											'value'		=> array( 'video' ) )
		);
		vc_add_param($this->base, $mobile_img_poster );
		array_push( $this->fields, $mobile_img_poster );


		// adding attributes "animation" to shortdcode
		$animate_effect = $this->shtAnimateAttrEffect( $this->shtCardName[ 'animate' ] );
		vc_add_param($this->base, $animate_effect );
		array_push( $this->fields, $animate_effect );
		vc_add_param($this->base_inner, $animate_effect );
		array_push( $this->fields_inner, $animate_effect );

		$animate_delay = $this->shtAnimateAttrDelay( $this->shtCardName[ 'animate' ] );
		vc_add_param($this->base, $animate_delay );
		array_push( $this->fields , $animate_delay );
		vc_add_param($this->base_inner, $animate_delay );
		array_push( $this->fields_inner, $animate_delay );

		// update map shortcode
		$setting = array (	'icon'			=> 'vc_wtr_row_icon',
							'description'	=> '',
							'weight'		=> 70000, );
		vc_map_update($this->base, $setting );
	}//end integrateWithVC


	public function render( $atts, $content = null, $sht ){

		$result				= '';
		$atts['content']	= wpb_js_remove_wpautop( $content, false );
		$atts				= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract( $atts );

		global $post_settings;

		if( isset( $css ) ){
			$css = explode( '{', $css );
			$css = substr( $css[ 0 ], 1 );
		}else{
			$css = '';
		}

		$css_id = ( !empty(  $el_id  ) ) ? 'id="' . $el_id . '"' : '';

		switch ( $img_attr ) {

			case 'cover':
				$img_attr_code = 'background-position: center; background-repeat: no-repeat; background-size: cover;';
			break;

			case 'contain':
				$img_attr_code = 'background-position: center; background-repeat: no-repeat; background-size: contain;';
			break;

			case 'no_repeat':
				$img_attr_code = 'background-repeat: no-repeat;';
			break;

			case 'repeat':
				$img_attr_code = 'background-repeat: repeat;';
			break;

			case 'default'	:
				if( 'true_parallax' == $parallax ){
					$img_attr_code = 'background-attachment: scroll; background-repeat: no-repeat; height: auto; position: relative; background-repeat: repeat-y; background-position: 0% 0; background-position-x: center !important; background-size: cover;';
				}else if( 'static_parallax' == $parallax ){
					$img_attr_code = 'background-position: center; background-repeat: no-repeat; background-size: cover;';
				}else if( 'none' == $parallax ){
					$img_attr_code = '';
				}
			break;
			default			:
				$img_attr_code = '';
			break;
		}

		if( 'default' != $img_attr ){
			$parallax = 'none';
		}

		if( ( 'setNone' !== $post_settings['wtr_SidebarPosition'] AND ( 'full_width_grid' == $row_type OR 'full_width' == $row_type OR 'video' == $bg_type OR 'true_parallax' == $parallax OR 'static_parallax' == $parallax ) )
			OR ( ('setNone' == $post_settings['wtr_SidebarPosition'] AND ( 'boxed' == $row_type ) ) AND ( 'video' == $bg_type OR 'true_parallax' == $parallax OR 'static_parallax' == $parallax  ) )
			){
			$result .= '<div class="wtrNoItemStream wtrShtAlertBox wtrRadius3">';
				$result .= '<h6 class="wtrNoItemStreamHeadline">';
					$result .= __( "THIS TYPE OF ROW DOESN’T WORK ON A PAGE WITH A SIDEBAR. PLEASE CHANGE THE TYPE OF ROW TO BOXED OR REMOVE THE SIDEBAR.", 'wtr_sht_framework' );
				$result .= '</h6>';
			$result .= '</div>';
			return $result;
		}

		// Full width with inner container OR Full width
		if( 'full_width_grid' == $row_type OR 'full_width' == $row_type ){

						$result .= '</div>';
					$result .= '</section>';
				$result .= '</div>';
			$result .= '</div>';

			$class_section		= ( 'full_width' == $row_type ) ? 'wtrShtFullWidthSection wtrShtFullWidthSectionNoInner' : 'wtrShtFullWidthSection';
			$class_html_attr	= 'wtrSht wtrStandardRow ' . $menu_above  . ' ' . $class_section . ' ' . $columns_autohight . ' ' . $el_class .' ' . $css;

			$result .= '<div ' . $css_id . ' ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' >';

				$style_parallax		= ( 'true_parallax' == $parallax  ) ? 'data-stellar-background-ratio="0.5"' : ( ('static_parallax' == $parallax ) ? 'data-stellar-background-ratio="0.0"' : '' );
				$innec_class		= ( 'full_width' == $row_type ) ? '' : 'wtrInner ';
				$color_overlay		= wtr_helper_hex2rgba( $color_overlay );
				$overlay_container	= ( 'on' == $color_overlay_opt ) ? '<div class="wtrShtBgOverlay" style="background-color: ' . esc_attr( $color_overlay ) . '"></div>' : '';

				if( 'video' == $bg_type ){
					$image_attributes	= wp_get_attachment_image_src( $mobile_img_poster, 'full' );
					$image_poster		= ( $image_attributes[0] ) ? $image_attributes[0] : '';
					$mobile_poster		= ( $image_poster ) ? 'data-posterm="' . $image_poster . '"' : 'data-posterm=""';

					if( 'local' == $type_video ){
						$result .= '<div class="wtrShtBgVideo" ' . $mobile_poster . '>';
							$result .= '<div class="wtrShtBgVideoContainer" >';
								$result .= $overlay_container;
								$result .= '<video class="wtrShtBgVideoElement" preload="auto" autoplay="autoplay" loop muted>';
									$result .= '<!-- MP4 must be first for iPad! --> <!-- Safari / iOS video    -->';
									$result .= '<source src="' . $mp4 . '" type="video/mp4" />';
									$result .= '<!-- Firefox / Opera / Chrome10 -->';
									$result .= '<source src="' . $ogg . '" type="video/ogg" />';
									$result .= '<source src="' . $webm . '" type="video/webm" />';
									$result .= '<!-- fallback to Flash: -->';
									$result .= '<object width="" height="" type="application/x-shockwave-flash" data="__FLASH__.SWF">';
										$result .= '<!-- Firefox uses the `data` attribute above, IE/Safari uses the param below -->';
										$result .= '<param name="movie" value="__FLASH__.SWF" />';
										$result .= '<param name="flashvars" value="controlbar=over&amp;image=img/1.jpg&amp;file=__VIDEO__.MP4" />';
										$result .= '<!-- fallback image. note the title field below, put the title of the video there -->';
									$result .= '</object>';
								$result .= '</video>';
							$result .= '</div>';
					} else if( 'youtube' == $type_video ) {

						$result .= '<div class="wtrShtFullWidthVideoStream wtrShtFullWidthYouTubeSection" ' . $mobile_poster . '>';
							$result .= $overlay_container;

							$result .= '<div class="wtrVideoBgContainer">';
								$result .= '<div class="wtrVideoSizeContener"></div>';
								$result .= '<div class="wtrVideoYoutubeContener">';
									$result .= '<div id="wtr-row-yt-player-' . self::$yt_player . '" data-sound="' . esc_attr( $sound_video ) . '" data-video="' . esc_attr( $youtube_video ) . '" class="wtrRowYTPlayer"></div>';
								$result .= '</div>';
							$result .= '</div>';

						if( 'on' == $control_video ){
							$result .= '<div id="wtr-row-yt-player-' . self::$yt_player . '-play" class="wtrFWVytPlay"><i class="fa fa-play"></i></div>';
							$result .= '<div id="wtr-row-yt-player-' . self::$yt_player . '-pause" class="wtrFWVytPause"><i class="fa fa-pause"></i></div>';
						}

						self::$yt_player++;

					}else if( 'vimeo' == $type_video ) {

						$result .= '<div class="wtrShtFullWidthVideoStream wtrShtFullWidthVimeoSection " ' . $mobile_poster . '>';
							$result .= '<div class="wtrVideoBgContainer">';
								$result .= $overlay_container;
								$result .= '<div class="wtrVideoSizeContener"></div>';
								$result .= '<div class="wtrVideoVimeContener">';
									$result .= '<iframe id="wtr-row-vimeo-player-' . self::$vimeo_player . '" class="wtrRowVimeoPlayer" data-sound="' . esc_attr( $sound_video ) . '" src="http://player.vimeo.com/video/' . esc_attr( $vimeo_video ) . '?loop=1" width="500" height="300" allowfullscreen></iframe>';
								$result .= '</div>';
							$result .= '</div>';

						if( 'on' == $control_video ){
							$result .= '<div id="wtr-row-vimeo-player-' . self::$vimeo_player . '-play" class="wtrFWVVimeoPlay"><i class="fa fa-play"></i></div>';
							$result .= '<div id="wtr-row-vimeo-player-' . self::$vimeo_player . '-pause" class="wtrFWVVimeoPause"><i class="fa fa-pause"></i></div>';
						}

						self::$vimeo_player++;
					}
				} else if( 'image' == $bg_type ) {

					$image_attributes	= wp_get_attachment_image_src( $img, 'full' );
					$image				= ( $image_attributes[0] ) ? $image_attributes[0] : '';
					$style				= ( $image ) ? 'style="background:url(' . $image . '); ' . $img_attr_code . '"' : '';

					$result .= '<div class="wtrSht wtrShtImageBg" ' . $style . ' ' . $style_parallax . ' >';
					$result .= $overlay_container;
				} else if( 'color' == $bg_type ) {
					$result .= '<div class="wtrContainer wtrContainerColor wtrPost wtrPage" style="background-color: ' . esc_attr( $color_bg ) . '">';
				} else {
					$result .= '<div class="wtrSht" >';
				}

					$result .= '<div class="' . $innec_class .' clearfix">';
						$result .= '<div class="wtrPageContent vcRow ' . esc_attr( $columns_type ) . ' clearfix">';
							$result .= $content;
						$result .= '</div>';
					$result .= '</div>';
				$result .= '</div>';
			$result .= '</div>';

			$result .= '<div class="wtrContainer wtrContainerColor wtrPost wtrPage">';
				$result .= '<div class="wtrInner clearfix">';
					$result .= '<section class="wtrContentCol ' . $post_settings['wtr_ContentInClass']['content'] .' clearfix">';
						$result .= '<div class="wtrPageContent clearfix">';
		//Boxed
		} else {

			$style				= '';
			$class				= '';
			$overlay_container	= '';

			if( 'image' == $bg_type ) {
				$image_attributes	= wp_get_attachment_image_src( $img, 'full' );
				$image				= ( $image_attributes[0] ) ? $image_attributes[0] : '';
				$style				= ( $image ) ? 'style="background:url(' . $image . '); ' . $img_attr_code . '"' : '';
				$color_overlay		= wtr_helper_hex2rgba( $color_overlay );
				$overlay_container	= ( 'on' == $color_overlay_opt ) ? '<div class="wtrShtBgOverlay" style="background-color: ' . esc_attr( $color_overlay ) . '"></div>' : '';
				$class				= 'wtrShtImageBg';

			} else if( 'color' == $bg_type ) {
				$style				= 'style="background-color: ' . esc_attr( $color_bg ) . ';"';
			}

			$class_html_attr = 'wtrSht wtrStandardRow wtrShtBoxedWidth ' . $menu_above  . ' ' . $columns_autohight . ' ' . $el_class .' ' . $css;

			$result .= '<div ' . $css_id . ' ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' >';
				$result .= '<div class="wtrSht ' . $class . '" ' . $style . ' >';
					$result .= $overlay_container;
					$result .= '<div class="wtrPageContent vcRow ' . esc_attr( $columns_type ) . ' clearfix">';
							$result .= $content;
					$result .= '</div>';
				$result .= '</div>';
			$result .= '</div>';

		}
		return $result;
	}//end render

	public function render_inner( $atts, $content = null, $sht ){
		$result				= '';
		$atts['content']	= wpb_js_remove_wpautop( $content, false );
		$atts				= $this->prepareCorrectShortcode( $this->fields_inner, $atts );
		extract( $atts );

		if( isset( $css ) ){
			$css = explode( '{', $css );
			$css = substr( $css[ 0 ], 1 );
		}else{
			$css = '';
		}

		$class_html_attr = 'wtrSht wtrRowInner ' . $columns_autohight . ' ' . $columns_type . ' ' . $el_class. ' ' . $css;

		$result .= '<div ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' >';
			$result .= '<div class="wtrPageContent vcRow clearfix">';
					$result .= $content;
			$result .= '</div>';
		$result .= '</div>';

		return $result;
	}//end render_inner

}//end VCExtendAddonRow

new VCExtendAddonRow();