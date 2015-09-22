<?php
/**
 * global functions
 *
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }


if( ! function_exists( 'wtr_excerpt' ) ){

	// excerpt
	function wtr_excerpt( $length = null, $str =null ){

		if( empty( $length )){
			global $post_settings;
			$length = $post_settings['wtr_BlogExcerptLength'];
		}

		if( empty( $str ) ){
			$str = get_the_excerpt();
		}

		$excerpt = wp_html_excerpt( $str, $length, '...' );

		return $excerpt;
	} // end wtr_excerpt
}


if( ! function_exists( 'wtr_excerpt_length' ) ){

	// the number of characters in the lead
	function wtr_excerpt_length( $length ) {
		return 999;
	} // end wtr_excerpt_length

}
add_filter( 'excerpt_length', 'wtr_excerpt_length', 999 );


if( ! function_exists( 'wtr_option_posts_per_page' ) ){

	// search query - change 'where'
	function wtr_search_posts_where( $where ) {
		global $wpdb;
		$where = str_replace( "AND ( (" . $wpdb->prefix . "postmeta.meta_key = '_wtr_trainer_last_name'", "OR ( (" . $wpdb->prefix . "postmeta.meta_key = '_wtr_trainer_last_name'", $where );
		return $where;
	} // end wtr_search_posts_where
}


if( ! function_exists( 'wtr_option_posts_per_page' ) ){

	// change the amount of posts on the page
	function wtr_option_posts_per_page( $value ) {

		global $post_settings, $WTR_Opt;

		$post_settings['wtr_BlogPostNumber'] = apply_filters( 'wtr_BlogPostNumber', $WTR_Opt->getopt( 'wtr_BlogPostNumber' ) );
		return $post_settings['wtr_BlogPostNumber'];
	} // end wtr_option_posts_per_page
}
add_filter( 'option_posts_per_page', 'wtr_option_posts_per_page' );


if( ! function_exists( 'wtr_search_form' ) ){

	// search form
	function wtr_search_form( $class_input = null, $class_form = null, $button = true, $label = false ){

		global $post_settings;

		$output = '<form role="search" method="get" class="' . $class_form . '" action="' . home_url( '/' ). ' ">';
		if( $label ){
			$output .='<label class="screen-reader-text" ></label>';
		}
		$output .= '<input type="text" name="s" class="' . $class_input . '" value="" placeholder="' . esc_attr( $post_settings['wtr_TranslateSearchNaviFormNewSearch'] ) . '" /> ';
		if( $button ) {
			$output .= '<button class="wtrSearchInputButton wtrRadius2 "> ' . $post_settings['wtr_TranslateSearchNaviFormNewSearchLabel'] . ' </button>';
			$output .= '<span class="wtrSearchCloseBtn wtrRadius2 "><i class="fa fa-times"></i></span>';
		}
		$output = apply_filters( 'wtr_search_form_output', $output );
		$output .= '</form>';

		return $output;
	} // end wtr_search_form
}


if( ! function_exists( 'wtr_comments_number' ) ){

	// counter comments
	function wtr_comments_number( $class = null, $id = null, $type = 'normal' ){

		global $post_settings, $post;

		// adding anchor
		if( 1 == $post_settings['wtr_disqus_status'] ){

			$url = get_permalink( $id );
			if( substr( $url , -1) == '/' ) {
				$url = substr($url, 0, -1);
			}

			$url .= '#disqus_thread';

		} else {
			$url = get_comments_link( $id );
		}
		$url = esc_url( $url );

		if( 'normal' == $type ){
			$output = '<a class="' . $class . '" href="' . $url . '"><i class="fa fa-comments"></i>' . get_comments_number( $id ) .'</a>';
		} else if(  'search' == $type ){
			$output = '<a class="' . $class . '" href="' . $url . '">' . get_comments_number( $id ) .' ' . $post_settings['wtr_TranslateSearchFormSearchComment'] . '</a>';
		}
		return $output;
	} // end wtr_comments_number
}


if( ! function_exists( 'wtr_pagination' ) ){

	// drawing pagination
	function wtr_pagination( $pages = '' ,  $range = 3 ){


		global $post_settings, $paged;
		$output		= '';
		$showitems	= ( $range * 2 ) + 1;

		if( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif( get_query_var( 'page' ) ) {
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}

		if( $pages == '' ){
			global $wp_query;
			$pages = $wp_query->max_num_pages;

			if(!$pages) {
				$pages = 1;
			}
		}

		if(1 != $pages){
			$output .= '<div class="wtrPagination clearfix" >';
				$output .= '<ul class="wtrPaginationList clearfix">';
				if( $paged > 1 AND 1 ==  $post_settings['wtr_GlobalPagineArrows'] ) {
					$output .= '<li class="wtrPagiPrev">';
					$output .= str_replace( '<a', '<a class="wtrPagiLink wtrAnimate wtrRadius3"', get_previous_posts_link( 'Prev' ) );
					$output .= '</li>';
				}
				for ($i=1; $i <= $pages; $i++) {
					$class_active = '';
					if (1 != $pages AND  ( !( $i >= $paged + $range + 1 OR  $i <= $paged - $range - 1 ) ) ) {
						if( $paged == $i ) {
							$class_active = 'active';
						}
						$output .= "<li class='wtrPagiNumber' ><a class='wtrPagiLink wtrAnimate wtrRadius3 " . $class_active . "' href='" . esc_url( get_pagenum_link( $i ) ) . "' >" . $i . "</a></li>\n";
					}
				}

				if ( $paged < $pages AND 1 ==  $post_settings['wtr_GlobalPagineArrows'] ) {
					$output .= '<li class="wtrPagiNext">';
					$output .= str_replace( '<a', '<a class="wtrPagiLink wtrAnimate wtrRadius3"', get_next_posts_link( 'Next' ) );
					$output .='</li>';
				}

				$output .= "</ul>";
			$output .= "</div>";
		}
		return $output;
	} // end wtr_pagination
}

if( ! function_exists( 'wtr_wp_link_pages_link' ) ){

	function wtr_wp_link_pages_link( $link, $i){

		global $page;

		if( $page !== $i ){
			$link = str_replace( '<a', '<a class="wtrPagiLink wtrAnimate wtrRadius3 "', $link) ;
			$link = '<li class="pagiNumber" >'.$link.'</li> ';
		}else {
			$link = '<li class="pagiNumber" ><a class="wtrPagiLink wtrAnimate wtrRadius3 active">'.$link.'</a></li> ';
		}
		return $link;
	} // end wtr_wp_link_pages_link
}
add_filter( 'wp_link_pages_link', 'wtr_wp_link_pages_link', 10, 2 );


if( ! function_exists( 'wtr_wp_link_pages' ) ){

	function wtr_wp_link_pages(){
			$args = array(
			'before'			=> '<ul class="wtrPaginationList clearfix">',
			'after'				=> '</ul>',
			'link_before'		=> '',
			'link_after'		=> '',
			'next_or_number'	=> 'number',
			'separator'			=> '',
			'pagelink'			=> '%',
			'echo'				=> 0
		);
		$wp_link_pages = wp_link_pages( $args );
		if ( $wp_link_pages ) {
			echo '<div class="wtrPagination wtrPostPagination clearfix">';
				echo $wp_link_pages;
			echo '</div>';
		}

	} // end wtr_wp_link_pages
}


if( ! function_exists( 'wtr_template_chooser' ) ){

	// loading templates
	function wtr_template_chooser( $template ){

		// display forms for administration password
		if( is_singular() AND post_password_required() ) {
			$template = locate_template('password_required_form.php');
		}
		return $template;
	}// end wtr_template_chooser
}
add_filter('template_include', 'wtr_template_chooser');


if( ! function_exists( 'wtr_redirect' ) ){

	// redirect to another page
	function wtr_redirect() {

		global $post_settings;

		// load 404 as a page with settings
		if( is_404() ) {
			$page_404 = apply_filters( 'wtr_page_404', $post_settings['wtr_Global404Page'] );

			if( 'publish' == get_post_status ( $page_404 ) ) {
				wp_redirect( get_permalink( $page_404 ) );
			}
		}

	} // end wtr_redirect
}
add_action( 'template_redirect', 'wtr_redirect' );


if( ! function_exists( 'wtr_comment_form' ) ){

	// comment form
	function wtr_comment_form(){
		global $post_settings;

		$commenter 	= wp_get_current_commenter();
		$req 		= get_option( 'require_name_email' );
		$aria_req 	= ( $req ? '*': '' );

		$fields =  array(
			'author'	=> '<p class="comment-form-author"><input type="text" aria-required="true" size="30" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="' .  esc_attr( $post_settings['wtr_TranslateCommentFormName'] ) . ' ' . $aria_req .' " name="author" id="author"><i class="icon-user"></i></p>',
			'email'		=> '<p class="comment-form-email"><input type="text" aria-required="true" size="30" value="' . esc_attr( $commenter['comment_author_email'] ) . '" placeholder="'. esc_attr( $post_settings['wtr_TranslateCommentFormEmail'] ) . ' ' . $aria_req .' " name="email" id="email"><i class="icon-envelope"></i></p>',
			'url'		=> '<p class="comment-form-url"><input type="text" size="30" value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="'. esc_attr( $post_settings['wtr_TranslateCommentFormUrl'] ) . '" name="url" id="url"><i class="icon-link"></i></p>',
		);


		$comments_args = array(
			'id_form'				=> 'wtr_form_comments',
			'class_form'			=> 'commentform',
			'id_submit'				=> 'submit',
			'title_reply'			=> $post_settings['wtr_TranslateCommentFormtitleReply'],
			'title_reply_to'		=> $post_settings['wtr_TranslateCommentFormtitleReplyTo'],
			'cancel_reply_link'		=> $post_settings['wtr_TranslateCommentFormcancelReplyLink'],
			'label_submit'			=> $post_settings['wtr_TranslateCommentFormlabelSubmit'],
			'comment_notes_after'	=> '',
			'comment_notes_before'	=> '',
			'fields' 				=> apply_filters( 'comment_form_default_fields', $fields),
			'comment_field' 		=> '',
		);

	?>
	<?php if( comments_open() ) : ?>
		<?php comment_form( $comments_args );?>
	<?php endif ?>
	<?php
	} // end wtr_comment_form
}


if( ! function_exists( 'wtr_comments_callback' ) ){

	// function responsible for drawing comments
	function wtr_comments_callback( $comment, $args, $depth ) {
		global $post_settings;
		$GLOBALS['comment'] = $comment;

		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
?>
		<<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
		<?php endif; ?>
		<div class="comment-author vcard">
			<?php if ( 0 != $args['avatar_size'] ) { echo get_avatar( $comment, $args['avatar_size'] ); } ?>
		</div>
		<?php printf( __( '<cite class="fn">%s</cite>' ), get_comment_author_link() ); ?>

		<?php if ( '0' == $comment->comment_approved ) : ?>
		<em class="comment-awaiting-moderation"><?php echo $post_settings['wtr_TranslateHomeCommentsmMderation'] ?></em>
		<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><span class="comment-date">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', WTR_THEME_NAME ), get_comment_date(),  get_comment_time() ); ?>
				</span>
				<?php edit_comment_link( __( '(Edit)', 'wtr_framework' ), '&nbsp;&nbsp;', '' );
			?>
		</div>
		<div class="comment-content">
			<?php comment_text( get_comment_id() ); ?>
		</div>
		<div class="reply">
			<?php
			$reply_link = get_comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
			$reply_link =str_replace( "class='comment-reply-link'" , "class='comment-reply-login wtrAnimate wtrRadius3'", $reply_link );
			echo $reply_link;
			?>
		</div>
		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; ?>
<?php
	} // end wtr_comments_callback
}


if( ! function_exists( 'wtr_comment_form_add_textarea' ) ) {

	// move textarea to top
	function wtr_comment_form_add_textarea(){
		global $post_settings;
		echo '<p class="comment-form-comment"><textarea aria-required="true" rows="2" placeholder="' . esc_attr( $post_settings['wtr_TranslateCommentFormComment'] ) .'" name="comment" id="comment"></textarea></p>';
	} // end wtr_comment_form_add_textarea
}
add_action( 'comment_form_top', 'wtr_comment_form_add_textarea' );


if( ! function_exists( 'wtr_footer_script' ) ){

	function wtr_footer_script(){
		global $post_settings, $wtr_post_type;
		$background_imgs		= ( 'page' == $wtr_post_type ) ? $post_settings['wtr_BackgroundImg'] : array();
		$images					= array();

		if( $background_imgs ){
			foreach ( $background_imgs as $img_key => $img ) {
				$id					= key( $img );
				$image_attributes	= wp_get_attachment_image_src( $id, 'full' );
				$images[]			= ( $image_attributes[0] ) ? '"' . $image_attributes[0] . '"' : '';
			}
		}
		$wtr_background_switcher_data = ( $images ) ? implode( array_filter( $images ), ', ' ) : '';
		echo '<script type="text/javascript">var wtr_background_switcher_data = [' . $wtr_background_switcher_data . '];</script>';

	} // end wtr_gooogle_maps_param

}
add_action( 'wp_footer', 'wtr_footer_script');


if( ! function_exists( 'wtr_paypal_price' ) ) {

	function wtr_paypal_price( $price ){

		$price = str_replace( ',', '.', $price );
		$price = number_format(  floatval( $price ), 2, '.', '');
		return $price;
	} // end wtr_paypal_price

}


if( ! function_exists( 'wtr_paypal_button' ) ) {

	function wtr_paypal_button( $button, $price, $email, $currencyCode, $name,  $class = '' ){

		global $post_settings;

		$output ='';
		if( 1 == $post_settings['wtr_PayPalGlobalStatus'] AND 1 ==  $button ){
			$output .= '<a class="' . $class . ' paypalTrigger">';
				$output .= '<i class="fa fa-paypal"></i>' . $post_settings['wtr_TranslateHomePayPal'] ;
			$output .= '</a>';
			$output .= wtr_paypal_form( $price, $email, $currencyCode, $name, 'paypalFunction' );
		}

		return $output;
	} // end wtr_paypal_button

}


if( ! function_exists( 'wtr_paypal_form' ) ) {

	function wtr_paypal_form( $price, $email, $currencyCode, $name,  $class = 'paypalFunction' ){

		$price			= esc_attr( wtr_paypal_price(  $price ) );
		$currencyCode	= esc_attr( $currencyCode );
		$name			= esc_attr( $name );
		$email			= esc_attr( $email );

		$output ='<form class="' . $class . '" name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">';
			$output .='<input type="hidden" name="cmd" value="_xclick">';
			$output .='<input type="hidden" name="business" value="' . $email . '">';
			$output .='<input type="hidden" name="currency_code" value="' . $currencyCode . '">';
			$output .='<input type="hidden" name="item_name" value="' . $name . '">';
			$output .='<input type="hidden" name="amount" value="' . $price . '">';
		$output .='</form>';

		return $output;
	} // end wtr_paypal_form

}


if( ! function_exists( 'wtr_date_format' ) ) {

	function wtr_date_format( $yeat, $month, $day, $settings){

		$order		= $settings['order'];
		$output		= $order;
		$output		= str_replace('[y]', $yeat, $output);
		$output		= str_replace('[m]', $month, $output);
		$output		= str_replace('[d]', $day, $output);

		return $output;
	} // end wtr_date_format

}