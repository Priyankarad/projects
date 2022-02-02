<?php

/*

Template name:search-listing

*/


session_start();
$currency = 'USD';
require_once( get_parent_theme_file_path( 'countrylist1.php' ) );
$villasData = array();
$locations = array();
if(!empty($_POST)){
	$_SESSION['start_date'] = $_POST['start_date'];
	$_SESSION['end_date'] = $_POST['end_date'];
	$_SESSION['room'] = $_POST['room'];
	$_SESSION['citys'] = $_POST['city'];
	$_SESSION['to_currency'] = $_POST['currency'];
}
if(!empty($_SESSION['to_currency'])){
	$currency = $_SESSION['to_currency'];
}
$rates = $_SESSION['exchangeRates']->$currency;
$symbol = $_SESSION['symbols'][$currency];

$villaIDsArray = array();
$cityArray = array();
$city = 'All';
if(!empty($_SESSION['citys'])){
	$city = ucwords($_SESSION['citys']);
}

if($city == 'All'){
	$cityArray = array('Seminyak','Kerobokan');
}else{
	$cityArray[] = $city;
}

/*temp code start*/
$latitudesK = array('-8.679427','-8.670241','-8.670244','-8.670260','-8.670244','-8.670260','-8.670249');
$longitudesK = array('115.166603','115.166523','115.166456','115.166375','115.166260','115.166150','115.166051');
$namesK = array('2 Bedroom – Villa Mi Amor','2 Bedroom – Villa Michelle','8 Bedroom - Villa Mason','5 Bedroom – Villa Pola','3 Bedroom – Villa Erja','6 Bedroom –  Villa Bella','3 Bedroom – Villa Olli');
/*temp code end*/

