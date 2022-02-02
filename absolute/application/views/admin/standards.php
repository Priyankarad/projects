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
        <li class="active">Standard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
				<?php alert(); ?>
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Standard List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Modify</th>
                </tr>
				<?php if(!empty($markets)){ $i=$i=$offset;; foreach($markets as $row){ $i++;
                 $mid=encoding($row->id);
				?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><img src="<?php echo BASEURL.'uploads/standard/'.$row->image;  ?>" style="width:150px;" class="img-thumbnail" ></td>
                  <td><?php echo $row->name;  ?></td>
                  <td>
				  <a href="<?php echo site_url('administrator/editstandard/'.$mid);?>" class="btn btn-info btn-sm"> <i class="fa fa-edit"></i></a> &nbsp; 
				  <a href="javascript:void(0)" onclick="return deletedata('<?php echo $mid; ?>','<?php echo STANDARD; ?>','<?php echo site_url('administrator/deleteusers'); ?>')" class="btn btn-danger btn-sm"> <i class="fa fa-trash-o"></i></a> &nbsp; 
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