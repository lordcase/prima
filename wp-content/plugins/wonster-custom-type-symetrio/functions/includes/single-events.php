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
				$id					= get_the_id();
				$title				= get_the_title();
				$thumbnail			= wp_get_attachment_image_src( $post_settings['wtr_event_covera_img'], 'size_5' );
				$thumbnail			= $thumbnail[0];
				$style				= ( $thumbnail ) ? 'style="background-image: url(\'' . $thumbnail . '\')"' : '';
				$number				= $post_settings['wtr_event_number'];
				$sign_up			= $post_settings['wtr_event_sign_up'];
				$date_format		= $post_settings['wtr_EventDateFormat'];
				$time_start			= $post_settings['wtr_event_time_start'];
				$time_start_type	= $post_settings['wtr_event_time_start_type'];
				$time_start_type	= ( 0 == $time_start_type ) ? '' : '<span>'. date( 'a', $time_start ) . '</span>';
				$time_start_h_type	= ( $time_start_type ) ? 'h' : 'H';
				$time_start_h_m		= date( $time_start_h_type . ':i', $time_start );
				$time_end			= $post_settings['wtr_event_time_end'];
				$time_end_type		= $post_settings['wtr_event_time_end_type'];
				$time_end_type		= ( 0 == $time_end_type ) ? '' : '<span>'. date( 'a', $time_end ) . '</span>';
				$time_end_h_type	= ( $time_end_type ) ? 'h' : 'H';
				$time_end_h_m		= date( $time_end_h_type . ':i', $time_end );
				$date				= date_i18n( $date_format['all'] , $time_start );
				$price				= $post_settings['wtr_event_price'];
				$fb					= $post_settings['wtr_event_fb'];
				$location_id		= $post_settings['wtr_event_location'];
				$organizer_id		= $post_settings['wtr_event_organizer'];
				$google_calendar	= $post_settings['wtr_event_google_calendar'];
				$category			= get_the_term_list( $id, 'events-category', '<li class="wtrEventEntryCategoryItem">', ', ','</li>');
				$PayPalButton		= $post_settings['wtr_PayPalButton'];
				$PayPalPrice		= $post_settings['wtr_PayPalPrice'];
				$PayPalEmail		= $post_settings['wtr_PayPalEmail'];
				$PayPalCurrencyCode	= $post_settings['wtr_PayPalCurrencyCode'];
				$PayPalHtml			= wtr_paypal_button( $PayPalButton, $PayPalPrice, $PayPalEmail, $PayPalCurrencyCode, $title, 'wtrEPPayPalBtnAct' );

				if( 0 !=  $location_id ){
					$location_title					= get_the_title( $location_id );
					$location_address				= get_post_meta( $location_id, '_wtr_events_locations_address', true );
					$location_email					= get_post_meta( $location_id, '_wtr_events_locations_email', true );
					$location_url					= get_post_meta( $location_id, '_wtr_events_locations_url', true );
					$location_phone					= get_post_meta( $location_id, '_wtr_events_locations_phone', true );

					$location_map_google			= str_replace('|', ',', get_post_meta( $location_id, '_wtr_events_locations_google', true ) );
					$location_map_type				= get_post_meta( $location_id, '_wtr_events_locations_type', true );
					$location_map_map_style			= get_post_meta( $location_id, '_wtr_events_locations_map_style', true );
					$location_map_zoom				= get_post_meta( $location_id, '_wtr_events_locations_zoom', true );
					$location_map_scroll			= get_post_meta( $location_id, '_wtr_events_locations_scroll', true );
					$location_map_marker_style		= get_post_meta( $location_id, '_wtr_events_locations_marker_style', true );

				}

				if( 0 != $organizer_id ){
					$organizer_title				= get_the_title( $organizer_id );
					$organizer_address				= get_post_meta( $organizer_id, '_wtr_events_organizers_address', true );
					$organizer_email				= get_post_meta( $organizer_id, '_wtr_events_organizers_email', true );
					$organizer_url					= get_post_meta( $organizer_id, '_wtr_events_organizers_url', true );
					$organizer_phone				= get_post_meta( $organizer_id, '_wtr_events_organizers_phone', true );
				}

				if( 1 == $google_calendar ){
					$google_calendar_location		= ( isset( $location_map_google ) ) ? $location_map_google : '';
					$google_dates					= date("Ymd\\THi00", $time_start ) . '/' . date("Ymd\\THi00", $time_end );
					$google_calendar_url			= esc_url( 'https://www.google.com/calendar/render?action=TEMPLATE&text=' . urlencode( $title ) . '&location=' . $google_calendar_location . '&dates=' . $google_dates . '&pli=1' );
				}

				?>
					<div class=" wtrEventEntryHeadline clearfix" <?php echo $style; ?> >
						<div class="wtrInner">
							<div class="wtrEventEntryMeta wtrColTwoThird clearfix">
								<div class="wtrEventEntryContainer clearfix">
									<div class="wtrEventEntryHeadlineContainer clearfix wtrRadius3">
										<h2 class="wtrEventEntryTitle"><?php echo $title; ?></h2>
									</div>
									<div class="wtrEventEntryMetaContainer wtrRadius3">
										<ul class="wtrEventEntryMetaList clearfix">
											<li>
												<div class="wtrEventEntryMetaDate">
													<i class="fa fa-clock-o"></i>
													<span><?php echo $date; ?></span>
												</div>
											</li>
											<li>
												<div class="wtrEventEntryMetaTime">
													<?php echo $time_start_h_m . ' ' . $time_start_type; ?> - <?php echo $time_end_h_m . ' ' . $time_end_type; ?>
												</div>
											</li>
											<?php if( $price OR $PayPalHtml ) : ?>
												<li>
													<div class="wtrEventEntryPrice wtrRadius2"><?php echo $price .  $PayPalHtml; ?></div>
												</li>
											<?php endif; ?>
											<li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="wtrEventEntryOverlay"></div>
					</div>

					<div class="wtrContainer wtrContainerColor wtrPage">
						<div class="wtrInner clearfix">
							<section class="wtrContentNoSidebar wtrEventEntryPage clearfix">
								<div class="wtrEventEntryPageContainer wtrColThreeFourth clearfix">
									<div class="wtrEventEntryAdditionalMeta clearfix">
										<div class="wtrEventEntryMetaSocialBtns clearfix">
											<?php if( $google_calendar ) : ?>
												<a target="_blank" href="<?php echo $google_calendar_url; ?>" class="wtrEventEntryMetaGoogle"><i class="fa fa-google"></i> </a>
											<?php endif;?>
											<?php if( $fb ) : ?>
												<a href="<?php echo esc_url( $fb ); ?>" class="wtrEventEntryMetaFacebook"><i class="fa fa-facebook"></i> </a>
											<?php endif;?>
										</div>
										<?php if( $category ) : ?>
											<ul class="wtrEventEntryCategory clearfix">
												<li class="wtrEventEntryCategoryItemHeadline wrtAltFontCharacter"><?php echo $post_settings['wtr_TranslateEventSingleCategory']; ?></li>
												<?php echo $category; ?>
											</ul>
										<?php endif; ?>
									</div>
									<div class="wtrPageContent clearfix">
										<?php the_content(); ?>
										<?php wtr_wp_link_pages(); ?>
									</div>
								</div>
								<div class="wtrEventEntryPageSidebar wtrRadius3 wtrColOneFourth wtrLastCol clearfix">
									<?php if( $location_id ) : ?>
										<div class="wtrEventEntryPageMapConteiner">
											<div id="event_google_maps" class="wtrEventEntryPageMap" data-marker="<?php echo esc_attr( $location_map_google ); ?>" data-type="<?php echo esc_attr( $location_map_type ); ?>" data-style="<?php echo esc_attr( $location_map_map_style ); ?>" data-zoom="<?php echo esc_attr( $location_map_zoom ); ?>" data-scroll="<?php echo esc_attr( $location_map_scroll ); ?>" data-marker-style="<?php echo esc_attr( $location_map_marker_style ); ?>"></div>
										</div>
										<div class="wtrEventEntryDetails">
											<h4 class="wtrEventEntryDetailsHeadline"><?php echo $post_settings['wtr_TranslateEventSingleVenue']; ?></h4>
											<div class="wtrEventEntryDetailsDesc ">
												<p class="wtrVeOrName"><strong><?php echo $location_title; ?></strong></p>
												<p class="wtrVeOrAdress"><?php echo $location_address; ?></p>
												<div class="wtrVeOrContact">
													<?php if( $location_phone ) : ?>
														<p class="wtrVeOrPhone"><?php echo $post_settings['wtr_TranslateEventSingleVenuePhone']; ?> <?php echo $location_phone; ?></p>
													<?php endif; ?>
													<?php if( $location_email ) : ?>
														<p class="wtrVeOrEmail"><a class="wtrDefaultLinkColor" href="mailto:<?php echo esc_attr( $location_email ); ?>"><?php echo $location_email; ?></a></p>
													<?php endif; ?>
													<?php if( $location_url ) : ?>
														<p class="wtrVeOrWeb"><a class="wtrDefaultLinkColor" href="<?php echo esc_url( $location_url ) ; ?>"><?php echo $location_url; ?></a></p>
													<?php endif; ?>
												</div>
											</div>
										</div>
									<?php endif; ?>
									<?php if( $organizer_id ) : ?>
										<div class="wtrEventEntryDetails">
											<h4 class="wtrEventEntryDetailsHeadline"><?php echo $post_settings['wtr_TranslateEventSingleOrgaznizer']; ?></h4>
											<div class="wtrEventEntryDetailsDesc ">
												<p class="wtrVeOrName"><strong><?php echo $organizer_title; ?></strong></p>
												<p class="wtrVeOrAdress"><?php echo $organizer_address; ?></p>
												<div class="wtrVeOrContact">
													<?php if( $organizer_phone ) : ?>
														<p class="wtrVeOrPhone"><?php echo $post_settings['wtr_TranslateEventSingleOrgaznizerPhone']; ?> <?php echo $organizer_phone; ?></p>
													<?php endif; ?>
													<?php if( $organizer_email ) : ?>
														<p class="wtrVeOrEmail"><a class="wtrDefaultLinkColor" href="mailto:<?php echo esc_attr( $organizer_email ); ?>"><?php echo $organizer_email; ?></a></p>
													<?php endif; ?>
													<?php if( $organizer_url ) : ?>
														<p class="wtrVeOrWeb"><a class="wtrDefaultLinkColor" href="<?php echo esc_url( $organizer_url ) ; ?>"><?php echo $organizer_url; ?></a></p>
													<?php endif; ?>
												</div>
											</div>
										</div>
									<?php endif; ?>
									<?php if( $number OR $sign_up ) : ?>
										<div class=" wtrEventEntryDetails ">
											<h4 class="wtrEventEntryDetailsHeadline"><?php echo $post_settings['wtr_TranslateEventSingleDetails']; ?></h4>
											<ul class="wtrEventMoreDetail clearfix">
												<?php if( $sign_up ) : ?>
													<li class="wtrEventMoreDetailRow">
														<div class="wtrEventMoreDetailHeadline"><?php echo $post_settings['wtr_TranslateEventSingleSignUps']; ?></div>
														<div><?php echo $sign_up; ?></div>
													</li>
												<?php endif; ?>
												<?php if( $number ) : ?>
													<li class="wtrEventMoreDetailRow">
														<div class="wtrEventMoreDetailHeadline"><?php echo $post_settings['wtr_TranslateEventSingleLimits']; ?></div>
														<div>
															<?php echo $number; ?>
															<?php echo $post_settings['wtr_TranslateEventSingleParticipants']; ?>
														</div>
													</li>
												<?php endif; ?>
											</ul>
										</div>
									<?php endif; ?>
								</div>
							</section>
						</div>
					</div>
			<?php endwhile; ?>
		<?php endif ?>
	</main>
<?php get_footer(); ?>