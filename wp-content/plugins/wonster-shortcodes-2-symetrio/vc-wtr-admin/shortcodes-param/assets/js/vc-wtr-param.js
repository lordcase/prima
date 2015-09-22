(function($) {

	"use strict";

	var WtrVCParam = {

		init: function() {
			this.wtr_animate_dropdown();
			this.wtr_icons_set();
			this.wtr_multi_select();

			setTimeout(this.wtr_google_map, 100);
		}, // end init


		wtr_animate_dropdown: function() {
			// switch dropdown
			var $select = $('.wtr_animate_select');

			if ($select.length) {
				var animateDivClass = 'animatedElement',
					$animate_div = $('.' + animateDivClass),
					aniationOpt,
					animate;

				$select.change(function() {
					aniationOpt = $(this).val();
					animate = aniationOpt.split('_');

					setTimeout(function() {
						$animate_div.removeAttr('class').addClass(animateDivClass + ' animated ' + animate.join(' '));
					}, 250 );
				});
			}
		}, //end wtr_animate_dropdown


		wtr_icons_set: function()
		{
			var $select = $('.wtrVcSelectGroup');
			if ($select.length) {
				var selectUser,
					icon = $('.wtrVcIconItemPos'),
					selectGroupVal = $select.find(":selected").val();

				// init
				$('.wtrIcon_' + selectGroupVal).fadeIn();

				// change group
				$select.change(function() {
					var area = $(this).parents('.wtr_vc_icons_set_div');
					var selectUser = $(this).val();

					area.find('.wtrVcIconList').hide();
					area.find('.wtrIcon_' + selectUser).fadeIn();
				});

				// select icon
				icon.click(function(event) {
					var classI,
						el,
						group,
						area = $(this).parents('.wtr_vc_icons_set_div');

					area.find('.wtrVcIconItemPos ').removeClass('iTPActive');
					$(this).addClass('iTPActive');

					classI = $(this).children('i').attr('class');
					el = area.find('.wtrIconSelectUser');
					el.fadeIn();
					el.find('i').removeClass().addClass(classI);

					// set hidden value
					group = area.find('.wtrVcSelectGroup').find(":selected").val();
					area.find('.wtr_vc_selected_icon').val($.trim(group) + '|' + $.trim(classI));
				});
			}
		}, //end wtr_icon_set


		wtr_multi_select: function()
		{
			var $multi_select = $('.wtr_vc_multi_select_field');
			if ($multi_select.length) {
				$multi_select.change(function() {
					var $real_val = $(this).parent().find('.wtr_vc_value'),
						val = $(this).val();
					var val_fo_save = (val.length) ? val.join() : '';

					$real_val.val(val_fo_save);
				});
			}
		}, //end wtr_multi_select


		wtr_google_map: function() {
			var $mapConteners = $( '.wtrVcGoogleMapContener' );
			if ($mapConteners.length) {
				$mapConteners.each(function(i, e) {
					WtrVCGoogleMaps.init($(e));
				});
			}
		}, //end wtr_google_map
	}; //end WtrVCParam



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

		init: function(mapContener)
		{
			var self = this;
			self.mapContener = mapContener;
			self.valueField = self.mapContener.siblings('.wtrVcGeoMapsVal');
			self.searchBtn = self.mapContener.siblings('.wtrVcSearchSectionMaps').find('.wtr_gmaps_search_btn');
			self.searchInput = self.mapContener.siblings('.wtrVcSearchSectionMaps').find('.wtr_maps_search_in');
			this._mappingArea(self);
		}, //end init


		_mappingArea: function(self)
		{
			var type_map_controler = $.trim(self.mapContener.attr('data-type-map-controler')),
				style_map_controler = $.trim(self.mapContener.attr('data-style-map-controler')),
				marker_map_controler = $.trim(self.mapContener.attr('data-marker-map-controler'));

			self.id = $.trim(self.mapContener.attr('id'));
			self.zoom = parseInt($.trim(self.mapContener.attr('data-zoom')));

			self.geo.x = $.trim(self.mapContener.attr('data-x'));
			self.geo.y = $.trim(self.mapContener.attr('data-y'));

			self._updateMarkerPos(self,
				$.trim(self.mapContener.attr('data-x')),
				$.trim(self.mapContener.attr('data-y'))
			);

			// type map controler
			if (false != type_map_controler) {
				self.typeControler = $('.' + type_map_controler);
				self.typeMap = self.typeControler.find(':selected').val();

				self._changeTypeMapGoogle(self);
			}

			// style map controler
			if (false != style_map_controler) {
				self.styleControler = $('.' + style_map_controler);
				self.styleMap = self.styleControler.find(':selected').val();

				self._changeStyleMapGoogle(self);
			}

			// style marker map controler
			if (false != marker_map_controler) {
				var marker_main_controler = marker_map_controler.split('|');

				self.markerControler = $('.' + marker_main_controler[0]);
				self.styleMarker = self.markerControler.find(':selected').val();

				self.ownMarkerControler = $('.' + marker_main_controler[1]);
				self.ownMarkerId = self.ownMarkerControler.val();

				if (null != self.ownMarkerId) {
					self.ownMarkerImgData = self._getOwnMarkerImgData(self);
				}

				self._changeStyleMapMarkerGoogle(self);
				self._changeStyleOwnMarkerMarkerGoogle(self);
			}

			//road mode
			if (self.mapContener.attr('data-road-controler')) {
				self.roadContener = $('.' + self.mapContener.attr('data-road-controler'));

			} else {
				self.roadContener = false;
			}

			self._initMapGoogle(self);
			self._createMarkerMap(self);
			self._createPolylineMap(self);
			self._searchAction(self);
		}, //end _mappingArea


		_initMapGoogle: function(self)
		{
			self.geocoder = new google.maps.Geocoder();
			self.mapOptions = {
				zoom: self.zoom,
				center: self.geoGoogle,
				mapTypeId: google.maps.MapTypeId[self.typeMap],
				scrollwheel: false,
				streetViewControl: false,
				styles: wtr_google_maps_style[self.styleMap],
			}


			if (false != self.roadContener) {
				self.mapOptions.draggableCursor = 'crosshair';
			}


			self.map = new google.maps.Map(document.getElementById(self.id), self.mapOptions);
		}, //end _initMapGoogle


		_createMarkerMap: function(self)
		{
			if (false != self.roadContener) {
				return false;
			}

			//wtr icon set
			if ('my_own' != self.styleMarker) {
				var icon_set = {
					url: wtr_google_marker_style[self.styleMarker].url,
					scaledSize: new google.maps.Size(
						wtr_google_marker_style[self.styleMarker].width,
						wtr_google_marker_style[self.styleMarker].height)
				};
			} else {
				if (null == self.ownMarkerId || '' == self.ownMarkerId) {
					var icon_set = null;
				} else {
					var icon_set = self.ownMarkerImgData;
				}
			}

			// create marker
			self.marker = new google.maps.Marker({
				position: self.geoGoogle,
				map: self.map,
				draggable: true,
				icon: icon_set,
			});

			//drag marker
			google.maps.event.addListener(self.marker, 'dragend', function(event) {
				self._updateMarkerPos(self, event.latLng.lat(), event.latLng.lng());
			});

			//click map - set new geo for marker
			google.maps.event.addListener(self.map, 'click', function(event) {
				self.marker.setPosition(event.latLng);
				self._updateMarkerPos(self, event.latLng.lat(), event.latLng.lng());
			});
		}, //end _createMarkerMap


		_changeStyleMapMarkerGoogle: function(self)
		{
			self.markerControler.change(function() {
				self.styleMarker = $(this).val();

				self.marker.setMap(null);
				self._createMarkerMap(self);
			});
		}, //end _changeStyleMapMarkerGoogle


		_changeStyleOwnMarkerMarkerGoogle: function(self)
		{
			self.ownMarkerControler.change(function() {
				self.ownMarkerId = $(this).val();
				self.ownMarkerImgData = self._getOwnMarkerImgData(self);

				self.marker.setMap(null);
				self._createMarkerMap(self);
			});
		}, //end _changeOwnMarker


		_getOwnMarkerImgData: function(self)
		{
			var imgData = wp.media.attachment(self.ownMarkerId).toJSON();

			if( undefined != imgData.url ){
				return {
					url: imgData.url,
					scaledSize: new google.maps.Size(
						imgData.width,
						imgData.height
					)
				};
			}else{
				var source;
				$.ajax({
					type		: 'POST',
					dataType	: 'json',
					async 		: false,
					url			: ajaxurl,
					data		: {
						action		: 'wtr_get_attachment_data',
						id_file		: self.ownMarkerId,
					},
					success : function( msg )
					{
						source = {
							url: msg.url,
							scaledSize: new google.maps.Size(
								parseInt( msg.width ),
								parseInt( msg.height )
							)
						};
					},
				});

				return source;
			}
		},//end _getOwnMarkerImgData


		_updateMarkerPos: function(self, x, y)
		{
			self.geo.x = x;
			self.geo.y = y;
			self.geoGoogle = new google.maps.LatLng(self.geo.x, self.geo.y);
			self.valueField.val(self.geo.x + '|' + self.geo.y);
		}, //end _updateMarkerPos


		_createPolylineMap: function(self)
		{
			if (false == self.roadContener || undefined === self.roadContener) {
				return false;
			}

			// init variable
			self.roadContenerColor = (self.mapContener.attr('data-road-color')) ? $('.' + self.mapContener.attr('data-road-color')) : false;
			if (self.roadContenerColor) {
				self.roadContenerColor.parents('.vc-color-picker').find('.vc-alpha-container').remove();
				self.roadColor = self.roadContenerColor.val();
			}

			self.roadContenerWeight = (self.mapContener.attr('data-road-weight')) ? $('.' + self.mapContener.attr('data-road-weight')) : false;
			if (self.roadContenerWeight) {
				self.roadWeight = self.roadContenerWeight.val();
			}

			self.roadPath = new google.maps.MVCArray();
			self.roadService = new google.maps.DirectionsService();
			self.roadMarkerStart = null;
			self.roadMarkerEnd = null;
			self.lastStepCount = [];
			self.roadFlagClear = false;
			self.roadControler = {};

			//init controler
			self.roadControler = self.mapContener.siblings('.wtrGoogleMapToolSet');
			self.roadControler.distanceField = {};
			self.roadControler.distanceField.miles = self.roadControler.find('.wtrDistMiles');
			self.roadControler.distanceField.km = self.roadControler.find('.wtrDistKm');
			self.roadControler.distanceField.m = self.roadControler.find('.wtrDistMetres');

			self.roadControler.undo = self.roadControler.find('#removeLastPoint');
			self.roadControler.removeAllPont = self.roadControler.find('#removeAllPoint');

			// draw road
			self._actionDrawRoad(self);

			// events
			self._actionDrawPontRoad(self);
			self._removeAllPointsRoad(self);
			self._removeLastPointsRoad(self);
			self._changeColorRoad(self);
			self._changeWeightRoad(self);
		}, //end _createPolylineMap


		_actionDrawRoad: function(self)
		{
			var loadedPoints = self._getPolylinePoints(self);
			// create object
			self.roadPolyline = new google.maps.Polyline({
				path: loadedPoints,
				map: self.map,
				strokeColor: self.roadColor,
				strokeWeight: self.roadWeight,
				geodesic: true,
			});

			if (loadedPoints.length) {
				google.maps.event.addListenerOnce(self.map, 'idle', function() {

					for (var i = 0; i < loadedPoints.length; i++) {
						self.roadPath.push(loadedPoints[i]);
					}

					self.roadPolyline.setPath(self.roadPath);

					self._addRoadFirstPoint(self, loadedPoints[0]);
					self._addRoadMarkerEnd(self, loadedPoints[loadedPoints.length - 1]);
					self._calculateRoadDistances(self);
				});
			}
		}, //end _actionDrawRoad


		_getPolylinePoints: function(self)
		{
			var pointString = $.trim(self.roadContener.val()),
				pointArray = [];

			if ('' == pointString) {
				return pointArray;
			} else {
				var geoSteps = pointString.split('@');
				var geoStepsLen = geoSteps.length;

				for (var i = 0; i < geoStepsLen; i++) {
					var geoPoints = geoSteps[i].split('|');
					var geoPointsLen = geoPoints.length;

					self.lastStepCount.push(geoPoints.length);

					for (var j = 0; j < geoPointsLen; j++) {
						var point = geoPoints[j];
						var geo = point.split(';');
						var LatLng = new google.maps.LatLng(geo[0], geo[1]);

						pointArray.push(LatLng);
					}
				}
				return pointArray;
			}
		}, //end _getPolylinePoints


		_actionDrawPontRoad: function(self)
		{
			google.maps.event.addListener(self.map, 'click', function(evt) {

				if (self.roadPath.getLength() === 0) {
					self.roadPath.push(evt.latLng);
					self.roadPolyline.setPath(self.roadPath);

					// first pont
					self._addRoadFirstPoint(self, evt.latLng);
				} else if ($('#roadSnapMode').is(':checked')) {
					self.roadService.route({
							origin: self.roadPath.getAt(self.roadPath.getLength() - 1),
							destination: evt.latLng,
							travelMode: google.maps.DirectionsTravelMode.WALKING
						},
						function(result, status) {
							if (status == google.maps.DirectionsStatus.OK) {
								self.lastStepCount.push(result.routes[0].overview_path.length);

								for (var i = 0, len = result.routes[0].overview_path.length; i < len; i++) {
									self.roadPath.push(result.routes[0].overview_path[i]);
								}

								self._newRoadClickEvent(self, evt.latLng);
							}
						});
				} else {
					self.lastStepCount.push(1);
					self.roadPath.push(evt.latLng);
					self._newRoadClickEvent(self, evt.latLng);
				}
			});
		}, //end _actionDrawPontRoad


		_addRoadFirstPoint: function(self, latLng)
		{
			self.roadMarkerStart = new google.maps.Marker({
				position: latLng,
				title: 'Start',
				map: self.map,
				icon: {
					url: wtr_google_marker_style.pin_red_circle.url,
					scaledSize: new google.maps.Size(36, 36)
				}
			});
		}, //end _addRoadFirstPoint


		_newRoadClickEvent: function(self, latLng)
		{
			self.roadFlagClear = false;
			self._calculateRoadDistances(self);
			self._addRoadMarkerEnd(self, latLng);
			self._exportToTextField(self);
		}, //end _newRoadClickEvent


		_addRoadMarkerEnd: function(self, latLng)
		{
			if (null != self.roadMarkerEnd) {
				self.roadMarkerEnd.setMap(null);
			}

			self.roadMarkerEnd = new google.maps.Marker({
				position: latLng,
				title: 'End',
				map: self.map,
				icon: {
					url: wtr_google_marker_style.pin_green_circle.url,
					scaledSize: new google.maps.Size(36, 36)
				}
			});
		}, //end __addRoadMarkerEnd


		_removeLastPointsRoad: function(self)
		{
			var lenPath = null,
				latLng = null;

			self.roadControler.undo.click(function() {

				//var wsk = path.getLength() - 1;
				var lastStepCountC = self.lastStepCount.pop();

				if (self.roadFlagClear) {

					if (null != self.roadMarkerStart) {
						self.roadMarkerStart.setMap(null);
					}

					if (null != self.roadMarkerEndt) {
						self.roadMarkerEnd.setMap(null);
					}

					self.roadPath.clear();
				} else {
					for (var i = 0; i < lastStepCountC; i++) {
						self.roadPath.pop();
					}

					lenPath = self.roadPath.getLength();

					if (lenPath == 1) {
						self.roadMarkerEnd.setMap(null);
						self.roadFlagClear = true;
					} else {
						latLng = self.roadPath.getAt(lenPath - 1);
						self._addRoadMarkerEnd(self, latLng);
					}
				}

				self._calculateRoadDistances(self);
			});
		}, //end _removeLastPointsRoad


		_removeAllPointsRoad: function(self)
		{
			self.roadControler.removeAllPont.click(function() {

				if (self.roadMarkerStart) {
					self.roadMarkerStart.setMap(null);
				}

				if (self.roadMarkerEnd) {
					self.roadMarkerEnd.setMap(null);
				}

				self.roadPath.clear();
				self._calculateRoadDistances(self);
			});
		}, //_removeAllPointsRoad


		_calculateRoadDistances: function(self)
		{
			var stuDistances = {};

			stuDistances.metres = google.maps.geometry.spherical.computeLength(self.roadPath.getArray());
			stuDistances.km = Math.round(stuDistances.metres / 1000 * 10) / 10;
			stuDistances.miles = Math.round(stuDistances.metres / 1000 * 0.6214 * 10) / 10;
			stuDistances.metres = Math.round(stuDistances.metres * 10) / 10;

			self._drawRoadDistancesInfo(self, stuDistances);
		}, //end _calculateRoadDistances


		_drawRoadDistancesInfo: function(self, d)
		{
			self.roadControler.distanceField.miles.html(d.miles);
			self.roadControler.distanceField.km.html(d.km);
			self.roadControler.distanceField.m.html(d.metres);
		}, //end_drawRoadDistancesInfo


		_exportToTextField: function(self)
		{
			var lenPath = self.roadPath.getLength(),
				lenStepA = self.lastStepCount.length,
				exportText = '';

			var exportItem = self.roadPath.getAt(0);
			if (undefined !== exportItem) {
				exportText += exportItem.lat() + ';' + exportItem.lng() + '@';
			}

			for (var i = 0, wsk = 0; i < lenStepA; i++) {
				for (var j = 0; j < self.lastStepCount[i]; j++, wsk++) {
					var exportItem = self.roadPath.getAt(wsk);

					if (undefined !== exportItem) {
						exportText += exportItem.lat() + ';' + exportItem.lng() + '|';
					}
				}
				exportText = exportText.slice(0, -1);
				exportText += '@';
			}
			self.roadContener.val(exportText.slice(0, -1));
		}, //end _exportToTextField


		_changeColorRoad: function(self)
		{
			var ColorContener = self.roadContenerColor.parents('.vc-color-picker').find('.wp-color-result');

			setInterval(function() {
				if (!ColorContener.hasClass('wp-picker-open')) {
					if (self.roadColor != self.roadContenerColor.val()) {
						self.roadColor = self.roadContenerColor.val();
						self.roadPolyline.setOptions({
							strokeColor: self.roadColor
						});
					}
				}
			}, 300);

		}, //end _changeColorRoad


		_changeWeightRoad: function(self)
		{
			self.roadContenerWeight.change(function() {
				self.roadWeight = $(this).val();
				self.roadPolyline.setOptions({
					strokeWeight: self.roadWeight
				});
			});
		}, //end _changeWeightRoad


		_changeTypeMapGoogle: function(self)
		{
			self.typeControler.change(function() {
				self.typeMap = $(this).val();

				if (self.styleControler != false && 'STREET_VIEW_PANORAMA' == self.typeMap) {
					self.styleMap = 'standard';
					self.styleControler.val(self.styleMap);
				}

				self._initMapGoogle(self);
				self._createMarkerMap(self);
			});
		}, //end _changeTypeMapGoogle


		_changeStyleMapGoogle: function(self)
		{
			self.styleControler.change(function() {
				self.styleMap = $(this).val();

				self._initMapGoogle(self);
				self._createMarkerMap(self);
			});
		}, //end _changeStyleMapGoogle


		_searchAction: function(self)
		{
			self.searchBtn.click(function(event) {

				// Verify that you have provided a place to locate
				var address = $.trim(self.searchInput.val());

				if ('' != address) {
					self.geocoder.geocode({
						'address': address
					}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							self.map.setCenter(results[0].geometry.location);

							if (false == self.roadContener) {
								self.marker.setPosition(results[0].geometry.location);
							}

							self._updateMarkerPos(self, results[0].geometry.location.lat(), results[0].geometry.location.lng());
						} else {
							alert('Geocode was not successful for the following reason: ' + status);
						}
					});
				}
			});
		}//end _searchAction
	};

	// init listeners
	WtrVCParam.init();
})(jQuery);