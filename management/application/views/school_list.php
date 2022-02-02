<?php include APPPATH.'views/includes/header.php'; ?>
<div class="main-w3layouts wrapper">
	<h1>School List</h1>
	<div class="main-agileinfo">
		<?php 
			if($this->session->flashdata('success')){ ?>
			<div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
			<?php }
		?>
		<div class="agileits-top">
			<form method='POST' action="<?php echo base_url('school/list'); ?>" >
				<input type='text' name="search" value='<?php echo $search ?>'>
				<input type="submit" name="submit" value="Search">
				<p><a href="<?php echo site_url();?>">Back to home page</a></p><br/>
				<p><a href="<?php echo site_url('create-school');?>">Add School</a></p>
			</form>
		</div>
	</div>
	<table border='1'>
		<tr>
			<th>S.no</th>
			<th>Name</th>
			<th>Registration ID</th>
			<th>Email</th>
			<th>Students</th>
			<th>Contact No.</th>
			<th>Action</th>
		</tr>
		<?php 
		$sno = $row+1;
		foreach($schoolRecords as $school){ ?>
		<tr>
			<td><?php echo $sno++;?></td>
			<td><?php echo $school['name'];?></td>
			<td><?php echo $school['registration_id'];?></td>
			<td><?php echo $school['email'];?></td>
			<td><?php echo $school['students'];?></td>
			<td><?php echo $school['contact_no'];?></td>
			<td>
			<a href="<?php echo site_url('edit-school/').encoding($school['id']);?>">Edit</a>
			<a id="delete" href="<?php echo site_url('school/delete/').encoding($school['id']);?>">Delete</a>
			<a href="<?php echo site_url('view-school/').encoding($school['id']);?>">View</a>
			</td>
		</tr>
		<?php }
		if(count($schoolRecords) == 0){ ?>
		<tr>
			<td colspan='6'>No record found.</td>
		</tr>
		<?php }
		?>
	</table>
	<div class="pagination">
		<?= $pagination; ?>
	</div>
</div>
<?php include APPPATH.'views/includes/footer.php'; ?>