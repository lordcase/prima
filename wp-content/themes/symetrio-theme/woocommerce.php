<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

get_header(); ?>

	<main class="wtrMainContent">
		<div class="wtrContainer wtrContainerColor wtrPost wtrPage">
			<div class="wtrInner clearfix">
				<?php if (have_posts()) : ?>
					<section class="wtrContentCol <?php echo $post_settings['wtr_ContentInClass']['content']; ?> clearfix">
						<div class="wtrPageContent wtrWooCommerce  clearfix">
							<?php woocommerce_content();?>
						</div>
					</section>
					<?php get_sidebar();?>
				<?php endif ?>
			</div>
		</div>
	</main>
<?php get_footer(); ?>
