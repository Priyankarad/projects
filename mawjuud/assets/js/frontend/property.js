jQuery.validator.addMethod("mynumber", function (value, element) {
    return this.optional(element) || /^[0-9,]+$/.test(value);
}, "Please enter a valid price(only digits,comma and decimal acceptable)");
var priceLimit = 0;
var propertyType;
$("#addPropertyForm").validate({
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


var bed_bath = ''; 

/*================AddlistingProperty-==============*/
/*================AddlistingProperty-==============*/
jQuery(document).ready(function() {
    /*For initializing the map*/
    $(window).load(function () {
        initialize();
        initialize_1();
    });
    $('.half_rent').css('display', 'block');
    $('.full_rent').css('display', 'none');

    jQuery(".skipToLast").click(function() { 
        jQuery('.add_maps_list').fadeIn('slow');
        jQuery('.skipClickShow').fadeIn('slow');
        jQuery('.mapEditOption').fadeIn('slow');
        jQuery('.hideDivSkip').hide();
        jQuery('.custom-pro-right').css({'display': 'none'});
        jQuery('.col.s6.full_rent').css({'width': '25%'});
        jQuery('.lastLstPst.col.s6').css({'width': '25%', 'display': 'block'});

    });
    jQuery(".next_btnListing2").click(function() { 
        jQuery('.add_maps_list').fadeIn('slow');
        google.maps.event.trigger(marker1,'click');
        jQuery(this).parents('.custom-pro-right').css({'display': 'none'});
    });

    jQuery(".backBtnList").click(function() { 
        $(this).parents('.hideItems').hide();
        $(this).parents('.hideItems').prev().fadeIn('slow');
    });

$('#Mcategorysliders').owlCarousel({
    loop:true,
    margin:0,
    nav:true,
    responsive:{
        0:{
            items:2
        },
        600:{
            items:3
        },
        1000:{
            items:4
        }
    },
    navText: ["<span class='ti-angle-left'></span>","<span class='ti-angle-right'></span>"]
});
$('.slider_select').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:2
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    },
    navText: ["<span class='ti-angle-left'></span>","<span class='ti-angle-right'></span>"]
});
$('.textareaeditors').richText();

/*For phone number and other contact number*/
$('#user_number li').on('click',function(){
    var code = $(this).data('dial-code');
    $('#number_code').val(code);
});
$('#other_contact li').on('click',function(){
    var code = $(this).data('dial-code');
    $('#other_code').val(code);
});
});

/*Rent Slider*/
var updateRange;
$(document).ready(function(){
    var $range = $("#propertypriceR"),
    $btn_minus = $(".M-minus"),
    $btn_plus = $(".M-add"),
    min = 1000,
    max = 500000,
    step = 1,
    from = 5000;


    $range.ionRangeSlider({
        type: "single",
        min: min,
        max: max,
        step: step,
        max_postfix: "+",
        from: from,
        onFinish: function (data) {
            from = data.from;
        },
        prettify_separator: ","
    });

    $btn_minus.on("click", function () {
        updateRange(-1);
    });

    $btn_plus.on("click", function () {
        updateRange(1);
    });

    var range_instance = $range.data("ionRangeSlider");

    updateRange = function (direction) {
        from += step * direction;
        if (from < min) {
            from = min;
        } else if (from > max) {
            from = max;
        }

        range_instance.update({
            from: from
        });
    };
    
});

/*Sale Slider*/
 var updateRangeS;
$(document).ready(function(){
    var $range = $("#propertypriceS"),
    $btn_minus = $(".M-minusS"),
    $btn_plus = $(".M-addS"),
    min = 75000,
    max = 5000000,
    step = 1,
    from = 100000;

    $range.ionRangeSlider({
        type: "single",
        min: min,
        max: max,
        step: step,
        max_postfix: "+",
        from: from,
        onFinish: function (data) {
            from = data.from;
        },
        prettify_separator: ","
    });

    $btn_minus.on("click", function () {
        updateRangeS(-1);
    });

    $btn_plus.on("click", function () {
        updateRangeS(1);
    });

    var range_instance = $range.data("ionRangeSlider");

    updateRangeS = function (direction) {
        from += step * direction;
        if (from < min) {
            from = min;
        } else if (from > max) {
            from = max;
        }

        range_instance.update({
            from: from
        });
    };
});

