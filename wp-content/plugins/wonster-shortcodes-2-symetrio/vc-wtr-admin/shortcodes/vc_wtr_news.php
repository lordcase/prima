<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );

class VCExtendAddonNews extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_news';
	public $fields	= array();

	//===FUNCTIONS
	public function __construct(){

		parent::__construct();

		// We safely integrate with VC with this hook
		add_action( 'init', array( &$this, 'integrateWithVC' ) );

		//Creating a shortcode addon
		add_shortcode( $this->base, array( &$this, 'render' ) );
	}//end __construct


	protected function generateListCategory(){

		$result	= array( __( 'Include all categories', 'wtr_sht_framework' ) => 'wtr_all_items' );
		$all	= get_categories( );

		if(is_array( $all )){
			foreach ( $all as $category ){
				$result[ $category->name ] = esc_attr( $category->slug );
			}
		}
		return $result;
	}// end generateListCategory

	public function integrateWithVC(){
		// Map fields

		$this->fields = array(

			array(
				'param_name'	=> 'alert',
				'heading'		=> '',
				'description'	=> '',
				'type'			=> 'wtr_alert',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_alert_class',
				'dependency' 	=> array(	'element'	=> 'type',
											'value'		=> array( 'boxed' ) ),
				'wtr_attr'		=> array(	'extra_class'	=> '',
											'message'		=> __( '<b>Important!</b> This element  may be used in a page
																<b>only in column 1/1</b>', 'wtr_sht_framework' )
										 ),
			),

			array(
				'param_name'	=> 'type',
				'heading'		=> __( 'Presentation style', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Boxed', 'wtr_sht_framework' )			=> 'boxed',
											__( 'News slider', 'wtr_sht_framework' )	=> 'slider',
											__( 'Timeline', 'wtr_sht_framework' )		=> 'timeline',
											__( 'Fancy list', 'wtr_sht_framework' )		=> 'fancy_list',
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
				'value'			=> array(	__( 'Standard', 'wtr_sht_framework' )	=> 'wtrShtLastNewsListStandard',
											__( 'Light', 'wtr_sht_framework' )		=> 'wtrShtLastNewsListLight',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_version_class',
				'dependency' 	=> array(	'element'	=> 'type',
											'value'		=> array( 'fancy_list' ) )
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
				'param_name'	=> 'count',
				'heading'		=> __( 'Number of news', 'wtr_sht_framework' ),
				'description'	=> __( '<b>Please, use only numeric signs</b>', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> 6,
				'admin_label' 	=> true,
				'class'			=> $this->base . '_count_class'
			),

			array(
				'param_name'	=> 'excerpt_length',
				'heading'		=> __( 'Post excerpt length (signs)', 'wtr_sht_framework' ),
				'description'	=> __( '<b>Please, use only numeric signs</b>', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> 220,
				'admin_label' 	=> false,
				'class'			=> $this->base . '_excerpt_length_class',
				'dependency' 	=> array(	'element'	=> 'type',
											'value'		=> array( 'timeline' ) )
			),

			array(
				'param_name'	=> 'category',
				'heading'		=> __( 'Include categories of news', 'wtr_sht_framework' ),
				'description'	=> __( 'Specify the category of the news ( you can choose more than one ', 'wtr_sht_framework' ),
				'type'			=> 'wtr_multi_select',
				'value'			=> $this->generateListCategory(),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_category_class',
				'wtr_attr'		=> array( 'size' => 6 ),
			),

			array(
				'param_name'	=> 'alert',
				'heading'		=> '',
				'description'	=> '',
				'type'			=> 'wtr_alert',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_alert_class',
				'dependency' 	=> array(	'element'	=> 'type',
											'value'		=> array( 'boxed' ) ),
				'wtr_attr'		=> array(	'extra_class'	=> '',
											'message'		=> __( '<b>Important!</b> You can use only one <b>"News"</b>
																	shortcode with pagination on the one page.
																	Using several elements of this type with enabled
																	pagination may result errors.', 'wtr_sht_framework' )
										 ),
				'dependency' 	=> array(	'element'	=> 'type',
											'value'		=> array( 'timeline', 'fancy_list' ) )
			),

			array(
				'param_name'	=> 'paginate',
				'heading'		=> __( 'Paginate', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Off', 'wtr_sht_framework' )	=> 'off',
											__( 'On', 'wtr_sht_framework' )		=> 'on',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_paginate_class',
				'dependency' 	=> array(	'element'	=> 'type',
											'value'		=> array( 'boxed', 'timeline', 'fancy_list' ) )
			),

			$this->getDefaultVCfield( 'el_class' ),
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );

		vc_map( array(
			'name'			=> __( 'News', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'elements' ],
			'params'		=> $this->fields,
			'weight'		=> 25000,
			)
		);
	}//end integrateWithVC


	public function render( $atts, $content = null ){
		$result	= '';
		$atts	= $this->prepareCorrectShortcode( $this->fields, $atts );
		extract( $atts );

		global $post_settings;

		$i					= 1;
		$item_rows			= 4;
		$query_category		= ( 'wtr_all_items' == $category ) ? '' : $category;
		$page				= ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : get_query_var( 'page' );
		$page				= ( ! $page OR 'no' == $paginate ) ? 1 : $page ;

		$query_args	= array(
			'post_type'			=> 'post',
			'posts_per_page'	=> $count,
			'category_name'		=> $query_category,
			'paged'				=> $page,
		);
		query_posts( $query_args );

		if ( have_posts() ) {

			if( 'boxed' == $type ){

				$result .= '<div class="wtrShtLastNewsMetroStream" >';
				while ( have_posts() ) {
					the_post();

					$id					= get_the_id();
					$post_thumbnail_id	= get_post_thumbnail_id( $id );
					$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_2' );
					$image_alt			= esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) );
					$image				= ( $image_attributes[0] ) ? $image_attributes[0] : $post_settings['wtr_DefalutThumbnail'] ;
					$title				= get_the_title();
					$url				= esc_url( get_permalink() );
					$date				= get_the_time( $post_settings['wtr_BlogDateFormat']['all'] );
					$author				= get_the_author_meta( 'display_name' );
					$author_url			= get_author_posts_url( get_the_author_meta( 'ID' ) );

					if( $i == 1 ){
						$class_html_attr = 'wtrSht wtrShtLastNewsMetro ' . $el_class . ' clearfix';
						$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . ' >';
					}
					$i++;
					$result .= '<article class="wtrColOneFourth wtrShtLastNewsBoxedItem">';
						$result .= '<div class="wtrShtLastNewsBoxedItemHolder">';
							$result .= '<div class="wtrShtLastNewsBoxedDate wtrShtLastNewsMetroAnimation">';
								$result .= '<div>' . $date . '</div>';
							$result .= '</div>';
							$result .= '<a href="' . $url .  '">';
								$result .= '<span class="wtrShtLastNewsBoxedOverlay wtrShtLastNewsMetroAnimation"></span>';
								$result .= '<img class="wtrShtLastNewsBoxedZoom wtrShtLastNewsMetroAnimation" alt="' . $image_alt . '" src="' . $image . '">';
							$result .= '</a>';
							$result .= '<a href="' . $url .  '" >';
								$result .= '<h2 class="wtrShtLastNewsBoxedHedline wtrShtLastNewsMetroAnimation">' . $title . '</h2>';
							$result .= '</a>';
							$result .= '<div class="wtrShtLastNewsBoxedAuthor wtrShtLastNewsMetroAnimation">';
								$result .= $post_settings['wtr_TranslateBlogSHTAuthor'] . ' <a class="" href="' . $author_url .  '"> ' . $author . ' </a>';
							$result .= '</div>';
						$result .= '</div>';
					$result .= '</article>';

					if( $item_rows <  $i ){
						$result .= '</div>';
						$i = 1;
					}
				}

				if( $i != 1 ) {
					$result .= '</div>';
				}

				if( 'on' == $paginate ){
					$result .= wtr_pagination();
				}
				$result .='</div>';

			} else if( 'slider' == $type ){

				$interval = intval( $interval );
				if( 0 >= $interval){
					$interval = 4000;
				}

				$class_html_attr = 'wtrSht wtrShtLastNewsModern clearfix';

				$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . '>';
					$result .= '<div data-interval="'. esc_attr( $interval ) .'" class="wtrShtLastNewsModernCarousel">';
						while ( have_posts() ) {
							the_post();

							$id					= get_the_id();
							$post_thumbnail_id	= get_post_thumbnail_id( $id );
							$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_2' );
							$image_alt			= esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) );
							$image				= ( $image_attributes[0] ) ? $image_attributes[0] : $post_settings['wtr_DefalutThumbnail'] ;
							$title				= get_the_title();
							$url				= esc_url( get_permalink() );
							$date				= get_the_time( $post_settings['wtr_BlogDateFormat']['all'] );
							$author				= get_the_author_meta( 'display_name' );
							$author_url			= get_author_posts_url( get_the_author_meta( 'ID' ) );
							$avatar				= get_avatar( get_the_author_meta( 'ID' ), 100 );
							$avatar				= str_replace("class='avatar", "class='wtrShtLastNewsModernBoxAuthorImg wtrRadius100", $avatar ) ;
							$comments			= wtr_comments_number( 'wtrShtLastNewsModernBoxComments', get_the_id() );

							$result .= '<div>';
								$result .= '<article class="wtrShtLastNewsModern">';
									$result .= '<div class="wtrShtLastNewsModernBox">';
										$result .= '<div>';
											$result .= '<div class="wtrShtLastNewsModernBoxDate wtrShtLastNewsModernBoxAnimation" >';
												$result .= $date;
											$result .= '</div>';
											$result .= '<h2 class="wtrShtLastNewsModernBoxHedaline wtrShtLastNewsModernBoxAnimation"><a href="' . $url . '">' . $title . '</a></h2>';
											$result .= '<div class="wtrShtLastNewsModernBoxOthers wtrShtLastNewsModernBoxAnimation clearfix">';
												$result .= '<div class="wtrShtLastNewsModernBoxOthersContainer clearfix">';
													$result .= '<a href="' . $url . '">' . $avatar . ' </a>';
													$result .= '<div class="wtrShtLastNewsModernBoxAutorContainer">';
														$result .= $post_settings['wtr_TranslateBlogSHTBy'] . ' <a href="' . $author_url . '" class="wtrShtLastNewsModernBoxAuthor">' . $author . '</a>' . $comments;
													$result .= '</div>';
												$result .= '</div>';
											$result .= '</div>';
											$result .= '<a href="' . $url . '">';
												$result .= '<span class="wtrPostOverlay wtrShtLastNewsModernBoxAnimation wtrRadius3"></span>';
												$result .= '<img class="wtrShtLastNewsModernBoxImg wtrRadius3" alt="' . $image_alt . '" src="' . $image . '">';
											$result .= '</a>';
										$result .= '</div>';
									$result .= '</div>';
								$result .= '</article>';
							$result .= '</div>';
						}
					$result .= '</div>';
				$result .= '</div>';

			} else if( 'timeline' == $type ){

				$class_html_attr = 'wtrSht wtrShtLastNewsStandard clearfix';
				$result .= '<div' . $this->shtAnimateHTML( $class_html_attr, $atts ) . '>';
					while ( have_posts() ) {
						the_post();

						$id					= get_the_id();
						$post_thumbnail_id	= get_post_thumbnail_id( $id );
						$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_2' );
						$image_alt			= esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) );
						$image				= ( $image_attributes[0] ) ? $image_attributes[0] : $post_settings['wtr_DefalutThumbnail'] ;
						$title				= get_the_title();
						$url				= esc_url( get_permalink() );
						$date_y				= '<div class="wtrBlogDfDateYear">' . get_the_time( $post_settings['wtr_BlogDateFormat']['date_y'] ) .'</div>';
						$date_m				= '<div class="wtrBlogDfDateMonth">' . get_the_time( $post_settings['wtr_BlogDateFormat']['date_m'] ) .'</div>';
						$date_d				= '<div class="wtrBlogDfDateDay">' . get_the_time( $post_settings['wtr_BlogDateFormat']['date_d'] ) .'</div>';
						$date_settings		= $post_settings['wtr_BlogDateFormat'];
						$date				= wtr_date_format( $date_y, $date_m, $date_d, $date_settings );
						$author				= get_the_author_meta( 'display_name' );
						$author_url			= get_author_posts_url( get_the_author_meta( 'ID' ) );
						$comments			= wtr_comments_number( 'wtrShtLastNewsStandardOtherLink wtrRadius3 wtrAnimate', get_the_id() );
						$excerpt			= wtr_excerpt( ( integer ) $excerpt_length );

						$result .= '<article class="wtrShtLastNewsStandardItem">';
							$result .= '<div class="wtrShtLastNewsStandardContainer">';
								$result .= '<div class="wtrShtLastNewsStandardImgContainer">';
									$result .= '<div class="wtrShtLastNewsStandardBox ">';
										$result .= '<div>';
											$result .= '<div class="wtrShtLastNewsStandardButtonContainer">';
												$result .= '<a href="' . $url . '" style="position: relative; " class="wtrButtonStd green">' . $post_settings['wtr_TranslateBlogSHTReadMore'] . '</a>';
											$result .= '</div>';
											$result .= '<a href="' . $url . '">';
												$result .= '<span class="wtrShtLastNewsStandardElements wtrShtLastNewsStandardAnimation">' . $post_settings['wtr_TranslateBlogSHTReadMore'] . '</span>';
											$result .= '</a>';
											$result .= '<a href="' . $url . '">';
												$result .= '<span class="wtrShtLastNewsStandardOverlay wtrShtLastNewsStandardAnimation wtrRadius3"></span>';
												$result .= '<img class="wtrShtLastNewsStandardImg wtrRadius3" alt="' . $image_alt . '" src="' . $image . '">';
											$result .= '</a>';
										$result .= '</div>';
									$result .= '</div>';
								$result .= '</div>';
								$result .= '<div class="wtrShtLastNewsStandardDate clearfix">';
									$result .= '<div class="wtrShtLastNewsStandardDateCreated" >';
										$result .= $date;
									$result .= '</div>';
								$result .= '</div>';
								$result .= '<header class="wtrBlogPostSneakPeakHeader clearfix" >';
									$result .= '<h2 class="wtrShtLastNewsStandardHeadline"><a class="wtrShtLastNewsStandardHeadlineColor" href="' . $url . '">' . $title . '</a></h2>';
									$result .= '<div class="wtrShtLastNewsStandardOther clearfix" >';
										$result .= $post_settings['wtr_TranslateBlogSHTBy'] . ' <a href="' . $author_url . '" class="wtrShtLastNewsStandardOtherLink wtrRadius3 wtrAnimate">' . $author . '</a>';
										$result .= $comments;
									$result .= '</div>';
									$result .= '<p class="wtrShtLastNewsStandardLead">';
										$result .= $excerpt;
									$result .= '</p>';
								$result .= '</header>';
							$result .= '</div>';
						$result .= '</article>';
					}
					if( 'on' == $paginate ){
						$result .= wtr_pagination();
					}
				$result .= '</div>';

			} else if( 'fancy_list' == $type ){
				$class_html_attr = 'wtrSht wtrShtLastNewsList ' . $version . ' clearfix';
				$result .= '<div ' . $this->shtAnimateHTML( $class_html_attr, $atts ) . '>';
					$result .= '<ul class="wtrShtLastNewsListStream">';
						while ( have_posts() ) {
							the_post();

							$id					= get_the_id();
							$post_thumbnail_id	= get_post_thumbnail_id( $id );
							$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_3' );
							$image_alt			= esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) );
							$image				= ( $image_attributes[0] ) ? $image_attributes[0] : $post_settings['wtr_DefalutThumbnail'] ;
							$title				= get_the_title();
							$url				= esc_url( get_permalink() );
							$date				= get_the_time( $post_settings['wtr_BlogDateFormat']['all'] );
							$author				= get_the_author_meta( 'display_name' );
							$author_url			= get_author_posts_url( get_the_author_meta( 'ID' ) );
							$comments			= get_comments_number( $id );
							$excerpt			= wtr_excerpt( 300 );

							$result .= '<li class="wtrShtLastNewsListStreamItem">';
								$result .= '<article class="wtrShtLastNewsListItem clearfix">';
									$result .= '<a href="' . $url . '" class="wtrShtLastNewsListItemLink" ></a>';
									$result .= '<div class="wtrShtLastNewsListItemHeadline">';
										$result .= '<h2 class="wtrShtLastNewsListItemTitle wtrShtLastNewsListAnimation">';
											$result .= '<a href="' . $url . '">' . $title . '</a>';
										$result .= '</h2>';
										$result .= '<div class="wtrShtLastNewsListItemLead wtrShtLastNewsListAnimation">';
											$result .=  $excerpt;
										$result .= '</div>';
									$result .= '</div>';
									$result .= '<div class="wtrShtLastNewsListItemImg">';
										$result .= '<span class="wtrShtLastNewsListOverlay wtrShtLastNewsListAnimationSec">';
											$result .= '<span class="wtrShtLastNewsListComments">';
												$result .= '<span class="wtrShtLastNewsListCommentsNr">' . $comments . '</span>';
												$result .= '<span class="wtrShtLastNewsListCommentsName">' . $post_settings['wtr_TranslateBlogSHTComments'] . '</span>';
											$result .= '</span>';
										$result .= '</span>';
										$result .= '<img src="' . $image . '" alt="' . $image_alt . '">';
									$result .= '</div>';
									$result .= '<div class="wtrShtLastNewsListItemMeta">';
										$result .= '<div class="wtrShtLastNewsListItemDate">';
											$result .= '<div class="wtrRadius3">' . $date . '</div>';
										$result .= '</div>';
										$result .= '<div class="wtrShtLastNewsListItemAuthor">';
											$result .= '<a href="' . $author_url . '">' . $author . '</a>';
										$result .= '</div>';
									$result .= '</div>';
								$result .= '</article>';
							$result .= '</li>';
					}

				$result .= '</ul>';
				if( 'on' == $paginate ){
					$result .= '' .wtr_pagination();
				}
			$result .= '</div>';

			}
		}
		wp_reset_query();
		return $result;
	}//end Render

}//end VCExtendAddonNews

new VCExtendAddonNews();