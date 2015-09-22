<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

if ( !defined( 'WTR_CP_PLUGIN_MAIN_FILE' ) ) { return; }

include_once ( 'vc_wtr.php' );

class VCExtendAddonClasses extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_classes';
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
		$result	= array( __( 'Include all', 'wtr_sht_framework' ) => 'wtr_all_items' );

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
				'param_name'	=> 'alert_excerpt',
				'heading'		=> '',
				'description'	=> '',
				'type'			=> 'wtr_alert',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_alert_excerpt_class',
				'wtr_attr'		=> array(	'extra_class'	=> '',
											'message'		=> __( '<b>Important!</b> When viewing this element, fields
																	<b>"description of classes"</b> include the information
																	entered in the <b>"excerpt"</b> for each of the classes',
																	'wtr_sht_framework' )
										 ),
			),

			array(
				'param_name'	=> 'alert',
				'heading'		=> '',
				'description'	=> '',
				'type'			=> 'wtr_alert',
				'value'			=> '',
				'wtr_attr'		=> array(
										'message' => __( '<b>Important!</b> This element  may be used in a page
															<b>only in column 1/1</b>', 'wtr_sht_framework' ),
									),
				'admin_label'	=> false,
				'class'			=> $this->base . '_alert_class',
				'dependency' 	=> array(	'element'	=> 'style',
											'value'		=> array( 'metro' ) )
			),

			array(
				'param_name'	=> 'style',
				'heading'		=> __( 'Presentation style', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Standard', 'wtr_sht_framework' )	=> 'standard',
											__( 'Metro', 'wtr_sht_framework' )		=> 'metro',
											__( 'List', 'wtr_sht_framework' )		=> 'list',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_style_class',
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
				'class'			=> $this->base . '_items_class',
				'dependency' 	=> array(	'element'	=> 'style',
											'value'		=> array( 'standard' ) )
			),

			array(
				'param_name'	=> 'gym_location',
				'heading'		=> __( 'Gym locations', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'wtr_multi_select',
				'value'			=> $this->getWpQuery( array( 'post_type' => 'gym_location' ) ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_gym_location_class',
				'wtr_attr'		=> array( 'size' => 3 ),
			),

			array(
				'param_name'	=> 'category',
				'heading'		=> __( 'Include categories of classes', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the category of the classes', 'wtr_sht_framework' ),
				'type'			=> 'wtr_multi_select',
				'value'			=> $this->getTermsData( 'classes-category' ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_category_class',
				'wtr_attr'		=> array( 'size' => 6 ),
			),

			array(
				'param_name'	=> 'trainers',
				'heading'		=> __( 'Filter by trainer', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'wtr_multi_select',
				'value'			=> $this->generateListTrainer(),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_trainers_class',
				'wtr_attr'		=> array( 'size' => 6 ),
			),

			array(
				'param_name'	=> 'order',
				'heading'		=> __( 'Order by', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify in which order selected rooms should be displayed', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Date added (ascending)', 'wtr_sht_framework' )		=> 'data_add_asc',
											__( 'Date added (descending)', 'wtr_sht_framework' )	=> 'data_add_desc',
											__( 'Order value (ascending)', 'wtr_sht_framework' )	=> 'order_asc',
											__( 'Order value (descending)', 'wtr_sht_framework' )	=> 'order_desc',
											__( 'Title (ascending)', 'wtr_sht_framework' )			=> 'title_asc',
											__( 'Title (descending)', 'wtr_sht_framework' )			=> 'title_desc',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_order_class',
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
			'name'			=> __( 'Classes', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'elements' ],
			'params'		=> $this->fields,
			'weight'		=> 36000,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){

		$result	='';
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract($atts);

		global $post_settings;

		$i						= 1;
		$tax_query				= null;
		$meta_query				= null;
		$query_gym_location		= ( 'wtr_all_items' == $gym_location ) ? '' :explode(',', $gym_location );
		$query_category			= ( 'wtr_all_items' == $category ) ? '' :explode(',', $category );
		$query_trainers			= ( 'wtr_all_items' == $trainers ) ? '' : explode(',', $trainers );

		if( $query_category ){
			$tax_query[]	=  array(
				'taxonomy'			=> 'classes-category',
				'field'				=> 'slug',
				'terms'				=> $query_category,
				'include_children'	=> false
			);
		}

		if( $query_gym_location ){
			$meta_query[]	=array(
				'key'				=> '_wtr_gym_location',
				'value'				=> $query_gym_location,
				'compare'			=> 'IN',
			);
		}

		if( $query_trainers ){
				$meta_query[]	=array(
				'key'				=> '_wtr_trainers',
				'value'				=> $query_trainers,
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

			case 'data_add_desc':
				$query_orderby	= 'date';
				$query_order	= 'DESC';
				break;

			case 'data_add_asc':
				$query_orderby	= 'date';
				$query_order	= 'ASC';
				break;
			case 'title_desc':
				$query_orderby	= 'title';
				$query_order	= 'DESC';
				break;

			case 'title_asc':
				$query_orderby	= 'title';
				$query_order	= 'ASC';
				break;
		}
		$query_args		= array(
			'post_type' 		=> 'classes',
			'posts_per_page'	=> $limit,
			'tax_query' 		=> $tax_query,
			'meta_query'		=> $meta_query,
			'orderby'			=> $query_orderby,
			'order'				=> $query_order,

		);

		// The Query
		$the_query = new WP_Query( $query_args );

		if( 'no' == $show_level ){
			$hide_diff = '';
		}else{
			$hide_diff = 'wtrNoDetailsClass';
		}

		if ( $the_query->have_posts() ) {

			if( 'standard' == $style ){

				while ( $the_query->have_posts() ) {
					$the_query->the_post();

					$id					= get_the_id();
					$title				= get_the_title();
					$url				= esc_url( get_permalink() );
					$lvl				= get_post_meta( $id, '_wtr_classes_lvl', true );
					$duration			= get_post_meta( $id, '_wtr_classes_duration', true );
					$post_thumbnail_id	= get_post_thumbnail_id( $id );
					$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_2' );
					$image_alt			= esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) );
					$image				= ( $image_attributes[0] ) ? $image_attributes[0] : $post_settings['wtr_DefalutThumbnail'] ;
					$class_row			= ( 1 == $item_rows ) ? 'wtrOneCol' : ( ( 2 == $item_rows ) ? 'wtrTwoCols' : ( ( 3 == $item_rows ) ? 'wtrThreeCols' : ( ( 4 == $item_rows ) ? 'wtrFourCols' :'' ) ) );
					$class_item			= ( $item_rows == $i ) ? 'wtrShtClassesLastInRow' : '';

					if( $i == 1 ){
						$class_html_attr = 'wtrShtClassesStream ' . $class_row . ' ' . $el_class . ' clearfix';
						$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' >';
					}
					$i++;

					$result .= '<div class="wtrSht wtrShtClasses ' . $class_item . ' ">';
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

					if( $item_rows <  $i ){
						$result .= '</div>';
						$i = 1;
					}
				}

				if( $i != 1 ) {
					$result .= '</div>';
				}

			} else if( 'metro' == $style ){

				$class_row	='wtrShtOrderChange';
				$item_rows	= 2;

				while ( $the_query->have_posts() ) {
					$the_query->the_post();

					$id					= get_the_id();
					$title				= get_the_title();
					$url				= esc_url( get_permalink() );
					$lvl				= get_post_meta( $id, '_wtr_classes_lvl', true );
					$duration			= get_post_meta( $id, '_wtr_classes_duration', true );
					$post_thumbnail_id	= get_post_thumbnail_id( $id );
					$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_2' );
					$image_alt			= esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) );
					$image				= ( $image_attributes[0] ) ? $image_attributes[0] : $post_settings['wtr_DefalutThumbnail'] ;
					$class_item			= ( 1 == $i ) ? '' : 'wtrShtBoxedClassesSpaceSec' ;

					if( $i == 1 ){
						$class_row			= ( empty( $class_row ) ) ? 'wtrShtOrderChange' : '';
						$class_html_attr	= 'wtrSht wtrShtBoxedClasses ' . $class_row . ' ' . $el_class . ' clearfix';
						$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' >';
					}
					$i++;

					$result .= '<div class="wtrShtBoxedClassesSpace wtrShtBoxedClassesCoOneHalf '. $hide_diff . ' ' . $class_item . ' clearfix">';
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
											$result .= '<i class="fa fa-clock-o"></i> ' . $duration . ' ' . $post_settings['wtr_TranslateClassesSHTMinutes'] ;
										$result .= '</span>';
									$result .= '</div>';
									$result .= '<p class="wtrShtBoxedClassesDesc">' . wtr_excerpt() . '</p>';
								$result .= '</div>';
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

			} else if( 'list' == $style ){
				$class_html_attr = 'wtrSht wtrShtClassesList ' . $el_class;
				$result .= '<ul ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . '>';
					while ( $the_query->have_posts() ) {
						$the_query->the_post();

						$id					= get_the_id();
						$title				= get_the_title();
						$url				= esc_url( get_permalink() );
						$lvl				= get_post_meta( $id, '_wtr_classes_lvl', true );
						$duration			= get_post_meta( $id, '_wtr_classes_duration', true );
						$kcal				= get_post_meta( $id, '_wtr_classes_calories_burned', true );

						$result .= '<li class="wtrShtClassesListItem '. $hide_diff . ' clearfix">';

							if( 'no' == $show_level ){
								$result .= '<ul class="wtrShtBoxedClassesSkill clearfix wtrRadius100">';
									$result .= wtr_helper_classes_skill_dot( $lvl );
								$result .= '</ul>';
							}

							$result .= '<h3 class="wtrShtClassesListTittle">';
								$result .= '<a href="' . $url . '" class="wtrClassHeadNameJs">' . $title . '</a>';
							$result .= '</h3>';
							$result .= '<div class="wtrShtClassesListItemRight">';
								$result .= '<span class="wtrShtClassesListKcallInfo">' . $kcal . ' ' . $post_settings['wtr_TranslateClassesSHTKcal'] . '<i class="fa fa-refresh"></i></span>';
								$result .= '<span class="wtrShtClassesListTimeInfo">' . $duration . ' ' . $post_settings['wtr_TranslateClassesSHTMinutes'] . '<i class="fa fa-clock-o"></i></span>';
							$result .= '</div>';
						$result .= '</li>';
					}
				$result .= '</ul>';
			}
		}
		wp_reset_postdata();
		return $result;
	}//end Render

}//end VCExtendAddonClasses

new VCExtendAddonClasses();