
var WtrPublicShortcode = function(){};
var WtrSliderClass = function(){};
var wtrShortcodeCodePlugin;

(function( $,sr )
{
	var x = function (f, t, e) {
	var tm;

	return function debounced ()
	{
		var obj = this, args = arguments;
		function d ()
		{
			if (!e)
			f.apply(obj, args);
			tm = null;
		};

		if (tm)
		{
			clearTimeout( tm );
		}
		else if ( e )
		{
			f.apply( obj, args );
		}
			tm = setTimeout( d, t || 200 );
		};
	}
	jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', x(fn)) : this.trigger(sr); };

})(jQuery,'wtrdynamicresize');

(function($) {

	"use strict";

	WtrPublicShortcode.prototype = {

		init : function()
		{
			if( false != /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|MSIE 9.0/i.test( navigator.userAgent ) )
			{
				this.is_mobile = true;
			}
			else
			{
				this.is_mobile = false;
			}

			this.move_rows();
			this.google_plus();
			this.fix_html();
			this.cols();
			this.testimontial();
			this.news_slider();
			this.clients();
			this.classes();
			this.events();
			this.wonster_slider();
			this.accordion();
			this.tabs();
			this.passes();
			this.instagram_image();
			this.row_yt();
			this.row_vimeo();
			this.row_parallax();
			this.paypal();
			this.row_mobile_video();
			this.gallery();
			this.google_maps();
			this.numieric_counter();
			this.circle_counter();
			this.countdown();
			this.step_by_step();
			this.content_slider();
			this.animate_element();
			this.video_center();
		},// end init


		move_rows : function(){
			var $m_rows = $( '.wtrAboveMenuRow' );
			if( $m_rows.length ){
				$m_rows.insertBefore( '.wtrHeader' );
				$( '.mp-pusher' ).addClass( 'wtrRBM' );
			}
		},//end move_rows


		animate_element : function()
		{
			function wtr_do_animation(){
				$('.wtr_animate').waypoint({
					offset		: '100%',
					triggerOnce	: true,
					continuous:	true,
					handler		: function(){
						var delay			= $( this ).data('animate-delay');
						var animationEffect = $( this ).data('animate');

						$( this ).delay( delay ).queue(function(){ $( this ).addClass( 'animated ' + animationEffect )} );
					}
				});
			}

			if( false == /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|MSIE 9.0/i.test( navigator.userAgent ) )
			{
				if( 0 == $( '.wtrLoader' ).length ){
					wtr_do_animation();
				}

				$( window ).on( 'wtr_content_loader', function(){
					wtr_do_animation();
				});
			}
			else
			{
				$( 'div, span, a, li, img, blockquote, ul, ol, i, table' ).removeClass('wtrOpacityNone  wtr_animate animated');
			}
		},//end animate_element


		google_plus : function()
		{
			var $g_plus = $( '.wpb_googleplus' );
			if ( $g_plus.length ) {
					var po		= document.createElement( 'script' );
					po.type		= 'text/javascript';
					po.async	= true;
					po.src		= 'https://apis.google.com/js/plusone.js';
					var s		= document.getElementsByTagName( 'script' )[ 0 ];

					s.parentNode.insertBefore(po, s);
			}
		},//end google_plus


		fix_html : function()
		{
			//fix ul i ol
			$( 'ul, ol' ).children().not('li').remove();
		},//end fix_html


		cols : function()
		{
			//auto height cols
			var $rows_auto = $( '.wtrAutoHeightColumns' );
			if( $rows_auto.length ){
				$( window ).on( 'resize', function(){
					$rows_auto.each(function( i, e ){
						var $elem = $( e );

						//standard row
						if( $elem.hasClass( 'wtrStandardRow' ) ){
							var $cols			= $elem.find( '.wtrStandardColumn' );
							var $cols_wrapper	= $cols.children( '.wpb_wrapper' );;
						}
						// inner row
						else if( $elem.hasClass( 'wtrRowInner' ) ){
							var $cols			= $elem.find( '.wtrInnerColumn' );
							var $cols_wrapper	= $cols.children( '.wpb_wrapper' );;
						}

						$cols_wrapper.height( '' );
						var maxHeight = Math.max.apply( null, $cols_wrapper.map( function(){ return $( this ).height(); } ).get() );
						$cols_wrapper.height( maxHeight );

						$cols.each(function( j, f ){
							var $col = $( f );

							if( !$col.hasClass( 'wtrOpacityNone' ) ){
								$col.css( 'opacity', 1 );
							}
						});

					});
				});
				$( window ).trigger( 'resize' );
			}
		},//end cols


		testimontial : function()
		{
			var $quoteRotator = $( '.wtrShtTestimonialRotSht' );
			if( $quoteRotator.length )
			{
				$quoteRotator.each(function( i, e ){
					var $elem		= $( e );
					var interval	= $elem.data( 'interval' );

					$elem.cbpQTRotator({
						interval : interval
					});
				});
			}

		},//end testimontial


		paypal : function()
		{
			$( '.wtrShtPayPalButton' ).find( '.wtrRadius3' ).each(function( i, e ){
				var button = $( e );
				var c1 = button.attr( 'data-color' );
				var h1 = button.attr( 'data-color-text' );
				var c2 = button.attr( 'data-color-hover' );
				var h2 = button.attr( 'data-color-text-hover' );

				button.mouseleave(function(){
					button.css({
						"background-color"	: c1,
						"color"				: h1
					});
				})
				.mouseover(function(){
					button.css({
						"background-color"	: c2,
						"color"				: h2
					});
				})
				.click(function( event ){
					event.stopPropagation();
					$( this ).next( '.paypalFunctionSht' ).submit();
				});
			});

			$( '.wtrShtPayPalImg' ).click(function( event ){
				$( this ).find( '.paypalFunctionSht' ).submit();
			});

			$( '.wtrShtPPPriceBtn' ).click(function( event ){
				$( this ).next( '.paypalFunctionSht' ).submit();
			});
		},//end paypal


		news_slider : function()
		{
			var $newsSlider = $( '.wtrShtLastNewsModernCarousel' );
			if( $newsSlider.length )
			{
				$newsSlider.each(function( i, e ){
					var $elem		= $( e );
					var interval	= $elem.data( 'interval' );

					$elem.owlCarousel({
						loop				: true,
						nav					: false,
						margin				: 40,
						responsiveClass		: true,
						autoplay			: true,
						autoplayTimeout		: interval,
						autoplayHoverPause	: true,
						responsive:{
							0	: { items : 1, nav : false, dots : true, loop : true },
							768 : { items : 1, nav : false },
							1000: { items : 3, nav : true, loop : true }
						}
					})
				});
			}
		},//end news_slider


		clients :function()
		{
			var $clientSlider = $( '.wtrClinetsCarusel' );
			if( $clientSlider.length )
			{
				$clientSlider.each(function( i, e ){
					var $elem		= $( e );
					var interval	= $elem.data( 'interval' );

					$elem.owlCarousel({
						loop:true,
						dots:true,
						margin:0,
						autoplay			: true,
						autoplayTimeout		: interval,
						autoplayHoverPause	: true,
						responsiveClass:true,
						responsive:{
							0:{ items : 1, nav : true, dots : true, loop : true },
							600:{ items : 3, nav : false },
							1000:{ items:6 , nav:true, dots : true, }
						}
					})
				});
			}
		},//end clients


		classes : function()
		{
			function rerender_classes(){
				$( '.wtrShtBoxedClassesColOne, .wtrShtBoxedClassesColOne, .wtrShtBoxedClassesSpace' ).each(function( i, e ){
					var $elem = $( e );
					var height = $elem.find( '.wtrShtBoxedClassesImgContainer' ).height();
					var top = $elem.find( '.wtrShtBoxedClassesDesc' ).position().top;
					var topH = $elem.find( '.wtrClassHeadNameJs' ).position().top;

					$elem.find( '.wtrShtBoxedClassesDesc' ).dotdotdot( { height : ( height - top - topH ) } );
				});
			}//end rerender_classes

			$(window).on( 'load', function() {
				rerender_classes();
			});

			$(window).on( 'resize', function() {
				rerender_classes();
			});

			$(window).trigger( 'resize' );
		},//end classes


		events : function()
		{
			function rerender_events(){
				$( '.wtrShtBoxedEventsColOne ' ).each(function( i, e ){
					var $elem	= $( e );
					var inner	= $elem.find( '.wtrShtBoxedEventsElements' ).height(),
						space	= $elem.find( '.wtrShtBoxedEventsContainerSpace' ).outerHeight(),
						$textL	= $elem.find( '.wtrShtBoxedEventsInfo' ),
						$readM	= $elem.find( '.wtrShtBoxedEventsReadMore' ),
						$mainC	= $elem.find( '.wtrShtBoxedEventsHeadline' );
					var textL	= $textL.outerHeight() + parseInt( $textL.css( 'margin-bottom' ) ),
						readM	= $readM.outerHeight() + parseInt( $readM.css( 'margin-top' ) ),
						mainC	= parseInt( $mainC.css( 'margin-top' ) ) + parseInt( $mainC.css( 'margin-bottom' ) );

					console.log( readM );
					console.log( '---' );
					$elem.find( '.wtrShtBoxedEventsHeadline a' ).dotdotdot( { height : inner - textL - readM - space - mainC } );
				});
			}//end rerender_events

			$(window).on( 'resize', function() {
				rerender_events();
			});

			$(window).on( 'load', function() {
				rerender_events();
			});

			if( $('.wtrBreadcrumbPath').length && $('.wtrBreadcrumbPath').position().top ){
				$( '.wtrBreadcrumbPathList .wtrActiveCrumb ' ).remove();
			}
		},//end events


		numieric_counter : function()
		{
			function helper_numeric_counter()
			{
				var obj = {};

				$( '.wtrCounterItem' ).waypoint({
					offset		: '100%',
					triggerOnce	: true,
					continuous	:	true,
					handler		: function(){
						$numericCounters.each(function( i, e ){
							var $elem = $( e );
							var duration	= $elem.data( 'duration' ),
								easing		= $elem.data( 'easing' ),
								value		= $elem.data( 'value' ),
								id			= $elem.attr( 'id' );

							var options = {
								useEasing	: easing,
								useGrouping	: false,
								separator	: ',',
								decimal		: '.',
							}

							obj[ id ] = new countUp( id, 1, value, 0, duration, options );
							obj[ id ].start();
						});
					}
				});
			}//end helper_numeric_counter

			var $numericCounters = $( '.wtrCounterItem' );
			if( $numericCounters.length ){
				setTimeout( helper_numeric_counter, 200 );
			}
		},//end numieric_counter


		circle_counter : function()
		{
			var $circleCounters = $( '.wtrShtCircleCounter' );
			if( $circleCounters.length ){
				$( '.wtrShtCircleCounterArea' ).waypoint({
					offset		: '100%',
					triggerOnce	: true,
					continuous	:	true,
					handler		: function(){
						$circleCounters.each(function( i, e ){
							var $elem	= $( e );
							var value	= $elem.data( 'value' ),
								speed	= $elem.data( 'speed' ),
								colorA	= $elem.data( 'active-color' ),
								color	= $elem.data( 'color' ),
								colorF	= $elem.data( 'font-color' ),
								weight	= $elem.data( 'weight' );

							$elem.ClassyLoader({
								percentage: value,
								speed: speed,
								diameter: 80,
								showText: true,
								fontSize: '40px',
								roundedLine: true,
								fontColor: colorF,
								lineColor: colorA,
								remainingLineColor: color,
								lineWidth: weight
							});
						});
					}
				});
			}
		},//end circle_counter


		wonster_slider : function()
		{
			WtrSliderClass.prototype = {

				init : function( id )
				{
					var selfSlider = this;

					selfSlider.component	= document.getElementById( id );
					selfSlider.items		= selfSlider.component.querySelector( 'ul.itemwrap' ).children;
					selfSlider.current		= 0;
					selfSlider.hoverM		= false;
					selfSlider.$component	= $( selfSlider.component);
					selfSlider.autoplay		= selfSlider.$component.data( 'autoslide' );
					selfSlider.delay		= selfSlider.$component.data( 'delay' );
					selfSlider.hoverStop	= selfSlider.$component.data( 'hover-stop' );
					selfSlider.effect		= selfSlider.$component.data( 'effect' );
					selfSlider.itemsCount	= selfSlider.items.length;
					selfSlider.nav			= selfSlider.component.querySelector( 'nav' );
					selfSlider.navDotList	= selfSlider.$component.next( '.wtrShtWonsterSliderDotsContainer' ).find( 'ul.wtrShtWonsterSliderDots li' );
					selfSlider.navDot		= selfSlider.navDotList.find( 'span' );
					selfSlider.navNext		= selfSlider.nav.querySelector( '.next' );
					selfSlider.navPrev		= selfSlider.nav.querySelector( '.prev' );
					selfSlider.isAnimating	= false;

					$( selfSlider.items[0] ).addClass( 'current' );
					selfSlider.navDot.eq( 0 ).addClass( 'wtrActiveSlide' );

					selfSlider.hideNav( selfSlider );
					selfSlider.navNext.addEventListener( 'click', function( ev ) { ev.preventDefault(); selfSlider.navigate( selfSlider, 'prev', null ); } );
					selfSlider.navPrev.addEventListener( 'click', function( ev ) { ev.preventDefault(); selfSlider.navigate( selfSlider, 'next', null ); } );
					selfSlider.navDotList.on( 'click', function( ev ) { ev.preventDefault(); if( !$(this).find( 'span' ).hasClass('wtrActiveSlide') ){ selfSlider.navigate( selfSlider, 'item', $(this).index() ); } });
					classie.addClass( selfSlider.component, selfSlider.effect );
					selfSlider.showNav( selfSlider );


					if( true === selfSlider.hoverStop ){
						selfSlider.$component.on( 'mouseover', function(){ selfSlider.hoverM = true; } );
						selfSlider.$component.on( 'mouseout', function(){ selfSlider.hoverM = false; } );
					}
					else{
						selfSlider.hoverM == false;
					}

					if( true === selfSlider.autoplay ){
						var wtrSliderInterwalChanger = function(){
							if( false === selfSlider.hoverM ){
								selfSlider.navigate( selfSlider, 'prev', null );
							}
						}//end wtrSliderInterwalChanger
						var wtrSliderInterwal = setInterval( wtrSliderInterwalChanger, selfSlider.delay );

						selfSlider.navDotList.click(function(){
							clearInterval( wtrSliderInterwal );
							wtrSliderInterwal = setInterval( wtrSliderInterwalChanger, selfSlider.delay );
						});
					}
				},//end init

				hideNav : function( selfSlider )
				{
					selfSlider.nav.style.display = 'none';
				},//end hideNav


				showNav : function( selfSlider )
				{
					selfSlider.nav.style.display = 'block';
				},//end showNav

				navigate : function( selfSlider, dir, index )
				{
					if( selfSlider.isAnimating ) return false;
					selfSlider.isAnimating = true;
					var cntAnims = 0;


					var currentItem = selfSlider.items[ selfSlider.current ];

					if( dir === 'next' ) {

						selfSlider.current = selfSlider.current > 0 ? selfSlider.current - 1 : selfSlider.itemsCount - 1;
					}
					else if( dir === 'prev' ) {
						selfSlider.current = selfSlider.current < selfSlider.itemsCount - 1 ? selfSlider.current + 1 : 0;
					}
					else if( dir === 'item'){
						selfSlider.current = index;
					}
					var nextItem = selfSlider.items[ selfSlider.current ];

					selfSlider.navDot.removeClass( 'wtrActiveSlide' );
					selfSlider.navDot.eq( selfSlider.current ).addClass( 'wtrActiveSlide' );

					var onEndAnimationCurrentItem = function() {
						this.removeEventListener( animEndEventName, onEndAnimationCurrentItem );
						classie.removeClass( this, 'current' );
						classie.removeClass( this, dir === 'next' ? 'navOutNext' : 'navOutPrev' );
						++cntAnims;
						if( cntAnims === 2 ) {
							selfSlider.isAnimating = false;
						}
					}

					var onEndAnimationNextItem = function() {
						this.removeEventListener( animEndEventName, onEndAnimationNextItem );
						classie.addClass( this, 'current' );
						classie.removeClass( this, dir === 'next' ? 'navInNext' : 'navInPrev' );
						++cntAnims;
						if( cntAnims === 2 ) {
							selfSlider.isAnimating = false;
						}
					}

					var onEndAnimationCurrentItemNoAnimation = function( currentItem, nextItem ) {
						$( selfSlider.items ).removeClass( 'current' );
						$( nextItem ).addClass( 'current' );
						selfSlider.isAnimating = false;
					}

					if( support.animations ) {
						currentItem.addEventListener( animEndEventName, onEndAnimationCurrentItem );
						nextItem.addEventListener( animEndEventName, onEndAnimationNextItem );

						classie.addClass( currentItem, dir === 'next' ? 'navOutNext' : 'navOutPrev' );
						classie.addClass( nextItem, dir === 'next' ? 'navInNext' : 'navInPrev' );
					}
					else {
						onEndAnimationCurrentItemNoAnimation( currentItem, nextItem );
					}
				},//end navigate
			};//end WtrSliderClass


			var $wonsterSliders = $( '.wtr-wonster-slider' );
			if( $wonsterSliders.length )
			{
				var support			= { animations : Modernizr.cssanimations },
				animEndEventNames	= {
					'WebkitAnimation'	: 'webkitAnimationEnd',
					'OAnimation'		: 'oAnimationEnd',
					'msAnimation'		: 'MSAnimationEnd',
					'animation'			: 'animationend'
				},
				animEndEventName	= animEndEventNames[ Modernizr.prefixed( 'animation' ) ],
				wonsterSliderList	= [];


				$wonsterSliders.each(function( i, e ){
					var $elem = $( e );
					wonsterSliderList.push( $elem.attr( 'id' ) );
				});
				var wonsterSlidersC = wonsterSliderList.length;

				for( var i = 0; i < wonsterSlidersC; i++ )
				{
					var slider = new WtrSliderClass();
					slider.init( wonsterSliderList[ i ] );
				}
			}
		},//end wonster_slider


		accordion : function()
		{

			var accordion = $( '.wtrShtAccordion' );
			if( accordion.length ){
				accordion.each(function( i,e ){
					var $elem	= $( e );
					var open	= parseInt( $elem.data( 'open' ) ),
						mode	= $elem.data( 'mode' );
					$elem.accordion({
						oneOpenedItem	: mode,
						open			: ( open - 1 )
					});

					$elem.find( '.wtrShtAccordionHeadline' ).on( 'click', function(){
						$( window ).trigger( 'resize' );
					});
				});
			}
		},//accordion


		tabs : function()
		{
			//standard tabs
			var $standardTabs = $('.wtrShtHorizontalTab');
			if( $standardTabs.length ){
				$standardTabs.each(function( i,e ){
					var $elem	= $( e );
					var open	= parseInt( $elem.data( 'open' ) );

					$elem.easyResponsiveTabs({
						type		: 'default',		//Types: default, vertical, accordion
						width		: 'auto',			//auto or any width like 600px
						fit			: true,				// 100% fit in a container
						closed		: 'accordion',		// Start closed if in accordion view
						activate	: function(event) {	// Callback function if tab is switched
							var $tab = $( this );
							var $info = $( '#tabInfo' );
							var $name = $( 'span', $info );
							$name.text( $tab.text() );
							$info.show();
							$( window ).trigger( 'resize' );
						}
					});

					$elem.find( 'ul.wtrShtTabList li' ).eq( open - 1 ).trigger( 'click' );
				});
			}

			//full width tabs
			var $fullWidthTabs = $( '.wtrShtFullWidthTabs' );
			if( $fullWidthTabs.length ){
				$fullWidthTabs.each(function( i, e ){
					var $elem	= $( e );
					var id		= $elem.attr( 'id' );
					var open	= $elem.data( 'open' );
					new CBPFWTabs( document.getElementById( id ) );

					var $li = $elem.find( 'ul.wtrShtFullWidthTabsLits li' );

					$li.on( 'click', function(){ $( window ).trigger( 'resize' ); } );
					$li.eq( open - 1 ).trigger( 'click' );
				});
			}
		},//end tabs


		passes : function()
		{
			var $passes = $( '.wtrPasses' );
			if( $passes.length ){
				$passes.each(function( i,e ){
					var $elem	= $( e );
					var open	= $elem.find( '.wtrShtPassesCategory-' + $elem.data( 'open' ) ).index();
					$elem.accordion({
						oneOpenedItem	: false,
						open			: open
					});
				});
			}

		},//end passes


		row_yt : function()
		{
			if( this.is_mobile ){
				$( '.wtrFWVytPlay' ).hide();
				$( '.wtrFWVytPause' ).hide();
			}else{
				var $row_yt = $( '.wtrRowYTPlayer' );
				if( $row_yt.length )
				{
					//start player
					if ( typeof( YT ) == 'undefined' || typeof( YT.Player ) == 'undefined' )
					{
						$.getScript('//www.youtube.com/iframe_api');

						window.onYouTubeIframeAPIReady = function()
						{
							$row_yt.each(function( i, e ){
								var mov_id = $( e ).attr( 'id' );
								var instance_yt = new YT.Player( $( e ).attr( 'id' ), {
									videoId		: $( e ).data( 'video' ),
									autoplay	: true,
									controls	: false,
									playerVars:	{
										wmode		: 'transparent',
										controls	: 0,
										loop		: 1,
										autoplay	: 1,
										autohide	: 0,
										showinfo	: 0,
										hd			: 1,
									},
									events		: {
										'onReady': function( event )
										{
											if( 'off' == $( e ).data( 'sound' ) )
											{
												event.target.mute();
											}

											// bind events
											if( $( '#' + mov_id + '-pause' ).length ){
												var playButton = document.getElementById( mov_id + '-play' );
													playButton.addEventListener("click", function() {
													instance_yt.playVideo();
													$( this ).hide();
													$( '#' + mov_id + '-pause' ).show();
												});

												var pauseButton = document.getElementById( mov_id + '-pause' );
													pauseButton.addEventListener( "click", function() {
													instance_yt.pauseVideo();
													$( this ).hide();
													$( '#' + mov_id + '-play' ).show();
												});
											}
										},
										'onStateChange': function(event)
										{
											if( event.data === YT.PlayerState.ENDED ){
												instance_yt.loadVideoById( $( e ).data( 'video' ) );
											}
										}
									}
								});
							});
						}
					}

					//change size
					$(window).on( 'resize', function() {
						$row_yt = $( '.wtrRowYTPlayer' );
						$row_yt.each(function( i, e ){
							var $elem			= $( e );
							var $video_size_c	= $elem.parent( '.wtrVideoYoutubeContener' ).siblings( '.wtrVideoSizeContener' );

							var width	= $video_size_c.width(),
								pWidth,
								height	= $video_size_c.height(),
								pHeight,
								options	= { ratio: 16/9 };

							if (width / options.ratio < height ){
								pWidth = Math.ceil( height * options.ratio );
								$elem.width( pWidth ).height( height ).css( { left: ( width - pWidth ) / 2, top: 0 } );
							} else {
								pHeight = Math.ceil( width / options.ratio );
								$elem.width( width ).height( pHeight ).css( { left: 0, top: ( height - pHeight ) / 2 } );
							}
						});

					});
					$(window).trigger( 'resize' );
				}
			}
		},//end row


		instagram_image : function()
		{
			var $instagram_images = $( 'iframe[src*="instagram.com"]' );
			if( $instagram_images.length ){
				$( window ).on( 'load resize', function () {
					$instagram_images.each(function( i, e ){
						var $elem = $( e ),
							width,
							windowWidth = $elem.parents( '.wtrPageContent' ).width(),
							newHeight,
							defaults;

						var defaults = {
							width		: 610,
							extraHeight	: 100,
							breakpoint	: 620
						};

						var options = $.extend( defaults,options );

						if ( windowWidth <= options.breakpoint ) {
							$elem.css( 'width','99%' );
						}
						else {
							$elem.css( 'width' ,options.width.toString( 10 ) + 'px' );
						}

						width = $elem.width();

						newHeight = Math.round( width + options.extraHeight );
						$elem.css( 'height', newHeight.toString( 10 ) + 'px' );
					});
				});
			}
		},//end instagram_image


		row_vimeo : function()
		{
			function onMessageReceived( e, $elem, url ) {
				var data	= JSON.parse(e.data),
					mov_id	= $elem.attr( 'id' );

				switch (data.event) {
					case 'ready':
						if( 'off' == $elem.data( 'sound' ) )
						{
							var valMax = 0;
						}
						else{
							var valMax = 1;
						}

						var data = { method: 'setVolume', value: valMax };
						$elem[0].contentWindow.postMessage( JSON.stringify( data ), '*' );
						data = { method: 'play' };
						$elem[0].contentWindow.postMessage( JSON.stringify( data ), '*' );
					break;
				}

				if( $( '#' + mov_id + '-pause' ).length ){
					var playButton = document.getElementById( mov_id + '-play' );
					playButton.addEventListener( "click", function() {
						data = { method: 'play' };
						$elem[0].contentWindow.postMessage( JSON.stringify( data ), '*' );
						$( this ).hide();
						$( '#' + mov_id + '-pause' ).show();
					});

					var pauseButton = document.getElementById( mov_id + '-pause' );
					pauseButton.addEventListener("click", function() {
						data = { method: 'pause' };
						$elem[0].contentWindow.postMessage( JSON.stringify( data ), '*' );
						$( this ).hide();
						$( '#' + mov_id + '-play' ).show();
					});
				}
			}

			var $row_vimeo = $( '.wtrRowVimeoPlayer' );
			if( $row_vimeo.length ){
				//start player

				if( this.is_mobile ){
					$( '.wtrFWVVimeoPlay' ).hide();
					$( '.wtrFWVVimeoPause' ).hide();
				}

				$row_vimeo.each(function( i, e ){
					var $elem	= $( e );
					var url		= $elem.attr('src').split('?')[0];

					if ( window.addEventListener ){
						window.addEventListener('message', function( e ){
							onMessageReceived( e, $elem, url );
						}, false);
					}
					else{
						window.attachEvent('onmessage', function( e ){
							onMessageReceived( e, $elem, url );
						}, false);
					}
				});

				//change size
				$(window).on( 'resize', function() {
					$row_vimeo = $( '.wtrRowVimeoPlayer' );
					$row_vimeo.each(function( i, e ){
						var $elem			= $( e );
						var $video_size_c	= $elem.parent( '.wtrVideoVimeContener' ).siblings( '.wtrVideoSizeContener' );

						var width	= $video_size_c.width(),
							pWidth,
							height	= $video_size_c.height(),
							pHeight,
							options	= { ratio: 16/9 };

						if (width / options.ratio < height ){
							pWidth = Math.ceil( height * options.ratio );
							$elem.width( pWidth ).height( height ).css( { left: ( width - pWidth ) / 2, top: 0 } );
						} else {
							pHeight = Math.ceil( width / options.ratio );
							$elem.width( width ).height( pHeight ).css( { left: 0, top: ( height - pHeight ) / 2 } );
						}
					});
				});
				$(window).trigger( 'resize' );
			}
		},//end row_vimeo


		row_parallax : function()
		{
			$.stellar({
				horizontalScrolling: false,
				verticalOffset: 0
			});
		},//end row_parallax


		row_mobile_video : function()
		{
			if( false != /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|MSIE 9.0/i.test( navigator.userAgent ) )
			{
				$( '.wtrShtFullWidthVideoStream' ).each(function( i, e ){
					var $video_div		= $( e );
					var mobile_poster	= $video_div.data( 'posterm' );

					if( mobile_poster.length ){
						$video_div.css({
							'background'		: 'url(' + mobile_poster + ')',
							'background-size'	: 'cover'
						});
					}
				});

				$( '.wtrShtBgVideo' ).each(function( i, e ){
					var $video_div		= $( e );
					var mobile_poster	= $video_div.data( 'posterm' );

					if( mobile_poster.length ){
						$video_div.css({
							'background-image'		: 'url(' + mobile_poster + ')'
						}).addClass( 'wtrNoVideoMobile' );
					}
				});
			}
		},//end row_mobile_video


		gallery : function()
		{
			//light gallery
			var lightGallery = $( '.wtrShtGalleryInit' );
			if( lightGallery.length ){
				lightGallery.lightGallery({
					escKey:true,
					speed: 400,
					desc:true,
					caption:true
				});
			}

			//flex gallery
			var flexGallery = $( '.wtrGalleryFlexGallery' );
			if( flexGallery.length ){
				flexGallery.flexslider();
			}
		},//end gallery


		google_maps : function()
		{
			var $googleMaps = $( '.wtrShtGoogleMaps' );
			if( $googleMaps.length )
			{
				//fix map heigth
				$googleMaps.each(function( i, e ){
					var $map			= $( e ).find( '.wtrShtGoogleMapsContener' );
					var map_height		= parseInt( $map.data( 'mheight' ) );
					var $map_contener	= $( e ).find( '.wtrShtGoogleMapsInfoBox' );

					if( $map_contener.length ){
						var h = parseInt( $map_contener.outerHeight() );

						if( map_height < ( h + 40 ) ){
							if( $map_contener.is( ':visible' ) ){
								$map.height( 80 + h );
							}else{
								$map.height( map_height );
							}
						}
					}
				});

				$( document ).on( 'google_maps_is_loaded', function(){

					function _getPolylinePoints( pointString )
					{
						var pointArray	= [];
						var geoSteps	= pointString.split( '@' );
						var geoStepsLen	= geoSteps.length;

						for (var i = 0; i < geoStepsLen; i++)
						{
							var geoPoints		= geoSteps[i].split('|');
							var geoPointsLen	= geoPoints.length;

							for (var j = 0; j < geoPointsLen; j++)
							{
								var point	= geoPoints[j];
								var geo		= point.split(';');
								var LatLng	= new google.maps.LatLng(geo[0], geo[1]);

								pointArray.push(LatLng);
							}
						}
						return pointArray;
					}//end _getPolylinePoints


					$googleMaps.each(function( i, e ){

						var $map		= $( e ).find( '.wtrShtGoogleMapsContener' );
						var map_height	= parseInt( $map.data( 'mheight' ) );
						var id_map		= $map.attr( 'id' );

						if( 'STREET_VIEW_PANORAMA' != wtr_google_maps[ i ].data.type_map )
						{
							if( !Modernizr.touch ){
								var wtr_draggable = true;
							}else{
								var wtr_draggable = false;
							}
							// create map
							var map_center	= wtr_google_maps[ i ].data.map.split( '|' );
							var center		= new google.maps.LatLng( map_center[ 0 ], map_center[ 1 ] );
							var map_options	= {
								zoom				: parseInt( wtr_google_maps[ i ].data.zoom ),
								center				: center,
								scrollwheel			: parseInt( wtr_google_maps[ i ].data.scroll ),
								zoomControl			: parseInt( wtr_google_maps[ i ].data.zoom_control ),
								mapTypeControl		: parseInt( wtr_google_maps[ i ].data.type_control ),
								panControl			: parseInt( wtr_google_maps[ i ].data.move_controls ),
								mapTypeId			: google.maps.MapTypeId[ wtr_google_maps[ i ].data.type_map ],
								streetViewControl	: false,
								draggable			: wtr_draggable,
								styles				: wtr_google_maps_style[ wtr_google_maps[ i ].data.style_map ]
							};
							var map = new google.maps.Map( document.getElementById( id_map ), map_options );

							//add markers
							var markerC = wtr_google_maps[ i ].markers.length;
							for( var j = 0; j < markerC; j++ )
							{
								var marker_obj	= wtr_google_maps[ i ].markers[ j ];
								var marker_pos	= marker_obj.geo_marker.split( '|' );

								if( 'standard' == marker_obj.marker_style ){
									iconData = null;
								}else if( 'my_own' == marker_obj.marker_style ){
									var iconData = {
											url: marker_obj.url,
											scaledSize: new google.maps.Size(
												parseInt( marker_obj.width ),
												parseInt( marker_obj.height )
											)
										};
								}
								else{
									var iconData = {
											url: wtr_google_marker_style[ marker_obj.marker_style ].url,
											scaledSize: new google.maps.Size(
												wtr_google_marker_style[ marker_obj.marker_style ].width,
												wtr_google_marker_style[ marker_obj.marker_style ].height
											)
										};
								}

								var marker = new google.maps.Marker({
									position	: new google.maps.LatLng( marker_pos[ 0 ], marker_pos[ 1 ] ),
									map			: map,
									draggable	: false,
									optimized	: false,
									title		: marker_obj.title_marker,
									icon		: iconData
								});

								//link url
								if( marker_obj.url_link.length ){

									var tmp_link	= marker_obj.url_link.split( '|' );

									if( '' !=   tmp_link[2] ){
										var target = true;
									}else{
										var target = false;
									}

									var tmp_link_u	= tmp_link[ 0 ].split( ':' );

									if( undefined != tmp_link_u[ 1 ] ){
										var marker_url	= decodeURIComponent( tmp_link_u[ 1 ] );

										google.maps.event.addListener(marker, 'click', function() {
											if( target ){
												window.open( marker_url, '_blank' );
											}else{
												window.location.href = marker_url;
											}
										});
									}
								}
							}

							//road
							var roadsC = wtr_google_maps[ i ].roads.length;
							for( var j = 0; j < roadsC; j++ )
							{
								var road_obj = wtr_google_maps[ i ].roads[ j ];
								if( '' != road_obj.points )
								{
									var road_points		= _getPolylinePoints( road_obj.points );
									var roadPolyline	= new google.maps.Polyline({
										path			: road_points,
										map				: map,
										strokeColor		: road_obj.color_line,
										strokeWeight	: road_obj.weight_line,
										geodesic		: true,
									});
								}
							}

							$( window ).on( 'resize', function(){
								google.maps.event.trigger( map, 'resize' );
								map.setCenter( center );
							});
						}
						else if( 'STREET_VIEW_PANORAMA' ==  wtr_google_maps[ i ].data.type_map ){
							var map_center			= wtr_google_maps[ i ].data.map.split( '|' );
							var panorama_options	= {
								position		: new google.maps.LatLng( map_center[ 0 ], map_center[ 1 ] ),
								addressControl	: parseInt( wtr_google_maps[ i ].data.address_control ),
								disableDefaultUI: parseInt( wtr_google_maps[ i ].data.disable_default_ui ),
								clickToGo 		: parseInt( wtr_google_maps[ i ].data.click_to_go ),
								zoomControl		: parseInt( wtr_google_maps[ i ].data.zoom_control ),
								scrollwheel		: parseInt( wtr_google_maps[ i ].data.scroll ),
								pov				: {
									heading	: parseInt( wtr_google_maps[ i ].data.heading_map ),
									pitch	: parseInt( wtr_google_maps[ i ].data.pitch_map )
								},
								visible			: true
							};
							var panorama = new google.maps.StreetViewPanorama(document.getElementById( id_map ), panorama_options );
						}

						// scale map for contener
						$( window ).on( 'resize', function(){
							var $map_contener = $( e ).find( '.wtrShtGoogleMapsInfoBox' );
							if( $map_contener.length ){
								var h = parseInt( $map_contener.outerHeight() );

								if(  map_height < ( h + 40 ) ){
									if( $map_contener.is( ':visible' ) ){
										$map.height( 80 + h );
									}else{
										$map.height( map_height );
									}
								}
							}
						});
						$( window ).trigger( 'resize' );
					});
				});
			}
		},//end google_maps


		countdown : function()
		{
			var $countdown = $( '.wtrShtCountdown' );
			if( $countdown.length )
			{
				$countdown.each(function( i, e ){
					var $elem	= $( e );
					var year	= $elem.data( 'year' ),
						month	= $elem.data( 'month' ),
						day		= $elem.data( 'day' ),
						hour	= $elem.data( 'hour' ),
						minute	= $elem.data( 'minute' );
					var austDay = new Date( year, month, day, hour, minute );

					$elem.countdown( { until: austDay } );
				});
			}
		},//end countdown


		step_by_step : function()
		{
			var $steps = $( '.wtrShtStepByStep' );
			if( $steps.length ){
				$( window ).on( 'resize', function(){
					$steps.each(function( i, e ){
						var $elem		= $( e );
						var $childrenC	= $elem.find( '.wtrShtStepByStepContainer' );

						$childrenC.height( '' );
						var maxHeight = Math.max.apply( null, $childrenC.map( function(){ return $( this ).height(); } ).get() );
						$childrenC.height( maxHeight );
						if( !$steps.hasClass( 'wtrOpacityNone' ) ){
							$steps.css( 'opacity', 1 );
						}
					});

				});

				$( 'body' ).imagesLoaded( function() {
					$( window ).trigger( 'resize' );
				});
			}
		},//end step_by_step


		content_slider : function()
		{
			var $content_slider = $( '.wtrContentSlider' );
			if( $content_slider.length ){
				$content_slider.each(function( i, e ){
					var $elem		= $( e );
					var autoplay	= $elem.data( 'autoplay' ),
						interval	= $elem.data( 'interval' );

					$elem .owlCarousel({
						loop			: true,
						dots			: true,
						nav				: true,
						margin			:40,
						responsiveClass	:true,
						autoplay		: autoplay,
						autoplayTimeout	: interval,
						responsive:{
							0	:{ items : 1, nav : false, dots :true, loop : true },
							600	:{ items :1, nav : false },
							1000:{ items : 1, nav :true, dots	:true, loop	:true }
						}
					});
				});
			}
		},//end content_slider


		video_center : function()
		{
			var $video_contener_to_center = $( '.wtrCenterVideo' );
			if( $video_contener_to_center.length ){
				$video_contener_to_center.each(function( i, e ){
					$( e ).wrap( "<center></center>" );
				});
			}
		}//end video_center
	};// end WtrPublicShortcode


	$(document).ready(function(){
		wtrShortcodeCodePlugin = new WtrPublicShortcode();
		wtrShortcodeCodePlugin.init();
	});
})(jQuery);