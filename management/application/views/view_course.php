<?php include APPPATH.'views/includes/header.php'; ?>
<div class="main-w3layouts wrapper">
	<h1>Course Details</h1>
	<div class="agileits-top">
	<p>
		<a href="<?php echo site_url('course');?>" class="btn btn-info">Go to course list</a>
	</p>
</div>
	<table border='1'>
		<tr>
			<td>Course Name</td>
			<td><?php echo !empty($courseData->name)?ucwords($courseData->name):'';?></td>
		</tr>
		<tr>
			<td>Duration</td>
			<td><?php echo !empty($courseData->duration)?$courseData->duration:'';?></td>
		</tr>
		<tr>
			<td>Price</td>
			<td><?php echo !empty($courseData->price)?$courseData->price:'';?></td>
		</tr>
	</table>
	<br/>
	<h1>Schools of the courses</h1>
	<table border="1">
		<tr>
			<th>S.No.</th>
			<th>Name</th>
			<th>Registration ID</th>
			<th>Email</th>
			<th>Students</th>
			<th>Contact No.</th>
		</tr>
	<?php 
		$id = !empty($courseData->id)?$courseData->id:'';
		$sno = 0;
		$schoolsList = getServicesList($id,'course');
		if(!empty($schoolsList)){
			foreach($schoolsList as $school){ ?>
				<tr>
					<td><?php echo ++$sno;?></td>
					<td><?php echo $school->name;?></td>
					<td><?php echo $school->registration_id;?></td>
					<td><?php echo $school->email;?></td>
					<td><?php echo $school->students;?></td>
					<td><?php echo $school->contact_no;?></td>
				</tr>
			<?php }
		}
	?>
	</table>
</div>
<?php include APPPATH.'views/includes/footer.php'; ?>