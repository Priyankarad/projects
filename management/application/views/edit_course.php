<?php include APPPATH.'views/includes/header.php'; ?>
<div class="main-w3layouts wrapper">
	<h1>Edit Course</h1>
	<div class="main-agileinfo">
		<?php 
		if($this->session->flashdata('success')){ ?>
		<div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
		<?php }
		?>
		<div class="agileits-top">
			<p><a href="<?php echo site_url('course');?>" class="btn btn-info">Go to course list</a></p><br/>
			<?php 
				$courseData = !empty($courseData['result'][0])?$courseData['result'][0]:'';
			?>
			<form action="<?php echo site_url('course/update');?>" method="post" class="managementForm" enctype="multipart/form-data">

				<input type="hidden" name="course_id" value="<?php echo !empty($courseData->id)?$courseData->id:'';?>">

				<input class="text validate[required]" type="text" name="course_name" placeholder="Course Name" value="<?php echo !empty($courseData->name)?$courseData->name:set_value('course_name');?>" readonly>
				<?php echo form_error('course_name','<div class="error">', '</div>'); ?>

				<input class="text validate[required]" type="text" name="duration" placeholder="Course Duration (in 1-10 years)" value="<?php echo !empty($courseData->duration)?$courseData->duration:set_value('duration');?>">
				<?php echo form_error('duration','<div class="error">', '</div>'); ?>

				<input class="text validate[required]" type="text" name="price" placeholder="Course Price" value="<?php echo !empty($courseData->price)?$courseData->price:set_value('price');?>">
				<?php echo form_error('price','<div class="error">', '</div>'); ?>

				<select class="courses" name="schools[]" multiple>
					<?php 
						$schools = !empty($courseData->schools)?explode(',', $courseData->schools):array();
					if(!empty($schoolData['result'])){
						foreach($schoolData['result'] as $school){ ?>
						<option value="<?php echo $school->id;?>" <?php echo (in_array($school->id,$schools))?'selected':'';?>><?php echo $school->name;?></option>
						<?php }
					}
					?>
				</select>
				<?php echo form_error('schools[]','<div class="error">', '</div>'); ?>

				<input type="submit" value="Update">
			</form>
			<p><a href="<?php echo site_url();?>">Back to home page</a></p>
		</div>
	</div>
</div>
<?php include APPPATH.'views/includes/footer.php'; ?>