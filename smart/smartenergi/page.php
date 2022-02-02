<?php include('header.php');
/*
array(
		"user"=>"B67193698","pass"=>"NTXYP",
	"firstSurname"=>"neha",
	 "yourReference"=>"pixlr",
	 "nationalID"=>"39999999A",
	  "productID"=>1,
	  "productBehaviour"=>0
	 );
$availableProducts=availableProducts();

print_r($availableProducts);die();*/
 ?>

<?php
if(empty($pageSlug) || empty($pageID)){
	
	header('location:'.BASE_URL.$defaultLangCode);
}

$sectionContent = getCMS($pageID,$langID,$con);

$sectionImage = !empty($sectionContent['image_path']) ? ADMIN_URL.'userfiles/'.$sectionContent['image_path'] : '';
$sectionTitle = stripslashes($sectionContent['page_title']);
$sectionDesc = stripslashes($sectionContent['page_desc']);

if($pageSlug == 'about-us'){
	
	include('aboutbanner.php');
}
else if($pageSlug == 'faq'){
	
	include('faqbanner.php');
}
else{
	
	include('generalbanner.php');
}
?>

<!-- One -->
<section id="main" class="wrapper">
	<div class="container cmscontents">
	
		<?php /* ?><header class="major">
			<h2><?=$sectionTitle?></h2>
		</header><?php */ ?>

		<?=$sectionDesc?>
		
	</div>
</section>

<?php include('footer.php'); ?>