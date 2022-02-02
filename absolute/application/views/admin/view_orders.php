<?php error_reporting(0); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Administrator</a></li>
        <li class="active">ORDERS</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
			<?php alert(); ?>
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="box">
            <div class="box-header with-border">
			   <div class="row clearfix">
			   <div class="col-md-6"><h3 class="box-title">ORDER List</h3></div>
			   <div class="col-md-6 text-right"> <a href="<?php echo site_url('administrator/allorders'); ?>" class="btn btn-info" > < Back</a></div>
               </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>IMAGE</th>
                  <th>PRODUCT</th>
                  <th>Quantity</th>
                  <th>COLOR</th>
                  <th>SIZE</th>
                  <th>CUSTOMER</th>
                  <th>DATE</th>
                 
                </tr>
				<?php
				if(!empty($orderdetails)){ $i=0; foreach($orderdetails as $row){
				  
				    $i++;
                 $order_id=encoding($row->id);
				 $product_id=$row->productid;
				 $productDtl=getdataByCondition('*',PRODUCT,array('id'=>$product_id));
				
				 $image=$productDtl[0]['images'];
				 $size_id=$row->product_size;
				 $sizeDtl=getdataByCondition('*',SIZE,array('id'=>$size_id));
				 $size=$sizeDtl[0]['size'];
				 $color_id=$row->product_color;
				 $colorDtl=getdataByCondition('*',COLOR,array('id'=>$color_id));
				 $color=$colorDtl[0]['color'];
				 $color_image=$colorDtl[0]['image'];
				?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><img src="<?php echo BASEURL.'uploads/products/'.$image;  ?>" style="width:80px" class="img-responsive"></td>
                  <td><?php echo $row->product_name;  ?> </td>
                  <td><?php echo $row->product_quantity;  ?></td>
                  <td><img src="<?php echo BASEURL.'uploads/colors/'.$color_image;  ?>" style="width:50px" class="img-responsive img-circle"><?php echo $color;  ?></td>
                  <td><?php echo $size;  ?></td>
                  <td><?php echo $row->firstname.' '.$row->lastname;  ?></td>
                  <td><?php echo date('d-m-Y', strtotime($row->lastupdate));  ?></td>
                  
                </tr>
				<?php } } ?>
                
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              
            </div>
          </div>
	   
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>