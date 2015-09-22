<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class VCExtendAddonInstagramGallery extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_instagram_gallery';
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
				'param_name'	=> 'access_token',
				'heading'		=> __( 'AccessToken', 'wtr_sht_framework' ),
				'description'	=> __( 'If you do not know where to get the data for this field please refer to
										<a target="_blank" href="http://support.wonster.co/manual/symetrio/instagram-manual/" style="font-weight:bold;">this material</a>',
										 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> true,
				'class'			=> $this->base . '_access_token_class',
			),

			array(
				'param_name'	=> 'user_id',
				'heading'		=> __( 'User ID', 'wtr_sht_framework' ),
				'description'	=> __( 'If you do not know where to get the data for this field please refer to
										<a target="_blank" href="http://support.wonster.co/manual/symetrio/instagram-manual/" style="font-weight:bold;">this material</a>',
										'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> true,
				'class'			=> $this->base . '_user_id_class',
			),

			array(
				'param_name'	=> 'item_rows',
				'heading'		=> __( 'Specify number of items in a row', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'One', 'wtr_sht_framework' )	=> 'oneInRow',
											__( 'Two', 'wtr_sht_framework' )	=> 'twoInRow',
											__( 'Three', 'wtr_sht_framework' )	=> 'threeInRow',
											__( 'Four', 'wtr_sht_framework' )	=> 'fourInRow',
											__( 'Five', 'wtr_sht_framework' )	=> 'fiveInRow',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_items_class',
			),

			array(
				'param_name'	=> 'limit',
				'heading'		=> __( 'Limit', 'wtr_sht_framework' ),
				'description'	=> __( 'Maximum value: 20', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '20',
				'admin_label' 	=> true,
				'class'			=> $this->base . '_limit_class',
			),



			$this->getDefaultVCfield( 'el_class' ),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );


		vc_map( array(
			'name'			=> __( 'Instagram Gallery', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'media' ],
			'params'		=> $this->fields,
			'weight'		=> 25850,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result	='';
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract( $atts );

		$instagram_connect	= new InstagramSource( $user_id, $access_token, $limit );
		$images				= $instagram_connect->getData();
		$imagesC			= count( $images );

		if( $imagesC ){
			$result	.= '<div class="wtrSht wtrShtInstagramGallery ' . esc_attr( $el_class ) . ' ' . esc_attr( $item_rows ) . ' clearfix">';
			for( $i = 0; $i < $imagesC; $i++ ){
				$result	.= '<div class="wtrShtInstagramGalleryItem">';
					$result	.= '<div class="wtrShtInstagramGalleryItemPicHolder">';
						$result	.= '<div class="wtrShtInstagramGalleryItemOverlay wtrShtInstagramGalleryAnim">';
							$result	.= '<a target="_blank" href="' . $images[ $i ][ 'url' ] . '" class="wtrShtInstagramGalleryItemLink wtrShtInstagramGalleryAnim">';
								$result	.= '<i class="fa fa-share wtrShtInstagramGalleryAnim"></i>';
							$result	.= '</a>';
							$result	.= '<span class="wtrShtInstagramGalleryItemLikes wtrShtInstagramGalleryAnimSec">';
								$result	.= '<i class="fa fa-heart"></i>';
								$result	.= '<span>' . $images[ $i ][ 'likes' ] . '</span>';
							$result	.= '</span>';
							$result	.= '<span class="wtrShtInstagramGalleryItemComm wtrShtInstagramGalleryAnimSec">';
								$result	.= '<i class="fa fa-comment"></i>';
								$result	.= '<span>' . $images[ $i ][ 'comments' ] . '</span>';
							$result	.= '</span>';
						$result	.= '</div>';
						$result	.= '<img class="wtrShtInstagramGalleryItemPic" src="' . $images[ $i ][ 'img' ] . '" alt="">';
					$result	.= '</div>';
				$result	.= '</div>';
			}
			$result	.= '</div>';
		}else{
			if( '' != $instagram_connect->source_status ){
				echo $instagram_connect->source_status;
			}
		}

		return $result;
	}//end Render

}//end VCExtendAddonInstagramGallery

new VCExtendAddonInstagramGallery();