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
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'includes/content', 'page' ); ?>
					<?php endwhile; ?>
					<?php get_sidebar();?>
				<?php endif ?>
			</div>
		</div>
	</main>
<?php get_footer(); ?>