<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

get_header(); ?>
	<main class="wtrMainContent <?php echo $post_settings['wtr_ContentInClass']['main'] ?>">
		<div class="wtrContainer wtrContainerColor wtrPost wtrPage ">
			<div class="wtrInner clearfix">
				<?php
					if ( have_posts()) {
						if ( 0 == $post_settings['wtr_BlogStreamStyle'] ) {
							wtr_blog_stream();
						} else {
							wtr_blog_stream_modern();
						}
						get_sidebar();
					}
				?>
			</div>
		</div>
	</main>
<?php get_footer(); ?>