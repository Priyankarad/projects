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
                                    <li class="breadcrumb-item"><a href="<?php echo site_url('source_feeds');?>">Source Feed List</a>
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
                                    <form id="adminForm" method="post" action="<?php echo base_url();?>add_feed">
                                        <input type="hidden" name="feed_id" value="<?php echo isset($feedData->id)?$feedData->id:'';?>">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Add Source Feed URL</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control validate[required,custom[url]]" id="url" name="url" value="<?php echo isset($feedData->feed)?$feedData->feed:'';?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Select Source Feed</label>
                                            <?php 
                                                $feedType = isset($feedData->source)?$feedData->source:'';
                                            ?>
                                            <div class="col-sm-10">
                                                <select 
                                                class="form-control form-control-default validate[required]" id="source" name="source">
                                                <option value="">Select Source</option>
                                                <option value="gomaster" <?php echo ($feedType=='gomaster')?'selected=selected':'';?>>Gomasterkey</option>
                                                <option value="mycrm" <?php echo ($feedType=='mycrm')?'selected=selected':'';?>>Mycrm</option>
                                                <option value="propspace" <?php echo ($feedType=='propspace')?'selected=selected':'';?>>Propspace</option>
                                                <option value="ycloud" <?php echo ($feedType=='ycloud')?'selected=selected':'';?>>Ycloudcrm</option>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="form-group row types">
                                            <label class="col-sm-2 col-form-label">Select Type</label>
                                            <?php 
                                                $feedType = isset($feedData->type)?$feedData->type:'';
                                            ?>
                                            <div class="col-sm-10">
                                                <select 
                                                class="form-control form-control-default validate[required]" id="type" name="type">
                                                <option value="rent" <?php echo ($feedType=='rent')?'selected=selected':'';?>>Rent</option>
                                                <option value="sale" <?php echo ($feedType=='sale')?'selected=selected':'';?>>Sale</option>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                              <button type="submit" class="btn btn-success">Submit</button>
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
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/custom/source.js"></script>