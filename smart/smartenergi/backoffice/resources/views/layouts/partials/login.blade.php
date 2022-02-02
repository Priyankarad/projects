<button class="btn scrolltop-btn back-top"><i class="fa fa-angle-up"></i></button>
<div class="modal fade" id="pop-login" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <ul class="login-tabs">
                    <li class="active">Login</li>
                    <li>Register</li>
                </ul>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>

            </div>
            <div class="modal-body login-block">
                <div class="tab-content">
                    <div class="tab-pane fade in active">
                        <!--<div class="message">
                            <p class="error text-danger"><i class="fa fa-close"></i> You are not Logedin</p>
                            <p class="success text-success"><i class="fa fa-check"></i> You are not Logedin</p>
                        </div>-->
						
						<div class="message loginmsg">
                            <p class="error text-danger loginerr"></p>
                            <p class="success text-success loginsuccess"></p>
                        </div>
						
                        <form name="frmlogin" id="frmlogin" method="post" action="{{ URL::route('dologin') }}">
							
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="act" value="dologin">
							
                            <div class="form-group field-group">
                                <div class="input-email input-icon">
                                    <input type="text" placeholder="Email" name="email" id="loginemail">
                                </div>
                                <div class="input-pass input-icon">
                                    <input type="password" placeholder="Password" name="password" id="loginpassword">
                                </div>
                            </div>
                            <div class="forget-block clearfix">
                                <!--<div class="form-group pull-left">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox">
                                            Remember me
                                        </label>
                                    </div>
                                </div>-->
                                <div class="form-group pull-right">
                                    <a href="#" data-toggle="modal" data-dismiss="modal" data-target="#pop-reset-pass">I forgot username and password</a>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Login</button>
							
							<div id="loginloader" style="margin:10px 0 0 0; text-align:center; display:none"><img src="{{ URL::asset('public/frontend/images/loaders/loader.svg') }}"></div>
							
                        </form>
                        <!--<hr>
                        <a href="#" class="btn btn-social btn-bg-facebook btn-block"><i class="fa fa-facebook"></i> login with facebook</a>
                        <a href="#" class="btn btn-social btn-bg-linkedin btn-block"><i class="fa fa-linkedin"></i> login with linkedin</a>
                        <a href="#" class="btn btn-social btn-bg-google-plus btn-block"><i class="fa fa-google-plus"></i> login with Google</a>-->
                    </div>
                    <div class="tab-pane fade">
					
						<div class="message registermsg">
                            <p class="error text-danger registererr"></p>
                            <p class="success text-success registersuccess"></p>
                        </div>
						
                        <form name="frmregister" id="frmregister" method="post" action="{{ URL::route('doregister') }}">
							
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="act" value="doregister">
							
                            <div class="form-group field-group">
                                <div class="input-user input-icon">
                                    <input type="text" placeholder="First Name" name="firstname" id="firstname">
                                </div>
                                <div class="input-user input-icon">
                                    <input type="text" placeholder="Last Name" name="lastname" id="lastname">
                                </div>
								<div class="input-email input-icon">
                                    <input type="text" placeholder="Email" name="email" id="email">
                                </div>
								<div class="input-pass input-icon">
                                    <input type="password" placeholder="Password" name="password" id="password">
                                </div>
								<div class="input-pass input-icon">
                                    <input type="password" placeholder="Confirm Password" name="conpassword" id="conpassword">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="terms" id="terms" value="yes" checked>
                                        I agree with your <a href="{{ URL::route('terms') }}" target="_blank">Terms & Conditions</a>.
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
							
							<div id="registerloader" style="margin:10px 0 0 0; text-align:center; display:none"><img src="{{ URL::asset('public/frontend/images/loaders/loader.svg') }}"></div>
							
                        </form>
						
                        <!--<hr>

                        <a href="#" class="btn btn-social btn-bg-facebook btn-block"><i class="fa fa-facebook"></i> login with facebook</a>
                        <a href="#" class="btn btn-social btn-bg-linkedin btn-block"><i class="fa fa-linkedin"></i> login with linkedin</a>
                        <a href="#" class="btn btn-social btn-bg-google-plus btn-block"><i class="fa fa-google-plus"></i> login with Google</a>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="pop-reset-pass" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <ul class="login-tabs">
                    <li class="active">Reset Password</li>
                </ul>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
            </div>
            <div class="modal-body">
                <p>Please enter your username or email address. You will receive a link to create a new password via email.</p>
                <form>
                    <div class="form-group">
                        <div class="input-user input-icon">
                            <input placeholder="Enter your username or email" class="form-control">
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block">Get new password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="after-register-message" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <ul class="login-tabs">
                    <li class="active">Thanks for Registering!</li>
                </ul>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
            </div>
            <div class="modal-body">
                <p>Your account has been created with us. An email with the verification link has been sent to your email address. Your account will be active within 24 hours after registration.</p>
				<p><strong>Note:</strong> We'll notify you once your account is active.</p>
                <button class="btn btn-primary btn-block" onclick="$('#after-register-message').modal('hide');">Okay</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')

