var last_id=0;
var site_url = 'https://www.workadvisor.co/';
var last_IDS=$('#Last_post_id').val();
$(document).ready(function() {
    // $('#messageTextarea').keypress(function(event) {
    //     if (event.which == 13) {
    //         event.preventDefault();
    //     }
    // });
    
  var base_url = $('#base_url').val();

  $("#profile_form_modal").submit(function(event){
    event.preventDefault(); 
    var post_url = $(this).attr("action");
    var request_method = $(this).attr("method"); 
    var form_data = $(this).serialize(); 
    $.ajax({
      url : post_url,
      type: request_method,
      data : form_data,
      dataType : 'json',
      success: function (data) {
        if(data.status == 1){
          $('#basic_information').removeClass("fade").modal("hide");
          $('#skills').addClass("fade").modal("show");
        }
      }
    });
  });
if ($(window).width() < 767) {
  $(window).scroll(function() {
    if($(window).scrollTop() == $(document).height() - $(window).height()) {
      last_id = $(".post-id:last").attr("id");
      // alert(last_id);
      var user_id =$(".post-id:last").attr("data-uid");
      loadMoreData(last_id,user_id);
    }
  });
}else{
  $(window).scroll(function() {
    if($(window).scrollTop()+$(window).height() == $(document).height()) {
      last_id = $(".post-id:last").attr("id");
      var user_id =$(".post-id:last").attr("data-uid");
      loadMoreData(last_id,user_id);
    }
  });
}

$(document).on('click', '.view_type', function(e) {
  var id = $(this).attr('data-vid');
  var file_folder = $(this).attr('data-views');
  var view_type =  $(this).val();
  var base_url = $('#base_url').val();
  $.ajax({
      type: "POST",
      dataType: "json",
      url: base_url+'profile/changeViewAccess',
      data: {id:id,view_type:view_type,file_folder:file_folder},
      success: function (data) {
        if(data.status == 1){
          $('#fileSuccess').html(data.html);
        }
      }
   });
});
/****************SEARCH TAGS********************/

  $('#searchTags').keyup(function(){  
    var query = $(this).val();  
    if(query.length > 2){
      $.ajax({  
        url:site_url+"/home/autofill/",  
        method:"POST",  
        data:{query:query},  
        success:function(data)  
        {  
          $('#tagList').fadeIn();  
          $('#tagList').html(data);  
        }  
      });  
    }else{
      $('#tagList').fadeOut();   
    } 
  });  
  $(document).on('click', '.tgli', function(){
    $('#searchTags').val($(this).text());  
    $('#tagList').fadeOut();  
  }); 

  $('#review_filter').change(function(){
    var filter = $(this).val();
    $.ajax({
      url: site_url+'/user/reviewFilter',
      type: "post",
      data : {filter:filter},
      success: function(result){
        $('#filter_data').html(result);
      }
    });
  });

$('#searchName').keyup(function(){
  var search = $(this).val();
  var base_url = $('#base_url').val();
  $.ajax({
      type: "POST",
      dataType: "html",
      url: base_url+'user/searchName',
      data: {search:search},
      success: function (data) {
        $('#friendsList').html(data);
        $.ajax({
      type: "POST",
      dataType: "html",
      url: base_url+'user/searchMsg',
      data: {search:search},
      success: function (data) {
        $('#indivisualChatBox').html(data);
      }
   });
      }
   });
  
    
});
var rate_id = 0;
$('.reply_').click(function(){
  rate_id = $(this).attr('data-reply_id');
  
});

$('.send_reply').click(function(){
  var reply = $('#reply').val();
  var history = $('#history').val();
   $.ajax({
    url:site_url+"/user/replyToReview",  
    method:"POST",  
    dataType:'json',
    data:{rate_id:rate_id,reply:reply,history:history},  
    success:function(data){
      if(data.status == '1'){
        location.reload();
      }
    }  
  });
});

});

function loadMoreData(last_id,userId){
// alert(44);
    $('.scrol_loding').show();
    $(".scrol_loding").delay(2000).hide(100);
    $.ajax({
        url: site_url+'/profile/postByLimit/5/'+last_id+'/'+userId,
        type: "get",
        success: function(result){
            if(result==""){
                $('#lastresponse').html('No More Result Found.');
                $('.scrol_loding').hide();
            }
      // if(last_IDS==last_id){
      // $('#Last_post_id').val(0);
      // }else{
            $('.scrol_loding').hide();
            $(".userposts").append(result);
      //}
        }
    });
}

$('#owl-shu').owlCarousel({
  loop: false,
  margin: 0,
  nav: true,
  responsive: {
    0: {
      items: 1
    },
    600: {
      items: 3
    },
    1000: {
      items: 5
    }
  },
  navText: ["<i class='fa fa-angle-left' aria-hidden='true'></i>", "<i class='fa fa-angle-right' aria-hidden='true'></i>"]
})
$('#advanse').owlCarousel({
  loop: true,
  margin: 50,
  nav: true,
  responsive: {
    0: {
      items: 1
    },
    600: {
      items: 3
    },
    1000: {
      items: 4
    }
  },
  navText: ["<i class='fa fa-angle-left' aria-hidden='true'></i>", "<i class='fa fa-angle-right' aria-hidden='true'></i>"]
})
var public_live_key = $('#public_live_key').val();
// alert(public_live_key);
Stripe.setPublishableKey(public_live_key);
  $(function() {
    var $form = $('#payment-form');
    $form.submit(function(event) {
    $form.find('.submit').prop('disabled', true);
    Stripe.card.createToken($form, stripeResponseHandler);
    return false;
    });
  });

  function stripeResponseHandler(status, response) {
    var $form = $('#payment-form');
  
    if (response.error) {
    $form.find('.payment-errors').text(response.error.message);
    $form.find('.submit').prop('disabled', false); // Re-enable submission
  
    } else {
    var token = response.id;
    $form.append($('<input type="hidden" name="stripeToken">').val(token));
    $form.get(0).submit();
    }
  };

  function selectPromoteType(type){
    if(type == 'date'){
      $('#promote_type').val('date');
    }else if(type == 'option'){
      $('#promote_type').val('option');
    }
  }




