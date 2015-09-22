<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

get_header(); ?>

	<main class="wtrMainContent">
		<div class="wtrContainer wtrContainerColor wtrPost wtrPage ">
			<div class="wtrInner clearfix">
				<?php if (have_posts()) : ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<section class="wtrContentCol <?php echo $post_settings['wtr_ContentInClass']['content']; ?> wtrRoomPage clearfix">
							<div class="wtrRoomPageContainer clearfix">
								<div class="wtrPageContent clearfix">
									<?php the_content(); ?>
									<?php wtr_wp_link_pages(); ?>
								</div>
							</div>
						</section>
					<?php endwhile; ?>
					<?php get_sidebar();?>
				<?php endif ?>
			</div>
		</div>
	</main>
<?php get_footer(); ?>