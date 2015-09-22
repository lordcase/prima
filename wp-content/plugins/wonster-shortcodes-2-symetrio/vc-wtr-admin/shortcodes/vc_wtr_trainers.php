<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

if ( !defined( 'WTR_CP_PLUGIN_MAIN_FILE' ) ) { return; }

include_once ( 'vc_wtr.php' );

class VCExtendAddonTrainers extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_trainers';
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
				'value'			=> array(	__( 'Blur background', 'wtr_sht_framework' )	=> 'blur',
											__( 'Square list ', 'wtr_sht_framework' )		=> 'square',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_style_class',
			),

			array(
				'param_name'	=> 'gym_location',
				'heading'		=> __( 'Gym locations', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'wtr_multi_select',
				'value'			=> $this->getWpQuery( array( 'post_type' => 'gym_location' ) ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_gym_location_class',
			),

			array(
				'param_name'	=> 'specializations',
				'heading'		=> __( 'Trainers specializations', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'wtr_multi_select',
				'value'			=> $this->getTermsData( 'trainer-specialization' ),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_specializations_class',
			),

			array(
				'param_name'	=> 'functions',
				'heading'		=> __( 'Trainers functions', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'wtr_multi_select',
				'value'			=> $this->getTermsData( 'trainer-function' ),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_functions_class',
			),

			array(
				'param_name'	=> 'order',
				'heading'		=> __( 'Order by', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify in which order selected rooms should be displayed', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Order value (ascending)', 'wtr_sht_framework' )	=> 'order_asc',
											__( 'Order value (descending)', 'wtr_sht_framework' )	=> 'order_desc',
											__( 'Name (ascending)', 'wtr_sht_framework' )			=> 'name_asc',
											__( 'Name (descending)', 'wtr_sht_framework' )			=> 'name_desc',
											__( 'Last name (ascending)', 'wtr_sht_framework' )		=> 'last_name_asc',
											__( 'Last name (descending)', 'wtr_sht_framework' )		=> 'last_name_desc',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_order_class',
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

			array(
				'param_name'	=> 'item_rows',
				'heading'		=> __( 'Specify number of items in a row', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'One', 'wtr_sht_framework' )	=> '1',
											__( 'Two', 'wtr_sht_framework' )	=> '2',
											__( 'Three', 'wtr_sht_framework' )	=> '3',
											__( 'Four', 'wtr_sht_framework' )	=> '4',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_item_rows_class',
			),

			array(
				'param_name'	=> 'limit',
				'heading'		=> __( 'Item limit', 'wtr_sht_framework' ),
				'description'	=> __( '<b>Please, use only numeric signs</b>', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '4',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_limit_class',
			),

			$this->getDefaultVCfield( 'el_class' ),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );

		vc_map( array(
			'name'			=> __( 'Trainers', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'elements' ],
			'params'		=> $this->fields,
			'weight'		=> 13000,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result	='';
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract($atts);

		global $post_settings, $wtr_social_media;

		$i						= 1;
		$tax_query				= null;
		$meta_query				= null;
		$meta_key				= null;
		$query_gym_location		= ( 'wtr_all_items' == $gym_location ) ? '' :explode(',', $gym_location );
		$query_functions		= ( 'wtr_all_items' == $functions ) ? '' :explode(',', $functions );
		$query_specializations	= ( 'wtr_all_items' == $specializations ) ? '' :explode(',', $specializations );

		if( $query_specializations ){
			$tax_query[]	=  array(
					'taxonomy' 			=> 'trainer-specialization',
					'field' 			=> 'slug',
					'terms' 			=> $query_specializations,
					'include_children' 	=> false
				);
		}

		if( $query_functions ){
			$tax_query[]	=  array(
					'taxonomy' 			=> 'trainer-function',
					'field' 			=> 'slug',
					'terms' 			=> $query_functions,
					'include_children' 	=> false
				);
		}

		if( $query_gym_location ){
			$meta_query[]	=array(
				'key'				=> '_wtr_gym_location',
				'value'				=> $query_gym_location,
				'compare'			=> 'IN',
			);
		}

		switch ( $order ) {

			case 'order_desc':
			default:
				$query_orderby	= 'menu_order';
				$query_order	= 'DESC';
				break;

			case 'order_asc':
				$query_orderby	= 'menu_order';
				$query_order	= 'ASC';
				break;

			case 'name_asc':
				$query_orderby	= 'meta_value';
				$meta_key		= '_wtr_trainer_name';
				$query_order	= 'ASC';
				break;

			case 'name_desc':
				$query_orderby	= 'meta_value';
				$meta_key		= '_wtr_trainer_name';
				$query_order	= 'DESC';
				break;

			case 'last_name_asc':
				$query_orderby	= 'meta_value';
				$meta_key		= '_wtr_trainer_last_name';
				$query_order	= 'ASC';
				break;

			case 'last_name_desc':
				$query_orderby	= 'meta_value';
				$meta_key		= '_wtr_trainer_last_name';
				$query_order	= 'DESC';
				break;
		}

		$query_args		= array(
			'post_type' 		=> 'trainer',
			'posts_per_page'	=> $limit,
			'orderby'			=> $query_orderby,
			'order'				=> $query_order,
			'tax_query' 		=> $tax_query,
			'meta_query'		=> $meta_query,
			'meta_key'			=> $meta_key
		);

		// The Query
		$the_query = new WP_Query( $query_args );

		if ( $the_query->have_posts() ) {

			if( 'square' == $style ){

				while ( $the_query->have_posts() ) {
					$the_query->the_post();

					$id					= get_the_id();
					$url				= esc_url( get_permalink() );
					$name				= get_post_meta( $id, '_wtr_trainer_name', true);
					$last_name			= get_post_meta( $id, '_wtr_trainer_last_name', true);
					$post_thumbnail_id	= get_post_thumbnail_id( $id );
					$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_2' );
					$image_alt			= esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) );
					$image				= ( $image_attributes[0] ) ? $image_attributes[0] : $post_settings['wtr_DefalutThumbnail'] ;
					$class_row			= ( 1 == $item_rows ) ? 'wtrOneCol' : ( ( 2 == $item_rows ) ? 'wtrTwoCols' : ( ( 3 == $item_rows ) ? 'wtrThreeCols' : ( ( 4 == $item_rows ) ? 'wtrFourCols' :'' ) ) );
					$class_item			= ( $item_rows == $i ) ? 'wtrShtTrainerLastInRow' : '';
					$functions			= get_the_terms( get_the_id(), 'trainer-function' );
					$functionsAll		= array();

					if( $functions ){
						foreach ( (array) $functions as $function ) {
							$functionsAll[] = $function->name;
						}
					}
					$functionsAllstr = implode( $functionsAll, ', ' );

					if( $i == 1 ){
						$class_html_attr = 'wtrShtTrainerStream ' . $class_row . ' ' . $el_class . ' clearfix';
						$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . '>';
					}
					$i++;

					$result .= '<div class="wtrSht wtrShtTrainer ' . $class_item . '">';
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


					if( $item_rows <  $i ){
						$result .= '</div>';
						$i = 1;
					}
				}

				if( $i != 1 ) {
					$result .= '</div>';
				}

			}else if( 'blur' == $style  ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();

					$id					= get_the_id();
					$url				= esc_url( get_permalink() );
					$name				= get_post_meta( $id, '_wtr_trainer_name', true);
					$last_name			= get_post_meta( $id, '_wtr_trainer_last_name', true);
					$post_thumbnail_id	= get_post_thumbnail_id( $id );
					$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_2' );
					$image_alt			= esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) );
					$image				= ( $image_attributes[0] ) ? '<img src="' . $image_attributes[0] . '" class="wtrCrewItemPicture " alt="' . $image_alt . '">' : '' ;
					$image_blur			= get_post_meta( $id, '_wtr_trainer_img_sht', true);
					$image_blur_alt		= esc_attr( get_post_meta( $image_blur, '_wp_attachment_image_alt', true ) );
					$image_blur			= wp_get_attachment_image_src( $image_blur, 'size_2' );
					$image_blur			= ( $image_blur[0] ) ? '<img class="wtrCrewItemBackground wtrRadius3" alt="' . $image_blur_alt . '" src="' . $image_blur[0] . '">' : '' ;
					$class_row			= ( 1 == $item_rows ) ? 'wtrOneCol' : ( ( 2 == $item_rows ) ? 'wtrTwoCols' : ( ( 3 == $item_rows ) ? 'wtrThreeCols' : ( ( 4 == $item_rows ) ? 'wtrFourCols' :'' ) ) );
					$class_item			= ( $item_rows == $i ) ? 'wtrCrewItemLastInRow' : '';
					$functions			= get_the_terms( get_the_id(), 'trainer-function' );
					$functionsAll		= array();
					$link_start			= '';
					$link_end			= '';

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


					if( $i == 1 ){
						$class_html_attr = 'wtrShtCrewStream ' . $class_row . ' ' . $el_class . ' clearfix';
						$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' >';
					}
					$i++;

					$result .= '<div class="wtrSht wtrCrewItem ' . $class_item . '">';
						$result .= '<div class="wtrCrewItemContainer">';
							$result .= $link_start;
								$result .= '<span class="wtrCrewItemPictureContainer wtrCrewAnimationSec">';
									$result .= $image;
								$result .= '</span>';
								$result .= '<span class="wtrCrewItemName wtrCrewAnimation">' . $name . ' ' . $last_name . '</span>';
								$result .= '<span class="wtrCrewItemPosition wtrCrewAnimation">' . $functionsAllstr . '</span>';
							$result .= $link_end;
							$result .= '<ul class="wtrCrewItemSocials wtrCrewAnimation">';
								foreach ( $wtr_social_media as $key => $value) {
									$social_key		= strtolower( '_wtr_' . str_replace( 'wtr_SocialMedia', '', $key ) );
									$social_value	= get_post_meta( $id, $social_key, true );
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


					if( $item_rows <  $i ){
						$result .= '</div>';
						$i = 1;
					}
				}

				if( $i != 1 ) {
					$result .= '</div>';
				}
			}

		}
		wp_reset_postdata();
		return $result;
	}//end Render

}//end VCExtendAddonTrainers

new VCExtendAddonTrainers();