/*****************************LOADMORE*********************/


$(document).ready(function() {
  $('.post_add').click(function(){
  //$(this).hide();
  $(this).addClass('post_loader');
});

  $('.scrol_loding').hide();
  var review_modal = $('#review_modal').val();
  if(review_modal == 1){
    $('#myModal5').modal('show');
  }

  $(".gr-lst-vie").on("click",function(){
  if($(this).attr('tp') == 'grid') {
    if(!$("#fileSuccess").hasClass('grid')) {
      $("#fileSuccess").addClass('grid');
      $("#fileSuccess").removeClass('list');
    }
  } else {
     $("#fileSuccess").removeClass('grid');
     $("#fileSuccess").addClass('list');
  }
})
selectPromoteType('option');
var user_login_type = $('#user_login_type').val();
if(user_login_type == 'performer' || user_login_type == 'employer'){
  $('#basic_information').modal('show');
}else{
  $('#basic_information').modal('hide');
}

$('#team_salary').dataTable();
$('#start_date').datepicker({
  minDate: 0,
  //dateFormat: 'yy-mm-dd',
  beforeShow: function() {
    $(this).datepicker('option', 'maxDate', $('#end_date').val());
  }
});
$('#end_date').datepicker({
 // dateFormat: 'yy-mm-dd',
  beforeShow: function() {
    $(this).datepicker('option', 'minDate', $('#start_date').val());
    if ($('#start_date').val() === '') $(this).datepicker('option', 'minDate', 0);
  }
});

  jQuery('body').on('click', '.p_clickments', function(){
    $('.team_Spaymetns').addClass('openpayTs');
  })
  
  $('.icon_fclick').click(function(){
    $(this).toggleClass('fclickopenF');
    $('.history_cont').toggleClass('hcontopen');
  });
  $('body').on('click', '.history_cont.hcontopen a', function(){
    $('.history_cont').removeClass('hcontopen');
    $('.icon_fclick').removeClass('fclickopenF');
  });
var vids = $("#videos"); 
$.each(vids, function(){
  this.controls = true; 
  this.autoplay = false;
  this.controlsList="nodownload";
  this.preload="none";
  this.loop="loop";
}); 

$(".fancybox").fancybox({
  'padding'       : 0,
  'autoScale'     : false,
  'transitionIn'  : 'none',
  'titleShow'     : false,
  'showCloseButton': true,
  'titlePosition' : 'inside',
  'transitionOut' : 'none',
  'title'         : '',
  'width'         : 640,
  'height'        : 385,
  'href'          : this.href,
  'type'          : 'iframe',
  'helpers'     : { 
  'overlay' : {'closeClick': false}
  }
});

  newNotifications();
  $('#ratings .stars label.star').click(function(){
    var fhg = $(this).parent('.stars').find('input').next().removeClass('feelin');
  });

  $('.searchnoxx').hide();
  $('#servh_scc').click(function() {
    $('.searchnoxx').toggle();
  });
});


/***********************WEBSITE**********************/ 
$(document).ready(function(){
  $('#cnewpassword').on('keyup', function(){
    var pw1 = $('#cnewpassword').val();
    var pw2 = $('#newpassword').val();
    if (pw2.length < 6) {
      $('#message1').html('Password Must Be 6 digit length').css('color', 'red');
      return false;
    } else {
      $('#message1').html(' ');
    }
    if (pw1 == pw2) {
      $('#message1').html('Password matched').css('color', 'green');
    } else {
      $('#message1').html('Password not matched').css('color', 'red');
    }
  });
  // $('.zip').keyup(function() {
  //   alert("yes");
  //   // var len = $.trim(this.value).match(/\d/g).length;
  //   // if (len >= 5 && len <= 7) {
  //   //   getGeo();
  //   // }
  // });
  $('#servh_scc').click(function() {
    $('.searchnoxx input').slideToggle();
  });
  $('body').on('click', '.removetag', function() {
    $(this).parent().remove();
  });
  $(".bar-one .bar").progress();
  $(".bar-two .bar").progress();
  $(".bar-three .bar").progress();
}); /************/
// function getGeo(e) {
//   var zipnew = document.getElementById('zip').value;
//   var base_url = $('#base_url').val();
//   $.ajax({
//       type: "POST",
//       dataType: "json",
//       url: base_url+'user/getZipLocation',
//       data: {zip:zipnew},
//       success: function (data) {
//         if(data.city)
//           $('#city').val(data.city);
//         if(data.state)
//           $('#state').val(data.state);
//         if(data.country){
//           $('.countrys').val(data.country);
//         }
//         // if(data.status == 1){
//         //   $('#fileSuccess').html(data.html);
//         // }else{
//         //   $('#fileSuccess').html('<div class="alert alert-danger">No data found</div>');
//         // }
//       }
//    });
  // var x = new XMLHttpRequest();
  // x.open("GET", "https://maps.googleapis.com/maps/api/geocode/json?address=" + zipnew, true);
  // x.send();
  // x.onreadystatechange = function(){
  //   if (this.readyState == 4 && this.status == 200) {
  //     var o = this.response;
  //     var city = JSON.parse(this.response).results[0].address_components[1].long_name;
  //     var state = JSON.parse(this.response).results[0].address_components[2].long_name;
  //     var country = JSON.parse(this.response).results[0].address_components[3].long_name;
  //     if (city) {
  //       document.getElementById('city').value = city;
  //     }
  //     if (state) {
  //       document.getElementById('state').value = state;
  //     }
  //     if (country) {
  //       document.getElementById('country').value = country;
  //     }
  //   }
  // }
