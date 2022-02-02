<!DOCTYPE html>
<?php 
$timeStamp = strtotime("now");
$actual_link = (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$this->session->set_userdata('redirect_url',$actual_link);
$userSession = $this->session->userdata('sessionData');
$userType = $userSession['user_role'];
?>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="-1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>Mawjuud</title>
    <!-- CSS  -->
    <link rel="shortcut icon" href="<?php echo base_url()?>assets/images/favicon_icon.png">
    <link href="<?php echo base_url()?>assets/css/materialize.min.css?ver=<?php echo $timeStamp;?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo base_url()?>assets/css/themify-icons.css?ver=<?php echo $timeStamp;?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo base_url()?>assets/css/owl.carousel.min.css?ver=<?php echo $timeStamp;?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo base_url()?>assets/css/animate.css?ver=<?php echo $timeStamp;?>" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/ion.rangeSlider.css?ver=<?php echo $timeStamp;?>" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/ion.rangeSlider.skinFlat.css?ver=<?php echo $timeStamp;?>" />
   <link rel="stylesheet" href="<?php echo base_url()?>assets/css/nicescroll.css?ver=<?php echo $timeStamp;?>" />
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/intlTelInput.min.css?ver=<?php echo $timeStamp;?>" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/ply.css?ver=<?php echo $timeStamp;?>" />
    <link href="<?php echo base_url()?>assets/css/richtext.min.css?ver=<?php echo $timeStamp;?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo base_url()?>assets/css/style.css?ver=<?php echo $timeStamp;?>" type="text/css" rel="stylesheet"/>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css?ver=<?php echo $timeStamp;?>" type="text/css" rel="stylesheet"/>
</head>
<body class="<?php echo isset($class)?$class:'';?>">

    <!--================header==============-->
    <div class="main_header">
        <div class="container">
            <nav>
                <div class="nav-wrapper">
                    <a href="<?php echo base_url()?>" class="brand-logo"><img src="<?php echo base_url()?>assets/images/logo.png"></a>
                    <a href="#" data-target="mobile-demo" class="sidenav-trigger">
                        <div class="barsicon">
                            <span class="line"></span>
                            <span class="line"></span>
                            <span class="line"></span>
                        </div>
                    </a>
                    <div class="my_allmenus">
                        <ul class="right">
                            <?php 
                            $sessionData = '';
                            if($this->session->userdata('sessionData')){
                                $sessionData = $this->session->userdata('sessionData');
                            }
                            if(empty($sessionData)){ 
                                ?>
                                <li><a href="#loginmodal" class="modal-trigger" > <span class="ti-user"></span> Login/Sign Up</a></li>
                                <!-- <li><a href="#signupmodal" class="modal-trigger"> <span class="ti-user"></span> Signup</a></li> -->
                            <?php }else{ ?>
                                <li><a class='dropdown-trigger' href='#' data-target='dropdown1'> <img src="<?php echo (isset($userSession['profile_thumbnail']) && !empty($userSession['profile_thumbnail']))?$userSession['profile_thumbnail']:base_url().DEFAULT_IMAGE; ?>" class="UserPimg" alt="userimg"><?php echo (isset($userSession['first_name'])&&isset($userSession['last_name']))?$userSession['first_name']." ".$userSession['last_name']:''; ?> <span class="ti-angle-down"></span></a>
                                    <ul id='dropdown1' class='dropdown-content'>
                                        <?php if($userType == 'agent'){ ?>
                                        <li><a href="<?php echo base_url();?>add_property"><span class="ti-list"></span> List Property For free</a></li>
                                        <li><a href="<?php echo base_url();?>myaccount?tab=my_propeties"><span class="ti-home"></span> My Properties<span style="color:#FF0000;display:none;"> (*Promotion)</span></a></li>
                                        <?php } ?>
                                        <li><a href="<?php echo base_url();?>favourite_properties"><span class="ti-heart"></span> Favourite Properties</a></li>
                                        <li><a href="<?php echo base_url();?>compare_properties"><span class="ti-plus"></span> Compare Properties</a></li>
                                        <?php if($userType == 'owner'){ ?>
                                        <li><a href="<?php echo base_url();?>myaccount?tab=searches" data-toggle="modal" data-target="#searches-modal"><span class="ti-search"></span> My Searches</a></li>
                                        <?php } ?>
                                        <li><a href="<?php echo base_url();?>myaccount?tab=settings"><span class="ti-settings"></span> Account Settings</a></li>
                                        <li><a href="<?php echo base_url();?>user/logout?<?php echo $timeStamp;?>"><span class="ti-power-off"></span> Logout</a></li>
                                    </ul>  
                                </li> 
                            <?php } ?>
                        </ul>
                        <ul class="right mymenus">
                            <!-- <li><a href="">Home</a></li> -->
                            <li><a href="<?php echo base_url();?>" class="nav-active <?php if(isset($page) && $page == 'home'){ echo 'active-menu';}?>">Home</a></li>
                            <!-- <li><a href="">Properties</a></li> -->
                            <li><a href="<?php echo base_url();?>agents" class="<?php if(isset($page) && $page == 'agents'){ echo 'active-menu';}?>">Agents </a></li>
                            <li class="rent_class"><a href="<?php echo base_url();?>property/setNearBy/rent">Rent</a></li>
                            <li class="sale_class"><a href="<?php echo base_url();?>property/setNearBy/sale">Buy</a></li>
                        </ul>
                    </div>

                </div>
            </nav>
        </div>
        <!--<div class="sidenav" id="mobile-demo">

        </div>-->
    </div>
    <!--================header==============-->

