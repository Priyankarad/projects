var sort = 'new';
var type = 'grid';
var polys = [];
var all_overlays = [];
var latlng = ''; 
var allProperties = [];
var times = '';
var transportLength;
var schoolLength;
var propertyData;
var transportData;
var schoolData;
var propertyID = [];
var photoView = 0;
var gridView = 0;
var checkMapType = 0;
var transports = [];
var schools = [];
var transportSet = 0;
var schoolSet = 0;
var schoolID = [];
var transportID = [];
$.ajax({
    url: baseUrl+ 'property/getAllProperties',
    type: 'post',
    dataType: 'json',
    success: function (data) {
        /*for all properties*/
        times = data['property'].length;
        propertyData = data['property'];
        /*for all transports*/
        transportLength = data['transport'].length;
        transportData = data['transport'];
        /*for all schools*/
        schoolLength = data['school'].length;
        schoolData = data['school'];
    },
});
/*For autocomplete address*/
$('.loader_outer').hide();
initAutocomplete();
function initAutocomplete() {
    new google.maps.places.Autocomplete(
        (document.getElementById('area')),
        {componentRestrictions: {country: "ae"}}
        );
}


/*=========new=============*/
//multiple-select-dropdown
$(document).ready(function(){
    $('body').find('.mw-typeselects ul li:nth-child(6)').before('<li class="hideMoreLi"><button class="clickmoreshow">More <span class="ti-angle-down"></span></button></li>');


    $('body').on('click', '.clickmoreshow', function(){
        $(this).parents('ul').find('li').show();
        $('.hideMoreLi').remove();
        $(this).parents('ul').css('height', 'auto');
    });

    var menu5 = $('.mw-typeselects ul');
    $(document).mouseup(function (e) {
        if ((!menu5.is(e.target)) && (menu5.has(e.target).length === 0))
        {
            $('body').find('.mw-typeselects ul li:nth-child(6)').before('<li class="hideMoreLi"><button class="clickmoreshow">More <span class="ti-angle-down"></span></button></li>');
            $('.mw-typeselects ul li:not(:nth-child(1), :nth-child(2), :nth-child(3), :nth-child(4), :nth-child(5), :nth-child(6))').hide();
            $('body').find('.mw-typeselects ul').css('height', 'auto');
        }
    });


    var moreapply = $('.moremanyopt');
    $(document).mouseup(function (e) {
        if (!moreapply.is(e.target) 
            && moreapply.has(e.target).length === 0) 
        {
            $('.MoreSmBox').removeClass('openmoreDiv');
        }
    });

    $(document).on('click', '.sameSizeBli', function(){
        $(this).children('.Sort-subbox').toggleClass('openmoreDiv');  
    });

    /*=========new=============*/
    /*For sorting options*/
    $('.sortBy').click(function(){
        sort = $(this).data('sort');
        searchProperty();
    });

    /*==============draw button================*/
    // $('body').on('click', '.map-controller-icon button', function(){
    //    // $('.map-controller-icon button').removeClass('activebg');
    //     $(this).addClass('activebg');
    // });


    /*==========min-max==============*/
    $('body').on('click', '.minvalues', function(){
        $('#minpriceappend').addClass('openmaxminlst');
        $('#maxpriceappend').removeClass('openmaxminlst');
    });
    $('body').on('click', '.maxvalues', function(){
        $('#minpriceappend').removeClass('openmaxminlst');
        $('#maxpriceappend').addClass('openmaxminlst');
    });
    $('body').on('click', 'ul#minpriceappend li a', function(){
        $('#minpriceappend').removeClass('openmaxminlst');
        $('#maxpriceappend').addClass('openmaxminlst');
        var minvalget = $(this).text();
        $('.minvalues').val(minvalget);
        priceChange();
    });
    $('body').on('click', '#maxpriceappend li a', function(){
        $('.maxminp-submenu').removeClass('openmoreDiv');
        $('#minpriceappend').addClass('openmaxminlst');
        $('#maxpriceappend').removeClass('openmaxminlst');
        var maxvalget = $(this).text();
        maxvalget = maxvalget.replace('AED ','');
        $('.maxvalues').val(maxvalget);
        searchProperty();
    });
    $('body').on('click', '.maxminp-mw p', function(){
        $('.maxminp-submenu').toggleClass('openmoreDiv');  
    });

    var maxminp_mw = $('.maxminp-mw');
    $(document).mouseup(function (e) {
        if (!maxminp_mw.is(e.target) 
            && maxminp_mw.has(e.target).length === 0) 
        {
            $('.maxminp-submenu').removeClass('openmoreDiv');
        }
    });
    /*==========min-max==============*/

    var sortDiv = $('.sortDiv');
    $(document).mouseup(function (e) {
        if (!sortDiv.is(e.target)
            && sortDiv.has(e.target).length === 0)
        {
            $('.Sort-subbox').removeClass('openmoreDiv');
        }
    });

    var viewT = 1;

    /*For viewing property*/
    $(document).on('click','.view',function(){
        $('#properties .box_div.property_hover').removeClass('fulltdgrid');
        $('.map-controller-icon button').removeClass('activebg');
        type = $(this).data('type');
        viewT = 2;
        if(photoView == 1){
            $('.photoclktopH .hover_property').addClass('photosViews');
        }
        if(checkMapType == 1){
            $('.M-maphide').trigger('click');
        }else if(checkMapType == 2){
            $('.M-mapmore').trigger('click');
        }
        for (var i = 0; i < nearbyMarkers.length; i++) {
            nearbyMarkers[i].setMap(null);
        }
        nearbyMarkers = [];
        //$('.nearby').removeClass('activebg');
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
        var listing = $('#listing').val();
        $.ajax({
            url: baseUrl+ 'property/savePropertySearch',
            type: 'post',
            dataType: 'json',
            data: {area:area,price:price,beds:beds,category:category,baths:baths,min_sqft:min_sqft,max_sqft:max_sqft,min_price:min_price,max_price:max_price,days_zillow:days_zillow,keywords:keywords,sort:sort,type:type,listing:listing},
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
});
/*For fetching property list based on filters*/
var markers = [];
var nearbyMarkers = [];
var hoverMarker = [];
var map = new google.maps.Map(document.getElementById('search_map'), {
    zoom: 9,
    zoomControl:true,
    center: new google.maps.LatLng(25.276987, 55.296249),
    mapTypeId: google.maps.MapTypeId.ROADMAP
});
var infowindow = new google.maps.InfoWindow();
var marker, i;

google.maps.event.addDomListener(window, 'load', initialize);
function disable(){
    map.setOptions({
        draggable: false, 
        zoomControl: false, 
        scrollwheel: false, 
        disableDoubleClickZoom: false
    });
}
function initialize() {
    $(".ti-slice").click(function(e) {
        e.preventDefault();
        disable();
        google.maps.event.addDomListener(map.getDiv(),'mousedown',function(e){
            drawFreeHand();
        });
    });
}
var markerLength;
function searchProperty(poly=false){
    $('#properties').DataTable().destroy();
    $('#propertiesPhotoView').DataTable().destroy();
    $('#tableView').DataTable().destroy();
    var polygon = 0;
    if(poly == 'poly'){
        polygon = 1;
    }else if(poly == 'circle'){
        polygon = 2;
    }
    else if(poly == 'nearby'){
        polygon = 3;
    }else{
        latlng = '';
        propertyID = [];
        // transportID = [];
        // schoolID = [];
    }
    var area = $('#area').val();
    var listing = $('#listing').val();
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
    var tableName='properties';
    if(type == 'grid'){
        $('.photoclktopH').hide();
        $('.tableView').hide();
        $('.property_searchI').show();
    }
    else if(type == 'photo'){
        tableName = 'propertiesPhotoView';
        $('.property_searchI').hide();
        $('.tableView').hide();
        $('.photoclktopH').show();
    }else if(type == 'table'){
        tableName = 'tableView';
        $('.property_searchI').hide();
        $('.photoclktopH').hide();
        $('.tableView').show();
    }

    if(type != 'table'){
        $('#'+tableName).DataTable({
            processing: true,
            lengthMenu: [48],
            serverSide: true,
            ordering: false,
            ajax:{
                url: baseUrl+'property/getPropertyDetails',
                dataType: "json",
                type: "POST",
                data: {area:area,beds:beds,category:category,baths:baths,min_sqft:min_sqft,max_sqft:max_sqft,min_price:min_price,max_price:max_price,days_zillow:days_zillow,keywords:keywords,sort:sort,type:type,listing:listing,latlng:latlng,propertyID:propertyID,polygon:polygon,transportID:transportID,schoolID:schoolID},
            },
            drawCallback: function(settings){
                if(type == 'grid'){
                    $('td').addClass('box_div property_hover');
                }
                else if(type == 'photo'){
                    $('td').addClass('col s12 box_div property_hover');
                }
                var api = this.api();
                fetchMapData(api,polygon);
            },
            columns: [
            { "data": "id" },
            { "data": "title" },
            ]   
        });
    }else{
        var tableHeader = '<div class="row"><div class="col-md-12"><table class="table table-bordered responsive-table searchshortingTbM" id="tableView"><thead><th></th><th>Type</th><th>Title</th><th>Address</th><th id="Mshortprc">Price(AED) <img src="assets/images/map-icon/shorting-icon.png" alt="images" class="miniconM"/></th><th id="Mshortbed">Bed(s) <img src="assets/images/map-icon/shorting-icon.png" alt="images" class="miniconM"/></th><th id="Mshortbath">Bath(s) <img src="assets/images/map-icon/shorting-icon.png" alt="images" class="miniconM"/></th><th id="Mshortsqft">Size (Sq. ft.) <img src="assets/images/map-icon/shorting-icon.png" alt="images" class="miniconM"/></th><th>Favorite</th><th>Compare</th><th>Hide</th></thead></table></div></div>';
        $('.tableView').html(tableHeader);
        $('#'+tableName).DataTable({
            processing: true,
            lengthMenu: [48],
            serverSide: true,
            ordering: false,
            ajax:{
                url: baseUrl+'property/getPropertyDetails',
                dataType: "json",
                type: "POST",
                data: {area:area,beds:beds,category:category,baths:baths,min_sqft:min_sqft,max_sqft:max_sqft,min_price:min_price,max_price:max_price,days_zillow:days_zillow,keywords:keywords,sort:sort,type:type,listing:listing,latlng:latlng,propertyID:propertyID,polygon:polygon,transportID:transportID,schoolID:schoolID},
            },
            drawCallback: function(settings){
                $('tr').addClass('box_div');
                var api = this.api();
                fetchMapData(api,polygon);
            },
            columns: [
            { "data": "id" },
            { "data": "type" },
            { "data": "title" },
            { "data": "address" },
            { "data": "price" },
            { "data": "bed" },
            { "data": "bath" },
            { "data": "size" },
            { "data": "favorite" },
            { "data": "add_to_compare" },
            { "data": "hide" },
            ]   
        });
    }
    $('select').formSelect();
}

function fetchMapData(api,polygon){
    setMapOnAll(null,polygon);
    if((api.ajax.json()!='undefined') && (api.ajax.json().location) && (api.ajax.json().location!='')){
        var locations = JSON.parse(api.ajax.json().location);
        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map
            });
            google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
                return function() {
                    var html = '<div class="col s12 box_div box_map"><div class="hover_property"><div class="box_img1"><a href="'+baseUrl+'single_property?id='+locations[i][15]+'" target="_blank" class="waves-effect waves-light"><img src="'+locations[i][4]+'" alt="images"><span class="ForSale '+locations[i][5]+'">For '+locations[i][6]+'</span><div class="box_cnts"><h4>'+locations[i][10]+'</h4><h6><span class="ti-location-pin"></span>'+locations[i][11]+'</h6><h5><span class="PriceSp">'+locations[i][12]+'</span></h5></div></a><div class="MtotalPicsList"><i>'+locations[i][13]+'</i> <span class="ti-camera"></span></div></div></div>      <div class="mapbox-btmsec"><h4><a href="">'+locations[i][16]+'</a></h4> <div><i>'+locations[i][9]+'</i> <span>Sq. ft</span> </div><ul><li><span>'+locations[i][8]+'</span><strong> Bed </strong> </li><li><span>'+locations[i][7]+'</span><strong>  Bath  </strong> </li></ul><h5><span class="PriceSp">'+locations[i][12]+'</span></h5></div>  </div>';
                    infowindow.setContent(html);
                    infowindow.open(map, marker);
                }
            })(marker, i));
            markers.push(marker);
            hoverMarker[locations[i][3]] = marker;
            google.maps.event.addListener(map, 'click', (function() {
                infowindow.close(map, marker);
            }));
            google.maps.event.addListener(marker, 'mouseout', (function(){
                infowindow.close(map, marker);
            }));
            markerLength = markers.length;
        }
        viewT = 1;
        $('.hover_property').hover(function(){
            var property_id = $(this).data('prop_id');
            google.maps.event.trigger(hoverMarker[property_id],'mouseover');
        });
    }else{
        setMapOnAll(null,1);
    }
    if(photoView == 1){
        $('.photoclktopH .hover_property').addClass('photosViews');
    }
    if((type=='grid') && (gridView == 1)){
        $('#properties .box_div.property_hover').addClass('fulltdgrid');
    }
    $(".phone").intlTelInput();
    $('.tooltipped').tooltip();


    if((api.ajax.json()!='undefined') && (api.ajax.json().schoolPointer) && (api.ajax.json().schoolPointer!='')){
        var schoolsP = JSON.parse(api.ajax.json().schoolPointer);
        if(schoolSet == 1  && (schoolsP)){
            for (i = 0; i < schoolsP.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(schoolsP[i].latitude,schoolsP[i].longitude),
                    map: map,
                    icon: 'https://pixlritllc.com/mawjuud/assets/images/school-newicon.png'
                });
                google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
                    return function() {
                        var html = '<div class="col s12 transportMapDiv"><div><h6>'+schoolsP[i].name+'</h6>'+schoolsP[i].star_ratings+'</div></div>';
                        infowindow.setContent(html);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
                schools.push(marker);
                google.maps.event.addListener(marker, 'mouseout', (function(){
                    infowindow.close(map, marker);
                }));
            }
        }
    }

    if((api.ajax.json()!='undefined') && (api.ajax.json().transportPointer) && (api.ajax.json().transportPointer!='')){
        var transportsP = JSON.parse(api.ajax.json().transportPointer);
        if((transportSet == 1) && (transportsP)){
            for (i = 0; i < transportsP.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(transportsP[i].latitude,transportsP[i].longitude),
                    map: map,
                    icon: 'https://pixlritllc.com/mawjuud/assets/images/transport-newicon.png'
                });
                google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
                    return function() {
                        var html = '<div class="col s12 transportMapDiv"><div><h6>'+transportsP[i].name+'</h6>'+transportsP[i].star_ratings+'</div></div>';
                        infowindow.setContent(html);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
                transports.push(marker);
                google.maps.event.addListener(marker, 'mouseout', (function(){
                    infowindow.close(map, marker);
                }));
            }
        }
    }
}