var updateRangeA;

/*Price Slider*/
$(document).ready(function(){
    var $range = $("#propertyrange"),
    $btn_minus = $(".A-minus"),
    $btn_plus = $(".A-add"),
    min = 0,
    max = 25000,
    step = 1,
    from = 5000;

    $range.ionRangeSlider({
        type: "single",
        min: min,
        max: max,
        step: step,
        max_postfix: "+",
        from: from,
        onFinish: function (data) {
            from = data.from;
        },
        prettify_separator: ","
    });

    $btn_minus.on("click", function () {
        updateRangeA(-1);
    });

    $btn_plus.on("click", function () {
        updateRangeA(1);
    });

    var range_instance = $range.data("ionRangeSlider");

    updateRangeA = function (direction) {
        from += step * direction;
        if (from < min) {
            from = min;
        } else if (from > max) {
            from = max;
        }

        range_instance.update({
            from: from
        });
    };
    // $("#propertyrange").onkeyup = function (e) {
    //     switch (e.key) {
    //         case 'ArrowLeft':
    //         alert('ddasdsad');
    //         updateRangeA(-1);
    //         break;
    //         case 'ArrowRight':
    //         updateRangeA(1);
    //     }
    // };
    // $(document).bind('keydown', function(event) {
    //     switch(event.keyCode){
    //         case 37:
    //         updateRangeA(-1);
    //         break;
    //         case 39:
    //         updateRangeA(1);
    //     }
    // });
});


/*================AddlistingProperty-==============*/

// /*To add property*/
// $(".add_property").click(function(){
//     var formData = new FormData($('#addPropertyForm')[0]);            
//     $.ajax({
//         url: baseUrl+ 'add_property',
//         type: 'post',
//         dataType: 'json',
//         data: formData,
//         success: function (data) {
//         },
//     });
// });    

/*To add property type*/
$('#add_property_type').click(function(){
    var other_type = $('#other_type').val();
    if(other_type!='')
        $('.other_type').html('<div class="signup_success card-panel teal accent-3">You have entered other property type as "'+other_type+'"</div>');
    else
        Ply.dialog("alert",'Please enter other type');
});

/*To add week days for availability*/
jQuery(document).on('change', '#day_select', function() {
    var day_html = '<div class="row"><div class="col s2"><p>'+$(this).val()+'</p></div><div class="col s6"><ul class="checkmultipleD"><li><div class="group-checkbox"><label class="hide_P"><input type="checkbox" checked="" /><span>Morning</span></label></div></li><li><div class="group-checkbox"><label class="hide_P"><input type="checkbox" /><span>Afternoon</span></label></div></li><li><div class="group-checkbox"><label class="hide_P"><input type="checkbox" checked=""/><span>Evening</span></label></div></li></ul></div></div>';
    $('.dayselecttimeC').append(day_html);
    $('option:selected', this).remove();
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
        additional_amenities.push(newAmiadd);
    }
    $('#additional_amenities1').val(additional_amenities);
});

jQuery(document).on('click', '.newAmntsAppend .group-checkbox', function(){
    additional_amenities = [];
    $(this).remove();
    jQuery('.span_ami').each(function() {
        var currentElement = $(this);
        var value = currentElement.text();
        additional_amenities.push(value);
    });
    $('#additional_amenities1').val(additional_amenities);
});

/*==========add-Aminities============*/
var category = 0;
/*To check the category*/
jQuery(document).on('click', '.category_list', function(){ 
    category = $(this).val();
    var listing = $(this).data('listing');
    var image = $(this).data('image');
    $('.selectcat-imgs').html('<img src="'+image+'" alt="images"/> '+listing);
});