//} /******************/
function resetImage(input) {
  input.value = '';
  input.onchange();
}

function readImage(input) {
  var receiver = input.nextElementSibling.nextElementSibling;
  input.setAttribute('title', input.value.replace(/^.*[\\/]/, ''));
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      receiver.style.backgroundImage = 'url(' + e.target.result + ')';
    };
    reader.readAsDataURL(input.files[0]);
  } else receiver.style.backgroundImage = 'none';
}
/******************/
//$(window).on('load', function() {
//    $(".loader").css("transform", 'scale(0)');
// });
/******************/

function saveData(formId,action_url,responseDiv,errorDivId){
  formId = '#'+formId;
  emtyp_var = true;
  jQuery(formId).find(".input_error_msg").css("display","none");
  jQuery(formId+" .check_empty").each(function(){
    if(jQuery(this).val() == '') {
      jQuery(this).remove();
      jQuery(this).parent().find(".input_error_msg").css("display","block");
      jQuery(this).focus();
      emtyp_var = false;
      return false; 
    }
  })
  if(emtyp_var){
    var formData = new FormData(jQuery(formId)[0]);
    $(".loader").css("transform", 'scale(1)');
    $.ajax({
      url: action_url,
      data: formData,
      type: 'POST', 
      processData: false, 
      contentType: false,
      success: function (res) {
        $(".loader").css("transform", 'scale(0)');
        var res = jQuery.parseJSON(res);
        //alert(res.status);
        if(res.status == 'success'){
          $('#'+errorDivId).hide();
          if(responseDiv=='newconversation'){
            $('#conversation').append(res.msg); 
          }else if(responseDiv == 'messageBox'){
            $('#ratings_').html('<div class="alert alert-success">Changes saved successfully</div>');
            setTimeout(function(){
              $('#myModal5').modal('hide');
            }, 7000);
            //location.reload();
            window.location = window.location.href.split("?")[0];
          }else{
            setTimeout(function(){
              $('#success_post').html('<div class="alert alert-success">Changes saved successfully</div>');
            }, 7000);
            location.reload();
            //$('#'+responseDiv).html(res.msg);
            window.location = window.location.href.split("?")[0];
          }

        } 
        else if(res.status == 'successful_post'){
          location.reload();
        }
        else {
          if(res.status=='Failed' && res.msg=='Login first'){
            $('#LoginModal').modal('show');
          }

          $('#'+errorDivId).show();
          $('#'+errorDivId).html(res.msg);
        }

        if(formId=='#sendMessage'){
          jQuery(formId).find("input[type=text],input[type=file], input[type=email],input[type=password],textarea").val(""); 
//jQuery('#conversation').scrollTop(jQuery('#conversation')[0].scrollHeight);
var scrollBottom = $('#conversation').scrollTop() + $('#conversation').height();
jQuery('#conversation').animate({scrollTop:scrollBottom}, 'slow');
}else{
  jQuery(formId).find("input[type=text],input[type=file],input[type=hidden], input[type=email],input[type=password],textarea").val(""); 
  jQuery('html, body').animate({scrollTop:0}, 'slow');
}
jQuery(formId).find('select').prop('selectedIndex',0);

if($('#myModal').length>0){
  $('#myModal').modal('hide');
  $('.my_upload_pics_t > input[type="hidden"]').remove();
  $('.my_upload_pics_t > .s').remove();
}
if($('#myModal2').length>0){
  $('#myModal2').modal('hide');
  $('.my_upload_pics_t > input[type="hidden"]').remove();
  $('.my_upload_pics_t > .s').remove();
}
},
error:function(){
  $(".loader").css("transform", 'scale(0)'); 
  alert('An error has occurred');
}
});
  } 
}
/***********************ENTER-TO-SEND-MESSAGE**********/
// function sendOnKeyup(e){
//   if (e.keyCode == 13) {
//     $("#SendMessageButton").trigger('click');
//     return false;
//   }
// }
/********************************/
// $(window).scroll(function() {
//   var hT = $('#main_with').offset().top,
//   hH = $('#main_with').outerHeight(),
//   wH = $(window).height(),
//   wS = $(this).scrollTop();
//   console.log((hT-wH) , wS);
//   if (wS > (hT+hH-wH)){
//     var last_id = $(".post-id:last").attr("id");
//     var user_id =$(".post-id:last").attr("data-uid");
//     loadMoreData(last_id,user_id);
//   }
// });