$(document).on('click','.M-maphide', function(){
    $('#properties .box_div.property_hover').removeClass('fulltdgrid');
    gridView = 0;
    checkMapType = 1;
    $('#ascrail2000').hide();
    $('.M-mapfixedsec').hide().removeClass('s9').addClass('s5');
    $('.M-listedfixedsec').addClass('s12');
    $('.row.box_div.property_hover > div').addClass('s6').removeClass('s12');
    $('.row.box_div.property_hover').addClass('rowdevide');
    $('.property_searchI .row .col.box_div.property_hover').addClass('s4').removeClass('s6 s12');
    if(type == 'grid'){
        $('#properties').addClass('increaseTr');
    }
    if(type == 'photo'){
        $('#propertiesPhotoView').addClass('increaseTr');
        $('.photoclktopH .hover_property').removeClass('photosViews');
    }
    photoView = 0;
});

$(document).on('click','.M-mapless', function(){
    gridView = 0;
    checkMapType = 0;
    $('#ascrail2000').hide();
    $('.row.box_div.property_hover').removeClass('rowdevide');
    $('.M-mapfixedsec').show().removeClass('s9').addClass('s5');
    $('.row.box_div.property_hover > div').addClass('s6').removeClass('s12');
    $('.M-listedfixedsec').addClass('s7').removeClass('s12 s3');
    $('.property_searchI .row .col.box_div.property_hover').addClass('s6').removeClass('s4 s12');
    if(type=='grid'){
        $('.m-grids').trigger('click');
    }
    if(type=='photo'){
        $('.m-photo').trigger('click');
    }
    $('#properties').removeClass('increaseTr');
    $('#propertiesPhotoView').removeClass('increaseTr');
    photoView = 0;
})


