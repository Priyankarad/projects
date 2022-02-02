var geocoder;
var geocoder1;
var map;
var map1;
var marker;
var marker1;
var infowindow = new google.maps.InfoWindow({size: new google.maps.Size(150,50)});
var infowindow1 = new google.maps.InfoWindow({size: new google.maps.Size(150,50)});
function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(25.276987, 55.296249);
    var mapOptions = {
        zoom: 8,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
    google.maps.event.addListener(map, 'click', function() {
        infowindow.close();
    });
}

function geocodePosition(pos) {
    geocoder.geocode({
        latLng: pos
    }, function(responses) {
        if (responses && responses.length > 0) {
            if(marker)
                marker.formatted_address = responses[0].formatted_address;
            if(marker1)
                marker1.formatted_address = responses[0].formatted_address;
            document.getElementById('searchLocationS').value = responses[0].formatted_address;
            document.getElementById('searchLocationS1').value = responses[0].formatted_address;
            var arrAddress = responses[0].address_components;
            $.each(arrAddress, function (i, address_component) {
                if (address_component.types[0] == "locality"){
                    document.getElementById('city').value = address_component.long_name;
                }
            });

        } else {
            marker.formatted_address = 'Cannot determine address at this location.';
            marker1.formatted_address = 'Cannot determine address at this location.';
        }
        if(marker)
            infowindow.setContent(marker.formatted_address+"<br>coordinates: "+marker.getPosition().toUrlValue(6));
        if(marker1)
            infowindow1.setContent(marker1.formatted_address+"<br>coordinates: "+marker1.getPosition().toUrlValue(6));
        if(marker)
            infowindow.open(map, marker);
        //infowindow1.open(map1, marker1);
    });
}
var dropdownAddr = 0;
var dropdownAddr1 = 0;
var addressSet = 0;
$(document).on('keyup','#searchLocationS1,#searchLocationS',function(){
    dropdownAddr = 0;
    dropdownAddr1 = 0;
});
function codeAddress() {
    addressSet = 1;
    var city = document.getElementById('searchLocationS').value;
    document.getElementById('searchLocationS1').value = document.getElementById('searchLocationS').value;
    if(dropdownAddr == 1){
        geocoder.geocode( { 'address': city}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                if (marker) {
                    marker.setMap(null);
                    if (infowindow) infowindow.close();
                }

                marker = new google.maps.Marker({
                    map: map,
                    draggable: true,
                    position: results[0].geometry.location
                });
                map.setZoom(15);

                $('#latitude').val(marker.getPosition().lat());
                $('#longitude').val(marker.getPosition().lng());

                map1.setCenter(results[0].geometry.location);
                marker1 = new google.maps.Marker({
                    map1: map1,
                    draggable: true,
                    position: results[0].geometry.location
                });
                marker1.setMap(map1);
                map1.setZoom(15);

                google.maps.event.addListener(marker, 'dragend', function() {
                    geocodePosition(marker.getPosition());
                });
                google.maps.event.addListener(marker1, 'dragend', function() {
                    geocodePosition(marker1.getPosition());
                });
                google.maps.event.addListener(marker, 'click', function() {
                    if (marker.formatted_address) {
                        infowindow.setContent(marker.formatted_address+"<br>coordinates: "+marker.getPosition().toUrlValue(6));
                    } else  {
                        infowindow.setContent(city+"<br>coordinates: "+marker.getPosition().toUrlValue(6));
                    }
                    infowindow.open(map, marker);
                });

                google.maps.event.trigger(marker, 'click');

                google.maps.event.addListener(marker1, 'click', function() {
                    if (marker1.formatted_address) {
                        infowindow1.setContent(marker1.formatted_address+"<br>coordinates: "+marker1.getPosition().toUrlValue(6));
                    } else  {
                        infowindow1.setContent(city+"<br>coordinates: "+marker1.getPosition().toUrlValue(6));
                    }
                    infowindow1.open(map1, marker1);
                });
            } 
        });
    }else{
        infowindow.close(map, marker);
        marker.setMap(null);
        $('#latitude').val('');
        $('#longitude').val('');
    }
}

function codeAddressDetail() {
    var city = document.getElementById('searchLocationS1').value;
    if(dropdownAddr1 == 1){
        geocoder.geocode( { 'address': city}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if(addressSet == 1){
                    if (marker1) {
                        marker1.setMap(null);
                        if (infowindow) infowindow.close();
                    }
                    map1.setZoom(15);
                    $('#latitude').val(marker1.getPosition().lat());
                    $('#longitude').val(marker1.getPosition().lng());
                    map1.setCenter(results[0].geometry.location);
                    marker1 = new google.maps.Marker({
                        map1: map1,
                        draggable: true,
                        position: results[0].geometry.location
                    });
                    marker1.setMap(map1);
                }else{
                    map1.setCenter(results[0].geometry.location);
                    if (marker1) {
                        marker1.setMap(null);
                        if (infowindow1) infowindow1.close();
                    }

                    marker1 = new google.maps.Marker({
                        map1: map1,
                        draggable: true,
                        position: results[0].geometry.location
                    });
                    map1.setZoom(15);
                    $('#latitude').val(marker1.getPosition().lat());
                    $('#longitude').val(marker1.getPosition().lng());
                    marker1.setMap(map1);
                }
                google.maps.event.addListener(marker1, 'dragend', function() {
                    geocodePosition(marker1.getPosition());
                });
               // google.maps.event.addListener(marker1, 'click', function() {
                    if (marker1.formatted_address) {
                        infowindow1.setContent(marker1.formatted_address+"<br>coordinates: "+marker1.getPosition().toUrlValue(6));
                    } else  {
                        infowindow1.setContent(city+"<br>coordinates: "+marker1.getPosition().toUrlValue(6));
                    }
                    infowindow1.open(map1, marker1);
               // });
            } 
        });
    }else{
        infowindow1.close(map1, marker1);
        marker1.setMap(null);
        $('#latitude').val('');
        $('#longitude').val('');
    }
}


function markerActive(){
    google.maps.event.trigger(marker1, 'click');
}

/*For autocomplete address*/
initAutocomplete();
function initAutocomplete() {
   // new google.maps.places.Autocomplete(
   //        (document.getElementById('searchLocationS')),
   //        {types: ['geocode'],componentRestrictions: {country: "ae"}}
   // );
   // new google.maps.places.Autocomplete(
   //        (document.getElementById('searchLocationS1')),
   //        {types: ['geocode'],componentRestrictions: {country: "ae"}}
   // );
}



$(document).ready(function () {
    $location_input = $("#searchLocationS");
    var options = {
       // types: ['geocode'],
        componentRestrictions: {
            country: 'ae'
        }
    };
    autocomplete = new google.maps.places.Autocomplete($location_input.get(0), options);    
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        //codeAddress();
        dropdownAddr = 1;
        $('.codeAddress').trigger('click');
    });

    $location_input1 = $("#searchLocationS1");
    var options1 = {
        //types: ['geocode'],
        componentRestrictions: {
            country: 'ae'
        }
    };
    autocomplete1 = new google.maps.places.Autocomplete($location_input1.get(0), options1);    
    google.maps.event.addListener(autocomplete1, 'place_changed', function() {
        //codeAddressDetail();
        dropdownAddr1 = 1;
        $('.codeAddressDetail').trigger('click');
    });
});


/*For initializing the second map*/
function initialize_1() {
    geocoder1 = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(25.276987, 55.296249);
    var mapOptions = {
        zoom: 8,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map1 = new google.maps.Map(document.getElementById('map_canvas_1'), mapOptions);
}