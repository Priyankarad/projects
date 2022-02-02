<?php include('header.php'); ?>

<div class="wrapper row-offcanvas row-offcanvas-left">

  <!-- Left side column. contains the logo and sidebar -->
  <?php include('leftpanel.php'); ?>
  
  <!-- Right side column. Contains the navbar and content of the page -->
  <aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> <i class="glyphicon glyphicon-home"></i> Dashboard <small>Control panel</small> </h1>
	  
      <?php include('breadcrumb.php'); ?>
	  
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12">
          <!-- Chat box -->
          <div class="box box-success">
            <div class="box-header"> <i class="fa fa-user-md"></i>
              <h3 class="box-title">Welcome</h3>
            </div>
            <div class="box-body" style="text-align:center">
				
				<h1 style="margin:0 0 30px 0"><strong><?=PROJECT_NAME?></strong> Control Panel</h1>
				
            </div>
            <!-- /.chat -->
          </div>
          <!-- /.box (chat box) -->
        </section>
        <!-- /.Left col -->
      </div>
      <!-- /.row (main row) -->
	  
	  <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12">
          <!-- Chat box -->
          <div class="box box-success">
            <div class="box-header"> <i class="fa fa-comments-o"></i>
              <h3 class="box-title">Last 5 Blog Posts</h3>
            </div>
            <div class="box-body table-responsive">
				
			  <table id="example1" class="table table-bordered table-striped table-mailbox">
                <thead>
                  <tr>	
                    <th>Sl No.</th>
				    <th>Blog Title</th>
                    <th>Posted On</th>
                    <th>Active</th>
				    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
				  
				  <?php
					$sl = 1;
					$getDefaultLang = "SELECT id FROM ".TABLE_PREFIX."languages WHERE is_default = '1'";
						
					$getrows = "SELECT BP.*, BC.blog_title, BC.blog_desc FROM ".TABLE_PREFIX."blog_posts AS BP LEFT JOIN ".TABLE_PREFIX."blog_contents AS BC ON BC.blog_id = BP.id  WHERE BC.language_id = (".$getDefaultLang.") ORDER BY id DESC";
							   
					$getrows = mysqli_query($con,$getrows) or die(mysqli_error());
					while($row = mysqli_fetch_array($getrows)){
						?>
						
						<tr >
							<td class="<?=$row['read'] == 'No' ? 'unread' : ''?>"><?=$sl?></td>
							<td class="center"><?=stripslashes($row['blog_title'])?></td>
							<td class="center"><?=date('dS M Y',stripslashes($row['createdate']))?></td>
							<td class="center"><?=$row['flag'] == '0' ? 'No' : 'Yes'?></td>
							<td class="center <?=$row['read'] == 'No' ? 'unread' : ''?>">
								<div class="btn-group">
									<button type="button" class="btn btn-warning btn-sm" onclick="location.href='<?php echo('blogposts.php?mode=edit&id='.$row['id']); ?>'"><i class='glyphicon glyphicon-edit'></i> Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="del('<?=$row['id']?>')"><i class='glyphicon glyphicon-trash'></i> Delete</button>
								</div>
							</td>
						</tr>
						
						<?php
						$sl++;
					}
					?>
						
				  
                </tbody>
              </table>
				
            </div>
            <!-- /.chat -->
          </div>
          <!-- /.box (chat box) -->
        </section>
        <!-- /.Left col -->
      </div>
      <!-- /.row (main row) -->
	  
    </section>
    <!-- /.content -->
  </aside>
  <!-- /.right-side -->
  
</div>
<!-- ./wrapper -->

<?php include('commonjs.php'); ?>

<?php include('footer.php'); ?>