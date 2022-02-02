<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <title><?php echo isset($title) ? $title : 'Mawjuud'; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="#">
    <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">
    <link rel="icon" href="<?php echo base_url()?>assets/images/favicon_icon.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/bower_components/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/icon/feather/css/feather.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/css/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" type="text/css"
    href="<?php echo base_url();?>assets/admin/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/pages/data-table/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/valid.css">
</head>
<?php $timestamp=date('ymdhis');?>
<body>
    <div class="theme-loader">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <?php
            $firstName = $this->session->userdata('firstname');
            $lastName = $this->session->userdata('lastname');
            ?>
            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">

                    <div class="navbar-logo">
                        <a class="mobile-menu" id="mobile-collapse" href="#!">
                            <i class="feather icon-menu"></i>
                        </a>
                        <a href="<?php echo site_url('dashboard'); ?>">
                            <img class="img-fluid" src="<?php echo base_url();?>assets/images/logo.png" alt="Mawjuud-Logo" style="width: 55px;" />
                        </a>
                        <a class="mobile-options">
                            <i class="feather icon-more-horizontal"></i>
                        </a>
                    </div>

                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-addon search-close"><i class="feather icon-x"></i></span>
                                        <input type="text" class="form-control">
                                        <span class="input-group-addon search-btn"><i class="feather icon-search"></i></span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="#!" onclick="javascript:toggleFullScreen()">
                                    <i class="feather icon-maximize full-screen"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav-right">
                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        <?php
                                        $img = base_url().DEFAULT_PROPERTY_IMAGE;
                                        if(checkRemoteFile($this->session->userdata('profile_image'))){
                                            $img = $this->session->userdata('profile_image'); 
                                        }
                                        ?>
                                        <img src="<?php echo $img;?>" class="img-radius" alt="User-Profile-Image" width="30" height="30">
                                        <span><?php echo ucwords($firstName.' '.$lastName);?></span>
                                        <i class="feather icon-chevron-down"></i>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <!-- <li><a href="<?php echo site_url('profile'); ?>"><i class="feather icon-user"></i> Profile</a></li> -->
                                        <li><a href="#"><i class="feather icon-user"></i> Profile</a></li> 
                                        <li><a href="<?php echo base_url();?>admin/home/logout"><i class="feather icon-log-out"></i> Logout</a> </li>
                                    </ul>

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        <div class="pcoded-inner-navbar main-menu">
                            <div class="pcoded-navigatio-lavel">Navigation</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="active">
                                    <a href="<?php echo site_url('adusers?').$timestamp; ?>">
                                        <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                                        <span class="pcoded-mtext">Manage Users</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="<?php echo site_url('adagents?').$timestamp;; ?>">
                                        <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                                        <span class="pcoded-mtext">Manage Agents</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="<?php echo site_url('listings'); ?>">
                                        <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                        <span class="pcoded-mtext">Manage Listings</span>
                                    </a>
                                </li>
                               <!--  <li class="">
                                    <a href="<?php echo site_url('listings'); ?>">
                                        <span class="pcoded-micon"><i class="feather icon-check-circle"></i></span>
                                        <span class="pcoded-mtext">Approve/delete Listings</span>
                                    </a>
                                </li> -->
                                <li class="">
                                    <a href="<?php echo site_url('scheduled_tours'); ?>">
                                        <span class="pcoded-micon"><i class="feather icon-calendar"></i></span>
                                        <span class="pcoded-mtext">See Scheduled Tours</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="<?php echo site_url('afavourite_property'); ?>">
                                        <span class="pcoded-micon"><i class="feather icon-bookmark"></i></span>
                                        <span class="pcoded-mtext">Most Favorited Property</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="<?php echo site_url('asearch_property'); ?>">
                                        <span class="pcoded-micon"><i class="feather icon-search"></i></span>
                                        <span class="pcoded-mtext">Most Searched Property</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="<?php echo site_url('enquiries_sale'); ?>">
                                        <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
                                        <span class="pcoded-mtext">Total Enquiries For Buy</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="<?php echo site_url('enquiries_rent'); ?>">
                                        <span class="pcoded-micon"><i class="feather icon-sidebar"></i></span>
                                        <span class="pcoded-mtext">Total Enquiries For Rent</span>
                                    </a>
                                </li>

                             <!--    <li class="">
                                    <a href="">
                                        <span class="pcoded-micon"><i class="feather icon-credit-card"></i></span>
                                        <span class="pcoded-mtext">Application Ratings  </span>
                                        <span class="pcoded-badge label">10</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="">
                                        <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                                        <span class="pcoded-mtext">Top Rated Agents</span>
                                        <span class="pcoded-badge label">15</span>
                                    </a>
                                </li>

                                <li class="">
                                    <a href="">
                                        <span class="pcoded-micon"><i class="feather icon-sliders"></i></span>
                                        <span class="pcoded-mtext">Top Rated Properties</span>
                                        <span class="pcoded-badge label">13</span>
                                    </a>
                                </li> -->
                                <!-- <li class="">
                                    <a href="">
                                        <span class="pcoded-micon"><i class="feather icon-mail"></i></span>
                                        <span class="pcoded-mtext">Agent-Custmor Message Monitoring</span>
                                    </a>
                                </li> -->

                                <!-- <li class="">
                                    <a href="">
                                        <span class="pcoded-micon"><i class="feather icon-award"></i></span>
                                        <span class="pcoded-mtext">Most Filters Applied While Searching</span>
                                    </a>
                                </li>
 -->
                               <!--  <li class="">
                                    <a href="">
                                        <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                                        <span class="pcoded-mtext">Suspend Agent Profile</span>
                                    </a>
                                </li>

                                <li class="">
                                    <a href="">
                                        <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                                        <span class="pcoded-mtext">Suspend User Profile</span>
                                    </a>
                                </li> -->

                                <li class="">
                                    <a href="">
                                        <span class="pcoded-micon"><i class="feather icon-mail"></i></span>
                                        <span class="pcoded-mtext">Manage Newsletters</span>
                                    </a>
                                </li>

                               <!--  <li class="">
                                    <a href="<?php echo site_url('page_settings');?>">
                                        <span class="pcoded-micon"><i class="feather icon-watch"></i></span>
                                        <span class="pcoded-mtext">Manage About Us Page</span>
                                    </a>
                                </li> -->

                                <li class="">
                                    <a href="<?php echo site_url('page_settings');?>">
                                        <span class="pcoded-micon"><i class="feather icon-help-circle"></i></span>
                                        <span class="pcoded-mtext">Page Settings</span>
                                    </a>
                                </li>

                               <!--  <li class="">
                                    <a href="">
                                        <span class="pcoded-micon"><i class="feather icon-monitor"></i></span>
                                        <span class="pcoded-mtext">Review Reported Listings </span>
                                    </a>
                                </li> -->

                                <li class="">
                                    <a href="<?php echo site_url('source_feeds');?>">
                                        <span class="pcoded-micon"><i class="feather icon-monitor"></i></span>
                                        <span class="pcoded-mtext">Source Feed</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </nav>
                    <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                    