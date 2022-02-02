/*==============carousel_thumbnail===============*/
$(document).ready(function() {

$(document).ready(function() {
  var bigimage = $("#topcar");
  var thumbs = $("#topcarthumb");
  //var totalslides = 10;
  var syncedSecondary = true;

  bigimage
    .owlCarousel({
    items: 1,
    slideSpeed: 2000,
    nav: true,
    dots: false,
    loop: true,
    responsiveRefreshRate: 200
  })
    .on("changed.owl.carousel", syncPosition);

  thumbs
    .on("initialized.owl.carousel", function() {
    thumbs
      .find(".owl-item")
      .eq(0)
      .addClass("current");
  })
    .owlCarousel({
    items: 5,
    dots: true,
    nav: true,
    smartSpeed: 200,
    slideSpeed: 500,
    slideBy: 5,
    responsiveRefreshRate: 100
  })
    .on("changed.owl.carousel", syncPosition2);

  function syncPosition(el) {
    //if loop is set to false, then you have to uncomment the next line
    //var current = el.item.index;

    //to disable loop, comment this block
    var count = el.item.count - 1;
    var current = Math.round(el.item.index - el.item.count / 2 - 0.5);

    if (current < 0) {
      current = count;
    }
    if (current > count) {
      current = 0;
    }
    //to this
    thumbs
      .find(".owl-item")
      .removeClass("current")
      .eq(current)
      .addClass("current");
    var onscreen = thumbs.find(".owl-item.active").length - 5;
    var start = thumbs
    .find(".owl-item.active")
    .first()
    .index();
    var end = thumbs
    .find(".owl-item.active")
    .last()
    .index();

    if (current > end) {
      thumbs.data("owl.carousel").to(current, 100, true);
    }
    if (current < start) {
      thumbs.data("owl.carousel").to(current - onscreen, 100, true);
    }
  }

  function syncPosition2(el) {
    if (syncedSecondary) {
      var number = el.item.index;
      bigimage.data("owl.carousel").to(number, 100, true);
    }
  }

  thumbs.on("click", ".owl-item", function(e) {
    e.preventDefault();
    var number = $(this).index();
    bigimage.data("owl.carousel").to(number, 300, true);
  });
});



});




/*==============carousel_thumbnail===============*/
$(document).ready(function(){
    $('.collapsible1 .collapsible-header').on('click', function(){
        $(this).siblings('.collapsible-body').slideToggle();
        $(this).parent('li').toggleClass('active');
    });
    /*For selecting country code*/
    $('li').on('click',function(){
        var code = $(this).data('dial-code');
        $('#phone_code').val(code);
    });

    /*To record call activity*/
    $('.grenbtnscall').on('click',function(){
        var property_id = $(this).data('property_id');
        $.ajax({
            url: baseUrl+ 'property/recordCallActivity',
            type: 'post',
            dataType: 'json',
            data: {property_id:property_id},
            success: function (data) {
                if(data.user_login!='' && (data.user_login == 1)){
                    $('#loginmodal').modal('open');
                }
            },
        });
    });
});

$('.addnewEm').click(function(){
    $('.hiddenAdemail').show();
    $(this).hide();
});

// $('#startbucks').owlCarousel({
//     loop:true,
//     margin:10,
//     nav:true,
//     responsive:{
//         0:{
//             items:1
//         },
//         600:{
//             items:2
//         },
//         1000:{
//             items:2
//         }
//     },
//     navText: ["<span class='ti-angle-left'></span>","<span class='ti-angle-right'></span>"]
// });



/*For google map*/
// var locations = <?php echo json_encode($location); ?>;
var latitude = $('#latitude').val();
var longitude = $('#longitude').val();
var map = new google.maps.Map(document.getElementById('property_map'), {
    zoom: 15,
    center: new google.maps.LatLng(latitude,longitude),
    mapTypeId: google.maps.MapTypeId.ROADMAP
});
var infowindow = new google.maps.InfoWindow();
var marker;

var property_address = $('#property_address').val();
marker = new google.maps.Marker({
    position: new google.maps.LatLng(latitude, longitude),
    map: map
});
google.maps.event.addListener(marker, 'click', (function(marker, i) {
    return function() {
        infowindow.setContent(property_address+"<br>coordinates: "+latitude+" , "+longitude);
        infowindow.open(map, marker);
    }
})(marker));

