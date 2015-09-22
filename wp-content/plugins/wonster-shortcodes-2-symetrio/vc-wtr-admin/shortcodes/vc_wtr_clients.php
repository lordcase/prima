<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

if ( !defined( 'WTR_CP_PLUGIN_MAIN_FILE' ) ) { return; }

include_once ( 'vc_wtr.php' );

class VCExtendAddonClients extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_clients';
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
				'param_name'	=> 'label',
				'heading'		=> __( 'Label', 'wtr_sht_framework' ),
				'description'	=> __( 'Where should your button link to?', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> true,
				'class'			=> $this->base . '_label_class',
			),

			array(
				'param_name'	=> 'type',
				'heading'		=> __( 'Presentation style', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Boxed table', 'wtr_sht_framework' )	=> 'boxed',
											__( 'Slider', 'wtr_sht_framework' )			=> 'slider',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_type_class',
			),

			array(
				'param_name'	=> 'controls',
				'heading'		=> __( 'Controls visibility', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify whether you want to see client slider controls', 'wtr_sht_framework' ),
				'type'			=> 'wtr_controls',
				'value'			=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Yes', 'wtr_sht_framework' )	=> ' ',
											__( 'No', 'wtr_sht_framework' )		=> 'wtrClientsNoControls',
										),
				'admin_label'	=> false,
				'class'			=> $this->base . '_controls_class',
				'dependency' 	=> array(	'element'	=> 'type',
											'value'		=> array( 'slider' ) )
			),

			array(
				'param_name'	=> 'interval',
				'heading'		=> __( 'Delay interval', 'wtr_sht_framework' ),
				'description'	=> 'For example: <b>1</b> second delay is <b>1000</b> milliseconds. <b>Please, use only numeric signs</b>',
				'type'			=> 'textfield',
				'value'			=> 4000,
				'admin_label' 	=> false,
				'class'			=> $this->base . '_interval_class',
				'dependency' 	=> array(	'element'	=> 'type',
											'value'		=> array( 'slider' ) )
			),

			array(
				'param_name'	=> 'version',
				'heading'		=> __( 'Version', 'wtr_sht_framework' ),
				'description'	=> __( 'Enable this option if you want to put this item on the background and make it
										more attractive', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Standard', 'wtr_sht_framework' )	=> 'wtrShtClientsStandard',
											__( 'Light', 'wtr_sht_framework' )		=> 'wtrShtClientsLight',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_version_class',
				'dependency' 	=> array(	'element'	=> 'type',
											'value'		=> array( 'slider' ) )
			),

			array(
				'param_name'	=> 'target',
				'heading'		=> __( 'Open link in a new tab', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Yes', 'wtr_sht_framework' )	=> 'yes',
											__( 'No', 'wtr_sht_framework' )		=> 'no',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_target_class',
			),

			array(
				'param_name'	=> 'category',
				'heading'		=> __( 'Include categories of clients', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the category of the clients', 'wtr_sht_framework' ),
				'type'			=> 'wtr_multi_select',
				'value'			=> $this->getTermsData( 'clients-category' ),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_category_class',
				'wtr_attr'		=> array( 'size' => 5 ),
			),

			array(
				'param_name'	=> 'order',
				'heading'		=> __( 'Order by', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify in which order selected clients should be displayed', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Date added client (ascending)', 'wtr_sht_framework' )		=> 'data_add_asc',
											__( 'Date added clients (descending)', 'wtr_sht_framework' )	=> 'data_add_desc',
											__( 'Order value (ascending)', 'wtr_sht_framework' )			=> 'order_asc',
											__( 'Order value (descending)', 'wtr_sht_framework' )			=> 'order_desc',
											__( 'Title (ascending)', 'wtr_sht_framework' )					=> 'title_asc',
											__( 'Title (descending)', 'wtr_sht_framework' )					=> 'title_desc',
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
			'name'			=> __( 'Clients', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'elements' ],
			'params'		=> $this->fields,
			'weight'		=> 35000,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result	='';
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract($atts);

		global $post_settings;

		$i						= 1;
		$item_rows				= 5;
		$tax_query				= null;
		$query_category			= ( 'wtr_all_items' == $category ) ? '' :explode(',', $category );

		if( $query_category ){
			$tax_query[]	=  array(
				'taxonomy'			=> 'clients-category',
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
			'post_type' 		=> 'clients',
			'posts_per_page'	=> $limit,
			'tax_query' 		=> $tax_query,
			'orderby'			=> $query_orderby,
			'order'				=> $query_order,

		);

		// The Query
		$the_query = new WP_Query( $query_args );

		if ( $the_query->have_posts() ) {

			$result .= '<div ' . $this->shtAnimateHTML( '', $atts ) . '>';
				if( 'boxed' == $type ){

					$result .= ( $label ) ? '<h1>' . $label . '</h1> <hr style="height:50px;">' : '';
					$result .= '<div class="wtrClientsTable  ' . esc_attr( $el_class ) . ' " > ';
						while ( $the_query->have_posts() ) {
							$the_query->the_post();

							$id					= get_the_id();
							$title				= get_the_title();
							$link				= get_post_meta( $id, '_wtr_clients_link', true );
							$url				= esc_url( $link );
							$post_thumbnail_id	= get_post_thumbnail_id( $id );
							$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_1' );
							$image_alt			= esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) );
							$image				= ( $image_attributes[0] ) ? $image_attributes[0] : $post_settings['wtr_DefalutThumbnail'] ;

							if( $i == 1 ){
								$result .= '<div class="wtrClientsRow ">';
							}
							$i++;

							if( ! empty( $link ) ){

								if( 'yes' == $target ){
									$target_str = 'target="_blank"';
								}else{
									$target_str = '';
								}

								$result .= '<div class="wtrColOneFifth wtrClientItem">';
									$result .= '<div class="wtrClientFix">';
										$result .= '<a href="' . $url . '" class="wtrClientName" ' . $target_str . '>';
											$result .= '<h4>' . $title . '</h4>';
										$result .= '</a>';
										$result .= '<a href="' . $url . '" class="wtrClientUrl" ' . $target_str . '>' . $link . '</a>';
										$result .= '<a href="' . $url . '"  ' . $target_str . '>';
											$result .= '<span class="wtrClientOverlay wtrImgAnimate"></span>';
											$result .= '<img class="wtrFWClientItemImg wtrImgAnimate" src="' . $image . '" alt="' . $image_alt . '">';
										$result .= '</a>';
									$result .= '</div>';
								$result .= '</div>';
							} else {
								$result .= '<div class="wtrColOneFifth wtrClientItem">';
									$result .= '<div class="wtrClientFix">';
										$result .= '<div class="wtrClientName">';
											$result .= '<h4>' . $title . '</h4>';
										$result .= '</div>';
										$result .= '<span class="wtrClientUrl">' . $link . '</span>';
										$result .= '<span class="wtrClientOverlay wtrImgAnimate"></span>';
										$result .= '<img class="wtrFWClientItemImg wtrImgAnimate" src="' . $image . '" alt="' . $image_alt . '">';
									$result .= '</div>';
								$result .= '</div>';
							}


							if( $item_rows <  $i ){
								$result .= '</div>';
								$i = 1;
							}
						}
						if( $i != 1 ) {
							$result .= '</div>';
						}

					$result .= '</div>';


				} else if( 'slider' == $type ){

					$interval = intval( $interval );
					if( 0 >= $interval){
						$interval = 4000;
					}
					$class_html_attr	= 'wtrSht wtrShtClinetsCaruselContainer ' . $version . ' ' . $el_class . ' '. $controls;

					$result .= '<div ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . '>';
						$result .= ( $label ) ? '<h6 class="wtrShtHeadline" >' . $label . '</h6>' : '';
							$result .= '<div data-interval="'. $interval .'" class="wtrClinetsCarusel clearfix">';
							while ( $the_query->have_posts() ) {
								$the_query->the_post();

								if( 'yes' == $target ){
									$target_str = 'target="_blank"';
								}else{
									$target_str = '';
								}

								$id					= get_the_id();
								$title				= get_the_title();
								$link				= get_post_meta( $id, '_wtr_clients_link', true );
								$url				= esc_url( $link );
								$post_thumbnail_id	= get_post_thumbnail_id( $id );
								$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_1' );
								$image_alt			= esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) );
								$image				= ( $image_attributes[0] ) ? $image_attributes[0] : $post_settings['wtr_DefalutThumbnail'] ;

								$result .= '<div>';
									$result .= '<div class="wtrClinetsCaruselItem">';
										if( ! empty( $link ) ){
											$result .= '<a href="' . $url . '" ' . $target_str . '>';
												$result .= '<img class="wtrClinetsCaruselItemImg wtrClientImgAnimation" src="' . $image . '" alt="' . $image_alt . '">';
											$result .= '</a>';
										} else {
											$result .= '<img class="wtrClinetsCaruselItemImg wtrClientImgAnimation" src="' . $image . '" alt="' . $image_alt . '">';
										}
									$result .= '</div>';
								$result .= '</div>';
							}
						$result .= '</div>';
					$result .= '</div>';
				}
			$result .= '</div>';
		}
		return $result;
	}//end Render

}//end VCExtendAddonClients

new VCExtendAddonClients();