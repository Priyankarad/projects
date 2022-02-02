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
              <h3 class="box-title">ORDER List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
          <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                 
                  <th>Product Name</th>
                  <th>Company</th>
                  <th>Customer </th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Address</th>
                  <th>Zip </th>
                  <th> Date</th>
                </tr>
             <?php 
             if(!empty($orders)){ $i=1; foreach($orders as $row){ 
              $a=explode(',',$row->product_id);
              $j=1;
              $pname='';
             foreach($a as $list)
             {
               $OrderDtl=getdataByCondition('product','product',array('id'=>$list));  
               if(!empty($OrderDtl['0']['product'])){
              $pname.= "<p style='background:#666;color:#fff'>".$OrderDtl['0']['product']."<p>";
              $j++;
               }
              
             }
                  ?>
                  <tr>
                  <td style="width: 10px"><?php echo $i; ?></td>
                  <td><?php echo $pname; ?></td>
                  <td><?php echo $row->company; ?></td>
                  <td><?php echo $row->firstname." ". $row->lastname; ?></td>
                  <td><?php echo $row->phone; ?></td>
                  <td><?php echo $row->email; ?></td>
                  <td><?php echo $row->address; ?></td>
                  <td><?php echo $row->zipcode; ?></td>
                  <td><?php echo  $newDate = date("d-m-Y h:i:s A", strtotime($row->postdate)); ?></td>
                </tr>
                <?php  $i++;} } ?>
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