$(document).on('click','.M-mapmore', function(){
    checkMapType = 2;
    $('#ascrail2000').hide();
    $('.M-mapfixedsec').addClass('s9').removeClass('s5').show();
    $('.row.box_div.property_hover').removeClass('rowdevide');
    $('.row.box_div.property_hover > div').addClass('s12').removeClass('s6');
    $('.M-listedfixedsec').removeClass('s7 s12').addClass('s3');
    $('.property_searchI .row .col.box_div.property_hover').addClass('s12').removeClass('s6');
    if(type=='grid'){
        gridView = 1;
        $('#properties .box_div.property_hover').addClass('fulltdgrid');
    }
    if(type=='photo'){
        photoView = 1;
        $('.photoclktopH .hover_property').addClass('photosViews');
    }else{
        photoView = 0;
    }
    $('#properties').removeClass('increaseTr');
    $('#propertiesPhotoView').removeClass('increaseTr');
});

function setMapOnAll(map,polygon) {
//for removing all the markers
for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
}
markers = [];

// /*For removing the nearby locations*/
// for (var i = 0; i < nearbyMarkers.length; i++) {
//     nearbyMarkers[i].setMap(null);
// }
// nearbyMarkers = [];

//for removing all the schools 
for (var i = 0; i < schools.length; i++) {
    schools[i].setMap(map);
}
schools = [];
//for removing all the transports 
for (var i = 0; i < transports.length; i++) {
    transports[i].setMap(map);
}
transports = [];

