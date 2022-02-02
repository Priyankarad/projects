jQuery.validator.addMethod("mynumber", function (value, element) {
    return this.optional(element) || /^[0-9,]+$/.test(value);
}, "Please enter a valid price(only digits,comma and decimal acceptable)");
var priceLimit = 0;
var propertyType;
$("#editPropertyForm").validate({
    errorPlacement: function (error, element) {
        error.css('color', 'red');
        error.insertAfter(element);
    },
    rules: {
        property_title:{
            required: true
        },
        rent_price: {
            mynumber: true,
//digits: true,
},
sale_price: {
    mynumber: true,
//digits: true,
},
security_deposit: {
    mynumber: true,
//digits: true,
},
square_feet: {
    mynumber: true,
//digits: true,
},
email: {
    email: true
}
},
messages: {
    rent_price: {
        mynumber: "Please enter a valid Rent Price",
    },
    sale_price: {
        mynumber: "Please enter a valid Sale Price",
    },
    security_deposit: {
        mynumber: "Please enter a valid Security Deposit value",
    },
    square_feet: {
        mynumber: "Please enter a valid Square Feet value",
    },
    email: {
        email: "Please enter a valid Email ID",
    }
}
}); 

/*To add property*/
$(".add_property").click(function(e){
    e.preventDefault();
    if($("#editPropertyForm").valid()){
        var formData = new FormData($('#editPropertyForm')[0]);
        if(storedFiles.length>0){
            for(var i=0, len=storedFiles.length; i<len; i++) {
                formData.append('file[]', storedFiles[i]);  
            } 
        }
        $('body').append(loader_ajax);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', baseUrl+ 'update_property', true);
        xhr.responseType = 'json';
        xhr.onload = function(e) {
            $('.loader_outer').hide();
            if(this.response.status == 1){
            	Ply.dialog("alert",'Property updated successfully');
                setTimeout(function () {
                    window.location.href = baseUrl+'search_properties';
                }, 4000); 
            }
        }
        xhr.send(formData);
    }
});   

jQuery(document).ready(function() {
	/*For initializing the map*/
	$(window).load(function () {
		initialize();
	});
});

var latitude;
var longitude;
var marker;
var map;
var geocoder;
var address;
var infowindow = new google.maps.InfoWindow({size: new google.maps.Size(150,50)});
function initialize() 
{ 
	geocoder = new google.maps.Geocoder();
	var mapOptions = {
		center: new google.maps.LatLng(25.276987, 55.296249),
		zoom: 8,
		scrollwheel: false,
		disableDefaultUI: false,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	map = new google.maps.Map(document.getElementById("map_canvas_1"),mapOptions);
	latitude = $('#latitude').val();
	longitude = $('#longitude').val();
	address = $('#searchLocationS1').val();
	marker = new google.maps.Marker({
		position: new google.maps.LatLng(latitude,longitude),
		map: map,
		draggable: true,
	});

	infowindow.setContent(address+'<br/>'+'coordinates:'+latitude+','+longitude);

	infowindow.open(map, marker);

	google.maps.event.addListener(marker, 'dragend', function() {
		geocodePosition(marker.getPosition());
	});

}

function geocodePosition(pos) {
	geocoder.geocode({
		latLng: pos
	}, function(responses) {
		if (responses && responses.length > 0) {
			if(marker){
				marker.formatted_address = responses[0].formatted_address;
			}
			document.getElementById('searchLocationS1').value = responses[0].formatted_address;
			var arrAddress = responses[0].address_components;
			$.each(arrAddress, function (i, address_component) {
				if (address_component.types[0] == "locality"){
					document.getElementById('city').value = address_component.long_name;
				}
			});

		} else {
			marker.formatted_address = 'Cannot determine address at this location.';
		}
		if(marker){
			infowindow.setContent(marker.formatted_address+"<br>coordinates: "+marker.getPosition().toUrlValue(6));
			infowindow.open(map, marker);
		}
		$('#searchLocationS1').val(marker.formatted_address);
	});
}

$(document).ready(function () {
	$location_input = $("#searchLocationS1");
	var options = {
		componentRestrictions: {
			country: 'ae'
		}
	};
	autocomplete = new google.maps.places.Autocomplete($location_input.get(0), options);   
	google.maps.event.addListener(autocomplete, 'place_changed', function() {
        dropdownAddr = 1;
        $('.codeAddressDetail').trigger('click');
    });
});

var dropdownAddr = 0;
var addressSet = 0;
$(document).on('keyup','#searchLocationS1',function(){
	dropdownAddr = 1;
});

function codeAddressDetail() {
	var city = document.getElementById('searchLocationS1').value;
	geocoder.geocode( { 'address': city}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			if(addressSet == 1){
				if (marker) {
					marker.setMap(null);
					if (infowindow) infowindow.close();
				}
				map.setZoom(15);
				$('#latitude').val(marker.getPosition().lat());
				$('#longitude').val(marker.getPosition().lng());
				map.setCenter(results[0].geometry.location);
				marker = new google.maps.Marker({
					map: map,
					draggable: true,
					position: results[0].geometry.location
				});
				marker.setMap(map);
			}else{
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
				marker.setMap(map);
			}
			google.maps.event.addListener(marker, 'dragend', function() {
				geocodePosition(marker.getPosition());
			});
			if (marker.formatted_address) {
				infowindow.setContent(marker.formatted_address+"<br>coordinates: "+marker.getPosition().toUrlValue(6));
			} else  {
				infowindow.setContent(city+"<br>coordinates: "+marker.getPosition().toUrlValue(6));
			}
			infowindow.open(map, marker);
		} 
	});

}


