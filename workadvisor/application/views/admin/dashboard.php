<section id="content">
            <div class="container">
                <header class="page-header">
                    <h3>Dashboard </h3>
                </header>
                
                <a href="<?php echo base_url(); ?>Performers">
                <div class="overview row">
                    <div class="col-md-4 col-sm-6">
                        <div class="o-item bg-cyan">
                            <div class="oi-title">
                                <span data-value="450382"></span>
                                <span>Total Performers</span>
                            </div>
                            <h1><?php echo getAllCount(USERS,array('user_role'=>'Performer')); ?></h1>
                        </div>
                    </div>
                </a>

                    <!-- <div class="col-md-4 col-sm-6">
                        <div class="o-item bg-creat">
                            <div class="oi-title">
                                <span data-value="8737"></span>
                                <span>Last Login</span>
                            </div>
                            <h3 class="last_login"><?php echo convertDateTime($this->session->userdata("last_login")); ?></h3>
                        </div>
                    </div> -->

                    <a href="<?php echo base_url(); ?>Employer">
                        <div class="col-md-4 col-sm-6">
                            <div class="o-item bg-bluegray">
                                <div class="oi-title">
                                    <span data-value="8737"></span>
                                    <span>Employers</span>
                                </div>
                                <h1><?php echo getAllCount(USERS,array('user_role'=>'Employer')); ?></h1>
                            </div>
                        </div> 
                    </a>


                    <a href="<?php echo base_url(); ?>admin/aproved_categories"> 
                        <div class="col-md-4 col-sm-6">
                            <div class="o-item bg-indigo">
                                <div class="oi-title">
                                    <span data-value="450382"></span>
                                    <span>Aproved Categories</span>
                                </div>
                                <h1><?php echo getAllCount(CATEGORY,array('category_status'=>1)); ?></h1>
                            </div>
                        </div>
                    </a>
                   
                </div>

            </div>
        </section>
