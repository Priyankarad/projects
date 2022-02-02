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
              <h3 class="box-title">Category List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Name</th>
                  <th>Parent</th>
                  <th>Modify</th>
                </tr>
				<?php if(!empty($category)){ foreach($category as $row){ $offset++;
                 $mid=encoding($row->id);
				 $parent_id= $row->parent_id;
				 if($parent_id!=0){
				 $parent_category=getdataByCondition('*',CATEGORY,array('id'=>$parent_id));
				 $parent_category_name=$parent_category[0]['category'];
				 }else{
				 $parent_category_name="-"; 
				 }
				?>
                <tr>
                  <td><?php echo $offset; ?></td>
                  <td><?php echo $row->category; ?></td>
                  <td><?php echo $parent_category_name; ?></td>
                  <td>
				  <a href="<?php echo site_url('administrator/editcategory/'.$mid);?>" class="btn btn-info btn-sm"> <i class="fa fa-edit"></i></a> &nbsp; 
				 <a href="javascript:void(0)" onclick="return deletedata('<?php echo $mid; ?>','<?php echo CATEGORY; ?>','<?php echo site_url('administrator/deleteusers'); ?>')" class="btn btn-danger btn-sm"> <i class="fa fa-trash-o"></i></a> &nbsp; 
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