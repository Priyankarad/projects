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
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url('dashboard');?>"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">Users List</a>
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
                                <?php
                                if($this->session->flashdata('success')){ ?>
                                    <div class="alert alert-success">
                                        <?php echo $this->session->flashdata('success');?>
                                    </div>
                                <?php }else if($this->session->flashdata('exist')){ ?>
                                    <div class="alert alert-danger">
                                        <?php echo $this->session->flashdata('exist');?>
                                    </div>
                                <?php }
                                ?>        
                                <div class="card-block table-responsive">
                                    <table class="table table-striped table-bordered nowrap datatable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Profile Image</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(!empty($users['result'])){ 
                                                $offset = 0; 
                                                foreach($users['result'] as $user){ 
                                                    $offset++;
                                                    $user_image=base_url().DEFAULT_IMAGE;
                                                    if(!empty($user->profile_thumbnail) && checkRemoteFile($user->profile_thumbnail)){
                                                        $user_image= $user->profile_thumbnail;
                                                    } 
                                                    ?>
                                                    <tr>
                                                        <th scope="row"><?php echo $offset; ?></th>
                                                        <td><img src="<?php  echo $user_image; ?>" class="img-fluid" style="width:50px"></td>
                                                        <td><?php echo ucfirst($user->firstname); ?></td>
                                                        <td><?php echo ucfirst($user->lastname); ?></td>
                                                        <td><?php echo $user->email; ?></td>
                                                        <td><?php echo ($user->verify_status=='verified') ? '<span class="text-success">Verified</span>' : '<span class="text-danger">Unverified</span>' ; ?></td>
                                                        <td>
                                                            <a href="<?php echo base_url();?>agent_edit/<?php echo encoding($user->id);?>" class="btn btn-info"><i class="ion-pencil"></i>Edit</a>  
                                                            <?php $delUrl = base_url('admin/user/delete_data/adagents/property_users/agent/'.encoding($user->id));?>
                                                            <a onclick="return confirm('Do you want to delete')" href="<?php echo $delUrl; ?>" class="btn btn-danger"><i class="ion-ios-trash"></i>Delete</a>
                                                            <?php
                                                            $suspendUrl = base_url('admin/user/suspend/agent/'.$user->id);
                                                           
                                                                if($user->suspend == 0){
                                                            ?>
                                                            <a onclick="return confirm('Do you want to suspend this agent')" href="<?php echo $suspendUrl; ?>" class="btn btn-danger"><i class="ion-ios-close"></i>Suspend</a>
                                                            <?php }else{ ?>
                                                                <a onclick="return confirm('Do you want to unsuspend this agent')" href="<?php echo $suspendUrl; ?>" class="btn btn-success"><i class="ion-ios-done-all"></i>Unsuspend</a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } } ?>  
                                            </tbody>
                                        </table>
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
