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
		   
		   <li class="<?=$selectiongroup['dropdownvalues']?>"> <a href="dropdownvalues.php"> <i class="glyphicon glyphicon-font"></i> <span>Dropdown Values</span></a></li>
		   
		   <li class="<?=$selectiongroup['dropdowntolanguages']?>"> <a href="dropdowntolanguages.php"> <i class="glyphicon glyphicon-bullhorn"></i> <span>Dropdown to Languages</span></a></li>
		   
		</ul>
		
	</li>
	
	<li class="<?=$selectiongroup['feedbacks']?>"> <a href="feedbacks.php"> <i class="glyphicon glyphicon-user"></i> <span>Feedbacks & Enquiries</span></a></li>

	<li class="<?=$selectiongroup['clientlogo']?>"><a href="clientlogo.php"><i class="fa fa-gear"></i> Client Logo</a></li>

	<li class="<?=$selectiongroup['change_pass']?>"> <a href="change_pass.php"> <i class="fa fa-key"></i> <span>Change Password</span></a></li>
    
    <li class="<?=$selectiongroup['settings']?>"><a href="settings.php"><i class="fa fa-gear"></i> Settings</a></li>

    <li class="treeview <?=$selectiongroup['emailtemplates']?>">
		
		<a href="#"><i class="fa fa-envelope"></i> <span>Email Template Management</span></a>
		
		<ul class="treeview-menu">
           
		   <li class="<?=$selectiongroup['loan_approve_email']?>"> <a href="loan_approve_email.php"> <i class="glyphicon glyphicon-flag"></i> Loan approve template <span></span></a></li>
		   <li class="<?=$selectiongroup['merchant_forgotpassword_email']?>"> <a href="merchant_forgotpassword_email.php"> <i class="glyphicon glyphicon-flag"></i> Merchant forgotpassword email <span></span></a></li>
		   <li class="<?=$selectiongroup['borrower_forgotpassword_email']?>"> <a href="borrower_forgotpassword_email.php"> <i class="glyphicon glyphicon-flag"></i> Borrower forgotpassword email <span></span></a></li>
		   <li class="<?=$selectiongroup['investor_forgotpassword_email']?>"> <a href="investor_forgotpassword_email.php"> <i class="glyphicon glyphicon-flag"></i> Investor forgotpassword email <span></span></a></li>
		   <li class="<?=$selectiongroup['lender_email_verification']?>"> <a href="lender_email_verification.php"> <i class="glyphicon glyphicon-flag"></i> Investor email verification <span></span></a></li>
		   <li class="<?=$selectiongroup['merchant_email_verification']?>"> <a href="merchant_email_verification.php"> <i class="glyphicon glyphicon-flag"></i> Merchant email verification <span></span></a></li>
		   <li class="<?=$selectiongroup['breach_of_contract']?>"> <a href="breach_of_contract.php"> <i class="glyphicon glyphicon-flag"></i>Breach of contract <span></span></a></li>
		   <li class="<?=$selectiongroup['default_communication']?>"> <a href="default_communication.php"> <i class="glyphicon glyphicon-flag"></i>Default communication <span></span></a></li>
		   <li class="<?=$selectiongroup['previous_day_installment']?>"> <a href="previous_day_installment.php"> <i class="glyphicon glyphicon-flag"></i>Previousday installment<span></span></a></li>
		   <li class="<?=$selectiongroup['loan_application_notify']?>"> <a href="loan_application_notify.php"> <i class="glyphicon glyphicon-flag"></i>Admin loan application notify<span></span></a></li>
		   <li class="<?=$selectiongroup['merchant_approval']?>"> <a href="merchant_approval.php"> <i class="glyphicon glyphicon-flag"></i>Merchant approval<span></span></a></li>
		   <li class="<?=$selectiongroup['loan_reject']?>"> <a href="loan_reject.php"> <i class="glyphicon glyphicon-flag"></i>Loan reject<span></span></a></li>
		   <li class="<?=$selectiongroup['loan_close']?>"> <a href="loan_close.php"> <i class="glyphicon glyphicon-flag"></i>Loan close<span></span></a></li>
		   <li class="<?=$selectiongroup['merchant_fund_email_notify']?>"> <a href="merchant_fund_email_notify.php"> <i class="glyphicon glyphicon-flag"></i>Merchant fund email notify<span></span></a></li>
		   <li class="<?=$selectiongroup['merchant_registration']?>"> <a href="merchant_registration.php"> <i class="glyphicon glyphicon-flag"></i>Merchant Registration<span></span></a></li>
		</ul>
		
	</li>
    
    <li><a href="logout.php"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
    
  </ul>
</section>
<!-- /.sidebar -->
</aside>