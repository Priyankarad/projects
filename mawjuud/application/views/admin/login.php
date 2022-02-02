<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <title>Mawjuud</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="#">
    <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">
    <link rel="icon" href="<?php echo base_url()?>assets/images/favicon_icon.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/bower_components/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/icon/themify-icons/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/icon/icofont/css/icofont.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/css/style.css">
</head>
<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
<body class="fix-menu">
    <div class="theme-loader">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
            </div>
        </div>
    </div>


    <section class="login-block">
        <div class="container">
            <div class="admin-lbox">
                <div class="row">
                    <div class="col-md-5">
                        <div class="logo_boxs">
                            <img src="<?php echo base_url();?>assets/images/logo.png" alt="logo.png">
                        </div>
                    </div>
                    <div class="col-sm-7">
                            <form class="md-float-material form-material" id="login_form" action="<?php echo base_url('admin/home'); ?>" method="post">
                                <div class="newcssbx">
                                    <div class="card-block">
                                        <div class="row m-b-20">
                                            <div class="col-md-12">
                                                <h3 class="text-center">Sign In</h3>
                                            </div>
                                        </div>
                                        <div class="show_error">
                                            <?php $error = $this->session->flashdata('loginerror');
                                            if($this->session->flashdata('loginerror')) {
                                                echo $error;
                                            } ?>
                                        </div>
                                        <div class="form-group form-primary">
                                            <img src="<?php echo base_url();?>assets/images/user-outline.png" alt="icon"/>
                                            <input type="text" id="email" name="email" class="form-control input"  placeholder="Your Email Address" value="<?php echo set_value('email') ?>">
                                            <span class="show_error"><?php echo form_error('email'); ?><span>
                                            <span class="form-bar"></span>
                                        </div>
                                        <div class="form-group form-primary">
                                            <img src="<?php echo base_url();?>assets/images/padlock.png" alt="icon"/>
                                            <input type="password" id="password" name="password" class="form-control input" placeholder="Password" value="<?php echo set_value('password') ?>">
                                            <span class="show_error"><?php echo form_error('password'); ?><span>
                                            <span class="form-bar"></span>
                                        </div>
                                        <!-- <div class="row m-t-25 text-left">
                                            <div class="col-12">
                                                <div class="checkbox-fade fade-in-primary d-">
                                                    <label>
                                                        <input type="checkbox" value="">
                                                        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                        <span class="text-inverse">Remember me</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="row m-t-30">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20 submit_login">Sign in</button>
                                            </div>
                                        </div>
                                       <!--  <div class="row">
                                            <div class="col-md-10">
                                                <p class="text-inverse text-left m-b-0">Thank you.</p>
                                                <p class="text-inverse text-left"><a href="index.html"><b class="f-w-600">Back to website</b></a></p>
                                            </div>
                                            <div class="col-md-2">
                                                <img src="<?php echo base_url()?>assets/images/favicon_icon.png">
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
 <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/jquery/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/popper.js/js/popper.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/modernizr/js/modernizr.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/modernizr/js/css-scrollbars.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/i18next/js/i18next.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/common-pages.js"></script>
</body>
</html>
