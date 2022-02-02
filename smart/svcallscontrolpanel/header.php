<?php
include('../config.php');

/*print "<pre>";
print_r($_SESSION);
die();*/

if(isset($_POST['changetheme']) && $_POST['changetheme'] == 'yes')
{
	$updatetheme = "UPDATE ".TABLE_PREFIX."admin SET theme = '".$_POST['theme']."' WHERE id = '".$_SESSION[base64_encode(PROJECT_NAME).'userid']."'";
	mysqli_query($con,$updatetheme) or die(mysqli_error());
}

//print "<pre>";
//print_r($breadcrumb);

$getuserdet = "SELECT * FROM ".TABLE_PREFIX."admin WHERE id = '".$_SESSION[base64_encode(PROJECT_NAME).'userid']."'";
$getuserdet = mysqli_query($con,$getuserdet) or die(mysqli_error());
$rowuserdet = mysqli_fetch_array($getuserdet);


$pagenav = end(explode("/",$_SERVER['REQUEST_URI']));
$pagenav = explode(".",$pagenav);
$pagenav = $pagenav[0];

switch($pagenav)
{
	case 'dashboard':
		$title = 'Dashboard';
		$breadcrumb = array(
			'0' => array(
				'title' => $title,
				'path' => $pagenav.'.php'
			)
		);
		$selection[$pagenav] = 'class="active"';
		$selectiongroup[$pagenav] = 'active';
		break;
		
	case 'change_pass':
		$title = 'Change Password';
		$breadcrumb = array(
			'0' => array(
				'title' => 'Dashboard',
				'path' => 'dashboard.php'
			),
			'1' => array(
				'title' => $title,
				'path' => $pagenav.'.php'
			)
		);
		$selection[$pagenav] = 'class="active"';
		$selectiongroup['change_pass'] = 'active';
		break;
		
	case 'settings':
		$title = 'Settings';
		$breadcrumb = array(
			'0' => array(
				'title' => 'Dashboard',
				'path' => 'dashboard.php'
			),
			'1' => array(
				'title' => $title,
				'path' => $pagenav.'.php'
			)
		);
		$selection[$pagenav] = 'class="active"';
		$selectiongroup['settings'] = 'active';
		break;
				
	case 'pages':
		$title = 'CMS Page';
		$breadcrumb = array(
			'0' => array(
				'title' => 'Dashboard',
				'path' => 'dashboard.php'
			),
			'1' => array(
				'title' => $title,
				'path' => $pagenav.'.php'
			)
		);
		$selection[$pagenav] = 'class="active"';
		$selectiongroup['pages'] = 'active';
		break;
		
	case 'managepage':
		$title = ucfirst($_REQUEST['mode']).' CMS Page';
		$breadcrumb = array(
			'0' => array(
				'title' => 'Dashboard',
				'path' => 'dashboard.php'
			),
			'1' => array(
				'title' => 'CMS Page',
				'path' => 'pages.php'
			),
			'2' => array(
				'title' => $title,
				'path' => '#'
			)
		);
		$selection['pages'] = 'class="active"';
		$selectiongroup['pages'] = 'active';
		break;	
		
		
	case 'medialibrary':
		$title = isset($_REQUEST['mode']) ? ucfirst($_REQUEST['mode']).' Media' : 'Media Library';
		$breadcrumb = array(
			'0' => array(
				'title' => 'Dashboard',
				'path' => 'dashboard.php'
			),
			'1' => array(
				'title' => 'Media Library',
				'path' => $pagenav.'.php'
			)
		);
		if(isset($_REQUEST['mode'])){
			
			$breadcrumb[] = array(
				'title' => $title,
				'path' => '#'
			);
		}
		$selection[$pagenav] = 'class="active"';
		$selectiongroup['medialibrary'] = 'active';
		break;
		
	case 'terms':
		$title = isset($_REQUEST['mode']) ? ucfirst($_REQUEST['mode']).' Term' : 'Terms';
		$breadcrumb = array(
			'0' => array(
				'title' => 'Dashboard',
				'path' => 'dashboard.php'
			),
			'1' => array(
				'title' => 'Terms',
				'path' => $pagenav.'.php'
			)
		);
		if(isset($_REQUEST['mode'])){
			
			$breadcrumb[] = array(
				'title' => $title,
				'path' => '#'
			);
		}
		$selection['languagetranslation'] = 'class="active"';
		$selectiongroup['languagetranslation'] = 'active';
		break;
		
	case 'termstolanguages':
		$title = 'Terms To Languages';
		$breadcrumb = array(
			'0' => array(
				'title' => 'Dashboard',
				'path' => 'dashboard.php'
			),
			'1' => array(
				'title' => 'Terms To Languages',
				'path' => $pagenav.'.php'
			)
		);
		$selection['languagetranslation'] = 'class="active"';
		$selectiongroup['languagetranslation'] = 'active';
		break;
		
	case 'blogposts':
		$title = isset($_REQUEST['mode']) ? ucfirst($_REQUEST['mode']).' Post' : 'Blog Posts';
		$breadcrumb = array(
			'0' => array(
				'title' => 'Dashboard',
				'path' => 'dashboard.php'
			),
			'1' => array(
				'title' => 'Blog Posts',
				'path' => $pagenav.'.php'
			)
		);
		if(isset($_REQUEST['mode'])){
			
			$breadcrumb[] = array(
				'title' => $title,
				'path' => '#'
			);
		}
		$selection['blogposts'] = 'class="active"';
		$selectiongroup['blogposts'] = 'active';
		break;
	
	case 'languages':
		$title = isset($_REQUEST['mode']) ? ucfirst($_REQUEST['mode']).' Language' : 'Languages';
		$breadcrumb = array(
			'0' => array(
				'title' => 'Dashboard',
				'path' => 'dashboard.php'
			),
			'1' => array(
				'title' => 'Languages',
				'path' => $pagenav.'.php'
			)
		);
		if(isset($_REQUEST['mode'])){
			
			$breadcrumb[] = array(
				'title' => $title,
				'path' => '#'
			);
		}
		$selection['languagetranslation'] = 'class="active"';
		$selectiongroup['languagetranslation'] = 'active';
		break;
		
	case 'feedbacks':
		$title = isset($_REQUEST['mode']) ? ucfirst($_REQUEST['mode']).' Language' : 'Feedbacks & Enquiries';
		$breadcrumb = array(
			'0' => array(
				'title' => 'Dashboard',
				'path' => 'dashboard.php'
			),
			'1' => array(
				'title' => 'Feedbacks & Enquiries',
				'path' => $pagenav.'.php'
			)
		);
		if(isset($_REQUEST['mode'])){
			
			$breadcrumb[] = array(
				'title' => $title,
				'path' => '#'
			);
		}
		$selection['feedbacks'] = 'class="active"';
		$selectiongroup['feedbacks'] = 'active';
		break;
		
}

