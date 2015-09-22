/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

var WtrObjsLoader = function(){};
var WtrObjsSystem = function(){};

(function($) {

	"use strict";

	var selfLoader;
	var ScriptLoaded;

	WtrObjsLoader.prototype = {

		initScriptObject : function()
		{
			selfLoader = this;
			this._objs_dialog_settings_default();
			this._objs_scroll();
			this._objs_img_radio();
			this._objs_btn_radio();
			this._objs_std_radio();
			this._objs_color();
			this._objs_sidebar();
			this._objs_select();
			this._objs_select_multiple();
			this._objs_upload();
			this._objs_font_switch();
			this._objs_icon();
			this._objs_tinyMCE();
			this._objs_sortable.init();
			this._objs_img_sortable();
			this._objs_animate();
			this._objs_datepicker();
			return this;
		},


		_objs_dialog_settings_default : function()
		{
			// Dialog
			var wtr_admin_modal = $('a[rel*=leanModal]');

			if(wtr_admin_modal.length)
			{
				wtr_admin_modal.leanModal({ top : 200, closeButton: ".wtr_admin_modal_close" });
				$('.wtr_admin_modal_close').click(function( event ){
					event.preventDefault();
				});
			}
		},// end _objs_dialog_settings_default


		_objs_scroll : function()
		{
			// Scroll
			var wtr_admin_scroll_field = $( '.wtr_admin_scroll_field' );
			var wtr_admin_scroll_amount = $( '.wtr_admin_scroll_amount' );
			if( wtr_admin_scroll_field.length )
			{
				$( '.wtr_admin_scroll_field' ).each(function( i, e ){
					var wtr_scroll = $( e );

					if( !wtr_scroll.hasClass( 'ui-slider') )
					{
						wtr_scroll.slider({
							range: 'min',
							value: wtr_scroll.data( 'value' ),
							min: wtr_scroll.data( 'min' ),
							max: wtr_scroll.data( 'max' ),

							slide: function( event, ui ) {
								var px_tmp = wtr_scroll.data( 'px' );
								var px = ( px_tmp )? ' ' + px_tmp : '';

								wtr_scroll.attr( 'data-value', ui.value );
								wtr_scroll.next( wtr_admin_scroll_amount ).val( ui.value + px );
							}
						});
					}
				});
			}

			if( wtr_admin_scroll_amount.length )
			{
				wtr_admin_scroll_amount.each( function( i,e ){
					var amount = $( e );
					var scroll = $( e ).siblings( '.wtr_admin_scroll_field' );
					var start_amount = scroll.attr( 'data-value' );
					var px_tmp = scroll.data( 'px' );
					var px = ( px_tmp )? ' ' + px_tmp : '';
					amount.val( $.trim( start_amount ) + px );
				});
			}
		},// end _objs_scroll


		_objs_img_radio : function()
		{
			// Img radio
			var wtr_radio_img = $( '.radio_img' );
			if( wtr_radio_img.length )
			{

				// init
				wtr_radio_img.each(function( i, e ){
					var elem = $(e);
					var chck = elem.data( 'checked' );
					var val = elem.val();

					elem.siblings( 'div.'+ val ).children( 'span' ).addClass( chck );
				});

				$( '.wtr_admin_radio_img_field_click' ).click(function(){
					var self = $( this );
					var imput = self.siblings( 'input' );
					var chck = imput.data( 'checked' );

					self.siblings( 'div' ).children( 'span' ).removeClass( chck );
					self.children( 'span' ).addClass( chck );
					imput.val( self.data( 'value' ) );
				});
			}
		},// end _objs_img_radio


		_objs_btn_radio : function()
		{
			// Img radio
			var wtr_radio_btn = $( '.wtr_admin_btn_radio_field_click' );
			if( wtr_radio_btn.length )
			{

				// init
				wtr_radio_btn.each(function( i, e ){
					var elem = $(e);
					var chck = elem.data( 'checked' );

					if( chck )
					{
						var val = elem.val();
						elem.siblings( '.wtr_admin_btn_radio_field_click' ).children( '.' + val ).find( 'span' ).addClass( chck );
					}
				});

				wtr_radio_btn.click(function(){
					var self = $( this );
					var val = self.children( '.wtr_admin_btn_radio_field' ).data( 'value' );
					var imput = self.siblings( 'input' );
					var chck = imput.data( 'checked' );

					self.siblings( 'div' ).find( 'span' ).removeClass( chck );
					self.find( 'span' ).addClass( chck );
					imput.val( val );
				});
			}
		},// end _objs_btn_radio


		_objs_std_radio : function(){
			// Standard Nice Radio
			var str_radio = $('input.wtrStrAdminRadio');

			if(str_radio.length)
			{
				str_radio.prettyCheckable({
					color: 'gray'
				});
			}
		},// end _objs_std_radio


		_objs_color : function()
		{
			// Color Picker

			var wtr_minicolors = $( '.minicolors' );

			if( wtr_minicolors.length )
			{

				$( '.minicolors' ).not('.wtr_read_done').each( function( i, e ) {

					if( !$( e ).hasClass( 'wtr_read_done' ) )
					{
						$( e ).addClass("wtr_read_done");
						$( e ).minicolors({
							control: $( this ).attr( 'data-control' ) || 'hue',
							defaultValue: $( this ).attr( 'data-default-value' ) || '',
							inline: $( this ).hasClass( 'inline' ),
							letterCase: $( this ).hasClass( 'uppercase' ) ? 'uppercase' : 'lowercase',
							opacity: $( this ).hasClass( 'opacity' ),
							position: $( this ).attr( 'data-position' ) || 'default',
							styles: $( this ).attr( 'data-style' ) || '',
							swatchPosition: $( this ).attr( 'data-swatch-position' ) || 'left',
							textfield: !$( this ).hasClass( 'no-textfield' ),
							theme: $( this ).attr( 'data-theme' ) || 'default',
							change: function(hex, opacity) {

								// Generate text to show in console
								var text = hex ? hex : 'transparent';
								if( opacity )
								{
									text += ', ' + opacity;
								}

								text += ' / ' + $( this ).minicolors( 'rgbaString' );
							}
						});
					}
				});
				$( '.minicolors' ).addClass("wtr_read_done");
			}
		},// _objs_color


		_objs_sidebar : function()
		{
			// sidebar elem
			var triggerDelSidebar = null;
			var wtr_admin_modal_close = '.wtr_admin_modal_close';

			// init
				// init input
				var wtr_admin_add_sidebar_input = $( '.wtr_admin_add_sidebar_input' );


				function initWonsterSidebarBoxInput ()
				{
					wtr_admin_add_sidebar_input.val( wtr_admin_add_sidebar_input.data( 'placeholder' ) );
					wtr_admin_add_sidebar_input.focus(function(){
						if( $(this).val() == $(this).data( 'placeholder' ) )
						{
							$(this).val( '' );
						}
					});
					wtr_admin_add_sidebar_input.blur(function(){
						if( !$.trim( $(this).val() ) )
						{
							$(this).val( $(this).data( 'placeholder' ) );
						}
					});
				}// end initWonsterSidebarBoxInput


				// init sidebar select
				function updateSidebarSelectField ( namX ){
					var selectArea = $( '.WtrNoneSidebarSelect' ).find( 'select' );
					var namesSidebar = '';

					$( '.sidebarName' ).each(function( i, e ){
						namesSidebar += '<option value=' + encodeURIComponent( $( e ).text() ) + '>' + unescape( $( e ).text() ) + '</option>';
					});

					selectArea.children( 'option' ).remove();
					selectArea.each(function( i, e ){
						var valC  = $( e ).attr( 'ctrp' );
						$( e ).append( namesSidebar );
						$( e ).find( 'option' ).removeAttr( 'selected' );

						var t = $( e ).find( 'option[value="' + valC  + '"]' );
						if( t.length )
						{
							t.attr( 'selected', 'selected' );
						}
						else
						{
							var valX = $( e ).find( 'option:first' ).val();
							$( e ).attr( 'ctrp',  valX  );
							$( e ).find( 'option[value="' + valX + '"]' ).attr( 'selected', 'selected' );
							$( e ).next( '.out' ).text( unescape( valX) );
						}
					});
					selectArea.parent().fadeIn();
				}//end updateSidebarSelectField


				function initWonsterSelectSidebarBox ( nameSidebar )
				{
					var countSidebar  = $( '.wtr_admin_sidebar_list' ).children( 'li' ).length - 1;
					var selectData    = $( '.WtrNoneSidebarData' );
					var sidebarInfo   = $( '.WtrNoneSidebarInfo' );
					var sidebarValue  = $( '.WtrNoneSidebarValue' );

					// sielect update of sidebar
					if( countSidebar )
					{
						selectData.hide();
						updateSidebarSelectField( nameSidebar );
						sidebarValue.prop( "disabled", true );
					}
					// msg - lack sidebar to choose
					else
					{
						$( '.noSidebar' ).show();
						selectData.hide();
						sidebarInfo.show();
						sidebarValue.prop( "disabled", false );
					}
				}//end initWonsterSelectSidebarBox

				initWonsterSidebarBoxInput();
				initWonsterSelectSidebarBox();

			// add element
			var wtr_admin_add_sidebar = $( '.wtr_admin_add_sidebar' );
			wtr_admin_add_sidebar.click(function( event ){

				event.preventDefault();
				var val				= $.trim( wtr_admin_add_sidebar_input.val() );
					val				= encodeURIComponent( val );
				var tname			= wtr_admin_add_sidebar_input.data( 'tname' );
				var id				= wtr_admin_add_sidebar_input.data( 'id' );
				var placeholder		= wtr_admin_add_sidebar_input.data( 'placeholder' );
				var flagCheck		= $( 'input[value="' + val + '"].wtr_sidebar_name_field' ).length;
				var wtr_a_sidebar_l	= $( '.wtr_admin_sidebar_list' );

				if( val &&  val != encodeURIComponent( placeholder ) && !flagCheck )
				{
					var li		= $( '<li>' ).hide();
					var div		= $( '<div>' ).addClass( 'sidebarName' ).text( decodeURIComponent( val ) );
					var span	= $( '<a>' ).addClass( 'delSidebar wtr_admin_del_sidebar' )
											.attr( 'href', '#wonsterModal_sidebarDel' )
											.attr( 'rel', 'leanModal' )
											.bind( 'click', function(){ delSidebarItem( event, $( this ),  $( this ).prev( '.sidebarName' ).text() ) })
											.leanModal({ top : 200, closeButton: wtr_admin_modal_close });
					var hidden = $( '<input>' ).attr({
						'type' 	: 'hidden',
						'class' : 'wtr_sidebar_name_field',
						'name' 	: tname + '[' + id + '][' + val + ']',
						'value' : val
					});

					if( 2 > wtr_a_sidebar_l.children( 'li' ).length)
					{
						$( '.noSidebar' ).slideUp();
					}

					wtr_a_sidebar_l.append(
						li.append( div ).append( span ).append( hidden )
					);
					li.fadeIn(500);

					// Clear imput
					wtr_admin_add_sidebar_input.val( wtr_admin_add_sidebar_input.data( 'placeholder' ) );

					initWonsterSelectSidebarBox();
				}
			});

			// delete a static element
			$( '.wtr_admin_del_sidebar' ).on( 'click', function( e ){
				var name = $( this ).prev( '.sidebarName' ).text();
				delSidebarItem( e, $( this ) ,  name );
			});

			function delSidebarItem ( e, self, nameSidebar ) {
				e.preventDefault();
				triggerDelSidebar = self;
				$( '#sideBarNameDel' ).text( unescape( nameSidebar ) );
			}

			$( '.wtr_admin_confirm_del_slider' ).bind( 'click', function( event ) {
				event.preventDefault();
				triggerDelSidebar.fadeOut(500, function(){

					triggerDelSidebar.parent().remove();

					if(2 > $( '.wtr_admin_sidebar_list' ).children( 'li' ).length )
					{
						$( '.noSidebar' ).slideDown();
					}

					// update select sidebar
					initWonsterSelectSidebarBox( $( '#sideBarNameDel' ).text() );
				});
				$( wtr_admin_modal_close ).trigger( 'click' );
			});
		},// end _objs_sidebar


		_objs_select : function()
		{
			// Select
			$( '.wtrFieldsContainer select, .wtrPageOptionsTabsContent select, .wtrUIContener select' ).not( '.wtrSelectMultiple' ).change(function () {
				var str = '';
				str = $( this ).find( ':selected' ).text();

				$(this).next( '.out' ).text( unescape( str ) );
				if( undefined != $(this).attr( 'ctrp' ) )
				{
					$(this).attr( 'ctrp', encodeURIComponent( str ) );
					$( this ).children( 'option' ).removeAttr( 'selected' );
					$( this ).find( 'option[value="' + encodeURIComponent( str ) + '"]' ).attr( 'selected', 'selected' );
				}
			}).trigger( 'change' );
		},// end _objs_select


		_objs_select_multiple : function()
		{
			$( '.wtrSelectMultiple' ).change(function(){
				var strOut		= '';
				var selectMulti	= $( this );
				selectMulti.children( 'option:selected' ).each(function( i, e ){
					var opt = $( e );
					strOut += ';' + opt.val() + ';';
				});

				selectMulti.next( '.wtrSelectMultipleHidden' ).val( strOut.replace( /;;/g,';' ) );
			});
		},//end _objs_select_multiple


	_objs_upload : function()
		{
			if( !wp.media )
			{
				return;
			}
			// Uploading files
			var file_framem;
			var	tab					= [];
			var	query;
			var	activeSize;
			var label;
			var id_frame			= 'wtr_file_select_upload';
			var wp_media_post_id	= wp.media.model.settings.post.id;

			$( '.wtr_admin_file_upload' ).unbind().click('click', function( event ){
				var file_frame = null;

				event.preventDefault();
				var parentBtn		= $(this).parents( '.wfSett' ).find( '.imgContener' );
				var titleModal		= $(this).attr( 'title_modal' );
				var filter_content	= $(this).attr( 'filter_content' );
				var target_type		= $(this).attr( 'target_type' );
				var multipleType	= ( 'multi-img' == target_type || 'multi-text' == target_type )? 'add' : false;
				var activeSize		= ( $(this).attr( 'default_size' ).length )? $(this).attr( 'default_size' ) :  'full';
				var typeClass		= ( '' == filter_content || ('image' == filter_content && 'add' != multipleType ) )? '-att-on' : '-att-off';
				var edytor			= $( this ).attr( 'data-editor' );

				// If the media frame already exists, reopen it.
				if ( file_frame )
				{
					file_frame.open();
					return;
				}

				function insertAtCursor(myField, myValue)
				{
					//IE support
					if (document.selection)
					{
						myField.focus();
						sel			= document.selection.createRange();
						sel.text	= myValue;
					}

					//MOZILLA/NETSCAPE support
					else if ( myField.selectionStart || myField.selectionStart == '0' )
					{
						var startPos	= myField.selectionStart;
						var endPos		= myField.selectionEnd;
						myField.value	= myField.value.substring(0, startPos)

						+ myValue + '\n\n'
						+ myField.value.substring(endPos, myField.value.length);
					}
					else
					{
						myField.value += myValue;
					}
				}// end insertAtCursor


				// Create the media frame.
				file_frame = wp.media.frames.file_frame = wp.media({
					id			: id_frame,
					title		: ( 'none' == titleModal)? jQuery( this ).data( 'uploader_title' ) : titleModal,
					library		: { type: filter_content },
					button		: { text: jQuery( this ).data( 'uploader_button_text' ), },
					multiple	: multipleType,
					className	: ' wtr-custom-media-frame-data wtr-custom-media-frame' + typeClass + ' media-frame'
					//frame:      'post',
				});

				file_frame.on('open',function() {
						var _AttachmentDisplay = wp.media.view.Settings.AttachmentDisplay;
						wp.media.view.Settings.AttachmentDisplay = _AttachmentDisplay.extend({
							render: function() {
								_AttachmentDisplay.prototype.render.apply(this, arguments);
								this.$el.find('select.link-to').val('none');
								this.model.set('link', 'none');
								this.updateLinkTo();
							}
						});

				var attachmentWtr = $('.wtr-custom-media-frame-data').find('.attachment-preview');

					attachmentWtr.die( 'click' ).live('click', function(){
						var selectWtr	= $( '.wtr-custom-media-frame-data' ).find( '.attachment-display-settings' );
						var opt			= selectWtr.find( 'option' );

						opt.removeAttr( 'selected' );
						opt.each(function( i, e ){
							var selfWtr = $(e);
							if( activeSize == selfWtr.val() )
							{
								selfWtr.attr('selected', 'selected');
							}
						});
					});
				});

				file_frame.on( 'select', function() {
					var attachment = file_frame.state().get('selection').toJSON();
					var size = $( '.wtr-custom-media-frame-data' ).find('.size').val();

					if( 'hidden' == target_type )
					{
						attachment	= file_frame.state().get( 'selection' ).first().toJSON();
						var fileurl	= attachment.url;

						var spanV	= $( '<span>' ).addClass( 'deleteFoto wtr_admin_deleteFoto' );
						var imgV	= $( '<img>' ).attr('src', fileurl ).addClass( 'wtr_admin_foto_tmb' );

						parentBtn.children( '.wtr_admin_deleteFoto' ).remove();
						parentBtn.children( '.wtr_admin_foto_tmb' ).remove();
						parentBtn.append( spanV ).append( imgV );
						parentBtn.children( 'input' ).val( attachment.id );

						$( 'html' ).removeClass( 'Image' );
						var formfield = null;
					}
					else if( 'text' == target_type )
					{
						attachment	= file_frame.state().get('selection').first().toJSON();
						var fileurl	= attachment.url;
						parentBtn.children( 'input' ).val( fileurl );
					}
					// multi select
					else if( 'multi-img' == target_type )
					{
						var selection	= file_frame.state().get('selection');
						var tab			= [];
						selection.map( function( attachment ) {
							attachment = attachment.toJSON();

							if( 'undefined' != typeof attachment.sizes && 'undefined' != typeof attachment.sizes.thumbnail )
							{
								tab.push( { 'thumb' : attachment.sizes.thumbnail.url, 'id' : attachment.id } );
							}
							//tab.push(attachment.url);
						});

						// create img item
						selfLoader._objs_img_sortable( 'addItem', tab );
					}
				});

				file_frame.open();
			});

			$('a.add_media').on( 'click', function() {
				wp.media.model.settings.post.id = wp_media_post_id;
			});

			// delete
			$( '.wtr_admin_deleteFoto' ).live( 'click', function(){
				var self = $(this);
				self.siblings( 'img' ).remove();
				self.siblings( 'input' ).val( '' );
				self.remove();
			});
		},// end _objs_upload


		_objs_font_switch : function(){


			function generatePrev ( self ){

				var fontFamily		= self.val();
				var hildPrev		= self.parents( '.wfSett' ).find( '.wtr_admin_font_prev' );
				var idCssGoogle		= $( self ).attr( 'id' ) + '_tmp';
				var fontFamilyTemp	= $.trim( fontFamily );
				var fontFamilyFinal	= fontFamilyTemp.replace( / /g,'+' );
				var fontFlag		= 0;

				$( '.' + idCssGoogle ).remove();

				if( '_' != fontFamilyFinal[0] )
				{
					// fix  - error downloading multiple the same fonts with google
					if( $( '#open-sans-css' ).length && 'Open+Sans' == fontFamilyFinal )
					{
						fontFlag = 0;
					}
					else
					{
						fontFlag = 1;
					}

					if( fontFlag )
					{
						$( 'head' ).append( '<link rel="stylesheet" class="' + idCssGoogle + '" type="text/css" href="http://fonts.googleapis.com/css?family=' + fontFamilyFinal + ':400,700italic,700,400italic" >' );
					}

					hildPrev.css( 'font-family', fontFamilyTemp );
				}
				else
				{
					hildPrev.css( 'font-family', fontFamilyTemp.substr( 1 ) );
				}
			} // end generatePrev

			var textF = $( '.wtr_admin_font_switch' );
			var textPrev = $( '.wtr_admin_font_prev' );
			var prevSize = $( '.wtr_admin_prev_font_size' );
			var selectFont = $('.wtr_admin_font_switch_select');

			if( prevSize.length )
			{
				// init text prev
				textPrev.text( textF.val() );

				// init prev size
				var sizeP = prevSize.data( 'value' );
				textPrev.css( 'font-size', $.trim( sizeP ) + 'px' );

				// init font prev
				selectFont.each(function( i, e ){
					generatePrev( $( e ) );
				});

				// change text
				textF.keyup( function (){
					var val = $( this ).val();
					textPrev.text( val );
				});

				// change select
				selectFont.change(function () {
					generatePrev( $( this ) );
				});

				// change size
				prevSize.slider({
					change: function( event, ui ) {
						textPrev.css( 'font-size', $.trim( ui.value ) + 'px' );
					}
				});
			}
		},// end _objs_font_switch


		_objs_icon : function()
		{
			if( $( '.wtrSelectGroup' ).length )
			{
				var selectGroup	= $( '.wtrSelectGroup' ).find(":selected").val();
				var SelectGroup	= $( '.wtrSelectGroup' );
				var selectUser;
				var icon		= $( '.iconItemPos ' );
				var selected	= $( '.wfSelectedIconPrev i' )
					selectUser	= selectGroup;

				// init
				$( '.wtrIcon_' + selectGroup ).fadeIn();

				// change group
				SelectGroup.change(function(){

					var area		= $(this).parents( '.wonsterFiled' );
						selectUser	= $(this).val();

					area.find( '.wtrIconList' ).hide();
					area.find( '.wtrIcon_' + selectUser ).fadeIn();
				});

				// select icon
				icon.click(function( event ){
					event.preventDefault();

					var $this	= $( this );
					var classI;
					var p		= $this.parents( '.wonsterFiled' );
					var el;

					p.find( '.iconItemPos ' ).removeClass( 'iTPActive' );
					$this.addClass( 'iTPActive' );

					classI = $this.children( 'i' ).attr( 'class' );
					el = p.find( '.wtrIconSelectUser' );
					el.fadeIn();
					el.find( 'i' ).removeClass().addClass( classI );

					// set hidden value
					p.find( '.wtr_admin_icons_field' ).val( selectUser  + '|' + classI );
				});
			}

		},// end _objs_icon


		_objs_tinyMCE : function()
		{
			var tiny = $( '.tinymce_contener' );
			tiny.each(function( i, e ) {
				var $this	= $( e );
				var id		= $this.data( 'tiny-id' ),
					dataC	= '',
					name	= $this.attr( 'name' ),
					baseContener	= $( '#' + id );

				// hide wonster plugin
				var active_text	= $this.find( '.switch-html' ).removeAttr( 'onload' ).attr( 'id', id + '-html-wtr' ),
					active_html	= $this.find( '.switch-tmce' ).removeAttr( 'onload' ).attr( 'id', id + '-tmce-wtr' );

				if( 0 == $this.find( '.quicktags-toolbar' ).length )
				{
					quicktags( {id: id , buttons: "strong,em,link,block,del,ins,img,ul,ol,li,code,spell,close"} );
					QTags._buttonsInit();
				}

				// vsual mode
				active_html.click( function( e ){
					e.preventDefault();

					$this.find( '.quicktags-toolbar' ).hide();
					active_html.parents( '.wp-editor-wrap' ).removeClass('html-active').addClass('tmce-active');

					var cc			= baseContener.val();
					var selfMce		= baseContener.siblings( '.mceEditor ' );

					if( 0 == selfMce.length )
					{

						if( '3' == tinymce.majorVersion )
						{
							cc = cc.replace(/[\r\n]/g, "<br />").
								replace( /<\/li><br \/>/g, '</li>' ).
								replace( /<\/ol><br \/>/g, '</ol>' ).
								replace( /<\/ul><br \/>/g, '</ul>' ).
								replace( /<ol><br \/>/g, '<ol>' ).
								replace( /<ul><br \/>/g, '<ul>' );

							tinyMCE.execCommand('mceAddControl', false, id );
							tinyMCE.execInstanceCommand( id, 'mceSetContent', false, cc );
						}
						else if( '4' == tinymce.majorVersion )
						{
							$( '#' + id ).val( '' );

							tinymce.execCommand('mceAddEditor', false, id );

							if( $.trim( cc ) )
							{
								var baseData		= cc.replace( /<p>\s<\/p>/g,"@@@empty_p@@@" );
									baseData		= window.switchEditors.wpautop( baseData );
									baseData		= baseData.replace( /@@@empty_p@@@/g, '<p><br data-mce-bogus="1"><\/p>' );

								tinymce.get( id ).insertContent( baseData );
							}
						}
					}
				});

				// text mode
				active_text.click( function( e ){
					e.preventDefault();

					$this.find( '.quicktags-toolbar' ).show();
					active_text.parents( '.wp-editor-wrap' ).removeClass('tmce-active').addClass('html-active');

					if( '3' == tinymce.majorVersion )
					{
						tinymce.execCommand('mceCleanup', false,  id );
						tinymce.execCommand('mceRemoveControl', false, id );
					}
					else if( '4' == tinymce.majorVersion )
					{
						tinymce.execCommand('mceRemoveEditor', false, id );

						var baseData		= baseContener.val();
							baseData		= baseData.replace( /<p>\s<\/p>/g,"@@@empty_p@@@" );
							baseData		= window.switchEditors.pre_wpautop( baseData );
							baseData		= baseData.replace( /@@@empty_p@@@/g, "&nbsp;\n\n" );
							baseContener.val( baseData );
					}
				});

				// fix -load card as the default text
				//active_text.trigger( 'click' );
				active_html.trigger( 'click' );
			});
		},// end _tinyMCE


		_objs_sortable :{

			initHook : function()
			{
				var ul	= $( '.wtrSortableList' );
				var cou	= ul.children( 'li' ).length - 1;
				var min	= ul.attr( 'data-min-one' );
				var max	= ul.attr( 'data-max-one' );

				if( 1 <= cou )
				{
					$( '.noSidebarLi' ).hide();
				}

				if ( min >= cou )
				{
					ul.find( '.wtr_accordItemDelete' ).hide();
				}
				else
				{
					ul.find( '.wtr_accordItemDelete' ).show();
				}


				if ( max > cou )
				{
					ul.next( '.wtr_accordItemAdd' ).show();
				}
				else
				{
					ul.next( '.wtr_accordItemAdd' ).hide();
				}

				ul.sortable({
					placeholder: 'ui-state-highlight',
					handle: '.handle',
					update: function( event, ui ) {selfLoader._objs_sortable._dragUpdate( $( this ), 1 ) }
				});

				$( '.wtrSortableList' ).disableSelection();
			},// end initHook


			_deleteElement : function()
			{
				var el = $( '.wtr_accordItemDelete' );

				el.die( 'click' ).live( 'click', function()
				{
					var ul		= $( this ).parents( 'ul' );
					var ulId	= ul.attr( 'id' );
					var id		= $( this ).siblings( '.wtr_accordItemName' ).attr( 'data-item' );
					var self	= $( this ).parent( 'li' );
					var sib		= self.siblings( 'li' );

					self.fadeOut( 400, function()
					{
						self.remove();

						var cou  = ul.children( 'li' ).length - 1;
						var min  = ul.data('min-one');
						var max  = ul.data('max-one');

						if( 0 ==  cou )
						{
							$( '.noSidebarLi' ).fadeIn();
						}
						else
						{
							$( '.noSidebarLi' ).fadeOut();
						}


						if( min == cou )
						{
							sib.find( '.wtr_accordItemDelete:first' ).hide();
						}
						else if ( min < cou )
						{
							sib.find( '.wtr_accordItemDelete:first' ).show();
						}
						else if( 1 == sib.length )
						{
							$( '.noSidebarLi' ).fadeIn();
						}

						// show add btn
						ul.next( '.wtr_accordItemAdd' ).fadeIn();

						//update obj
						( window.wtr_shr_trigger.data[ ulId ].option ).splice( id, 1 );
						selfLoader._objs_sortable._dragUpdate( $( '#' + ulId ), 0 );
					});
				});
			},// end deleteElement


			_addElement : function()
			{
				var el = $( '.wtr_accordItemAdd' );

				el.unbind().click(function( event ){

					event.preventDefault();

					function draw( ul, default_option, optPrev, text_sht, newId )
					{
						var fullTextStip = ( default_option[ 0 ][ optPrev ].value ).replace( /<[^>]+>/ig, '' ),
							text_final;
						if( fullTextStip.length >= 55 )
						{
							text_final = fullTextStip.substr( 0, 55 ) + '...';
						}
						else
						{
							text_final = fullTextStip;
						}

						// create a new item based on the default settings
						var li		= $( '<li>' ).addClass( 'ui-state-default' ).hide();
						var spanH	= $( '<span>' ).addClass( 'handle' )
						var a		= $( '<a>' ).addClass( 'wtr_accordItemName wtr_accordItemNameCode' ).attr( { 'href': '', 'data-item' : newId } ).text( text_final );
						var spanD	= $( '<span>' ).addClass( 'wtr_accordItemDelete' );
						var hidden	= $( '<input>' ).attr( 'type', 'hidden' ).addClass( 'Wtr_Opt_Shortcode' ).val( text_sht );
						var full_t	= $( '<input>' ).attr( 'type', 'hidden' ).addClass( 'Wtr_Opt_Full' ).val( default_option[ 0 ][ optPrev ].value );

						li.append( spanH ).append( a ).append( spanD ).append( full_t ).append( hidden );
						ul.append( li );
						li.fadeIn();

						var ulChC = ul.children( 'li' );
						if( 3 == ulChC.length )
						{
							ulChC.find( '.wtr_accordItemDelete' ).show();
						}
						else if( 2 == ulChC.length )
						{
							$( '.noSidebarLi' ).hide();
						}
					}// draw


					function updateSouece(idN, newId, default_option )
					{
						window.wtr_shr_trigger.data[ idN ].option[ newId ] = {};
						window.wtr_shr_trigger.data[ idN ].option[ newId ] = default_option[ 0 ];
					}// updateSouece

					function setControl( ul ){

						var cou = ul.children( 'li' ).length - 1;
						var min = ul.attr( 'data-min-one' );
						var max = ul.attr( 'data-max-one' );

						if( min >= cou )
						{
							ul.find( '.wtr_accordItemDelete' ).hide();
						}
						else
						{
							ul.find( '.wtr_accordItemDelete' ).show();
						}

						if( max == cou )
						{
							ul.next( '.wtr_accordItemAdd' ).hide();
						}
						else if ( max > cou )
						{
							ul.next( '.wtr_accordItemAdd' ).fadeIn();
						}
					}// end setControl

					var ul				= $(this).prev( '.wtrSortableList' );
					var idN				= ul.attr( 'id' );
					var text_sht		= window.wtr_shr_trigger.data[ idN ].default_shortcode;
					var newId			= ul.children( 'li' ).length - 1;
					var default_option	= window.wtr_shr_trigger.data[ idN ].default_option;
					var optPrev			= window.wtr_shr_trigger.data[ idN ].option_prev;

					draw( ul, default_option, optPrev , text_sht, newId );
					updateSouece(idN,  newId, default_option );
					setControl( ul );
				});
			},// end _addElement


			_editItemObj : function()
			{
				var el = $( '.wtr_accordItemNameCode' );
				var self = this;
				el.die( 'click' ).live( 'click', function( event )
				{
					event.preventDefault();

					var self	= $( this );
					var id		= self.attr( 'data-item' );
					var ul		= self.parents( 'ul' );
					var ulId	= ul.attr( 'id' );

					// trigget shortcode
					var type	= ul.data( 'typed' );
					var size_m	= {
							'width'			: parseInt( ul.data( 'widthd' ) ),
							'height'		: parseInt( ul.data( 'heightd' ) ),
							'fullscreenW'	: ul.data( 'fullscreenwd' ),
							'fullscreenH'	: ul.data( 'fullscreenhd' ),
						}

					//clean css modal
					WtrModalShortcodeLoader.cleanCssModalProperties();

					// set init data
					selfLoader._objs_sortable.editDataPrepare( id, ulId );

					// show modal
					WtrShortcodeFunModalProperties.showModal(type, size_m, 'properties' );
				});
			},// end _editItem


			finishObj : function( dataIn )
			{
				var li = $( '#' + dataIn.ulId ).find( '.wtr_accordItemNameCode:eq(' + dataIn.id + ')' );

				li.text( dataIn.text_final );
				li.siblings( '.Wtr_Opt_Full' ).val( dataIn.data[ dataIn.prev ].value );
				li.siblings( '.Wtr_Opt_Shortcode' ).val( dataIn.shr );
			},


			editDataPrepare : function( id, ulId )
			{
				// backup data
				window.wtr_shr_trigger.safe_item	= {};
				window.wtr_shr_trigger.safe_item	= DeepCloneObj( window.wtr_shr_trigger.item );
				window.wtr_shr_trigger.item			= {	type			: window.wtr_shr_trigger.item.type,
														id				: window.wtr_shr_trigger.item.id,
														active_opt		: id,
														active_field	: ulId,
														active_field_t	: '_objs_sortable',
														child_end_el	: window.wtr_shr_trigger.data[ ulId ].child_end_el,
														child_shortcode	: window.wtr_shr_trigger.data[ ulId ].child_shortcode,
														prev_cut		: 55
													};
				window.wtr_shr_trigger.safe_data	= {};
				window.wtr_shr_trigger.safe_data	= DeepCloneObj( window.wtr_shr_trigger.data );

				// set data to render
				window.wtr_shr_trigger.data = window.wtr_shr_trigger.data[ ulId ].option[ id ];
			},// end editDataPrepare


			_dragUpdate : function( selfX, mod )
			{
				var result	= [];
				var itemX	= selfX.find( '.wtr_accordItemName' );
				var ulId	= selfX.attr( 'id' );

				itemX.each( function( ix, e ){
					var selfD = $( e );
					var opt = selfD.attr( 'data-item' );
					selfD.attr( 'data-item', ix );

					if( mod )
					{
						result[ ix ] = window.wtr_shr_trigger.data[ ulId ].option[ opt ];
					}
				});

				if( mod )
				{
					window.wtr_shr_trigger.data[ ulId ].option = {};
					window.wtr_shr_trigger.data[ ulId ].option = DeepCloneObj( result );
				}
			},// end dragUpdate


			init : function()
			{
				this.initHook();
				this._deleteElement();
				this._addElement();
				this._editItemObj();
			},// end init
		},// _sortable


		_objs_img_sortable : function( loadFun, dataSource )
		{
			var selfG = this;

			function initHook ()
			{
				$( '.wr_ImgSortableArea' ).sortable({
					handle: '.wtr_GfxItemImgSortable',
					placeholder: 'ui-state-highlight',
					opacity: "0.6",
					distance: 30,
					update: function( event, ui ) { dragUpdateImg() }
				});
				$( '.wr_ImgSortableArea' ).disableSelection();
			}//end initHook


			function addItem ( tab )
			{
				var tabC		= tab.length;
				var ul			= $( '.wr_ImgSortableArea' );
				var name		= ul.attr( 'data-name' );
				var parentList	= ul.parents( '.wonsterImgSortableContener' );

				for( var i = 0; i < tabC; ++i )
				{
					var contener	= $( '<div>' ).addClass( 'imgThumbContainerImgSortable' );
					var del_btn		= $( '<div>' ).addClass( 'delItemImgSortable' );
					var img			= $( '<img>' ).attr({ 'src'    : tab[ i ].thumb, 'width'  : 80,'height' : 80 }).addClass( 'wtr_GfxItemImgSortable' );
					var li			= $( '<li>' ).addClass( 'ui-state-default' );
					var hidden		= $( '<input>' ).attr({ 'type' : 'hidden', 'name' : name + '[][' + tab[ i ].id +  ']' }).addClass( 'wtr_ValThumbItemImgSortable' );

					// single item
					li.append( contener.append( del_btn ).append( img ).append( hidden ) );

					// add to contener
					ul.append( li );
				}

				initHook();

				// delete empty array
				parentList.find( '.wtr_emptyValThumbItemImgSortable' ).remove();
			}// end add_item


			function deleteItem()
			{
				$( '.delItemImgSortable' ).live( 'click', function()
				{
					var self		= $( this );
					var parentList	= self.parents( '.wonsterImgSortableContener' );
					var name		= self.parents( 'ul' ).attr( 'data-name' );
					self.parents( 'li' ).remove();
				});
			}// end delete_item


			function dragUpdateImg (){} // end dragUpdate


			function init()
			{
				if( $( '.wr_ImgSortableArea li' ).length )
				{
					initHook();
				}

				deleteItem();
			}// end init

			if( undefined == loadFun || undefined == dataSource )
			{
				init();
			}
			else if( 'addItem' )
			{
				addItem( dataSource );
			}
		},// end _img_sortable


		_objs_animate : function()
		{
			var $animate_select = $( '.wtrAnimateTriggerSelect' );

			if( $animate_select.length )
			{
				var animateDivClass = 'animatedElement',
					$animate_div = $('.' + animateDivClass );

				$animate_select.change(function(){
					var aniationOpt = $( this ).val();
					setTimeout(function(){
						$animate_div.removeAttr( 'class' ).addClass( animateDivClass + ' animated ' + aniationOpt );
					}, 250);

				});
			}
		},//end _objs_animate


		_objs_datepicker : function()
		{
			var picker_fields = $( '.wtrDatepickerField' );

			if( picker_fields.length ){
				picker_fields.each(function( i, e ){

					var $field = $( e );
					var picker = new Pikaday(
					{
						field: document.getElementById( $field.attr( 'id' ) ),
						firstDay: 1,
						yearRange: [ $field.data( 'rande-start' ) , $field.data( 'rande-end' ) ],
					});
				});

				var $icon_datepicker = $( '.wtrDatepickerIco' );
				$icon_datepicker.click(function( event ){
					$( this ).next( 'input' ).trigger( 'click' );
				});
			}

		},//end _objs_datepicker
	};// end WtrObjsLoader.prototype



	WtrObjsSystem.prototype = {

		init : function()
		{
			this.tabs();
			this.events_location();
			this.events_time_set();
			this.template();
		},// end init

		tabs : function()
		{
			var pageOption = $( '.wtrPageOptionsTabItem' );
			if( pageOption.length )
			{
				var tabsContent = $( '.wtrPageOptionsTabContentInner' );
				tabsContent.not( ':first' ).hide();

				pageOption.click(function( event ) {

					var $self = $( this );

					// change active tabs
					pageOption.removeClass( 'wtrActivePageOptionTab' ).addClass( 'wtrNonActivePageOptionTab' );
					$self.addClass( 'wtrActivePageOptionTab' ).removeClass( 'wtrNonActivePageOptionTab' );

					// change active content
					tabsContent.hide();
					$( '.' + $( this ).data( 'trigger' ) ).show();
				});
			}
		},// end tabs


		events_location : function()
		{
			var $mapConteners = $( '.wtrGoogleMapContener' );
			if ($mapConteners.length) {
				$mapConteners.each(function( i, e ) {
					WtrVCGoogleMaps.init( $( e ) );
				});
			}
		},//end events_location


		events_time_set : function()
		{
			function change_select_hour_value( val, $obj ){
				if( '0' != val ){
					var x = parseInt( $obj.val() );
					$obj.find( 'option' ).each(function( i, e ){
						if( 0 == i || i > 12 ){
							$( e ).hide();
						}
					});

					if( 0 == x || x > 12 ){
						$obj.find('option:eq(1)').attr( "selected", "selected" );
						$obj.siblings( '.out' ).html( '01' );
					}
				}else{
					$obj.find( 'option' ).show();
				}
			}//end chanbe_select_hour_value

			$( '#_wtr_event_time_start_type' ).change(function( e ){
				var value = $( this ).val();
				change_select_hour_value( value, $( '#_wtr_event_time_start_h' ) );
			});
			$( '#_wtr_event_time_start_type' ).trigger( 'change' );

			$( '#_wtr_event_time_end_type' ).change(function( e ){
				var value = $( this ).val();
				change_select_hour_value( value, $( '#_wtr_event_time_end_h' ) );
			});
			$( '#_wtr_event_time_end_type' ).trigger( 'change' );
		},//end events_time_set


		template : function()
		{
			var templateSelect = $( '#page_template' );
			if( templateSelect.length )
			{
				templateSelect.change(function(){

					var selectTypePage		= $( this );
					var standardPageField	= $('.wtrPageOptionsTabContentInner').children('.wonsterFiled').show();
					var tabsOption			= $( '.wtrPageOptionsTabItem' ).parents( 'li' ),
						editor				= $( '.postarea' ),
						vc_teaser			= $( '#vc_teaser' ),
						vc_swither			= $( '.composer-switch' ),
						valSelect			= selectTypePage.val();

					// reset view
					standardPageField.show();
					tabsOption.show();
					/*editor.show();
					vc_teaser.show();
					vc_swither.show();*/

					//events view
					if( 'template-events.php' ==  valSelect )
					{
						/*editor.hide();
						vc_teaser.hide();
						vc_swither.hide();*/
						$( '.wtrPageOptionsTabItem_Sidebar, .wtrPageOptionsTabItem_OnePage' ).children( '.wonsterFiled' ).hide();
						$( '.wtrOnlyEventsTabs' ).parents( 'li' ).hide();
						$( '.wtrOnlyEventsTabsFields' ).parents( '.wonsterFiled' ).hide();
					}
					else if( 'template-onepage.php' ==  valSelect ){
						$( '.wtrPageOptionsTabItem_Sidebar' ).children( '.wonsterFiled' ).hide();
						$( '.wtrOnlyOnepageTabs' ).parents( 'li' ).hide();
						$( '.wtrOnlyOnepageTabsFields' ).parents( '.wonsterFiled' ).hide();
					}

					if( !$( '.tcontent-pb' ).is(':visible') && !$( '.tcontent' ).is(':visible') )
					{
						$( '.wtrPageOptionsTabItem:visible:first' ).trigger( 'click' );
					}
				});
				templateSelect.trigger( 'change' );
			}
		},//end template
	};// end WtrObjsSystem.prototype


	var WtrVCGoogleMaps = {

		id: null,
		zoom: null,
		geo: {
			x: null,
			y: null
		},
		geoGoogle: null,
		geocoder: null,
		mapContener: null,
		marker: null,
		mapOptions: null,
		self: null,
		valueField: null,
		styleControler: false,
		styleMap: 'standard',
		typeControler: false,
		typeMap: 'ROADMAP',
		markerControler: false,
		styleMarker: 'standard',
		ownMarkerControler: false,
		ownMarkerId: null,
		ownMarkerImgData: null,
		searchBtn: false,
		searchInput: false,

		init: function( mapContener )
		{
			var self = this;
			self.mapContener	= mapContener;
			self.valueField		= self.mapContener.siblings( '.wtrGeoMapsVal' );
			self.searchBtn		= self.mapContener.siblings( '.wtr_gmaps_search_btn' );
			self.searchInput	= self.mapContener.siblings( '.wtr_maps_search_in' );
			this._mappingArea(self);
		},//end init


		_mappingArea: function(self)
		{
			var type_map_controler	= $.trim(self.mapContener.attr( 'data-type-map-controler' ) ),
			style_map_controler		= $.trim(self.mapContener.attr( 'data-style-map-controler' ) ),
			marker_map_controler	= $.trim(self.mapContener.attr( 'data-marker-map-controler' ) );

			self.id		= $.trim( self.mapContener.attr( 'id' ) );
			self.zoom	= parseInt( $.trim( self.mapContener.attr( 'data-zoom' ) ) );

			self.geo.x	= $.trim( self.mapContener.attr( 'data-x' ) );
			self.geo.y	= $.trim( self.mapContener.attr( 'data-y' ) );

			self._updateMarkerPos(self,
				$.trim( self.mapContener.attr( 'data-x' ) ),
				$.trim( self.mapContener.attr( 'data-y' ) )
			);

			// type map controler
			if ( false != type_map_controler )
			{
				self.typeControler = $( '#' + type_map_controler );
				self.typeMap = self.typeControler.find( ':selected' ).val();
				self._changeTypeMapGoogle( self );
			}

			// style map controler
			if ( false != style_map_controler )
			{

				self.styleControler = $( '#' + style_map_controler );
				self.styleMap = self.styleControler.find( ':selected' ).val();

				self._changeStyleMapGoogle( self );
			}

			// style marker map controler
			if ( false != marker_map_controler )
			{
				var marker_main_controler = marker_map_controler.split( '|' );

				self.markerControler = $( '#' + marker_main_controler[ 0 ] );
				self.styleMarker = self.markerControler.find( ':selected' ).val();

				self.ownMarkerControler = $( '#' + marker_main_controler[ 1 ] );
				self.ownMarkerId = self.ownMarkerControler.val();

				if ( null != self.ownMarkerId ) {
					self.ownMarkerImgData = self._getOwnMarkerImgData( self );
				}

				self._changeStyleMapMarkerGoogle( self );
				self._changeStyleOwnMarkerMarkerGoogle( self );
			}

			self._initMapGoogle( self );
			self._createMarkerMap( self );
			self._searchAction( self );
		},//end _mappingArea


		_initMapGoogle: function( self )
		{
			self.geocoder = new google.maps.Geocoder();
			self.mapOptions = {
				zoom				: self.zoom,
				center				: self.geoGoogle,
				mapTypeId			: google.maps.MapTypeId[ self.typeMap ],
				scrollwheel			: false,
				streetViewControl	: false,
				styles				: wtr_google_maps_style[ self.styleMap ],
			}

			self.map = new google.maps.Map( document.getElementById( self.id ), self.mapOptions );
		},//end _initMapGoogle


		_createMarkerMap: function( self )
		{
			//wtr icon set
			if ( 'my_own' != self.styleMarker )
			{
				var icon_set = {
					url 		: wtr_google_marker_style[ self.styleMarker ].url,
					scaledSize	: new google.maps.Size(
						wtr_google_marker_style[ self.styleMarker ].width,
						wtr_google_marker_style[ self.styleMarker ].height
					)
				};
			}else{
				if ( null == self.ownMarkerId || '' == self.ownMarkerId ) {
					var icon_set = null;
				} else {
					var icon_set = self.ownMarkerImgData;
				}
			}

			// create marker
			self.marker = new google.maps.Marker({
				position	: self.geoGoogle,
				map			: self.map,
				draggable	: true,
				icon		: icon_set,
			});

			//drag marker
			google.maps.event.addListener( self.marker, 'dragend', function( event ){
				self._updateMarkerPos( self, event.latLng.lat(), event.latLng.lng() );
			});

			//click map - set new geo for marker
			google.maps.event.addListener( self.map, 'click', function( event ){
				self.marker.setPosition( event.latLng );
				self._updateMarkerPos( self, event.latLng.lat(), event.latLng.lng() );
			});
		},//end _createMarkerMap


		_changeStyleMapMarkerGoogle: function( self )
		{
			self.markerControler.change(function() {
				self.styleMarker = $( this ).val();

				self.marker.setMap( null );
				self._createMarkerMap( self );
			});
		},//end _changeStyleMapMarkerGoogle


		_changeStyleOwnMarkerMarkerGoogle: function( self )
		{
			self.ownMarkerControler.change(function() {
				self.ownMarkerId = $( this ).val();
				self.ownMarkerImgData = self._getOwnMarkerImgData( self );

				self.marker.setMap( null );
				self._createMarkerMap( self );
			});
		},//end _changeOwnMarker


		_getOwnMarkerImgData: function( self )
		{
			var imgData = wp.media.attachment( self.ownMarkerId ).toJSON();
			return {
				url			: imgData.url,
				scaledSize	: new google.maps.Size( imgData.width, imgData.height )
			};
		},//end _getOwnMarkerImgData


		_updateMarkerPos: function( self, x, y )
		{
			self.geo.x = x;
			self.geo.y = y;
			self.geoGoogle = new google.maps.LatLng( self.geo.x, self.geo.y );
			self.valueField.val( self.geo.x + '|' + self.geo.y );
		},//end _updateMarkerPos


		_changeTypeMapGoogle: function(self)
		{
			self.typeControler.change(function() {
				self.typeMap = $( this ).val();

				if ( self.styleControler != false && 'STREET_VIEW_PANORAMA' == self.typeMap ) {
					self.styleMap = 'standard';
					self.styleControler.val( self.styleMap );
				}

				self._initMapGoogle( self );
				self._createMarkerMap( self );
			});
		},//end _changeTypeMapGoogle


		_changeStyleMapGoogle: function( self )
		{
			self.styleControler.change(function(){
				self.styleMap = $( this ).val();

				self._initMapGoogle( self );
				self._createMarkerMap( self );
			});
		},//end _changeStyleMapGoogle


		_searchAction: function( self )
		{
			self.searchBtn.click( function( event ) {

				// Verify that you have provided a place to locate
				var address = $.trim( self.searchInput.val() );

				if ('' != address) {
					self.geocoder.geocode({
						'address': address
					}, function( results, status ) {
						if ( status == google.maps.GeocoderStatus.OK ) {
							self.map.setCenter( results[ 0 ].geometry.location );
							self.marker.setPosition( results[ 0 ].geometry.location );
							self._updateMarkerPos( self, results[ 0 ].geometry.location.lat(), results[ 0 ].geometry.location.lng() );
						} else {
							alert( 'Geocode was not successful for the following reason: ' + status );
						}
					});
				}
			});
		}//end _searchAction
	};//end WtrVCGoogleMaps

	$(document).ready(function(){
		var SystemScriptLoaded = new WtrObjsSystem();
		SystemScriptLoaded.init();
	});
})(jQuery);