var rent_sale = 0;
var price_1 = 1;
jQuery(document).on('click', '#map_cont', function(){
    var searchLocationS = $('#searchLocationS').val();
    if(searchLocationS == ''){
        Ply.dialog("alert",'Please enter a search location');
    }else{
        jQuery('#bed_details').css({'display': 'block'});
        jQuery('#bath_details').css({'display': 'block'});
        if(category == 2 || category == 3 || category == 5 || category == 7 || category == 9 || category == 11 || category == 0){
            jQuery('.area_1').fadeIn('slow');
            jQuery(this).parent().css({'display': 'none'});
            jQuery('#bed_details').css({'display': 'none'});
            jQuery('#bath_details').css({'display': 'none'});
        }else if(category == 1 || category == 4 || category == 6 || category == 10 || category == 12){
            jQuery(this).parent().next().fadeIn('slow');
            jQuery(this).parent().css({'display': 'none'});
        }else if(category == 8){
            jQuery('.bed_bath_hide').fadeIn('slow');
            jQuery('.bed_bath_hide p').text('Select Number of Baths');
            jQuery('#bedselect').css({'display': 'none'});
            jQuery('#bed_details').css({'display': 'none'});
            jQuery(this).parent().css({'display': 'none'});
        }
    }
});

/*To check the category*/
jQuery(document).on('click', '#first_cont', function(){ 
    jQuery(this).parent().next().fadeIn('slow');
    jQuery(this).parent().css({'display': 'none'});
});


jQuery(document).on('click', '#category_cont,#bed_bath_cont', function(){ 
    var listing = $('.category_list').val();
    jQuery(this).parent().next().fadeIn('slow');
    jQuery(this).parent().css({'display': 'none'});
});

jQuery(document).on('click', '#area_cont', function(){ 
    var listing = $('.category_list').val();
    jQuery(this).parent().next().fadeIn('slow');
    jQuery(this).parent().css({'display': 'none'});
    rent_sale = 1;
    price_1 = 0;
});

jQuery(document).on('click', '.rent_sale_back', function(){
    rent_sale = 0;
    price_1 = 1;
});


$(document).ready(function(){
    $('.half_rent').css('display', 'none');
    $('.select_optBy input').on('change', function() {
        propertyType = $('input[name=property_type]:checked').val(); 
        if(propertyType == 'rent'){
            max=500000;
            min=1000;
            $('.half_rent').css('display', 'block');
            $('.full_rent').css('display', 'none');
            $('.list_f').html('<div class="col s1 list_rent">For Rent</div>');
            priceLimit = 500000;
            $('.changesaleS').html('Rent');
            $('.sale_div').addClass('hide');
            $('.rent_div').removeClass('hide');
            document.onkeyup = function (e) {
                switch (e.key) {
                    case 'ArrowLeft':
                    if(rent_sale == 1){
                        updateRange(-1);
                    }
                    break;
                    case 'ArrowRight':
                    if(rent_sale == 1){
                        updateRange(1);
                    }
                }
            };
            document.onkeydown = function (e) {
                switch (e.key) {
                    case 'ArrowLeft':
                    if(price_1 == 1){
                        updateRangeA(-1);
                    }
                    break;
                    case 'ArrowRight':
                    if(price_1 == 1){
                        updateRangeA(1);
                    }
                }
            };

        }else if(propertyType == 'sale'){
            $('#duration').html('');
            max=5000000;
            min=75000;
            $('.full_rent').css('display', 'block');
            $('.half_rent').css('display', 'none');
            $('.list_f').html('<div class="col s1 list_sale">For Sale</div>');
            priceLimit = 5000000;
            $('.changesaleS').html('Sale');
            $('.sale_div').removeClass('hide');
            $('.rent_div').addClass('hide');

            document.onkeyup = function (e) {
                switch (e.key) {
                    case 'ArrowLeft':
                    if(rent_sale == 1){
                        updateRangeS(-1);
                    }
                    break;
                    case 'ArrowRight':
                    if(rent_sale == 1){
                        updateRangeS(1);
                    }
                }
            };
            document.onkeydown = function (e) {
                switch (e.key) {
                    case 'ArrowLeft':
                    if(price_1 == 1){
                        updateRangeA(-1);
                    }
                    break;
                    case 'ArrowRight':
                    if(price_1 == 1){
                        updateRangeA(1);
                    }
                }
            };
        }
    }); 

//$('.richText-editor div').attr('contentEditable',true);
//$('.richText-editor div').attr('placeholder','enter   ');

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

$('#neighbourhood').keyup(function(){
    $('#neighbourhood1').val($(this).val());
});
});


