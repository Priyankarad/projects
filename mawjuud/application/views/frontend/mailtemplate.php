<table style="font-family:tahoma;width:560px;margin:0 auto;border:1px solid #eeeeee;border-collapse:collapse;text-align:center;">
	<tr>
		<td>
			<a href="<?php echo base_url()?>" target="_blank" style="display: inline-block;width: 100%;padding: 20px;box-sizing: border-box;">
				<img src="<?php echo base_url();?>assets/images/logo.png" width="102" alt="mawjuud_img"/>
			</a>
		</td>
	</tr>
	<tr>
		<td style="padding-top: 15px;">
			<h3 style="font-size: 25px;letter-spacing: 0.5px;margin: 0;padding: 20px;">Hi <span><?php echo isset($username)?$username:'';?> !</span></h3>
		</td>
	</tr>
	<tr>
		<td style="padding-bottom: 24px;">
			<p style="font-size: 15px;line-height: 23px;padding:0 24px 15px 24px;letter-spacing: 0.3px;margin: 0;color: #515151;"><?php echo isset($message)?$message:'';?></p>
			

		<p style="font-size: 15px;line-height: 23px;padding:0 24px 0px 24px;letter-spacing: 0.3px;margin: 0;color: #515151;"><b>Thanks & Regards</b>
		</p>
		<p style="font-size: 15px;line-height: 23px;padding:0 24px 0px 24px;letter-spacing: 0.3px;margin: 0;color: #515151;">
				<b>Mawjuud Team</b>
		</p>
		</td>
	</tr>
</table>