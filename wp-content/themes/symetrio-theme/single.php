<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

get_header(); ?>
	<main class="wtrMainContent <?php echo $post_settings['wtr_ContentInClass']['main'] ?>">
		<?php
			if ( have_posts() ) {

				while ( have_posts() ){

					the_post();

					if ( 0 == $post_settings['wtr_BlogSingleStyle'] ) {
						get_template_part( 'includes/content', 'single' );
					} else {
						get_template_part( 'includes/content', 'single-modern' );
					}
				}
			}
		?>
	</main>
<?php get_footer(); ?>