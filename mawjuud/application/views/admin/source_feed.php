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
                                    <li class="breadcrumb-item"><a href="#!"><?php echo isset($title)?$title:'';?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-body">
                    <div class="row">
                        <a href="<?php echo base_url();?>add_feed" class="btn btn-info">+ Add Feed</a>
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
                                                <th>Source</th>
                                                <th>Url</th>
                                                <th>Type</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            if(!empty($feedData['result'])){
                                                $count = 0;
                                                foreach($feedData['result'] as $feed){ 
                                                    $count++;?>
                                                    <tr>
                                                        <td><?php echo $count;?></td>
                                                        <td><?php echo isset($feed->source)?ucwords($feed->source):'';?></td>
                                                        <td><?php echo isset($feed->feed)?$feed->feed:'';?></td>
                                                        <td><?php echo isset($feed->type)?ucwords($feed->type):0;?></td>
                                                        <td>

                                                            <a href="<?php echo base_url();?>edit_feed/<?php echo encoding($feed->id);?>" class="btn btn-info"><i class="ion-pencil"></i>Edit</a>
                                                            <?php $delUrl = base_url('admin/user/delete_data/source_feeds/source_feeds/feed/'.encoding($feed->id));?>
                                                            <a onclick="return confirm('Do you want to delete')" href="<?php echo $delUrl; ?>" class="btn btn-danger"><i class="ion-ios-trash"></i>Delete</a>

                                                        </td>
                                                    </tr>
                                                <?php }
                                            }
                                            ?>
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
