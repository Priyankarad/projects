<?php include APPPATH.'views/includes/header.php'; ?>
<div class="main-w3layouts wrapper">
	<h1>Course List</h1>
	<div class="main-agileinfo">
		<?php 
			if($this->session->flashdata('success')){ ?>
			<div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
			<?php }
		?>
		<div class="agileits-top">
			<form method='POST' action="<?php echo base_url('course/list'); ?>" >
				<input type='text' name="search" value='<?php echo $search ?>'>
				<input type="submit" name="submit" value="Search">
				<p><a href="<?php echo site_url();?>">Back to home page</a></p><br/>
				<p><a href="<?php echo site_url('create-course');?>">Add Course</a></p>
			</form>
		</div>
	</div>
	<table border='1'>
		<tr>
			<th>S.no</th>
			<th>Name</th>
			<th>Duration</th>
			<th>Price</th>
			<th>Action</th>
		</tr>
		<?php 
		$sno = $row+1;
		foreach($courseRecords as $course){ ?>
		<tr>
			<td><?php echo $sno++;?></td>
			<td><?php echo $course['name'];?></td>
			<td><?php echo $course['duration'];?></td>
			<td><?php echo $course['price'];?></td>
			<td>
			<a href="<?php echo site_url('edit-course/').encoding($course['id']);?>">Edit</a>
			<a id="delete" href="<?php echo site_url('course/delete/').encoding($course['id']);?>">Delete</a>
			<a href="<?php echo site_url('view-course/').encoding($course['id']);?>">View</a>
			</td>
		</tr>
		<?php }
		if(count($courseRecords) == 0){ ?>
		<tr>
			<td colspan='4'>No record found.</td>
		</tr>
		<?php }
		?>
	</table>
	<div class="pagination">
		<?= $pagination; ?>
	</div>
</div>
<?php include APPPATH.'views/includes/footer.php'; ?>