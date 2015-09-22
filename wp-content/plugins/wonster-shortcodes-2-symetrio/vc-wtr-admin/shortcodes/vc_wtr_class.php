<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

if ( !defined( 'WTR_CP_PLUGIN_MAIN_FILE' ) ) { return; }

include_once ( 'vc_wtr.php' );

class VCExtendAddonClass extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_class';
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
				'param_name'	=> 'style',
				'heading'		=> __( 'Presentation style', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Standard', 'wtr_sht_framework' )		=> 'standard',
											__( 'Metro left', 'wtr_sht_framework' )		=> 'metro_left',
											__( 'Metro right', 'wtr_sht_framework' )	=> 'metro_right',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_style_class',
			),

			array(
				'param_name'	=> 'id_class',
				'heading'		=> __( 'Class', 'wtr_sht_framework' ),
				'description'	=> __( 'Select a class to be attached to content', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> $this->getWpQuery( array(
										'post_type'			=> 'classes',
										'wtr_add_all_item'	=> false,
										'wtr_select_item'	=> true
									) ),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_id_class_class',
			),

			array(
				'param_name'	=> 'show_level',
				'heading'		=> __( 'Hide the difficulty of the classes', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'No', 'wtr_sht_framework' )		=> 'no',
											__( 'Yes', 'wtr_sht_framework' )	=> 'yes'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_show_level',
			),

			$this->getDefaultVCfield( 'el_class' ),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );


		vc_map( array(
			'name'			=> __( 'Class', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'elements' ],
			'params'		=> $this->fields,
			'weight'		=> 37000,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){

		$result	='';
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract($atts);

		if( 'wtr_select_item' == $id_class ){
			return $this->draw_alert_info_wrong_data_id_sht( 'class' );
		}

		global $post_settings;


		$post = get_post( $id_class );
		if( empty( $post ) ){
			return ;
		}

		$excerpt			= apply_filters( 'get_the_excerpt', $post->post_excerpt );
		$title				= get_the_title( $id_class );
		$url				= esc_url( get_permalink( $id_class ) );
		$lvl				= get_post_meta( $id_class, '_wtr_classes_lvl', true );
		$duration			= get_post_meta( $id_class, '_wtr_classes_duration', true );
		$post_thumbnail_id	= get_post_thumbnail_id( $id_class );
		$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_2' );
		$image_alt			= esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) );
		$image				= ( $image_attributes[0] ) ? $image_attributes[0] : $post_settings['wtr_DefalutThumbnail'] ;

		if( 'standard' == $style ){

			$class_html_attr = 'wtrShtClassesStream wtrOneCol ' . $el_class . ' clearfix';

			$result .= '<div ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' >';
				$result .= '<div class="wtrSht wtrShtClasses">';
					$result .= '<div class="wtrShtClassesData">';
						$result .= '<div class="wtrShtClassesMeta ">';
							$result .= '<div class="wtrShtClassesMetaNames wtrShtTrainerAnimate">';
								$result .= '<h5 class="wtrShtClassesMetaHeadline wtrShtTrainerAnimate">';
									$result .= '<a href="' . $url . '" class="wtrClassHeadNameJs">' . $title . '</a>';
								$result .= '</h5>';
								$result .= '<div class="wtrShtClassesMetaTime wtrShtTrainerAnimate"><i class="fa fa-clock-o"></i> ' . $duration . ' ' . $post_settings['wtr_TranslateClassesSHTMinutes'] . '</div>';
							$result .= '</div>';
						$result .= '</div>';
						$result .= '<a href="' . $url . '" class="wtrShtClassesElements wtrShtClassesAnimate">';
							$result .= '<i class="fa fa-share wtrShtClassesArrow wtrShtClassesAnimate"></i>';

							if( 'no' == $show_level ){
								$result .= '<ul class="wtrShtBoxedClassesSkill wtrRadius100 clearfix">';
									$result .= wtr_helper_classes_skill_dot( $lvl );
								$result .= '</ul>';
							}

						$result .= '</a>';
						$result .= '<span class="wtrShtTrainerOverlay wtrShtTrainerAnimate wtrRadius3"></span>';
						$result .= '<img src="' . $image . '" class="wtrRadius3" alt="' . $image_alt . '">';
					$result .= '</div>';
				$result .= '</div>';
			$result .= '</div>';

		} else {

			if( 'no' == $show_level ){
				$hide_diff = '';
			}else{
				$hide_diff = 'wtrNoDetailsClass';
			}

			$class_row			= ( 'metro_left' == $style ) ? 'wtrShtOrderChange' : '';
			$class_html_attr	= 'wtrSht wtrOneElementSht wtrShtBoxedClasses ' . $class_row . ' ' . $el_class . ' clearfix';

			$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' >';
				$result .= '<div class="wtrShtBoxedClassesSpace wtrShtBoxedClassesCoOneHalf ' . $hide_diff . ' clearfix">';
					$result .= '<div class="wtrShtBoxedClassesColOne clearfix">';
						$result .= '<a href="' . $url . '" class="wtrShtBoxedClassesColTwo wtrShtBoxedClassesImgContainer">';
							$result .= '<span class="wtrShtBoxedClassesElements wtrShtBoxedClassesAnimate"></span>';
							$result .= '<span class="wtrShtBoxedClassesOverlay wtrShtBoxedClassesAnimate"></span>';
							$result .= '<span></span>';
							$result .= '<img src="' . $image . '" alt="' . $image_alt . '">';
						$result .= '</a>';
						$result .= '<div class="wtrShtBoxedClassesColTwoSec">';
							$result .= '<div class="wtrShtBoxedClassesContainer">';
							$result .= '<h3 class="wtrShtBoxedClassesHeadline">';
								$result .= '<a href="' . $url . '" class="wtrClassHeadNameJs">' . $title . '</a>';
							$result .= '</h3>';
							$result .= '<div class="wtrShtBoxedClassesInfo clearfix">';

								if( 'no' == $show_level ){
									$result .= '<ul class="wtrShtBoxedClassesSkill clearfix wtrRadius100">';
										$result .= wtr_helper_classes_skill_dot( $lvl );
									$result .= '</ul>';
								}

								$result .= '<span class="wtrShtBoxedClassesTime wtrShtBoxedClassesAnimate">';
									$result .= '<i class="fa fa-clock-o"></i> ' . $duration . ' ' . $post_settings['wtr_TranslateClassesSHTMinutes'];
								$result .= '</span>';
							$result .= '</div>';
							$result .= '<p class="wtrShtBoxedClassesDesc">' . wtr_excerpt( null, $excerpt ) . '</p>';
							$result .= '</div>';
						$result .= '</div>';
					$result .= '</div>';
				$result .= '</div>';
			$result .= '</div>';
		}
		wp_reset_postdata();
		return $result;
	}//end Render

}//end VCExtendAddonClass

new VCExtendAddonClass();