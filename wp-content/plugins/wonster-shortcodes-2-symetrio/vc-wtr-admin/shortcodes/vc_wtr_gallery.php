<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

if ( !defined( 'WTR_CP_PLUGIN_MAIN_FILE' ) ) { return; }

include_once ( 'vc_wtr.php' );

class VCExtendAddonGallery extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_gallery';
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
				'description'	=> __( 'Choose the type of your gallery', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Metro', 'wtr_sht_framework' )			=> 'metro',
											__( 'Flex slider', 'wtr_sht_framework' )	=> 'flex_slider',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_target_class',
			),

			array(
				'param_name'	=> 'id_gallery',
				'heading'		=> __( 'Galleries', 'wtr_sht_framework' ),
				'description'	=> __( 'Select a gallery to be attached to content', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> $this->getWpQuery( array(
										'post_type'			=> 'gallery',
										'wtr_add_all_item'	=> false,
										'wtr_select_item'	=> true
									) ),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_id_gallery_class',
			),

			$this->getDefaultVCfield( 'el_class' ),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );


		vc_map( array(
			'name'			=> __( 'Gallery', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'media' ],
			'params'		=> $this->fields,
			'weight'		=> 29000,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result	='';
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract( $atts );

		if( 'wtr_select_item' == $id_gallery ){
			return $this->draw_alert_info_wrong_data_id_sht( 'gallery' );
		}

		global $post;

		$post = get_post( $id_gallery );
		if( empty( $post ) ){
			return ;
		}

		$id					= $post->ID;
		$gallery_items		= get_post_meta( $id, '_wtr_portfolio_gallery_item', true );

		if( is_array( $gallery_items ) ){
			if( 0 == count( $gallery_items ) ){
				wp_reset_postdata();
				return $result;
			}
		}else if( is_string( $gallery_items ) && 0 == strlen( $gallery_items ) ){
			wp_reset_postdata();
			return $result;
		}

		if( 'metro' == $type ) {

			$class_html_attr = 'wtrSht wtrShtGallery ' . $el_class;

			$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . '>';
				$result .= '<div class="wtrShtGalleryHolder">';
					$result .= '<ul class="wtrShtGalleryItemList gallery wtrShtGalleryInit clearfix">';
						foreach ( $gallery_items as $item ) {

							$key	= ( key ( $item ) );
							$post	= get_post( $key );
							if( ! empty( $post ) ) {

								setup_postdata( $post );
								$title					= get_the_title();
								$desc					= esc_attr( get_the_excerpt() );
								$thumbnail_attributes	= wp_get_attachment_image_src( $key , 'size_2' );
								$thumbnail				= $thumbnail_attributes[0];
								$image_attributes		= wp_get_attachment_image_src( $key , 'full' );
								$image					= $image_attributes[0];
								$image_alt				= esc_attr( get_post_meta( $key, '_wp_attachment_image_alt', true ) );

								$result .= '<li data-title="' . esc_attr( $title ) . '" data-desc="' . esc_attr( $desc ) . '" data-src="' . $image . '" data-thumb="' . esc_attr( $thumbnail ) . '" class="wtrShtGalleryItem wtrColOneFourth">';
									$result .= '<a class="wtrWidgetRecentGalleryOverlay wtrWidgetAnimation" href="">';
										$result .= '<span class="wtrHoveredGalleryItemElements wtrHoverdGalleryItemAnimation"></span>';
									$result .= '</a>';
									$result .= '<a href="">';
										$result .= '<span class="wtrShtGalleryItemOverlay wtrHoverdGalleryItemAnimation "></span>';
										$result .= '<img class="wtrBlogPostModernSneakPeakImg" src="' . $thumbnail . '" alt="' . $image_alt . '">';
									$result .= '</a>';
								$result .= '</li>';
							}
						}
					$result .= '</ul>';
				$result .= '</div>';
			$result .= '</div>';

		} else {
			$class_html_attr = 'wtrSht wtrShtSliderGallery ' . esc_attr( $el_class );

			$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . '>';
				$result .= '<div class="wtrGalleryFlexGallery flexslider">';
					$result .= '<ul class="slides">';
						foreach ( $gallery_items as $item ) {

							$post_thumbnail_id	= key( $item );
							$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_4' );
							$image_alt			= esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) );
							$image				= ( $image_attributes[0] ) ? '<li><img src="' . $image_attributes[0] . '" alt="' . $image_alt . '"></li>'  : '';
							$result .= $image;
						}

					$result .= '</ul>';
				$result .= '</div>';
			$result .= '</div>';
		}
		wp_reset_postdata();
		return $result;
	}//end Render

}//end VCExtendAddonGallery

new VCExtendAddonGallery();