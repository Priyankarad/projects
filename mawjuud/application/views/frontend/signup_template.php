<table style="font-family:tahoma;width:499px;margin:0 auto;border:1px solid #eeeeee;border-collapse:collapse;text-align:center;">
	<tr>
		<td>
			<a href="<?php echo base_url()?>" target="_blank" style="display: inline-block;width: 100%;padding: 20px;box-sizing: border-box;">
				<img src="<?php echo base_url()?>assets/images/logo.png" width="102" alt="mawjuud_img"/>
			</a>
		</td>
	</tr>
	<tr>
		<td>
			<h3 style="font-size: 25px;letter-spacing: 0.5px;margin: 0;padding: 20px;">Welcome <span><?php echo isset($username)?ucwords($username):'';?>!</span></h3>
		</td>
	</tr>
	<tr>
		<td style="padding-bottom: 24px;">
			<p style="text-align: center;width: 100%;max-width: 308px;padding-top: 5px;margin: 0 auto;letter-spacing: 0.4px;color: #909090;padding-bottom: 12px;font-size: 17px;">Thanks for signing up! We just need you to verify your email address to complete setting up your account.</p>

			<p style="margin:0;padding: 16px 0 20px 0;">
				<a href="<?php echo isset($url_verify)?$url_verify:'';?>" style="background: #1d65e0; display: inline-block;color: #fff;text-decoration: none;padding: 11px 22px 12px 22px;border-radius: 30px;font-size: 15px;letter-spacing: 0.4px;box-shadow: 0px 0px 23px 0px #ccc;">Verify My Email</a>
			</p>

			<p style="font-size: 15px;line-height: 23px;padding:0 24px 0px 24px;letter-spacing: 0.3px;margin: 0;color: #515151;">
				<b>Thanks & Regards</b>
			</p>
			<p style="font-size: 15px;line-height: 23px;padding:0 24px 0px 24px;letter-spacing: 0.3px;margin: 0;color: #515151;">
				<b>Mawjuud Team</b>
			</p>
		</td>
	</tr>
</table>