jQuery(document).on('change', '#beds,.bed_1', function(){ 
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

jQuery(document).on('change', '#baths,.bath_1', function(){ 
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

jQuery(document).on('change', '#propertyrange', function(){ 
    $('#square_feet').val(numberWithCommas($(this).val()));
    $('.square_feet').html(numberWithCommas($(this).val())+' Sq. ft.');
});

jQuery(document).on('keyup change', '#propertypriceR,#propertypriceS', function(){ 
    var number = $(this).val();
    number1 = numberWithCommas(number);
    $('#aed').html(number1+' AED');
    $('#rent_price').val(numberWithCommas(number));
    $('#sale_price').val(numberWithCommas(number));
});

jQuery(document).on('keyup', '#sale_price,#rent_price', function(){ 
    var number = $(this).val();
// if(Number(number)>Number(priceLimit)){
//     Ply.dialog("alert",'Price can\'t be greater than '+numberWithCommas(priceLimit));
//     return false;
// }
number = numberWithCommas(number);
$('#aed').html(number+' AED');
});
/*For rent duration*/
jQuery(document).on('change', '#rent_duration', function(){ 
    var duration = $(this).val();
    $('#duration').html("/"+duration+'.');
});

/*Function to format number*/
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

/*To add property*/
$(".add_property").click(function(e){
    e.preventDefault();
    var btn_name = $(this).data('btn_name');
    if(btn_name == 'draft'){
        $('#property_draft').val(1);
    }else{
        $('#property_draft').val(0);
    }
    if($("#addPropertyForm").valid()){
        var formData = new FormData($('#addPropertyForm')[0]);
        if(storedFiles.length>0){
            for(var i=0, len=storedFiles.length; i<len; i++) {
                formData.append('file[]', storedFiles[i]);  
            } 
        }
        $('body').append(loader_ajax);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', baseUrl+ 'add_property', true);
        xhr.responseType = 'json';
        xhr.onload = function(e) {

            $('.loader_outer').hide();
            if(this.response.status == 1){
                if(btn_name == 'draft'){
                    Ply.dialog("alert",'Property saved as draft successfully');
                }else if(btn_name == 'activate'){
                    Ply.dialog("alert",'Property added successfully');
                }
                setTimeout(function () {
                    window.location.href = baseUrl+'search_properties';
                }, 4000); 
            }
        }
        xhr.send(formData);
    }
});   


//================RENT OPTION ON OFF =================
$(document).ready(function(){
    $('.switchCheck').change(function(){
        if(this.checked) {
            $('.questionAnswer').show();
        } else {
            $('.questionAnswer').hide();
        }
    });   
});

var qid = 0;
var questions = 0;
//================QUESTION ADD DIV =================
$(document).ready(function(){
    var maxField = 4; 
    var addButton = $('.addQuestionT'); 
    var wrapper = $('#questionsList'); 
    var fieldHTML = '<div><input type="text" name="questions[]" value=""/><a class="remove_button" onclick="deletQues('+questions+')">Delete</a></div>'; 
    var x = 1; 
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

$('#square_feet').keyup(function(){
    var square_feet = $(this).val();
    var squareFeet = 10000;
    // if(Number(square_feet)>Number(squareFeet)){
    //     Ply.dialog("alert",'Size can\'t be greater than '+numberWithCommas(squareFeet));
    //     return false;
    // }
    $('.square_feet').html(numberWithCommas(square_feet)+" Sq. ft.");
});

function toCommas(value) {
    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

/*To add contents of property terms below description*/
$('#property_terms').keyup(function(){
    var property_terms = $(this).val();
    if(property_terms!=''){
        $('#options_term').removeClass('hide');
        $('#term_text').html(property_terms);
    }else{
        $('#options_term').addClass('hide');
    }
});



/*==============moving==================*/
$( function() {
    $( "#dragimgappend" ).sortable();
});