jQuery(document).on('keyup', '#price', function(){ 
	var number = $(this).val();
	number = numberWithCommas(number);
	$('#aed').html(number);
});

/*For rent duration*/
jQuery(document).on('change', '#rent_duration', function(){ 
    var duration = $(this).val();
    if(duration!=''){
    	$('#duration').html("AED/"+duration+'.');
    }else{
    	$('#duration').html("");
    }
});

/*Function to format number*/
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$('#square_feet').keyup(function(){
    var square_feet = $(this).val();
    $('.square_feet').html(numberWithCommas(square_feet)+" Sq. ft.");
});

jQuery(document).on('change', '#beds', function(){ 
    var bed = $(this).val();
    $('#beds').val(bed);
    $('#beds').formSelect();
    if(bed == 100){
        bed = 'Studio Bed';
    }
    if(bed == 10){
        bed = '10+ Beds';
    }
    if(Number(bed) > Number(1)){
        bed = bed+' Beds';
    }
    if(bed == 1){
        bed = bed+' Bed';
    }
    $('#bed1').html(bed+' <img src="'+baseUrl+'assets/images/bed1.png" alt=""/>');
});

jQuery(document).on('change', '#baths', function(){ 
    var bath = $(this).val();
    $('#baths').val(bath);
    $('#baths').formSelect();
    if(bath == 10){
        bath = '10+ Baths';
    }
    if(Number(bath) > Number(1)){
        bath = bath+' Baths';
    }
    if(bath == 1){
        bath = bath+' Bath';
    }
    $('#bath1').html(bath+' <img src="'+baseUrl+'assets/images/bath1.png" alt=""/>');
});

$('.textareaeditors').richText();
$('.richText-editor').focus(function(){ 
    $(this).css('color','#000000');
    var editor = $(this).html();
    if(editor == 'Add your Description here'){
        $(this).css('color','#dad1d4');
        $(this).html('');
    }
});
$('.richText-editor').blur(function(){ 
    $(this).css('color','#000000');
    var editor = $(this).html();
    if(editor == '<div><br></div>' || editor == ''){
        $(this).css('color','#dad1d4');
        $(this).html('Add your Description here');
    }
});


/*==========add-Aminities============*/ 
var additional_amenities = [];

jQuery(document).on('click', '#newAddAminities', function(){ 
    var newAmiadd = jQuery(this).siblings('input').val(); 
    if(newAmiadd == 0){
        Ply.dialog("alert",'Please add Amenities');
    }else{ 
        jQuery(this).siblings('input').val(' '); 
        jQuery('.newAmntsAppend').append('<div class="group-checkbox"> <label class="hide_P"><span class=span_ami> ' + newAmiadd + ' </span></label> <i class="removeTags"> x </i></div>'); 
    }
    addAmenities();
});

jQuery(document).on('click', '.newAmntsAppend .group-checkbox', function(){
    $(this).remove();  
    addAmenities();
});


function addAmenities(){
	additional_amenities = [];
	jQuery('.span_ami').each(function() {
        var currentElement = $(this);
        var value = currentElement.text();
        additional_amenities.push(value);
    });
    $('#additional_amenities1').val(additional_amenities);
}
/*==============moving==================*/
$( function() {
    $( "#dragimgappend" ).sortable();
});

$(document).ready(function(){
	$('.switchCheck').trigger('change');
    $('.switchCheck').change(function(){
        if(this.checked) {
            $('.questionAnswer').show();
        } else {
            $('.questionAnswer').hide();
        }
    });   
});

var quest_count = $('#quest_count').val();
var x = $('#quest_count').val();

if(Number(x) == Number(0)){
	x=1;
}else{
	x=Number(x)+Number(1);
    $('.questionAnswer').show();
}

//================QUESTION ADD DIV =================
$(document).ready(function(){
    var maxField = 4; 
    var addButton = $('.addQuestionT'); 
    var wrapper = $('#questionsList'); 
    var fieldHTML = '<div><input type="text" name="questions[]" value=""/><a class="remove_button">Delete</a></div>'; 
    $(addButton).click(function(){
        if(x < maxField){ 
            x++;
            $(wrapper).append(fieldHTML); 
        }
    });

    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove();
        x--; 
    });

});
