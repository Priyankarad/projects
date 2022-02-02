<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Administrator</a></li>
        <li class="active">Vendors</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
				<?php alert(); ?>
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Vendor List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Currency</th>
                  <th>Modify</th>
                </tr>
				<?php
				if(!empty($vendors)){ $i=$offset; foreach($vendors as $row){ $i++;
                $mid=encoding($row->id);
				?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $row->firstname.' '.$row->lastname;  ?></td>
                  <td><?php echo $row->email;  ?></td>
                  <td><?php echo $row->mobile;  ?></td>
				   <td><?php $cid= $row->currency; $ven=getdataByCondition('*',CURRENCY,array('id'=>$cid)); $currency=$ven[0]['currency'].' ( '.$ven[0]['symbol'].' )'; echo $currency; ?></td>
                  <td>
				  <a href="<?php echo site_url('administrator/editvendor/'.$mid);?>" class="btn btn-info btn-sm"> <i class="fa fa-edit"></i></a> &nbsp; 
				  <a href="javascript:void(0)" onclick="return deletedata('<?php echo $mid; ?>','<?php echo USERS; ?>','<?php echo site_url('administrator/deleteusers'); ?>')" class="btn btn-danger btn-sm"> <i class="fa fa-trash-o"></i></a> &nbsp; 
				  <?php if($row->status==0){ ?>
				  <a href="<?php echo site_url('administrator/approvevendor/'.$mid);?>" class="btn btn-success btn-sm"> <i class="fa fa-check"></i> Click to approve</a> &nbsp; 
				  <?php }else{ ?>
				  <a href="<?php echo site_url('administrator/unapprovevendor/'.$mid);?>" class="btn btn-warning btn-sm"> <i class="fa fa-check"></i> Click to un-approve</a> &nbsp; 
				  <?php } ?>
				  </td>
                </tr>
				<?php } } ?>
                
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <?php echo $pagination; ?>
            </div>
          </div>
	   
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>