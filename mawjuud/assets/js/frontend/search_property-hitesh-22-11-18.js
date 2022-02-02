var sort = 'desc';
var type = 'grid';
/*For autocomplete address*/
$('.loader_outer').hide();
initAutocomplete();
function initAutocomplete() {
    new google.maps.places.Autocomplete(
        (document.getElementById('area')),
        {types: ['geocode'],componentRestrictions: {country: "ae"}}
        );
}
/*For sorting the property order*/
$('.short_Xb').click(function(){
    if(sort == 'asc'){
        sort = 'desc';
    }else {
        sort = 'asc';
    }
    searchProperty();
});

/*For viewing property*/
$('.view').click(function(){
    type = $(this).data('type');
    searchProperty();
});

/*For saving the search query*/
$('.PsaveBtnS').click(function(){
    var area = $('#area').val();
    var price = $('#price').val();
    var beds = $('#beds').val();
    var category = $('#category').val();
    var baths = $('#baths').val();
    var min_sqft = $('#min_sqft').val();
    var max_sqft = $('#max_sqft').val();
    var min_price = $('#min_price').val();
    var max_price = $('#max_price').val();
    var days_zillow = $('#days_zillow').val();
    var keywords = $('#keywords').val();
    $.ajax({
        url: baseUrl+ 'property/savePropertySearch',
        type: 'post',
        dataType: 'json',
        data: {area:area,price:price,beds:beds,category:category,baths:baths,min_sqft:min_sqft,max_sqft:max_sqft,min_price:min_price,max_price:max_price,days_zillow:days_zillow,keywords:keywords,sort:sort,type:type},
        success: function (data) {
            if(data.user_login!='' && (data.user_login == 1)){
                $('#loginmodal').modal('open');
            }
            if(data.status == 1){
                Ply.dialog("alert",'Search saved successfully');
            }
        },
    });
});

/*For fetching property list based on filters*/
function searchProperty(){
    var area = $('#area').val();
    var price = $('#price').val();
    var beds = $('#beds').val();
    var category = $('#category').val();
    var baths = $('#baths').val();
    var min_sqft = $('#min_sqft').val();
    var max_sqft = $('#max_sqft').val();
    var min_price = $('#min_price').val();
    var max_price = $('#max_price').val();
    var days_zillow = $('#days_zillow').val();
    var keywords = $('#keywords').val();
    if(min_sqft!='' && max_sqft!=''){
        if(Number(min_sqft) > Number(max_sqft)){
            Ply.dialog("alert",'Min Sqft should be less than Max Sqft');
            return false;
        }
    }
    if(min_price!='' && max_price!=''){
        if(Number(min_price) > Number(max_price)){
            Ply.dialog("alert",'Min Price should be less than Max Price');
            return false;
        }
    }
    $('body').append(loader_ajax);
    $('.loader_outer').show();
    $.ajax({
        url: baseUrl+ 'property/searchPropertyFilter',
        type: 'post',
        dataType: 'json',
        data: {area:area,price:price,beds:beds,category:category,baths:baths,min_sqft:min_sqft,max_sqft:max_sqft,min_price:min_price,max_price:max_price,days_zillow:days_zillow,keywords:keywords,sort:sort,type:type},
        success: function (data) {
            $('.loader_outer').hide();
            $('.property_searchI').html('');
            $('.property_searchI').html(data.html);
            var locations = JSON.parse(data.location);
            var map = new google.maps.Map(document.getElementById('search_map'), {
                zoom: 6,
                center: new google.maps.LatLng(25.276987, 55.296249),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            var infowindow = new google.maps.InfoWindow();
            var marker, i;
            for (i = 0; i < locations.length; i++) {  
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map
                });
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infowindow.setContent(locations[i][0]+"<br>coordinates: "+locations[i][1]+" , "+locations[i][2]);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            }
        },
    });
}

/*for making property favourite*/
function favouriteProperty(property_id,evt){
    $(evt).removeClass('fillHearts');
    $('body').append(loader_ajax);
    $('.loader_outer').show();
    $.ajax({
        url: baseUrl+ 'property/favouriteProperty',
        type: 'post',
        dataType: 'json',
        data: {property_id:property_id},
        success: function (data) {
            $('.loader_outer').hide();
            if(data.user_login!='' && (data.user_login == 1)){
                $('#loginmodal').modal('open');
            }
            if(data.status == 1){
                $(evt).addClass('fillHearts');
                Ply.dialog("alert",'Property added to your favourite list successfully');
            }
            if(data.status == 2){
                $(evt).removeClass('fillHearts');
                Ply.dialog("alert",'Property removed from your favourite list');
            }
        },
    });
}


function drawFreeHand(){
    poly=new google.maps.Polyline({map:map,clickable:false});
    var move=google.maps.event.addListener(map,'mousemove',function(e){
        poly.getPath().push(e.latLng);
    });
    google.maps.event.addListenerOnce(map,'mouseup',function(e){
        google.maps.event.removeListener(move);
        var path=poly.getPath();
        poly.setMap(null);
        var theArrayofLatLng = path.j;
        var ArrayforPolygontoUse= GDouglasPeucker(theArrayofLatLng,50); 
        console.log("ArrayforPolygontoUse", ArrayforPolygontoUse);        
        var polyOptions = {
            map: map,
            fillColor: '#0099FF',
            fillOpacity: 0.7,
            strokeColor: '#AA2143',
            strokeWeight: 2,
            clickable: false,
            zIndex: 1,
            path:ArrayforPolygontoUse,
            editable: false
        }
        poly=new google.maps.Polygon(polyOptions);
        google.maps.event.clearListeners(map.getDiv(), 'mousedown');
        enable()
    });
}


function enable(){
    map.setOptions({
        draggable: true, 
        zoomControl: true, 
        scrollwheel: true, 
        disableDoubleClickZoom: true
    });
}

$(document).ready(function(){
    $('.tooltipped').tooltip();
});

$('.MpicView').on('click',function(){
   $('.property_searchI').hide();
   $('.photoclktopH').show();
});

