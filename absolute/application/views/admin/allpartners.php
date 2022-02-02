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
        <li class="active">Category</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
				<?php alert(); ?>
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Partner List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Name</th>
                  <th>Content</th>
                  <th>Modify</th>
                </tr>
				<?php if(!empty($partners)){ foreach($partners as $row){ $offset++;
                 $mid=encoding($row->id);
				?>
                <tr>
                  <td><?php echo $offset; ?></td>
                  <td><?php echo $row->title; ?></td>
                  <td><?php echo $row->content; ?></td>
                  <td><img style="width: 100px;height: 100px;" src="<?=site_url().$row->images?>"/></td>
                  <td>
				  <a href="<?php echo site_url('editpartners/'.$mid);?>" class="btn btn-info btn-sm"> <i class="fa fa-edit"></i></a> &nbsp; 
				 <a href="javascript:void(0)" onclick="return deletedata('<?php echo $mid; ?>','<?php echo PARTNERS; ?>','<?php echo site_url('administrator/deletepartner'); ?>')" class="btn btn-danger btn-sm"> <i class="fa fa-trash-o"></i></a> &nbsp; 
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