<ol class="breadcrumb">

<?php
$sl = 1;
foreach($breadcrumb as $val)
{
	
	?>
	<li <?=$sl < count($breadcrumb) ? 'class="active"' : ''?>><a href="<?=$val['path']?>" title=""><?=($sl==1 ? '<i class="fa fa-home"></i>' : '').'&nbsp;'.$val['title']?></a></li>
	<?php
	$sl++;
}
?>

</ol>