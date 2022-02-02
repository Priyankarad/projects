<?php

/*

Template name:search-listing

*/


session_start();
$currency = 'USD';
require_once( get_parent_theme_file_path( 'countrylist1.php' ) );
$villasData = array();
$locations = array();

if(empty($_SESSION['city'])){
	$_SESSION['city'] = 'All';
}
if(empty($_GET['city'])){
	$_SESSION['city'] = 'All';
}else{
	$_SESSION['city'] = $_GET['city'];
}


if(!empty($_POST)){
	$_SESSION['start_date'] = $_POST['start_date'];
	$_SESSION['end_date'] = $_POST['end_date'];
	$_SESSION['room'] = $_POST['room'];
	$_SESSION['city'] = ucwords($_POST['city']);
	$_SESSION['to_currency'] = $_POST['currency'];
}
if(!empty($_SESSION['to_currency'])){
	$currency = $_SESSION['to_currency'];
}
$rates = $_SESSION['exchangeRates']->$currency;
$symbol = $_SESSION['symbols'][$currency];

if($symbol == ''){
	$symbol = 'USD $';
}
$villaIDsArray = array();
$cityArray = array();
$city = 'All';
if(!empty($_SESSION['city'])){
	$city = ucwords($_SESSION['city']);
}

if($city == 'All'){
	$cityArray = array('Seminyak','Kerobokan');
}else{
	$cityArray[] = $city;
}

/*temp code start*/
$latitudesK = array('-8.679427','-8.670241','-8.670244','-8.670250','-8.670248','-8.670250','-8.670249');
$longitudesK = array('115.166603','115.166523','115.166456','115.166365','115.166264','115.166140','115.166051');
// $namesK = array('2 Bedroom – Villa Mi Amor','2 Bedroom – Villa Michelle','8 Bedroom - Villa Mason','5 Bedroom – Villa Pola','3 Bedroom – Villa Erja','6 Bedroom –  Villa Bella','3 Bedroom – Villa Olli');
$namesK = array('2 Bedroom – VILLA MI AMOR','2 Bedroom – VILLA MICHELLE','8 Bedroom - VILLA MASON','5 Bedroom – VILLA POLA','3 Bedroom – VILLA ERJA','6 Bedroom –  VILLA BELLA','3 Bedroom – VILLA OLLI');
/*temp code end*/