//for removing all the polylines
if(polygon == 0 || polygon == 2 || polygon == 3){
    for(var i=0;i<polys.length;i++){
        polys[i].setMap(map);
    }
    polys = [];
}

//for removing all the circles
if(polygon == 0 || polygon == 1 || polygon == 3){
    for (var i = 0; i < all_overlays.length; i++) {
        all_overlays[i].overlay.setMap(null);
    }
    all_overlays = [];
}
propertyID = [];
// schoolID = [];
// transportID = [];
}
searchProperty();
/*To clear the selection applied on map*/
$('.clear').click(function(){
    $('.map-controller-icon button').removeClass('activebg');
    $(this).addClass('activebg');
    setMapOnAll(null,1);
    setMapOnAll(null,2);
    searchProperty();
});

/*for making property favourite*/
function favouriteProperty(property_id,evt){
    $(evt).removeClass('fillHearts');
//$('body').append(loader_ajax);
//$('.loader_outer').show();
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
            $('.ti-heart'+property_id).addClass('fillHearts');
        }
        if(data.status == 2){
            $(evt).removeClass('fillHearts');
            $('.ti-heart'+property_id).removeClass('fillHearts');
        }
        if(data.favouriteCount!=0){
            $('#saved_properties').html('('+data.favouriteCount+')');
        }
    },
});
}

