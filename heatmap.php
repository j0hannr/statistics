<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
      <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmTAYFwzl41BtNCEShQ2OzTbpHMSnxAL4&libraries=visualization"></script> -->
    <title>Heatmaps</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }
      #floating-panel {
        background-color: #fff;
        border: 1px solid #999;
        left: 25%;
        padding: 5px;
        position: absolute;
        top: 10px;
        z-index: 5;
      }
    </style>
  </head>

  <body>
    <div id="floating-panel">
      <button onclick="toggleHeatmap()">Toggle Heatmap</button>
      <button onclick="changeGradient()">Change gradient</button>
      <button onclick="changeRadius()">Change radius</button>
      <button onclick="changeOpacity()">Change opacity</button>
    </div>
    <div id="map"></div>
    <script>

      // This example requires the Visualization library. Include the libraries=visualization
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmTAYFwzl41BtNCEShQ2OzTbpHMSnxAL4&libraries=visualization">

      var map, heatmap;

      function initMap() {
        var roadAtlasStyles = [{
  							"elementType": "geometry",
  							"stylers": [{
  									"color": "#f5f5f5"
  							}]
  					},
  					{
  							"elementType": "labels",
  							"stylers": [{
  									"visibility": "off"
  							}]
  					},
  					{
  							"elementType": "labels.icon",
  							"stylers": [{
  									"visibility": "off"
  							}]
  					},
  					{
  							"elementType": "labels.text.fill",
  							"stylers": [{
  									"color": "#616161"
  							}]
  					},
  					{
  							"elementType": "labels.text.stroke",
  							"stylers": [{
  									"color": "#f5f5f5"
  							}]
  					},
  					{
  							"featureType": "administrative.land_parcel",
  							"stylers": [{
  									"visibility": "off"
  							}]
  					},
  					{
  							"featureType": "administrative.land_parcel",
  							"elementType": "labels.text.fill",
  							"stylers": [{
  									"color": "#bdbdbd"
  							}]
  					},
  					{
  							"featureType": "administrative.neighborhood",
  							"stylers": [{
  									"visibility": "off"
  							}]
  					},
  					{
  							"featureType": "poi",
  							"elementType": "geometry",
  							"stylers": [{
  									"color": "#eeeeee"
  							}]
  					},
  					{
  							"featureType": "poi",
  							"elementType": "labels.text.fill",
  							"stylers": [{
  									"color": "#757575"
  							}]
  					},
  					{
  							"featureType": "poi.park",
  							"elementType": "geometry",
  							"stylers": [{
  									"color": "#e5e5e5"
  							}]
  					},
  					{
  							"featureType": "poi.park",
  							"elementType": "labels.text.fill",
  							"stylers": [{
  									"color": "#9e9e9e"
  							}]
  					},
  					{
  							"featureType": "road",
  							"elementType": "geometry",
  							"stylers": [{
  									"color": "#ffffff"
  							}]
  					},
  					{
  							"featureType": "road.arterial",
  							"elementType": "labels.text.fill",
  							"stylers": [{
  									"color": "#757575"
  							}]
  					},
  					{
  							"featureType": "road.highway",
  							"elementType": "geometry",
  							"stylers": [{
  									"color": "#dadada"
  							}]
  					},
  					{
  							"featureType": "road.highway",
  							"elementType": "labels.text.fill",
  							"stylers": [{
  									"color": "#616161"
  							}]
  					},
  					{
  							"featureType": "road.local",
  							"elementType": "labels.text.fill",
  							"stylers": [{
  									"color": "#9e9e9e"
  							}]
  					},
  					{
  							"featureType": "transit.line",
  							"elementType": "geometry",
  							"stylers": [{
  									"color": "#e5e5e5"
  							}]
  					},
  					{
  							"featureType": "transit.station",
  							"elementType": "geometry",
  							"stylers": [{
  									"color": "#eeeeee"
  							}]
  					},
  					{
  							"featureType": "water",
  							"stylers": [{
  									"color": "#ffffff"
  							}]
  					},
  					{
  							"featureType": "water",
  							"elementType": "geometry",
  							"stylers": [{
  									"color": "#ffffff"
  							}]
  					},
  					{
  							"featureType": "water",
  							"elementType": "labels.text.fill",
  							"stylers": [{
  									"color": "#9e9e9e"
  							}]
  					}
          ];
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 4,
          center: {lat: 37.775, lng: -122.434},
          mapTypeId: 'satellite'
        });

        heatmap = new google.maps.visualization.HeatmapLayer({
          data: getPoints(),
          map: map
        });

        var styledMapOptions = {
						name: 'Statistics'
				};

        usRoadMapType = new google.maps.StyledMapType(roadAtlasStyles, styledMapOptions);

        map.mapTypes.set('Statistics', usRoadMapType);
				map.setMapTypeId('Statistics');
      }


      function toggleHeatmap() {
        heatmap.setMap(heatmap.getMap() ? null : map);
      }

      function changeGradient() {
        var gradient = [
          'rgba(0, 255, 255, 0)',
          'rgba(0, 255, 255, 1)',
          'rgba(0, 191, 255, 1)',
          'rgba(0, 127, 255, 1)',
          'rgba(0, 63, 255, 1)',
          'rgba(0, 0, 255, 1)',
          'rgba(0, 0, 223, 1)',
          'rgba(0, 0, 191, 1)',
          'rgba(0, 0, 159, 1)',
          'rgba(0, 0, 127, 1)',
          'rgba(63, 0, 91, 1)',
          'rgba(127, 0, 63, 1)',
          'rgba(191, 0, 31, 1)',
          'rgba(255, 0, 0, 1)'
        ]
        heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
      }

      function changeRadius() {
        heatmap.set('radius', heatmap.get('radius') ? null : 20);
      }

      function changeOpacity() {
        heatmap.set('opacity', heatmap.get('opacity') ? null : 0.2);
      }

      // Heatmap data: 500 Points
      function getPoints() {
        return [
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	49.88286590	,	8.65964031	),
          new google.maps.LatLng(	49.41301800	,	8.71387500	),
          new google.maps.LatLng(	49.88286590	,	8.65964031	),
          new google.maps.LatLng(	49.88286590	,	8.65964031	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	52.02271226	,	8.52985382	),
          new google.maps.LatLng(	48.52007000	,	8.32665000	),
          new google.maps.LatLng(	46.94797400	,	7.44744700	),
          new google.maps.LatLng(	46.94797400	,	7.44744700	),
          new google.maps.LatLng(	46.62416400	,	8.04139600	),
          new google.maps.LatLng(	46.94797400	,	7.44744700	),
          new google.maps.LatLng(	48.52007000	,	8.32665000	),
          new google.maps.LatLng(	48.52007000	,	8.32665000	),
          new google.maps.LatLng(	48.77584600	,	9.18293200	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	52.02271226	,	8.52985382	),
          new google.maps.LatLng(	46.62416400	,	8.04139600	),
          new google.maps.LatLng(	46.62416400	,	8.04139600	),
          new google.maps.LatLng(	46.62416400	,	8.04139600	),
          new google.maps.LatLng(	46.62416400	,	8.04139600	),
          new google.maps.LatLng(	46.62416400	,	8.04139600	),
          new google.maps.LatLng(	46.62416400	,	8.04139600	),
          new google.maps.LatLng(	46.62416400	,	8.04139600	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.11353300	,	8.70117200	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.62925000	,	3.05725600	),
          new google.maps.LatLng(	50.62925000	,	3.05725600	),
          new google.maps.LatLng(	50.62925000	,	3.05725600	),
          new google.maps.LatLng(	50.62925000	,	3.05725600	),
          new google.maps.LatLng(	50.62925000	,	3.05725600	),
          new google.maps.LatLng(	50.62925000	,	3.05725600	),
          new google.maps.LatLng(	8.03768400	,	98.60431700	),
          new google.maps.LatLng(	7.89719600	,	98.29845400	),
          new google.maps.LatLng(	8.03768400	,	98.60431700	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	8.03768400	,	98.60431700	),
          new google.maps.LatLng(	8.03768400	,	98.60431700	),
          new google.maps.LatLng(	8.03768400	,	98.60431700	),
          new google.maps.LatLng(	8.03768400	,	98.60431700	),
          new google.maps.LatLng(	8.03768400	,	98.60431700	),
          new google.maps.LatLng(	8.03768400	,	98.60431700	),
          new google.maps.LatLng(	7.89719600	,	98.29845400	),
          new google.maps.LatLng(	13.75633100	,	100.50176500	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	13.75633100	,	100.50176500	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	51.22774100	,	6.77345600	),
          new google.maps.LatLng(	51.22774100	,	6.77345600	),
          new google.maps.LatLng(	51.22774100	,	6.77345600	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	52.02271226	,	8.52985382	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	7.89719600	,	98.29845400	),
          new google.maps.LatLng(	7.89719600	,	98.29845400	),
          new google.maps.LatLng(	13.75633100	,	100.50176500	),
          new google.maps.LatLng(	13.75633100	,	100.50176500	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	49.53981300	,	11.46802900	),
          new google.maps.LatLng(	49.42540900	,	11.07965500	),
          new google.maps.LatLng(	52.02271226	,	8.52985382	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.02271226	,	8.52985382	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	51.92423500	,	4.50451500	),
          new google.maps.LatLng(	51.92423500	,	4.50451500	),
          new google.maps.LatLng(	51.92423500	,	4.50451500	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	49.42540900	,	11.07965500	),
          new google.maps.LatLng(	49.42540900	,	11.07965500	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	53.54907943	,	9.98931885	),
          new google.maps.LatLng(	53.54907943	,	9.98931885	),
          new google.maps.LatLng(	53.54907943	,	9.98931885	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.62925000	,	3.05725600	),
          new google.maps.LatLng(	46.46283300	,	6.84191900	),
          new google.maps.LatLng(	46.65420600	,	6.50428700	),
          new google.maps.LatLng(	46.20632900	,	6.13981200	),
          new google.maps.LatLng(	50.62925000	,	3.05725600	),
          new google.maps.LatLng(	50.62925000	,	3.05725600	),
          new google.maps.LatLng(	50.62925000	,	3.05725600	),
          new google.maps.LatLng(	50.62925000	,	3.05725600	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	52.02271226	,	8.52985382	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	52.02271226	,	8.52985382	),
          new google.maps.LatLng(	52.02271226	,	8.52985382	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	25.28012000	,	110.28460000	),
          new google.maps.LatLng(	34.27356700	,	108.95484900	),
          new google.maps.LatLng(	39.47680000	,	75.98245000	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	52.02271226	,	8.52985382	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	53.67773100	,	6.99854900	),
          new google.maps.LatLng(	53.67773100	,	6.99854900	),
          new google.maps.LatLng(	53.67773100	,	6.99854900	),
          new google.maps.LatLng(	53.67773100	,	6.99854900	),
          new google.maps.LatLng(	53.67773100	,	6.99854900	),
          new google.maps.LatLng(	53.67773100	,	6.99854900	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	43.81910000	,	87.55552000	),
          new google.maps.LatLng(	40.55347000	,	72.80275000	),
          new google.maps.LatLng(	42.83315000	,	74.56838000	),
          new google.maps.LatLng(	42.83315000	,	74.56838000	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	42.83315000	,	74.56838000	),
          new google.maps.LatLng(	42.83315000	,	74.56838000	),
          new google.maps.LatLng(	42.83315000	,	74.56838000	),
          new google.maps.LatLng(	42.83315000	,	74.56838000	),
          new google.maps.LatLng(	41.83472000	,	71.95939500	),
          new google.maps.LatLng(	41.83472000	,	71.95939500	),
          new google.maps.LatLng(	41.87247200	,	71.97598900	),
          new google.maps.LatLng(	40.55347000	,	72.80275000	),
          new google.maps.LatLng(	42.83315000	,	74.56838000	),
          new google.maps.LatLng(	42.64553000	,	77.17615000	),
          new google.maps.LatLng(	42.64553000	,	77.17615000	),
          new google.maps.LatLng(	42.64553000	,	77.17615000	),
          new google.maps.LatLng(	42.64553000	,	77.17615000	),
          new google.maps.LatLng(	42.83315000	,	74.56838000	),
          new google.maps.LatLng(	37.77705000	,	75.22215000	),
          new google.maps.LatLng(	37.77705000	,	75.22215000	),
          new google.maps.LatLng(	37.77705000	,	75.22215000	),
          new google.maps.LatLng(	39.47680000	,	75.98245000	),
          new google.maps.LatLng(	43.81910000	,	87.55552000	),
          new google.maps.LatLng(	29.11487000	,	110.47613000	),
          new google.maps.LatLng(	24.31173000	,	109.39677000	),
          new google.maps.LatLng(	30.23400000	,	120.14955000	),
          new google.maps.LatLng(	34.27356700	,	108.95484900	),
          new google.maps.LatLng(	29.11487000	,	110.47613000	),
          new google.maps.LatLng(	25.28012000	,	110.28460000	),
          new google.maps.LatLng(	24.91700300	,	110.53250400	),
          new google.maps.LatLng(	30.53283000	,	114.31203000	),
          new google.maps.LatLng(	31.18856000	,	121.42926700	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	52.02271226	,	8.52985382	),
          new google.maps.LatLng(	53.54907943	,	9.98931885	),
          new google.maps.LatLng(	53.54907943	,	9.98931885	),
          new google.maps.LatLng(	53.54907943	,	9.98931885	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	53.38640000	,	-2.35244800	),
          new google.maps.LatLng(	53.38210000	,	-1.46787600	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	46.20632900	,	6.13981200	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	46.20632900	,	6.13981200	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	33.83445500	,	-117.91317000	),
          new google.maps.LatLng(	33.83445500	,	-117.91317000	),
          new google.maps.LatLng(	33.83445500	,	-117.91317000	),
          new google.maps.LatLng(	33.83445500	,	-117.91317000	),
          new google.maps.LatLng(	33.83445500	,	-117.91317000	),
          new google.maps.LatLng(	33.83445500	,	-117.91317000	),
          new google.maps.LatLng(	33.83445500	,	-117.91317000	),
          new google.maps.LatLng(	33.83445500	,	-117.91317000	),
          new google.maps.LatLng(	34.51168000	,	-120.50163000	),
          new google.maps.LatLng(	36.36147500	,	-121.85626100	),
          new google.maps.LatLng(	36.60023800	,	-121.89467600	),
          new google.maps.LatLng(	36.03133200	,	-118.41613800	),
          new google.maps.LatLng(	37.74653000	,	-119.58697000	),
          new google.maps.LatLng(	37.74653000	,	-119.58697000	),
          new google.maps.LatLng(	37.42200000	,	-122.08405700	),
          new google.maps.LatLng(	37.77492900	,	-122.41941600	),
          new google.maps.LatLng(	37.77492900	,	-122.41941600	),
          new google.maps.LatLng(	37.77492900	,	-122.41941600	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	31.18856000	,	121.42926700	),
          new google.maps.LatLng(	31.18856000	,	121.42926700	),
          new google.maps.LatLng(	31.18856000	,	121.42926700	),
          new google.maps.LatLng(	31.18856000	,	121.42926700	),
          new google.maps.LatLng(	31.18856000	,	121.42926700	),
          new google.maps.LatLng(	31.18856000	,	121.42926700	),
          new google.maps.LatLng(	31.18856000	,	121.42926700	),
          new google.maps.LatLng(	31.18856000	,	121.42926700	),
          new google.maps.LatLng(	32.03718000	,	118.76752000	),
          new google.maps.LatLng(	36.06710800	,	120.38260900	),
          new google.maps.LatLng(	36.06710800	,	120.38260900	),
          new google.maps.LatLng(	31.18856000	,	121.42926700	),
          new google.maps.LatLng(	31.18856000	,	121.42926700	),
          new google.maps.LatLng(	31.18856000	,	121.42926700	),
          new google.maps.LatLng(	31.18856000	,	121.42926700	),
          new google.maps.LatLng(	31.03234300	,	121.22520400	),
          new google.maps.LatLng(	31.18856000	,	121.42926700	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	50.94124900	,	6.95781100	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	51.25621300	,	7.15076400	),
          new google.maps.LatLng(	45.09109800	,	6.05922800	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	),
          new google.maps.LatLng(	52.51747439	,	13.40950012	)
        ];
      }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmTAYFwzl41BtNCEShQ2OzTbpHMSnxAL4&libraries=visualization&callback=initMap">
    </script>
  </body>
</html>
