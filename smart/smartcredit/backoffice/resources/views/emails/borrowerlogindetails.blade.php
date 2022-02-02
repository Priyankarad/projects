
@include('emails.partials.header')

<table class="main" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;background:#fff;border-radius:3px;width:100%;">
  <!-- START MAIN CONTENT AREA -->
  <tr>
	<td class="wrapper" style="font-family:sans-serif;font-size:14px;vertical-align:top;box-sizing:border-box;padding:20px;">
	  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;">
		<tr>
		  <td style="font-family:sans-serif;font-size:14px;vertical-align:top;">
			<p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">Apreciad@ {{ $name }},</p>
			
			<p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">Le Your loagin details</p>
			
			<p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">Emailaddress: {{ $emailaddress }}</p>
			
			<p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">Password: {{ $password }}</p>
			
			<p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">
			 <a href="{{ $url }}">Follow up application</a></p>
			
			<p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">Desde {{ $projectname }} queremos agradecerle su confianza.</p>
			
			<p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:5px;"><strong>Reciba un cordial saludo,</strong></p>
			<p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;"><strong>El equipo de {{ $projectname }}</strong></p>
		  </td>
		</tr>
	  </table>
	</td>
  </tr>
  <!-- END MAIN CONTENT AREA -->
</table>

@include('emails.partials.footer')