foreach($cityArray as $city){
	/*temp code start*/
	if($city == 'Kerobokan'){
		for($i=0;$i<=6;$i++){
			$locations[]=array('name'=>$namesK[$i], 'lat'=>$latitudesK[$i], 'lng'=>$longitudesK[$i], 'city'=>'Kerobokan', 'villa_id'=>'', 'image'=>'https://www.mingguvillas.com/new/wp-content/uploads/2019/05/banner3-1.jpg', 'price'=>'-');
		}
	}
	else{
		$args = array(
			'post_type' => 'page',
			'post_status'  => 'publish',
			'meta_query'             => array(
				array(
					'key'       => 'villacity',
					'value'     => $city,
				),
			),
		);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$villaID = get_the_id();
				$villaData = get_post_meta(get_the_id());
				$propertyID = isset($villaData['villa_id'][0])?$villaData['villa_id'][0]:'';
				$currenDate = date('Y-m-d');
				$oneYearDate = date('Y-m-d',strtotime('+3 months'));
				$result =  getAvailability($propertyID,$currenDate,$oneYearDate); 
				$rooms = $result['RoomsAvailability']['RoomAvailability']['DayAvailability'];
				$roomPrice = array();
				$alottedRooms = array();
				if(!empty($rooms)){
					foreach($rooms as $room){
						if($room['Alot'] == 1){
							$roomPrice[] = number_format($room['Price']);
						}
						if($room['Alot'] == 0){
							$alottedRooms[] = date('d-m-Y',strtotime($room['@attributes']['day']));
						}
					}
				}

				$status = 0;
				if(!empty($_SESSION['start_date']) && !empty($_SESSION['end_date'])){
					$startDate = date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['start_date'])));
					$startDate = strtotime($startDate);
					$endDate = date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['end_date'])));
					$endDate = strtotime($endDate);
					if($startDate == $endDate){
						$status = 3;
					}else{
						for ($i=$startDate; $i<$endDate; $i+=86400) {  
							$dateCheckAlotted =  date("d-m-Y", $i);
							if(in_array($dateCheckAlotted,$alottedRooms)){
								$status = 1;
							}
						}
					}
				}else{
					$status = 2;//if start and end date not set
				}

				if(($status == 0) || ($status == 2)){
					$minRoomPrice = min($roomPrice);
					$minRoomPrice = $rates*$minRoomPrice;
					$villaName = isset($villaData['my_villa_first_section_title_one'][0])?$villaData['my_villa_first_section_title_one'][0]:'';
					$rooms = preg_replace('/[^0-9]/', '', $villaName);
					if($rooms>=$_SESSION['room']){
						$villasData[$villaID]['min_price'] = $symbol.number_format($minRoomPrice,1);
						$villasData[$villaID]['name'] = $villaName;
						$villasData[$villaID]['city'] = $city;
						$villasData[$villaID]['address'] = isset($villaData['my_villa_first_section_title_two'][0])?$villaData['my_villa_first_section_title_two'][0]:'';
						$villasData[$villaID]['page_name'] = isset($villaData['page_name'][0])?$villaData['page_name'][0]:'';
						/*Code for image*/
						$imageID = $villaData['main_image'][0];
						$imageData = get_post($imageID);
						if(!empty($imageData)){
							$villasData[$villaID]['image'] = $imageData->guid;
						}else{
							$villasData[$villaID]['image'] = '';
						}

						$latitude = isset($villaData['latitude'][0])?$villaData['latitude'][0]:'';
						$longitude = isset($villaData['longitude'][0])?$villaData['longitude'][0]:'';
						$villaName = explode('-',$villaName);
						$villaNameCapital = strtoupper($villaName[1]);

						$locations[]=array('name'=>$villaName[0].' - '.$villaNameCapital, 'lat'=>$latitude, 'lng'=>$longitude, 'city'=>$city, 'villa_id'=>$villaID,'image'=>$villasData[$villaID]['image'],'price'=>$villasData[$villaID]['min_price']);
						$amenities = '';
						if( have_rows('overview_keyfacts_repeater',$villaID) ):
							while ( have_rows('overview_keyfacts_repeater',$villaID) ) : the_row();

								$amenities.='<li class="room-details-features__list-item">
								<img src="'.get_sub_field('overview_keyfacts_new_icon',$villaID).'">'.get_sub_field('overview_keyfacts_new_title',$villaID).'</li>';

							endwhile;
						else :
						endif;
						$villasData[$villaID]['amenities'] = $amenities;
					}
				}
			}
		}
	}
}
$markers = json_encode($locations);
get_header('one');
?>
<input type="hidden" name="markers" id="markers" value='<?php echo $markers;?>'>
<input type="hidden" name="zoom" id="zoom" value='5'>
<div class="pi-listingsearch PiRemoMr">



	<div class="pi-topsearch NewPiTop ForCalNewpi">

		<div class="container-fluid">



			<form method="post" action="#" id="villaForm"> 

				<div class="row">

					<div class="col-md-12">

						<div class="row pdmain0">
							<div class="col-md-1 col-sm-1 col-12">
								<span class="check_available1">Check Availability</span>
							</div>
							<div class="col-md-2 col-sm-2 col-6 two-col">
								<div class="form-group BannrGrup">
									<select name="city" class="form-control" id="city">
										<option selected="selected" value="all" <?php echo ($_SESSION['city'] == 'All')?'selected':''; ?> >All Destinations</option>
										<option value="seminyak" <?php echo ($_SESSION['city'] == 'Seminyak')?'selected':''; ?>>Seminyak</option>
										<option value="kerobokan" <?php echo ($_SESSION['city'] == 'Kerobokan')?'selected':''; ?>>Kerobokan</option>
									</select>
								</div>
							</div>


							<!-- onlty-for-mobile-view -->
							<div class="col-md-1 col-sm-1 col-6 two-col disply-show" style="display: none;">

								<div class="form-group BannrGrup VilaSrchbnr">

									<button type="submit" class="btn SubBtn VilaSrchSubBtn" name="search" value="submit">

										<span class="lnr lnr-magnifier"></span>

									</button>

								</div>
							</div>

							<div class="col-md-2 col-sm-2 col-6 two-col">

								<div class="form-group BannrGrup">

									<!--  <label>Selecte Date:</label> -->

									<input type="text" placeholder="Check-IN" class="form-control BannerInput searchdate" name="start_date" id="start_date" autocomplete="off" readonly value="<?php echo isset($_SESSION['start_date'])?$_SESSION['start_date']:'';?>">

									<span class="lnr lnr-calendar-full"></span>

								</div>

							</div>

							<div class="col-md-2 col-sm-2 col-6 two-col">

								<div class="form-group BannrGrup">

									<!--  <label>Selecte Date:</label> -->

									<input type="text" placeholder="Check-OUT" class="form-control BannerInput searchdate" id="end_date" name="end_date" autocomplete="off" readonly value="<?php echo isset($_SESSION['end_date'])?$_SESSION['end_date']:'';?>">

									<span class="lnr lnr-calendar-full"></span>

								</div>

							</div>

							<div class="col-md-2 col-sm-2 col-6 two-col">

								<div class="form-group BannrGrup">
									<select name="room" id="room" class="form-control">
										<option selected="selected" value="0">All Rooms</option>
										<?php 
										$bedroom = ' bedrooms';
										for($i=2;$i<=8;$i++){ ?>
											<option value="<?php echo $i;?>" <?php echo (isset($_SESSION[
												'room']) && $_SESSION[
													'room'] == $i)?'selected':'';?> ><?php echo $i.$bedroom;?></option>
										<?php }
										?>
									</select>

									<span><img src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/images/Bed_1.png" class="img-fluid bediconImg" alt="Icon"></span>

								</div>

							</div>

							<div class="col-md-2 col-sm-2 col-6 two-col">
								<div class="form-group BannrGrup vilaSrchSeclBk">
									<select class="selector ftNselct currency_select11" id="currency" name="currency">
										<option value="dummy" <?php echo ($currency == 'dummy')?'selected':'';?>>Currency </option>
										<?php 
										foreach( $age as $x => $x_value ) { ?>
											<option value="<?php echo $x; ?>" <?php echo ($currency == $x)?'selected':'';?>><?php echo $x." ".$x_value;?></option> 
										<?php } ?>
									</select>
								</div>
							</div>

							<div class="col-md-1 col-sm-1 col-6 two-col disply-off">

								<div class="form-group BannrGrup VilaSrchbnr">

									<button type="submit" class="btn SubBtn VilaSrchSubBtn" name="search" value="submit">

										<span class="lnr lnr-magnifier"></span>

									</button>

								</div>

							</div>

						</div> 

					</div>

