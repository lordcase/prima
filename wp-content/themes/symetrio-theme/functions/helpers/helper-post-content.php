<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! function_exists( 'wtr_blog_stream' ) ){

	// blog stream
	function wtr_blog_stream() {
		global $post_settings;

		echo '<section class="wtrContentCol ' . $post_settings['wtr_ContentInClass']['content'] . ' wtrBlogStreamStd clearfix">';
			echo '<div class="wtrBlogStreamStdContainer">';
				while ( have_posts() ) {
					the_post();

					$id					= get_the_id();
					$url				= esc_url( get_permalink() );
					$title				= get_the_title();
					$post_thumbnail_id	= get_post_thumbnail_id( $id );
					$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_2' );
					$image_alt			= esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) ) ;
					$image				= ( $image_attributes[0] ) ? '<img class="wtrBlogPostSneakPeakImg wtrRadius3" alt="' . $image_alt . '" src="' . $image_attributes[0] . '">' : '';
					$container_class	= ( $image ) ? '' : 'wtrBlogPostSneakPeakNoImg';
					$date_y				= '<div class="wtrBlogDfDateYear">' . get_the_time( $post_settings['wtr_BlogDateFormat']['date_y'] ) .'</div>';
					$date_m				= '<div class="wtrBlogDfDateMonth">' . get_the_time( $post_settings['wtr_BlogDateFormat']['date_m'] ) .'</div>';
					$date_d				= '<div class="wtrBlogDfDateDay">' . get_the_time( $post_settings['wtr_BlogDateFormat']['date_d'] ) .'</div>';
					$date_settings		= $post_settings['wtr_BlogDateFormat'];
					$date				= wtr_date_format( $date_y, $date_m, $date_d, $date_settings );
					$author				= get_the_author_meta( 'display_name' );
					$author_url			= get_author_posts_url( get_the_author_meta( 'ID' ) );
					$comments			= wtr_comments_number( 'wtrBlogDfPostOtherLink wtrRadius3 wtrAnimate ', $id);
					$post_class			= implode( get_post_class( "wtrBlogPostSneakPeak" ), ' ' );

					echo '<article id="post-' . get_the_ID() . '" class="' . $post_class .'">';
						echo '<div class="wtrBlogPostSneakPeakContainer ' . $container_class . ' ">';
							if( $image ){
								echo '<div class="wtrBlogPostSneakPeakImgContainer">';
									echo '<div class="wtrHoverdPostBox ">';
										echo '<div>';
											echo '<div class="wtrHoverdPostButtonContainer">';
												echo '<a href="' . $url . '" style="position: relative; " class="wtrDefStdButton">' . $post_settings['wtr_TranslateBlogContinueReading'] . '</a>';
											echo '</div>';
											echo '<a href="' . $url . '" >';
												echo '<span class="wtrHoverdPostElements wtrHoverdPostBoxAnimation">' . $post_settings['wtr_TranslateBlogContinueReading'] . '</span>';
											echo '</a>';
											echo '<a href="' . $url . '">';
												echo '<span class="wtrPostOverlay wtrHoverdPostBoxAnimation wtrRadius3"></span>';
												echo $image;
											echo '</a>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
							}

							echo '<div class="wtrBlogPostSneakPeakDate clearfix">';
								echo '<div class="wrtBlogDfPostDateCreated" >';
									echo $date;
								echo '</div>';
							echo '</div>';

							echo '<header class="wtrBlogPostSneakPeakHeader clearfix" >';
								echo '<h2 class="wtrBlogPostSneakPeakHeadline wtrDefHedlineLinkColor"><a class="" href="' . $url . '">' . $title . '</a></h2>';
								if( 1 == $post_settings['wtr_BlogShowMeta'] ){
									echo '<div class="wtrBlogPostSneakPeakOther clearfix" >';
										echo $post_settings['wtr_TranslateBlogByAuthor'] . ' <a href="' . $author_url . '" class="wtrBlogDfPostOtherLink wtrRadius3 wtrAnimate">' . $author . '</a>';
										echo $comments;
										if( is_sticky() ){
											echo '<span class="wtrStickyPost"><i class="fa fa-bookmark"></i>' .$post_settings['wtr_TranslateBlogStickyPosts'] . '</span>';
										}
									echo '</div>';
								}
								echo '<p class="wtrBlogPostSneakPeakLead">';
									echo wtr_excerpt();
								echo '</p>';
							echo '</header>';
						echo '</div>';
					echo '</article>';
				}
			echo '</div>';
			echo wtr_pagination();
		echo '</section>';
	} // end wtr_blog_stream
}


