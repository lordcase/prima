var WtrPublicGUICode = function(){};
var wtrMainGUI;

(function($) {

	"use strict";

	WtrPublicGUICode.prototype = {

		init : function(){
			this.menu_revers();
			this.header_menu();
			this.mobile_navi();
			this.smart_menu();
			this.relaterd_post_rotator();
			this.dynamic_background();
			this.google_maps_init();
			this.set_google_maps_event();
			this.search_form();
			this.paypal();
			this.blog_comment_form();
			this.onepage();
			this.loader_page();

			//widgets
			this.widget_gallery();
			this.widget_event();
			this.widget_search_form();
			this.widget_countdown();
			this.widget_testimontial();

			//plugin
			this.wpml_template();
		},//end init


		header_menu : function()
		{
				var $header				= $( '.wtrHeader' );
				var $headerSecond		= $( '.wtrHeaderSecond' );
				var headerLogoNormal	= $header.data( 'logo-normal' ),
					headerLogoTrans		= $header.data( 'logo-trans' ),
					logo				= $header.find( '.wtrLogoWebsite' ),
					header_height		= $header.height(),
					$smartMenu			= $( '.dl-menuwrapper' ),
					mobile_flag			= /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test( navigator.userAgent );

			$( '#mp-pusher' ).on( 'click', function(){
				setTimeout(function(){ $( '#mp-pusher' ).removeAttr( 'style' ); }, 300 );
			});

			if( false == mobile_flag )
			{
				//active li hover
				$( '.wtrMainNavigation li.wtrNaviItem' ).mouseover(function(){
					$(this).addClass( 'wtrNaviHover' );
				}).mouseout(function(){
					$(this).removeClass( 'wtrNaviHover' );
				});

				if( $header.hasClass( 'wtrHeaderFixed' ) )
				{
					var flag_menu_change = false;
					var flag_menu_state = false;

					$( window ).scroll( function(){
						if( $( window ).scrollTop() ){
							flag_menu_state = true;
							$header.addClass( 'wtrMenuScroll' );
							logo.attr( 'src', headerLogoNormal );
						}else{
							flag_menu_state = false;
							$header.removeClass( 'wtrMenuScroll' );
							logo.attr( 'src', headerLogoTrans );
						}

						if( flag_menu_change != flag_menu_state ){
							flag_menu_change = flag_menu_state;
							$( window ).trigger( 'wtr_menu_position_change' );
						}
					});
				}
				else if( $headerSecond.length )
				{
					var flag_menu_change = false;
					var flag_menu_state = false;

					$( window ).scroll( function(){
						if( header_height + $header.offset().top > $( window ).scrollTop() ){
							flag_menu_state = true;
							$headerSecond.addClass( 'wtrDisplayHide' );
							$headerSecond.removeClass( 'wtrHeaderFixedAnim' );
						}else{
							flag_menu_state = false;
							$headerSecond.removeClass( 'wtrDisplayHide' );
							$headerSecond.addClass( 'wtrHeaderFixedAnim' );
						}

						if( flag_menu_change != flag_menu_state ){
							flag_menu_change = flag_menu_state;
							$( window ).trigger( 'wtr_menu_position_change' );
						}
					});
				}
				else if( $smartMenu.length )
				{
					var hHeder =$header.height();

					$( window ).scroll( function(){
						if( $( window ).scrollTop() > hHeder + $header.offset().top ){
							$smartMenu.show();
						}else{
							$smartMenu.fadeOut( 400, function(){
								$( window ).trigger( 'wtr_smart_menu_hide' );
							});
						}
					});
				}
			}
			else{
				if( false != mobile_flag )
				{
					$header.removeClass( 'wtrHeaderFixed' );
				}

				$( window ).bind('touchend', function(e) {});
			}
		},//end header_menu


		menu_revers : function()
		{
			var $width_limit	= $( '.wtrMainHeader .wtrInner' );
			if( $width_limit.length ){
				var max_width		= $width_limit.offset().left + $width_limit.width();

				$( '.wtrHeaderSecond ' ).removeClass( 'wtrDisplayHide' );
				$( '.wtrMainNavigation .wtrSecondDrop' ).each(function( i, e ){
					var $elem				= $( this );
					var max_elem_width		= $elem.offset().left + $elem.width();
					var $sub_menu			= $elem.find( '.wtrSecondMenuContainer' ).css( { 'display' : 'block', 'position' : 'absolute', 'min-width' : '200px' } );
					var max_sub_menu_width	= $sub_menu.offset().left + $sub_menu.width();
					var $third_menu,
						flag_one			= 0,
						flag_dwo			= 0;

					if( max_width < max_sub_menu_width )
					{
						flag_one = 1;
					}
					else
					{
						$third_menu = $sub_menu.find( '.wtrThirdNavi .wtrThirdNavigation' );

						if( $third_menu.length ){
							$third_menu.css({ 'display' : 'block', 'position' : 'absolute', 'left' : '100%', 'right' : 'auto' } );
							var max_sub_menu_width = $third_menu.offset().left + $third_menu.width();

							if( max_width < max_sub_menu_width ){
								flag_dwo = 1;
							}
							$third_menu.removeAttr( 'style' );
						}
					}

					$sub_menu.removeAttr( 'style' );

					if( 1 == flag_one ){
						$sub_menu.css({ marginLeft : '-' + ( max_sub_menu_width - max_elem_width ) + 'px' } );
						$sub_menu.find( '.wtrThirdNavi' ).addClass( 'wtrRevNav' );
					}else if( 1 == flag_dwo ){
						$third_menu.parents( '.wtrThirdNavi' ).addClass( 'wtrRevNav' );
					}
				});
				$( '.wtrHeaderSecond ' ).addClass( 'wtrDisplayHide' );
			}
		},//end menu_revers


		mobile_navi : function()
		{
			var $wp_menu		= $( '#mp-menu' ),
				$classic_menu	= $( '.wtrSimpleMobileNav' );
			if( $wp_menu.length ){
				$( '.wtrTriggerMobileMenu' ).attr( 'id', 'trigger' );
				new mlPushMenu( document.getElementById( 'mp-menu' ), document.getElementById( 'trigger' ), {
					type : 'cover'
				} );


				$( window ).on( 'resize', function(){
					if( $( this ).width() > 991 ){
						$( '#mp-pusher' ).removeAttr( 'style' ).trigger( 'click' );
					}
				});

				$( '.wtrTriggerMobileMenu' ).click(function(){
					$( window ).scrollTop( 0 );
				});
			}
			else if( $classic_menu.length ){
				var $menu_trigger	= $( '.wtrMobileMenu' ),
					$m_navi			= $( '.wtrSimpleMobileNavContainer' ),
					$mp_pusher		= $( '.mp-pusher' ),
					$content		= $( '.container' ),
					$overlay_m		= $( '.wtrSimpleNavOverlay' ),
					$expander		= $( '.wtrExpander' );


				//content switch
				$menu_trigger.click(function(){
					if( $menu_trigger.hasClass( 'wtrMenuOpen' ) ){
						$menu_trigger.removeClass( 'wtrMenuOpen' );
						$mp_pusher.removeClass( 'wtrSimpleNavOn' );
						$m_navi.hide();
						$overlay_m.hide();
					}else{
						$( window ).scrollTop( 0 );

						//collapse mobile menu
						$( '.wtrSimpleMobileNavContainer .sub-menu li' ).hide();
						$expander.removeClass( 'wtrMinus' ).addClass( 'wtrPlus' );

						$menu_trigger.addClass( 'wtrMenuOpen' );
						$mp_pusher.addClass( 'wtrSimpleNavOn' );
						$m_navi.show();
						$overlay_m.show();
					}
				});

				//Expander
				$expander.click(function(){
					var $this =  $( this );

					if( $this.hasClass( 'wtrPlus' ) ){
						$this.removeClass( 'wtrPlus' ).addClass( 'wtrMinus' );
						$this.siblings( '.sub-menu' ).children( 'li' ).show();
					}else{
						$this.removeClass( 'wtrMinus' ).addClass( 'wtrPlus' );
						$this.siblings( '.sub-menu ' ).children( 'li' ).hide();
					}
					$this.siblings( '.sub-menu' );
				});
			}
		},//end mobile_navi


		smart_menu : function()
		{
			$( '#dl-menu' ).dlmenu({
				animationClasses : { classin : 'dl-animate-in-3', classout : 'dl-animate-out-3' }
			});

			var flag_smart_menu_click = false;
			$( '.dl-trigger' ).click(function(){
				flag_smart_menu_click = ( flag_smart_menu_click )? false : true;
			});

			$( window ).on( 'wtr_smart_menu_hide' , function(){
				if( flag_smart_menu_click ){
					$( '.dl-trigger' ).trigger( 'click' );
				}
			});
		},//end smart_menu


		relaterd_post_rotator : function(){
			$( '.wtrRecentPostRotator' ).owlCarousel({
				loop:true,
				dots: false,
				nav: true,
				margin:40,
				responsiveClass:true,
				responsive:{
					0		:{ items : 1, nav : true, dots : false, loop : false },
					768		:{ items : 2, nav : true },
					1000	:{ items : 3, nav : true, dots : false, loop : false }
				}
			});
		},//end relaterd_post_rotator


		paypal : function(){
			$( '.paypalTrigger' ).click(function(){
				$( this ).next( '.paypalFunction' ).submit();
			});
		},//end paypal


		//WIDGETS
		widget_gallery : function()
		{
			var $w_gallery = $( '.wtrWidgetGallery' );
			if( $w_gallery.length ){
				$w_gallery.lightGallery({
					escKey	:true,
					speed	: 400,
					// desc:true,
					// caption:true
				});
			}
		},//end widget_gallery


		widget_event : function()
		{
			$( '.wtrWidgetUpcomingEventsRotator' ).owlCarousel({
				loop			:true,
				dots			: true,
				margin			:20,
				responsiveClass	:true,
				responsive:{
					0:{ items:1, nav:false, dots:true, loop:false },
					600:{ items:1, nav:false },
					1000:{ items:1, nav:true, loop:true, autoplay:true, autoplayTimeout:2000, autoplayHoverPause:true }
				}
			});
		},//end widget_event


		dynamic_background : function()
		{
			if( wtr_background_switcher_data.length ){
				$.backstretch( wtr_background_switcher_data, { duration: 3700, fade: 2300 } );
			}
		},//end dynamic_background

		google_maps_init : function()
		{
			if( $( '.wtrEventEntryPageMap' ).length || $( '.wtrShtGoogleMapsContener' ).length ){

				$.getScript( wtr_main_theme_data .theme_url + '/assets/js/wtr_google_maps_style.js', function(){
					var script	= document.createElement( 'script' );
					script.id	= 'google_maps_api';
					script.type	= 'text/javascript';
					script.src	= 'https://maps.googleapis.com/maps/api/js?v=3.exp&' + 'callback=wtrMainGUI.trigger_google_maps_load_event';
					document.body.appendChild( script );
				});
			}
		},//end google_maps_init


		trigger_google_maps_load_event : function()
		{
			$( document ).trigger( 'google_maps_is_loaded' );
		},//end trigger_google_maps_load_event


		set_google_maps_event : function()
		{
			$( document ).on( 'google_maps_is_loaded', function(){
				var $map = $( '.wtrEventEntryPageMap' );
				if( $map.length )
				{
					// create map
					var map_center	= $map.data( 'marker' ).split( ',' );
					var center		= new google.maps.LatLng( map_center[ 0 ], map_center[ 1 ] );
					var map_options	= {
						zoom				: parseInt( $map.data( 'zoom' ) ),
						center				: center,
						scrollwheel			: parseInt( $map.data( 'scroll' ) ),
						zoomControl			: true,
						mapTypeControl		: false,
						mapTypeId			: google.maps.MapTypeId[ $map.data( 'type' ) ],
						styles				: wtr_google_maps_style[ $map.data( 'style' ) ],
					};
					var map_g = new google.maps.Map( document.getElementById( 'event_google_maps' ), map_options );

					//add markers
					var marker = $map.data( 'marker-style' );

					if( 'standard' == marker ){
						iconData = null;
					}
					else{
						var iconData = {
								url: wtr_google_marker_style[ marker ].url,
								scaledSize: new google.maps.Size(
									wtr_google_marker_style[ marker ].width,
									wtr_google_marker_style[ marker ].height
								)
							};
					}

					var marker = new google.maps.Marker({
						position	: center,
						map			: map_g,
						draggable	: false,
						optimized	: false,
						icon		: iconData
					});
				}
			});

		},//end set_google_maps_event


		search_form : function()
		{
			var $search_f = $( '.wtrSearchFormTrigger' );
			if( $search_f.length ){

				$search_f.click(function(){
					var search_fc = $( this ).next( '.wtrSearchContainer' );
					search_fc.fadeIn();
					search_fc.find( '.wtrSearchInput' ).focus();
				});

				$( '.wtrSearchCloseBtn' ).click(function( event ){
						$( '.wtrSearchContainer' ).hide();
				});

				$( window ).click(function( event ){
					if( !$( event.target ).parents( '.wtrNaviSearchItem' ).length ){
						$( '.wtrSearchContainer' ).hide();
					}
				});

				$( window ).on( 'wtr_menu_position_change', function(){
					$( '.wtrSearchContainer' ).hide();
				});
			}
		},//end search_form


		blog_comment_form : function()
		{
			var $form			= $( '#wtr_form_comments' );
			var is_logged		= $form.find( '.comment-form-author' ).length;
			var $comment_field	= $form.find( '.comment-form-comment textarea' );

			$comment_field.attr( 'data-min-rows', '2' );

			$(document).one('focus.comment-form-comment textarea', '.comment-form-comment textarea', function(){
				var savedValue			= this.value;
				this.value				= '';
				this.baseScrollHeight	= this.scrollHeight;
				this.value				= savedValue;
			}).on('input.comment-form-comment textarea','.comment-form-comment textarea', function(){
				var minRows	= this.getAttribute( 'data-min-rows' )|0,
					rows;

				this.rows	= minRows;
				rows		= Math.ceil((this.scrollHeight - this.baseScrollHeight) / 17);
				this.rows	= minRows + rows;
			});

			//no logged
			if( is_logged ){
				var $dynamic_field = $form.find( 'p' ).not( ':first' ).not( ':last' );
				$dynamic_field.hide();

				$comment_field.click(function(){
					$dynamic_field.slideDown();
					$dynamic_field.animate({opacity: 1},{queue: false});
				});
			}
		},//end blog_comment_form


		onepage : function()
		{
			if( $('.wtr_fullpage').length ){
				$('.wtr_fullpage').fullpage({
					'verticalCentered'	: wtr_onepage_stettings.verticalCentered,
					'css3'				: true,
					'sectionsColor'		: wtr_onepage_stettings.sectionsColor,
					'navigation'		: true,
					'navigationPosition': 'right',
					'fitToSection'		: false,
					'navigationTooltips': wtr_onepage_stettings.navigationTooltips,
					'afterLoad'			: function(anchorLink, index){
						$( window ).trigger( 'wtr_content_loader', index );
					},
				});

				$( wtr_onepage_stettings.navigationClass ).each(function( i, elem ){
					$( '#fp-nav' ).find( 'li' ).eq( i ).addClass( elem );
				});

				$( window ).on( 'resize', function(){
					if( $( this ).width() > 991 ){
						$.fn.fullpage.setAutoScrolling( true );
					}else{
						$.fn.fullpage.setAutoScrolling( false );
					}
				});
			}
		},//end onepage



		loader_page : function()
		{
			var wtr_loader_area = $( '.wtrLoader' );
			if( wtr_loader_area.length ){
				$( 'body' ).imagesLoaded( function() {
					setTimeout(function(){
						$( '.wtrLoader' ).fadeOut( '400', function(){
							$( window ).trigger( 'wtr_content_loader' );
						});
					}, 700);
				});
			}else{
				$( 'body' ).imagesLoaded( function(){
					$( window ).trigger( 'wtr_content_loader' );
				});
			}
		},//end loader_page


		widget_search_form : function()
		{
			$( '.wtrFooterWdg .widget_search label' ).click(function(){
				$( this ).parents( 'form' ).submit();
			});
		},//end widget_search_form


		widget_countdown : function()
		{
			var $countdown = $( '.wtrWidgetCountdown' );
			if( $countdown.length )
			{
				$countdown.each(function( i, e ){
					var $elem	= $( e );
					var year	= $elem.data( 'year' ),
						month	= parseInt( $elem.data( 'month' ) ) - 1,
						day		= $elem.data( 'day' ),
						hour	= $elem.data( 'hour' ),
						minute	= $elem.data( 'minute' );
					var austDay = new Date( year, month, day, hour, minute );

					$countdown.countdown( { until: austDay } );
				});
			}
		},//end widget_countdown


		widget_testimontial : function()
		{
			var $quoteRotator = $( '.wtrShtTestimonialRotWidget' );
			if( $quoteRotator.length )
			{
				$quoteRotator.each(function( i, e ){
					var $elem		= $( e );
					var interval	= $elem.data( 'interval' );

					$elem.cbpQTRotator({
						interval : interval
					});
				});

				$( window ).on( 'resize', function(){
					$quoteRotator.each(function( i, e ){
						var $elem	= $( e );
						var $items	= $elem.find( '.wtrShtTestimonialStdItem' );

						$items.height( '' );
						var maxHeight = Math.max.apply( null, $items.map( function(){ return $( this ).height(); } ).get() );
						$items.height( maxHeight );
					});
				});
				$( window ).trigger( 'resize' );
			}
		},//end widget_testimontial


		wpml_template : function()
		{
			var $wpml_t = $( '.menu-item-language a' );
			if( $wpml_t.length ){
				if( $wpml_t.first().text().length ){
					$wpml_t.parents( '.menu-item-language' ).addClass( 'wtrLangLabel' );
				}
			}
		},//end wpml_template
	};//end WtrPublicGUICode

	$(document).ready(function(){
		wtrMainGUI = new WtrPublicGUICode();
		wtrMainGUI.init();
	});
})(jQuery);