/*****
 if ($(window).width() < 767) {

$('#main_with').on('scroll', function() {
  if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
 
       var last_id = $(".post-id:last").attr("id");
       var user_id =$(".post-id:last").attr("data-uid");
       loadMoreData(last_id,user_id);

}
})

}else{
$(window).scroll(function(){
  // if($(window).scrollTop() + $(window).height() >= $(document).height()) {
    if($(window).scrollTop() == $(document).height() - $(window).height()) {
    var last_id = $(".post-id:last").attr("id");
    var user_id =$(".post-id:last").attr("data-uid");
    loadMoreData(last_id,user_id);
  }
});
} 

**************/
// $(window).scroll(function(){
//   // if($(window).scrollTop() + $(window).height() >= $(document).height()) {
//     if($(window).scrollTop() == $(document).height() - $(window).height()) {
//     var last_id = $(".post-id:last").attr("id");
//     var user_id =$(".post-id:last").attr("data-uid");
//     loadMoreData(last_id,user_id);
//   }
// });
/***************LOAD MORE DATA *****************/	
// function loadMoreData(last_id,userId){
//   $.ajax({
//     url: site_url+'/profile/postByLimit/5/'+last_id+'/'+userId,
//     type: "get",
//     beforeSend: function()
//     {
//       $('.scrol_loding').show();
//       $(".scrol_loding").delay(2000).hide(400);
//     }
//   })
//   .done(function(data){
//     $('.scrol_loding').hide();
//     if(data==""){
//       $('#lastresponse').html('No More Result Found.');
//       $('.scrol_loding').hide();
//     }
//     $('.scrol_loding').hide();
//     $(".userposts").append(data);
//   });
//   // .fail(function(jqXHR, ajaxOptions, thrownError)
//   // {
//   //   alert('server not responding...');
//   // });
// }


  
/*************************************/
var placeSearch, autocomplete;
var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};

function initAutocomplete() {
  autocomplete = new google.maps.places.Autocomplete(
    (document.getElementById('autocomplete')),
    {types: ['geocode']});
  autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
  var place = autocomplete.getPlace();

  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
    }
  }
}

function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle({
        center: geolocation,
        radius: position.coords.accuracy
      });
      autocomplete.setBounds(circle.getBounds());
      var lattitude=geolocation.lat;
      var longitude=geolocation.lng;
      initialize();
      codeLatLng(lattitude, longitude)


    });
  }
}
function initialize() {
  geocoder = new google.maps.Geocoder();
}  
/******************************************/
function codeLatLng(lat, lng) {
  var latlng = new google.maps.LatLng(lat, lng);
  geocoder.geocode({'latLng': latlng}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      if (results[1]) {
        for (var i=0; i<results[0].address_components.length; i++) {
          for (var b=0;b<results[0].address_components[i].types.length;b++) {
            if (results[0].address_components[i].types[b] == "locality") {
              city= results[0].address_components[i];
              break;
            }
          }
        }
        //$('#autocomplete').val(city.long_name);
        //$('#locality').val(city.long_name);

      } else {
       // alert("No results found");
      }
    } else {
      alert("Geocoder failed due to: " + status);
    }
  });
}
/**************CHECK BLANK*************/
function checkBlank(){
  var searchTags= $('#searchTags').val();
  var city= $('#autocomplete').val();
  var locality= $('#locality').val();
  if(searchTags==""){
    $('#searchTags').css('border','1px solid red');
    $('#searchTags').focus();
    return false;
  }

}	
/*****************************/
$(document).ready(function(){
  if(window.File && window.FileList && window.FileReader) {
    $(".files").on("change",function(e) {
      _this = jQuery(this);
      jQuery('.alrdy_pic > img').hide();

      var files = e.target.files ,
      filesLength = files.length ;
      for (var i = 0; i < filesLength ; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {

          var file = e.target;
          // htmlele = "<div class='s'><img class='imageThumb' src='"+e.target.result+"' title='"+f.name+ "'></img><span onclick=remove(this)><i class='fa fa-close'></i></span></div><input type='hidden' name='post_images[]' value='"+e.target.result+"' >"; 
           htmlele = "<div class='s'><img class='imageThumb' src='"+e.target.result+"' title='"+f.name+ "'></img><span onclick=remove(this)><i class='fa fa-close'></i></span></div>"; 
          _this.parents(".tabsupphoto").find(".my_upload_pics_t .img_div").before(htmlele);
        });
        fileReader.readAsDataURL(f);
      }
    });
  } else { alert("Your browser doesn't support to File API") }

});
function remove(r) {
  _this = jQuery(r);
  _this.closest(".s").remove();
}
$( ".img_upload_label" ).click(function() {
  $( ".my_plus_i89" ).css('display', 'block')
});
/****************************/
function addfriend(userid,abc){
  _this=$(abc);
  $.ajax({
    url:site_url+"/user/addfriend/",  
    method:"POST",  
    data:{userid:userid},  
    success:function(data){
      var data = jQuery.parseJSON(data);
      if(data.status==1){
        //var nht='<i class="fa fa-check"></i> <a href="javascript:void(0)" >Request Sent</a>';
        var nht='Request Sent';
        _this.html(nht); 
      }else{
        if(data.msg=='Login first'){
          $('#LoginModal').modal('show');
        }
        else if(data.msg=='Request Pending'){
          //var nht='<i class="fa fa-check"></i> <a href="javascript:void(0)" >Request Pending</a>';
          var nht='Request Pending';
          _this.html(nht);
        }else{
          // var nht='<i class="fa fa-check"></i> <a href="javascript:void(0)" >'+data.msg+'</a>';
          var nht=data.msg;
          _this.html(nht);
        }


      }
    }  
  }); 

}
/****************_FRIEND-REQUEST_**************/

