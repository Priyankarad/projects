<?php include APPPATH.'views/admin/includes/header.php';?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-header start -->
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4><?php echo isset($title)?$title:'';?></h4>
                                </div>
                            </div>
                            <?php
                                if($this->session->flashdata('success')){ ?>
                                    <div class="alert alert-success">
                                        <?php echo $this->session->flashdata('success');?>
                                    </div>
                                <?php }
                                ?>        
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url('dashboard');?>"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!"><?php echo isset($title)?$title:'';?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5><?php echo isset($title)?$title:'';?></h5>
                                </div>
                                <div class="card-block">
                                    <form id="adminForm" action="<?php echo site_url('profile');?>" method="post" enctype= multipart/form-data>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Firstname</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control validate[required,custom[onlyLetterSp]]" id="firstname" name="firstname" value="<?php echo isset($userData->firstname)?$userData->firstname:'';?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Lastname</label>
                                            <div class="col-sm-10">
                                                <input type="text" id="lastname" name="lastname" class="form-control validate[required,custom[onlyLetterSp]]" value="<?php echo isset($userData->lastname)?$userData->lastname:'';?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="text" id="email" name="email" class="form-control" readonly="" value="<?php echo isset($userData->email)?$userData->email:'';?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Upload Profile Image</label>
                                            <div class="col-sm-5">
                                                <input type="file" id="profile_img" name="profile_img" class="form-control" accept="image/*">
                                            </div>
                                            <?php
                                            $img = base_url().DEFAULT_PROPERTY_IMAGE;
                                            if(checkRemoteFile($userData->profile_thumbnail)){
                                                $img = $userData->profile_thumbnail; 
                                            }
                                            ?>
                                            <div class="col-sm-5 user_img">
                                                <img id="user_img" src="<?php echo $img;?>" height="100" width="100">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                              <button type="submit" class="btn btn-success">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include APPPATH.'views/admin/includes/footer.php';?>
<script type="text/javascript">
    $("#profile_img").change(function() {
        readURL(this,'user_img');
    });
</script>