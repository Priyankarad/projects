<?php include APPPATH.'views/frontend/includes/header.php'; ?>

<div class="new_passwordG">
	<div class="container">
		<form id="newpass_frm" method="post" action="javascript:void(0);">
			<h4 class="modal-title"><center>Reset Password</center></h4>
			<div class="signup_error card-panel red lighten-3" style="display:none">
				<strong></strong>
			</div>
			<div class="signup_success card-panel teal accent-3" style="display:none">
				<strong></strong>
			</div>
			<input type="hidden" id="user_id" name="user_id" value="<?php echo isset($user_id)?$user_id:'';?>">
			<input type="password" name="newpassword" id="newpassword" placeholder="New Password" class="form-control">
			<input type="password" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" class="form-control">
			<button type="submit" class="newpasswordS">Save</button>
			<a href="<?php echo base_url();?>?popup=login">Login</a>
		</form>
	</div>
</div>

<?php include APPPATH.'views/frontend/includes/footer.php'; ?>
<?php include APPPATH.'views/frontend/includes/footer_script.php'; ?>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/frontend/login.js"></script>