if( ! function_exists( 'wtr_blog_stream_modern' ) ){

	// blog stream modern
	function wtr_blog_stream_modern() {
		global $post_settings, $wp_query;

		echo '<section class="wtrContentCol ' . $post_settings['wtr_ContentInClass']['content'] . ' wtrBlogStreamModern clearfix">';
			echo '<div class="wtrBlogStreamModernContainer clearfix">';
			while ( have_posts() ) {
				the_post();

				$current_id			= ( $wp_query->current_post );
				$row				= $current_id % 2;
				$id					= get_the_id();
				$url				= esc_url( get_permalink() );
				$title				= get_the_title();
				$post_thumbnail_id	= get_post_thumbnail_id( $id );
				$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_2' );
				$image_alt			= esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) );
				$image				= ( $image_attributes[0] ) ? $image_attributes[0] : $post_settings['wtr_DefalutThumbnail'] ;
				$date				= get_the_time( $post_settings['wtr_BlogDateFormat']['all'] );
				$avatar				= get_avatar( get_the_author_meta( 'ID' ), 100 );
				$avatar				= str_replace("class='avatar", "class='wtrBlogPostModernSneakPeakAuthorImg wtrRadius100 avatar", $avatar ) ;
				$author				= get_the_author_meta( 'display_name' );
				$author_url			= get_author_posts_url( get_the_author_meta( 'ID' ) );
				$comments			= wtr_comments_number( 'wtrBlogPostModernSneakPeakComments', $id);
				$post_class			= implode( get_post_class( "wtrBlogModernPostSneakPeak" ), ' ' );


				if( 0 == $row ){
					echo '<div class="wtrBlogModernPostRow clearfix">';
				}
					echo '<article id="post-' . get_the_ID() . '" class="' . $post_class .'">';
						echo '<div class="wtrHoverdModernPostBox ">';
							echo '<div>';
								echo '<div class="wtrBlogPostModernSneakPeakDate wtrHoverdPostBoxAnimation" >';
									echo $date;
								echo '</div>';
								echo '<h2 class="wtrBlogPostModernSneakPeakHeadline wtrHoverdPostBoxAnimation"><a href="' . $url . '">' . $title . '</a></h2>';
								echo '<div class="wtrBlogPostModernSneakPeakOthers wtrHoverdPostBoxAnimation clearfix">';
									echo '<div class="wtrBlogPostModernSneakPeakOtherContainer clearfix">';
										if( 1 == $post_settings['wtr_BlogShowMeta'] ){
											echo '<a href="' . $url . '">' . $avatar . '</a>';
											echo '<div class="wtrBlogPostModernSneakPeakAuthorContainer">';
												echo $post_settings['wtr_TranslateBlogByAuthor'] . ' <a href="' . $author_url . '" class="wtrBlogPostModernSneakPeakAuthor">' . $author . '</a>';
												echo $comments;
												if( is_sticky() ){
													echo '<span class="wtrStickyPost"><i class="fa fa-bookmark"></i></span>';
												}
											echo '</div>';
										}
									echo '</div>';
								echo '</div>';
								echo '<a href="' . $url . '">';
									echo '<span class="wtrPostOverlay wtrHoverdModernPostBoxAnimation wtrRadius3"></span>';
									echo '<img class="wtrBlogPostModernSneakPeakImg wtrRadius3" alt="' . $image_alt . '" src="' . $image . '">';
								echo '</a>';
							echo '</div>';
						echo '</div>';
					echo '</article>';

				if( 1 == $row OR $current_id + 1 == $wp_query->post_count ){
					echo '</div>';
				}
			}
			echo '</div>';
			echo wtr_pagination();
		echo '</section>';
	} // wtr_blog_stream_modern
}