/*for adding property to compare list*/
function compareProperty(property_id,evt){
    $(evt).removeClass('fillHearts');
    $('body').append(loader_ajax);
    $('.loader_outer').show();
    $.ajax({
        url: baseUrl+ 'property/compareProperty',
        type: 'post',
        dataType: 'json',
        data: {property_id:property_id},
        success: function (data) {
            $('.loader_outer').hide();
            if(data.user_login!='' && (data.user_login == 1)){
                $('#loginmodal').modal('open');
            }
            if(data.status == 1){
                $(evt).css('color','#ff8787');
            }
            if(data.status == 2){
                $(evt).css('color','#505050');
            }
        },
    });
}

/*For drawing a polyline*/
function drawFreeHand(){
    latlng = '';
    propertyID = [];
    schoolID = [];
    transportID = [];
    //for clearing the old polylines
    for(var i=0;i<polys.length;i++){
        polys[i].setMap(null);
    }
    //for clearing the circle
    for (var i = 0; i < all_overlays.length; i++) {
        all_overlays[i].overlay.setMap(null);
    }
    all_overlays = [];
    //for removing all the transports 
    for (var i = 0; i < transports.length; i++) {
        transports[i].setMap(null);
    }
    transports = [];
    
    //for removing all the transports 
    for (var i = 0; i < schools.length; i++) {
        schools[i].setMap(null);
    }
    schools = [];

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
        /*properties those are user draw area*/
        for(var i=0; i<times; i++){
            var latitude = propertyData[i]['latitude'];
            var longitude = propertyData[i]['longitude'];
            var id = propertyData[i]['id'];
            var coordinate = new google.maps.LatLng(latitude,longitude);
            if (poly.Contains(coordinate)) {
                propertyID.push(id); 
            }
        }
        /*transport stations those are user draw area*/
        for(var i=0; i<transportLength; i++){
            var latitude = transportData[i]['latitude'];
            var longitude = transportData[i]['longitude'];
            var id = transportData[i]['id'];
            var coordinate = new google.maps.LatLng(latitude,longitude);
            if (poly.Contains(coordinate)) {
                transportID.push(id); 
            }
        }
        /*schools those are user draw area*/
        for(var i=0; i<schoolLength; i++){
            var latitude = schoolData[i]['latitude'];
            var longitude = schoolData[i]['longitude'];
            var id = schoolData[i]['id'];
            var coordinate = new google.maps.LatLng(latitude,longitude);
            if (poly.Contains(coordinate)) {
                schoolID.push(id); 
            }
        }
        polys.push(poly);
        google.maps.event.clearListeners(map.getDiv(), 'mousedown');
        enable();
        searchProperty('poly');
    });
}

/*To check if the lat lng exist in the polygon or not*/
google.maps.Polygon.prototype.Contains = function (point) {
    var crossings = 0,
    path = this.getPath();

// for each edge
for (var i = 0; i < path.getLength(); i++) {
    var a = path.getAt(i),
    j = i + 1;
    if (j >= path.getLength()) {
        j = 0;
    }
    var b = path.getAt(j);
    if (rayCrossesSegment(point, a, b)) {
        crossings++;
    }
}

// odd number of crossings?
return (crossings % 2 == 1);

function rayCrossesSegment(point, a, b) {
    var px = point.lng(),
    py = point.lat(),
    ax = a.lng(),
    ay = a.lat(),
    bx = b.lng(),
    by = b.lat();
    if (ay > by) {
        ax = b.lng();
        ay = b.lat();
        bx = a.lng();
        by = a.lat();
    }
// alter longitude to cater for 180 degree crossings
if (px < 0) {
    px += 360;
}
if (ax < 0) {
    ax += 360;
}
if (bx < 0) {
    bx += 360;
}

if (py == ay || py == by) py += 0.00000001;
if ((py > by || py < ay) || (px > Math.max(ax, bx))) return false;
if (px < Math.min(ax, bx)) return true;

var red = (ax != bx) ? ((by - ay) / (bx - ax)) : Infinity;
var blue = (ax != px) ? ((py - ay) / (px - ax)) : Infinity;
return (blue >= red);

}

};

