<?php include APPPATH.'views/includes/header.php'; ?>
	<div class="main-w3layouts wrapper">
		<h1>Edit School</h1>
		<div class="main-agileinfo">
			<?php 
			if($this->session->flashdata('success')){ ?>
			<div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
			<?php }
			?>
			<div class="agileits-top">
				<p><a href="<?php echo site_url('school');?>" class="btn btn-info">Go to school list</a></p><br/>

				<?php 
					$schoolData = !empty($schoolData['result'][0])?$schoolData['result'][0]:'';
					$schoolRegisrtationNo = !empty($schoolData->registration_id)?$schoolData->registration_id:'';
				?>
				<p><strong class="reg_id">Registration ID : <?php echo $schoolRegisrtationNo;?></strong></p>
				<form action="<?php echo site_url('school/update');?>" method="post" class="managementForm" enctype="multipart/form-data">

					<input type="hidden" name="school_id" value="<?php echo !empty($schoolData->id)?$schoolData->id:'';?>"> 

					<input class="text validate[required]" type="text" name="school_name" placeholder="School Name" value="<?php echo !empty($schoolData->name)?$schoolData->name:set_value('school_name');?>" readonly>
					<?php echo form_error('school_name','<div class="error">', '</div>'); ?>

					<input class="text validate[required,custom[email]]" type="text" name="email" placeholder="Email Address" value="<?php echo !empty($schoolData->email)?$schoolData->email:set_value('email');?>">
					<?php echo form_error('email','<div class="error">', '</div>'); ?>

					<input class="text validate[required]" type="text" name="students" placeholder="Number Of Students" value="<?php echo !empty($schoolData->students)?$schoolData->students:set_value('students');?>">
					<?php echo form_error('students','<div class="error">', '</div>'); ?>

					<input class="text validate[required]" type="text" name="contact_number" placeholder="Contact Number" value="<?php echo !empty($schoolData->contact_no)?$schoolData->contact_no:set_value('contact_number');?>">
					<?php echo form_error('contact_number','<div class="error">', '</div>'); ?>

					<input class="text" type="file" accept=".jpg,.jpeg,.png" id="school_logo" name="school_logo">
					<?php echo form_error('school_logo','<div class="error">', '</div>'); ?>

					<img src="<?php echo site_url('uploads/logos/').$schoolData->logo;?>" id="logo">

					<textarea class="text validate[required]" name="address" placeholder="Address"><?php echo !empty($schoolData->address)?$schoolData->address:set_value('address');?></textarea>
					<?php echo form_error('address','<div class="error">', '</div>'); ?>

					<select class="courses" name="courses[]" multiple>
						<?php 
							$courses = !empty($schoolData->courses)?explode(',', $schoolData->courses):array();
							if(!empty($courseData['result'])){
								foreach($courseData['result'] as $course){ ?>
								<option value="<?php echo $course->id;?>" <?php echo (in_array($course->id,$courses))?'selected':'';?>><?php echo $course->name;?></option>
								<?php }
							}
						?>
					</select>
					<?php echo form_error('courses[]','<div class="error">', '</div>'); ?>

					<input type="submit" value="Update">
				</form>
				<p><a href="<?php echo site_url();?>">Back to home page</a></p>
			</div>
		</div>
	</div>
<?php include APPPATH.'views/includes/footer.php'; ?>