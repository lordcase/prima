Element.prototype.matches=Element.prototype.matches||Element.prototype.webkitMatchesSelector;!function(){function a(a){if(a.length){if(1===a.length)return a[0];var b,c,d=document.createDocumentFragment();for(b in arguments)c=arguments[b],d.appendChild("string"==typeof c?document.createTextNode(c):c);return d}throw new Error("DOM Exception 8")}Element.prototype.prepend=function(){this.insertBefore(a(arguments),this.firstChild)},Element.prototype.append=function(){this.appendChild(a(arguments))},Element.prototype.before=function(){this.parentNode&&this.parentNode.insertBefore(a(arguments),this)},Element.prototype.after=function(){this.parentNode&&this.parentNode.insertBefore(a(arguments),this.nextSibling)},Element.prototype.replace=function(){this.parentNode&&this.parentNode.replaceChild(a(arguments),this.nextSibling)}}();

/*
 *  jQuery Custombox v1.1.3 - 2014/02/18
 *  jQuery Modal Window Effects.
 *  http://dixso.github.io/custombox/
 *  (c) 2014 Julio De La Calle - http://dixso.net - @dixso9
 *
 *  Under MIT License - http://www.opensource.org/licenses/mit-license.php
 */
// the semi-colon before function invocation is a safety net against concatenated
// scripts and/or other plugins which may not be closed properly.
;(function(e,t,n,r){"use strict";function i(e,t){this.element=e;if(typeof this.element==="object"&&typeof t==="object"&&isNaN(t.zIndex)&&t.zIndex==="auto"){t.zIndex=this._isIE()?o.zIndex:this._zIndex()}this.settings=this._extend({},o,t);if(typeof this.element==="object"){this._box.init(this)}else{this[this.element]()}}var s="custombox",o={url:null,cache:false,escKey:true,eClose:null,zIndex:10002,overlay:true,overlayColor:"#000",overlayOpacity:0,overlayClose:true,overlaySpeed:200,customClass:null,width:null,height:null,effect:"fadein",position:null,speed:600,open:null,complete:null,close:null,responsive:true,scrollbar:false,error:"Error 404!"};i.prototype={_overlay:function(){var e=this._hexToRgb(this.settings.overlayColor),t={};if(navigator.appVersion.indexOf("MSIE 8.")!=-1){t.backgroundColor=this.settings.overlayColor;t.zIndex=parseFloat(this.settings.zIndex)+1;t.filter="alpha(opacity="+this.settings.overlayOpacity*100+")"}else{t["background-color"]="rgba("+e.r+","+e.g+", "+e.b+","+this.settings.overlayOpacity+")";t["z-index"]=parseFloat(this.settings.zIndex)+1;t["transition"]="all "+this.settings.overlaySpeed/1e3+"s"}n.getElementsByTagName("body")[0].appendChild(this._create({id:"overlay",eClass:"overlay"},t))},_box:{init:function(i){var s=i._create({},{visibility:"hidden",width:"100px"});var o=n.body;o.appendChild(s);var u=s.offsetWidth;s.style.overflow="scroll";var a=i._create({},{width:"100%"});s.appendChild(a);var f=a.offsetWidth;s.parentNode.removeChild(s);o.style.marginRight=u-f+"px";i._addClass(n.getElementsByTagName("html")[0],"hide-scrollbar");var l="wtrTableModalOverlay";if(0==e("."+l).length){jQuery("body").prepend('<div class="wtrTableModalOverlay"> <div id="wtrTimeTableLoaderCss" class="wtrShtTTLoader"> <div class="wtrRect1"></div> <div class="wtrRect2"></div> <div class="wtrRect3"></div> <div class="wtrRect4"></div> <div class="wtrRect5"></div> </div> </div>')}e(".wtrTableModalOverlay, #wtrTimeTableLoaderCss").show();jQuery(t).resize(function(){jQuery("#wtrTimeTableLoaderCss").css({top:jQuery(t).height()/2-20+jQuery(t).scrollTop(),left:jQuery(t).width()/2-25})});jQuery(t).trigger("resize");if(i.settings.open&&typeof i.settings.open==="function"){i.settings.open(r!==arguments[0]?arguments[0]:"")}if(i.settings.url===null){if(i.element!==null){i.settings.url=i.element.getAttribute("href")}}if(typeof i.settings.url==="string"){if(i.settings.url.charAt(0)==="#"||i.settings.url.charAt(0)==="."){if(n.querySelector(i.settings.url)){i._box.build(i,n.querySelector(i.settings.url).cloneNode(true))}else{i._box.build(i,null)}}else{this.ajax(i)}}else{i._box.build(i,null)}},create:function(e){var t={};if(e._isIE()){t.zIndex=parseFloat(e.settings.zIndex)+2}else{t["z-index"]=parseFloat(e.settings.zIndex)+2}var r=e._create({id:"modal",eClass:"modal "+e._box.effect(e)+(e.settings.customClass?" "+e.settings.customClass:"")},t),i=e._create({id:"modal-content",eClass:"modal-content"},{"transition-duration":e.settings.speed+"ms"});r.appendChild(i);jQuery("#wtrTimeTableLoaderCss").hide();n.body.insertBefore(r,n.body.firstChild);if(e.settings.overlay){e._overlay()}return[r,i]},effect:function(e){var t=["slide","flip","rotate"],r=["letmein","makeway","slip","blur"],i=s+"-"+e.settings.effect,o="";if(e.settings.position!==null&&e.settings.position.indexOf(",")!==-1){e.settings.position=e.settings.position.split(",");if(e.settings.position.length>1){o=" "+s+"-"+e.settings.effect+"-"+e.settings.position[0].replace(/^\s+|\s+$/g,"")+"-"+e.settings.position[1].replace(/^\s+|\s+$/g,"")}}for(var u=0,a=t.length;u<a;u++){if(t[u]===e.settings.effect){i=s+"-"+e.settings.effect+"-"+(o!==""?e.settings.position[0]:e.settings.position)+o}}for(var f=0,l=r.length;f<l;f++){if(r[f]===e.settings.effect){if(e.settings.effect!=="blur"){e._addClass(n.getElementsByTagName("html")[0],"perspective")}var c=n.createElement("div");c.className=s+"-container";while(n.body.firstChild){c.appendChild(n.body.firstChild)}n.body.appendChild(c)}}return i},build:function(e,i){var o=n.body,u=n.documentElement,a=u&&u.scrollTop||o&&o.scrollTop||0;if(e.settings.error!==false&&typeof e.settings.error==="string"){if(i===null){i=n.createElement("div");e._addClass(i,"error");i.innerHTML=e.settings.error}var f=e._box.create(e);f[1].appendChild(i);i.style.display="block";f[0].setAttribute("data-"+s+"-scroll",a);var l={width:parseInt(e.settings.width,0),height:parseInt(e.settings.height,0)};if(!isNaN(l.width)&&l.width===e.settings.width&&l.width.toString()===e.settings.width.toString()&&l.width!==null){i.style.width=l.width+"px"}if(!isNaN(l.height)&&l.height===e.settings.height&&l.height.toString()===e.settings.height.toString()&&l.height!==null){i.style.height=l.height+"px"}var c=i.offsetWidth,h={"margin-left":-c/2+"px",width:c+"px"};if(e._isIE()){var p=i.offsetHeight;h["margin-top"]="0px";h["height"]=p+"px"}if(e.settings.position!==null&&e.settings.position.indexOf("top")!==-1){h["transform"]="none"}e._create({},h,f[0]);var d={width:"innerWidth"in t?t.innerWidth:n.documentElement.offsetWidth,height:"innerHeight"in t?t.innerHeight:n.documentElement.offsetHeight};if(!e.settings.scrollbar){if(i.offsetHeight<d.height&&o.offsetHeight>d.height){}}else{e._scrollbar(f[0])}if(e.settings.responsive){e._box.responsive(e,f,i,d)}setTimeout(function(){e._listeners(a);f[0].className+=" "+s+"-show";var n=f[1].getElementsByTagName("script");for(var i=0,o=n.length;i<o;i++){(new Function(n[i].text))()}if(t.attachEvent){setTimeout(function(){if(e.settings.complete&&typeof e.settings.complete==="function"){e.settings.complete(r!==arguments[0]?arguments[0]:"")}},e.settings.speed)}else{var u=true;f[0].addEventListener(e._crossBrowser(),function(){if(u){u=false;if(e.settings.complete&&typeof e.settings.complete==="function"){e.settings.complete(r!==arguments[0]?arguments[0]:"")}}},false)}},e.settings.overlay?e.settings.overlaySpeed:200)}},responsive:function(e,n,r,i){r.setAttribute("data-"+s+"-width",r.offsetWidth);e._create({},{width:"auto"},r);if(i.width<r.offsetWidth){e._create({},{width:i.width-40+"px","margin-left":"20px","margin-right":"20px",left:0},n[0])}var o="onorientationchange"in t,u=o?"orientationchange":"resize";if(t.attachEvent){t.attachEvent(u,function(){a(this)},false)}else{t.addEventListener(u,function(){a(this)},false)}var a=function(i){if(typeof t.orientation==="undefined"){if(r.getAttribute("data-"+s+"-width")!==null){var o=r.getAttribute("data-"+s+"-width");if(o>i.innerWidth){e._create({},{width:i.innerWidth-40+"px","margin-left":"20px","margin-right":"20px",left:0},n[0])}else{e._create({},{width:o+"px","margin-left":-o/2+"px",left:"50%"},n[0])}}}else{e._create(null,{width:i.innerWidth-40+"px","margin-left":"20px","margin-right":"20px",left:0},n[0])}}},ajax:function(e){var t=new XMLHttpRequest;t.onreadystatechange=function(){var r=4;if(t.readyState===r){if(t.status===200){var i=n.createElement("div");i.innerHTML=t.responseText;e._box.build(e,i)}else{e._box.build(e,null)}}};t.open("GET",e.settings.url+(!e.settings.cache?"?_="+(new Date).getTime():""),true);t.setRequestHeader("X-Requested-With","XMLHttpRequest");t.send(null)}},_close:function(){var e=this;setTimeout(function(){e._removeClass(n.getElementsByTagName("html")[0],s+"-hide-scrollbar");n.getElementsByTagName("body")[0].style.marginRight=0;var i=e._isIE()?n.querySelectorAll("."+s+"-modal")[0]:n.getElementsByClassName(s+"-modal")[0];e._remove(i);if(e.settings.overlay){e._remove(e._isIE()?n.querySelectorAll("."+s+"-overlay")[0]:n.getElementsByClassName(s+"-overlay")[0])}if(e.settings.close&&typeof e.settings.close==="function"){e.settings.close(r!==arguments[0]?arguments[0]:"")}else if(typeof i!=="undefined"&&i.getAttribute("data-"+s)!==null){var o=i.getAttribute("data-"+s),u=(new Function("onClose","return "+o))(o);u()}t.top.scroll(0,i.getAttribute("data-"+s+"-scroll"));jQuery(".wtrTableModalOverlay").hide()},e.settings.speed);e._addClass(e._isIE()?n.querySelectorAll("."+s+"-modal")[0]:n.getElementsByClassName(s+"-modal")[0],"close");e._removeClass(e._isIE()?n.querySelectorAll("."+s+"-modal")[0]:n.getElementsByClassName(s+"-modal")[0],s+"-show");e._removeClass(n.getElementsByTagName("html")[0],s+"-perspective")},_listeners:function(){var e=this;if(e._isIE()){if(typeof n.querySelectorAll("."+s+"-overlay")[0]!=="undefined"&&e.settings.overlayClose){n.querySelectorAll("."+s+"-overlay")[0].attachEvent("onclick",function(){e._close()})}}else{if(typeof n.getElementsByClassName(s+"-overlay")[0]!=="undefined"&&e.settings.overlayClose){n.getElementsByClassName(s+"-overlay")[0].addEventListener("click",function(){e._close()},false)}}if(e.settings.escKey){n.onkeydown=function(n){n=n||t.event;if(n.keyCode===27){e._close()}}}if(e.settings.eClose!==null&&typeof e.settings.eClose==="string"&&e.settings.eClose.charAt(0)==="#"||typeof e.settings.eClose==="string"&&e.settings.eClose.charAt(0)==="."&&n.querySelector(e.settings.eClose)){n.querySelector(e.settings.eClose).addEventListener("click",function(){e._close()},false)}if(e.settings.close&&typeof e.settings.close==="function"){var r=e.settings.close;var i=e._isIE()?n.querySelectorAll("."+s+"-modal")[0]:n.getElementsByClassName(s+"-modal")[0];i.setAttribute("data-"+s,r)}},_extend:function(){for(var e=1,t=arguments.length;e<t;e++){for(var n in arguments[e]){if(arguments[e].hasOwnProperty(n)){arguments[0][n]=arguments[e][n]}}}return arguments[0]},_create:function(e,t,i){var o=i===r||i===null?n.createElement("div"):i;Object.keys=Object.keys||function(e){var t=[];for(var n in e){if(e.hasOwnProperty(n)){t.push(n)}}return t};if(e!==null&&Object.keys(e).length!==0){if(e.id!==null){o.id=s+"-"+e.id}if(e.eClass!==null){this._addClass(o,e.eClass)}}if(t!==null){for(var u in t){if(t.hasOwnProperty(u)){if(this._isIE()){var a=u.split("-");if(a.length>1){a=a[0]+a[1].replace(/(?:^|\s)\w/g,function(e){return e.toUpperCase()})}o.style[a]=t[u]}else{o.style.setProperty(u,t[u],null)}if((u.indexOf("transition")!==-1||u==="transform"!==-1)&&!this._isIE()){var f=["-webkit-","-ms-"];for(var l=0,c=f.length;l<c;l++){o.style.setProperty(f[l]+u,t[u],null)}}}}}return o},_hexToRgb:function(e){var t=/^#?([a-f\d])([a-f\d])([a-f\d])$/i;e=e.replace(t,function(e,t,n,r){return t+t+n+n+r+r});var n=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);return n?{r:parseInt(n[1],16),g:parseInt(n[2],16),b:parseInt(n[3],16)}:null},_addClass:function(e,t){if(!this._hasClass(e,t)){e.className=e.className.length&&e.className!==" "?e.className+" "+s+"-"+t:s+"-"+t}},_removeClass:function(e,t){if(this._hasClass(e,t)){var n=new RegExp("(\\s|^)"+t+"(\\s|$)");e.className=e.className.replace(n," ")}},_hasClass:function(e,t){return e!==r?e.className.match(new RegExp("(\\s|^)"+t+"(\\s|$)")):false},_remove:function(e){if(e!==r){e.parentNode.removeChild(e)}},_zIndex:function(){var e=n,t=e.getElementsByTagName("*"),r=0;for(var i=0,s=t.length;i<s;i++){var o=e.defaultView.getComputedStyle(t[i],null).getPropertyValue("z-index");if(o>r&&o!=="auto"){r=o}}return r},_isIE:function(){return navigator.appVersion.indexOf("MSIE 9.")!=-1||navigator.appVersion.indexOf("MSIE 8.")!=-1},_crossBrowser:function(){var e=n.createElement("fakeelement"),t={transition:"transitionend",WebkitTransition:"webkitTransitionEnd"},i;for(var s in t){if(t.hasOwnProperty(s)&&e.style[s]!==r){i=t[s]}}return i},_scrollbar:function(e){var n=this;setTimeout(function(){t.scrollTo(0,0)},n.settings.overlay?n.settings.overlaySpeed:200);var r={position:"absolute"};if(n.settings.position!==null&&n.settings.position.indexOf("top")!==-1){r["top"]=0;r["margin-top"]="20px"}n._create({},r,e)},close:function(){this._close()}};e.fn[s]=function(t){var n=arguments,o=typeof HTMLElement==="object"?t instanceof HTMLElement:t&&typeof t==="object"&&t!==null&&t.nodeType===1&&typeof t.nodeName==="string";if(t===r||typeof t==="object"){if(o){if(navigator.appName==="Microsoft Internet Explorer"){var u=new RegExp("MSIE ([0-9]{1,}[.0-9]{0,})");if(u.exec(navigator.userAgent)!=null){var a=parseInt(RegExp.$1)}}if(typeof a==="undefined"||a>=10){if(t.getAttribute("data-"+s)!==null&&parseInt(t.getAttribute("data-"+s))+1>Math.round((new Date).getTime()/1e3)){return}t.setAttribute("data-"+s,Math.round((new Date).getTime()/1e3))}e(t).each(function(){e.data(this,s,new i(this,n[1]))})}else{new i(null,n[0])}}else if(typeof t==="string"&&t==="close"){e.data(this,s,new i(n[0],n[1]))}}})(jQuery,window,document);
// Wonster.co scripts

var WtrPublicScheduleFunction = function(){};
var wtrClassSchedule;

(function($) {

	"use strict";

	WtrPublicScheduleFunction.prototype = {

		init : function()
		{
			this.class_details_modal();
			this.filter_classes_modal();
			this.filter_classes();
			this.multi_week_change_week();
			this.daily_schedule();
		},// end init


		class_details_modal : function()
		{
			$( document ).on( 'click', '.wtrClassDetails', function ( e ) {
				$.fn.custombox( this, {
					effect		: 'fadein',
					position	: 'center',
					customClass	: 'customslide',
					speed		: 200,
					width		: 800,
					url			: wtr_classes_schedule_param.ajax_url + '?action=wtr_calendar_schedule_class_detail&type=' + $( this ).data( 'type' ) + '&level=' + $( this ).data( 'level' ) + '&idx=' + $( this ).data( 'idx' ) + '&class=' + $( this ).data( 'class' ) + '&time=' + $( this ).data( 'time' ),
					complete: function () {
						// btn close
						$( '.wtrTimeTableModalClose' ).on( 'click', function(){
							$( '#custombox-overlay' ).trigger( 'click' );
						});
					}
				});
				e.preventDefault();
			});
		},//end class_details_modal


		filter_classes_modal : function()
		{
			var $btn_filter = $( '.wtrClassFilter' );
			$btn_filter.on('click', function ( e ) {

				if( $( this ).hasClass( 'wtrStopAction' ) ){
					return false;
				}

				$.fn.custombox( this, {
					effect		: 'fadein',
					position	: 'center',
					cache		: true,
					customClass	: 'customslide',
					speed		: 200,
					width		: 1170,
					url			: wtr_classes_schedule_param.ajax_url + '?action=wtr_calendar_schedule_class_filter&id_calendar=' + $( this ).data( 'calendar' ) + '&type=' + $( this ).data( 'type' ) + '&idx=' + $( this ).data( 'idx' ),
					complete: function () {

						// btn close
						$( '.wtrTimeTableModalClose' ).on( 'click', function(){
							$( '#custombox-overlay' ).trigger( 'click' );
						});

						//tabs
						 $('.wtrTimeTableModalTabs').easyResponsiveTabs({
							type	: 'default',			//Types: default, vertical, accordion
							width	: 'auto',				//auto or any width like 600px
							fit		: true,					// 100% fit in a container
							closed	: 'accordion',			// Start closed if in accordion view
							activate: function( event ) {	// Callback function if tab is switched
								var $tab	= $( this );
								var $info	= $( '#tabInfo' );
								var $name	= $( 'span', $info );
								$name.text( $tab.text() );
								$info.show();
							}
						});

						wtrClassSchedule.filter_classes();
					},
				});
				e.preventDefault();
			});
		},//end filter_classes_modal


		filter_classes : function()
		{
			$( '.wtrTimetableFilterData' ).on( 'click', function(){
				var calendar_id		= $( this ).data( 'idx' );
				var filter			= $( this ).data( 'filter' );
				var $calendar		= $( '.wtrShtTimeTableIdx-' + calendar_id );
				var calendar_fields	= $calendar.find( '.wtrShtTimeTableFitnessEntryClass' );

				calendar_fields.hide();
				calendar_fields.filter( '.' + filter ).show();
				$calendar.find( '.wtrscheduleTimeGo' ).attr( 'data-filter', filter );

				$( '#custombox-overlay' ).trigger( 'click' );
			});

			$( '.wtrTimetableFilterDataAll' ).on( 'click', function(){

				if( $( this ).hasClass( 'wtrStopAction' ) ){
					return false;
				}

				var $calendar = $( this ).parents( '.wtrShtTimeTable' );
				$calendar.find( '.wtrShtTimeTableFitnessEntryClass' ).show();
				$calendar.find( '.wtrscheduleTimeGo' ).attr( 'data-filter', '' );
			});
		},//filter_classes


		multi_week_change_week : function()
		{
			$( '.wtrscheduleTimeGo' ).on( 'click', function(){
				var $elem		= $( this );
				var direction	= $elem.data( 'direction' ),
					calendar	= $elem.data( 'calendar' ),
					modal		= $elem.data( 'modal' ),
					level		= $elem.data( 'level' ),
					hours		= $elem.data( 'hours' ),
					id_class	= $elem.data( 'idclass' ),
					clickable	= $elem.data( 'clickable' ),
					showweekend	= $elem.data( 'showweekend' ),
					day			= $elem.siblings( '.wtrShtTimeTableHeadlinePeriod' ).find( '.wtrScheduleTimePickerStart' ).text(),
					$parents	= $elem.parents('.wtrShtDesktopTimeTable' ),
					notiQuery	= $( '#wtr_calendar_public_nonce' ).val();

				//show loader
				var schedule_c	= $parents.find( '.wtrShtTimeTableLoadOverlay' );
				schedule_c.fadeIn( 'fast' );

				//block action
				$parents.find( '.wtrClassFilter' ).addClass( 'wtrStopAction' );
				$parents.find( '.wtrTimetableFilterDataAll' ).addClass( 'wtrStopAction' );
				$parents.find( '.wtrscheduleTimeGo' ).addClass( 'wtrStopAction' );

				$.ajax({
					type		: 'POST',
					dataType	: 'json',
					url			: wtr_classes_schedule_param.ajax_url,
					data		: {
						action		: 'wtr_calendar_get_week',
						day			: day,
						modal		: modal,
						direction	: direction,
						calendar	: calendar,
						level		: level,
						hours		: hours,
						id_class	: id_class,
						clickable	: clickable,
						showweekend	: showweekend,
						_wpnonce	: notiQuery
					},
					success : function( msg )
					{
						window.x = msg;
						$parents.find( '.wtrScheduleTimePickerStart' ).text( msg.scope.days_f[ 0 ] );
						$parents.find( '.wtrScheduleTimePickerEnd' ).text( msg.scope.days_f[ 6 ] );

						$parents.find( '.wtrShtTimeTableItem' ).remove();
						$parents.find( '.wtrShtTimeTableLoadOverlay' ).after( msg.html_data );

						var filter_data = $parents.find( '.wtrShtTimeTableBtnPrev' ).attr( 'data-filter' );

						if( '' != filter_data ){
							$parents.find( '.wtrShtTimeTableFitnessEntryClass' ).hide();
							$parents.find( '.' + filter_data ).show();
						}

						schedule_c.fadeOut( 'fast' );

						$parents.find( '.wtrClassFilter' ).removeClass( 'wtrStopAction' );
						$parents.find( '.wtrTimetableFilterDataAll' ).removeClass( 'wtrStopAction' );
						$parents.find( '.wtrscheduleTimeGo' ).removeClass( 'wtrStopAction' );
					},
				});

			});
		},


		daily_schedule : function()
		{
			var $daily_rotator = $('.wtrDailyScheduleRotator');
			$daily_rotator.owlCarousel({

				loop			:true,
				dots			:true,
				margin			:0,
				responsiveClass	:true,
				responsive		:{
					0		:{ items:1, nav:true, dots:true, loop:false },
					600		:{ items:3, nav:false },
					1000	:{ items:4, nav:true, dots:true, autoplay:false, autoplayTimeout:2000, autoplayHoverPause:true }
				}
			});

			$( '.wtrDSNext' ).click(function() {
				$daily_rotator.trigger( 'next.owl.carousel' );
			})
			$( '.wtrDSPrev' ).click(function() {
				$daily_rotator.trigger( 'prev.owl.carousel', [ 300 ] );
			})
		},
	};// end WtrPublicScheduleFunction


	$(document).ready(function(){
		wtrClassSchedule = new WtrPublicScheduleFunction();
		wtrClassSchedule.init();
	});
})(jQuery);