<?php include('header.php'); ?>

<div class="wrapper row-offcanvas row-offcanvas-left">

  <!-- Left side column. contains the logo and sidebar -->
  <?php include('leftpanel.php'); ?>
  
  <!-- Right side column. Contains the navbar and content of the page -->
  <aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> <i class="glyphicon glyphicon-list-alt"></i> <?=$title?> </h1>
	  
      <?php include('breadcrumb.php'); ?>
	  
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
	  
	  <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12">
		  
			
			<?php
			if($_REQUEST['action']=='updated'){
			?>
			<div class="alert alert-success alert-dismissable">
				<i class="fa fa-check"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?=$title?> Updated
			</div>
			<?php
			}
			if($_REQUEST['action']=='added'){
			?>
			<div class="alert alert-success alert-dismissable">
				<i class="fa fa-check"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?=$title?> Added
			</div>
			<?php
			}
			if($_REQUEST['action']=='deleted'){
			?>
			<div class="alert alert-success alert-dismissable">
				<i class="fa fa-check"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?=$title?> Deleted
			</div>
			<?php
			}
			?>
		  
		  
          <!-- Chat box -->
          <div class="box box-success">
		  	
			<form action="pages.php" method="post" name="frmlisting">
			<input type="hidden" name="mode" value="" />
			<input type="hidden" name="id" value="" />
			
            <div class="box-header"> 
              
            </div>
            <div class="box-body table-responsive">
				
				<table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Sl No.</th>
				    <th>Page Title</th>
				    <th>Page Slug</th>
				    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
				  
				  <?php
					$sl = 1;
					$getrows = "SELECT * FROM ".TABLE_PREFIX."pages";
							   
					$getrows = mysqli_query($con,$getrows) or die(mysqli_error());
					while($row = mysqli_fetch_array($getrows)){
						?>
						
						<tr>
							<td><?=$sl?></td>
							<td class="center"><?=stripslashes($row['page_name'])?></td>
							<td class="center"><?=stripslashes($row['page_slug'])?></td>
							<td class="center">
								<div class="btn-group">
									<button type="button" class="btn btn-warning btn-sm" onclick="location.href='managepage.php?mode=edit&id=<?=$row['id']?>'"><i class='fa fa-edit'></i></button>
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
			
			</form>
			
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