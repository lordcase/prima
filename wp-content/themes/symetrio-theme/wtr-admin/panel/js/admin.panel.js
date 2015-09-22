/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

(function($) {

	"use strict";

var WtrAdmin = function(){};

	var self    = this;

	//group
	var group				= $( '.wtr_admin_group' ),
		groupActive			= null,
		groupActiveClass	= 'navActive';

	//section
	var section				= $( '.wtr_admin_select' ),
		sectionArea			= $( '.ui-form' ).children( 'div' ),
		sectionActive		= null;

	// action btn
	var saveF				= $( '.wtr_save_form' ),
		closeError			= $( '.infoErrorBtn' ),
		defSettings			= $( '.wonster_do_def_serttings' ),
		save_form_to_file	= $( '.wtr_save_form_to_file' );

	// submitControl
	var form				= $( '#wtr_form_settings' ),
		submitControl		= $( '.wtr_admin_submit_control' ),
		importTextBtn		= $( '.wonster_do_import_text_serttings' ),
		importAutoBtn		= $( '.wonster_do_import_auto_serttings' ),
		exportBtn			= $( '.wtr_admin_export_settings' ),
		exportFileStatus	= $(  '#wtr_export_setting_to_file' );

	// overwrite custom skin
	var overwriteCustomBtn	= $( '.wtrOverwriteSkin' );

	// one click import
	var oneClickImportBtn	= $( '.wtr_do_once_click_import' );

	WtrAdmin.prototype = {

		hideGroupNotAcrive : function()
		{
			group.siblings( 'ul.secNav' ).hide();
			sectionArea.hide();
			if( null == groupActive )
			{
				groupActive = group.eq(0);
			}

			sectionActive = groupActive.next( '.secNav' ).children( 'li:first' ).children( 'a' );

			// group selection
			group.removeClass(groupActiveClass);
			groupActive.addClass(groupActiveClass);
			groupActive.siblings( 'ul.secNav' ).show();
			$( '.wtr_admin_active_group_title' ).html( groupActive.text() );

			// selection
			wtrAdminPanelControl.hideSectionBotActive();
		},// end hideGroupNotAcrive

		hideSectionBotActive : function()
		{
			sectionArea.hide();
			section.removeClass( 'secNavAct' );
			sectionActive.addClass( 'secNavAct' );
			$( '.wtr_admin_active_section_title' ).text( sectionActive.text() );
			$( '#' + sectionActive.attr( 'id' ) + '_section' ).fadeIn();
		},// end hideSectionBotActive


		showMsgFormSave : function ( type )
		{
			$( '.wtr_adimin_option_msg, .wonsterLoader' ).hide();

			if( 'success' == type )
			{
				$( '.saveInfoNagOk' ).show();
				$( '.saveInfo' ).fadeIn().delay(900).fadeOut();
			}
			else
			{
				$( '.saveInfoNagErr' ).show();
				$( '.saveInfo' ).fadeIn();
			}
		},//end showMsgFormSave


		checkUpdateFieldSettingsStatus :function()
		{
			var statusQuery = null;

			// query
			var query = $.ajax({
				url: wp_param_admin_panel.uri_class + "/wtr_export.php",
				type : "POST",
				data : { get_act_opt : 1 },
				async: false
			});

			// query success
			query.done(function(msg) {
				if ( 1 == msg[ 'status' ] )
				{
					statusQuery = true;
				}
				else
				{
					statusQuery = false;
				}
			});

			// query error
			query.fail(function(jqXHR, textStatus) {
				statusQuery = false;
			});
			return statusQuery;
		},// end checkUpdateFieldSettingsStatus


		exportOptData : function()
		{
			var statusQuery = null;

			//  query
			var query = $.ajax({
				url: wp_param_admin_panel.uri_class + "/wtr_export.php",
				type : "POST",
				data : { get_auto_opt : 1 },
				async: false
			});

			// query success
			query.done(function( msg ) {

				if ( 1 == msg[ 'status' ] )
				{
					wtrAdminPanelControl.updateListExport( msg[ 'draw' ] );
					statusQuery = true;
				}
				else
				{
					statusQuery = false;
				}
			});

			// query error
			query.fail(function(jqXHR, textStatus) {
				statusQuery = false;
			});
			return statusQuery;
		},// end exportOptData


		updateListExport : function( source ){

			var ul = $( '.wtr_admin_list_export_data' );
			ul.children().remove();
			ul.append( source );
			$('input.wtrStrAdminRadio').prettyCheckable( {color: 'gray'} );
		},// end updateListExport


		init : function()
		{
			var ScriptLoaded = new WtrObjsLoader();

			ScriptLoaded.initScriptObject();
			this.eventListener();
			wtrAdminPanelControl.hideGroupNotAcrive();

			//check change settings
			this.checkChangeSettings();

			// move div alerts
			$( "#screen-meta" ).before( $(".saveInfo") );
		},// end init


		// EVENTS
		eventListener : function()
		{
			save_form_to_file.bind( 'click', this.clickSaveBtnFoFile );
			group.bind( 'click', this.clickGroupBtn );
			section.bind( 'click', this.clickSectionBtn );
			saveF.bind( 'click', this.clickSaveBtn );
			closeError.bind( 'click', this.clickCloseError );
			defSettings.bind( 'click', this.sutmitFormStandard) ;
			importTextBtn.bind( 'click', this.sutmitFormStandard );
			importAutoBtn.bind( 'click', this.sutmitFormStandard );
			exportBtn.bind( 'click', this.exportSettings );
			overwriteCustomBtn.bind( 'click', this.overwriteCustomSkin );
			oneClickImportBtn.bind( 'click', this.doOneClickImport );
		},// end eventListener


		clickGroupBtn : function( event )
		{
			event.preventDefault();
			groupActive = $( this );
			wtrAdminPanelControl.hideGroupNotAcrive();
		},// end clickGroupBtn


		clickSectionBtn : function( event )
		{
			event.preventDefault();
			sectionActive = $( this );
			wtrAdminPanelControl.hideSectionBotActive();
		},//end clickSectionBtn


		clickSaveBtn : function ( e )
		{
			wtrAdminPanelControl.resetForm();

			var options = {
				success: function(m) {
					var msg = null;
					var updateStatus = wtrAdminPanelControl.checkUpdateFieldSettingsStatus();

					if( updateStatus ) // correct update field settings
					{
						msg = ( 'wtr_save_option_error' == $.trim( m ) ) ? 'error' : 'success';
					}
					else // incorrect update field settings
					{
						msg = 'error';
					}

					wtrAdminPanelControl.showMsgFormSave(msg);
				 },

				error: function(){},

				beforeSubmit: function( arr, $form, options ) {
					$( '.wtr_adimin_option_msg' ).hide();
					$( '.saveInfo, .wonsterLoader' ).show();
				}
			};

			submitControl.val('ajax');
			$('#wtr_form_settings').ajaxForm( options );
		},//end clickSaveBtn


		clickSaveBtnFoFile : function( event )
		{
			exportFileStatus.val( 'export' );
			form.unbind().submit();
		},//end clickSaveBtnFoFile


		clickCloseError : function( event )
		{
			event.preventDefault();
			$( '.saveInfo' ).hide();
		},//end clickCloseError


		sutmitFormStandard : function ( event )
		{
			wtrAdminPanelControl.resetForm();

			var opt = $(this).data('trigger');
			event.preventDefault();
			submitControl.val( opt );

			$('.wtr_adimin_option_msg').hide();
			$( '.saveInfo, .wonsterLoader' ).show();
			$( '.wtr_admin_modal_close' ).trigger( 'click');
			form.unbind().submit();
		},// end sutmitFormStandard


		checkChangeSettings : function ( )
		{
			// restore default
			var defaultOpt  = $( '.wtr_admin_set_alert_default' );
			var importOpt   = $( '.wtr_admin_set_alert_import_data' );
			var errorOpt    = $( '.wtr_admin_set_alert_import_error' );
			var speed       = 1500;

			if( defaultOpt.length )
			{
				$( '.wtr_adimin_option_msg' ).hide();
				$( '.restoreInfoNagOk' ).show();
				$( '.saveInfo' ).delay().fadeOut( speed );
			}
			else if ( importOpt.length )
			{
				$( '.wtr_adimin_option_msg' ).hide();
				$( '.importInfoNagOk' ).show();
				$( '.saveInfo' ).delay( 900 ).fadeOut( speed );
			}
			else if ( errorOpt.length )
			{
				$( '.wtr_adimin_option_msg' ).hide();
				$( '.saveInfoNagErr' ).show();
			}
		},//end checkChangeSettings


		exportSettings : function( event )
		{
			event.preventDefault();

			$( '.wtr_adimin_option_msg' ).hide();
			$( '.wonsterLoader' ).show();
			$( '.saveInfo' ).fadeIn(400, function(){

				if( wtrAdminPanelControl.exportOptData() )
				{
					$( '.wonsterLoader' ).hide();
					$( '.exportInfoNagOk' ).show();
					$( '.saveInfo' ).delay(900).fadeOut();
				}
				else{
					$( '.wonsterLoader' ).hide();
					$( '.saveInfoNagErr' ).show();
				}
			});
		},//end exportSettings

		overwriteCustomSkin : function( event )
		{
			event.preventDefault();

			var selectVal = $( '.wtrOverwriteSkinSelect' ).val();
			var notiQuery = $( '#wtr_restet_custom_skin_nonce' ).val();

			// show loader
			$('.wtr_adimin_option_msg').hide();
			$( '.saveInfo, .wonsterLoader' ).show();
			$( '.wtr_admin_modal_close' ).trigger( 'click');

			$.ajax({
				type        : 'POST',
				dataType    : 'json',
				url         : wp_param_admin_panel.ajaxurl,
				data        : {
					skin    : selectVal,
					action  : 'wtr_restet_custom_skin',
					_wpnonce: notiQuery
				},
				success : function( msg )
				{
					if( 'success' == msg.status ){
						$( '.wonsterLoader' ).hide();
						$( '.saveInfoNagOk' ).show();
						$( '.saveInfo' ).fadeIn().delay( 900 ).fadeOut();
					}
					else
					{
						$( '.wonsterLoader' ).hide();
						$( '.saveInfoNagErr' ).show();
						$( '.saveInfo' ).fadeIn();
					}
				},
				error : function()
				{
					$( '.wonsterLoader' ).hide();
					$( '.saveInfoNagErr' ).show();
					$( '.saveInfo' ).fadeIn();
				},
			});

		},//end overwriteCustomSkin


		doOneClickImport : function()
		{

			$('.wtr_adimin_option_msg').hide();
			$( '.saveInfo, .wonsterLoader' ).show();
			$( '.wtr_admin_modal_close' ).trigger( 'click');

			jQuery.ajax({
			  type: 'POST',
			  dataType : 'json',
			  url: wp_param_admin_panel.ajaxurl,
			  data: {
					action: 'wtr_one_click_import',
					_wpnonce: jQuery('#wtr_one_click_import_nonce').val(),
					wtr_import_type: jQuery('#wtr_DataBackupOneClickImport').val(),
					submitControl:'one-click-import',
			  },
			  success : function(msg, textStatus, XMLHttpRequest){

				if( msg.status ){
					$( '.wonsterLoader' ).hide();
					$( '.importOneClickInfoNagOk' ).show();
					$( '.saveInfo' ).fadeIn().delay( 900 ).fadeOut();
				}
				else
				{
					$( '.wonsterLoader' ).hide();
					$( '.saveInfoNagErr' ).show();
					$( '.saveInfo' ).fadeIn();
				}
			  },
			  error : function(MLHttpRequest, textStatus, errorThrown){
				$( '.wonsterLoader' ).hide();
				$( '.saveInfoNagErr' ).show();
				$( '.saveInfo' ).fadeIn();
			  }
			});
		},//end doOneClickImport

		resetForm : function()
		{
			// reset form function
			exportFileStatus.val( '' );
		},//end resetForm
	};// end WtrAdmin

	var wtrAdminPanelControl = new WtrAdmin();
	wtrAdminPanelControl.init();
})(jQuery);