<!-- <div class="col-md-6">

<p class="text-right pi-mappin"><span class="lnr lnr-map-marker"></span></p>

</div> -->

</div>

</form>

</div>

</div>



<div class="pi-mainmaplist">

	<div class="container-fluid">

		<div class="row">

			<div class="col-md-7">

				<div class="pi-left-listing">

					<div class="pi-morefilter">


					</div>



					<div class="pi-mainlist">

						

							<?php 
							if(!empty($villasData)){
								$count = 0;
								$villaIndex = 0;
								$villaCount = count($villasData);
								foreach($villasData as $key=>$villa){
									$count++;
									$villaIndex++;
									if($count == 1){
										echo '<div class="row">';
									}
									?>
									<div class="col-md-4 hoverVilla" data-villa_id1="<?php echo $key;?>">

										<div class="pi-mainlisttop">

											<div class="pi-mainlistimgs">


												<img src="<?php echo $villa['image'];?>" alt="" class="w-100" data-villa_id="<?php echo $key;?>"/>

											</div>

											<div class="pi-mainlistbtms">
												<p><?php echo $villa['city'];?></p>
												<h5 class="" style=""><a href="<?php echo home_url($villa['page_name']);?>" target="_blank"><?php
												$villaName = explode('-',$villa['name']);
												//$villaNameCapital = strtoupper($villaName[1]);
												$villaNameCapital = $villaName[1];
												echo $villaName[0].' <span class="villasnames"> '.$villaNameCapital.'</span>';
												;?></a></h5>

												<p class="texxts">

													<a href="<?php echo home_url($villa['page_name']);?>" target="_blank"><span><?php echo $villa['address'];?></span></a>

												</p>

												<ul>
													<?php echo $villa['amenities'];?>
												</ul>

												<div class="NewVilaBedBtnBox">
													<div class="row">
														<div class="col-md-6 col-sm-12 col-12 SrcRPadR">

															<button class=" room_btn vilRmbtnrad">
																<span>Start From</span> 
																<span><?php echo $villa['min_price'];?> </span>
																<a href="<?php echo home_url($villa['page_name']);?>?villa=1" class="btn btn-cta room_anchor VilaAnchoreVt rombrrad2a">Book Now</a>

															</button>
														</div>

														<div class="col-md-6 col-sm-12 col-12 SrcRPadL">
															<div class="SrchvilaPrice scrchRad">
																<a href="<?php echo home_url($villa['page_name']);?>?villa=1">Book Now</a>
															</div>
														</div>
													</div>
												</div>

												<h5 class="disply-show" style="display: none;"><a href="<?php echo home_url($villa['page_name']);?>" target="_blank"><?php
												$villaName = explode('-',$villa['name']);
												$villaNameCapital = strtoupper($villaName[1]);
												echo $villaName[0].' - '.$villaNameCapital;
												;?></a></h5>
											</div>

										</div>

									</div>
								<?php
										if($count == 3){
											echo '</div><hr>'; 
											$count = 0;
										}
										if($villaIndex == $villaCount){
											echo '</div>';
										}
								}
							}else{ ?>
								<span style="color:red;margin: 0 auto;text-align: center; width: 100%;display: inline-block;">No results found</span>
							<?php } ?>

						<!-- </div> -->

					</div>

				</div>

			</div>

			<div class="col-md-5">

				<div class="pi-mapfix">
					<div id="map"></div>
				</div>

			</div>

		</div>  

	</div>

