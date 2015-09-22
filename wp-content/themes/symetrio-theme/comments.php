<?php
/**
 * The template for displaying Comments.
 *
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

	global $post_settings;

	$comments_number = get_comments_number();

	if ( post_password_required() OR ( ! comments_open() AND 0 == $comments_number ) ){
		return;
	}

	?>
		<div class="wtrCommentList">
			<div id="comments" class="commentlist " >

				<div class="wtrHeadlineElement big">
					<?php _e( $post_settings['wtr_TranslateHomeCommentsCount'] ); ?>
					<div class="wtrCommentCounter wtrDefBgColor wtrRadius50"><?php  echo $comments_number ?></div>
				</div>
					<?php
						wp_list_comments( array(
							'style'			=> 'div',
							'callback'		=> 'wtr_comments_callback',
							'avatar_size'	=> 64,
							)
						);

					// Are there comments to navigate through?
					if ( get_comment_pages_count() > 1 AND  get_option( 'page_comments' ) ) : ?>
						<nav class="navigation comment-navigation" role="navigation">
							<div class="nav-previous"><?php previous_comments_link( $post_settings['wtr_TranslateHomeOlderComments'] ); ?></div>
							<div class="nav-next"><?php next_comments_link( $post_settings['wtr_TranslateHomeNewerComments'] ); ?></div>
						</nav><!-- .comment-navigation -->
					<?php endif; ?>
			</div>
			<?php wtr_comment_form( ); ?>
		</div>

		<?php if ( ! comments_open() AND $comments_number ) : ?>
			<div class="commentsClosed">
				<span><?php echo $post_settings['wtr_TranslateHomeCommentsAreClosed']; ?> </span>
			</div>
		<?php endif;