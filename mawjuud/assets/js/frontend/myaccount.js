setTimeout(function() {
    $('.success').fadeOut('fast');
}, 3000);
/*================myAccount-==============*/
/*================myAccount-==============*/
var repeatId = 0;
jQuery(document).on('click', '.addMoreField', function() { 
    $('.LicensesRepeat').append('<div class="row"> <div class="col s3"> <div class="input-field"> <span class="titleDst">Licenses #:</span> </div></div><div class="col s7"> <div class="input-field"> <input id="licensesNumber-'+ repeatId +'" name="licenses_number[]" type="text" class="validate"/> <label for="licensesNumber-'+ repeatId +'">Enter licenses number</label> </div></div><div class="col s2"> <div class="input-field"> <button type="button" class="closeField waves-effect waves-light">Close</button></div> </div></div>');
    repeatId++;
});

var repeatId2 = 0;
jQuery(document).on('click', '.addMoreField2', function() { 
    $('.servicesRepeat').append(' <div class="row"> <div class="col s10"> <div class="input-field"> <input id="servicesArea-'+ repeatId2 +'" name="services_area[]" type="text" class="validate"/> <label for="servicesArea-'+ repeatId2 +'">Neighbourhood, city, country, ZIP, etc.</label> </div></div><div class="col s2"> <div class="input-field"> <button type="button" class="closeField waves-effect waves-light">Close</button></div></div></div>');
    repeatId2++;
}); 

jQuery(document).on('click', '.closeField', function() { 
    $(this).parent().parent().parent().remove();
});

jQuery(document).on('change','#category_agent',function(){
    var category = jQuery(this).val();
    if(category == 'owner'){
        jQuery('.agentBrokerSelect').hide();
        jQuery('.agency_name').hide();
    }else{
        jQuery('.agentBrokerSelect').show();
        jQuery('.agency_name').show();
    }
});

var category_agent = $('#category_agent').val();
if(category_agent == 'agent'){
    jQuery('.agentBrokerSelect').show();
}else{
    jQuery('.agency_name').hide();
}
/*================myAccount-==============*/
/*================myAccount-==============*/

/*To validate account form*/
$("#accountForms").validate({
    errorPlacement: function (error, element) {
        error.css('color', 'red');
        error.insertAfter(element);
    },
    rules: {
        first_name :"required",
        last_name :"required",
        category_agent :"required",
        agency_cell_code :"required",
        agency_cell :"required",
        website_url: {
            url: true
        },
        fb_url: {
            url: true
        },
        twitter_url: {
            url: true
        },
        linkedin_url: {
            url: true
        },
        profile_video: {
            url: true
        },
        agency_cell: {
            number : true,
            minlength : 10,
            maxlength : 11
        },
        user_number: {
            number   : true,
            minlength : 10,
            maxlength : 11
        }
    },
    messages: {
        first_name: "First Name is required",
        last_name : "Last Name is required",
        category_agent : "Professional Category is required",
        agency_cell_code : "Country Code is required",
        agency_cell : "Number is required",
        website_url: {
            url: "Enter a valid Website url",
        },
        fb_url: {
            url: "Enter a valid Facebook url",
        },
        twitter_url: {
            url: "Enter a valid Twitter url",
        },
        linkedin_url: {
            url: "Enter a valid Linkedin url",
        },
        profile_video: {
            url: "Enter a valid Profile Video url",
        },
        agency_cell: {
            minlength : "Minimum 10 digits",
            maxlength : "Mamimum 11 digits"
        },
        user_number: {
            minlength : "Minimum 10 digits",
            maxlength : "Mamimum 11 digits"
        },
    }
}); 

$("#accountForms").on('submit',function(e){
    e.preventDefault();
    if($("#accountForms").valid()){
        $('body').append(loader_ajax);
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: baseUrl+ 'myaccount',
            type: 'post',
            dataType: 'json',
            processData: false,
            contentType: false,
            data : formData,
            success: function (data) {
                $('.loader_outer').remove();
                Ply.dialog("alert",'Profile updated successfully');
                setTimeout(function () {
                    window.location.href = baseUrl+'myaccount';
                }, 4000); 
            },
        });
    }
});    




$('.top_barAccount .tabs li a').on('click', function(){
  $('.showdash').removeClass('mypshows '); 
})
$('ul.tabs.accountmawjuudsa li a').on('click', function(){
  $('ul.tabs.accountmawjuudsa li a').removeClass('activedefault'); 
  $(this).addClass('activedefault');  
  $('.eclickrmv').addClass('active');  
  $('#my_profile').addClass('mypshows').css('display', 'block');
})
/*for linking edit profile to my profile tab*/
jQuery('a.editPs.editRmyaccount').click(function(){
    $('.top_barAccount .tabs .tab  a').removeClass('active');
    $('.eclickrmv').addClass('active');
    $('.all_cnt_accountS > div').removeClass('active').css('display', 'none');
    $('#my_profile').addClass('active showdash').css('display', 'block');
});






