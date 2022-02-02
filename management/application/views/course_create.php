<?php include APPPATH.'views/includes/header.php'; ?>
	<div class="main-w3layouts wrapper">
		<h1>Create Course</h1>
		<div class="main-agileinfo">
			<div class="agileits-top">
				<p><a href="<?php echo site_url('course');?>" class="btn btn-info">Go to course list</a></p><br/>
				<form action="#" method="post" class="managementForm" enctype="multipart/form-data">
					<input class="text validate[required]" type="text" name="course_name" placeholder="Course Name" value="<?php echo set_value('course_name');?>">
					<?php echo form_error('course_name','<div class="error">', '</div>'); ?>

					<input class="text validate[required]" type="text" name="duration" placeholder="Course Duration (in 1-10 years)" value="<?php echo set_value('duration');?>">
					<?php echo form_error('duration','<div class="error">', '</div>'); ?>

					<input class="text validate[required]" type="text" name="price" placeholder="Course Price" value="<?php echo set_value('price');?>">
					<?php echo form_error('price','<div class="error">', '</div>'); ?>

					<select class="courses" name="schools[]" multiple>
						<?php 
							if(!empty($schoolData['result'])){
								foreach($schoolData['result'] as $school){ ?>
								<option value="<?php echo $school->id;?>"><?php echo $school->name;?></option>
								<?php }
							}
						?>
					</select>
					<?php echo form_error('schools[]','<div class="error">', '</div>'); ?>

					<input type="submit" value="Save">
				</form>
				<p><a href="<?php echo site_url();?>">Back to home page</a></p>
			</div>
		</div>
	</div>
<?php include APPPATH.'views/includes/footer.php'; ?>