function friendRequest(userid,fstatus,resp){
  $.ajax({
    url:site_url+"/user/requestStatus/",  
    method:"POST",  
    data:{userid:userid,status:fstatus},  
    success:function(data){
      var data = jQuery.parseJSON(data);
      if(data.status==1){
        $('#'+resp).hide();
        window.location.reload();
      }else if(data.status==1 && data.msg=='Login first'){
        $('#LoginModal').modal('show'); 
      }else{
        $('#'+resp).hide(); 
      }
    }  
  }); 

}
/***************_JOB-REQUEST_**************/
function sendJobRequest(userid,abc,emp=false){
  _this=$(abc);
  $.ajax({
    url:site_url+"/user/sendjobrequest/",  
    method:"POST",  
    data:{userid:userid,emp:emp},  
    success:function(data){
      var data = jQuery.parseJSON(data);
      if(data.status==1){
        var nht='<i class="fa fa-check"></i> Request Sent';
        _this.html(nht); 
      }else{
        if(data.msg=='Login first'){
          $('#LoginModal').modal('show');
        }
        else if(data.msg=='Request Pending'){
          var nht='<i class="fa fa-check"></i> Request Pending</a>';
          _this.html(nht);
        }else{
          var nht='<i class="fa fa-check"></i> '+data.msg;
          _this.html(nht); 
        }


      }
    }  
  }); 
}
function jobRequest(userid,fstatus,resp,abc,per=false){
  _this=$(abc)
  $.ajax({
    url:site_url+"/user/jobrequeststatus/",  
    method:"POST",  
    data:{userid:userid,status:fstatus,per:per},  
    success:function(data){
      var data = jQuery.parseJSON(data);
      if(data.status==1){
        _this.hide();
        if($('#'+resp).length>0){
          $('#'+resp).hide(); 
        }
      }else if(data.status==1 && data.msg=='Login first'){
        $('#LoginModal').modal('show'); 
      }else{
        _this.hide();
        if($('#'+resp).length>0){
          $('#'+resp).hide(); 
        }
      }
    }  
  }); 

}
/******************Notifications************************/
function notifyMe(ntfytitle,message,returnurl) {
  if (Notification.permission !== "granted")
    Notification.requestPermission();
  else{
    var notification = new Notification(ntfytitle, {
      icon: 'https://webandappdevelopers.com/workadviser_ci/assets/images/profl.png',
      body: message,
    });
    notification.onclick = function () {
      window.location.href=returnurl;      
    };
  }
}
/******************Notifications************************/
function checkNotification(){
  $.ajax({
    type:'POST',
    url:site_url+'/user/checknotification',
    data: {mdt:'news'},
    dataType: 'json',
    success:function(res){
      if(res.result==1){
        var message=res.msg;	
        var notifyTitle=res.title;	
        var rurl=res.returl;	
        notifyMe(notifyTitle,message,rurl);
        if (res.type=='MESSAGE'){
          if($('#conversation').length>0){
            if($("#conversation").attr("data-id")==res.usId){	
              $("#conversation").append(res.msView);
              var scrollBottom = $('#conversation').scrollTop() + $('#conversation').height();
              jQuery('#conversation').animate({scrollTop:scrollBottom}, 'slow');
            }
          }
          if($('#latestMessage_'+res.usId).length>0){
            $('#latestMessage_'+res.usId).html(res.msg);
            $('.serch_profile').find(".chatuser").removeClass('activechat');
            $('#friendlistmenu'+res.usId).addClass('activechat');
          }

          if($('#latestMessageCount_'+res.usId).length>0){
            var valc =$("#latestMessageCount_"+res.usId).html();
            var counts1=Number(valc);
            var n=Number(counts1)+1;
            $("#latestMessageCount_"+res.usId).addClass('cuircl2');
            $("#latestMessageCount_"+res.usId).html(n);
          }


        }
      } 
    }
  });
}
/***********************GET-Indivisul-MSG***************************/
function getIndivisualMsg(userid){
  $('.serch_profile').find(".chatuser").removeClass('activechat');	
  $.ajax({
    type:'POST',
    url:site_url+'/user/indivisualMessage',
    data: {userid:userid},
    dataType: 'json',
    success:function(res){
      $('#indivisualChatBox').html(res.msg);
      $('#friendlistmenu'+res.userid).addClass('activechat');
      $("#latestMessageCount_"+res.userid).html('');
      $("#latestMessageCount_"+res.userid).removeClass('cuircl2');
	  autoscrollnow('conversation');
    },
    error:function(){
      $(".loader").css("transform", 'scale(0)'); 
      alert('An error has occurred');
    }
  });	

}


var record = 0;
function setID(id){
  $('#record_id').val(id);
}

/***********Delete Data**********/
function deleteData(){
  var record =  $('#record_id').val();
  var folderrecord_id =  $('#folderrecord_id').val();
  var delete_url = $('#delete_url').val();
  var table_name = $('#table_name').val();
  $.ajax({
    type:'POST',
    url:delete_url,
    data: {record:record,table_name:table_name,folderrecord_id:folderrecord_id},
    dataType: 'json',
    success:function(res){
      if(res.status == 1)
        $('#success').html('<div class="alert alert-success">Record deleted successfully</div>');
      location.reload();
    },
    error:function(){
      $(".loader").css("transform", 'scale(0)'); 
      alert('An error has occurred');
    }
  }); 
}