if(latitude=='' && longitude==''){
    marker.setMap(null);
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
            }
            if(data.status == 2){
                $(evt).removeClass('fillHearts');
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

/*To contact agent*/
$("#contactOwner").submit(function(e){
    if($("#contactOwner").valid()){
        e.preventDefault();
        $('body').append(loader_ajax);
        $.ajax({
            url: baseUrl+ 'property/contactAgent',
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
    },
}); 

/*To ask question*/
$("#askQuestion").submit(function(e){
    if($("#askQuestion").valid()){
        e.preventDefault();
        $('body').append(loader_ajax);
        $.ajax({
            url: baseUrl+ 'property/askQuestion',
            type: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: function (data) {
                $('.loader_outer').hide();
                $('#askModal').modal('close');
                $('#askQuestion')[0].reset();
                if(data.status == 1){
                    Ply.dialog("alert",'Question successfully submitted');
                }
            },
        });
    }
});

$("#askQuestion").validate({
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
            mynumber: true
        },
        email: {
            required: true,
            email: true
        }
    },
});


/*To share property*/
$("#shareForm").submit(function(e){
    if($("#shareForm").valid()){
        e.preventDefault();
        $('body').append(loader_ajax);
        $.ajax({
            url: baseUrl+ 'property/shareNote',
            type: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: function (data) {
                $('.loader_outer').hide();
                if(data.user_login!='' && (data.user_login == 1)){
                    $('#loginmodal').modal('open');
                }
                $('#shareForm')[0].reset();
                if(data.status == 1){
                    Ply.dialog("alert",'Property note shared successfully');
                }
                $('.sharelisting').modal('close');
            },
        });
    }
});  

$("#shareForm").validate({
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

/*To request a tour*/
$("#tourRequest").submit(function(e){
    e.preventDefault();
    $('body').append(loader_ajax);
    $.ajax({
        url: baseUrl+ 'property/requestTour',
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function (data) {
            $('.loader_outer').hide();
            $('#tourRequest')[0].reset();
            if(data.user_login!='' && (data.user_login == 1)){
                $('#loginmodal').modal('open');
            }
            else{
                if(data.status == 1){
                    Ply.dialog("alert",'Tour request sent successfully');
                }
                else if(data.status == 2){
                    Ply.dialog("alert",'Please select the tour time when you would be comfortable for a tour');
                }
            }
        },
    });
});  

/*function for down payment calculation*/
function downPaymentCalc(type){
    var home_price = $('#home_price').val();
    home_price = home_price.split(',').join('');
    var percent = $('#percent').val();
    var down_payment = $('#down_payment').val();
    if(Number(home_price) < Number(down_payment)){
        Ply.dialog("alert",'Home price should be greater than down payment');
        $('#down_payment').val('');
        return false;
    }

    if(Number(percent) > 100){
        Ply.dialog("alert",'Percentage can\'t be greater than 100');
        $('#percent').val('');
        return false;
    }

    if(type=='payment'){
        var percent = (Number(down_payment)*100)/Number(home_price);
        $('#percent').val(percent.toFixed(2));
    }
    if(type=='percent'){
        var down_payment = (Number(home_price)*Number(percent))/100;
        $('#down_payment').val(down_payment.toFixed(2));
    }
    emiCalculation();
}

/*function for EMI calculation*/
function emiCalculation(){
    var home_price = $('#home_price').val();
    home_price = home_price.split(',').join('');
    var down_payment = $('#down_payment').val();
    var percent = $('#percent').val();
    var years = $('#years').val();
    years = Number(years)*12;
    var interest_rate = $('#interest_rate').val();
    interest_rate = Number(interest_rate)/(12*100);
    var price = Number(home_price).toFixed(2)-Number(down_payment).toFixed(2);
    var emi = price * interest_rate / (1 - (Math.pow(1/(1 + interest_rate), years)));
    $('#emi').val(emi.toFixed(2));
}





/*To fetch nearby shops*/
findPlaces();
function findPlaces(){
    $('#startbucks').html('');
    var shop_type = $('#gmap_type').val();
    if(shop_type == 'cafe'){
        var type = ['cafe','food'];
    }else{
        var type = [shop_type];
    }
    var radius = $('#changekm').val();
    var keyword = '';
    var cur_location = new google.maps.LatLng(latitude,longitude);
    for(i=0;i<1;i++){
        var request = {
            location: cur_location,
            radius: radius,
            types: [type[i]]
        };
        service = new google.maps.places.PlacesService(map);
        service.search(request, createMarkers);
    }
}

// create markers (from 'findPlaces' function)
function createMarkers(results, status) {
    if (status == google.maps.places.PlacesServiceStatus.OK) {
        for (var i = 0; i < results.length; i++) {
            createMarker(results[i]);
        }
    } else if (status == google.maps.places.PlacesServiceStatus.ZERO_RESULTS) {
        //alert('Sorry, nothing is found');
    }
    $('#startbucks .item').addClass('lslide');
    $('#startbucks .item').css({"width": "259.333px","margin-right": "10px"});
}

// creare single marker function
function createMarker(obj) {
    var mark = JSON.stringify(obj);
    var jsonObj = JSON.parse(mark);
    var lat = jsonObj.geometry.location.lat;
    var lng = jsonObj.geometry.location.lng;
    var km = distance(latitude,longitude,lat, lng, 'K');
    var distance1;
    if(km<1){
        distance1 = (km*1000).toFixed(0);
        unit = ' Meters';
    }else{
        distance1 = km.toFixed(1);
        unit = ' KM';
    }
    var html = '<div class="item"><div class="star-bucks"><div class="star-bucks-img"><img src="'+obj.icon+'"></div> <h5>'+obj.name+'</h5>  <div class="map-fitsa"><a href="https://www.google.com/maps/search/?api=1&query='+lat+','+lng+'" target="_blank"><img src="'+baseUrl+'assets/images/imgmap.png" alt="images"/><p>Show on Map</p>  </a><span>'+distance1+unit+'</span></div> </div></div>';
    $('#startbucks').append(html);
}


function distance(lat1, lon1, lat2, lon2, unit) {
    if ((lat1 == lat2) && (lon1 == lon2)) {
        return 0;
    }
    else{
        var radlat1 = Math.PI * lat1/180;
        var radlat2 = Math.PI * lat2/180;
        var theta = lon1-lon2;
        var radtheta = Math.PI * theta/180;
        var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
        if (dist > 1) {
            dist = 1;
        }
        dist = Math.acos(dist);
        dist = dist * 180/Math.PI;
        dist = dist * 60 * 1.1515;
        if (unit=="K") { dist = dist * 1.609344 }
            if (unit=="N") { dist = dist * 0.8684 }
                return dist;
    }
}

/*function to post a comment*/
$("#commentForm").validate({
    errorPlacement: function (error, element) {
        error.css('color', 'red');
        error.insertAfter(element);
    },
    rules: {
        comment:{
            required: true
        },
    },
    messages: {
        comment: {
            required: "Comment field is required",
        }
    }
}); 

$(".redbgnewsImp").click(function(e){
    e.preventDefault();
    if($("#commentForm").valid()){
        var property_id = $('#property_id').val();
        var comment = $('#comment').val();
        $.ajax({
            url: baseUrl+ 'property/postComment',
            type: 'post',
            dataType: 'json',
            data: {comment:comment,property_id:property_id},
            success: function (data) {
                $('.loader_outer').hide();
                $('#comment').val('');
                $('#user_comments').html(data.html);
            },
        });
    }
});   


/*Tour selection*/
$('#tourSelect').change(function(){
    var daySelected = $("#tourSelect option:selected").data('checks');
    var dayName = $("#tourSelect option:selected").data('day_name');
    var daysArr = ['Morning','Afternoon','Evening'];
    var days = [];
    if(daySelected == 1){
        days.push(1);
    }else if(daySelected == 2){
        days.push(2);
    }else if(daySelected == 3){
        days.push(3);
    }else{
        days = daySelected.split('-');
    }
    var html = '';
    for(var i=0;i<3;i++){
        if(days[i] == 1){
            html+='<label><input type="radio" name="duration" value="Morning"><span>Morning</span></label>';
        }else if(days[i] == 2){
            html+='<label><input type="radio" name="duration" value="Afternoon"><span>Afternoon</span></label>';
        }else if(days[i] == 3){
            html+='<label><input type="radio" name="duration" value="Evening"><span>Evening</span></label>';
        }
    }
    $('.dayCheckbox').html(html);
});


window.fbAsyncInit = function() {
    FB.init({
        appId            : '996078703923803',
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




var maxLength = 400;
$(".show-read-more").each(function(){
    var myStr = $(this).text();
    if($.trim(myStr).length > maxLength){
        var newStr = myStr.substring(0, maxLength);
        var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
        $(this).empty().html(newStr);
        $(this).append(' <a href="javascript:void(0);" class="read-more">Read more...</a>');
        $(this).append('<span class="more-text">' + removedStr + '</span>');
    }
});
$(".read-more").click(function(){
    $(this).siblings(".more-text").contents().unwrap();
    $(this).remove();
});

