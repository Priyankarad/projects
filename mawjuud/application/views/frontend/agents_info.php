
<div class="agentdivp">
	
	<div class="agent-imgs">
		<a href="<?php echo base_url().'agent_info?id='.encoding($agent->id);?>">
			<?php
			$img = base_url().DEFAULT_IMAGE;
			if(checkRemoteFile($agent->profile_thumbnail)){
				$img = $agent->profile_thumbnail; 
			}
			?>
			<img src="<?php echo $img;?>" alt=""/> 
	    </a>
	</div>
	<div class="agentsItemName">
		<a href=""><?php echo ucwords($agent->firstname." ".$agent->lastname);?></a>
	</div>
	<ul>
		<li><span class="ti-home"></span> <?php echo isset($agent->agency_name)?$agent->agency_name:'-';?></li>
		<li><span class="ti-mobile"></span> <?php echo isset($agent->agency_cell)?$agent->agency_cell:'-';?></li>
		<li><span class="ti-email"></span> <?php echo isset($agent->email)?$agent->email:'-';?></li>
	</ul>
</div>