if( ! function_exists( 'wtr_post_social_share' ) ){

	//social share buttons
	function wtr_post_social_share( $class = null ){
		global $post_settings;

		if( 0 == $post_settings['wtr_SocialMediaToolbar'] ){
			return;
		}

		$url			= urlencode( esc_url( get_permalink() ) );
		$socials_share	= array();

		$post_thumbnail_id	= get_post_thumbnail_id( get_the_id() );
		$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id );
		$thumbnail			= $image_attributes[0];


		$socials 		= array(
			'facebook'	=> array(
				'status'=> $post_settings['wtr_SocialsMediaSettFacebook'],
				'link'	=> 'href="http://www.facebook.com/sharer.php?u=' . $url . '&amp;t=' . urlencode( $post_settings['wtr_SeoTitle'] ) . '"  target="_blank" ',
				'js'	=> "onclick=\"javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600' );return false;\" ",
				'icon'	=> '<i class="fa fa-facebook"></i>',
				'class' => 'wtrFacebookShare wtrRadius3 wtrAnimate',
				),
			'google'	=> array(
				'status'=> $post_settings['wtr_SocialsMediaSettGooglePlus'],
				'link'	=> 'href="https://plus.google.com/share?url=' . $url . '"  target="_blank"',
				'js'	=> "onclick=\"javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=350,width=480' );return false;\" ",
				'icon'	=> '<i class="fa fa-google-plus"></i>',
				'class' => 'wtrGoogleShare wtrRadius3 wtrAnimate',
				),
			'twitter'	=> array(
				'status'=> $post_settings['wtr_SocialsMediaSettTwitter'],
				'link'	=>'href="https://twitter.com/share?url=' . $url . '&amp;text=' . urlencode( $post_settings['wtr_SeoTitle'] ) . '"  target="_blank"',
				'js'	=> "onclick=\"javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600' );return false;\" ",
				'icon'	=> '<i class="fa fa-twitter"></i>',
				'class' => 'wtrTwitterShare wtrRadius3 wtrAnimate',
				),
			'tumblr'	=> array(
				'status'=> $post_settings['wtr_SocialsMediaSettTumblr'],
				'link'	=>'href="http://tumblr.com/share?s=&amp;v=3&amp;t=' . urlencode( $post_settings['wtr_SeoTitle'] ) . '&amp;u='. $url . '"  target="_blank"',
				'js'	=> "onclick=\"javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=450,width=600' );return false;\" ",
				'icon'	=> '<i class="fa fa-tumblr"></i>',
				'class' => 'wtrTumblrShare wtrRadius3 wtrAnimate',
				),
			'pinterest'	=> array(
				'status'=> $post_settings['wtr_SocialsMediaSettPinterest'],
				'link'	=>'href="http://pinterest.com/pin/create/button/?url='. $url . '&amp;media='. $thumbnail .'&amp;description=' . urlencode( $post_settings['wtr_SeoTitle'] ) . '"  target="_blank"',
				'js'	=> "onclick=\"javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=320,width=770' );return false;\" ",
				'icon'	=> '<i class="fa fa-pinterest"></i>',
				'class' => 'wtrPinterestShare wtrRadius3 wtrAnimate',
				),

			);
		echo '<div class="wrtBlogDfPostSocialShare ' . $class . 'clearfix">';
			foreach ( $socials as $social ) {
				if( 1 == $social['status'] ) {
					$socials_share[] = $social;
					echo '<a  ' . $social['link'] . '  ' . $social['js'] . ' class="' . $social['class'] . '">';
						echo $social['icon'];
					echo '</a>';
				}
			}
		echo '</div>';
	} // end wtr_post_social_share
}