if($_SESSION[base64_encode(PROJECT_NAME).'userid'] == ""){
	header('location:index.php');
	die();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?=$title?> | <?=PROJECT_NAME?> Admin</title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<!-- bootstrap 3.0.2 -->
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- font Awesome -->
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!-- Ionicons -->
<link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
<!-- Morris chart -->
<link href="css/morris/morris.css" rel="stylesheet" type="text/css" />
<!-- jvectormap -->
<link href="css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
<!-- Date Picker -->
<link href="css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
<!-- Daterange picker -->
<link href="css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<!-- bootstrap wysihtml5 - text editor -->
<link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
<!-- DATA TABLES -->
<link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<!-- Theme style -->
<link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

</head>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Choose Media</h4>
      </div>
      <div class="modal-body">
        <p>Choose from one of the images from the media library</p>
		
		<div class="timeline-body">
		
			<?php
			$getrows = "SELECT * FROM ".TABLE_PREFIX."media_library ORDER BY id DESC";								   
			$getrows = mysqli_query($con,$getrows) or die(mysqli_error());
			while($row = mysqli_fetch_array($getrows)){
				
				$imagePath = ADMIN_URL.'userfiles/'.stripslashes($row['image_path']);
				?>
				<img src="<?php echo($imagePath); ?>" alt="<?php echo(stripslashes($row['image_title'])); ?>" title="<?php echo(stripslashes($row['image_title'])); ?>" class="margin imageselect" data-mediaid="<?php echo($row['id']); ?>">
				<?php
			}
			?>
			
		</div>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<body class="skin-black">
<!-- header logo: style can be found in header.less -->
<header class="header"> <a href="<?=ADMIN_URL?>" class="logo">
  <!-- Add the class icon to your logo image or logo icon to add the margining -->
  <?=PROJECT_NAME?></a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
    <div class="navbar-right">
      <ul class="nav navbar-nav">
      
      	<li>
            <a href="<?=BASE_URL?>" target="_blank">Visit Front End</a>
        </li>
        
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="glyphicon glyphicon-user"></i> <span><?=$rowuserdet['name']?> <i class="caret"></i></span> </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header bg-light-blue"> <img src="img/avatar3.png" class="img-circle" alt="User Image" />
              <p> <?=$rowuserdet['name']?> </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left"> <a href="change_pass.php" class="btn btn-default btn-flat">Change Password</a> </div>
              <div class="pull-right"> <a href="logout.php" class="btn btn-default btn-flat">Sign out</a> </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>