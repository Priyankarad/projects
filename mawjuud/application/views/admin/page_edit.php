<?php include APPPATH.'views/admin/includes/header.php';?>
<div class="pcoded-content">
	<div class="pcoded-inner-content">
		<div class="main-body">
			<div class="page-wrapper">
				<!-- Page-header start -->
				<div class="page-header">
					<div class="row align-items-end">
						<div class="col-lg-8">
							<div class="page-header-title">
								<div class="d-inline">
									<h4><?php echo isset($title)?$title:'';?></h4>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="page-header-breadcrumb">
								<ul class="breadcrumb-title">
									<li class="breadcrumb-item">
										<a href="<?php echo site_url('dashboard');?>"> <i class="feather icon-home"></i> </a>
									</li>
									<li class="breadcrumb-item"><a href="<?php echo site_url('page_settings');?>">Page Settings List</a>
									</li>
									<li class="breadcrumb-item"><a href="#!"><?php echo isset($title)?$title:'';?></a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>

				<div class="page-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-header">
									<h5><?php echo isset($title)?$title:'';?></h5>
								</div>
								<div class="card-block">
									<form id="adminForm" action="<?php echo site_url('page_edit/'.encoding(isset($pageData->id)?$pageData->id:''));?>" method="post">
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Page Name</label>
											<div class="col-sm-10">
												<input type="text" readonly="" class="form-control" value="<?php echo isset($pageData->page)?ucfirst(str_replace('-',' ',ucwords($pageData->page))):'';?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Content</label>
											<div class="col-sm-10">
												<textarea class="form-control mceEditor" name="contents"><?php echo !empty($pageData->content) ? $pageData->content : ''; ?></textarea>
											</div>
										</div>
										<div class="form-group row">
											<button type="submit" class="btn btn-success">Update</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include APPPATH.'views/admin/includes/footer.php';?>
<!-- <script type="text/javascript" src="<?php echo site_url('assets/js/tinymce.min.js');?>"></script> -->
<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=o3of1jlh4sgz42v00lie16mm4vcprpogubffn77tkpv6ssln"></script>

<script type="text/javascript">
	$(document).ready(function() {
  tinymce.init({
    selector: 'textarea',
    height: 500,
    menubar: false,
});
  });
</script>