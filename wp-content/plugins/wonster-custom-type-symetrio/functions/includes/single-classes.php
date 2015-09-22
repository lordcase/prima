<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

get_header(); ?>
	<main class="wtrMainContent">
		<?php if (have_posts()) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
			<?php

				$background_img		= wp_get_attachment_image_src( $post_settings['wtr_classes_covera_img'], 'size_5' );
				$background_img		= $background_img[0];
				$background_img		= ( $background_img ) ? 'style="background-image: url(\'' . $background_img . '\')"' : '';
				$categories			= get_the_terms( get_the_id(), 'classes-category' );
				$font_color			= $post_settings['wtr_classes_font_color'];
				$bg_color			= $post_settings['wtr_classes_bg_color'];
				$kcal				= $post_settings['wtr_classes_kcal'];
				$duration			= $post_settings['wtr_classes_duration'];
				$lvl				= $post_settings['wtr_classes_lvl'];
				$number				= $post_settings['wtr_classes_number'];
				$title				= get_the_title();
				$PayPalButton		= $post_settings['wtr_PayPalButton'];
				$PayPalPrice		= $post_settings['wtr_PayPalPrice'];
				$PayPalEmail		= $post_settings['wtr_PayPalEmail'];
				$PayPalCurrencyCode	= $post_settings['wtr_PayPalCurrencyCode'];
				$PayPalHtml			= wtr_paypal_button( $PayPalButton, $PayPalPrice, $PayPalEmail, $PayPalCurrencyCode, $title, 'wtrCPPayPalBtnAct wtrRadius3' );

				$trainers			= array();
				$class				= ( 1 != $post_settings['wtr_classes_hide'] ) ? 'wtrColOneTwo' : 'wtrColOne';
				if( ! empty( $post_settings['wtr_classes_trainers'] ) ){
					$args = array(
							'posts_per_page'	=> -1,
							'post_type'			=>'trainer',
							'order'				=> 'DESC',
							'orderby'			=> 'menu_order',
							'post__in'			=> $post_settings['wtr_classes_trainers'],
						);
					$trainers = get_posts( $args );
				}
				?>

					<div class=" wtrClassesHeadline clearfix" <?php echo $background_img; ?>>
						<div class="wtrInner">
							<div class="wtrClassesMeta wtrColThreeFifth">
								<div class="wtrClassesNameHeadlineContainer">
									<h2 class="wtrClassesNameHeadline wtrClassesNameColorHolder wtrRadius3" style="background-color:<?php echo esc_attr( $bg_color ); ?>;color:<?php echo esc_attr( $font_color ); ?>"><?php echo $title; ?></h2>
									<?php echo $PayPalHtml; ?>
									<div class="clearfix"></div>
								</div>
								<?php if( $kcal ) : ?>
									<div class="wtrClassesKcalInfo">
										<i class="fa fa-refresh"></i> <?php echo $kcal . ' ' . $post_settings['wtr_TranslateClassesKcal']  ?>
									</div>
								<?php endif; ?>
							</div>
							<div class="wtrClassesDetails wtrColTwoFifth wtrLastCol clearfix">
								<div class="wtrClassesTime <?php echo $class; ?> clearfix">
									<div class="wtrClassesTimeStopWatch">
										<h6 class="wtrTimeCounter"><?php echo $duration; ?></h6>
										<p class="wtrTimeCounterLead"><?php echo $post_settings['wtr_TranslateClassesMinutes']; ?></p>
									</div>
								</div>
								<?php if( 1 != $post_settings['wtr_classes_hide'] ) : ?>
									<div class="wtrClassesDetailsLevel wtrColOneTwo wtrLastCol">
										<ul class="wtrClassesDifficultMeter wtrRadius100">
											<?php echo str_repeat( '<li class="wtrClassesMeterDot active wtrRadius100"></li>', $lvl ); ?>
											<?php echo str_repeat( '<li class="wtrClassesMeterDot wtrRadius100"></li>', 5 - $lvl ); ?>
										</ul>
										<div class="wtrClassesDifficultMeterInfo clearfix">
											<span class="wtrFloatLeft wtrClassesDifficultLvl"><?php echo $post_settings['wtr_TranslateClassesLevel']; ?></span>
											<span class="wtrFloatRight "><?php echo $post_settings['wtr_TranslateClassesLevel_' . $lvl ]; ?></span>
										</div>
										<div class="wtrClassesParticipantLimit">
											<div class="wtrClassParticipantHeadline"><?php echo $post_settings['wtr_TranslateClassesNumber']; ?></div>
											<div class="wtrClassParticipantNumber wtrRadius2"><?php echo $number; ?></div>
										</div>
									</div>
							<?php endif; ?>
							</div>
						</div>
						<div class="wtrClassesOverlay"></div>
					</div>
					<div class="wtrContainer wtrContainerColor wtrPage ">
						<div class="wtrInner clearfix">
							<section class="wtrContentNoSidebar wtrClassPage clearfix">
								<div class="wtrClassPageContainer clearfix">
									<div class="wtrClassesTrainerInfo clearfix">
										<div class="wtrClassesTrainers wtrColFourFifth clearfix">
											<?php if( $post_settings['wtr_TranslateClassesTrainer'] ) : ?>
												<div class="wtrHeadlineElement big">
													<?php echo $post_settings['wtr_TranslateClassesTrainer'];?>
												</div>
											<?php endif; ?>
											<ul class="wtrClassesTrainerList">
												<?php foreach ( $trainers as $trainer ) : ?>
													<?php
														$trainer_name		= get_post_meta( $trainer->ID, '_wtr_trainer_name', true );
														$trainer_last_name	= get_post_meta( $trainer->ID, '_wtr_trainer_last_name', true ) ;
														$trainer_full_name	= ( $trainer_last_name OR $trainer_name ) ? $trainer_name . ' ' . $trainer_last_name : get_the_title( $trainer->ID );

													?>
													<li class="wtrClassesTrainerItem clearfix">
														<?php if( has_post_thumbnail( $trainer->ID ) ) : ?>
															<?php
																$trainer_thumbnail_id			= get_post_thumbnail_id( $trainer->ID );
																$trainer_thumbnail__attributes	= wp_get_attachment_image_src( $trainer_thumbnail_id, 'thumbnail' );
																$trainer_thumbnail				= $trainer_thumbnail__attributes[0];
																$trainer_thumbnail_alt			= esc_attr( get_post_meta( $trainer_thumbnail_id, '_wp_attachment_image_alt', true ) );
															?>
															<img src="<?php echo $trainer_thumbnail ?>" class="wtrClassesTrainerPicture wtrRadius100" alt="<?php echo $trainer_thumbnail_alt ?>">
														<?php endif; ?>
														<div class="wtrClassesTrainerItemDetails">
															<div class="wtrClassesTrainerItemName"><?php echo $trainer_full_name; ?></div>
															<a href="<?php echo esc_url( get_permalink( $trainer->ID ) ); ?>" class="wtrClassesTrainerItemLink"><?php echo $post_settings['wtr_TranslateClassesTrainerReadMore'];?></a>
														</div>
													</li>
												<?php endforeach; ?>
											</ul>
										</div>
									</div>
									<?php if( $categories ) : ?>
										<div class="wtrClassesCategory wtrBlogPostTags" >
											<ul class="wtrBlogPostTagsList clearfix">
												<?php
													foreach ( $categories as $cateogry ) {
														echo '<li class="wtrBlogPostTagsListItem"><a href="' . esc_url( get_term_link( $cateogry ) ) . '" class="wtrBlogDfPostOtherLink wtrRadius3 wtrAnimate">' . $cateogry->name . '</a></li>';
													}
												?>
											</ul>
										</div>
									<?php endif; ?>
									<div class="wtrPageContent clearfix">
										<?php the_content(); ?>
										<?php wtr_wp_link_pages(); ?>
									</div>
								</div>
							</section>
						</div>
					</div>

			<?php endwhile; ?>
		<?php endif ?>
	</main>
<?php get_footer(); ?>