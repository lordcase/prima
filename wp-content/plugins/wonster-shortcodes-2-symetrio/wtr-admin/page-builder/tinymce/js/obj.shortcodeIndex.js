/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

var WtrShortcodeIndex			= function(){};
var WtrShortcodeModalIndex		= function(){};
var WtrShortcodeModalItem		= function(){};
var WtrShortcodeModalProperties = function(){};
var WtrShortcodeElement			= function(){};

(function($){

	"use strict";

	var ScriptLoaded;

	// loading settings panel for a particular shortcode
	WtrShortcodeModalItem.prototype = {

		modal_w	: '',
		modal_h	: '',
		w_mode	: '',
		h_mode	: '',
		fields	: {},

		initModal : function( lib, modal_w, modal_h, w_mode, h_mode )
		{
			// set the modal size
			this.modal_w	= modal_w;
			this.modal_h	= modal_h;
			this.w_mode		= w_mode;
			this.h_mode		= h_mode;

			var dataM		= JSON.stringify( window.wtr_shr_trigger.data ) ;
				dataM		= unescape( dataM.replace( /\\u/g, '%u' ) );
				dataM		= encodeURIComponent( dataM );
			var idShtWks		= wtrSetShtIdData();

			// show modal shortcode
			var urlModal	= wtr_shr_param.uri + '/page-builder/tinymce/view/shortcodeModal.php?lib=' + lib + '&w=' + modal_w + '&wtr_sht_id_data=' + idShtWks + '&h=' + modal_h + '&mode=0&lang=' + wtr_shr_param.lang;
			var size		= WtrModalShortcodeLoader.calcModalCss({
								'fullscreenW'	: w_mode,
								'fullscreenH'	: h_mode,
								'width'			: modal_w,
								'height'		: modal_h
								}) ;
			// save the data for presentation in the preview
			var wtrAjaxSaveSht	= wtrSetShtData( idShtWks, dataM );

			wtrProgressInfo( 1 );
			wtrAjaxSaveSht.done(function( result ){
				TINY.box.fill( urlModal, 1, 0, 1, size.w, size.h, WtrModalShortcodeLoader.WtrCheckDrowModal );
			});
		},// end initModal


		WtrResetModalStyle : function()
		{
			$( window ).resize(function(){

				// width auto modal
				if ( 'yes'  == $( '.container-shortcode' ).data( 'width-mode' ) )
				{
					if( $( '.container-shortcode' ).length )
					{
						$( '.tbox2' ).addClass( 'tbox' );
						$( '.tinner' ).css( 'width', '100%' );
						$( '.tbox' ).css({
							'max-width' : '',
						});
					}
				}
				else{
					if( $( '.container-shortcode' ).length )
					{
						$( '.tbox2' ).addClass( 'tbox' );
						$( '.tinner' ).css( 'width', '100%' );
						$( '.tbox' ).css({
							'max-width' : WtrModalShortcodeLoader.modal_w + 'px',
						});
					}
				}

				// height auto modal
				if ( 'yes'  == $( '.container-shortcode' ).data( 'height-mode' ) )
				{
					if( $( '.container-shortcode' ).length )
					{
						$( '.tbox2' ).addClass( 'tbox' );
						$( '.tinner' ).css( 'height', 'auto' );
						$( '.tbox' ).css({
							'max-height': '',
							'top'		: '35px',
						});
					}
				}
				else
				{
					if( $( '.container-shortcode' ).length )
					{
						$( '.tbox2' ).addClass( 'tbox' );
						$( '.tinner' ).css( 'height', 'auto' );
						$( '.tbox' ).css({
							'max-height'	: WtrModalShortcodeLoader.modal_h + 'px',
							'posion'		: 'fixed',
							/*'top' 		 : '35px',	*/
						});
					}
				}
			});
		},// end WtrResetModalStyle


		WtrCheckDrowModal : function()
		{
			var refreshIntervalId = setInterval( function()
			{
					clearInterval( refreshIntervalId );

					//bind scripts
					ScriptLoaded = new WtrObjsLoader();
					ScriptLoaded.initScriptObject();

					// hide fields
					$( '.ModalHide' ).parents( '.wonsterFiled ' ).hide();

					// bind js events
					var type = $( '.wtrFieldsContainer' ).attr( 'type' );
					var objS = WtrShortcodeDefElement[type];

					WtrShortcodeDefElement.setDependencyElement();

					if( objS != undefined && typeof(objS.initEvent) == 'function' )
					{
						objS.initEvent();
					}

					// finish render modal
					WtrShortcodeFunModalIndex.finishRender();
					WtrModalShortcodeLoader.WtrResetModalStyle();
					wtrProgressInfo( 0 );

					// fix tinymce sroll
					var divSecond	= $('.wtrFieldsContainerShortcodes');
					var divThird	= $('.wtrFieldsContainerProperties');
					var div			= ( divThird.length )? divThird : divSecond;
					div.scrollTop(0);
			}, 20 );
		},// end WtrCheckDrowModal


		calcModalCss : function( source )
		{
			var w = $( window ).width();
			var h = $( window ).height();

			if( 'yes'  == source.fullscreenW )
			{
				var winWidthWorkArea = w - 60
				$('.tbox').css( 'max-width', '' );
			}
			else
			{
				var wFinal = ( source.width > w )? w - 60 : source.width;
				var winWidthWorkArea = wFinal;
				$( '.tbox' ).css( 'max-width', wFinal + 'px' );
			}

			if( 'yes'  == source.fullscreenH )
			{
				var winHeightWorkArea = h - 85;
				$( '.tbox' ).css( 'max-height', '' );
			}
			else
			{
				var hFinal = ( source.height > h )? h - 85 : source.height;
				var winHeightWorkArea = hFinal;
				$( '.tbox' ).css( 'max-height', hFinal + 'px' );
			}

			return { w: winWidthWorkArea, h: winHeightWorkArea }
		},// end calcModalCss

		cleanCssModalProperties : function()
		{
			$( '.tbox-properties' ).removeClass( 'tbox-properties2' );
		}// end cleanCssModalProperties
	}// end WtrShortcodeModalItem


	// ### WtrShortcodeModalProperties ###
	WtrShortcodeModalProperties.prototype = {

		modal_size : {},
		mode : '',

		showModal : function( type, modal_size, mode )
		{
			this.modal_size	= modal_size;
			this.mode		= mode;

			var modalVer,
				opacity,
				modalType,
				closeFunctionVersion;

			if( -1 != mode.search( 'properties' ) )
			{
				$( '.tbox-properties' ).removeClass( 'tbox-properties2' ).removeAttr('style');
				var size		= WtrShortcodeFunModalProperties.calcModalCss( this.modal_size );
				var modalVer	= TINY_PROPERTIES;
				var opacity		= 80;
			}
			else if( 'pb' == mode )
			{
				// hide scroll
				WtrShortcodeFunModalIndex.hideScroll();
				var size		= WtrModalShortcodeLoader.calcModalCss( this.modal_size );
				var modalVer	= TINY_PB;
				var opacity		= 50;
			}

			var dataM	= JSON.stringify( window.wtr_shr_trigger.data ) ;
				dataM	= unescape( dataM.replace( /\\u/g, '%u' ) );
				dataM	= encodeURIComponent( dataM );

			var wtrAjaxSaveSht;
			var idShtWks	= wtrSetShtIdData();

			if( mode == 'propertiesPrev' )
			{
				modalType = wtr_shr_param.uri + '/page-builder/tinymce/view/shortcodePrev.php?h=' + ( this.modal_size.height - 200 ) + '&wtr_sht_id_data=' + idShtWks;
				closeFunctionVersion = function(){};
				wtrAjaxSaveSht = wtrSetShtData( idShtWks, window.wtr_shr_trigger.prev_shortcode );
			}
			else
			{
				modalType = wtr_shr_param.uri + '/page-builder/tinymce/view/shortcodeModal.php?lib=' + type + '&wtr_sht_id_data=' + idShtWks + '&w=null&h=null' + '&mode=' + this.mode;

				wtrAjaxSaveSht = wtrSetShtData( idShtWks, dataM );
			}
			closeFunctionVersion = ( 'pb' == mode )? WtrShortcodeFunModalProperties.closeModalPB : WtrShortcodeFunModalProperties.closeModalProperties;

			wtrProgressInfo( 1 );

			// load modal
			wtrAjaxSaveSht.done(function(){

				if( mode == 'propertiesPrev' )
				{
					window.wtr_shr_trigger.safe_data = DeepCloneObj( window.wtr_shr_trigger.data );
				}

				modalVer.box.show({
					url:		modalType,
					opacity:	opacity,
					width:		size.w,
					height:		size.h,
					topsplit:	WtrSHR.optionModalIndex.topsplit,
					openjs:		WtrShortcodeFunModalProperties.openModal,
					closejs:	closeFunctionVersion,
				});

				if( mode == 'propertiesPrev' )
				{
					// no restore data - set wsk
					$('.tmask-properties').attr( 'data-restore-source', 1 );
				}
			});
		},// show Modal


		openModal : function()
		{
			ScriptLoaded = new WtrObjsLoader();
			ScriptLoaded.initScriptObject();

			// hide fields
			$( '.ModalHide' ).parents( '.wonsterFiled ' ).hide();

			// bind js events
			var type = $( '.wtrFieldsContainer' ).attr( 'type' );
			var objS = WtrShortcodeDefElement[ type ];

			WtrShortcodeDefElement.setDependencyElement();
			if( objS != undefined && typeof(objS.initEvent) == 'function' )
			{
				objS.initEvent();
			}

			wtrProgressInfo( 0 );

			WtrShortcodeFunModalProperties._clickClose();
			WtrShortcodeFunModalIndex._clickInsert();
			WtrShortcodeFunModalIndex.finishRender();
			WtrShortcodeFunModalIndex._clickPrevShortcode();
			WtrShortcodeFunModalIndex._clickGroupOptions();
			WtrShortcodeFunModalProperties.WtrResetModalStyle( WtrShortcodeFunModalProperties.mode, WtrShortcodeFunModalProperties.modal_size );

			// fix tinymce sroll
			var divSecond	= $( '.wtrFieldsContainerShortcodes' );
			var divThird	= $( '.wtrFieldsContainerProperties' );
			var div			= ( divThird.length )? divThird : divSecond;
			div.scrollTop(0);
		},// end openModal


		closeModalPB : function()
		{

			WtrShortcodeFunModalIndex.showScroll();
			$('.tbox-pb').removeClass( 'tbox-pb2' );
		},// end closeModalPB


		closeModalProperties : function()
		{
			if( 0 == $( '.wtrFieldsContainerProperties' ).length && window.wtr_shr_trigger.safe_data )
			{
				window.wtr_shr_trigger.data = DeepCloneObj( window.wtr_shr_trigger.safe_data );
			}
		},// end closeModalProperties


		_clickClose : function()
		{
			var clsp = $( '.tclose-properties' );
			var cls  = $( '.tclose' );

			if( clsp.length )
			{
				var mask = $( '.tmask-properties' );
				mask.die( 'click' ).live('click', function( e ){

					// fix tinymce
					var tinyMCE = $( '.Tinymce' );

					if( tinyMCE.length )
					{
						tinyMCE.each(function( i, e ){
							var name = $( e ).attr( 'name' );

							if( '4' == tinymce.majorVersion )
							{
								tinymce.execCommand('mceRemoveEditor', false, name );
							}
						});

						$('.wtrFieldsContainerShortcodes').find( '.switch-tmce' ).trigger('click');
					}

					var attr = mask.attr('data-restore-source');

					if (typeof attr !== 'undefined' && attr !== false)
					{
						mask.removeAttr( 'data-restore-source' );
					}
					else if( window.wtr_shr_trigger.safe_data )
					{
						window.wtr_shr_trigger.data = DeepCloneObj( window.wtr_shr_trigger.safe_data );
					}
				});

				clsp.die( 'click' ).live('click', function( event ){
					event.preventDefault();
					mask.trigger( 'click' );
				});
			}
			else if( cls.length )
			{
				var mask = $( '.tmask-pb' );
				mask.die( 'click' ).live('click', function( e ){

					// fix tinymce
					var tinyMCE = $( '.Tinymce' );
					if( tinyMCE.length )
					{
						tinyMCE.each(function( i, e ){
							var name = $( e ).attr( 'name' );

							if( '4' == tinymce.majorVersion )
							{
								tinymce.execCommand('mceRemoveEditor', false, name );
							}
						});

						//$('.wtrFieldsContainerShortcodes').find( '.witch-tmce' ).trigger('click');
					}

					var attr = mask.attr('data-restore-source');

					if (typeof attr !== 'undefined' && attr !== false)
					{
						mask.removeAttr( 'data-restore-source' );
					}
					else if( window.wtr_shr_trigger.safe_data )
					{
						window.wtr_shr_trigger.data = DeepCloneObj( window.wtr_shr_trigger.safe_data );
					}
				});

				cls.die( 'click' ).live('click', function( event ){
					event.preventDefault();
					mask.trigger( 'click' );
				});
			}
		},// end _clickClose


		calcModalCss : function( source )
		{
			var w = $( window ).width();
			var h = $( window ).height();

			if ( 'yes' == source.fullscreenW )
			{
				var winWidthWorkArea = w - 110;
			}
			else
			{
				var winWidthWorkArea = ( source.width > w - 60  )? w - 110 : source.width - 50;
			}

			if ( 'yes' == source.fullscreenH )
			{
				var winHeightWorkArea = h - 135;
			}
			else
			{
				var winHeightWorkArea = ( source.height > h - 60 )? h - 135 : source.height - 50;
			}

			return { w: winWidthWorkArea, h: winHeightWorkArea };
		},// end calcModalCss


		WtrResetModalStyle : function( mode, source )
		{
			var opt;
			var min;

			if( 'properties' == mode || 'properties' == mode.substr(0,10) )
			{
				opt = 'properties';
				min = 50;
			}
			else if( 'pb' == mode )
			{
				opt = 'pb';
				min = 0;
			}

			$( window ).resize(function() {

				// width auto modal
				if ( 'yes' == source.fullscreenW )
				{
					if( $( '.container-shortcode' ).length )
					{
						$( '.tbox-' + opt ).addClass( 'tbox-' + opt + '2' );
						$( '.tinner-' + opt ).css( 'width', '100%' );
						$( '.tbox-' + opt ).css({
							'max-width' : '',
						});
					}
				}
				else
				{
					if( $( '.container-shortcode' ).length )
					{
						$( '.tbox-' + opt ).addClass( 'tbox-' + opt + '2' );
						$( '.tinner-' + opt ).css( 'width', '100%' );
						$( '.tbox-' + opt ).css({
							'max-width' : ( source.width - min ) + 'px',
						});
					}
				}

				// height auto modal
				if ( 'yes'  == source.fullscreenH )
				{
					if( $( '.container-shortcode' ).length )
					{
						$( '.tbox-' + opt ).addClass( 'tbox-' + opt + '2' );
						$( '.tinner-' + opt ).css( 'height', 'auto' );
						$( '.tbox-' + opt ).css({
							'max-height' : '',
						});
					}
				}
				else
				{
					if( $( '.container-shortcode' ).length )
					{
						$( '.tbox-' + opt ).addClass( 'tbox-' + opt + '2' );
						$( '.tinner-' + opt ).css( 'height', 'auto' );
						$( '.tbox-' + opt ).css({
							'max-height' : ( source.height - min ) + 'px',
						});
					}
				}
			});
		}// end WtrResetModalStyle
	} // end WtrShortcodeModalProperties


	//### WtrShortcodeIndex ###
	WtrShortcodeIndex.prototype = {

		// WP parameters sent by PHP
		param : null,
		tinymce_destiny : null,

		// default settings index window
		optionModalIndex :
		{
			opacity		: 50,
			width		: 710,
			height		: 291,
			topsplit	: 2
		},


		initModal : function( opt, txt )
		{
			this.param = DeepCloneObj( wtr_shr_param );
			this.optionModalIndex = $.extend( {}, this.optionModalIndex, opt );

			if( txt != undefined && txt == 1 )
			{
				var mks = false;
			}
			else
			{
				var mks = true;
			}

			$('.tbox2').removeClass('tbox');
			$('.tbox2').css({
				'max-height'	: '',
				'max-width'		: '',
				'left'			: '',
				'right'			: ''
			});

			WtrShortcodeFunModalIndex.hideScroll();
			wtrProgressInfo( 1 );

			// open modal index shortcode
			TINY.box.show({
				url:		this.param.uri + '/page-builder/tinymce/view/indexModal.php',
				opacity:	this.optionModalIndex.opacity,
				width:		this.optionModalIndex.width,
				height:		this.optionModalIndex.height,
				topsplit:	this.optionModalIndex.topsplit,
				openjs:		$.proxy( this.openModal, this ),
				closejs:	$.proxy( this.closeModal, this ),
				mask:		mks
			});
		},// end initModal


		initEvents : function()
		{
			this._clickShortcodeIcon();
			this._clickClose();
		},// end initEvents


		openModal : function()
		{
			// init  index tabs
				$( '#wtrModalTabs' ).easyResponsiveTabs({
					type: 'default',					//Types: default, vertical, accordion
					width: 'auto',						//auto or any width like 600px
					fit: true,							// 100% fit in a container
					closed: 'accordion',				// Start closed if in accordion view
					activate: function(event) {			// Callback function if tab is switched
						var $tab = $( this );
						var $info = $( '#tabInfo' );
						var $name = $( 'span', $info );

						$name.text( $tab.text() );
						$info.show();

						// get modal height
						var modalH= $( '.wtrWpModal' ).css( 'height' );

						// change modal height
						$('.tinner').css( 'height',  modalH);
					}
				});

			// init events

			this.initEvents();
			wtrProgressInfo( 0 );
		},// end openModal


		// cleaning garbage
		closeModal : function()
		{
			WtrShortcodeFunModalIndex.showScroll();
		},// end closeModal


		_clickShortcodeIcon : function()
		{
			WtrShortcodeFunModalIndex.initEvents();
		}, // end clickShortcodeIcon


		_clickClose : function()
		{
			//btn close
			$( '.tclose' ).click(function( event ){
				event.preventDefault();

				// hide modal
				$( '.tmask' ).trigger( 'click' );
			});
		},// end _clickClose


		removeLine : function()
		{
			// remove dotted line of the last element
			if( $( '#ShortcodeFieldsFormShortcodes' ).length )
			{
				var wonsterFiled = $( '#ShortcodeFieldsFormShortcodes .wonsterFiled' );
			}
			else
			{
				var wonsterFiled = $( '#ShortcodeFieldsFormProperties .wonsterFiled' );
			}

			wonsterFiled.removeClass( 'last' );
			wonsterFiled.siblings( ':visible' ).last().addClass( 'last' );
		},// end removeLine


		setScrollMove : function ( stal, act, obj, scrollAcrion ){

			var stal		= parseInt( stal );
			var divSecond	= $( '.wtrFieldsContainerShortcodes' );
			var divThird	= $( '.wtrFieldsContainerProperties' );
			var div			= ( divThird.length )? divThird : divSecond;
			var scroll		= div.scrollTop();
			var objC		= obj.length;
			var mainScroll	= $( document ).scrollTop();
			var self =		this;

			obj.each(function( i, e ){
				$( e ).fadeIn(400, function(){
					if( scrollAcrion &&  ( objC - 1 ==  i ) )
					{
						div.animate( { scrollTop: ( scroll + act.offset().top - stal - mainScroll ) }, 'slow' );
						self.removeLine();
					}
				});
				$( e ).show();
			});
		}// end setScrollMove
	}// end WtrShortcodeIndex.prototype


	//### WtrShortcodeModal ###
	WtrShortcodeModalIndex.prototype = {

		initEvents : function()
		{
			this._clickTriggerSelf();
			this._clickTriggerModal();
			this._clickBackModal();
			this._clickGroupOptions();
			this._clickInsert();
			this._clickPrevShortcode();
		},// end initEvents


		returnShortcode : function( shr )
		{
			if( window.tinyMCE )
			{
				if( '4' == tinymce.majorVersion )
				{
					tinymce.get( WtrSHR.tinymce_destiny ).insertContent( shr );
				}
			}

			$( '.wtrModalClose' ).trigger( 'click' );
		},// end returnShortcode


		_clickTriggerSelf : function()
		{
			$( '.wtr_shortcode_target_self' ).click( function( event ){
				event.preventDefault();
				var shr = $( this ).children( '.srtBtnIco' ).attr( 'data-shortcode-code' );
				WtrShortcodeFunModalIndex.returnShortcode( shr );
			});
		},// _clickTriggerSelf


		_clickTriggerModal : function()
		{
			$( '.wtr_shortcode_target_new_modal' ).on( 'click', function( event ){
				event.preventDefault();

				var d		= $( this ).children( '.srtBtnIco' );
				var w		= d.attr( 'data-modal-w' );
				var h		= d.attr( 'data-modal-h' );
				var wMode	= d.attr( 'data-width-mode' );
				var hMode	= d.attr( 'data-height-mode' );

				//clean global
				CleanWtrTrigger();

				// set of indicators modal facility
				window.wtr_shr_trigger.item  = { id				: 'default',
												 active_opt		: null,
												 active_field	: null,
												 type			: d.attr( 'data-shortcode-modal' )
												};

				window.wtr_shr_trigger.data  = DeepCloneObj( wtr_shr_param.default_sht[ window.wtr_shr_trigger.item.type ].fields );
				window.wtr_shr_trigger.type	 = 'shortcode';

				// loading settings screen shortcode
				WtrModalShortcodeLoader.initModal( window.wtr_shr_trigger.item.type, w, h, wMode,  hMode );
			});
		},// _clickTriggerModal


		_clickBackModal : function()
		{
			$( '.wtrModalBack' ).die( 'click' ).live( 'click', function( event ){
				event.preventDefault();

				// fix tinymce
				var tinyMCE = $( '.Tinymce' );
				if( tinyMCE.length )
				{
					tinyMCE.each(function( i, e ){
						var name = $( e ).attr( 'name' );

						if( '4' == tinymce.majorVersion )
						{
							tinymce.execCommand('mceRemoveEditor', false, name );
						}
					});
				}

				// reset style index modal shortcode
				$( '.tbox2' ).css({ 'max-width'		: '',
									'max-height'	: '',
									'top' 			: ''
								  });
				WtrSHR.initModal( [], 1 );
			});
		},// end _clickBackModal


		_clickGroupOptions : function()
		{
			$( '.wtrGroupDisplayTrigger' ).die( 'click' ).live( 'click', function( event ){

				var $self		= $( this ),
					triggerElem	= $self.data( 'group' );

				$( '.wtrGroupOptionTabs' ).removeClass( 'activeWtrTab' ).addClass( 'nonActiveWtrTab' );
				$self.addClass('activeWtrTab').removeClass( 'nonActiveWtrTab' );

				$( '.wtr_subform_option' ).hide();
				$( '.' + triggerElem ).show();
			});
		}, // end _clickGroupOptions


		hideScroll : function(){
			if ( $(document).height() > $(window).height() )
			{
				var scrollTop = ( $( 'html' ).scrollTop()) ? $( 'html' ).scrollTop() : $( 'body' ).scrollTop(); // Works for Chrome, Firefox, IE...
				$('html').css({ 'overflow': 'hidden', 'height': '100%' });
				$('html').css( 'top', -scrollTop );
			}
		},// end hideScroll


		showScroll : function(){
			$('html').css({ 'overflow': 'auto', 'height': 'auto' });
		},


		_clickInsert : function()
		{
			$( '.wtrInsertSortcut' ).die( 'click' ).live( 'click', function( event, prevMode ){
				event.preventDefault();

				var self			= $( this ),
					FieldsValStd	= [],
					FieldsValSpl	= [],
					FieldsOnj		= {},
					opt_short		= [],
					shr				= '';

				if( ! self.hasClass( 'wtrInsertSortcutProperties' ) )
				{
					var AllFields		= $('.wtr_data_shortcodes').find( '.ModalFields' );
					var AllFieldsForm	= $( '#ShortcodeFieldsFormShortcodes' ).serialize();
					var data			= $( '.wtrFieldsContainerShortcodes' );
					var type			= data.attr( 'type' );
					var end_el			= data.attr( 'end_el' );
				}
				else
				{
					var AllFields		= $('.wtr_data_properties').find( '.ModalFields' );
					var AllFieldsForm	= $( '#ShortcodeFieldsFormProperties' ).serialize();
					var data			= $( '.wtrFieldsContainerProperties' );
					var type			= data.attr( 'type' );
					var end_el			= data.attr( 'end_el' );
				}

				var AllFieldsVal = WtrShortcodeFunModalIndex.getFieldsFormVal( AllFieldsForm );

				AllFields.each( function( i, e ){
					var el = $( e );
					var nameTmp = el.attr( 'name' );

					if( undefined != nameTmp )
					{

						var tmpName = ( nameTmp ).replace( type + '_' , '' );

						if( 'exist' != AllFieldsVal[ nameTmp ] )
						{
							// getting the standard value
							if( el.hasClass( 'ReadStandard' ) )
							{
								var flag = true;
								if(el.hasClass( 'MustValue' ) && '' == $.trim( AllFieldsVal[ nameTmp ] ) )
								{
									flag = false;
								}

								if( flag )
								{
									if( el.hasClass( 'VCModUrl' ) ){
										FieldsValStd.push( tmpName + '="url:' + encodeURIComponent( AllFieldsVal[ nameTmp ] ) + '"' );
										FieldsOnj[ nameTmp ] = { value : AllFieldsVal[ nameTmp ] };
									}else{
										FieldsValStd.push( tmpName + '="' + AllFieldsVal[ nameTmp ] + '"' );
										FieldsOnj[ nameTmp ] = { value : AllFieldsVal[ nameTmp ] };
									}
								}

							}
							else if( el.hasClass( 'ReadSize' ) )
							{
								FieldsOnj[ nameTmp ] = { value : AllFieldsVal[ nameTmp ] };
								var size = AllFieldsVal[ nameTmp ].split( '-' );
								FieldsValStd.push( 'width="' + size[ 0 ] + '"' );
								FieldsValStd.push( 'height="' + size[ 1 ] + '"' );
							}
							else if( el.hasClass( 'ReadScroll' ) )
							{
								var valS	= AllFieldsVal[ nameTmp ];
								valS		= valS.replace( ' px', '' );
								valS		= valS.replace( ' %', '' );

								FieldsValStd.push( tmpName + '="' + valS + '"' );
								FieldsOnj[ nameTmp ] = { value : AllFieldsVal[ nameTmp ] };
							}
							else if( el.hasClass( 'ReadColorWithoutHash' ) )
							{
								var str		= AllFieldsVal[ nameTmp ];
								var strT	= str.substr(1);

								FieldsValStd.push( tmpName + '="' + strT + '"' );
								FieldsOnj[ nameTmp ] = { value : strT };
							}
							else if( el.hasClass( 'ReadColorHash' ) )
							{
								var str		= AllFieldsVal[ nameTmp ];
								var strT	= str.substr(1);

								FieldsValStd.push( tmpName + '="' + '#' +  strT + '"' );
								FieldsOnj[ nameTmp ] = { value :  '#' + strT };
							}
							// default video shortcode
							else if( el.hasClass( 'VideoSrc' ) )
							{
								var valid	= [ 'mp4', 'm4v', 'webm', 'ogv', 'wmv', 'flv' ];
								var exD		= AllFieldsVal[ nameTmp ];
								var ext		= exD.split(".").pop();

								if( el.hasClass( 'TypeImportant' ) )
								{
									ext = tmpName;
								}

								FieldsValStd.push( ( ( -1 != valid.indexOf( ext ) )? ext : tmpName )+ '="' + AllFieldsVal[ nameTmp ] + '"' );
								FieldsOnj[ nameTmp ] = { value : AllFieldsVal[ nameTmp ] };
							}
							// default audio shortcode
							else if( el.hasClass( 'AudioSrc' ) )
							{
								var valid	= [ 'mp3', 'm4a', 'ogg', 'wav', 'wma' ];
								var exD		= AllFieldsVal[ nameTmp ];
								var ext		= exD.split(".").pop();

								FieldsValStd.push( ( ( -1 != valid.indexOf( ext ) )? ext : tmpName )+ '="' + AllFieldsVal[ nameTmp ] + '"' );
								FieldsOnj[ nameTmp ] = { value : AllFieldsVal[ nameTmp ] };
							}
							else if( el.hasClass( 'SimleTextBetween' ) )
							{
								FieldsValSpl.push( AllFieldsVal[ nameTmp ] );
								FieldsOnj[ nameTmp ] = { value : AllFieldsVal[ nameTmp ] };
							}
							else if( el.hasClass( 'Tinymce' ) )
							{
								// fix text mode -> convert to html
								$( '.' + nameTmp + '_activation' ).trigger( 'click' );
								$( '#' + nameTmp + '-tmce' ).trigger( 'click' );

								var val = ( null === tinymce.get( nameTmp ) || undefined === tinymce.get( nameTmp ) )? $( '#'+ nameTmp ).val() : tinymce.get( nameTmp ).getContent();
									val = val.replace(/"/g, '``');

								if( el.hasClass( 'TinymceAttr' ) )
								{
									FieldsValStd.push( tmpName + '="' + val + '"' );
								}
								else
								{
									FieldsValSpl.push( val );
								}
								FieldsOnj[ nameTmp ] = { value : val };

								// fix tinymce
								if( '4' == tinymce.majorVersion )
								{
									tinymce.execCommand('mceRemoveEditor', false, name );
								}
							}
							else if( el.hasClass('SaveOnly') )
							{
								FieldsOnj[ nameTmp ] = { value : AllFieldsVal[ nameTmp ] };
							}
							else if( el.hasClass( 'SortableObj' ) )
							{
								if( el.hasClass( 'SortableObjNoneSht' ) )
								{
									FieldsOnj[ nameTmp ] = { value : AllFieldsVal[ nameTmp ] };
								}
								else
								{
									var li_sht	= el.find( '.Wtr_Opt_Shortcode' );
									var li_txt	= el.find( '.wtr_accordItemNameCode' );
									var out		= '';
									var str		= '';

									// gent head - shotcut tabs
									if( el.hasClass( 'GenHeadInfo' ) && ! self.hasClass( 'wtrInsertSortcutProperties' ) )
									{
										li_txt.each(function( i , e ){
											FieldsValStd.push( 'tab' + ( i + 1 ) + '="' + $( e ).text() + '"' );
										});
									}

									if( li_sht.length )
										str = out;

									// get saved & default shortcode
									li_sht.each(function( i , e ){
										var cX = $( e ).val();
										str += cX + out;
										opt_short[ i ]= cX;
									});
									FieldsValSpl.push( str );

									if( ! self.hasClass( 'wtrInsertSortcutProperties' ) && 'pb' == window.wtr_shr_trigger.type )
									{
										FieldsOnj[ nameTmp ] = DeepCloneObj( window.wtr_shr_trigger.data[ nameTmp ] );
										FieldsOnj[ nameTmp ].option_shortcode = DeepCloneObj( opt_short );
									}
								}
							}
							else if( el.hasClass( 'GeoMapsVal' ) )
							{
								var parentV = $( e ).attr( 'data-parent-name' );
								if( undefined == FieldsOnj[ parentV ] )
								{
									FieldsOnj[ parentV ] = { value : '' };
								}

								FieldsValStd.push( tmpName + '="' + AllFieldsVal[ nameTmp ] + '"' );
								FieldsOnj[ parentV][ nameTmp ]  = AllFieldsVal[ nameTmp ];
							}
							else if ( el.hasClass( 'TableFields' ) )
							{
								//Get number of columns
								var colC			= $( '.Wtr_Table_Delete_Col' ).length;
								var rowC			= $( '.Wtr_Table_Delete_Row' ).length;
								var cellNotEmpty	= $( '.wtrTableItemValue' );
								var rowAttr			= {};
								var colAttr			= {};
								var cellVal			= {};
								var shtChild		= '';
								var out				= '<br /><br />';
								var wtr_row			= 'wtr_row';
								var wtr_cell		= 'wtr_cell';
								var cellCounter		= 0;

								// Get val Cell
								cellNotEmpty.each(function( i, e ){
									var self = $( e );
									cellVal[ self.parents( '.wtrTableCellEditable' ).attr( 'data-id-cell' ) ] = self.val();
								});

								//Get rows attr
								$( '.TableSelectRow' ).each( function( i, e ){
									var val =  $( e ).val();
									rowAttr[ i ] = val;
								});
								window.wtr_shr_trigger.data[ nameTmp ].rows_attr = rowAttr;

								//Get rows attr7
								$( '.TableSelectCol' ).each( function( i, e ){
									var val =  $( e ).val();
									 colAttr[ i ] = val;
								});
								window.wtr_shr_trigger.data[ nameTmp ].cols_attr = colAttr;

								for(var i = 0; i < rowC; i++ )
								{
									shtChild +=  out + '[' + wtr_row + ' type="' + rowAttr[ i ] + '"]' + out;
									for(var j = 0; j < colC; j++ )
									{
										var cellValOne  = (typeof  cellVal[ cellCounter ] != 'undefined' )? cellVal[ cellCounter ] : '';
										shtChild +=  '[' + wtr_cell + ' type="' + colAttr[ j ] + '"]' + cellValOne + '[/' + wtr_cell + ']' + out;
										++cellCounter;
									}
									shtChild += '[/' + wtr_row + ']';
								}

								FieldsValSpl.push( shtChild );

								if( ! self.hasClass( 'wtrInsertSortcutProperties' ) && 'pb' == window.wtr_shr_trigger.type )
								{
									FieldsOnj[ nameTmp ] = DeepCloneObj( window.wtr_shr_trigger.data[ nameTmp ] );
								}
							}
							else if( el.hasClass( 'OnlnyValue' ) )
							{
								FieldsValStd.push( AllFieldsVal[ nameTmp ] );
								FieldsOnj[ nameTmp ] = { value : AllFieldsVal[ nameTmp ] };
							}

							AllFieldsVal[ nameTmp ] = 'exist';
						}
					}
				});

				if( self.hasClass( 'wtrInsertSortcutProperties' ) )
				{
					type	= window.wtr_shr_trigger.item.child_shortcode;
					end_el	= window.wtr_shr_trigger.item.child_end_el;
				}

				// create shortcode
				shr = WtrShortcodeFunModalIndex.generateShortcode( FieldsValStd, FieldsValSpl, type, end_el );

				// bind js events
				var type = $( '.wtrFieldsContainer' ).attr( 'type' );
				var objS = WtrShortcodeDefElement[type];

				WtrShortcodeDefElement.setDependencyElement();
				// generate a shortcode for preview
				if( 'propertiesPrev' == prevMode )
				{
					if( objS != undefined && typeof(objS.insertShtMain) == 'function' )
					{
						shr = objS.insertShtMain( shr );
					}

					window.wtr_shr_trigger.prev_shortcode = encodeURIComponent( shr );

					return;
				}

				// main modal
				if( ! self.hasClass( 'wtrInsertSortcutProperties' ) )
				{
					if( objS != undefined && typeof(objS.insertShtMain) == 'function' )
					{
						shr = objS.insertShtMain( shr );
					}

					if( 'shortcode' == window.wtr_shr_trigger.type )
					{
						// insert shortcode to tinymce
						WtrShortcodeFunModalIndex.returnShortcode( shr );
					}
					else if( 'pb' == window.wtr_shr_trigger.type )
					{
						// update global obj - pb
						var idY = window.wtr_shr_trigger.item.id;
						wtr_shr_param.page_builder[ idY ].fields	= DeepCloneObj( FieldsOnj );
						wtr_shr_param.page_builder[ idY ].shortcode	= DeepCloneObj( shr );
					}

					window.wtr_shr_trigger.item = { type			: null,
													id				: null,
													active_opt		: null,
													active_field	: null,
													child_end_el	: null,
													child_shortcode	: null,
												  };

					$( '.wtrModalClose, .tmask-pb' ).trigger( 'click' );
				}
				// edit item
				else
				{
					// update Obj Status
					WtrShortcodeFunModalIndex.updateObjValue( FieldsOnj, shr );
					$( '.tmask-properties' ).trigger( 'click' );
				}
			});
		},// end _clickInsert


		_clickPrevShortcode : function()
		{
			$( '.wonBtnPreview' ).die( 'click' ).live( 'click', function( event ){
				event.preventDefault();

				var sht_type	= window.wtr_shr_trigger.data.type_external.value;

				// get basic sht template
				var size_m	= wtr_shr_param.default_sht[ sht_type ].prev_size;

				// generate a shortcode for preview
				$( '.wtrInsertSortcut' ).trigger('click', 'propertiesPrev' );

				//clean css modal
				WtrModalShortcodeLoader.cleanCssModalProperties();

				// show modal
				WtrShortcodeFunModalProperties.showModal( sht_type, size_m, 'propertiesPrev' );

				window.wtr_shr_trigger.prev_shortcode = null;
			});
		},// end _clickPrevShortcode


		updateObjValue : function( data , shr )
		{
			var id				= window.wtr_shr_trigger.item.active_opt;
			var ulId			= window.wtr_shr_trigger.item.active_field;
			var ulIdType		= window.wtr_shr_trigger.item.active_field_t;
			var rewrite			= window.wtr_shr_trigger.safe_data[ ulId ].defautl_rewrite;
			var prev			= window.wtr_shr_trigger.safe_data[ ulId ].option_prev;
			var dataFinishFun	= {};
			var text_final,
				fullTextStip,
				prev_field;

			// if rewrite
				var rewriteC = rewrite.length;
				for( var k = 0; k < rewriteC; k++ )
				{
					var zt		= rewrite[ k ];
					var org		= window.wtr_shr_trigger.safe_data[ ulId ].default_option[ 0 ][ zt ].value;
					var new_v	= data[ zt ].value;

					window.wtr_shr_trigger.safe_data[ ulId ].default_option[ 0 ][ zt ].value = new_v;
					window.wtr_shr_trigger.safe_data[ ulId ].default_shortcode[ 0 ] = ( window.wtr_shr_trigger.safe_data[ ulId ].default_shortcode[ 0 ] ).replace( org, new_v );
				}

			// save data
				window.wtr_shr_trigger.data = DeepCloneObj( window.wtr_shr_trigger.safe_data );
				var type_external 	= window.wtr_shr_trigger.data.type_external.value;

			// update the option item
				window.wtr_shr_trigger.data[ ulId ].option[ id ] = DeepCloneObj( data );
				window.wtr_shr_trigger.data[ ulId ].option_shortcode[ id ] = shr;
					window.wtr_shr_trigger.safe_data = window.wtr_shr_trigger.data;

			// update html - return changes
				if( 'WTR_Shortcode_Table' == type_external )
				{
					prev_field =  data[ prev[ window.wtr_shr_trigger.item.type ] ].value;
				}
				else
				{
					prev_field = data[ prev ].value;
				}

				fullTextStip = prev_field.replace( /<[^>]+>/ig, '' );
				fullTextStip = fullTextStip.replace(/``/g, '"');

				if( fullTextStip.length >= window.wtr_shr_trigger.item.prev_cut )
				{
					text_final = fullTextStip.substr( 0, window.wtr_shr_trigger.item.prev_cut ) + '...';
				}
				else
				{
					text_final = fullTextStip;
				}

				window.wtr_shr_trigger.item = DeepCloneObj( window.wtr_shr_trigger.safe_item );

				if( 'WTR_Shortcode_Table' == type_external )
				{
					dataFinishFun = {
						item		: id,
						ulId		: ulId,
						data		: data,
						shr			: shr,
						text_final	: text_final
					}
				}
				else
				{
					dataFinishFun = {
						ulId		: ulId,
						id			: id,
						shr			: shr,
						prev		: prev,
						data		: data,
						text_final	: text_final
					}
				}

				ScriptLoaded[ ulIdType ].finishObj( dataFinishFun );

				// action execution shortcode ??? !!!
				var typeMain		= $( '.wtrFieldsContainerShortcodes' ).attr( 'type' );
				var typeProperties	= $( '.wtrFieldsContainerProperties' ).attr( 'type' );
				var type			= ( typeMain == typeProperties )? typeMain : typeProperties;
				var objS			= WtrShortcodeDefElement[type];

				WtrShortcodeDefElement.setDependencyElement();
				if( objS != undefined && typeof(objS.insertShtProperties) == 'function' )
				{
					shr = objS.insertShtProperties( dataFinishFun );
				}
		},// end updateObjValue


		getFieldsFormVal : function( val )
		{
			var r = {};

			if( val )
			{
				var tmp = [];
				var tmpC;

				tmp		= val.split( '&' );
				tmpC	= tmp.length;

				for( var i = 0; i < tmpC ; ++i )
				{
					var elem = tmp[i].split( '=' );
					r[ elem[ 0 ] ] = $.trim(  decodeURIComponent( elem[ 1 ].replace(/\+/g, ' ' ) ) );
				}
			}
			return r;
		},// end getFieldsFormVal


		generateShortcode : function( elstd, elspl, type, end_el )
		{
			if( 'none' != type )
			{
				var stdC	= elstd.length;
				var elsplC	= elspl.length;
				var r		= '[' + type + ( ( stdC )? ' ' + elstd.join( ' ' ) : '' ) + ']';

				if( end_el )
				{
					r += elspl.join(' ') + '[/' + type + ']';
				}
			}
			else
			{
				var r = elspl[ 0 ];
			}
			return r.replace(/&quot;/g,'"');
		},// end generateShortcode


		finishRender : function()
		{
			// remove dotted line of the last element
			var wonsterFiledMain		= $( '#ShortcodeFieldsFormShortcodes .wonsterFiled' );
			var wonsterFiledProperties	= $( '#ShortcodeFieldsFormProperties .wonsterFiled' );
			var wonsterFiled			= ( wonsterFiledProperties.length )? wonsterFiledProperties : wonsterFiledMain;

			wonsterFiled.removeClass( 'last' );

			if( wonsterFiled.length > 1 )
			{
				wonsterFiled.siblings( ':visible' ).last().addClass( 'last' );
			}
			else
			{
				wonsterFiled.last( ':visible' ).addClass( 'last' );
			}
		},// end textareaToTinyMce

	}// end WtrShortcodeModalIndex.prototype

	// fix tiny mce
	$( '.wtrModalClose, .tmask' ).die('click').live('click', function( event ){
		event.preventDefault();

		var tinyMCE = $( '.Tinymce' );
		if( tinyMCE.length )
		{
			tinyMCE.each(function( i, e ){
				var name = $( e ).attr( 'name' );

				if( '4' == tinymce.majorVersion )
				{
					tinymce.execCommand('mceRemoveEditor', false, name );
				}

				/*	if($('.wtrFieldsContainerShortcodes').find( '.switch-tmce' ).length)
					$('.wtrFieldsContainerShortcodes').find( '.switch-tmce' ).trigger('click');*/
			});
		}

		if( $( '.tmask-properties' ).is(":visible" ) )
		{
			$( '.tmask-properties' ).trigger( 'click' );
		}
		else{
			$( '.tmask-pb' ).trigger( 'click' );
		}
	});


	WtrShortcodeElement.prototype = {

		setDependencyElement : function()
		{
			var checkDependencyElement = function( $e, val_f, val )
			{
				var flag	= false;
				var val_l	= val.length;

				for( var i = 0; i < val_l; i++ ){
					if( val_f == val[ i ] ){
						flag = true;
						break;
					}
				}

				if( flag )
					$e.show();
				else
					$e.hide();

				WtrSHR.removeLine();

			}// end checkDependencyElement

			var dependency = $( '.dependency' );
			if( dependency.length ){

				dependency.each(function( i, e ){
					var $e		= $( e );
					var field	= $( '#' + $e.data( 'field-dependency' ) );

					var val		= ( $e.data( 'option-dependency' ).toString() ).split( '|' );
					var eventT	= null;

					if( "INPUT" == field.get(0).tagName ){
						eventT = 'keyup';
					}
					else if( "SELECT" == field.get(0).tagName ){
						eventT = 'change';
					}

					field[ eventT ](function(event) {
						var val_f	= $( this ).val();
						checkDependencyElement( $e, val_f, val );
					});
					field.trigger( eventT );
				});
			}
		},//end setDependencyElement
	}// WtrShortcodeElement
})(jQuery);


CleanWtrTrigger = function()
{
	window.wtr_shr_trigger = {};
	window.wtr_shr_trigger = { item : {}, safe_data : {}, data : {} }
} // end CleanWtrTrigger


wtrSetShtData = function( name_var, value_var )
{
	return jQuery.ajax({
		url: wtr_shr_param.uri + '/page-builder/wtr-shortcodes/wtr_set_data_sht.php',
		type: 'POST',
		data: 'wtr_sht_id_data=' + name_var + '&wtr_sht_data=' + value_var ,
	}).promise();

}// end wtrSetCookie


wtrProgressInfo = function( opt )
{
	if( opt )
	{
		jQuery( 'body, a, span, .srtBtnIco' ).addClass( 'wtrProgressInfoLoader' );
	}
	else
	{
		jQuery( 'body, a, span, .srtBtnIco' ).removeClass( 'wtrProgressInfoLoader' );
	}
}// end wtrProgressInfo

wtrSetShtIdData = function()
{
	return 'wtr_sht_id_' + (new Date().getTime() + Math.floor((Math.random()*10)+1) );
}// end wtrSetShtIdData


DeepCloneObj = function( a )
{
	return JSON.parse(JSON.stringify(a));
}// end DeepCloneObj


// create object - modal shortcodes
var WtrSHR							= new WtrShortcodeIndex();
var WtrShortcodeFunModalIndex		= new WtrShortcodeModalIndex();
var WtrShortcodeFunModalProperties	= new WtrShortcodeModalProperties();
var WtrModalShortcodeLoader			= new WtrShortcodeModalItem();
var WtrShortcodeDefElement			= new WtrShortcodeElement();