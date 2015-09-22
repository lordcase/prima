/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

var WtrMegaMenu = function(){};

( function( $ ) {

	"use strict";

	WtrMegaMenu.prototype = {

		extra_class : 'wtr_mega_menu_settings',

		init : function(){
			var $self = this;
			this._menu_item_mouseup( $self );
			this._change_mega_menu_mode( $self );
			this._media_frame_setup( $self );
			this._remove_image_menu( $self );

			this._pre_render_menu( $self );
		},//end init


		_pre_render_menu : function( $self )
		{
			var menu_item = $( '.menu-item' );
			if( menu_item.length ){
				menu_item.each(function( i, e ){
					var $obj = $( e );
					if( $obj.hasClass( 'menu-item-depth-0' ) ){
						$obj.find( '.menu-item-bar' ).trigger( 'mouseup' );
					}
				});
			}
		},//end _pre_render_menu

		_menu_item_mouseup: function( $self )
		{
			var menu_item = $( '.menu-item-bar' );
			menu_item.on( 'mouseup', function( event ) {
				var obj = $( this ).parent( 'li' );
				setTimeout(function(){ $self._render_settings_fields( $self, obj ) }, 200 );
			});
		},//end _menu_item_mouseup


		_render_settings_fields : function( $self, $obj )
		{
			//init lvl-0
			var mega_menu_status = $obj.find( '.edit-menu-item-wtr-megamenu_status' );
			if( $obj.hasClass( 'menu-item-depth-0' ) )
			{
				var $next = $.merge( $obj, $obj.find( '~ li' ) );
				if( mega_menu_status.is( ':checked' ) ){
					$self._render_child_extra_mega_menu_class( $self, $next, true );
				}else{
					$self._render_child_extra_mega_menu_class( $self, $next, false );
				}
			}
			else{
				$obj.prevAll( '.menu-item-depth-0:first' ).find( '.menu-item-bar' ).trigger( 'mouseup' );
			}
		},//end _render_settings_fields


		_render_child_extra_mega_menu_class : function( $self, $obj, mode )
		{
			var flag		= true;
			var flag_first	= true;

			$obj.each(function( i, e ){

				if( flag ){
					var $li = $( e );

					if( !flag_first && $li.hasClass( 'menu-item-depth-0' ) ){
						flag = false;
					}
					else{
						if( mode ){
							$li.addClass( $self.extra_class );
						}else{
							$li.removeClass( $self.extra_class );
						}
					}
				}
				flag_first = false;
			});
		},//_render_child_extra_mega_menu_class


		_change_mega_menu_mode : function( $self )
		{
			$( document ).on( 'click', '.edit-menu-item-wtr-megamenu_status', function(){

				var $obj = $( this ).parents( 'li' );
				var $next = $.merge( $obj, $obj.find( '~ li' ) );


				if( $( this ).is( ':checked' ) ){
					$self._render_child_extra_mega_menu_class( $self, $next, true );
				}else{
					$self._render_child_extra_mega_menu_class( $self, $next, false );
				}
			});
		},//end _change_mega_menu_mode


		_media_frame_setup : function()
		{
			var wtr_mega_menu_media_frame;
			var item_id;

			$( '.edit-menu-item-wtr-menu_img' ).each(function( i, e ){
				var $obj =  $( e );

				if( $obj.val() ){
					var item_id = $( this ).data( 'trigger' );
					$( '#wtr-mega-menu-media-img-'+ item_id ).attr( 'src', $obj.val() );
					$( '#wtr-mega-menu-delete-img-' + item_id ).show();
					$( '#wtr-mega-menu-set-thumbnail-' + item_id ).hide();
				}
			});

			$( document.body ).on( 'click', '.wtr-mega-menu-media-img, .wtr-mega-menu-set-thumbnail-btn', function( e ){

				e.preventDefault();

				item_id = $( this ).data( 'trigger' );

				if ( wtr_mega_menu_media_frame ) {
					wtr_mega_menu_media_frame.open();
					return;
				}

				wtr_mega_menu_media_frame = wp.media.frames.file_frame = wp.media({
					frame	: 'select',
					multiple: false,
					library	: { type: 'image' }
				});

				wtr_mega_menu_media_frame.on( 'select', function(){
					var media_attachment = wtr_mega_menu_media_frame.state().get( 'selection' ).first().toJSON();

					$( '#edit-menu-item-wtr-menu_img-'+ item_id ).val( media_attachment.url );
					$( '#wtr-mega-menu-media-img-'+ item_id ).attr( 'src', media_attachment.url ).css( 'display', 'block' ).attr( 'data-trigger', item_id );
					$( '#wtr-mega-menu-delete-img-' + item_id ).show();
					$( '#wtr-mega-menu-set-thumbnail-' + item_id ).hide();
				});

				wtr_mega_menu_media_frame.open();
			});
		},//end media_frame_setup


		_remove_image_menu : function( $self ){
			$( document.body ).on( 'click', '.wtr-mega-menu-remove-img', function( e ){

				var item_id = $( this ).data( 'trigger' );

				$( '#edit-menu-item-wtr-menu_img-'+ item_id ).val( '' );
				$( '#edit-menu-item-wtr-menu_img-'+ item_id ).data( 'trigger', null );
				$( '#wtr-mega-menu-media-img-'+ item_id ).attr( 'src', null  ).hide();
				$( '#wtr-mega-menu-delete-img-' + item_id ).hide();
				$( '#wtr-mega-menu-set-thumbnail-' + item_id ).show();
			});
		},//_remove_image_menu
	};

	$(document).ready(function(){
		var MegaMenu = new WtrMegaMenu();
		MegaMenu.init();
	});
})( jQuery );