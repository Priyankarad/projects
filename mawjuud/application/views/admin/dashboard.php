<?php include APPPATH.'views/admin/includes/header.php';?>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-body">
                    <div class="row">
                        <!-- task, page, download counter  start -->
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-yellow update-card">
                                <div class="card-block">
                                    <div class="row align-items-end">
                                        <div class="col-8">
                                            <h4 class="text-white"><?php echo !empty($users['total_count'])?$users['total_count']:0;?></h4>
                                            <h6 class="text-white m-b-0">Total Users</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <i class="feather icon-users icons_dash"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-green update-card">
                                <div class="card-block">
                                    <div class="row align-items-end">
                                        <div class="col-8">
                                            <h4 class="text-white"><?php echo !empty($agents['total_count'])?$agents['total_count']:0;?></h4>
                                            <h6 class="text-white m-b-0">Total Agents</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <i class="feather icon-users icons_dash"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-pink update-card">
                                <div class="card-block">
                                    <div class="row align-items-end">
                                        <div class="col-8">
                                            <h4 class="text-white"><?php echo !empty($properties['total_count'])?$properties['total_count']:0;?></h4>
                                            <h6 class="text-white m-b-0">Total Properties</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <i class="feather icon-menu icons_dash"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-lite-green update-card">
                                <div class="card-block">
                                    <div class="row align-items-end">
                                        <div class="col-8">
                                            <h4 class="text-white"><?php echo !empty($tours['total_count'])?$tours['total_count']:0;?></h4>
                                            <h6 class="text-white m-b-0">Scheduled Tours</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <i class="feather icon-calendar icons_dash"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- task, page, download counter  end -->

                    </div>

                    <div class="row">
                        <!-- task, page, download counter  start -->
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-lite-green update-card">
                                <div class="card-block">
                                    <div class="row align-items-end">
                                        <div class="col-8">
                                            <h4 class="text-white"><?php echo !empty($rent['total_count'])?$rent['total_count']:0;?></h4>
                                            <h6 class="text-white m-b-0">Total Enquiries For Buy</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <i class="feather icon-mail icons_dash"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-pink update-card">
                                <div class="card-block">
                                    <div class="row align-items-end">
                                        <div class="col-8">
                                            <h4 class="text-white"><?php echo !empty($buy['total_count'])?$buy['total_count']:0;?></h4>
                                            <h6 class="text-white m-b-0">Total Enquiries For Rent</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <i class="feather icon-layers icons_dash"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-yellow update-card">
                                <div class="card-block">
                                    <div class="row align-items-end">
                                        <div class="col-8">
                                            <h4 class="text-white"><?php echo !empty($feeds['total_count'])?$feeds['total_count']:0;?></h4>
                                            <h6 class="text-white m-b-0">Source Feeds</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <i class="feather icon-monitor icons_dash"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="styleSelector">

            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
<!-- Warning Section Ends -->
<!-- Required Jquery -->

<?php include APPPATH.'views/admin/includes/footer.php';?>