/*For drawing a circle*/
var drawingManager;
function circle() {
    propertyID = []; 
    for (var i = 0; i < all_overlays.length; i++) {
        all_overlays[i].overlay.setMap(null);
    }
    all_overlays = [];
//for clearing the old polylines
for(var i=0;i<polys.length;i++){
    polys[i].setMap(null);
}
polys = [];
var polyOptions = {
    strokeWeight: 0,
    fillOpacity: 0.45,
    editable: true
};
drawingManager = new google.maps.drawing.DrawingManager({
    drawingControlOptions: {
        position: google.maps.ControlPosition.TOP_CENTER,
        drawingModes: [
        google.maps.drawing.OverlayType.CIRCLE]
    },
    circleOptions: polyOptions,
    map: map
});
google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
    all_overlays.push(e);
    var radius = e.overlay.getRadius();
    var lat = e.overlay.getCenter().lat();
    var lng = e.overlay.getCenter().lng();

    for(var i=0; i<times; i++){
        var latitude = propertyData[i]['latitude'];
        var longitude = propertyData[i]['longitude'];
        var id = propertyData[i]['id'];
        var distance = calculateDistance(latitude,longitude,lat,lng,"K");
        if (distance * 1000 < radius) { 
            propertyID.push(id);
        }
    }
    if (e.type != google.maps.drawing.OverlayType.MARKER) {
        drawingManager.setDrawingMode(null);
        drawingManager.setOptions({
            drawingControl: false
        });
    }
    for (var i = 0; i < Number(all_overlays.length)-Number(1); i++) {
        all_overlays[i].overlay.setMap(null);
    }
    searchProperty('circle');
    currentOverlay = e.overlay;
    currentOverlay.addListener('radius_changed', showRadius);
    currentOverlay.addListener('center_changed', showRadius);
    showRadius();

});
}

function showRadius(){
    propertyID = [];
    (currentOverlay.getRadius()/1000.0).toFixed(3);
    var radius = currentOverlay.getRadius();
    var lat = currentOverlay.getCenter().lat();
    var lng = currentOverlay.getCenter().lng();
    for(var i=0; i<times; i++){
        var latitude = propertyData[i]['latitude'];
        var longitude = propertyData[i]['longitude'];
        var id = propertyData[i]['id'];
        var distance = calculateDistance(latitude,longitude,lat,lng,"K");
        if (distance * 1000 < radius) { 
            propertyID.push(id);
        }
    }
    searchProperty('circle');
    $('.gmnoprint').addClass('hide');
}


function calculateDistance(lat1, lon1, lat2, lon2, unit) {
    var radlat1 = Math.PI * lat1/180;
    var radlat2 = Math.PI * lat2/180;
    var radlon1 = Math.PI * lon1/180;
    var radlon2 = Math.PI * lon2/180;
    var theta = lon1-lon2;
    var radtheta = Math.PI * theta/180;
    var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
    dist = Math.acos(dist);
    dist = dist * 180/Math.PI;
    dist = dist * 60 * 1.1515;
    if (unit=="K") { dist = dist * 1.609344; }
    if (unit=="N") { dist = dist * 0.8684; }
    return dist;
}


$(document).on('click','.exceptNearby',function(){
    /*For removing the old current location*/
    for (var i = 0; i < nearbyMarkers.length; i++) {
        nearbyMarkers[i].setMap(null);
    }
    nearbyMarkers = [];
    //$('.nearby').removeClass('activebg');
});

/*For fetching nearby places*/
$(document).on('click','.nearby',function(){
    setMapOnAll(null,1);
    setMapOnAll(null,2);
    /*For removing the old current location*/
    for (var i = 0; i < nearbyMarkers.length; i++) {
        nearbyMarkers[i].setMap(null);
    }
    var lat;
    var lng;
    nearbyMarkers = [];
// if ("geolocation" in navigator){
    if (0){
        navigator.geolocation.getCurrentPosition(function(position){ 
            lat = position.coords.latitude;
            lng = position.coords.longitude;
        });
    }else{
        lat = 25.276987;
        lng = 55.296249;
    }
    var _this = $(this);
    nearby(lat,lng,_this);
    marker = new google.maps.Marker({
        position: new google.maps.LatLng(lat,lng),
        map: map,
        draggable: true,
        icon: baseUrl+'assets/images/map-icon/newsvgicon/mawjuud-img.gif'
    });
    nearbyMarkers.push(marker);
    google.maps.event.addListener(marker, 'dragend', function (event) {
        var newLat = this.getPosition().lat();
        var newLng = this.getPosition().lng();
        nearby(newLat,newLng,_this);
    });
    google.maps.event.addListener(marker, 'mouseout', (function(){
        infowindow.close(map, marker);
    }));
});


