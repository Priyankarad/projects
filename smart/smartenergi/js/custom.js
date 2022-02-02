var loaderimage = '<div class="loaderimage"><div class="innerdiv"></div></div>';
$(document).ready(function(){

$('#slider3d').RollingSlider({
	showArea:"#example",
	prev:"#jprev",
	next:"#jnext",
	moveSpeed:300,
	autoPlay:false
});

})

$(document).ready(function(){

	// $('body').on('click', 'nav#nav > ul > li > a', function(){
	// 	$('nav#nav a').removeClass('menuactive');
	// })


    $("#poenpP").click(function(){
       $('#myModal1').show(); 
    });

    $("#poenpP2").click(function(){
       $('#myModal2').show();
       $('#myModal4').show();  
    });

    $("#poenpP3").click(function(){
       $('#myModal3').show(); 
    });
    
    $(".close_ic").click(function(){
		$(this).parents('.modalIn').hide();
	});

	$(".succes_iDs p span, .error_iDs p span").click(function(){
		$(this).parent().parent().hide();
	});

	
	$(function() {
	    $('.pass_id1').on('click init-post-format', function() {
	        $('.show_bon').toggle($('#passY').prop('checked'));
	    }).trigger('init-post-format');
	});

	$(".collaspe_btns").click(function(){
		$(this).siblings('.collaspeable_div').slideToggle();
	});


});

function ajaxRequest(formAttr,method){
	event.preventDefault();
  jQuery('body').append(loaderimage);
	var Formbutton=$(formAttr).find('button');

     // Get form
        var form = $(formAttr)[0];

		// Create an FormData object 
        var formData = new FormData(form);
     //$(".loadingimag").show(); 
     $.ajax({
           type: method,
           url: $(formAttr).attr('action'),
           cache: false,
           contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
    	   processData: false, // NEEDED, DON'T OMIT THIS
           data: formData, // serializes the form's elements.
           success: function(data)
           {
             jQuery('.loaderimage').remove(); 
           	// $(".loadingimag").hide();
           	 $(formAttr).find('.errbrdr').removeClass('errbrdr');
           	 $(formAttr).find('.errtxt').remove();
           	 var  ajaxresponse = jQuery.parseJSON(data);
           	 if(ajaxresponse.status==0){
           	 	
           	 	if(ajaxresponse.errstr){
	                var errstring = ajaxresponse.errstr;
					 if(errstring.length > 0){
						errstring.forEach(function(err){
							$('#' + err.type).addClass('errbrdr');
							$('#' + err.type).after('<div class="errtxt">' + err.msg + '</div>');
							
						});
					}
					
					$('html,body').animate({scrollTop : $('.errbrdr:first').offset().top-50},600);
					$('.errbrdr:first').focus();
				}
           	 }else if(ajaxresponse.status==1){
           	 	if(ajaxresponse.stepchange==1){
           	 		Formbutton.parents('.item_boxes').removeClass('activeitemF');
					Formbutton.parents('.item_boxes').next().addClass('activeitemF');
					Formbutton.parents('.multistepSmain').prev().find('.active-steps').parent().next().find('.firstSbox').addClass('active-steps');
					Formbutton.parents('.multistepSmain').prev().find('.active-steps').first().removeClass('active-steps');
				}
				if(typeof ajaxresponse.msg !== 'undefined'){
					$(formAttr).parents('.item_boxes').html('<div class="row uniform 100%"><div class="12u 12u$(medium)"><h4>'+ajaxresponse.msg+'</h4></div></div>');
	           	}


           	 	if(ajaxresponse.redirect){
           	 		window.setTimeout(function() {
					    window.location.href = ajaxresponse.redirect;
					}, 500);
           	 	}
           	 	 
           	 }
                // show response from the php script.
           },
          error: function (errorThrown) {
             jQuery('.loaderimage').remove(); 
             alert("There is some error.Try again.");
          }
         });
}





$(document).ready(function(){
	
	$('.basic-infos  ul.tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('.basic-infos  ul.tabs li').removeClass('current');
		$('.basic-infos  .tab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	})

})

$(document).on("change keyup keypress keydown","input[name='cardNumber']",function(){
//function detectCardType(number) {
	var number=$(this).val();
    var re = {
        electron: /^(4026|417500|4405|4508|4844|4913|4917)\d+$/,
        maestro: /^(5018|5020|5038|5612|5893|6304|6759|6761|6762|6763|0604|6390)\d+$/,
        dankort: /^(5019)\d+$/,
        interpayment: /^(636)\d+$/,
        unionpay: /^(62|88)\d+$/,
        visa: /^4[0-9]{12}(?:[0-9]{3})?$/,
        mastercard: /^5[1-5][0-9]{14}$/,
        amex: /^3[47][0-9]{13}$/,
        diners: /^3(?:0[0-5]|[68][0-9])[0-9]{11}$/,
        discover: /^6(?:011|5[0-9]{2})[0-9]{12}$/,
        jcb: /^(?:2131|1800|35\d{3})\d{11}$/
    }

    for(var key in re) {
        if(re[key].test(number)) {
            return key
        }
    }
})