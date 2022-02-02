<?php
session_start();
ob_start();

error_reporting(E_COMPILE_ERROR|E_RECOVERABLE_ERROR|E_ERROR|E_CORE_ERROR);

date_default_timezone_set('Asia/Calcutta');

define("TABLE_PREFIX","abgf_");

if($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1')
{
	define("DB_HOST","localhost");
	define("DB_USER","root");
	define("DB_PASS","");
	define("DB_NAME","abogadosfintech");
	define("BASE_URL","http://localhost/abogadosfintech/");
	define("ADMIN_URL","http://localhost/abogadosfintech/abgfcontrolpanel/");
	define("ADMIN_DIR","abgfcontrolpanel/");
	define("HTTP_HOST",'http://');
}
else
{
	define("DB_HOST","db693873680.db.1and1.com");
	define("DB_USER","dbo693873680");
	define("DB_PASS","DDxz4W?$");
	define("DB_NAME","db693873680");
	define("BASE_URL","http://abogadosfintech.com/");
	define("ADMIN_URL","http://abogadosfintech.com/abgfcontrolpanel/");
	define("ADMIN_DIR","abgfcontrolpanel/");
	define("HTTP_HOST",'http://');
}

$con = mysqli_connect(DB_HOST,DB_USER,DB_PASS) or die(mysqli_error());
mysqli_select_db($con,DB_NAME);

define("DEVELOPED_BY","Subhasis Laha");
define("DEVELOPED_BY_URL",BASE_URL);

// Get settings
$config = array();

$getconfig = "SELECT * FROM ".TABLE_PREFIX."config";
$getconfig = mysqli_query($con,$getconfig) or die(mysqli_error());
while($rowconfig = mysqli_fetch_array($getconfig))
{
	$config[$rowconfig['config_type']] = stripslashes($rowconfig['config_val']);
}

/*print "<pre>";
print_r($config);*/

define("PROJECT_NAME",$config['project_name']);
define("PROJECT_ALIAS",$config['project_alias']);
define("DEFAULT_THEME",$config['project_default_theme']);

include('image-magician/php_image_magician.php');
include('class.phpmailer.php');

function getCMS($id,$lang,$con){	

	$getdata = "SELECT PC.*, ML.image_path, PG.page_slug FROM ".TABLE_PREFIX."page_content PC 
				LEFT JOIN ".TABLE_PREFIX."pages PG ON PG.id = PC.page_id
				LEFT JOIN ".TABLE_PREFIX."media_library ML ON ML.id = PG.media_id
				WHERE PC.page_id = '".$id."' AND PC.language_id = '".$lang."'";

	$getdata = mysqli_query($con,$getdata) or die(mysqli_error());

	$rowdata = mysqli_fetch_assoc($getdata);

	return $rowdata;
}

function getBlog($slug,$lang,$con){	

	$getrows = "SELECT BP.*, BC.blog_title, BC.blog_desc, ML.image_path FROM ".TABLE_PREFIX."blog_posts AS BP 
				LEFT JOIN ".TABLE_PREFIX."blog_contents AS BC ON BC.blog_id = BP.id  
				LEFT JOIN ".TABLE_PREFIX."media_library AS ML ON ML.id = BP.media_id  
				WHERE BC.language_id = (".$lang.") AND BP.blog_slug = '".$slug."'";
					   
	$getrows = mysqli_query($con,$getrows) or die(mysqli_error());

	$rowdata = mysqli_fetch_assoc($getrows);

	return $rowdata;
}

function getFeaturedBlog($lang,$con){	

	$getrows = "SELECT BP.*, BC.blog_title, BC.blog_desc, ML.image_path FROM ".TABLE_PREFIX."blog_posts AS BP 
				LEFT JOIN ".TABLE_PREFIX."blog_contents AS BC ON BC.blog_id = BP.id  
				LEFT JOIN ".TABLE_PREFIX."media_library AS ML ON ML.id = BP.media_id  
				WHERE BC.language_id = (".$lang.") AND BP.is_featured = 'Yes' AND BP.flag = '1'";
					   
	$getrows = mysqli_query($con,$getrows) or die(mysqli_error());

	$rowdata = mysqli_fetch_assoc($getrows);

	return $rowdata;
}

function getpageIDbySlug($slug,$con){	

	$getdata = "SELECT id FROM ".TABLE_PREFIX."pages WHERE page_slug = '".$slug."'";

	$getdata = mysqli_query($con,$getdata) or die(mysqli_error());

	$rowdata = mysqli_fetch_assoc($getdata);

	return stripslashes($rowdata['id']);
}

function geteventtitle($seokey,$con){	

	$getsname = "SELECT * FROM ".TABLE_PREFIX."weddingevent WHERE event_seo = '".$seokey."'";

	$getsname = mysqli_query($con,$getsname) or die(mysqli_error());

	$rowsname = mysqli_fetch_array($getsname);	

	return $rowsname['event_title'];
}

function createthmb($filepath,$thumbpath,$thmbwidth,$thmbheight)
{
	$getsize = getimagesize($filepath);	

	$width = $getsize[0];
	$height = $getsize[1];	

	$aspect = $width/$height;	

	$newheight = $thmbheight;

	$newwidth = round($newheight*$aspect,0);	

	//die();

	$magicianObj = new imageLib($filepath);		

	$magicianObj -> resizeImage($newwidth,$newheight);

	$magicianObj -> saveImage($thumbpath, 100);
}

function getDefaultLang($con){	

	$getdata = "SELECT * FROM ".TABLE_PREFIX."languages WHERE is_default = '1' AND flag = '1'";

	$getdata = mysqli_query($con,$getdata) or die(mysqli_error());

	$rowdata = mysqli_fetch_assoc($getdata);

	return $rowdata;
}

function getTranslation($lang,$con){	

	$getTermLanguage = "SELECT TL.*, TR.term FROM ".TABLE_PREFIX."term_language AS TL LEFT JOIN ".TABLE_PREFIX."terms AS TR ON TR.id = TL.term_id WHERE language_id = '".$lang."' AND TR.flag = '1'";
	
	$getTermLanguage = mysqli_query($con,$getTermLanguage) or die(mysqli_error());
	
	$tranArr = array();
	
	$rowsTermLanguage = mysqli_num_rows($getTermLanguage);
	
	if($rowsTermLanguage){
		
		while($rowTrans = mysqli_fetch_array($getTermLanguage)){
			
			$tranArr[stripslashes($rowTrans['term'])] = stripslashes($rowTrans['language_term']);
		}
	}

	return $tranArr;
}

function allcontents($langID,$getLang,$con){
	
	$getdata = "SELECT id FROM ".TABLE_PREFIX."pages";

	$getdata = mysqli_query($con,$getdata) or die(mysqli_error());
	
	$contentData = array();

	while($rowdata = mysqli_fetch_assoc($getdata)){
		
		$sectionContent = getCMS($rowdata['id'],$langID,$con);
	
		$sectionImage = !empty($sectionContent['image_path']) ? ADMIN_URL.'userfiles/'.$sectionContent['image_path'] : '';
		$sectionTitle = stripslashes($sectionContent['page_title']);
		$sectionDesc = stripslashes($sectionContent['page_desc']);
		$sectionLink = BASE_URL.$getLang.'/p/'.stripslashes($sectionContent['page_slug']);
		
		$contentData[$rowdata['id']] = array(
			
			'sectionTitle' => $sectionTitle,
			'sectionImage' => $sectionImage,
			'sectionDesc' => $sectionDesc,
			'sectionLink' => $sectionLink
		);
	}
	
	return $contentData;
}

function sendemail($feedbackid, $config,$con){
	
	//<link rel="stylesheet" type="text/css" href="http://subhasislaha.com/projects/hero-email-template/stylesheets/email.css" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
	
	$getdata = "SELECT * FROM ".TABLE_PREFIX."feedback WHERE id = '".$feedbackid."'";

	$getdata = mysqli_query($con,$getdata) or die(mysqli_error());

	$rowdata = mysqli_fetch_assoc($getdata);
	
	$name = ucwords(stripslashes($rowdata['name']));
	$email = stripslashes($rowdata['email']);
	$message = stripslashes($rowdata['message']);
	$senton = date('dS F Y, h:i:s A',$rowdata['createdate']);
	
	$mailbody = '
		
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
		<head style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
		<!-- If you delete this tag, the sky will fall on your head -->
		<meta name="viewport" content="width=device-width" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
		<title style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">'.PROJECT_NAME.'</title>
		<link rel="stylesheet" type="text/css" href="http://subhasislaha.com/projects/hero-email-template/stylesheets/email.css" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
		</head>
		
		<body bgcolor="#CCCCCC" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;-webkit-font-smoothing: antialiased;-webkit-text-size-adjust: none;height: 100%;width: 100%!important; color:#666; background-color:#CCC;">
		
		 
		
		<!-- BODY -->
		<table class="body-wrap" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 100%; margin-top:20px;">
		  <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
			<td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;"></td>
			<td class="container" bgcolor="#FFFFFF" style="margin: 0 auto!important;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;display: block!important;max-width: 600px!important;clear: both!important;"><div class="content" style="margin: 0 auto;padding: 15px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;max-width: 600px;display: block;">
				
				<!-- HEADER -->
				<table class="head-wrap" bgcolor="#fff" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 100%; border-bottom:1px solid #999; margin-bottom:20px;">
				  <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
					<td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;"></td>
					<td class="header container" style="margin: 0 auto!important;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;display: block!important;max-width: 600px!important;clear: both!important;"><div class="content" style="margin: 0 auto;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;max-width: 600px;display: block;">
						<table bgcolor="#fff" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 100%;">
						  <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
							<td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; vertical-align:middle;"><h1 style="color:#11ABB0; font-size:32px;">'.PROJECT_NAME.'</h1></td>
							<td align="right" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;"><h6 class="collapse" style="margin: 0!important;padding: 0;font-family: &quot;HelveticaNeue-Light&quot;, &quot;Helvetica Neue Light&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Lucida Grande&quot;, sans-serif;line-height: 1.1;margin-bottom: 15px;color: #444;font-weight: 900;font-size: 14px;text-transform: none;">Notification</h6><small><br />Online Enquiry Submission<br />'.$senton.'</small></td>
						  </tr>
						</table>
					  </div></td>
					<td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;"></td>
				  </tr>
				</table>
				<!-- /HEADER -->
				
				<table style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 100%;">
				  <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
					<td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;"><h3 style="margin: 0;padding: 0;font-family: &quot;HelveticaNeue-Light&quot;, &quot;Helvetica Neue Light&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Lucida Grande&quot;, sans-serif;line-height: 1.1;margin-bottom: 15px;color:#333;font-weight: 500;font-size: 22px;">Hello, Admin</h3>
					  <p class="lead" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px; color:#333; line-height: 1.6;">A new enquiry has been submitted on your website. Please check the details below:</p>
					  
					  <p><strong style="font-size:14px">Name</strong>: '.$name.'</p>
					  <p><strong style="font-size:14px">Email</strong>: '.$email.'</p>
					  <p><strong style="font-size:14px">Message</strong>: '.$message.'</p>
					  <p><strong style="font-size:14px">Sent On</strong>: '.$senton.'</p>
					  <p><strong style="font-size:14px">&nbsp;</p>
					  
					  <!-- A Real Hero (and a real human being) -->
					  
					  <!-- social & contact -->
					  
					  <table class="social" width="100%" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;background-color:#11ABB0;width: 100%; color:#fff">
						<tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
						  <td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;"><!--- column 1 -->
							
							<table width="250" align="left" class="column" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 280px;float: left;min-width: 279px;">
							  <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
								<td width="242" style="margin: 0;padding: 15px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;"><p class="" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;">
								
								<a href="'.BASE_URL.'en" style="color:#fff; text-decoration:none">Home</a> |
								<a href="'.BASE_URL.'en/blog" style="color:#fff; text-decoration:none">Blog</a> | 
								<a href="'.BASE_URL.'en/contact" style="color:#fff; text-decoration:none">Contact</a>                        
								
								</p></td>
							  </tr>
							</table>
							<!-- /column 1 --> 
							
							<!--- column 2 -->
							
							<table align="left" class="column" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 280px;float: left;min-width: 279px;">
							  <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
								<td style="margin: 0;padding: 15px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
								
									<p class="" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;">
										
									Follow Us on:
									
									<a href="'.$config['facebook_url'].'"><img src="'.BASE_URL.'images/fgray.png" style="vertical-align:middle" /></a>  
									<a href="'.$config['twitter_url'].'"><img src="'.BASE_URL.'images/tgray.png" style="vertical-align:middle" /></a>
									<a href="'.$config['googleplus_url'].'"><img src="'.BASE_URL.'images/gplusgray.png" style="vertical-align:middle" /></a>
									<a href="'.$config['linkedin_url'].'"><img src="'.BASE_URL.'images/lgray.png" style="vertical-align:middle" /></a>  
									
									</p>
								
								</td>
							  </tr>
							</table>
							<!-- /column 2 --> 
							
							<span class="clear" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;display: block;clear: both;"></span></td>
						</tr>
					  </table>
					  <!-- /social & contact --></td>
				  </tr>
				</table>
			  </div></td>
			<td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;"></td>
		  </tr>
		</table>
		<!-- /BODY --> 
		
		<!-- FOOTER -->
		<table class="footer-wrap" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 100%;clear: both!important;">
		  <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
			<td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;"></td>
			<td class="container" style="margin: 0 auto!important;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;display: block!important;max-width: 600px!important;clear: both!important;"><!-- content -->
			  
			  <div class="content" style="margin: 0 auto;padding: 15px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;max-width: 600px;display: block;">
				<table style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 100%;">
				  <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
					<td align="center" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;"><p style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px; color:#333">Copyright &copy; '.date('Y').'. <a href="'.BASE_URL.'" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#11ABB0; text-decoration:none">'.PROJECT_NAME.'</a>. All Rights Reserved.</p></td>
				  </tr>
				</table>
			  </div>
			  <!-- /content --></td>
			<td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;"></td>
		  </tr>
		</table>
		<!-- /FOOTER -->
		
		</body>
		</html>
		
		';
		
		
	$mail = new PHPMailer();
			
	$subject = PROJECT_NAME.' | New Enquiry Submitted';
	
	$mail->From = $email;
	
	$mail->FromName = $name;
	
	$mail->Subject = $subject;
	
	$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; 
			
	$mail->IsHTML(true);
	
	$mail->Body = $mailbody;
	
	$mail->AddAddress($config['contact_email']);
		
	$mail->Send();
}

function clean($string) {
   $string = strtolower($string);
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

   return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}

function str_replace_first($search, $replace, $subject) {
    return implode($replace, explode($search, $subject, 2));
}
?>