function nearby(lat,lng,_this){
    var radius = 10000;
    for(var i=0; i<times; i++){
        var latitude = propertyData[i]['latitude'];
        var longitude = propertyData[i]['longitude'];
        var id = propertyData[i]['id'];
        var distance = calculateDistance(latitude,longitude,lat,lng,"K");
        if (distance * 1000 < radius) { 
            propertyID.push(id);
        }
    }
    //$('.map-controller-icon button').removeClass('activebg');
    _this.addClass('activebg');
    searchProperty('nearby');
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

$(document).on('click','.Mhideproperty',function(){
    var id = $(this).data("property");
    $.ajax({
        url: baseUrl+ 'property/hideProperty',
        type: 'post',
        data: {id:id},
        dataType: 'json',
        success: function (data) {

        },
    });
    searchProperty();
});

/*for clearing the form on clear button click in filter*/
$('.clearbtndsn').click(function(){
    $('#baths').prop('selectedIndex',0);
    $("#baths").formSelect();
    $('#min_sqft').val('');
    $('#max_sqft').val('');
    $('#min_price').val('');
    $('#max_price').val('');
    $('#keywords').val('');
    $('#days_zillow').prop('selectedIndex',0);
    $("#days_zillow").formSelect();
});

$('.moremanyopt .MoreBnts').click(function(){ 
    $(this).siblings('.MoreSmBox').toggleClass('openmoreDiv');  
});

$(window).on("load resize ", function() {
    var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
    $('.tbl-header').css({'padding-right':scrollWidth});
}).resize();

jQuery(document).ready(function() {
    jQuery(document).on('click','.callModal',function(){
        propertyID = $(this).data('property_id');
        jQuery(this).siblings('#callModal'+propertyID).addClass('open1').after('<div class="modal-overlay" style="z-index: 1002; display: block; opacity: 0.5;"></div>');
        jQuery('.modal').modal();
    });

    jQuery(document).on('click','.share',function(){
        propertyID = $(this).data('property_id');
        jQuery(this).siblings('#sharelisting'+propertyID).addClass('open1').after('<div class="modal-overlay" style="z-index: 1002; display: block; opacity: 0.5;"></div>');
        jQuery('.modal').modal();
    });

    jQuery(document).on('click','.inquiry',function(){
        propertyID = $(this).data('property_id');
        $.ajax({
            url: baseUrl+ 'property/openInquiryForm',
            type: 'post',
            data: {propertyID:propertyID},
            dataType: 'json',
            success: function (data) {
                $('.openInquiryBlock').html(data.modalData);
                $('.inquiry_agent_modal').addClass('open1').after('<div class="modal-overlay" style="z-index: 1002; display: block; opacity: 0.5;"></div>');
                jQuery('.modal').modal();
            },
        });
    });

    jQuery(document).on('click','.modal-close',function(){
        jQuery(this).parents('.modal').removeClass('open1').hide();
        jQuery('.modal-overlay').hide();
    });

    /*For selecting country code*/
    $(document).on('click','.inquiry_agent li',function(){
        var code = $(this).data('dial-code');
        $('.phone_code').val(code);
    });


    /*To contact agent*/
    $(document).on('submit',".contactOwners",function(e){
        e.preventDefault();
        $('.contactOwners').each( function(){
            $(this).trigger('click');
            var form = $(this);
            form.validate({
                errorPlacement: function (error, element) {
                    error.css('color', 'red');
                    error.insertAfter(element);
                },
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                },
                success: function(label) {
                    label.addClass("valid").text("")
                },
                submitHandler: function() { 
                    $('body').append(loader_ajax);
                    $('.loader_outer').show();
                    $.ajax({
                        url: baseUrl+ 'property/contactAgent',
                        type: 'post',
                        dataType: 'json',
                        data: form.serialize(),
                        success: function (data) {
                            $('.loader_outer').hide();
                            form[0].reset();
                            $('.inquiry_agent').modal('close');
                            if(data.status == 1){
                                Ply.dialog("alert",'Contact request sent successfully to an agent');
                            }
                            $('.modal-close').trigger('click');
                        },
                    });
                }
            })
        });
    });
});



window.fbAsyncInit = function() {
    FB.init({
        appId            : '1935343549865205',
        autoLogAppEvents : true,
        xfbml            : true,
        version          : 'v3.0'
    });
};

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk')); 
function submitAndShare(shareimg,sharetitle,url='') {
    sharedUrl = ''; 
    var title = "-"+sharetitle; 
    var description = '';
    if(url == ''){
        sharedUrl = window.location.href
    } else {
        sharedUrl = url;
    }
    shareOverrideOGMeta(sharedUrl,sharetitle,description,shareimg);
    return false;
}

