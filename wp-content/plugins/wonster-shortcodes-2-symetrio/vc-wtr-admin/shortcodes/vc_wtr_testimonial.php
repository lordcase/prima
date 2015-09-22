<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

if ( !defined( 'WTR_CP_PLUGIN_MAIN_FILE' ) ) { return; }

include_once ( 'vc_wtr.php' );

class VCExtendAddonTestimonial extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_testimonial';
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
				'param_name'	=> 'type',
				'heading'		=> __( 'Presentation style', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Standard', 'wtr_sht_framework' )	=> 'standard',
											__( 'Carusel', 'wtr_sht_framework' )	=> 'carusel',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_type_class',
			),

			array(
				'param_name'	=> 'version',
				'heading'		=> __( 'Version', 'wtr_sht_framework' ),
				'description'	=> __( 'Enable this option if you want to put this item on the background and make it
										more attractive', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Standard', 'wtr_sht_framework' )	=> 'standard',
											__( 'Light', 'wtr_sht_framework' )		=> 'light',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_version_class',
			),

			array(
				'param_name'	=> 'interval',
				'heading'		=> __( 'Interval', 'wtr_sht_framework' ),
				'description'	=> 'For example: <b>1</b> second delay is <b>1000</b> milliseconds. <b>Please, use only numeric signs</b>',
				'type'			=> 'textfield',
				'value'			=> 4000,
				'admin_label' 	=> false,
				'class'			=> $this->base . '_interval_class',
				'dependency' 	=> array(	'element'	=> 'type',
											'value'		=> array( 'carusel' ) )
			),

			array(
				'param_name'	=> 'category',
				'heading'		=> __( 'Include categories of testimonial', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the category of the testimonial', 'wtr_sht_framework' ),
				'type'			=> 'wtr_multi_select',
				'value'			=> $this->getTermsData( 'testimonial-category' ),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_category_class',
				'wtr_attr'		=> array( 'size' => 5 )
			),

			array(
				'param_name'	=> 'order',
				'heading'		=> __( 'Order by', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify in which order selected testimonials should be displayed', 'wtr_sht_framework' ),
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
			'name'			=> __( 'Testimonial', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'elements' ],
			'params'		=> $this->fields,
			'weight'		=> 16000,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result	='';
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract( $atts );

		$tax_query				= null;
		$query_category			= ( 'wtr_all_items' == $category ) ? '' :explode(',', $category );

		if( $query_category ){
			$tax_query[]	=  array(
				'taxonomy'			=> 'testimonial-category',
				'field'				=> 'slug',
				'terms'				=> $query_category,
				'include_children'	=> false
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
			'post_type' 		=> 'testimonial',
			'posts_per_page'	=> $limit,
			'tax_query' 		=> $tax_query,
			'orderby'			=> $query_orderby,
			'order'				=> $query_order,

		);

		// The Query
		$the_query = new WP_Query( $query_args );

		if ( $the_query->have_posts() ) {

			if( 'standard' == $type ){

				$class				= ( 'standard' == $version ) ? 'wtrShtTestimonialStd' : 'wtrShtTestimonialStdLight' ;
				$class_html_attr	= 'wtrShtTestimonialStdStream ' . $el_class . ' clearfix';

				$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . '>';

					while ( $the_query->have_posts() ) {
						$the_query->the_post();

						$id					= get_the_id();
						$author				= get_post_meta( $id, '_wtr_testimonial_author', true );
						$desc				= get_post_meta( $id, '_wtr_testimonial_desc', true );
						$post_thumbnail_id	= get_post_thumbnail_id( $id );
						$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'thumbnail' );
						$image_alt			= esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) );
						$image				= ( $image_attributes[0] ) ? $image_attributes[0] : '';

						$result .= '<div class="wtrSht wtrShtTestimonialStd ' . $class . '">';
							$result .= '<div class="wtrShtTestimonialStdContainer">';
								$result .= '<p>' . $desc . '</p>';
							$result .= '</div>';
							$result .= '<div class="wtrShtTestimonialStdAuthor clearfix">';
								if( $image ){
									$result .= '<div class="wtrShtTestimonialStdAuthorPicContainer">';
										$result .= '<img class="wtrShtTestimonialStdAuthorPic" src="' . $image . '" alt="' . $image_alt . '">';
									$result .= '</div>';
								}
								if( $author ){
									$result .= '<span class="wtrShtTestimonialStdAuthorName">' . $author . '</span>';
								}
							$result .= '</div>';
						$result .= '</div>';
					}
				$result .= '</div>';

			} else if( 'carusel' == $type  ){

				$interval = intval( $interval );
				if( 0 >= $interval){
					$interval = 4000;
				}

				$class = ( 'standard' == $version ) ? '' : 'wtrCenterLight' ;
				$class_html_attr = 'wtrSht wtrShtTestimonialRot wtrShtTestimonialRotSht wtrCenterFullWidth ' . esc_attr( $class ) . ' ' . esc_attr( $el_class ) . ' clearfix';
				$result .= '<div data-interval="'. esc_attr( $interval ) .'" ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' >';

					while ( $the_query->have_posts() ) {
						$the_query->the_post();

						$id			= get_the_id();
						$author		= get_post_meta( $id, '_wtr_testimonial_author', true );
						$desc		= get_post_meta( $id, '_wtr_testimonial_desc', true );

						$result .= '<div class="wtrShtTestimonialStdItem">';
							$result .= '<div class="wtrShtTestimonialStdContainer">';
								$result .= '<p>' . $desc . '</p>';
							$result .= '</div>';
							$result .= '<div class="wtrShtTestimonialStdAuthor clearfix">';
								if( $author ){
									$result .= '<span class="wtrShtTestimonialStdAuthorName">' . $author . '</span>';
								}
							$result .= '</div>';
						$result .= '</div>';
					}
				$result .= '</div>';
			}
		}
		wp_reset_postdata();
		return $result;
	}//end Render

}//end VCExtendAddonTestimonial

new VCExtendAddonTestimonial();