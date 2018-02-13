/*jQuery(document).ready(function(a){});*/

(function ($) {

  $(function() {

    function initMap() {

      var article = ( typeof locationews_map_init.article === 'object' ? locationews_map_init.article : null );

      if ( typeof article === 'object' ) {

        var mapCenter = {
          lat: parseFloat(article.latitude),
          lng: parseFloat(article.longitude)
        };

        var articles = ( typeof locationews_map_init.articles !== 'undefined' ? locationews_map_init.articles : null );
        var mapZoom  = ( typeof locationews_map_init.zoom !== 'undefined' ? parseInt(locationews_map_init.zoom) : 11 );

        // 34x48
        var icon_active = {
          url: "http://locationews.com/info/wp-content/plugins/locationews/admin/img/locationewsmerkkinormaali.png",
        }
        var icon_default = {
          url: "http://locationews.com/info/wp-content/plugins/locationews/admin/img/locationewsmerkkinormaali.png",
          scaledSize: new google.maps.Size(23, 32), // scaled size
          origin: new google.maps.Point(0,0), // origin
          anchor: new google.maps.Point(0, 0) // anchor
        }

        var markers = articles.map(function (ar, i) {
          return new google.maps.Marker({
            position: new google.maps.LatLng(parseFloat(ar.latitude), parseFloat(ar.longitude)),
            title: ar.title,
            url: ar.url,
            icon: icon_default
          });

        })

        markers.push(
          new google.maps.Marker({
            position: new google.maps.LatLng(parseFloat(article.latitude), parseFloat(article.longitude)),
            title: article.title,
            url: article.url,
            icon: icon_active
          })
        )

        var locationews_map_options = {
          zoom                   : mapZoom,
          center                 : mapCenter,
          disableDoubleClickZoom : true,
          mapTypeId              : google.maps.MapTypeId.ROADMAP,
          disableDefaultUI       : true,
          zoomControl            : true,
          gestureHandling        : 'greedy',
          streetViewControl      : false,
          styles: [
            { "elementType": "geometry", "stylers": [{ "color": "#f5f5f5" }] },
            { "elementType": "labels.icon", "stylers": [{ "visibility": "off" }] },
            { "elementType": "labels.text.fill", "stylers": [{ "color": "#616161" }] },
            { "elementType": "labels.text.stroke", "stylers": [{ "color": "#f5f5f5 " }] },
            { "featureType": "administrative.land_parcel", "elementType": "labels.text.fill", "stylers": [{ "color": "#bdbdbd" }] },
            { "featureType": "poi", "elementType": "geometry", "stylers": [{ "color": "#eeeeee" }] },
            { "featureType": "poi", "elementType": "labels.text.fill", "stylers": [{ "color": "#757575" }] },
            { "featureType": "poi.park", "elementType": "geometry", "stylers": [{ "color": "#e5e5e5" }] },
            { "featureType": "poi.park", "elementType": "labels.text.fill", "stylers": [{ "color": "#9e9e9e" }] },
            { "featureType": "road", "elementType": "geometry", "stylers": [{ "color": "#e05a5a" }] },
            { "featureType": "road.arterial", "elementType": "labels.text.fill", "stylers": [{ "color": "#757575" }] },
            { "featureType": "road.highway", "elementType": "geometry", "stylers": [{ "color": "#e05a5a" }, { "saturation": -40 }, { "lightness": 30 }] },
            { "featureType": "road.highway", "elementType": "labels.text.fill", "stylers": [{ "color": "#616161" }]},
            { "featureType": "road.local", "elementType": "labels.text.fill", "stylers": [{ "color": "#9e9e9e" }]},
            { "featureType": "transit.line", "elementType": "geometry", "stylers": [{ "color": "#e5e5e5" }]},
            { "featureType": "transit.station", "elementType": "geometry", "stylers": [{ "color": "#eeeeee" }]},
            { "featureType": "water", "elementType": "geometry", "stylers": [{ "color": "#c9d9d9" }]},
            { "featureType": "water", "elementType": "labels.text.fill", "stylers": [{ "color": "#9e9e9e" }]}
          ]
        };

        // Create a map object and specify the DOM element for display.
        var map = new google.maps.Map(document.getElementById('locationews-google-map'),
          locationews_map_options
        );

        // Add a marker clusterer to manage the markers.
        var markerCluster = new MarkerClusterer(map, markers,
          {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
      }
    }
    initMap();
  });
})(jQuery);