<aside class="left-side sidebar-offcanvas">
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
  <!-- Sidebar user panel -->
  <div class="user-panel">
	<div class="pull-left image"> <img src="img/avatar3.png" class="img-circle" alt="User Image" /> </div>
	<div class="pull-left info">
	  <p>Hello, <?=$rowuserdet['name']?></p>
	</div>
  </div>
  <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu">
	<li class="<?=$selectiongroup['dashboard']?>"> <a href="<?=ADMIN_URL?>"> <i class="fa fa-home"></i> <span>Dashboard</span> </a> </li>
	
	<li class="<?=$selectiongroup['pages']?>"> <a href="pages.php"> <i class="glyphicon glyphicon-list-alt"></i> <span>Contents</span></a></li>
	
	<li class="<?=$selectiongroup['medialibrary']?>"> <a href="medialibrary.php"> <i class="glyphicon glyphicon-picture"></i> <span>Media Library</span></a></li>
	
	<li class="treeview <?=$selectiongroup['languagetranslation']?>">
		
		<a href="#"><i class="glyphicon glyphicon-comment"></i> <span>Languages Translation</span></a>
		
		<ul class="treeview-menu">
           
		   <li class="<?=$selectiongroup['languages']?>"> <a href="languages.php"> <i class="glyphicon glyphicon-flag"></i> <span>Languages</span></a></li>
		   
		   <li class="<?=$selectiongroup['terms']?>"> <a href="terms.php"> <i class="glyphicon glyphicon-font"></i> <span>Terms</span></a></li>
	
		   <li class="<?=$selectiongroup['termstolanguages']?>"> <a href="termstolanguages.php"> <i class="glyphicon glyphicon-bullhorn"></i> <span>Terms To Languages</span></a></li>
		</ul>
		
	</li>
	
	<li class="<?=$selectiongroup['blogposts']?>"> <a href="blogposts.php"> <i class="glyphicon glyphicon-pencil"></i> <span>News</span></a></li>
	
	<li class="<?=$selectiongroup['feedbacks']?>"> <a href="feedbacks.php"> <i class="glyphicon glyphicon-user"></i> <span>Feedbacks & Enquiries</span></a></li>
	
	<li class="<?=$selectiongroup['change_pass']?>"> <a href="change_pass.php"> <i class="fa fa-key"></i> <span>Change Password</span></a></li>
    
    <li class="<?=$selectiongroup['settings']?>"><a href="settings.php"><i class="fa fa-gear"></i> Settings</a></li>
    
    <li><a href="logout.php"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
    
  </ul>
</section>
<!-- /.sidebar -->
</aside>