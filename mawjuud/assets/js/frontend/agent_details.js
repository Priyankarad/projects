var agent_id = $('#agent_id').val();
/*To contact agent*/
$("#contactOwner").submit(function(e){
    if($("#contactOwner").valid()){
        e.preventDefault();
        $('body').append(loader_ajax);
        $.ajax({
            url: baseUrl+ 'property/contactAgentDetail',
            type: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: function (data) {
                $('.loader_outer').hide();
                $('#contactOwner')[0].reset();
                $('#questionModal').modal('close');
                if(data.status == 1){
                    Ply.dialog("alert",'Contact request sent successfully to an agent');
                }
            },
        });
    }
});  

jQuery.validator.addMethod("mynumber", function (value, element) {
    return this.optional(element) || /^[0-9,.]+$/.test(value);
}, "Please specify the correct number format");

$("#contactOwner").validate({
    errorPlacement: function (error, element) {
        error.css('color', 'red');
        error.insertAfter(element);
    },
    rules: {
        name: {
            required: true
        },
        phone_number: {
            required: true,
        },
        email: {
            required: true,
            email: true
        },
        message: {
            required: true,
        }
    },
}); 

/*for initializing the map*/
var map = new google.maps.Map(document.getElementById('agent_propeties_map'), {
    zoom: 10,
    center: new google.maps.LatLng(25.276987, 55.296249),
    mapTypeId: google.maps.MapTypeId.ROADMAP
});
var infowindow = new google.maps.InfoWindow();
var marker;
/*for showing active listings*/
var table = $('.ouractivelistings').DataTable({
    processing: true,
    lengthMenu: [4],
    serverSide: true,
    ordering: false,
    ajax:{
        url: baseUrl+'user/getMyActiveListings',
        dataType: "json",
        type: "POST",
        data:{agent_id:agent_id}
    },
    drawCallback: function(settings){
        var api = this.api();
        var properties = api.ajax.json().recordsTotal;
        $('#active_properties').html(properties+' Properties');
        $('#active_listings').html('('+properties+')');
        if((api.ajax.json()!='undefined') && (api.ajax.json().location) && (api.ajax.json().location!='')){
            var locations = JSON.parse(api.ajax.json().location);
            for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map,
                });
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    var html = '<div class="col s12 box_div box_map"><div class="hover_property"><div class="box_img1"><a href="'+baseUrl+'single_property?id='+locations[i][15]+'" target="_blank" class="waves-effect waves-light"><img src="'+locations[i][4]+'" alt="images"><span class="ForSale '+locations[i][5]+'">For '+locations[i][6]+'</span><div class="box_cnts"><h4>'+locations[i][10]+'</h4><h6><span class="ti-location-pin"></span>'+locations[i][11]+'</h6><h5><span class="PriceSp">'+locations[i][12]+'</span></h5></div></a><div class="MtotalPicsList"><i>'+locations[i][13]+'</i> <span class="ti-camera"></span></div></div></div>      <div class="mapbox-btmsec"><h4><a href="">'+locations[i][16]+'</a></h4> <div><i>'+locations[i][9]+'</i> <span>Sq. ft</span> </div><ul><li><span>'+locations[i][8]+'</span><strong> Bed </strong> </li><li><span>'+locations[i][7]+'</span><strong>  Bath  </strong> </li></ul><h5><span class="PriceSp">'+locations[i][12]+'</span></h5></div>  </div>';
                    infowindow.setContent(html);
                    infowindow.open(map, marker);
                }
            })(marker, i));
            }
        }
    },
    columns: [
    { "data": "address" },
    { "data": "bed_bath" },
    { "data": "price" },
    ]   
});

/*for showing our past sales*/
var table = $('.ourpastsales').DataTable({
    processing: true,
    lengthMenu: [4],
    serverSide: true,
    ordering: false,
    ajax:{
        url: baseUrl+'user/getOurPastSales',
        dataType: "json",
        type: "POST",
        data:{agent_id:agent_id}
    },
    drawCallback: function(settings){
        var api = this.api();
        var properties = api.ajax.json().recordsTotal;
        $('#past_total').html('('+properties+')');
        if((api.ajax.json()!='undefined') && (api.ajax.json().location) && (api.ajax.json().location!='')){
            var locations = JSON.parse(api.ajax.json().location);
            for (i = 0; i < locations.length; i++) {
                var locationPointer;
                if(locations[i][6] == 'Sale'){
                    locationPointer = 'sales.png';
                }else if(locations[i][6] == 'Rent'){
                    locationPointer = 'rents.png';
                }
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map,
                    icon: baseUrl+'assets/images/'+locationPointer
                });
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    var html = '<div class="col s12 box_div box_map"><div class="hover_property"><div class="box_img1"><a href="'+baseUrl+'single_property?id='+locations[i][15]+'" target="_blank" class="waves-effect waves-light"><img src="'+locations[i][4]+'" alt="images"><span class="ForSale '+locations[i][5]+'">For '+locations[i][6]+'</span><div class="box_cnts"><h4>'+locations[i][10]+'</h4><h6><span class="ti-location-pin"></span>'+locations[i][11]+'</h6><h5><span class="PriceSp">'+locations[i][12]+'</span></h5></div></a><div class="MtotalPicsList"><i>'+locations[i][13]+'</i> <span class="ti-camera"></span></div></div></div>      <div class="mapbox-btmsec"><h4><a href="">'+locations[i][16]+'</a></h4> <div><i>'+locations[i][9]+'</i> <span>Sq. ft</span> </div><ul><li><span>'+locations[i][8]+'</span><strong> Bed </strong> </li><li><span>'+locations[i][7]+'</span><strong>  Bath  </strong> </li></ul><h5><span class="PriceSp">'+locations[i][12]+'</span></h5></div>  </div>';
                    infowindow.setContent(html);
                    infowindow.open(map, marker);
                }
            })(marker, i));
            }
        }
        
    },
    columns: [
    { "data": "address" },
    { "data": "represented" },
    { "data": "sold_date" },
    { "data": "price" },
    ]   
});