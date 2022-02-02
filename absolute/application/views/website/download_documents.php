<!--========header=============-->
<section class="banner-top" style="background-image: url('<?php echo BASEURL; ?>assets/web/images/banner.png')">

    <div class="link_section">
        <h1>Documents</h1>
    </div>
</section>
<!--=============== Contact Section Start============ -->
<section class="partmer_section pd_all pdbtm60px">
	<div class="container contain_new">
		<div class="partners">
			<div class="row">
				<table border="1" width="100%">
					<tr>
					<th>S.No.</th>
					<th>Name</th>
					<th>Document</th>
				</tr>
				<?php 
				$count = 0;
				if(!empty($documents['result'])){
					foreach($documents['result'] as $doc){
						$count++; ?>
						<tr>
							<td><?php echo $count;?></td>
							<td><?php echo ucwords($doc->doc_name);?></td>
							<td><a target="_blank" href="<?php echo BASEURL.$doc->image; ?>"><img height="50" width="50" src="<?php echo BASEURL.'uploads/download.png';  ?>" class="img-responsive img-circle"></a></td>
						</tr>
					<?php }
				}else{ ?>
					<tr>
						<td colspan="3">No Data Available</td>
					</tr>
				<?php }
				?>
				</table>
			</div>
		</div>
	</div>
</section>

<!--=============== Contact Section Start============ -->
