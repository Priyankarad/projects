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
                                                <th>Page Name</th>
                                                <th>Page Contents</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(!empty($pageListing['result'])){ 
                                                $offset = 0; 
                                                foreach($pageListing['result'] as $page){ 
                                                    $offset++;
                                                    ?>
                                                    <tr>
                                                        <th scope="row"><?php echo $offset; ?></th>
                                                        <td><?php echo str_replace('-',' ',ucwords($page->page)); ?></td>
                                                        <td><?php echo !empty($page->content)?substr(ucfirst($page->content),0,150).'...':''; ?></td>
                                                        <td>
                                                            <a href="<?php echo base_url();?>page_edit/<?php echo encoding($page->id);?>" class="btn btn-info"><i class="ion-pencil"></i>Edit</a>  
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