function shareOverrideOGMeta(overrideLink, overrideTitle, overrideDescription, overrideImage)
{
    FB.ui({
        method: 'share_open_graph',
        action_type: 'og.shares',
        action_properties: JSON.stringify({
            object: {
                'og:url': overrideLink,
                'og:title': overrideTitle,
                'og:description': overrideDescription,
                'og:image': overrideImage
            }
        })
    },
    function (response) {
    });
}

$(document).on('click','.addnewEm',function(){
    $('.hiddenAdemail').show();
    $(this).hide();
});

/*To share property*/
$(document).on("submit",".shareForm",function(e){
    if($(".shareForm").valid()){
        e.preventDefault();
        $('body').append(loader_ajax);
        $.ajax({
            url: baseUrl+ 'property/shareNote',
            type: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: function (data) {
                $('.loader_outer').hide();
                $('.shareForm')[0].reset();
                if(data.status == 1){
                    Ply.dialog("alert",'Property note shared successfully');
                }
                $('.sharelisting').modal('close');
                $('.modal-close').trigger('click');
            },
        });
    }
});  

$(".shareForm").validate({
    errorPlacement: function (error, element) {
        error.css('color', 'red');
        error.insertAfter(element);
    },
    rules: {
        note: {
            required: true
        },
        'email[]': {
            required: true,
            email: true
        }
    },
});

/*For changing the min max price*/
function priceChange(){
    var minPrice = $('#min_price').val();
    var maxPrice = $('#max_price').val();
    minPrice = minPrice.replace(',','');
    minPrice = minPrice.replace('AED ','');
    $('#min_price').val(commaSeparateNumber(minPrice));
    $('#max_price').val(commaSeparateNumber(maxPrice));
    var appendMaxPrice='';
    var price = minPrice;
    for(var i=0; i<=8; i++){
        price = Number(price)+Number(25000);
        appendMaxPrice+='<li data-value="'+price+'"><a class="option">AED '+price.toLocaleString()+'</a></li>';
    }
    appendMaxPrice+='<li data-value="any"><a class="option">Any Price</a></li>';
    $('#maxpriceappend').html(appendMaxPrice);
    searchProperty();
}

$(document).on('blur','#min_price,#max_price',function(){
    searchProperty();
});

function commaSeparateNumber(val){
    while (/(\d+)(\d{3})/.test(val.toString())){
        val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
    }
    return val;
}

/*For fetching school and transport*/
$(document).on('click','.facilities',function(){
    var _this = $(this);
    var typeF = _this.data('type');
    var img;
    if(typeF == 'school'){
        img = 'school-newicon.png';
        if(schoolSet == 0){
            facilities(_this,img,typeF);
        }else{
            schoolSet = 0;
            // for removing all the schools 
            for (var i = 0; i < schools.length; i++) {
                schools[i].setMap(null);
            }
            schools = [];
            _this.removeClass('activebg');
        }
    }
    else if(typeF == 'transport'){
        img = 'transport-newicon.png';
        if(transportSet == 0){
            facilities(_this,img,typeF);
        }else{
            transportSet = 0;
            // for removing all the transports 
            for (var i = 0; i < transports.length; i++) {
                transports[i].setMap(null);
            }
            transports = [];
            _this.removeClass('activebg');
        }
    }
});

function facilities(_this,img,typeF1){
    if(typeF1 == 'transport'){
        transportSet = 1;
        _this.addClass('activebg');
    }
    else if(typeF1 == 'school'){
        schoolSet = 1;
        _this.addClass('activebg');
    }
    $.ajax({
        url: baseUrl+ 'property/fetchFacilities',
        type: 'post',
        dataType: 'json',
        data: {typeF:typeF1,schoolID:schoolID,transportID:transportID,schoolSet:schoolSet,transportSet:transportSet},
        success: function (data) {
            var facilitiesLength = data.facilities.length;
            for (i = 0; i < facilitiesLength; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(data.facilities[i].latitude, data.facilities[i].longitude),
                    map: map,
                    icon: baseUrl+'assets/images/'+img
                });
                google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
                    return function() {
                        var html = '<div class="col s12 transportMapDiv"><div><h6>'+data.facilities[i].name+'</h6>'+data.facilities[i].star_ratings+'</div></div>';
                        infowindow.setContent(html);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
                google.maps.event.addListener(marker, 'mouseout', (function(){
                    infowindow.close(map, marker);
                }));
                if(typeF1 == 'transport'){
                    transports.push(marker);
                }
                if(typeF1 == 'school'){
                    schools.push(marker);
                }
            }
        },
    });
}