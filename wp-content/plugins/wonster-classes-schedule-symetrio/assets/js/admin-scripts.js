/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

var WtrObjsClassesSchedule	= function(){};
var WtrModalProperties		= function(){};
var WtrModalHelper			= function(){};

(function($) {

	"use strict";

	function getUrlVars() {
		var vars = {};
		var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			vars[key] = value;
		});
		return vars;
	}


	WtrObjsClassesSchedule.prototype = {

		init : function()
		{
			var $self = this;

			this._tabs( $self );
			this._add_calendar( $self );
			this._edit_calendar( $self );
			this._delete_calendar( $self );
			this._add_scope( $self );
			this._edit_scope( $self );
			this._delete_scope( $self );
			this._add_instance( $self );
			this._edit_instance( $self );
			this._delete_instance( $self );
			this._filter_scope_instance( $self );
		},//end init


		//=== CALENDAR FUNCTION

		rerender_calendar_prev : function( $self, table )
		{
			var calendar_table  = $( table );
			var calendar_c      = calendar_table.children( 'tr' ).not( '.stdNothingHere' ).length;
			var alert_row       = calendar_table.find( '.stdNothingHere' );

			if( 0 == calendar_c ){
				alert_row.show();
			}else{
				alert_row.hide();
			}
		},//end rerender_calendar_prev


		wtrProgressInfo : function( opt )
		{
			if( opt ){
				$( 'body, a, span, .srtBtnIco' ).addClass( 'wtrProgressInfoLoader' );
			}else{
				$( 'body, a, span, .srtBtnIco' ).removeClass( 'wtrProgressInfoLoader' );
			}
		},// end wtrProgressInfo


		_tabs : function( $self )
		{
			var tabSchedule = $( '.wtrClassScheduleTabItem' );
			if( tabSchedule.length )
			{
				var tabsContent = $( '.wtrClassScheduleTabContentInner' );
				//tabsContent.not( ':first' ).hide();

				tabSchedule.click(function( event ) {
					var $self = $( this );

					// change active tabs
					tabSchedule.removeClass( 'wtrActivePageOptionTab' ).addClass( 'wtrNonActivePageOptionTab' );
					$self.addClass( 'wtrActivePageOptionTab' ).removeClass( 'wtrNonActivePageOptionTab' );

					// change active content
					tabsContent.hide();
					$( '.' + $( this ).data( 'trigger' ) ).show();
				});

				$( '.wtrActivePageOptionTab' ).trigger( 'click' );
			}
		},//end tabs


		_add_calendar : function( $self )
		{
			var btnAddCalendar = $( '.wtrAddCalendar' );
			btnAddCalendar.click(function(){
				var WtrModal = new WtrModalProperties();
				WtrModal.show_modal( $self, 'new_calendar', null, null, null );
			});
		},//end _add_calendar


		_edit_calendar : function( $self )
		{
			$( document.body ).on('click', '.wtrEditCalendar', function(event) {
				var WtrModal	= new WtrModalProperties();
				var $this		= $( this );
				var idCalendar	= $this.data( 'calendar' );

				WtrModal.show_modal( $self, 'edit_calendar', idCalendar, null, null );
			});
		},//end _edit_calendar


		_delete_calendar : function( $self )
		{
			var idCalendar  = null;

			$( document.body ).on('click', '.wtrDeleteCalendar', function(event) {

				var $btn = $( this );
				$self.wtrProgressInfo( 1 );

				// confirm window
				var action =  confirm( wtr_classes_schedule_param.msg.delete_calendar );

				if( action ){
					var $this		= $( this );
					idCalendar		= $this.data( 'calendar' );
					var notiQuery	= $( '#wtr_calendar_nonce' ).val();

					$.ajax({
						type		: 'POST',
						dataType	: 'json',
						url			: wtr_classes_schedule_param.ajax_url,
						data		: {
							action			: 'wtr_calendar_schedule_delete',
							id_timetable	: idCalendar,
							_wpnonce		: notiQuery
						},
						success : function( msg )
						{
							if( msg == -1 || 'error' == msg.status ){
								alert( wtr_classes_schedule_param.msg.error );
							}
							else if( 'success' == msg.status ){
								$btn.parents( 'tr' ).remove();
								$self.rerender_calendar_prev( $self, '.wtrAdminCalendarTable .pure-table tbody' );
							}
						},
						error : function()
						{
							alert( wtr_classes_schedule_param.msg.error );
						},
						complete : function()
						{
							$self.wtrProgressInfo( 0 );
						},
					});
				}
				else{
					$self.wtrProgressInfo( 0 );
				}
			});
		},//end _delete_calendar


		//=== CALENDAR SCOPE

		_add_scope : function( $self )
		{
			var btnAddScope = $( '.wtrAddScope' );
			btnAddScope.click(function(){
				var idCalendar	= $( this ).data( 'calendar' );
				var WtrModal	= new WtrModalProperties();

				WtrModal.show_modal( $self, 'new_scope', idCalendar, null, null );
			});
		},//end _add_scope


		_edit_scope : function( $self )
		{
			$( document.body ).on('click', '.wtrEditScope', function(event) {

				var WtrModal	= new WtrModalProperties();
				var $this		= $( this );
				var idScope		= $this.data( 'scope' );
				var idCalendar	= $this.data( 'calendar' );
				var dataT		= idCalendar + '-' + idScope;

				WtrModal.show_modal( $self, 'edit_scope', dataT, null, null );
			});
		},//end _add_scope


		_delete_scope : function( $self )
		{
			$( document.body ).on('click', '.wtrDeleteScope', function(event) {

				var $btn = $( this );
				$self.wtrProgressInfo( 1 );

				// confirm window
				var action =  confirm( wtr_classes_schedule_param.msg.delete_scope );

				if( action ){
					var $this		= $( this );
					var idScope		= $this.data( 'scope' );
					var notiQuery	= $( '#wtr_scope_nonce' ).val();
					var dayT		= $btn.parents( '.wtrClassScheduleTabContentInner' ).data( 'day' );

					$.ajax({
						type		: 'POST',
						dataType	: 'json',
						url			: wtr_classes_schedule_param.ajax_url,
						data		: {
							action		: 'wtr_calendar_scope_delete',
							id_scope	: idScope,
							_wpnonce	: notiQuery
						},
						success : function( msg )
						{
							if( msg == -1 || 'error' == msg.status ){
								alert( wtr_classes_schedule_param.msg.error );
							}
							else if( 'success' == msg.status ){
								$btn.parents( 'tr' ).remove();
								$self.rerender_calendar_prev( $self, '.wtrClassScheduleTabContentInner.scope-day-' + dayT + ' tbody' );
							}
						},
						error : function()
						{
							alert( wtr_classes_schedule_param.msg.error );
						},
						complete : function()
						{
							$self.wtrProgressInfo( 0 );
						},
					});
				}
				else{
					$self.wtrProgressInfo( 0 );
				}
			});
		},//end _delete_scope


		_add_instance : function( $self )
		{
			var btnAddScope = $( '.wtrAddInstance' );
			btnAddScope.click(function(){

				var idCalendar	= $( this ).data( 'calendar' );
				var WtrModal	= new WtrModalProperties();

				WtrModal.show_modal( $self, 'new_instance', idCalendar, null, null );
			});
		},//end _add_instance


		_edit_instance : function( $self )
		{
			$( document.body ).on('click', '.wtrEditInstance', function(event) {

				var WtrModal	= new WtrModalProperties();
				var $this		= $( this );
				var idInstance	= $this.data( 'instance' );
				var idCalendar	= $this.data( 'calendar' );
				var dataT		= idCalendar + '-' + idInstance;

				WtrModal.show_modal( $self, 'edit_instance', dataT, null, null );
			});
		},//end _edit_instance


		_delete_instance : function( $self )
		{
			$( document.body ).on('click', '.wtrDeleteInstance', function(event) {

				var $btn = $( this );
				$self.wtrProgressInfo( 1 );

				// confirm window
				var action =  confirm( wtr_classes_schedule_param.msg.delete_scope );

				if( action ){
					var $this		= $( this );
					var idInstance		= $this.data( 'instance' );
					var type			= $this.data( 'type' );
					var notiQuery	= $( '#wtr_instance_nonce' ).val();
					var dayT		=$btn.parents( '.wtrClassScheduleTabContentInner' ).data( 'day' );

					$.ajax({
						type		: 'POST',
						dataType	: 'json',
						url			: wtr_classes_schedule_param.ajax_url,
						data		: {
							action		: 'wtr_calendar_instance_delete',
							id_instance	: idInstance,
							type		: type,
							_wpnonce	: notiQuery
						},
						success : function( msg )
						{
							if( msg == -1 || 'error' == msg.status ){
								alert( wtr_classes_schedule_param.msg.error );
							}
							else if( 'success' == msg.status ){
								$btn.parents( 'tr' ).remove();
								$self.rerender_calendar_prev( $self, '.wtrClassScheduleTabContentInner.scope-day-' + dayT + ' tbody' );
							}
						},
						error : function()
						{
							alert( wtr_classes_schedule_param.msg.error );
						},
						complete : function()
						{
							$self.wtrProgressInfo( 0 );
						},
					});
				}
				else{
					$self.wtrProgressInfo( 0 );
				}
			});
		},//end _delete_instance


		_filter_scope_instance : function( $self )
		{
			var filter_btn = $( '.wtrInstanceFilterButton' );
			if( filter_btn.length ){

				//init datepicker
				var $datepicker		= $( '.wtrFilterScopeInstanceDatePicker' ),
					btn_show_data	= $( '.wtrFilterScopeInstance' ),
					date_label		= $( '.wtrPageOptionsDateEmiterHeadline ' ),
					date_filter,
					date_split;

				var picker = new Pikaday(
				{
					field		: document.getElementById( $datepicker.attr( 'id' ) ),
					firstDay	: 1,
					yearRange	: [ $datepicker.data( 'rande-start' ) , $datepicker.data( 'rande-end' ) ],
					minDate		: new Date( $datepicker.data( 'date-start' ) ),
					maxDate		: new Date( $datepicker.data( 'date-end' ) )
				});

				//change datepicker
				$datepicker.change(function( event ){
					event.preventDefault();
					date_filter = $datepicker.val();
					date_label.html( date_filter );
					btn_show_data.attr( 'href', '?page=wtr_classes_schedule&view=instance&id=' + getUrlVars()[ 'id' ] + '&date=' + date_filter );
				});

				//trigger datepicker
				filter_btn.click( function( event ){
					event.preventDefault();
					$datepicker.trigger( 'click' );
				} );

				//click btn - show data
				btn_show_data.click(function(){
					date_filter = $datepicker.val();
					//alert( date_filter );
					window.location.href= btn_show_data.attr( 'href' );
				});
			}
		},//end _filter_scope_instance

	};//end WtrObjsClassesSchedule


	WtrModalProperties.prototype = {

		modal_size	: {},
		mode		: '',


		show_modal : function( main_self, type_modal, data, openjs, closejs )
		{
			var options = {};
			var $self   = this;

			switch( type_modal )
			{
				case 'new_calendar':
					options = {
						url			: wtr_classes_schedule_param.plugin_path +
										'wtr-admin/class/wtr_modal/wtr_view_modal_controller.php?&w=null&h=null' +
										'&view=wtr_calendar_schedule&mode=new&data=null',
						width		: 700,
						height		: 620,
						fullscreenW	: 'no',
						fullscreenH	: 'no',
						topsplit	: 2
					};
				break;

				case 'edit_calendar':
					options = {
						url			: wtr_classes_schedule_param.plugin_path +
										'wtr-admin/class/wtr_modal/wtr_view_modal_controller.php?&w=null&h=null' +
										'&view=wtr_calendar_schedule&mode=edit&data=' + data,
						width		: 700,
						height		: 540,
						fullscreenW	: 'no',
						fullscreenH	: 'no',
						topsplit	: 2
					};
				break;

				case 'new_scope':
					options = {
						url			: wtr_classes_schedule_param.plugin_path +
										'wtr-admin/class/wtr_modal/wtr_view_modal_controller.php?&w=null&h=null' +
										'&view=wtr_calendar_scope&mode=new&data=' + data, // - data - id- calendar
						width		: 700,
						height		: 1000,
						fullscreenW	: 'no',
						fullscreenH	: 'yes',
						topsplit	: 2
					};
				break;

				case 'edit_scope':
					options = {
						url			: wtr_classes_schedule_param.plugin_path +
										'wtr-admin/class/wtr_modal/wtr_view_modal_controller.php?&w=null&h=null' +
										'&view=wtr_calendar_scope&mode=edit&data=' + data,
						width		: 700,
						height		: 1000,
						fullscreenW	: 'no',
						fullscreenH	: 'no',
						topsplit	: 2
					};
				break;

				case 'new_instance':
					options = {
						url			: wtr_classes_schedule_param.plugin_path +
										'wtr-admin/class/wtr_modal/wtr_view_modal_controller.php?&w=null&h=null' +
										'&view=wtr_calendar_instance&mode=new&data=' + data, // - data - id- calendar
						width		: 700,
						height		: 1000,
						fullscreenW	: 'no',
						fullscreenH	: 'yes',
						topsplit	: 2
					};
				break;

				case 'edit_instance':
					options = {
						url			: wtr_classes_schedule_param.plugin_path +
										'wtr-admin/class/wtr_modal/wtr_view_modal_controller.php?&w=null&h=null' +
										'&view=wtr_calendar_instance&mode=edit&data=' + data,
						width		: 700,
						height		: 1000,
						fullscreenW	: 'no',
						fullscreenH	: 'no',
						topsplit	: 2
					};
				break;
			}

			main_self.wtrProgressInfo( 1 );

			// clean modal html
			$( '.tbox-pb' ).removeClass( 'tbox-pb2' ).removeAttr('style');

			var HelperJs	= new WtrModalHelper();
			var size		= HelperJs.calcModalCss( options );

			// load modal
			WTR_MODAL_WINDOW.box.show({
				url		: options.url,
				opacity	: 50,
				width	: size.w,
				height	: size.h,
				topsplit: options.topsplit,
				openjs	: function(){
					$self._openModal( main_self, $self, openjs, options );
				},
				closejs	: function(){
					$self._closeModal( main_self, $self, closejs, options );
				},
			});
		},


		_openModal : function( main_self, $self, openjs, options )
		{
			var ScriptLoaded = new WtrObjsLoader();
			ScriptLoaded.initScriptObject()

			var HelperJs = new WtrModalHelper();
			HelperJs.setDependencyElement();

			//finish rener
			HelperJs.finishRender();
			HelperJs.resetModalStyle({
				fullscreenW	: options.fullscreenW,
				fullscreenH	: options.fullscreenH,
				height		: options.height,
				width		: options.width
			});

			// hide fields
			$( '.ModalHide' ).parents( '.wonsterFiled ' ).hide();
			HelperJs.removeLine();

			$self._saveClick( main_self, $self );
			$self._clickClose( main_self, $self );

			main_self.wtrProgressInfo( 0 );

			$('.wtrFieldsContainerProperties form').keypress(function (e) {
				var key = e.which;
				if(key == 13){
					return false;
				}
			});
			//openjs()
		},//openModal


		_closeModal : function( main_self, $self, closejs, options )
		{
			//closejs()
		},//_closeModal


		_clickClose : function()
		{
			var btnClose	= $( '.wtrModalClose' );
			var mask		= $( '.tmask-pb' );

			$( document.body ).on('click', '.wtrModalClose', function(event) {
				event.preventDefault();
				mask.trigger( 'click' );
			});
		},// end _clickClose


		_saveClick : function( main_self, $self )
		{
			var btn = $( '.wtrUpdateClassesSchedule' );
			btn.click(function( event ) {

				var dataForm	= $self.getFormData( $self, 'ShortcodeFieldsFormProperties' );
				var viewC		= $( '#view_controler' ).val();
				var modeC		= $( '#mode_type_controler' ).val();
				var nonce		= $( '#' + viewC + '_' + modeC + '_opt_nonce' ).val();
				var $this		= $( this );

				if( !$this.hasClass( 'wtrUpdateClassesScheduleProcess' ) )
				{
					$this.addClass( 'wtrUpdateClassesScheduleProcess' );
					main_self.wtrProgressInfo( 1 );

					$.ajax({
						type	: 'POST',
						dataTyp	: 'json',
						url		: wtr_classes_schedule_param.ajax_url,
						data	: {
							action		: viewC + '_' + modeC,
							field		: dataForm,
							_wpnonce	: nonce
						},
						success : function( msg )
						{
							msg = jQuery.parseJSON( msg );
							$self[ msg.controler + '_event' ] ( msg, main_self, $self );
						},
						error : function()
						{
							alert( wtr_classes_schedule_param.msg.error );
							$( '.wtrModalClose' ).trigger( 'click' );
						},
						complete : function()
						{
							main_self.wtrProgressInfo( 0 );
							$this.removeClass( 'wtrUpdateClassesScheduleProcess' );
						},
					});
				}
			});
		},//end saveClick


		wtr_calendar_schedule_event : function( msg, main_self, $self )
		{
			if( msg == -1 || 'error' == msg.status ){
				switch( msg.reason ){
					case 'name_calendar_not_unique' :
						alert( wtr_classes_schedule_param.msg.name_calendar_not_unique );
					break;

					default:
						alert( wtr_classes_schedule_param.msg.error );
					break;
				}
			}
			else if( 'success' == msg.status ){
				if( msg.mode == 'new' )
				{
					$( '.wtrAdminCalendarTable .pure-table tbody' ).prepend( $( msg.code ) );
					main_self.rerender_calendar_prev( $self, '.wtrAdminCalendarTable .pure-table tbody' );
				}else if( msg.mode == 'edit' )
				{
					$( '.wtrAdminCalendarTable .pure-table .wtr-data-calendar-' + msg.id_timetable ).replaceWith( $( msg.code ) );
				}

				$( '.wtrModalClose' ).trigger( 'click' );
			}
		},//end wtr_calendar_schedule_event


		wtr_calendar_scope_event : function( msg, main_self, $self )
		{
			if( msg == -1 || 'error' == msg.status )
			{
				switch( msg.reason ){
					case 'id_classes' :
						alert( wtr_classes_schedule_param.msg.scope_no_id_class );
					break;

					case 'id_room' :
						alert( wtr_classes_schedule_param.msg.scope_no_id_room );
					break;

					case 'trainers' :
						alert( wtr_classes_schedule_param.msg.scope_no_trainers );
					break;

					case 'wrong_hour' :
						alert( wtr_classes_schedule_param.msg.scope_wrong_hour );
					break;

					case 'wrong_scope' :
						alert( wtr_classes_schedule_param.msg.scope_wrong_scope );
					break;

					case 'no_instance' :
						alert( wtr_classes_schedule_param.msg.scope_no_instance );
					break;

					default:
						alert( wtr_classes_schedule_param.msg.error );
					break;
				}
			}
			else if( 'success' == msg.status ){
				if( msg.mode == 'new' )
				{
					window.code = msg;
					window.d = $( '.wtrClassScheduleTabContentInner.scope-day-' + msg.day + ' tbody' );
					$( '.wtrClassScheduleTabContentInner.scope-day-' + msg.day + ' tbody' ).prepend( $( msg.code ) );
					main_self.rerender_calendar_prev( $self, '.wtrClassScheduleTabContentInner.scope-day-' + msg.day + ' tbody' );
				}else if( msg.mode == 'edit' )
				{
					$( '.wtrAdminCalendarTable .pure-table .wtr-data-scope-' + msg.id_scope ).replaceWith( $( msg.code ) );
				}

				$( '.wtrModalClose' ).trigger( 'click' );
			}
		},//end wtr_calendar_scope_event


		wtr_calendar_instance_event : function( msg, main_self, $self )
		{
			if( msg == -1 || 'error' == msg.status )
			{
				switch( msg.reason )
				{
					case 'id_classes' :
						alert( wtr_classes_schedule_param.msg.scope_no_id_class );
					break;

					case 'id_room' :
						alert( wtr_classes_schedule_param.msg.scope_no_id_room );
					break;

					case 'trainers' :
						alert( wtr_classes_schedule_param.msg.scope_no_trainers );
					break;

					case 'wrong_hour' :
						alert( wtr_classes_schedule_param.msg.scope_wrong_hour );
					break;

					default:
						alert( wtr_classes_schedule_param.msg.error );
					break;
				}
			}
			else if( 'success' == msg.status )
			{
				if( msg.mode == 'new' )
				{
					$( '.wtrClassScheduleTabContentInner.scope-day-' + msg.day + ' tbody' ).prepend( $( msg.code ) );
					main_self.rerender_calendar_prev( $self, '.wtrClassScheduleTabContentInner.scope-day-' + msg.day + ' tbody' );
				}else if( msg.mode == 'edit' )
				{
					if( true === msg.change )
					{
						var acc_day = $( '.wtr-data-instance-' + msg.id_instance ).parents( 'table' ).data( 'day' );
						if( msg.day != '' && msg.day != acc_day )
						{
							$( '.wtrAdminCalendarTable .pure-table .wtr-data-instance-' + msg.id_instance ).remove();
							main_self.rerender_calendar_prev( $self, '.wtrClassScheduleTabContentInner.scope-day-' + acc_day + ' tbody' );

							$( '.wtrClassScheduleTabContentInner.scope-day-' + msg.day + ' tbody' ).prepend( $( msg.code ) );
							main_self.rerender_calendar_prev( $self, '.wtrClassScheduleTabContentInner.scope-day-' + msg.day + ' tbody' );
						}
						else
						{
							$( '.wtrAdminCalendarTable .pure-table .wtr-data-instance-' + msg.id_instance ).replaceWith( $( msg.code ) );
						}
					}
				}

				$( '.wtrModalClose' ).trigger( 'click' );
			}
		},//end wtr_calendar_instance_event


		getFormData : function( $self, field )
		{
			//get extra data
			var extra_source	= '';
			var extra_tmp		= source = $( '#' + field ).find( '.GetRealValue' );
			if( extra_tmp.length ){
				var extra_data = {};
				extra_tmp.each(function( i, e ){
					var elem		= $( e );
					var tmp_text	= [];

					if( "SELECT" == elem.get(0).tagName ){
						elem.children('option:selected' ).each(function( j, f ){
							tmp_text.push( $( f ).text() );
						});
						extra_data[ 'txt_' + elem.attr( 'name' ) ] = tmp_text.join(  );
					}
				});
				extra_source = '&' + $.param( extra_data );
			}

			var source  = $( '#' + field ).find( '.ReadStandard' ).serialize();
			var sourceA = source + extra_source;
			JSON.stringify( sourceA ) ;
			sourceA = unescape( sourceA.replace( /\\u/g, '%u' ) );
			sourceA = encodeURIComponent( sourceA );
			return sourceA;
		},//end getFormData
	};// end WtrModalProperties


	WtrModalHelper.prototype = {

		setDependencyElement : function()
		{
			var self = this;

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

				if( flag ){
					$e.show();
				}
				else{
					$e.hide();
				}

				self.removeLine();
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
						var val_f = $( this ).val();
						checkDependencyElement( $e, val_f, val );
					});
					field.trigger( eventT );
				});
			}
		},//end setDependencyElement


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
		},//end calcModalCss

		resetModalStyle : function( source )
		{
			var opt = 'pb';
			var min = 0;

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
	};//end WtrModalHelper

	$(document).ready(function(){
		var ClassesSchedule = new WtrObjsClassesSchedule();
		ClassesSchedule.init();
	});
})(jQuery);