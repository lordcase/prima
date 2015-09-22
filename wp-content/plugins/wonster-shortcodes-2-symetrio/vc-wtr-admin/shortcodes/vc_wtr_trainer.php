<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

if ( !defined( 'WTR_CP_PLUGIN_MAIN_FILE' ) ) { return; }

include_once ( 'vc_wtr.php' );

class VCExtendAddonTrainer extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_trainer';
	public $fields	= array();

	//===FUNCTIONS
	public function __construct(){

		parent::__construct();

		// We safely integrate with VC with this hook
		add_action( 'init', array( &$this, 'integrateWithVC' ) );

		//Creating a shortcode addon
		add_shortcode( $this->base, array( &$this, 'render' ) );
	}//end __construct


	protected function generateListTrainer(){

		$args = array(
			'post_type'				=> 'trainer',
			'posts_per_page'		=> -1,
			'ignore_sticky_posts'	=> 1,
			'fields'				=> 'ids'
		);

		// The Query
		$posts	= get_posts( $args );
		$result	= array( __( 'Select item', 'wtr_sht_framework' ) => 'wtr_select_item' );


		if ( ! empty( $posts ) ){
			foreach ( $posts as $post ) {

				$nameTrainer	= get_post_meta( $post, '_wtr_trainer_name', true );
				$surnameTrainer	= get_post_meta( $post, '_wtr_trainer_last_name', true );

				if( $nameTrainer || $surnameTrainer ){
					$index = trim( $nameTrainer . ' ' . $surnameTrainer );
				}
				else{
					$index = __( 'no title', 'wtr_sht_framework' );
				}

				$result[ ' ' . $index . ' ' ] = $post;
			}
		}

		if( !count( $result ) ) {
			$result = array( __( 'There is no trainer to choose from', 'wtr_sht_framework' ) => 'NN' );
		}

		return $result;
	}//end generateListTrainer


	public function integrateWithVC(){
		// Map fields

		$this->fields = array(

			array(
				'param_name'	=> 'style',
				'heading'		=> __( 'Presentation style', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Blur background', 'wtr_sht_framework' )	=> 'blur',
											__( 'Square list ', 'wtr_sht_framework' )		=> 'square',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_style_class',
			),

			array(
				'param_name'	=> 'id_trainer',
				'heading'		=> __( 'Trainer', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> $this->generateListTrainer(),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_trainer_class',
			),

			array(
				'param_name'	=> 'link',
				'heading'		=> __( 'Trainer detail link', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Yes', 'wtr_sht_framework' )	=> 'yes',
											__( 'No', 'wtr_sht_framework' )		=> 'no',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_link_class',
			),

			$this->getDefaultVCfield( 'el_class' ),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );

		vc_map( array(
			'name'			=> __( 'Trainer', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'elements' ],
			'params'		=> $this->fields,
			'weight'		=> 14000,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result	='';
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract($atts);

		if( 'wtr_select_item' == $id_trainer ){
			return $this->draw_alert_info_wrong_data_id_sht( 'trainer' );
		}

		global $post_settings, $wtr_social_media;


		$post = get_post( $id_trainer );
		if( empty( $post ) ){
			return ;
		}

		$url				= esc_url( get_permalink( $id_trainer ) );
		$name				= get_post_meta( $id_trainer, '_wtr_trainer_name', true);
		$last_name			= get_post_meta( $id_trainer, '_wtr_trainer_last_name', true);
		$post_thumbnail_id	= get_post_thumbnail_id( $id_trainer );
		$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_2' );
		$image_alt			= esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) );
		$image				= ( $image_attributes[ 0 ] ) ? $image_attributes[ 0 ] : $post_settings['wtr_DefalutThumbnail'] ;
		$image_blur			= get_post_meta( $id_trainer, '_wtr_trainer_img_sht', true);
		$image_blur_alt		= esc_attr( get_post_meta( $image_blur, '_wp_attachment_image_alt', true ) );
		$image_blur			= wp_get_attachment_image_src( $image_blur, 'size_2' );
		$image_blur			= ( $image_blur[0] ) ? '<img class="wtrCrewItemBackground wtrRadius3" alt="' . $image_blur_alt . '" src="' . $image_blur[0] . '">' : '' ;
		$functions			= get_the_terms( $id_trainer, 'trainer-function' );
		$functionsAll		= array();


		if( $functions ){
			foreach ( (array) $functions as $function ) {
				$functionsAll[] = $function->name;
			}
		}
		$functionsAllstr	= implode( $functionsAll, ', ' );

		if( 'yes' == $link ){
			$link_start		= '<a href="' . $url . '">';
			$link_end		= '</a>';
		}

		if( 'square' == $style ){

			$class_html_attr = 'wtrShtTrainerStream wtrOneCol ' . $el_class . ' clearfix';

			$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' >';
				$result .= '<div class="wtrSht wtrShtTrainer">';
					$result .= '<div class="wtrShtTrainerData">';
						if( 'yes' == $link ){
							$result .= '<a href="' . $url . '" class="wtrShtTrainerElements wtrShtTrainerAnimateSec"></a>';
						}
						$result .= '<span class="wtrShtTrainerOverlay wtrShtTrainerAnimate wtrRadius3"></span>';
						$result .= '<img src="' . $image . '" alt="' . $image_alt . '">';
					$result .= '</div>';
					$result .= '<div class="wtrShtTrainerMeta ">';
						$result .= '<div class="wtrShtTrainerMetaName wtrShtTrainerAnimate">';
							$result .= '<h5 class="wtrShtTrainerMetaNameHeadline wtrShtTrainerAnimate">' . $name . '</h5>';
							$result .= '<h5 class="wtrShtTrainerMetaNameSubline wtrShtTrainerAnimate">' . $last_name . '</h5>';
							$result .= '<div class="wtrShtTrainerMetaPositionName wtrShtTrainerAnimate">' . $functionsAllstr . '</div>';
						$result .= '</div>';
					$result .= '</div>';
				$result .= '</div>';
			$result .= '</div>';

		}else if( 'blur' == $style  ) {

			$link_start			= '';
			$link_end			= '';

			if( 'yes' == $link ){
				$link_start		= '<a href="' . $url . '">';
				$link_end		= '</a>';
			}

			$class_html_attr = 'wtrShtCrewStream wtrOneCol ' . $el_class . ' clearfix';

			$result .= '<div ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' >';
				$result .= '<div class="wtrSht wtrCrewItem">';
					$result .= '<div class="wtrCrewItemContainer">';
						$result .= $link_start;
							$result .= '<span class="wtrCrewItemPictureContainer wtrCrewAnimationSec">';
								$result .= '<img src="' . $image . '" class="wtrCrewItemPicture " alt="' . $image_alt . '">';
							$result .= '</span>';
							$result .= '<span class="wtrCrewItemName wtrCrewAnimation">' . $name . ' ' . $last_name . '</span>';
							$result .= '<span class="wtrCrewItemPosition wtrCrewAnimation">' . $functionsAllstr . '</span>';
						$result .= $link_end;
						$result .= '<ul class="wtrCrewItemSocials wtrCrewAnimation">';
							foreach ( $wtr_social_media as $key => $value) {
								$social_key		= strtolower( '_wtr_' . str_replace( 'wtr_SocialMedia', '', $key ) );
								$social_value	= get_post_meta( $id_trainer, $social_key, true );
								if( ! empty( $social_value ) ){
									$result .= '<li>';
										$result .= '<a target="_blank" href="' . esc_url( $social_value ) . '" class="wtrAnimate">';
											$result .= '<i class="' . $value['icon'] .'"></i>';
										$result .= '</a>';
									$result .= '</li>';
								}
							}
						$result .= '</ul>';
						$result .= '<span class="wtrShtCrewOverlay wtrCrewAnimation wtrRadius3"></span>';
						$result .= $image_blur;
					$result .= '</div>';
				$result .= '</div>';
			$result .= '</div>';
		}
		wp_reset_postdata();
		return $result;
	}//end Render

}//end VCExtendAddonTrainer

new VCExtendAddonTrainer();