function deleteMessage(){
  var sender =  $('#record_id').val();
  var receiver =  $('#current_user').val();
  var delete_url = $('#delete_url').val();
  $.ajax({
    type:'POST',
    url:delete_url,
    data: {sender:sender,receiver:receiver},
    dataType: 'json',
    success:function(res){
      if(res.status == 1)
        $('#success').html('<div class="alert alert-success">Message deleted successfully</div>');
      location.reload();
    },
    error:function(){
      $(".loader").css("transform", 'scale(0)'); 
      alert('An error has occurred');
    }
  }); 
}
/***********Delete Album Data**********/
function deleteAlbumData(){
  var record =  $('#record_id').val();
  var delete_url = $('#delete_album_url').val();
  $.ajax({
    type:'POST',
    url:delete_url,
    data: {record:record},
    dataType: 'json',
    success:function(res){
      if(res.status == 1){
       $('#success_').html('<div class="alert alert-success">Document deleted successfully</div>');
		   setTimeout(function(){
			$('#modalAlbumDelete').modal('hide');
			$('#success_').html('');
		  }, 3000);
       $('#fileSuccess').html(res.html);
     }
   }
 }); 
} 
/** delete album folder data */

function deleteAlbumfolderData() {
	var base_url = $('#base_url').val();
  var record =  $('#record_id').val();
  var folderrecord_id =  $('#directoryId').val();
  var delete_url = $('#delete_album_url').val();
  $.ajax({
    type:'POST',
    url:base_url+"profile/deleteAlbumfolderData",
    data: {record:record,folderrecord_id:folderrecord_id},
    dataType: 'json',
    success:function(res){
      if(res.status == 1){
       $('#success1_').html('<div class="alert alert-success">Document deleted successfully</div>');
        setTimeout(function(){
        $('#foldermodalAlbumDelete').modal('hide');
        $('#success1_').html('');
      }, 3000);
       $('#fileSuccess').html(res.html);
     }
   }
 }); 
}


$('#file').change(function(){
  var height = $(this).height();
  var width = $(this).width();
  if(width<400){

  }
});



/***********Edit Post**********/
function editPost(postID){
  $('#modalEdit').html('');
  var base_url = $('#base_url').val();
  $.ajax({
    type:'POST',
    url:base_url+"profile/editPost",
    data: {id:postID},
    dataType: 'html',
    success:function(res){
      $('#modalEdit').html(res);
      $('#myModal2').modal('show');
    },
    error:function(){
      $(".loader").css("transform", 'scale(0)'); 
      alert('An error has occurred');
    }
  }); 
}

/***********mail-img click**********/
// $(document).ready(function(){
//     $(".mail-img-click").on('click', function(){
//         //$(".inner-mailbox").slideToggle();\
//         var base_url = $('#base_url').val();
//         $.ajax({
//           type:'POST',
//           url:base_url+"user/getMails",
//           data: {},
//           dataType: 'html',
//           success:function(res){
//             //$('#modalEdit').html(res);
//             //$('#myModal2').modal('show');
//             $(".inner-mailbox").html(res);
//           },
//           error:function(){
//             $(".loader").css("transform", 'scale(0)'); 
//             alert('An error has occurred');
//           }
//         }); 
//     });
// });
/***********mail-img click**********/

function addMore(type){
  $('#friend_invitation'+type).append('<div class="form-group"><input type="text" name="emails[]" class="form-control" placeholder="Enter your Invite email"></div>');
}

setInterval(function () {
  newNotifications();
}, 4000); // Execute somethingElse() every 2 seconds.

function newNotifications(){
 $.ajax({
  type:'POST',
  url:site_url+'/user/newNotifications',
  data: {},
  dataType: 'json',
  success:function(res){
    if(res.count>0){
        //$('.notification_modal').html(res.html);
        $('#notifications_ul').html(res.html);
        $('.notification_bell').html(res.count);
      }else{
        $('.notification_bell').html(0);
        $('#notifications_ul').html(res.html);
      }
    }
  });
}

function setFriendID(id){
  $('#friend_id').val(id);
  $('#leave_job').val(id);
}

function unfriend(){
  var record =  $('#friend_id').val();
  var unfriend_url = $('#unfriend_url').val();
  $.ajax({
    type:'POST',
    url:unfriend_url,
    data: {record:record},
    dataType: 'json',
    success:function(res){
      if(res.status == 1)
        $('#success1').html('<div class="alert alert-success">Unfriend successful</div>');
      location.reload();
    },
    error:function(){
      $(".loader").css("transform", 'scale(0)'); 
      alert('An error has occurred');
    }
  }); 
}

function leaveJob(){
  var record =  $('#leave_job').val();
  var leave_job_url = $('#leave_job_url').val();
  $.ajax({
    type:'POST',
    url:leave_job_url,
    data: {record:record},
    dataType: 'json',
    success:function(res){
      if(res.status == 1)
        $('#success2').html('<div class="alert alert-success">Job left successfully</div>');
      location.reload();
    },
    error:function(){
      $(".loader").css("transform", 'scale(0)'); 
      alert('An error has occurred');
    }
  }); 
}

// $('.qr_code1').click(function(){
//   var src = $(this).attr('src');
//   var uname = $('#uname').val();
//   var uemail = $('#uemail').val();
//   $('#qr_code_modal').modal('show');
//   $('.qr_modal').html('<img src="'+src+'"><ul><li>'+uname+'</li></ul><input type="button" class="btn btn-info" id="btnPrint" value="Print">');
// })