if( ! function_exists( 'wtr_post_category' ) ){

	//post cateogry
	function wtr_post_category( $class = null ){

		global $post_settings;

		if( 0 == $post_settings['wtr_Categories'] ) {
			return;
		}

		if( has_category() ) {
			echo '<ul class="wtrBlogDfPostCategory ' . $class . ' clearfix">';
				$post_category		= get_the_category();
				$post_category_last	= end( $post_category );

				foreach ( $post_category as $category ) {
					$link = esc_url( get_category_link( $category->cat_ID ) );
					echo '<li class="wtrBlogDfPostCategoryItem">';
						echo '<a href="' . $link .'">' . $category->cat_name . '</a>';
						echo ( $post_category_last->cat_ID != $category->cat_ID ) ? ',': '';
					echo '</li>';
				}
			echo '</ul>';
		}
	} // end wtr_post_category
}


if( ! function_exists( 'wtr_post_tags' ) ){

	//post tags
	function wtr_post_tags(){

		global $post_settings;

		if( 0 == $post_settings['wtr_ShowTags'] ) {
			return;
		}

		$post_tag = get_the_tags();

		if( $post_tag ){
			echo '<div class="wtrBlogPostTags" >';
				echo '<div class="wtrHeadlineElement big">' . $post_settings['wtr_TranslateBlogPostTags'] . '</div>';
					echo '<ul class="wtrBlogPostTagsList clearfix">';
						foreach( $post_tag as $tag ){
							$link = esc_url( get_term_link( $tag, 'post_tag' ) );
							echo '<li class="wtrBlogPostTagsListItem"><a href="' . $link . '" class="wtrBlogDfPostOtherLink wtrRadius3 wtrAnimate">'. $tag->name .'</a></li>';
						}
					echo '</ul>';
			echo '</div>';
		}
	}
}




if( ! function_exists( 'wtr_draw_post_author' ) ){

	// drawing information about the author post
	function wtr_draw_post_author(){

		global $post_settings, $wtr_social_media;

		if( 0 == $post_settings['wtr_ShowAuthorBio'] ) {
			return;
		}

		$avatar			= get_avatar( get_the_author_meta( 'ID' ), 100 );
		$avatar			= str_replace("class='avatar", "class='wtrPostAutorPicture wtrRadius100 avatar", $avatar ) ;
		$description	= get_the_author_meta( 'description' );
		$socials		= get_the_author_meta( 'wtr_social' );


		echo '<div class="wtrPostAuthor wtrRadius3 clearfix">';
			echo '<div class="wtrColOneFifth wtrPostAutorPictureHolder">';
				echo $avatar;
			echo '</div>';
			echo '<div class="wtrColFourFifth wtrLastCol wtrPostAutorDescHolder">';
				echo '<div class="wtrPostAuthorData">';
					echo '<h4 class="wtrPostAuthorName">';
						echo '<span class="wtrDefFontCharacter">' . $post_settings['wtr_TranslateBlogPostAuthor'] . '</span> '. get_the_author_meta( 'display_name' );
						if( is_array( $socials ) ){
							echo '<span class="wtrPostAuthorSocials">';
								foreach ( get_the_author_meta( 'wtr_social' ) as $key => $value) {
									if( isset( $wtr_social_media[ $key ] ) AND ! empty( $value ) ){
										echo '<a class="wtrPostAuthorSocialLink " href="' . esc_url( $value )  . '"><i class="' . esc_attr( $wtr_social_media[ $key ]['icon']) . '"></i> </a>';
									}
								}
							echo '</span>';
						}
					echo '</h4>';
					if( $description ){
						echo '<p class="wtrPostAuthorDesc">' . $description . '</p>';
					}
				echo '</div>';
			echo '</div>';
		echo '</div>';

	} // end wtr_draw_post_autor

}