foreach($cityArray as $city){
	/*temp code start*/
	if($city == 'Kerobokan'){
		for($i=0;$i<=6;$i++){
			$locations[]=array('name'=>$namesK[$i], 'lat'=>$latitudesK[$i], 'lng'=>$longitudesK[$i], 'city'=>'Kerobokan');
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
				if(!empty($rooms)){
					foreach($rooms as $room){
						if($room['Alot'] == 1){
							$roomPrice[] = number_format($room['Price']);
						}
					}
				}
				$minRoomPrice = min($roomPrice);
				$minRoomPrice = $rates*$minRoomPrice;
				$villasData[$villaID]['min_price'] = $symbol.number_format($minRoomPrice,1);
				$villasData[$villaID]['name'] = isset($villaData['my_villa_first_section_title_one'][0])?$villaData['my_villa_first_section_title_one'][0]:'';
				$villasData[$villaID]['address'] = isset($villaData['my_villa_first_section_title_two'][0])?$villaData['my_villa_first_section_title_two'][0]:'';
				$villasData[$villaID]['page_name'] = isset($villaData['page_name'][0])?$villaData['page_name'][0]:'';
				if( have_rows('my_villa_overview_section_one',$villaID) ):
					while ( have_rows('my_villa_overview_section_one',$villaID) ) : the_row();
						$villasData[$villaID]['image'] = get_sub_field('my_villa_overview_section_one_image',$villaID);
						break;
					endwhile;
				else :
				endif;
				$latitude = isset($villaData['latitude'][0])?$villaData['latitude'][0]:'';
				$longitude = isset($villaData['longitude'][0])?$villaData['longitude'][0]:'';

				$locations[]=array('name'=>$villasData[$villaID]['name'], 'lat'=>$latitude, 'lng'=>$longitude, 'city'=>$city);
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
$markers = json_encode($locations);
get_header('one');
?>
<input type="hidden" name="markers" id="markers" value='<?php echo $markers;?>'>
<input type="hidden" name="zoom" id="zoom" value='12'>
<div class="pi-listingsearch">



	<div class="pi-topsearch NewPiTop">

		<div class="container-fluid">

			<form method="post" action="#"> 

				<div class="row">

					<div class="col-md-12">

						<div class="row pdmain0">
							<div class="col-md-2 col-sm-2 col-12">
								<div class="form-group BannrGrup">
									<select name="city" class="form-control" id="city">
										<option selected="selected" value="all" <?php echo ($_SESSION['citys'] == 'all')?'selected':''; ?> >All Destinations</option>
										<option value="kerobokan" <?php echo ($_SESSION['citys'] == 'kerobokan')?'selected':''; ?>>Kerobokan</option>
										<option value="seminyak" <?php echo ($_SESSION['citys'] == 'seminyak')?'selected':''; ?>>Seminyak</option>
									</select>
								</div>
							</div>

							<div class="col-md-2 col-sm-2 col-12">

								<div class="form-group BannrGrup">

									<!--  <label>Selecte Date:</label> -->

									<input type="text" placeholder="Check-IN" class="form-control BannerInput searchdate" name="start_date" id="start_date1" autocomplete="off" readonly="" value="<?php echo isset($_SESSION['start_date'])?$_SESSION['start_date']:'';?>">

									<span class="lnr lnr-calendar-full"></span>

								</div>

							</div>

							<div class="col-md-2 col-sm-2 col-12">

								<div class="form-group BannrGrup">

									<!--  <label>Selecte Date:</label> -->

									<input type="text" placeholder="Check-OUT" class="form-control BannerInput searchdate" id="end_date1" name="end_date" autocomplete="off" readonly value="<?php echo isset($_SESSION['end_date'])?$_SESSION['end_date']:'';?>">

									<span class="lnr lnr-calendar-full"></span>

								</div>

							</div>

							<div class="col-md-2 col-sm-2 col-12">

								<div class="form-group BannrGrup">
									<select name="room" id="room" class="form-control">
										<option selected="selected">All Rooms</option>
										<?php 
										for($i=1;$i<=8;$i++){ ?>
											<option value="<?php echo $i;?>" <?php echo (isset($_SESSION[
												'room']) && $_SESSION[
													'room'] == $i)?'selected':'';?> ><?php echo $i;?></option>
										<?php }
										?>
									</select>

									<span><img src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/images/Bed_1.png" class="img-fluid bediconImg" alt="Icon"></span>

								</div>

							</div>

							<div class="col-md-2 col-sm-2 col-12">
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

							<div class="col-md-2 col-sm-2 col-12">

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

						<div class="row">

							<?php 
							if(!empty($villasData)){
								foreach($villasData as $villa){
									?>
									<div class="col-md-4">

										<div class="pi-mainlisttop">

											<div class="pi-mainlistimgs">

												<a href="<?php echo home_url($villa['page_name']);?>" target="_blank">

													<!-- <div class="show-on-map"><span class="lnr lnr-map-marker"></span> show on map</div> -->

													<img src="<?php echo $villa['image'];?>" alt="" class="w-100"/>

													<div class="price" ><small class="price__from"><span class="">from</span></small> <span class="price__min-price"><?php echo $villa['min_price'];?></span> <small class="period"><span class="">per night</span></small></div>

												</a>

<!-- <div class="BtnImgB">

<a href="<?php echo home_url($villa['page_name']);?>" target="_blank" class="btn btn-cta srchsubBtn">Book Now</a>

</div> -->

</div>

<div class="pi-mainlistbtms">

	<h5><a href="<?php echo home_url($villa['page_name']);?>" target="_blank"><?php
	$villaName = explode('-',$villa['name']);
	$villaNameCapital = strtoupper($villaName[1]);
	echo $villaName[0].' - '.$villaNameCapital;
	;?></a></h5>

	<p>

		<a href="<?php echo home_url($villa['page_name']);?>" target="_blank"><span><?php echo $villa['address'];?></span></a>

	</p>

	<ul>
		<?php echo $villa['amenities'];?>
	</ul>

</div>

</div>

</div>
<?php }
}else{ ?>
	<span style="color:red;margin-left:280px;">No results found</span>
<?php } ?>

</div>

</div>

</div>

</div>

<div class="col-md-5">

	<div class="pi-mapfix">

		<!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d117763.5515414666!2d75.79380938754157!3d22.724115838761882!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3962fcad1b410ddb%3A0x96ec4da356240f4!2sIndore%2C+Madhya+Pradesh!5e0!3m2!1sen!2sin!4v1556285327795!5m2!1sen!2sin" style="border:0" allowfullscreen></iframe> -->
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
	$(function () {
		$("#start_date1").datepicker({
			minDate: 0,
			dateFormat:'dd/mm/yy',
			onSelect: function(selected) {
				$("#end_date1").datepicker("option","minDate", selected)
			}
		});
		$("#end_date1").datepicker({
			minDate: 0,
			dateFormat:'dd/mm/yy', 
			onSelect: function (selected) {
				$("#start_date1").datepicker("option","maxDate", selected)
			}
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