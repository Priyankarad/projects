<?php require_once('header.php'); ?>

	<div class="mini_banners" style="background:url('<?php echo($allcontents[65]['sectionImage']); ?>')">
			<div class="Meet_minitx">
				<h1><?php echo($allcontents[65]['sectionTitle']); ?></h1>
				<?php echo($allcontents[65]['sectionDesc']); ?>
				<div class="open_btns">
					<a href="<?=BASE_URL.$getLang?>/invest"><?php echo($transArr['Open your account']); ?></a>
				</div>
			</div>
			<div class="shape_ag"></div>
	</div>
	
	<div class="how_it_work">
		<div class="container">
			<header class="major">
				<h2><?php echo($allcontents[56]['sectionTitle']); ?></h2>
				<p><?php echo($allcontents[56]['sectionDesc']); ?></p>
			</header>
			<div class="howitparent">
				<div class="row 150%">
					<div class="4u 12u$(medium)">
						<div class="howit_box">
							<div class="explore-icon explore_iconX">&nbsp;</div>
							<div class="circle_cntsX">
								<h4><?php echo($allcontents[57]['sectionTitle']); ?></h4>
								<p><?php echo($allcontents[57]['sectionDesc']); ?></p>
							</div>
						</div>
					</div>
					<div class="4u 12u$(medium)">
						<div class="howit_box">
							<div class="explore-icon invest_iconX">&nbsp;</div>
							<div class="circle_cntsX">
								<h4><?php echo($allcontents[58]['sectionTitle']); ?></h4>
								<p><?php echo($allcontents[58]['sectionDesc']); ?></p>
							</div>
						</div>
					</div>
					<div class="4u 12u$(medium)">
						<div class="howit_box">
							<div class="explore-icon earn_iconX">&nbsp;</div>
							<div class="circle_cntsX">
								<h4><?php echo($allcontents[59]['sectionTitle']); ?></h4>
								<p><?php echo($allcontents[59]['sectionDesc']); ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="proven_dshape"></div>
	</div>


	<div class="proven_d">
		<div class="container">
			<div class="row">
				<div class="6u 12u$(medium)">
					<div class="proven_leftX">
						<h1><?php echo($allcontents[60]['sectionTitle']); ?></h1>
						<p><?php echo($allcontents[60]['sectionDesc']); ?></p>
						<div class="open_btns">
							<a href="<?=BASE_URL.$getLang?>/invest"><?php echo($transArr['Register as an investor']); ?></a>
						</div>
					</div>
				</div>
				<div class="6u 12u$(medium)">
					<div class="graph_img">
						
					</div>
				</div>
			</div>
			<p class="small_textX"><?php echo($allcontents[61]['sectionDesc']); ?></p>
		</div>
	</div>


<div class="browse_loan">
	<div class="container">
		<header class="major">
			<h2><?php echo($allcontents[62]['sectionTitle']); ?><sup>+</sup></h2>
			<p><?php echo($allcontents[62]['sectionDesc']); ?></p>
		</header>
		<div class="slider_loan">
			<div id="slider3d">
				<ul class="slide-wrap" id="example">
					<?php
$sql = "select * from ".TABLE_PREFIX."backoffice_loan_applications as LA order by LA.id DESC limit 0,7";
$qry = mysqli_query($con,$sql) or die(mysqli_error());
$rows = mysqli_num_rows($qry);
if(count($rows)){
						$sl = 1;
						while($row = mysqli_fetch_assoc($qry)){
							//print_r($row);
?>
		<li class="pos<?=$sl?>">
			<div class="loan_bslider">
				<div class="img_sliderX" style="background:url('<?php echo($allcontents[66]['sectionImage']); ?>');">
					<div class="overlayG"></div>
				</div>
				<div class="div_ctop">
					<h2 class="rating_loan">AA</h2>
					<h4><?= $row['loan_amount'];?>&euro;</h4>
					<p>Yield: <?=$row['loan_apr']."%";?></p>
				</div>
				<div class="footer_loanX">
					<p><?php echo($allcontents[66]['sectionTitle']); ?>: 23.7%</p>
				</div>
			</div>
		</li>

<?php
		$sl++;					
						} }