@parent

<script>

$(document).ready(function() {
	
    var loginoptions = { 
		beforeSubmit: validlogin,
        success: afterloginresponse,
		dataType: 'json',
		clearForm: false,
		resetForm: false
    }; 
	
	var loginregister = { 
		beforeSubmit: validregister,
        success: afterregisterresponse,
		dataType: 'json',
		clearForm: false,
		resetForm: false
    }; 
 
    $('#frmlogin').ajaxForm(loginoptions); 
    $('#frmregister').ajaxForm(loginregister); 
	
	$('input[type=text],input[type=password],input[type=checkbox],textarea,select').on('change keyup',function(){
		
		$(this).removeClass('errbrdr');
		$(this).parent().parent().removeClass('errbrdr');
	});
	
	var hash = window.location.hash.substring(1);
	
	if(hash != ''){
		
		$('#loginlink').trigger('click');
	}
	
	$('#pop-login').on('hidden.bs.modal', function () {
		
		$('#frmlogin')[0].reset();
		$('#frmregister')[0].reset();
		$('.loginmsg').find('.loginsuccess,.loginerr').html('');
		$('.registermsg').find('.registersuccess,.registererr').html('');
		$('input[type=text],input[type=password],input[type=checkbox],textarea,select').removeClass('errbrdr');
		$('input[type=text],input[type=password],input[type=checkbox],textarea,select').parent().parent().removeClass('errbrdr');
	})
	
}); 
 
function validlogin(formData, jqForm, options) { 
    
    var flag = 0;
	
	var email = $('#loginemail').val().trim();
	var password = $('#loginpassword').val().trim();
	
	if(email == ''){
		$('#loginemail').addClass('errbrdr');
		flag = 1;
	}
	else if(!isEmail(email)){
		$('#loginemail').addClass('errbrdr');
		flag = 1;
	}
	if(password == ''){
		$('#loginpassword').addClass('errbrdr');
		flag = 1;
	}
	
	if(flag == 1){
		return false;
	}
	else{
		
		$('#loginloader').show();
		
		return true;
	}
} 
 
function afterloginresponse(responseText, statusText, xhr, $form)  { 
    
	$('#loginloader').hide();
	
	if(responseText.status == 'success'){
		
		var name = responseText.name;
		
		$('.loginmsg').find('.loginsuccess').html('');
		$('.loginmsg').find('.loginerr').html('');
		
		$('.loginmsg').find('.loginsuccess').html('Welcome back ' + name + '!');
		
		setTimeout(function(){
			
			location.href = '{{ URL::route("myaccountdashboard") }}';
			
		},2000);		
	}
	else if(responseText.status == 'notexists'){
		
		$('.loginmsg').find('.loginerr').html('Invalid Email or Password!');
	}
	else if(responseText.status == 'notactive'){
		
		$('.loginmsg').find('.loginerr').html('Your account is inactive!');
	}
} 

function validregister(formData, jqForm, options) { 
    
   var flag = 0;
	
	var firstname = $('#firstname').val().trim();
	var lastname = $('#lastname').val().trim();
	var email = $('#email').val().trim();
	var password = $('#password').val().trim();
	var conpassword = $('#conpassword').val().trim();
	var terms = $('#terms').is(":checked");
	
	if(firstname == ''){
		$('#firstname').addClass('errbrdr');
		flag = 1;
	}
	if(lastname == ''){
		$('#lastname').addClass('errbrdr');
		flag = 1;
	}
	if(email == ''){
		$('#email').addClass('errbrdr');
		flag = 1;
	}
	else if(!isEmail(email)){
		$('#email').addClass('errbrdr');
		flag = 1;
	}
	if(password == ''){
		$('#password').addClass('errbrdr');
		flag = 1;
	}
	if(conpassword == ''){
		$('#conpassword').addClass('errbrdr');
		flag = 1;
	}
	if(conpassword != password){
		$('#conpassword').addClass('errbrdr');
		flag = 1;
	}
	if(!terms){
		$('.checkbox').addClass('errbrdr');
		flag = 1;
	}
	
	if(flag == 1){
		return false;
	}
	else{
		
		$('#registerloader').show();
		
		return true;
	}
} 
 
function afterregisterresponse(responseText, statusText, xhr, $form)  { 
    
	$('#registerloader').hide();
	
	if(responseText.status == 'success'){
		
		$('#pop-login').find('.close').trigger('click');
		$('#after-register-message').modal('show');
	}
	else if(responseText.status == 'exists'){
		
		$('.registermsg').find('.registererr').html('An account already exists with this email address!');
	}
} 

function isEmail(email) { 
    return /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(email);
} 

</script>

@append
