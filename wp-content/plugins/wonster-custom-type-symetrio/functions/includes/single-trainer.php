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
					<?php
						$post_thumbnail_id	= get_post_thumbnail_id( get_the_id() );
						$image_attributes	= wp_get_attachment_image_src( $post_thumbnail_id, 'size_2' );
						$image_alt			= esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) );
						$img				= ( $image_attributes[0] ) ? '<img src="' . $image_attributes[0]  . '" class="wtrTrainerPagePicture wtrRadius200" alt="' . $image_alt . '">' : '';
						$class				= ( $img ) ? '' : 'wtrTrainerPageCoverNoTrainerPhoto';
						$background_img		= wp_get_attachment_image_src( $post_settings['wtr_trainer_background_img'], 'size_4' );
						$background_img		= $background_img[0];
						$background_img		= ( $background_img ) ? 'style="background-image: url(\'' . $background_img . '\')"' : '';
						$name				= $post_settings['wtr_trainer_name'];
						$last_name			= $post_settings['wtr_trainer_last_name'];
						$functions			= get_the_terms( get_the_id(), 'trainer-function' );
						$functionsAll		= array();
						if( $functions ){
							foreach ( (array) $functions as $function ) {
								$functionsAll[] = $function->name;
							}
						}
						$functionsAllstr = implode( $functionsAll, ', ' );
						?>
						<section class="wtrContentCol <?php echo $post_settings['wtr_ContentInClass']['content']; ?> wtrTrainerPage clearfix">
							<div class="wtrTrainerPageContainer clearfix">
								<div class="wtrTrainerPageDesc <?php echo $class; ?>">
									<div class="wtrTrainerPageCover" <?php echo $background_img; ?> >
										<?php echo $img; ?>
										<div class="wtrTrainerPageMeta">
											<div class="wtrTrainerPageTrainerData">
												<?php if( $name ) : ?>
												<h2 class="wtrTrainerPageTrainerName"><?php echo $name; ?></h2>
												<?php endif; ?>
												<?php if( $last_name ) : ?>
													<h2 class="wtrTrainerPageTrainerSurname"><?php echo $last_name; ?></h2>
												<?php endif; ?>
											</div>
											<?php if( $functionsAllstr ) : ?>
												<div class="wtrTrainerPageTrainerFunction">
													<?php echo $functionsAllstr; ?>
												</div>
											<?php endif; ?>


											<ul class="wtrTrainerPageTrainerSocialLinks">
											<?php
												foreach ( $wtr_social_media as $key => $value) {
													$trainer_social = 'wtr_trainer_' . str_replace( 'wtr_SocialMedia', '', $key );
													if( ! empty( $post_settings[ $trainer_social ] ) ){
														echo ' <li>
																<a target="_blank" href="' . esc_url( $post_settings[ $trainer_social ] ) . '" class="wtrRadius2 wtrAnimate">
																	<i class="' . $value['icon'] .'"></i>
																</a>
															</li>
														';
													}
												}
											?>
											</ul>
										</div>
										<div class="wtrTrainerPageCoverOverlay"></div>
									</div>
									<div class="wtrPageContent clearfix">
										<?php the_content(); ?>
										<?php wtr_wp_link_pages(); ?>
									</div>
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