/*for loading datatable*/
// var table;
// var table1;
$(document).ready(function() {
    //table1 = $('#property_table').DataTable();
    // $('.callActivity').DataTable();
    // table = $('.propertyTable').DataTable({
    //     "lengthMenu": [[3, 5, 10, 25, 50, -1], [3, 5, 10, 25, 50, "All"]]
    // });
    $('#category_agent').prop("disabled", true);
    $('select').formSelect();
});


jQuery('.tabs .tab a').click(function(){
    $('.tab a').removeClass('active');
    $(this).addClass('active');
    $('.showdash').removeClass('active').css('display', 'none');
});


/*For changing password*/
$("#changepwdForm").on('submit',function(e){
    e.preventDefault();
    if($("#changepwdForm").valid()){
        var newpwd = $('#newpwd').val();
        var crntpwd = $('#crntpwd').val();
        $('body').append(loader_ajax);
        $.ajax({
            url: baseUrl+ 'user/changePassword',
            type: 'post',
            dataType: 'json',
            data : {crntpwd:crntpwd,newpwd:newpwd},
            success: function (data) {
                $('.loader_outer').remove();
                $('#changepwdForm')[0].reset();
                if(data.status == 1){
                    Ply.dialog("alert",'Password changed successfully');
                }
                if(data.status == 2){
                    Ply.dialog("alert",'Invalid current password');
                }
            },
        });
    }
});  

/*To validate change password form*/
$("#changepwdForm").validate({
    errorPlacement: function (error, element) {
        error.css('color', 'red');
        error.insertAfter(element);
    },
    rules: {
        crntpwd: {
            required: true
        },
        newpwd: {
            required: true
        },
        cnpwd: {
            required: true,
            equalTo:'#newpwd'
        },
    },
    messages: {
        cnpwd: {
            equalTo:'Confirm password should be same as new password'
        },
    }
}); 


/*For changing password*/
$("#changemailform").on('submit',function(e){
    e.preventDefault();
    if($("#changemailform").valid()){
        var newemail = $('#newemail').val();
        $('body').append(loader_ajax);
        $.ajax({
            url: baseUrl+ 'user/changeEmail',
            type: 'post',
            dataType: 'json',
            data : {newemail:newemail},
            success: function (data) {
                $('.loader_outer').remove();
                $('#changemailform')[0].reset();
                if(data.status == 1){
                    Ply.dialog("alert",'Email changed successfully');
                }
            },
        });
    }
});  

/*To validate change password form*/
$("#changemailform").validate({
    errorPlacement: function (error, element) {
        error.css('color', 'red');
        error.insertAfter(element);
    },
    rules: {
        newemail: {
            required: true,
            email:true
        },
    },
}); 

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
    //$(this).closest('tr').hide();
});


/*For viewing property*/
type = 'photo';
$(document).on('click','.view',function(){
    type = $(this).data('type');
    searchProperty();
});

/*for refreshing the publish date*/
$(document).on('click','.refresh',function(){
    var _this = $(this);
    var propertyID = _this.data('property_id');
    $('body').append(loader_ajax);
    $('.loader_outer').show();
    $.ajax({
        url: baseUrl+ 'property/refreshProperty',
        type: 'post',
        data: {propertyID:propertyID},
        dataType: 'json',
        success: function (data) {
            $('.loader_outer').hide();
            $('.publisheds'+propertyID).html(data.publish_date);
        },
    });
});

/*for showing rented and sold band*/
$(document).on('click','.rent_sale',function(){
    var _this = $(this);
    var type = _this.val();
    var rentSale;
    if(_this.prop("checked") == true){
        rentSale = 1;
    }
    else if(_this.prop("checked") == false){
        rentSale = 0;
    }
    var propertyID = _this.data('property_id');
    $('body').append(loader_ajax);
    $('.loader_outer').show();
    $.ajax({
        url: baseUrl+ 'property/rentedSold',
        type: 'post',
        data: {propertyID:propertyID,rentSale:rentSale},
        dataType: 'json',
        success: function (data) {
            $('.loader_outer').hide();
            if(type == 'sold' && rentSale == 1){
                $('.band'+propertyID).html('<div class="mw-solds">sold</div>');
            }else if(type == 'sold' && rentSale == 0){
                $('.band'+propertyID).html('');
            }
            else if(type == 'rented' && rentSale == 1){
                $('.band'+propertyID).html('<div class="mw-rented">rented</div>');
            }else if(type == 'rented' && rentSale == 0){
                $('.band'+propertyID).html('');
            }
        },
    });
});

