$( document ).ready(function() {
	var str1 = window.location.href;
	/*for fb and google accounts exist as normal or vice versa*/
	var str = "pass=password";
	if(str1.includes(str)){
		$('#enter_password_modal').modal('open');
	}

	/*for popup login*/
	var str2 = "popup=login";
	if(str1.includes(str2)){
		$('#loginmodal').modal('open');
	}
	//to check user category after login
	var user_logged_in = $('#user_logged_in').val();
	if(user_logged_in == 1){
		$('#enter_password_modal').modal('close');
		$('#chooseCategory').modal('open');
	}
});

//To check the user data exist
$(".login_frm").click(function(){
	if($("#login_frm").valid()){
		$('body').append(loader_ajax);
		$.ajax({
			url: baseUrl+ 'user/userRegistrationStatus',
			type: 'post',
			dataType: 'json',
			data: {
				user_email:$(".login_user_email").val(),
			},
			success: function (data) {
				$('#loginmodal').modal('close');
				$('.loader_outer').remove();
				if(data.result == 1){ // user already exist
					$('#enter_password_modal').modal('open');
				}else if(data.result == 0){
					$('#create_password_modal').modal('open');
				}
			},
		});
	}
});    

$("#login_frm").validate({
	errorPlacement: function (error, element) {
		error.css('color', 'red');
		error.insertAfter(element);
	},
	rules: {
		user_email : {
			required: true,
			email: true
		},
	},
	messages: {
		user_email: {
			required: "Email is required",
			email: "Please enter a valid email address"
		}
	}

}); 


//To enter the password if exist
$(".enter_frm").click(function(){
	if($("#enter_frm").valid()){
		$('body').append(loader_ajax);
		$.ajax({
			url: baseUrl+ 'user/userPassword/enter',
			type: 'post',
			dataType: 'json',
			data: {
				enter_password:$("#enter_password").val(),
			},
			success: function (data) {
				$('.loader_outer').remove();
				if(data.status == 0){
					$(".enter_frm_pass strong").html("Invalid Email Id or Password");
					$(".enter_frm_pass").show();
				}else if(data.status == 3){
					//window.location.href = baseUrl+"myaccount";
					window.location.href=data.redirect_url;
				}
				else if(data.status == 4){
					$(".enter_frm_pass strong").html("Please verify your account !");
					$(".enter_frm_pass").show();
				}
				else{
					// window.location.href = baseUrl;
					window.location.reload();
				}
			},
		});
	}
});    

$("#enter_frm").validate({
	errorPlacement: function (error, element) {
		error.css('color', 'red');
		error.insertAfter(element);
	},
	rules: {
		enter_password :"required",
	},
	messages: {
		enter_password: {
			required: "Password is required",
		}
	}

}); 

 //To create password
$(".create_frm").click(function(){
	if($("#create_frm").valid()){
		$('body').append(loader_ajax);
		$.ajax({
			url: baseUrl+ 'user/userPassword/create',
			type: 'post',
			dataType: 'json',
			data: {
				create_password:$("#create_password").val(),
			},
			success: function (data) {
				$('.loader_outer').remove();
				if(data.status == 4){
					$(".create_frm_pass strong").html("Please verify your account !");
					$(".create_frm_pass").show();
				}
				else{
				 	window.location.href=data.redirect_url;
				}
			},
		});
	}
});    

$("#create_frm").validate({
	errorPlacement: function (error, element) {
		error.css('color', 'red');
		error.insertAfter(element);
	},
	rules: {
		create_password : "required",
	},
	messages: {
		create_password: {
			required: "Password is required",
		}
	}
}); 



$("#signup_frm").on('submit',function(){
	var current=$(this);
	if($("#signup_frm").valid()){
		$('body').append(loader_ajax);
		$.ajax({
			type:'POST',
			url:baseUrl+'/user/userSignUp',
			data: new FormData($(this)[0]),
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			success:function(res){
				$('.loader_outer').remove();
				if(res.result == 1){
					current.find('input').val(''); 
					$(".signup_success strong").html("User registered successfully. Verification email sent. Please verify account to login");
					$(".signup_success").show();
				}else if(res.result == 0){
					$(".signup_error strong").html("User already registered");
					$(".signup_error").show();
				}else{
					$(".signup_error strong").html("Something went wrong. Please contact site admin");
					$(".signup_error").show();
				}
				current.parents().find('#signupModal').fadeIn();
				$('.my-signup').fadeIn();
				current.parents().find('#my-profile').css('display','none');
			}
		}); 
	}
});

$("#signup_frm").validate({
	errorPlacement: function (error, element) {
		error.css('color', 'red');
		error.insertAfter(element);
	},
	rules: {
		register_as_agent: {
			required: true,
		},
		emailSignup: {
			required: true,
			email: true
		},
		emailSignup1: {
			equalTo: "#emailSignup",
		},
		pass1Signup: "required",
		pass2Signup: {
			equalTo: "#pass1Signup",
		},
		firstnameSignup: "required",
		lastnameSignup: "required",
	},
	messages: {
		register_as_agent: {
			required: 'Category is required',
		},
		emailSignup: {
			required: 'Email is required.',
			email: 'Please enter a valid email address'
		},
		emailSignup1: 'Confirm email should be same as the original email',
		pass1Signup: 'Password is required.',
		pass2Signup: 'Confirm password should be same as the original password',
		firstnameSignup: 'Firstname is required.',
		lastnameSignup: 'Lastname is required.',
	}

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
	$("#confirmationemail").modal('close');
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
				$('#resend_email').val(res.email);
				if(res.status == 1){
					current.find('input').val(''); 
					//$(".signup_success strong").html("Reset password link has been sent to your registered Email ID");
					//$(".signup_success").show();
					$("#confirmationemail").modal('open');
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

$("#newpass_frm").validate({
	errorPlacement: function (error, element) {
		error.css('color', 'red');
		error.insertAfter(element);
	},
	rules: {
		newpassword: {
			required: true,
		},
		confirmpassword: {
			required: true,
			equalTo: "#newpassword",
		},
	},
	messages: {
		newpassword: {
			required: 'Password is required.',
		},
		confirmpassword: {
			required: 'Confirm password is required.',
			equalTo: "Confirm password should be same as the original password",
		},
	}

}); 

$("#newpass_frm").on('submit',function(){
	var current=$(this);
	$(".signup_error").hide();
	$(".signup_success").hide();
	if($("#newpass_frm").valid()){
		$('body').append(loader_ajax);
		$.ajax({
			type:'POST',
			url:baseUrl+'/user/update_password',
			data: new FormData($(this)[0]),
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			success:function(res){
				$('.loader_outer').remove();
				if(res.status == 1){
					current.find('input').val(''); 
					$(".signup_success strong").html("Password updated successfully");
					$(".signup_success").show();
				}else{
					$(".signup_error strong").html("Something went wrong. Please contact site admin");
					$(".signup_error").show();
				}
			}
		}); 
	}
});

$(document).on('click','#resend',function(){
	var resetemail = $('#resend_email').val();
	$.ajax({
		type:'POST',
		url:baseUrl+'/user/sendForgotMail',
		data: {resetemail:resetemail},
		dataType: 'json',
		success:function(res){
			Ply.dialog("alert",'Mail sent successfully');
		}
	}); 
});