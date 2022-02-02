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
        <li class="active">Article</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
				<?php alert(); ?>
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Article List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Image</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Modify</th>
                </tr>
				<?php if(!empty($markets)){ $i=$offset; foreach($markets as $row){ $i++;
                 $mid=encoding($row->id);
				?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><img src="<?php echo BASEURL.'uploads/article/'.$row->image;  ?>" style="width:150px;" class="img-thumbnail" ></td>
                  <td><?php echo $row->title;  ?></td>
                  <td>
					<?php
						$string=$row->description;
						$string = strip_tags($string);
						if (strlen($string) > 70) {
						// truncate string
						$stringCut = substr($string, 0, 70);
						$endPoint = strrpos($stringCut, ' ');

						//if the string doesn't contain any space then it will cut without word basis.
						$string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
						$string .= '...';
						}
						echo $string;
					?>
				  </td>
                  <td>
				  <a href="<?php echo site_url('administrator/editarticle/'.$mid);?>" class="btn btn-info btn-sm"> <i class="fa fa-edit"></i></a> &nbsp; 
				  <a href="javascript:void(0)" onclick="return deletedata('<?php echo $mid; ?>','<?php echo ARTICLE; ?>','<?php echo site_url('administrator/deleteusers'); ?>')" class="btn btn-danger btn-sm"> <i class="fa fa-trash-o"></i></a> &nbsp; 
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