$('.bell').click(function(){$('#notifications_ul').toggle();});


$(document).ready(function(){
  $(document).on('click', '#btnPrint', function(){
    //$('#printThis').printElem();
    var uname = $('#uname').val();
    // $('#qrCodeImg').append('<ul><li>'+uname+'</li></ul>');
    $('#qrCodeImg').printElem();
  });
});

jQuery.fn.extend({
  printElem: function() {
    var cloned = this.clone();
    var printSection = $('#printSection');
    if (printSection.length == 0) {
      printSection = $('<div id="printSection"></div>')
      $('body').append(printSection);
    }
    printSection.append(cloned);
    var toggleBody = $('body *:visible');
    toggleBody.hide();
    $('#printSection, #printSection *').show();
    window.print();
    printSection.remove();
    toggleBody.show();
  }
});

//search filters
function searchFilter(){
  var base_url = $('#base_url').val();
  var form=$("#searchfilter1");
  
  $.ajax({
    type: "POST",
    dataType: "html",
    url: base_url+'search/searchFilter',
    data: form.serialize(),
    processData: false,
    success: function(data)
    {
      $('.Donald').html(data);
    }
  });
}

$.fn.fileUploader = function (filesToUpload, sectionIdentifier) {
  var fileIdCounter = 0;
  this.closest(".files").change(function (evt) {
    var output = [];
    for (var i = 0; i < evt.target.files.length; i++) {
      fileIdCounter++;
      var file = evt.target.files[i];
      var fileId = sectionIdentifier + fileIdCounter;

      filesToUpload.push({
        id: fileId,
        file: file
      });
      var removeLink = "<a class=\"removeFile\" href=\"#\" data-fileid=\"" + fileId + "\">Remove</a>";

      output.push("<li><strong>", escape(file.name), "</strong> - ", file.size, " bytes. &nbsp; &nbsp; ", removeLink, "</li> ");
    };

    $(this).children(".fileList")
    .append(output.join(""));
    evt.target.value = null;
  });

  $(this).on("click", ".removeFile", function (e) {
    e.preventDefault();
    var fileId = $(this).parent().children("a").data("fileid");
    for (var i = 0; i < filesToUpload.length; ++i) {
      if (filesToUpload[i].id === fileId)
        filesToUpload.splice(i, 1);
    }
    $(this).parent().remove();
  });
  this.clear = function () {
    for (var i = 0; i < filesToUpload.length; ++i) {
      if (filesToUpload[i].id.indexOf(sectionIdentifier) >= 0)
        filesToUpload.splice(i, 1);
    }
    $(this).children(".fileList").empty();
  }
  return this;
};
$(document).ready(function() {
  var filesToUpload = [];

  var files1Uploader = $("#files1").fileUploader(filesToUpload, "files1");
  
  
  $("#uploadBtn").click(function (e) {
	   e.preventDefault();
	directoryid ='';
	directoryid = jQuery("#directoryId").val();
	
	var view_type = $('#view_type').val();
   
    var formData = new FormData();
    for (var i = 0, len = filesToUpload.length; i < len; i++) {
      formData.append("files[]", filesToUpload[i].file);
    }  
	formData.append('directoryid',directoryid);
    var base_url = $('#base_url').val();
    var form = $("#fileupload");
    $.ajax({
      type: "POST",
      dataType: "json",
      url: base_url+'profile/uploadDocFiles',
      data: formData,
      async: false,
      cache: false,
      contentType: false,
      enctype: 'multipart/form-data',
      processData: false,
      success: function (data) {
        if(data.status == 1){ 
          files1Uploader.clear();
		  if(data.adddingType == 'Direct') {
			  $('#fileSuccessmain').html(data.html);
		  } else {
			  $('#fileSuccessDir').html(data.html); 
		  }
        }
        if(data.status == 0)
          $('#fileSuccess').html('<div class="alert alert-danger">No Files To Upload</div>');
        },
        error: function (data) {
              //alert("ERROR - " + data.responseText);
        }
        });
  });
});


//get current location
function currLocation(){
 $.ajax({
            url: "https://geoip-db.com/jsonp",
            jsonpCallback: "callback",
            dataType: "jsonp",
            success: function( location ) {
                $('#autocomplete').val(location.city);
                // $('#country').val(location.country_name);
                // $('#administrative_area_level_1').val(location.state);
                $('#locality').val(location.city);
                // $('#latitude').val(location.latitude);
                // $('#longitude').val(location.longitude);
                // $('#ip').val(location.IPv4);  
            }
        });  
}

function reportProfile(userID,name){
  var base_url = $('#base_url').val();
  $.ajax({
      type: "POST",
      dataType: "json",
      url: base_url+'viewdetails/reportProfile',
      data: {userID:userID,name:name},
      success: function (data) {
        if(data.status == 1){
          $('#success').html('<div class="alert alert-success">Profile reported successfully</div>');
            setTimeout(function(){
              $('#modalReport').modal('hide');
              $('#success').html('');
            }, 3000);
        }else{
          if(data.status=='Failed' && data.msg=='Login first'){
            $('#LoginModal').modal('show');
          }
          else{
            $('#success').html('<div class="alert alert-danger">Problem reporting profile</div>');
          }
        }
      }
   });
}







