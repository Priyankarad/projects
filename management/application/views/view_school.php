<?php include APPPATH.'views/includes/header.php'; ?>
<div class="main-w3layouts wrapper">
	<h1>School Details</h1>
	<div class="agileits-top">
	<p>
		<a href="<?php echo site_url('school');?>" class="btn btn-info">Go to school list</a>
	</p>
</div>
	<table border='1'>
		<tr>
			<td>Logo</td>
			<td><img id="logo" src="<?php echo !empty($schoolData->logo)?site_url('uploads/logos/').$schoolData->logo:'';?>"></td>
		</tr>
		<tr>
			<td>Registration ID</td>
			<td><?php echo !empty($schoolData->registration_id)?$schoolData->registration_id:'';?></td>
		</tr>
		<tr>
			<td>School Name</td>
			<td><?php echo !empty($schoolData->name)?ucwords($schoolData->name):'';?></td>
		</tr>
		<tr>
			<td>Email Address</td>
			<td><?php echo !empty($schoolData->email)?$schoolData->email:'';?></td>
		</tr>
		<tr>
			<td>Contact No.</td>
			<td><?php echo !empty($schoolData->contact_no)?$schoolData->contact_no:'';?></td>
		</tr>
		<tr>
			<td>Address</td>
			<td><?php echo !empty($schoolData->address)?$schoolData->address:'';?></td>
		</tr>
		<tr>
			<td>No. Of Students</td>
			<td><?php echo !empty($schoolData->students)?$schoolData->students:'';?></td>
		</tr>
	</table>
	<br/>
	<h1>Courses offered by school</h1>
	<table border="1">
		<tr>
			<th>S.No.</th>
			<th>Name</th>
			<th>Duration</th>
			<th>Price</th>
		</tr>
	<?php 
		$id = !empty($schoolData->id)?$schoolData->id:'';
		$sno = 0;
		$coursesList = getServicesList($id,'school');
		if(!empty($coursesList)){
			foreach($coursesList as $course){ ?>
				<tr>
					<td><?php echo ++$sno;?></td>
					<td><?php echo $course->name;?></td>
					<td><?php echo $course->duration;?></td>
					<td><?php echo $course->price;?></td>
				</tr>
			<?php }
		}
	?>
	</table>
</div>
<?php include APPPATH.'views/includes/footer.php'; ?>