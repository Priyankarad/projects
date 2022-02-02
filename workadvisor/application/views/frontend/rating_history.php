<div class="row">
<div class="col-md-8">
<h3>Rating History &nbsp;<span class="history_"><i class="fa fa-question-circle" aria-hidden="true"></i></span></h3>
<div class="main_with coutm-wit">
<ul>
<?php 

if(!empty($MyhistoryRating)){ foreach($MyhistoryRating as $key=>$historyratings){
$upid=encoding($user_data->id);
$compid=encoding($MyhistoryRating[$key][0]['company_id']);
?>        
<li class="ful_cntant min-pdn">
<div class="lin-higthdiv">
<a href="<?php echo site_url('user/indivisualhistory/'.$upid.'/'.$compid) ?>">  <?php //echo ($key!="" && isset($category_questions->name)) ? $key : $category_questions->name ;
if($key!=''){
echo $key;
}else if(isset($category_questions->name)){
echo $category_questions->name ;
}else{
echo 'Unknown';
}
?> (<?php echo count($historyratings); 
?> Ratings) 
</a>
</div>
</li>
<?php } } ?>
</ul>
</div>
</div>
<!-- <div class="col-md-4">

<ins class="adsbygoogle"
style="display:block"
data-ad-client="ca-pub-3979824042791728"
data-ad-slot="5769690836"
data-ad-format="auto"
data-full-width-responsive="true"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>  
</div>     -->     
</div>