if( ! function_exists( 'wtr_related_posts' ) ){

	function wtr_related_posts(){

		global $post_settings;
		$related_posts			= $post_settings['wtr_BlogRelatedPosts'];
		$related_posts_by		= $post_settings['wtr_BlogRelatedPostsBy'];
		$related_posts_order_by	= ( 0 ==  $post_settings['wtr_BlogRelatedPostsOrderBy'] ? "date" : "rand");
		$post_not_id[]			= get_the_id();

		if( 0 == $related_posts ){
			return;
		}

		$args = array(
			'post_type' 			=> 'post',
			'order' 				=> 'DESC',
			'orderby' 				=> $related_posts_order_by,
			'post__not_in'			=> $post_not_id,
			'posts_per_page' 		=> 6,
			'ignore_sticky_posts' 	=> 1,
		);


		switch ( $related_posts_by ) {
			case 0:
				$args['tag__in'] = wp_get_post_tags( get_the_id(), array( 'fields' => 'ids' ) );
				break;
			case 1:
				$args['category__in'] = wp_get_post_categories( get_the_id(), array( 'fields' => 'ids' ) );
				break;
			case 2:
				$args['tax_query'] = array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'category',
						'field' => 'id',
						'terms' => wp_get_post_categories( get_the_id(), array( 'fields' => 'ids' ) ),
					),
					array(
						'taxonomy' => 'post_tag',
						'field' => 'id',
						'terms' => wp_get_post_tags( get_the_id(), array( 'fields' => 'ids' ) )
						)
				);
				break;
		}

		// The Query
		$the_query= new WP_Query( $args );
		$recent_posts_id = array();

		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$post_not_id[] 			= get_the_ID();
				$recent_posts_id[] 	= get_the_ID();
			}
		}

		// not related to portfolio - complementing the 4 elements
		if ( 6 != $the_query->post_count ){
			$args = array(
				'post_type' 			=> 'post',
				'order' 				=> 'DESC',
				'orderby' 				=> 'date',
				'post__not_in'			=> $post_not_id,
				'posts_per_page' 		=>  6 - $the_query->post_count,
				'ignore_sticky_posts' 	=> 1,
			);

			// The Query
			$the_query = new WP_Query( $args );

			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$post_not_id[] 			= get_the_ID();
					$recent_posts_id[] 	= get_the_ID();
				}
			}
		}

		/* Restore original Post Data */
		wp_reset_postdata();

		echo '<div class="wtrRelatedPosts clearfix">';
			echo '<div class="wtrHeadlineElement big">' . $post_settings['wtr_TranslateBlogRelatedPosts'] .'</div>';
				echo '<div class="wtrRecentPostRotator">';
				foreach ( $recent_posts_id as $key => $id ) {

					$current_post		= get_post( $id );
					$author_id			= $current_post->post_author;
					$author_name		= get_the_author_meta( 'display_name', $author_id );
					$url				= esc_url( get_permalink( $id ) );
					$title				= get_the_title( $id );
					$date				= get_the_time( $post_settings['wtr_BlogDateFormat']['all'] );
					$post_thumbnail_id	= get_post_thumbnail_id( $id );
					$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_2' );
					$image_alt			= esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) );
					$image				= ( $image_attributes[0] ) ? $image_attributes[0] : $post_settings['wtr_DefalutThumbnail'] ;

					echo '<div>';
						echo '<div class="wtrHoverdNewsBox ">';
							echo '<p class="wtrHoverdNewsBoxPostDate wtrHoverdNewsBoxAnimation">' . $date . '</p>';
							echo '<a href="' . $url . '" >';
								echo '<span class="overlay wtrHoverdNewsBoxAnimation wtrRadius3"></span>';
								echo '<img class="wtrRadius3" alt="" src="' . $image. '">';
							echo '</a>';
							echo '<a href="' . $url . '" >';
								echo '<h3 class="wtrHoverdNewsBoxPostTittle wtrHoverdNewsBoxAnimation">' . $title . '</h3>';
							echo '</a>';
							echo '<div class="wtrHoverdNewsBoxAuthor wtrHoverdNewsBoxAnimation">';
								echo $post_settings['wtr_TranslateBlogRelatedPostsAuthor'] . ' <a class="" href="' . $url . '" title="' . $image_alt . '" >' . $author_name . '</a>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				}
			echo '</div>';
		echo '</div>';

	} // end wtr_related_posts
}