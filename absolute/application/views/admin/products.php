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
        <li class="active">Products</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
		  <?php alert(); ?>
      <!-- Small boxes (Stat box) -->
      <div class="row">

        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Products List</h3>
			  <div class="text-right"><a href="<?php echo site_url('administrator/addproduct'); ?>" class="btn btn-info"> <i class="fa fa-plus" aria-hidden="true"></i> Add Product</a></div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
			
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Product</th>
                  <th>Images</th>
                  <th>Price</th>
                  <th>Category</th>
                  <th>Modify</th>
                </tr>
				<?php if(!empty($products)){ $i=$offset;; foreach($products as $row){ $i++;
                 $mid=encoding($row->id);
				?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $row->product; 
                
                  ?></td>
                  <td> <img src="<?php echo BASEURL.'uploads/products/'.$row->images;  ?>" class="img-responsive img-circle" style="width:80px"></td>
                  <td><?php echo $row->price;  ?></td>
                  <td><?php
				  $product_categories='';
				  $category='';
				  $pid= $row->category;
				  if(!empty($pid)){
					$carray=explode(',',$pid);
					foreach($carray as $pcr){
				  $ven=getdataByCondition('*',CATEGORY,array('id'=>$pcr));
				  $product_categories.=$ven[0]['category'].',';
					}
					$category=rtrim($product_categories,',');
				  }
				  echo $category;
				  ?></td>
                  <td>
				  <a href="<?php echo site_url('administrator/editproduct/'.$mid);?>" class="btn btn-info btn-sm"> <i class="fa fa-edit"></i></a> &nbsp; 
				 <a href="javascript:void(0)" onclick="return deletedata('<?php echo $mid; ?>','<?php echo PRODUCT; ?>','<?php echo site_url('administrator/deleteusers'); ?>')" class="btn btn-danger btn-sm"> <i class="fa fa-trash-o"></i></a> &nbsp; 
				  &nbsp;  <a href="javascript:void(0)" data-url="<?php echo site_url('product/copy_product/');?>"  data-id="<?php echo $row->id; ?>" class="copy-product btn btn-info btn-sm"> <i class="fa fa-copy"></i></a> 
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