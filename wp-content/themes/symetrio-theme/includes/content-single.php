<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

global $post_settings; ?>
<?php

$id					= get_the_id();
$url				= get_permalink();
$title				= get_the_title();
$post_thumbnail_id	= get_post_thumbnail_id( $id );
$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_4' );
$image_alt			= get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true );
$image				= ( $image_attributes[0] ) ? '<img class="wtrBlogDfPostHeaderImg wtrRadius3" alt="' . $image_alt . '" src="' . $image_attributes[0] . '">' : '';
$date_y				= '<div class="wtrBlogDfDateYear">' . get_the_time( $post_settings['wtr_BlogDateFormat']['date_y'] ) .'</div>';
$date_m				= '<div class="wtrBlogDfDateMonth">' . get_the_time( $post_settings['wtr_BlogDateFormat']['date_m'] ) .'</div>';
$date_d				= '<div class="wtrBlogDfDateDay">' . get_the_time( $post_settings['wtr_BlogDateFormat']['date_d'] ) .'</div>';
$date_settings		= $post_settings['wtr_BlogDateFormat'];
$date				= wtr_date_format( $date_y, $date_m, $date_d, $date_settings );
$author				= get_the_author_meta( 'display_name' );
$author_url			= get_author_posts_url( get_the_author_meta( 'ID' ) );
$comments			= wtr_comments_number( 'wtrBlogDfPostOtherLink wtrRadius3 wtrAnimate ', $id);
?>

	<div id="post-<?php the_ID(); ?>" <?php post_class( 'wtrContainer wtrContainerColor wtrPost wtrPage' ) ?> >
		<div class="wtrInner clearfix">
			<section class="wtrContentCol <?php echo $post_settings['wtr_ContentInClass']['content']; ?> clearfix">
				<article class="wtrBlogDfPost clearfix">
					<div class="wtrBlogDfPostAssets clearfix">
						<div class="wrtBlogDfPostDate clearfix">
							<div class="wrtBlogDfPostDateCreated">
								<?php echo $date; ?>
							</div>
						</div>
						<?php wtr_post_social_share() ?>
					</div>
					<div class="wtrBlogDfPostContent clearfix">
						<header class="wtrBlogDfPostHeader clearfix" >
							<?php echo $image; ?>
							<h1 class="wtrBlogDfPostHeadline"><?php echo $title; ?></h1>
							<?php wtr_post_category() ?>
							<div class="wtrBlogDfPostOther clearfix" >
								<?php echo $post_settings['wtr_TranslateBlogPostByAuthor'] ?> <a href="<?php echo $author_url; ?>" class="wtrBlogDfPostOtherLink wtrRadius3 wtrAnimate"><?php echo $author; ?></a>
								<?php echo $comments; ?>
							</div>
						</header>
						<div class="wtrPageContent clearfix">
							<?php the_content(); ?>
						</div>
						<?php wtr_wp_link_pages(); ?>
						<?php wtr_post_tags() ?>
					</div>
				</article>
				<?php wtr_related_posts(); ?>
				<?php wtr_draw_post_author(); ?>
				<?php comments_template(); ?>
			</section>
			<?php get_sidebar(); ?>
		</div>
	</div>