</div>



</div>

<script src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/jquery-3.2.1.slim.min.js"></script>
<script type='text/javascript' src='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/jquery-ui.js'></script>
<script type="text/javascript">
	$(document).on('click','.deleteDates',function(){
		$('#start_date').val('');
		$('#end_date').val('');
		$("#start_date").datepicker("hide");
		$("#end_date").datepicker("hide");
	});
	$(function () {
		$("#start_date").datepicker({
			minDate: 0,
			dateFormat:'dd/mm/yy',
			onSelect: function(selected) {
				$("#end_date").datepicker("option","minDate", selected)
			}
		});
		$("#end_date").datepicker({
			minDate: 0,
			dateFormat:'dd/mm/yy', 
			onSelect: function (selected) {
				$("#start_date").datepicker("option","maxDate", selected)
			}
		});

		$(document).on('change','.currency_select11',function(){
			$('#villaForm').submit();
		});
	});
</script>
<style type="text/css">
	.pi-mainmaplist .row .col-md-5 {
		padding-right: 0px;
		padding-left: 0;
		width: 100%;
		overflow: hidden;
	}
	.pi-mapfix{
		width: 100%;
	}
	div#map {
		position: unset !important;
		overflow: unset  !important; 
		top: 302px;
	}
</style>
<?php get_footer();?>