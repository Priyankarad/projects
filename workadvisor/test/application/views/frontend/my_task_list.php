<?php 
if(!empty($taskList['result'])){
	foreach($taskList['result'] as $task){
	?>
	<li class="myTaskList" data-notification="1" data-toggle="modal" data-target="#addtasksfill" data-mytask_id="<?php echo $task->id;?>" data-assigned_to="0"> <?php echo ucfirst($task->title);?> </li>
<?php }
}else{
	echo '<li>No task found</li>';
} ?>
