<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="format-detection" content="telephone=no">
        <meta charset="UTF-8">

        <meta name="description" content="<?php echo SITE_NAME; ?>">
        <meta name="keywords" content="<?php echo SITE_NAME; ?>">
        <title><?php echo SITE_NAME; ?> Admin</title>
        
        <link href="<?php echo base_url(); ?>assets/admin/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/admin/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
        
        <link href="<?php echo base_url(); ?>assets/admin/css/app.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/admin/css/custom.css" rel="stylesheet">
    </head>
    <body class="login-content">
        <!-- Login -->

        <div class="lc-block toggled" id="l-login">
            <form id="login_form">
                <div class="lcb-float"><img src="<?php echo base_url();?>assets/images/logowhit.png"></div>
	            <!-- <div class="lcb-float"><i class="zmdi zmdi-pin-account"></i></div> -->
	            <!-- <div class="lcb-float"><h1><?php echo SITE_NAME; ?></h1></div> -->
            
	            <div class="form-group">
	            	<p class="show_error danger" style="display:none">Invalid Login Credientials</p>
	            </div>
	            <div class="form-group">
	                <input type="text" class="form-control input" id="email" name="email" placeholder="Email">
	            </div>
	            
	            <div class="form-group">
	                <input type="password" class="form-control input" id="password" name="password" placeholder="Password">
	            </div>
	            
	            <div class="clearfix"></div>
	            
	            <div class="p-relative ">
	                <div class="checkbox cr-alt">
	                    <label class="c-gray">
	                        <input type="checkbox" checked name="remember_me">
	                        <i class="input-helper"></i>
	                        Keep me signed in
	                    </label>
	                </div>
	            </div>
	            <a href="javascript:void(0)" class="btn btn-block btn-primary btn-float m-t-25 submit_login">Sign In</a>
        	</form>
        </div>
        <!-- Javascript Libraries -->
        <script src="<?php echo base_url(); ?>assets/admin/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js/functions.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js/custom/login.js"></script>
    	<script type="text/javascript">
            function get_url()
            {
                var url = "<?php echo base_url(); ?>";
                return url;
            }
        </script> 
    </body>
</html>