function checkDateDiff(){
  var promote_type =  $('#promote_type').val();
  if(promote_type == 'date'){
      var dollar = 1;
      var start_date = $('#start_date').val();
      var end_date = $('#end_date').val();
      var date1 = new Date(start_date);
      var date2 = new Date(end_date);
      var timeDiff = Math.abs(date2.getTime() - date1.getTime());
      var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
      var total = dollar*(parseInt(diffDays)+1);
      if(total){
        $('#stripe').modal('show');
        $('#total_amount').html('<div class="form-row"><label><span >To Pay <span style="color:red;"></span></span><input type="text" value="'+total+'" id="amount" name="amount" readonly></label></div><input type="hidden" id="start_dates" name="start_dates" value="'+start_date+'"><input type="hidden" id="end_dates" name="end_dates" value="'+end_date+'">');
      }
    }else if(promote_type == 'option'){
      var exposure = $('.promot_ones:checked').val();
      if(exposure){
        $('#stripe').modal('show');
        var no_of_days = 0;
        if(exposure == 20){
          no_of_days = 27;
        }else if(exposure == 10){
          no_of_days = 15;
        }else if(exposure == 5){
          no_of_days = 7;
        }
        $('#total_amount').html('<div class="form-row"><label><span >To Pay <span style="color:red;"></span></span><input type="text" value="'+exposure+'" id="amount" name="amount" readonly></label></div><input type="hidden" id="no_of_days" name="no_of_days" value="'+no_of_days+'">');
      }
    }
}
// function checkDateDiff(){
//   $('#error_date').html('');
//   //var dollar = $('#dollar').val();
//   var dollar = 1;
//   var start_date = $('#start_date').val();
//   var end_date = $('#end_date').val();
//   if(end_date==''||start_date==''){
//     //$('#error_date').html('<div class="alert alert-danger">Start date and End date can\'t be empty</div>');
//   }else if(dollar == ''){
//    // $('#error_date').html('<div class="alert alert-danger">Price can\'t be empty</div>');
//   }else{
//     var date1 = new Date(start_date);
//     var date2 = new Date(end_date);
//     var timeDiff = Math.abs(date2.getTime() - date1.getTime());
//     var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
//     var total = dollar*(parseInt(diffDays)+1);
//     //if(total>=50){
//     if(total){
//       $('#stripe').modal('show');
//       $('#total_amount').html('<div class="form-row"><label><span >To Pay <span style="color:red;">(in $ and should be >= 50)</span></span><input type="text" value="'+total+'" id="amount" name="amount" readonly></label></div>');
//     }else{
//       //$('#error_date').html('<div class="alert alert-danger">Amount should be greater than or equal to 50. Right now the amount is = '+total+'</div>');
//     }
//   }
// }

$('.optradio').click(function(){
  alert($(this).val());
});

$('.promot_ones').each(function() {
  $(this).prop('previousValue', $(this).is(':checked'))
})
$('.promot_ones').click(function(event) {
  console.log('clicked ' + event.target.id)
  var newValue = !$(event.target).prop('previousValue')
  $(event.target).prop('checked', newValue)
  $(event.target).prop('previousValue', newValue)
})
$('.promot_ones').change(function(event) {
  console.log('changing ' + event.target.id + ', checked = ' + $(event.target).is(':checked'))
})

 $(document).ready(function(){
                    $('#submit_category').click(function(){
                        $.ajax({
                            type:'POST',
                            fileElementId :'userfile',
                            url:"<?php echo site_url('user/insert_userdata');?>",
                            dataType:'json',
                            data:$("#addCategoryForm").serialize(),
                            success:function(resp){
                                $('.form-error').html("");
                                if(resp.type == "validation_err"){
                                    var errObj = resp.msg;
                                    var keys   = Object.keys(errObj);
                                    var count  = keys.length;
                                    for (var i = 0; i < count; i++) {
                                        $('.'+keys[i]).html(errObj[keys[i]]);
                                    };
                                }else if(resp.type == "success"){
                                    $('#addCategoryForm')[0].reset();
                                    Ply.dialog("alert", resp.msg);

                                    setTimeout(function(){window.location.href = resp.url}, 1500);

                                }else{
                                    Ply.dialog('alert',resp.msg);  
                                }
                            },
                        });
                    });

                    /**************** User Form Script End ***************/

                });

function userRole(role){
  $('#userRole').val(role);
  $('#userRoles').val(role);
}

function checkQuestionsAvailabitity(){
  var base_url = $('#base_url').val();
  var optradio = $('#userRole').val();
  var user_category = $('#user_category').val();
  $('#cate_id').val(user_category);
  $('#user_role').val(optradio);
    $.ajax({
      type: "POST",
      dataType: "json",
      url: base_url+'user/checkQuestionsAvailabitity',
      data: {user_type:optradio,user_category:user_category},
      success: function (data) {
        if(data.status == 1){
          $('#create_category').submit();
        }else{
          $('#myQuesModal').modal('show');
        }
      }
   });
}

function getDocuments(other = false){
  var base_url = $('#base_url').val();
  var user_id = $('#user_id').val();
  var search_doc = $('#search_doc').val();
  $.ajax({
      type: "POST",
      dataType: "json",
      url: base_url+'profile/getDocuments',
      data: {user_id:user_id,search_doc:search_doc,other:other},
      success: function (data) {
        if(data.status == 1){
          $('#fileSuccess').html(data.html);
        }else{
          $('#fileSuccess').html('<div class="alert alert-danger">No data found</div>');
        }
      }
   });
}



$('.click_Dts7').click(function(){
      $(this).parents('.poromote_fx').find('.click_Dts7Shows').toggle('slow');
      $('.threeShows').toggle();
    })

