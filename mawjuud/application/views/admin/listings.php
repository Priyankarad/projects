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
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Type</th>
                                                <th>Owner</th>
                                                <th>Area</th>
                                                <th>Price</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($propertyListing['result']){
                                                $offset=0; 
                                                foreach($propertyListing['result'] as $property){
                                                    $offset++;
                                                    $first_image=base_url().DEFAULT_PROPERTY_IMAGE;
                                                    if(!empty($property->thumbnail_photo_media)){
                                                        $image_array=explode('|',$property->thumbnail_photo_media);
                                                        $first_image=$image_array[0];
                                                    }
                                                    ?>
                                                    <tr>
                                                        <th scope="row"><?php echo $offset; ?></th>
                                                        <td><img src="<?php  echo $first_image; ?>" class="img-fluid" style="width:80px"></td>
                                                        <td><?php echo substr($property->title,0,40).'...'; ?></td>
                                                        <td><span style="text-transform: capitalize;"><?php echo $property->property_type; ?></span></td>
                                                        <td><?php echo $property->user_name; ?></td>
                                                        <td><?php echo $property->square_feet; ?>/Sq Ft</td>
                                                        <td><?php echo 'AED '.number_format($property->property_price); ?></td>
                                                        <td>

                                                                     <?php
                                                            $approveUrl = base_url('admin/property/approve/'.$property->id);
                                                                if($property->approved == 1){
                                                            ?>
                                                            <a onclick="return confirm('Do you want to unapprove this property ?')" href="<?php echo $approveUrl; ?>" class="btn btn-danger"><i class="ion-ios-close"></i>Unapprove</a>
                                                            <?php }else{ ?>
                                                                <a onclick="return confirm('Do you want to approve this property ?')" href="<?php echo $approveUrl; ?>" class="btn btn-success"><i class="ion-ios-done-all"></i>Approve</a>
                                                            <?php } ?>

                                                            <?php $delUrl = base_url('admin/user/delete_data/listings/property/listing/'.encoding($property->id));?>
                                                            <a onclick="return confirm('Do you want to delete ?')" href="<?php echo $delUrl; ?>" class="btn btn-danger"><i class="ion-ios-trash"></i>Delete</a>
                                                            <?php $editUrl = base_url('property_edit/'.encoding($property->id));?>
                                                            <a  href="<?php echo $editUrl; ?>" class="btn btn-danger"><i class="ion-ios-trash"></i>Edit</a>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            } ?>    

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