?>	

			<!----		
					<li class="pos2">
						<div class="loan_bslider">
							<div class="img_sliderX" style="background:url('https://www.prosper.com/web-investor/assets/images/shared/web-investor/Large-purchases-7269a3aa8492101804d14828890f6439.jpg');">
								<div class="overlayG"></div>
							</div>
							<div class="div_ctop">
								<h2 class="rating_loan">A</h2>
								<h4>$34,901</h4>
								<p>Yield: 9.8%</p>
							</div>
							<div class="footer_loanX">
								<p>Funded: 26.4%</p>
							</div>
						</div>
					</li>
					<li class="pos3">
						<div class="loan_bslider">
							<div class="img_sliderX" style="background:url('https://www.prosper.com/web-investor/assets/images/shared/web-investor/Large-purchases-7269a3aa8492101804d14828890f6439.jpg');">
								<div class="overlayG"></div>
							</div>
							<div class="div_ctop">
								<h2 class="rating_loan">D</h2>
								<h4>$15,000</h4>
								<p>Yield: 24.44%</p>
							</div>
							<div class="footer_loanX">
								<p>Funded: 40.7%</p>
							</div>
						</div>
					</li>
					<li class="pos4">
						<div class="loan_bslider">
							<div class="img_sliderX" style="background:url('https://www.prosper.com/web-investor/assets/images/shared/web-investor/Large-purchases-7269a3aa8492101804d14828890f6439.jpg');">
								<div class="overlayG"></div>
							</div>
							<div class="div_ctop">
								<h2 class="rating_loan">AA</h2>
								<h4>$24,000</h4>
								<p>Yield: 7.44%</p>
							</div>
							<div class="footer_loanX">
								<p>Funded: 23.2%</p>
							</div>
						</div>
					</li>
					<li class="pos5">
						<div class="loan_bslider">
							<div class="img_sliderX" style="background:url('https://www.prosper.com/web-investor/assets/images/shared/web-investor/Large-purchases-7269a3aa8492101804d14828890f6439.jpg');">
								<div class="overlayG"></div>
							</div>
							<div class="div_ctop">
								<h2 class="rating_loan">AA</h2>
								<h4>$30,000</h4>
								<p>Yield: 4.31%</p>
							</div>
							<div class="footer_loanX">
								<p>Funded: 23.7%</p>
							</div>
						</div>
					</li>
					----->
				</ul>
				<i class="arrow prev" id="jprev">&lt;</i>
				<i class="arrow next" id="jnext">&gt;</i>
			</div>
		</div>
		
		<div class="bottomcnt3D">
		<div class="open_btns">
			<a href="<?=BASE_URL.$getLang?>/loanlistings"><?php echo($allcontents[63]['sectionTitle']); ?></a>
		</div>
		<p class="small_textX"><?php echo($allcontents[63]['sectionDesc']); ?></p>

	</div>
</div>
</div>


<div class="risk_rating2" id="returns">
	<div class="container">
		<header class="major">
			<h2><?php echo($allcontents[64]['sectionTitle']); ?></h2>
			<p><?php echo($allcontents[64]['sectionDesc']); ?></p>
		</header>
		<div class="risk_bx">
			<ul>
				<li>
					<div class="risk_reatX">Risk Rating</div>
					<span>Estimated Returns*</span>
				</li>
				<li>
					<div class="circle_abc">AA</div>
					<span>4.99%</span>
				</li>
				<li>
					<div class="circle_abc">A</div>
					<span>5.6%</span>
				</li>
				<li>
					<div class="circle_abc">B</div>
					<span>6.7%</span>
				</li>
				<li>
					<div class="circle_abc">C</div>
					<span>9.09%</span>
				</li>
				<li>
					<div class="circle_abc">D</div>
					<span>12.5%</span>
				</li>
				<li>
					<div class="circle_abc">E</div>
					<span>14.41%</span>
				</li>
				<li>
					<div class="circle_abc">HR</div>
					<span>11.75%</span>
				</li>
				<li>
					<div class="risk_reatX">Total Return</div>
					<span class="tot_rskb">7.92%</span>
				</li>
			</ul>
		</div>
		<p class="small_textX">*Estimated returns are calculated by (i) taking the weighted average borrower interest rate for all loans originated during the period, adding (ii) estimated collected late fees and post charge-off principal recovery for such loans, and subtracting (iii) the servicing fee, estimated uncollected interest on charge-offs and estimated principal loss on charge-offs from such loans. The actual return on any Note depends on the prepayment and delinquency pattern of the loan underlying each Note, which is highly uncertain. Individual results may vary and projections can change. Past performance is no guarantee of future results and the information presented is not intended to be investment advice or a guarantee about the performance of any Note. Based on data from June 1, 2018 - June 30, 2018.</p>
	</div>
</div>



<?php require_once('footer.php');



