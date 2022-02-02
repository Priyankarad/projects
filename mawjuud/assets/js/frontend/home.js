/*for searching rent properties*/
$('.rent_btn').click(function(e){
	e.preventDefault();
	var address = $('#rent_address').val();
	if(address == ''){
		Ply.dialog("alert",'Please enter search location');
	}else{
		$('#searchPropertyRentForm').submit();
	}
});

/*for searching sale properties*/
$('.sale_btn').click(function(e){
	e.preventDefault();
	var address = $('#sale_address').val();
	if(address == ''){
		Ply.dialog("alert",'Please enter search location');
	}else{
		$('#searchPropertySaleForm').submit();
	}
});

/*For autocomplete address*/
initAutocomplete();
function initAutocomplete(){
	/*for rent*/
	$location_input = $("#rent_address");
	var options = {
		componentRestrictions: {
			country: 'ae'
		}
	};
	autocomplete = new google.maps.places.Autocomplete($location_input.get(0), options);   
	google.maps.event.addListener(autocomplete, 'place_changed', function() {
		$('#searchPropertyRentForm').submit();
	});

	/*for sale*/
	$location_input = $("#sale_address");
	var options = {
		componentRestrictions: {
			country: 'ae'
		}
	};
	autocomplete = new google.maps.places.Autocomplete($location_input.get(0), options);   
	google.maps.event.addListener(autocomplete, 'place_changed', function() {
		$('#searchPropertySaleForm').submit();
	});
}

/*for making property favourite*/
function favouriteProperty(property_id,evt){
	$(evt).removeClass('fillHearts');
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
		},
	});
}