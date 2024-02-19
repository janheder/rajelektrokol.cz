/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Google Map
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the General Public License (GPL 2.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/GPL-2.0
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the module to newer
 * versions in the future.
 *
 *  @author    Bonpresta
 *  @copyright 2015-2020 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*/

$(window).load(function(){
    if (typeof(status_map) != 'undefined') {
        if (!status_map) {
            initScript('//maps.googleapis.com/maps/api/js?key='+BON_GOOGLE_KEY+'&sensor=true&callback=initMap');
        } else {
            initMap();
        }
    }
});

function initScript(url, callback){
    var script = document.createElement('script');

    if (callback) {
        script.onload = callback;
    }

    script.async = true;
    script.type = 'text/javascript';
    script.src = url;
    document.body.appendChild(script);
}

function initMap(){
    if (typeof(defaultLat) == 'undefined' && typeof(defaultLong) == 'undefined') {
        return;
    }

    if ($('#googlemap').length < 1) {
        return;
    }

    googlemap = new google.maps.Map(document.getElementById('googlemap'), {
        center: new google.maps.LatLng(parseFloat(defaultLat), parseFloat(defaultLong)),
        zoom: BON_GOOGLE_ZOOM,
        mapTypeId: BON_GOOGLE_TYPE,
        scrollwheel: BON_GOOGLE_SCROLL,
        mapTypeControl: BON_GOOGLE_TYPE_CONTROL,
        streetViewControl: BON_GOOGLE_STREET_VIEW,
        draggable: true,
        panControl: true,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
        }
    });

    infoWindow = new google.maps.InfoWindow();
    initMarkers();
}

function initMarkers(){
    Array.prototype.mapWithIndex = function(fn){
        var arr = [];
        if (typeof fn === 'function') {
            for (var i=0; i < this.length; i++) {
                arr.push(fn.apply(null, [this[i], i]));
            }
            return arr;
        } else {
            return this;
        }
    };

    function inherits(base, extension){
        if (!extension) {
            extension = {};
        }

        for ( var property in base ) {
            extension[property] = base[property];
        }

        return extension ;
    };

    if (typeof(json_encode_store) == 'undefined' && typeof(json_encode_info) == 'undefined') {
        json_encode_store = json_encode_store.sort(function(a,b){return a.id-b.id_store});
        json_encode_info = json_encode_info.sort(function(a,b){return a.id-b.id_store});
    }

    var array = json_encode_store.mapWithIndex(function(e,i){
        return inherits(e,json_encode_info[i])
    });

    var infowindow = new google.maps.InfoWindow();
    var marker, i, y;

    for (i = 0; i < array.length; i++) {
        var name = array[i]['name'],
            icon = array[i]['image'],
            latlng = new google.maps.LatLng(
                parseFloat(array[i]['latitude']),
                parseFloat(array[i]['longitude'])
            );

        if (BON_GOOGLE_ANIMATION == true) {
            animation = google.maps.Animation.BOUNCE;
        } else {
            animation = false;
        }

        marker = new google.maps.Marker({
            map: googlemap,
            position: latlng,
            icon: icon,
            title: name,
            animation: animation
        });

        var google_ps_version_var = parseFloat(google_ps_version).toFixed(1);
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            if (BON_GOOGLE_POPUP == true) {
                return function () {
                 
                        var contents = '<div class="googlemap-popup">' +
                            '<div class="map_address clearfix">'+((!!array[i]['id_image']) ? '<img class="bongooglemap-logo" src="'+img_store_dir+parseInt(array[i]['id'])+'.jpg" alt="" />' : '')+'' +
                            '<div class="description"><h5>'+array[i]['name']+'</h5><p>'+array[i]['address1']+'</p><p>'+array[i]['content']+'</p></div>' +
                            '</div>';

                    infowindow.setContent(contents);
                    infowindow.open(googlemap, marker);
                }
            }
        })(marker, i));

        markers.push(marker);
    }

    var zoom = googlemap.getZoom();

    if (zoom > BON_GOOGLE_ZOOM) {
        zoom = BON_GOOGLE_ZOOM;
    }

    googlemap.setZoom(zoom);
}