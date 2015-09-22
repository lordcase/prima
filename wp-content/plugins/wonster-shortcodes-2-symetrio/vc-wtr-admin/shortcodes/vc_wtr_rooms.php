<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

if ( !defined( 'WTR_CP_PLUGIN_MAIN_FILE' ) ) { return; }

include_once ( 'vc_wtr.php' );

class VCExtendAddonRooms extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_rooms';
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
				'heading'		=> __( 'Include categories of rooms', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the category of the rooms', 'wtr_sht_framework' ),
				'type'			=> 'wtr_multi_select',
				'value'			=> $this->getTermsData( 'rooms-category' ),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_category_class',
				'wtr_attr'		=> array( 'size' => 3 ),
			),

			array(
				'param_name'	=> 'order',
				'heading'		=> __( 'Order by', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify in which order selected rooms should be displayed', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Date added testimonial (ascending)', 'wtr_sht_framework' )		=> 'data_add_asc',
											__( 'Date added testimonial (descending)', 'wtr_sht_framework' )	=> 'data_add_desc',
											__( 'Order value (ascending)', 'wtr_sht_framework' )				=> 'order_asc',
											__( 'Order value (descending)', 'wtr_sht_framework' )				=> 'order_desc',
											__( 'Title (ascending)', 'wtr_sht_framework' )						=> 'title_asc',
											__( 'Title (descending)', 'wtr_sht_framework' )						=> 'title_desc',
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

			$this->getDefaultVCfield( 'el_class' ),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );

		vc_map( array(
			'name'			=> __( 'Rooms', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'elements' ],
			'params'		=> $this->fields,
			'weight'		=> 20000,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result	='';
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract( $atts );

		global $post_settings;

		$tax_query				= null;
		$meta_query				= null;
		$query_gym_location		= ( 'wtr_all_items' == $gym_location ) ? '' :explode(',', $gym_location );
		$query_category			= ( 'wtr_all_items' == $category ) ? '' :explode(',', $category );

		if( $query_category ){
			$tax_query[]	=  array(
				'taxonomy'			=> 'rooms-category',
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
			'post_type' 		=> 'rooms',
			'posts_per_page'	=> $limit,
			'tax_query' 		=> $tax_query,
			'meta_query'		=> $meta_query,
			'orderby'			=> $query_orderby,
			'order'				=> $query_order,

		);

		// The Query
		$the_query = new WP_Query( $query_args );

		if ( $the_query->have_posts() ) {

			$class_html_attr = 'wtrSht wtrShtRooms ' . esc_attr( $el_class );

			$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . '>';
				while ( $the_query->have_posts() ) {
					$the_query->the_post();

					$id					= get_the_id();
					$title				= get_the_title();
					$url				= esc_url( get_permalink() );
					$post_thumbnail_id	= get_post_thumbnail_id( $id );
					$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_4' );
					$image				= ( $image_attributes[0] ) ? 'style="background-image: url(\' ' . $image_attributes[0] . '\');"' : $post_settings['wtr_DefalutThumbnail'] ;
					$categories			= get_the_terms( get_the_id(), 'rooms-category' );

					$result .= '<div class="wtrShtRoom">';
						$result .= '<div class="wtrShtRoomContainer">';
							$result .= '<div class="wtrShtRoomName wrtAltFontCharacter">';
								$result .= $title;
								$result .= '<span class="wtrShtRoomIcon wtrShtRoomAnimation">';
									$result .= '<i class="fa fa-long-arrow-right"></i>';
								$result .= '</span>';
							$result .= '</div>';
							$result .= '<div class="wtrShtRoomSeparator"></div>';

							if( $categories ){
								$result .= '<ul class="wtrShtRoomClasses clearfix">';
									foreach ( (array) $categories as $category ) {
										$result .= '<li class="wtrShtRoomClassesName wtrRadius2">' . $category->name . '</li>';
									}
								$result .= '</ul>';
							}

							$result .= '</div>';
							$result .= '<a href="' . $url . '" class="wtrShtRoomClassesLink"></a>';
							$result .= '<div class="wtrShtRoomOverlay wtrShtRoomAnimation"></div>';
							$result .= '<div class="wtrShtRoomBg" ' . $image . ' ></div>';
					$result .= '</div>';
				}
			$result .= '</div>';
		}
		wp_reset_postdata();
		return $result;
	}//end Render

}//end VCExtendAddonRooms

new VCExtendAddonRooms();