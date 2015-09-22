<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

if ( !defined( 'WTR_CP_PLUGIN_MAIN_FILE' ) ) { return; }

include_once ( 'vc_wtr.php' );

class VCExtendAddonPasses extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_passes';
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
				'param_name'	=> 'version',
				'heading'		=> __( 'Version', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Standard', 'wtr_sht_framework' )	=> 'wtrShtPassesListLight',
											__( 'Dark', 'wtr_sht_framework' )		=> 'wtrShtPassesListDark',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_version_class',
			),

			array(
				'param_name'	=> 'mode',
				'heading'		=> __( 'Mode', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Show tickets only from 1 category', 'wtr_sht_framework' )	=> 'signle',
											__( 'Show several categories ticket', 'wtr_sht_framework' )		=> 'many',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_mode_class',
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
				'heading'		=> __( 'Select a pass category to be attached to content', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> $this->getTermsData( 'pass-category', array( 'wtr_add_all_item' => false )  ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_category_class',
				'dependency' => array(	'element' => 'mode',
										'value' => array( 'signle' ) )
			),

			array(
				'param_name'	=> 'categories_passes',
				'heading'		=> __( 'Passes category', 'wtr_sht_framework' ),
				'description'	=> __( 'Select a pass to be attached to content', 'wtr_sht_framework' ),
				'type'			=> 'wtr_multi_select',
				'value'			=> $this->getTermsData( 'pass-category' ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_categories_passes_class',
				'wtr_attr'		=> array( 'size' => 6 ),
				'dependency' => array(	'element' => 'mode',
										'value' => array( 'many' ) )
			),

			array(
				'param_name'	=> 'open',
				'heading'		=> __( 'Specify a category, which item should be open initially', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> $this->getTermsData( 'pass-category', array( 'wtr_add_all_item' => false ) ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_open_class',
				'dependency' => array(	'element' => 'mode',
										'value' => array( 'many' ) )
			),

			array(
				'param_name'	=> 'order_category_passes',
				'heading'		=> __( 'Order passes category by', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify in which order selected pass category should be displayed', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Category title (ascending)', 'wtr_sht_framework' )		=> 'title_asc',
											__( 'Category title (descending)', 'wtr_sht_framework' )	=> 'title_desc',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_order_category_passes_class',
				'dependency' => array(	'element' => 'mode',
										'value' => array( 'many' ) )
			),

			array(
				'param_name'	=> 'order_passes',
				'heading'		=> __( 'Order passes by', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the order of pass category', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Date added client (ascending)', 'wtr_sht_framework' )		=> 'data_add_asc',
											__( 'Date added clients (descending)', 'wtr_sht_framework' )	=> 'data_add_desc',
											__( 'Order value (ascending)', 'wtr_sht_framework' )			=> 'order_asc',
											__( 'Order value (descending)', 'wtr_sht_framework' )			=> 'order_desc',
											__( 'Title (ascending)', 'wtr_sht_framework' )					=> 'title_asc',
											__( 'Title (descending)', 'wtr_sht_framework' )					=> 'title_desc',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_order_passes_class',
			),

			$this->getDefaultVCfield( 'el_class' ),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );

		vc_map( array(
			'name'			=> __( 'Passes', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'elements' ],
			'params'		=> $this->fields,
			'weight'		=> 21000,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result	='';
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract( $atts );

		global $post_settings;

		$pass_array				= array();
		$i						= 1;
		$tax_query				= null;
		$meta_query				= null;
		$query_gym_location		= ( 'wtr_all_items' == $gym_location ) ? '' :explode(',', $gym_location );

		if( 'many' == $mode ) {
			$query_category			= ( 'wtr_all_items' == $categories_passes ) ? '' :explode(',', $categories_passes );
		} else {
			$query_category[]		= $category;
			$open					= $category;
		}

		if( $query_category ){
			$tax_query[]	=  array(
				'taxonomy'			=> 'pass-category',
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

		switch ( $order_passes ) {
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
			'post_type'			=> 'pass',
			'posts_per_page'	=> -1,
			'tax_query'			=> $tax_query,
			'meta_query'		=> $meta_query,
			'orderby'			=> $query_orderby,
			'order'				=> $query_order,

		);

		// The Query
		$the_query = new WP_Query( $query_args );

		if ( $the_query->have_posts() ) {

				while ( $the_query->have_posts() ) {

					$the_query->the_post();
					$id			= get_the_id();
					$status		= get_post_meta( $id, '_wtr_pass_status', True );
					$categories	= get_the_terms( $id, 'pass-category' );

					if( is_array( $categories ) ) {
						foreach ( $categories as $category ) {

							$category_name = $category->name;
							$category_slug = $category->slug;

							if( empty( $query_category ) OR in_array( $category_slug, $query_category) ){
								$pass_array[ $category_name ][ 'slug' ] = $category_slug ;
								$pass_array[ $category_name ][ 'pass' ][ $id ]= array(
										'title'					=> get_the_title( $id ),
										'price'					=> get_post_meta( $id, '_wtr_pass_price', True ),
										'membership_type'		=> get_post_meta( $id, '_wtr_pass_membership_type', True ),
										'desc'					=> get_post_meta( $id, '_wtr_pass_desc', True ),
										'status'				=> $status,
										'class'					=> ( 0 == $status ) ? 'promoStatus' : ( ( 1 == $status ) ? 'newStatus' : 'featuredStatus' ),
										'PayPalHtml'			=> wtr_paypal_button( get_post_meta( $id, '_wtr_PayPalButton', True ), get_post_meta( $id, '_wtr_PayPalPrice', True ), get_post_meta( $id, '_wtr_PayPalEmail', True ), get_post_meta( $id, '_wtr_PayPalCurrencyCode', True ), get_the_title( $id ), 'wtrPLPayPalBtnAct' )
									);
							}
						}
					}
				}
			( 'title_asc' == $order_category_passes ) ? ksort( $pass_array, SORT_STRING ) : krsort( $pass_array, SORT_STRING );

			$class_html_attr = 'wtrSht wtrShtPasses wtrShtPassesList wtrPasses ' . $el_class . ' ' . $version . ' clearfix';

			$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' data-open="' . $open . '" >';
				foreach ( $pass_array  as $category => $passes ) {
					$result .= '<ul class="wtrShtPassesListContainer clearfix wtrShtPassesCategory-' . $passes[ 'slug' ] . '">';
						$result .= '<li class="wtrShtPassesListItem">';
							$result .= '<div class="wtrShtPassesListHeadline">';
								$result .= '<h5 class="wtrShtPassesListHeadlineItem">' . $category . '</h5>';
								$result .= '<span class="wtrShtPassesListNavi"></span>';
							$result .= '</div>';
							$result .= '<div class="wtrShtPassesListContent">';
								$result .= '<ul class="wtrShtPassesPriceList ">';
								foreach ( $passes[ 'pass' ] as $pass ) {
									$result .= '<li class="wtrShtPassesPriceListItem">';
										$result .= '<div class="wtrShtPassesListClassesName">';
											$result .= $pass['title'];
											$result .= '<span class="' . $pass['class'] . ' wtrRadius100">' . $post_settings['wtr_TranslateClassesSHTPassStatus' . $pass['status'] ] . '</span>';
										$result .= '</div>';

										$result .= '<div class="wtrShtPassesListClassesDesc">';
											$result .= $pass['desc'];
										$result .= '</div>';
										$result .= '<div class="wtrShtPassesListClassesPrice wtrRadius2">';
											$result .= $pass['price'];
											$result .= $pass['PayPalHtml'];
										$result .= '</div>';
									$result .= '</li>';
								}
								$result .= '</ul>';
							$result .= '</div>';
						$result .= '</li>';
					$result .= '</ul>';
				}
			$result .= '</div>';
		}

		return $result;
	}//end Render

}//end VCExtendAddonPasses

new VCExtendAddonPasses();