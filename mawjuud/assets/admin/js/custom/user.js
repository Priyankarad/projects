var repeatId = 0;
jQuery(document).on('click', '.addMoreField', function() { 
    $('.LicensesRepeat').append('<div class="form-group row"><label class="col-sm-2 col-form-label">Licenses #:</label><div class="col-sm-9"><input name="licenses_number[]" type="text" class="form-control"/></div><div class="col-sm-1"><button type="button" class="closeField waves-effect waves-light btn btn-danger">-</button></div></div>');
    repeatId++;
});

var repeatId2 = 0;
jQuery(document).on('click', '.addMoreField2', function() { 
    $('.servicesRepeat').append('<div class="form-group row"><label class="col-sm-2 col-form-label">Services Areas #:</label><div class="col-sm-9"><input name="services_area[]" type="text" class="form-control"/></div><div class="col-sm-1"><button type="button" class="closeField waves-effect waves-light btn btn-danger">-</button></div></div>');
    repeatId2++;
}); 

jQuery(document).on('click', '.closeField', function() { 
    $(this).parent().parent().remove();
});

$("#profile_img").change(function() {
		readURL(this,'user_img');
	});