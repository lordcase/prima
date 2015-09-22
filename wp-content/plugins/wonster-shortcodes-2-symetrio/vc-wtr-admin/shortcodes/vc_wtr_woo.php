<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

if( ! function_exists( 'is_woocommerce' ) ) {
	return 0;
}

include_once ( 'vc_wtr.php' );

class VCExtendAddonWooRelatedProducts extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_woo_related_products';
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
				'param_name'	=> 'per_page',
				'heading'		=> __( 'Products per page', 'wtr_sht_framework' ),
				'description'	=> __( '<b>Please, use only numeric signs</b>', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '10',
				'admin_label' 	=> true,
				'class'			=> $this->base . '_per_page_class',
			),

			array(
				'param_name'	=> 'columns',
				'heading'		=> __( 'Number of columns of products', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( ' 5 ', 'wtr_sht_framework' )	=> '5',
											__( ' 4 ', 'wtr_sht_framework' )	=> '4',
											__( ' 3 ', 'wtr_sht_framework' )	=> '3',
											__( ' 2 ', 'wtr_sht_framework' )	=> '2',
											__( ' 1 ', 'wtr_sht_framework' )	=> '1',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_columns_class',
			),

			array(
				'param_name'	=> 'orderby',
				'heading'		=> __( 'Sorting by attribute', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Menu order', 'wtr_sht_framework' )	=> 'menu_order',
											__( 'Title', 'wtr_sht_framework' )		=> 'title',
											__( 'Date', 'wtr_sht_framework' )		=> 'date',
											__( 'Rand', 'wtr_sht_framework' )		=> 'rand',
											__( 'ID', 'wtr_sht_framework' )			=> 'id',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_orderby_class',
			),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );

		vc_map( array(
			'name'			=> __( 'WooCommerce Related Products', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'woocommerce' ],
			'params'		=> $this->fields,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract( $atts );

		$result	='[related_products per_page="' . esc_attr( $per_page ) . '" columns="' . esc_attr( $columns ) . '" orderby="' . esc_attr( $orderby ) . '"]';
		$result = do_shortcode( $result );

		return $result;
	}//end Render
}//end VCExtendAddonWooRelatedProducts


class VCExtendAddonWooBestSellingProducts extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_woo_best_selling_product';
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
				'param_name'	=> 'per_page',
				'heading'		=> __( 'Products per page', 'wtr_sht_framework' ),
				'description'	=> __( '<b>Please, use only numeric signs</b>', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '10',
				'admin_label' 	=> true,
				'class'			=> $this->base . '_per_page_class',
			),

			array(
				'param_name'	=> 'columns',
				'heading'		=> __( 'Number of columns of products', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( ' 5 ', 'wtr_sht_framework' )	=> '5',
											__( ' 4 ', 'wtr_sht_framework' )	=> '4',
											__( ' 3 ', 'wtr_sht_framework' )	=> '3',
											__( ' 2 ', 'wtr_sht_framework' )	=> '2',
											__( ' 1 ', 'wtr_sht_framework' )	=> '1',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_columns_class',
			),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );

		vc_map( array(
			'name'			=> __( 'WooCommerce Best Selling Products', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'woocommerce' ],
			'params'		=> $this->fields,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract( $atts );

		$result	='[best_selling_products per_page="' . esc_attr( $per_page ) . '" columns="' . esc_attr( $columns ) . '"]';
		$result = do_shortcode( $result );

		return $result;
	}//end Render
}//end VCExtendAddonWooBestSellingProducts


class VCExtendAddonWooSaleProducts extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_woo_sale_products';
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
				'param_name'	=> 'per_page',
				'heading'		=> __( 'Products per page', 'wtr_sht_framework' ),
				'description'	=> __( '<b>Please, use only numeric signs</b>', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '10',
				'admin_label' 	=> true,
				'class'			=> $this->base . '_per_page_class',
			),

			array(
				'param_name'	=> 'columns',
				'heading'		=> __( 'Number of columns of products', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( ' 5 ', 'wtr_sht_framework' )	=> '5',
											__( ' 4 ', 'wtr_sht_framework' )	=> '4',
											__( ' 3 ', 'wtr_sht_framework' )	=> '3',
											__( ' 2 ', 'wtr_sht_framework' )	=> '2',
											__( ' 1 ', 'wtr_sht_framework' )	=> '1',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_columns_class',
			),

			array(
				'param_name'	=> 'orderby',
				'heading'		=> __( 'Sorting by attribute', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Menu order', 'wtr_sht_framework' )	=> 'menu_order',
											__( 'Title', 'wtr_sht_framework' )		=> 'title',
											__( 'Date', 'wtr_sht_framework' )		=> 'date',
											__( 'Rand', 'wtr_sht_framework' )		=> 'rand',
											__( 'ID', 'wtr_sht_framework' )			=> 'id',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_orderby_class',
			),

			array(
				'param_name'	=> 'order',
				'heading'		=> __( 'Sort order', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Ascending (A-Z)', 'wtr_sht_framework' )	=> 'asc',
											__( 'Descending (Z-A)', 'wtr_sht_framework' )	=> 'desc'
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_orderby_class',
			),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );

		vc_map( array(
			'name'			=> __( 'WooCommerce Sale Products', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'woocommerce' ],
			'params'		=> $this->fields,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract( $atts );

		$result	='[sale_products per_page="' . esc_attr( $per_page ) . '" columns="' . esc_attr( $columns ) . '" orderby="' . esc_attr( $orderby ) . '"  order="' . esc_attr( $order ) . '"]';
		$result = do_shortcode( $result );

		return $result;
	}//end Render
}//end VCExtendAddonWooSaleProducts


class VCExtendAddonWooFeaturedProducts extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_woo_featured_products';
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
				'param_name'	=> 'per_page',
				'heading'		=> __( 'Products per page', 'wtr_sht_framework' ),
				'description'	=> __( '<b>Please, use only numeric signs</b>', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '10',
				'admin_label' 	=> true,
				'class'			=> $this->base . '_per_page_class',
			),

			array(
				'param_name'	=> 'columns',
				'heading'		=> __( 'Number of columns of products', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( ' 5 ', 'wtr_sht_framework' )	=> '5',
											__( ' 4 ', 'wtr_sht_framework' )	=> '4',
											__( ' 3 ', 'wtr_sht_framework' )	=> '3',
											__( ' 2 ', 'wtr_sht_framework' )	=> '2',
											__( ' 1 ', 'wtr_sht_framework' )	=> '1',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_columns_class',
			),

			array(
				'param_name'	=> 'orderby',
				'heading'		=> __( 'Sorting by attribute', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Menu order', 'wtr_sht_framework' )	=> 'menu_order',
											__( 'Title', 'wtr_sht_framework' )		=> 'title',
											__( 'Date', 'wtr_sht_framework' )		=> 'date',
											__( 'Rand', 'wtr_sht_framework' )		=> 'rand',
											__( 'ID', 'wtr_sht_framework' )			=> 'id',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_orderby_class',
			),

			array(
				'param_name'	=> 'order',
				'heading'		=> __( 'Sort order', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Ascending (A-Z)', 'wtr_sht_framework' )	=> 'asc',
											__( 'Descending (Z-A)', 'wtr_sht_framework' )	=> 'desc'
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_orderby_class',
			),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );

		vc_map( array(
			'name'			=> __( 'WooCommerce Featured Products', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'woocommerce' ],
			'params'		=> $this->fields,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract( $atts );

		$result	='[featured_products per_page="' . esc_attr( $per_page ) . '" columns="' . esc_attr( $columns ) . '" orderby="' . esc_attr( $orderby ) . '"  order="' . esc_attr( $order ) . '"]';
		$result = do_shortcode( $result );

		return $result;
	}//end Render
}//end VCExtendAddonWooFeaturedProducts


class VCExtendAddonWooTopRatedProducts extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_woo_top_rated_products';
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
				'param_name'	=> 'per_page',
				'heading'		=> __( 'Products per page', 'wtr_sht_framework' ),
				'description'	=> __( '<b>Please, use only numeric signs</b>', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '10',
				'admin_label' 	=> true,
				'class'			=> $this->base . '_per_page_class',
			),

			array(
				'param_name'	=> 'columns',
				'heading'		=> __( 'Number of columns of products', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( ' 5 ', 'wtr_sht_framework' )	=> '5',
											__( ' 4 ', 'wtr_sht_framework' )	=> '4',
											__( ' 3 ', 'wtr_sht_framework' )	=> '3',
											__( ' 2 ', 'wtr_sht_framework' )	=> '2',
											__( ' 1 ', 'wtr_sht_framework' )	=> '1',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_columns_class',
			),

			array(
				'param_name'	=> 'orderby',
				'heading'		=> __( 'Sorting by attribute', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Menu order', 'wtr_sht_framework' )	=> 'menu_order',
											__( 'Title', 'wtr_sht_framework' )		=> 'title',
											__( 'Date', 'wtr_sht_framework' )		=> 'date',
											__( 'Rand', 'wtr_sht_framework' )		=> 'rand',
											__( 'ID', 'wtr_sht_framework' )			=> 'id',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_orderby_class',
			),

			array(
				'param_name'	=> 'order',
				'heading'		=> __( 'Sort order', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Ascending (A-Z)', 'wtr_sht_framework' )	=> 'asc',
											__( 'Descending (Z-A)', 'wtr_sht_framework' )	=> 'desc'
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_orderby_class',
			),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );

		vc_map( array(
			'name'			=> __( 'WooCommerce Top Rated Products', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'woocommerce' ],
			'params'		=> $this->fields,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract( $atts );

		$result	='[top_rated_products per_page="' . esc_attr( $per_page ) . '" columns="' . esc_attr( $columns ) . '" orderby="' . esc_attr( $orderby ) . '"  order="' . esc_attr( $order ) . '"]';
		$result = do_shortcode( $result );

		return $result;
	}//end Render
}//end VCExtendAddonWooTopRatedProducts


class VCExtendAddonWooProductCategory extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_woo_product_category';
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
				'param_name'	=> 'per_page',
				'heading'		=> __( 'Products per page', 'wtr_sht_framework' ),
				'description'	=> __( '<b>Please, use only numeric signs</b>', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '10',
				'admin_label' 	=> true,
				'class'			=> $this->base . '_per_page_class',
			),

			array(
				'param_name'	=> 'columns',
				'heading'		=> __( 'Number of columns of products', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( ' 5 ', 'wtr_sht_framework' )	=> '5',
											__( ' 4 ', 'wtr_sht_framework' )	=> '4',
											__( ' 3 ', 'wtr_sht_framework' )	=> '3',
											__( ' 2 ', 'wtr_sht_framework' )	=> '2',
											__( ' 1 ', 'wtr_sht_framework' )	=> '1',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_columns_class',
			),

			array(
				'param_name'	=> 'orderby',
				'heading'		=> __( 'Sorting by attribute', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Menu order', 'wtr_sht_framework' )	=> 'menu_order',
											__( 'Title', 'wtr_sht_framework' )		=> 'title',
											__( 'Date', 'wtr_sht_framework' )		=> 'date',
											__( 'Rand', 'wtr_sht_framework' )		=> 'rand',
											__( 'ID', 'wtr_sht_framework' )			=> 'id',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_orderby_class',
			),

			array(
				'param_name'	=> 'order',
				'heading'		=> __( 'Sort order', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Ascending (A-Z)', 'wtr_sht_framework' )	=> 'asc',
											__( 'Descending (Z-A)', 'wtr_sht_framework' )	=> 'desc'
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_orderby_class',
			),

			array(
				'param_name'	=> 'category',
				'heading'		=> __( 'Category', 'wtr_sht_framework' ),
				'description'	=> __( 'Go to: WooCommerce > Products > Categories to find the slug column', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> true,
				'class'			=> $this->base . '_category_class',
			),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );

		vc_map( array(
			'name'			=> __( 'WooCommerce Product Category', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'woocommerce' ],
			'params'		=> $this->fields,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract( $atts );

		$result	='[product_category per_page="' . esc_attr( $per_page ) . '" columns="' . esc_attr( $columns ) . '" orderby="' . esc_attr( $orderby ) . '"  order="' . esc_attr( $order ) . '" category="' . esc_attr( $category ) . '"]';
		$result = do_shortcode( $result );

		return $result;
	}//end Render
}//end VCExtendAddonWooProductCategory


class VCExtendAddonWooRecentProduct extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_woo_recent_product';
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
				'param_name'	=> 'per_page',
				'heading'		=> __( 'Products per page', 'wtr_sht_framework' ),
				'description'	=> __( '<b>Please, use only numeric signs</b>', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '10',
				'admin_label' 	=> true,
				'class'			=> $this->base . '_per_page_class',
			),

			array(
				'param_name'	=> 'columns',
				'heading'		=> __( 'Number of columns of products', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( ' 5 ', 'wtr_sht_framework' )	=> '5',
											__( ' 4 ', 'wtr_sht_framework' )	=> '4',
											__( ' 3 ', 'wtr_sht_framework' )	=> '3',
											__( ' 2 ', 'wtr_sht_framework' )	=> '2',
											__( ' 1 ', 'wtr_sht_framework' )	=> '1',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_columns_class',
			),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );

		vc_map( array(
			'name'			=> __( 'WooCommerce Recent Product', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'woocommerce' ],
			'params'		=> $this->fields,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract( $atts );

		$result	='[recent_products per_page="' . esc_attr( $per_page ) . '" columns="' . esc_attr( $columns ) . '"]';
		$result = do_shortcode( $result );

		return $result;
	}//end Render
}//end VCExtendAddonWooRecentProduct


//== Create WooCommerce Sht Object
new VCExtendAddonWooRelatedProducts();
new VCExtendAddonWooBestSellingProducts();
new VCExtendAddonWooSaleProducts();
new VCExtendAddonWooFeaturedProducts();
new VCExtendAddonWooTopRatedProducts();
new VCExtendAddonWooProductCategory();
new VCExtendAddonWooRecentProduct();