/*to activate deactivate property*/
$(document).on('click','.activate',function(){
    var activate=1;
    var act = $(this).data('act');
    var activates = $(this).data('activate');
    if(act == 1){
        if (activates == 0) {
            activate = 0;
        }
    }else{
        if ($(this).is(":checked")==false) {
            activate = 0;
        }
    }
    var property_id = $(this).data('property_id');
    $('body').append(loader_ajax);
    $('.loader_outer').show();
    $.ajax({
        url: baseUrl+ 'property/activeProperty',
        type: 'post',
        data: {activate:activate,propertyID:property_id},
        dataType: 'json',
        success: function (data) {
            $('.loader_outer').hide();
            if(activate == 0){
                $('.act_deact'+property_id).html('<button data-act="1"  class="m-green activate" data-activate = "1" data-property_id="'+property_id+'">Activate <i class="ti-power-off"></i></button>');
                $('.publish'+property_id).removeClass('m-ylow');
                $('.publish'+property_id).css('background-color','#00b050');
                $('.publish'+property_id).html('Saved In Draft');
            }else{
                $('.act_deact'+property_id).html('<button data-act="1"  class="m-red activate" data-activate = "0" data-property_id="'+property_id+'">Deactivate <i class="ti-power-off"></i></button>');
                $('.publish'+property_id).css('background-color','');
                $('.publish'+property_id).addClass('m-ylow');
                $('.publish'+property_id).html('Published');
            }
            $('.publisheds'+property_id).html(data.publish_date);
        },
    }); 
});

/*For search filter*/
var sortBy;
$(document).on('click','.sortBy',function(){
    sortBy = $(this).data('sort');
    searchProperty();
});
searchProperty();
function searchProperty(){
    $('.propertyPhotoTable').DataTable().destroy();
    $('.propertyTableView').DataTable().destroy();
    var category = $('#category').val();
    var status = $('#status').val();
    var propertyType = $('#property_type').val();
    if(type == 'photo'){
        $('.propertyPhotoTable').DataTable({
            processing: true,
            lengthMenu: [3],
            serverSide: true,
            ordering: false,
            ajax:{
                url: baseUrl+'property/searchMyPropertyFilter',
                dataType: "json",
                type: "POST",
                data: {category:category,status:status,propertyType:propertyType,sortBy:sortBy,type:type},
            },
            columns: [
            { "data": "id" },
            ]   
        });
                    if(type == 'table'){
                $('.d-propertytable').removeClass('hide');
                $('.d-propertylist').addClass('hide');
            }
            if(type == 'photo'){
                $('.d-propertylist').removeClass('hide');
                $('.d-propertytable').addClass('hide');
            }
    }else if(type == 'table'){
        $('.propertyTableView').DataTable({
            processing: true,
            lengthMenu: [10],
            serverSide: true,
            ordering: false,
            ajax:{
                url: baseUrl+'property/searchMyPropertyFilter',
                dataType: "json",
                type: "POST",
                data: {category:category,status:status,propertyType:propertyType,sortBy:sortBy,type:type},
            },
            columns: [
            { "data": "R / S" },
            { "data": "Type" },
            { "data": "Ref #" },
            { "data": "Title" },
            { "data": "Address" },
            { "data": "Price (AED)" },
            { "data": "Bed" },
            { "data": "Bath" },
            { "data": "Size" },
            { "data": "Date Added" },
            { "data": "Date Published" },
            { "data": "Status" },
            { "data": "Activity" },
            { "data": "Mark" },
            { "data": "ESD" },
            ]   
        });
                            if(type == 'table'){
                $('.d-propertytable').removeClass('hide');
                $('.d-propertylist').addClass('hide');
            }
            if(type == 'photo'){
                $('.d-propertylist').removeClass('hide');
                $('.d-propertytable').addClass('hide');
            }
    }
    // var category = $('#category').val();
    // var status = $('#status').val();
    // var propertyType = $('#property_type').val();
    // $('body').append(loader_ajax);
    // $('.loader_outer').show();
    // $.ajax({
    //     url: baseUrl+ 'property/searchMyPropertyFilter',
    //     type: 'post',
    //     data: {category:category,status:status,propertyType:propertyType,sortBy:sortBy,type:type},
    //     dataType: 'json',
    //     success: function (data) {
    //         $('.loader_outer').hide();
    //         if(type == 'table'){
    //             $('.d-propertytable').removeClass('hide');
    //             $('.d-propertylist').addClass('hide');
    //             $('.d-propertytable').html(data.html);
    //         }
    //         if(type == 'photo'){
    //             $('.d-propertylist').removeClass('hide');
    //             $('.d-propertytable').addClass('hide');
    //             $('.d-propertylist').html(data.html);
    //         }
            
    //     },
    // });
}

/*For deleting the property*/
var propertyID;
$(document).on('click', '.myacc_div', function(){
    propertyID = $(this).data('property_id');
});

$(document).on('click', '.delete_property', function(){
    $('body').append(loader_ajax);
    $('.loader_outer').show();
    var _this = $(this);
    $.ajax({
        url: baseUrl+ 'property/deleteProperty',
        type: 'post',
        data: {propertyID:propertyID},
        dataType: 'json',
        success: function (data) {
            $('.loader_outer').hide();
            $('.modalDelete'+propertyID).modal('close');
            Ply.dialog("alert",'Property deleted successfully');
            $('.modal-close').trigger('click');
            searchProperty();
        },
    });
});



$(document).on('click','.deleteRecord',function(){
    var record_id = $(this).data('record_id');
    $('#record_id').val(record_id);
    var tablename = $(this).data('table');
    $('#table').val(tablename);
});
/***********Delete Data**********/
var titleTable;
$(document).ready(function() {
    titleTable = $('#titleTable').DataTable();
});
function deleteRecord(){
    $('#deleteModal').modal('close');
    var record =  $('#record_id').val();
    var table_name = $('#table').val();
    $.ajax({
        type:'POST',
        url:baseUrl+'property/deleteRecord',
        data: {record:record,table_name:table_name},
        dataType: 'json',
        success:function(res){
            if(res.status == 1){
                Ply.dialog('alert','Record deleted successfully');  
            }else{
                Ply.dialog('alert','Problem deleting record! Please try again later.'); 
            }
            titleTable.row($('#'+record)).remove().draw(true);  
        },
        error:function(){
            $(".loader").css("transform", 'scale(0)'); 
            alert('An error has occurred');
        }
    }); 
}

jQuery(document).ready(function() {
    jQuery(document).on('click','.deleteModal',function(){
        propertyID = $(this).data('property_id');
        jQuery(this).siblings('.modalDelete'+propertyID).addClass('open1').after('<div class="modal-overlay" style="z-index: 1002; display: block; opacity: 0.5;"></div>');
        jQuery('.modal').modal();
    });

    jQuery(document).on('click','.share',function(){
        propertyID = $(this).data('property_id');
        jQuery(this).siblings('#sharelisting'+propertyID).addClass('open1').after('<div class="modal-overlay" style="z-index: 1002; display: block; opacity: 0.5;"></div>');
        jQuery('#sharelisting'+propertyID).addClass('open1').after('<div class="modal-overlay" style="z-index: 1002; display: block; opacity: 0.5;"></div>');
        jQuery('.modal').modal();
    });

    jQuery(document).on('click','.modal-close',function(){
        jQuery(this).parents('.modal').removeClass('open1').hide();
        jQuery('.modal-overlay').hide();
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

$(document).on('click','.addnewEm',function(){
    $('.hiddenAdemail').show();
    $(this).hide();
});

$("#forgot_frm").validate({
    errorPlacement: function (error, element) {
        error.css('color', 'red');
        error.insertAfter(element);
    },
    rules: {
        resetemail: {
            required: true,
            email: true
        },
    },
    messages: {
        resetemail: {
            required: 'Email is required.',
            email: 'Please enter a valid email address'
        },
    }

}); 

$("#forgot_frm").on('submit',function(){
    var current=$(this);
    $(".signup_error").hide();
    $(".signup_success").hide();
    if($("#forgot_frm").valid()){
        $('body').append(loader_ajax);
        $.ajax({
            type:'POST',
            url:baseUrl+'/user/sendForgotMail',
            data: new FormData($(this)[0]),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success:function(res){
                $('.loader_outer').remove();
                if(res.status == 1){
                    current.find('input').val(''); 
                    $(".signup_success strong").html("Reset password link has been sent to your registered Email ID");
                    $(".signup_success").show();
                }else if(res.status == 2){
                    $(".signup_error strong").html("No such user exist");
                    $(".signup_error").show();
                }else{
                    $(".signup_error strong").html("Something went wrong. Please contact site admin");
                    $(".signup_error").show();
                }
            }
        }); 
    }
});

/*To get the email preferences settings*/
$(document).on('click','.switches',function(){
    var option = $(this).data('option');
    var checked = 0;
    if ($(this).is(':checked')) {
        checked = 1;
    }
    $.ajax({
        url: baseUrl+ 'notification',
        type: 'post',
        dataType: 'json',
        data : {option:option,checked:checked},
        success: function (data) {
        },
    });
});

/*for archive*/
$(document).on('click','.hideSvg',function(){
    var hide = $(this).siblings('a').data('property_id');
    $.ajax({
        url: baseUrl+ 'property/archiveProperty',
        type: 'post',
        dataType: 'json',
        data : {hide:hide},
        success: function (data) {
            if(data.status == 1){
                searchProperty();
            }
        },
    });
});