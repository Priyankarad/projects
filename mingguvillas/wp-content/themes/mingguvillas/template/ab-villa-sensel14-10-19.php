<?php
/*
Template name:ab-villa-senser
*/



session_start();
$currency = 'USD';
if(!empty($_SESSION['to_currency'])){
	$currency = $_SESSION['to_currency'];
}
require_once( get_parent_theme_file_path( 'countrylist1.php' ) );
$propertyID = '298710';
$currenDate = date('Y-m-d');
$oneYearDate = date('Y-m-d',strtotime('+1 years'));
$result =  getAvailability($propertyID,$currenDate,$oneYearDate);
$rooms = $result['RoomsAvailability']['RoomAvailability']['DayAvailability'];
$alottedRooms = array();
$roomPrice = array();
if(!empty($rooms)){
	foreach($rooms as $room){
		if($room['Alot'] == 0){
			$alottedRooms[] = date('d-m-Y',strtotime($room['@attributes']['day']));
		}
		$date = date('d-m-Y',strtotime($room['@attributes']['day']));
		$roomPrice[$date] = number_format($room['Price']);
	}
}

$endDate = $alottedRooms;
$endDateNew = $alottedRooms;
$nextCheckoutDates = array();
foreach($endDate as $key=>$date){
	$prevDate = date('d-m-Y', strtotime($date .' -1 day'));
	if(!in_array($prevDate, $endDate)){
		$endDateNew = array_values(array_diff($endDateNew, array($date)));
		$nextCheckoutDates[] = $date;
	}
}

/*for not higlighting today's date*/
$date = date('d-m-Y');
$endDateNew[] = date('d-m-Y');
$nextCheckoutDates = array_values(array_diff($nextCheckoutDates, array($date)));

if(!empty($_POST['startDateSet'])){
	$dateStart = str_replace('/','-',$_POST['selected']);
	$oldDate =  $dateStart;
	for($i=0;$i<=365;$i++){
		$nextDate = date('d-m-Y', strtotime($oldDate .' +1 day'));
		if(in_array($nextDate,$nextCheckoutDates)){
			break;
		}else{
			$oldDate = $nextDate;
		}
	}
	echo json_encode(array('nextCheckout'=>$nextDate));die;
}

if($_POST['currencyRatesSet']){
	$symbol = $_POST['symbol'];
	$currencyRate = $_POST['currencyRate'];
	$html = '';
	if( have_rows('villats_rates_section') ):
		while ( have_rows('villats_rates_section') ) : the_row();
			$seasonRate = get_sub_field('villats_rates_section_title_three',356);
			$rate = $currencyRate*$seasonRate;
			$rate = $symbol.number_format($rate,1);
			$html.='<tr>
			<td>
			<div class="rate-title">'.get_sub_field('villats_rates_section_title_one',356).'</div>
			<div class="rate-period">'.get_sub_field('villats_rates_section_title_two',356).'</div>
			</td>
			<td data-title="Daily">
			<span class="payment-prices">
			<span> '.$rate.' </span>
			</span>
			</td>
			</tr>';
		endwhile;
	else :
	endif;
	echo json_encode(array('html'=>$html));die();
}
$_SESSION['pool_fence'] = get_field('pool_fence',356);
$_SESSION['image'] = '/assets/images/abvillaimg5.jpg';
$_SESSION['name'] = '6 Bedroom - Villa Sensel';
$_SESSION['address_line_1'] = 'Jl.Kunti 1, Gang Mangga N.01AB';
$_SESSION['address_line_2'] = '80361Seminyak, Kuta, Bali, Indonesia';
$_SESSION['guest'] = 12;
$_SESSION['city'] = 'Seminyak';

if(!empty($_POST['currencySet'])){
	$_SESSION['to_currency'] = $_POST['currency'];
	$currency1 = $_POST['currency'];
	$rates = $_SESSION['exchangeRates']->$currency1;
	$symbol = $_SESSION['symbols'][$_POST['currency']];
	echo json_encode(array('rates'=>$rates,'symbol'=>$symbol));die;
}

if($_POST){
	$_SESSION['durationPrice'] = $_POST;
	$checkAlottedDates = array();
	$startDate = $start = date('Y-m-d',strtotime(str_replace('/','-',$_POST['start_date'])));
	$startDate = strtotime($startDate);
	$endDate = $end = date('Y-m-d',strtotime(str_replace('/','-',$_POST['end_date'])));
	$endDate = strtotime($endDate);
	$status = 0;
	$_SESSION['durationPrice']['available'] = 'yes';
	for ($i=$startDate; $i<$endDate; $i+=86400) {  
		$dateCheckAlotted =  date("d-m-Y", $i);
		$checkAlottedDates[] =  date("Y-m-d", $i); 
		if(in_array($dateCheckAlotted,$alottedRooms)){
			$status = 1;
			$_SESSION['durationPrice']['available'] = 'no';
		}
	}
	$price = 0;
	$nights = 0;
	if($status == 0){
		foreach($rooms as $room){
			if(($room['Alot'] != 0) && in_array($room['@attributes']['day'],$checkAlottedDates)){
				$nights++;
				$price+=$room['Price'];
			}
		} 
	}
	$_SESSION['durationPrice']['price'] = $price;
	$_SESSION['durationPrice']['propertyID'] = $propertyID;
	$_SESSION['durationPrice']['nights'] = $nights;

	/*price calculation*/
	echo json_encode(array('status'=>$status,'price'=>$price,'nights'=>$nights));die;
}

/*currency conversion code*/ 
$toCurrency = 'USD';
if(!empty($_SESSION['to_currency'])){
	$toCurrency = $_SESSION['to_currency'];
}
$currencies = array();
$rates = 0;
if(!empty($_SESSION['exchangeRates'])){
	$currencies = (array)$_SESSION['exchangeRates'];
	$rates = $currencies[$toCurrency];
}
if(!empty($_SESSION['symbols'])){
	$symbols = $_SESSION['symbols'];
	$symbol = $symbols[$toCurrency];
}
get_header('one');
?>
<input type="hidden" id="symbol" value="<?php echo $symbol;?>">
<input type="hidden" id="currency_rate" value="<?php echo $rates;?>">
<input type="hidden" id="url" value="<?php echo home_url(); ?>">
<section class="VilaTab pd90">
	<div class="container">
		<div class="VilaTabDetail">
			<div class="row">
				<div class="col-md-9 col-sm-9 col-12">
					<div class="NineNewOne">//
			










						


<!-- <div id="loadMore">Load more</div>
	<div id="showLess">Show less</div> -->

</div>



<!-- ===============TRIAL ICON DEMO START========== -->


<div class="TRIALICON">

	<h6>Trial Demo Icon</h6>

	<div class="row">
		<div class="col-md-4 col-sm-4 col-12">
			<ul>
		<li>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st1.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st2.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st3.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st4.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st5.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st6.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st7.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st8.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st9.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st10.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st11.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st12.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st13.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st14.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st15.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st16.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st17.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st18.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st19.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st20.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st21.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st22.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st23.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st24.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st25.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st26.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st27.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st28.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st29.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st30.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st31.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st32.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st33.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st34.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st35.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st36.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st37.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st38.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st39.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st40.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st41.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st42.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st43.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st44.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st45.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st46.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/1st47.svg"> Free parking</p>
		</li> 
	</ul>
		</div>


		<div class="col-md-4 col-sm-4 col-12">
			<ul>
		<li>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd1.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd2.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd3.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd4.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd5.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd6.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd7.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd8.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd9.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd10.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd11.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd12.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd13.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd14.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd15.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd16.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd17.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd18.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd19.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd20.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd21.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd22.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd23.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd24.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd25.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd26.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd27.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd28.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd29.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd30.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd31.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd32.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd33.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd34.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd35.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd36.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd37.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd38.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd39.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd40.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd41.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd42.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd43.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd44.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd45.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd46.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/2nd47.svg"> Free parking</p>
		</li> 
	</ul>
		</div>


		<div class="col-md-4 col-sm-4 col-12">
			<ul>
		<li>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd1.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd2.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd3.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd4.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd5.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd6.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd7.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd8.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd9.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd10.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd11.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd12.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd13.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd14.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd15.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd16.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd17.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd18.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd19.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd20.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd21.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd22.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd23.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd24.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd25.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd26.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd27.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd28.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd29.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd30.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd31.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd32.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd33.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd34.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd35.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd36.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd37.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd38.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd39.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd40.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd41.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd42.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd43.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd44.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd45.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd46.svg"> Free parking</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/3rd47.svg"> Free parking</p>
		</li> 
	</ul>
		</div>
	</div>
	
</div>
<!-- ===============TRIAL ICON DEMO END========== -->




<!-- ===============TRIAL ICON DEMO START========== -->


<div class="TRIALICON" style="margin-top: 30px;">

	<h6> Second Trial Demo Icon </h6>

	<div class="row">
		<div class="col-md-4 col-sm-4 col-12">
			<ul>
		<li>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th1.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th2.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th3.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th4.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th5.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th6.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th7.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th8.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th9.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th10.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th11.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th12.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th13.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th14.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th15.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th16.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th17.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th18.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th19.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th20.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th21.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th22.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th23.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th24.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th25.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th26.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th27.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th28.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th29.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th30.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th31.svg"> Free parking 4</p>
			
		</li> 
	</ul>
		</div>


		<div class="col-md-4 col-sm-4 col-12">
			<ul>
		<li>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th32.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th33.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th34.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th35.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th36.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th37.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th38.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th39.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th40.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th41.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th42.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th43.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th44.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th45.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th46.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th47.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th48.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th49.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th50.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th51.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th52.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th53.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th54.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th55.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th56.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th57.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th58.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th59.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th60.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th61.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th62.svg"> Free parking 4</p>
			
			
		</li> 
	</ul>
		</div>


		<div class="col-md-4 col-sm-4 col-12">			
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th63.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th64.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th65.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th66.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th67.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th68.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th69.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th70.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th71.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th72.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th73.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th74.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th75.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th76.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th77.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th78.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th79.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th80.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th81.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th82.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th83.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th84.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th85.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th86.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th87.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th88.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th89.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th90.svg"> Free parking 4</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/4th91.svg"> Free parking 4</p>
			<ul>
		<li>
			
		</li> 
	</ul>
		</div>
	</div>
	
</div>
<!-- ===============TRIAL ICON DEMO END========== -->





<!-- ===============TRIAL ICON DEMO START========== -->


<div class="TRIALICON" style="margin-top: 30px;">

	<h6> Second Trial Demo Icon Last Final </h6>

	<div class="row">
		<div class="col-md-4 col-sm-4 col-12">
			<ul>
		<li>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/5thf1.svg"> Free parking 4 Final</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/5thf2.svg"> Free parking 4 Final</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/5thf3.svg"> Free parking 4 Final</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/5thf4.svg"> Free parking 4 Final</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/5thf5.svg"> Free parking 4 Final</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/5thf6.svg"> Free parking 4 Final</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/5thf7.svg"> Free parking 4 Final</p>
			
			
			
		</li> 
	</ul>
		</div>


		<div class="col-md-4 col-sm-4 col-12">
			<ul>
		<li>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/5thf8.svg"> Free parking 4 Final</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/5thf9.svg"> Free parking 4 Final</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/5thf10.svg"> Free parking 4 Final</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/5thf11.svg"> Free parking 4 Final</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/5thf12.svg"> Free parking 4 Final</p>
			
			
		</li> 
	</ul>
		</div>

				<div class="col-md-4 col-sm-4 col-12">
			<ul>
		<li>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/5thf13.svg"> Free parking 4 Final</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/5thf14.svg"> Free parking 4 Final</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/5thf15.svg"> Free parking 4 Final</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/5thf16.svg"> Free parking 4 Final</p>
			<p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/5thf17.svg"> Free parking 4 Final</p>
			
			
		</li> 
	</ul>
		</div>

	</div>
	
</div>
<!-- ===============TRIAL ICON DEMO END========== -->



































<div class="StiBlokBar">

	<div class="SinglChkBOxag">

		<div class="SidebarFrom SingSideABVila">
			<form method="post" action="#" id="booking">
				<!-- <p>from 17,471 ₨ per night </p> -->
				<div class="side_new">
					<div class="row">

						<div class="col-md-4 col-sm-4 col-4 MobChkPdall">
							<div class="form-group BannrGrup mb_20">
								<input type="text" placeholder="Check-IN" class="form-control   hasDatepicker" id="start_date" name="start_date" autocomplete="off" readonly="">   
								<label class="lnr lnr-calendar-full" for="start_date"></label> 
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-4 MobChkPdall">
							<div class="form-group BannrGrup mb_20">
								<input type="text" placeholder="Check-OUT" class="form-control   hasDatepicker" id="end_date" name="end_date" autocomplete="off" readonly=""> 
								<label class="lnr lnr-calendar-full" for="end_date"></label> 
							</div>
						</div>

<div class="col-md-4 col-sm-4 col-4 MobChkPdall">
	<div class="form-group BannrGrup mb_20 PixBtnMr1">
		<button type="button" class="btn SubBtn BkNow">Book Now</button>
	</div>
</div>

<div id="total_rupees" class="TotRu109">
<p>2 night / Total USD $530</p>
</div>

</div>
</div>
</form>
</div>





</div>









	<div class="row">
		<div class="col-md-12 col-sm-12 col-12">
			<div class="TAbULId">
				<div class="row">
					<div class="col-md-12">
						<ul class="MainWidth-ul">
							<li class="MaxwiLi1"><a href="#VidClick1">Video</a></li>
							<li class="MaxwiLi2"><a href="#GalClick1">Gallery</a></li>
							<li class="MaxwiLi3"><a href="#FplanClick1">Floor Plan</a></li>
							<li class="MaxwiLi4"><a href="#LocClick1">Location</a></li>
							<li class="MaxwiLi5"><a href="#RatClick1">Rates</a></li>
							<li class="MaxwiLi6"><a href="#AvaClick1">Availability</a></li>
							<li class="MaxwiLi7"><a href="#RevClick1">Review</a></li>
							<li class="MaxwiLi8"><a href="#feaClick1">Feature</a></li>
						</ul>
					</div>
				</div>
			</div> 
		</div>
	</div>


</div>
<div class="CustomTabNew">

	<div class="TabContFlr">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-12">
				<div class="ContTabDetail ForTxtCapH">
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

					<h4>Start your Virtual Tour<!--  around Villa Sensel --></h4>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- ========TAB END======= -->

<div class="faq_ins forabvilaFaqins">

	<div class="row">
		<div class="col-md-12 col-sm-12 col-12">
			<div class="my_wimin">
				<!--Accordion wrapper-->
				<div class="accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
					<!-- Accordion card -->
					<div class="card carddesign" id="VidClick1">
						<!-- Card header -->
						<div class="card-header" role="tab" id="headingOne">
							<a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="iarrowclick">
								<h5 class="mb-0"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
									width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
									<style type="text/css">
										.st0{fill:none;}
										.st1{fill:#952524;}
									</style>
									<rect class="st0" width="32" height="32"/>
									<g>
										<path class="st1" d="M26.7,0.5H5.3c-2.7,0-4.8,2.2-4.8,4.8v21.3c0,2.7,2.2,4.8,4.8,4.8h21.3c2.7,0,4.8-2.2,4.8-4.8V5.3
										C31.5,2.7,29.3,0.5,26.7,0.5 M30.3,5.3v21.3c0,2-1.7,3.7-3.7,3.7H5.3c-2,0-3.7-1.7-3.7-3.7V5.3c0-2,1.7-3.7,3.7-3.7h21.3
										C28.7,1.7,30.3,3.3,30.3,5.3"/>
										<path class="st1" d="M23.3,15.5L11.5,8.7c-0.3-0.1-0.6-0.2-0.7-0.1c-0.3,0.2-0.3,0.5-0.3,0.7v13.6c0,0.2,0.1,0.3,0.3,0.4
										c0.1,0,0.2,0.1,0.3,0.1c0.1,0,0.2,0,0.3-0.1l12-7c0.2-0.1,0.3-0.3,0.3-0.4C23.6,15.8,23.5,15.6,23.3,15.5 M21.7,15.9l-10.1,5.8
										V10.1L21.7,15.9z"/>
									</g>
								</svg> Video <i class="fa fa-angle-up rotate-icon"></i></h5>
							</a>
						</div>
						<!-- Card body -->
						<div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" style="">
							<div class="card-body">
								<div class="DesVideo galdesvideo abgalvideo">
									<?php the_field('overview_description_video',356); ?>
								</div>
							</div>
						</div>
					</div>
					<!-- Accordion card -->
					<div class="card carddesign" id="GalClick1">
						<!-- Card header -->
						<div class="card-header" role="tab" id="headingTwo">
							<a data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" class="iarrowclick">
<h5 class="mb-0"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
<style type="text/css">
	.st0{fill:none;}
	.st1{fill:#952524;}
</style>
<rect class="st0" width="32" height="32"/>
<g>
	<path class="st1" d="M8.2,12.3c1.9,0,3.5-1.6,3.5-3.5s-1.6-3.5-3.5-3.5S4.7,6.8,4.7,8.8S6.3,12.3,8.2,12.3z M8.2,6.4
	c1.3,0,2.4,1.1,2.4,2.4s-1.1,2.4-2.4,2.4c-1.3,0-2.4-1.1-2.4-2.4S6.9,6.4,8.2,6.4z"/>
	<path class="st1" d="M26.7,0.5H5.3c-2.7,0-4.8,2.2-4.8,4.8v21.3c0,2.7,2.2,4.8,4.8,4.8h21.3c2.7,0,4.8-2.2,4.8-4.8V5.3
	C31.5,2.7,29.3,0.5,26.7,0.5z M5.3,1.7h21.3c2,0,3.7,1.7,3.7,3.7v20.1l-7.9-8c-0.6-0.6-1.4-0.9-2.2-0.9c-0.8,0-1.6,0.4-2.1,1.1
	l-2.2,2.7L12,16.1c-0.5-0.6-1.3-0.9-2.1-0.8c-0.8,0-1.5,0.4-2,1l-6.3,8V5.3C1.7,3.3,3.3,1.7,5.3,1.7z M1.7,26.7v-0.5L8.9,17
	c0.3-0.3,0.7-0.6,1.1-0.6c0,0,0,0,0.1,0c0.4,0,0.8,0.2,1.1,0.5l12.9,13.4H5.3C3.3,30.3,1.7,28.7,1.7,26.7z M26.7,30.3h-1l-8.8-9.2
	l2.3-2.8c0.3-0.4,0.7-0.6,1.2-0.6c0,0,0.1,0,0.1,0c0.4,0,0.9,0.2,1.2,0.5l8.6,8.8l0.1,0.1C30,28.9,28.5,30.3,26.7,30.3z"/>
</g>
</svg>

Gallery <i class="fa fa-angle-up rotate-icon"></i></h5>
</a>
</div>
<!-- Card body -->
<div id="collapseTwo" class="collapse show" role="tabpanel" aria-labelledby="headingTwo" style="">
	<div class="card-body">
		<div class="pills-GalleryT GAllBrdrBottom">
			<div class="row">
				<div class="col-md-2 col-sm-2 col-12 OutCenter2">
<p class="OutImg2"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
<style type="text/css">
	.st0{fill:none;}
	.st1{fill:#952524;}
</style>
<g>
	<rect class="st0" width="32" height="32"/>
</g>
<g>
	<path class="st1" d="M31.9,20.7L29,13.1V5.2c0-1.7-1.4-3.1-3.1-3.1H6C4.3,2.1,3,3.5,3,5.2v7.9l-2.9,7.6C0,20.8,0,20.9,0,21.1l0,6.2
	c0,0.6,0.5,1.1,1.1,1.1h1.5v1.3c0,0.1,0.1,0.2,0.2,0.2h0.8c0.1,0,0.2-0.1,0.2-0.2v-1.3h24.2v1.3c0,0.1,0.1,0.2,0.2,0.2h0.8
	c0.1,0,0.2-0.1,0.2-0.2v-1.3h1.5c0.6,0,1.1-0.5,1.1-1.1v-6.2C32,21,32,20.8,31.9,20.7z M24.9,13.3c0,0.1,0,0.2-0.1,0.3
	c-0.1,0.2-0.3,0.3-0.5,0.3H19c-0.2,0-0.4-0.1-0.5-0.3c-0.1-0.1-0.1-0.2-0.1-0.3v-3c0-0.3,0.3-0.6,0.6-0.6h5.3
	c0.3,0,0.6,0.3,0.6,0.6V13.3z M13.6,10.3v3c0,0.1,0,0.2-0.1,0.3c-0.1,0.2-0.3,0.3-0.5,0.3H7.7c-0.2,0-0.4-0.1-0.5-0.3
	c-0.1-0.1-0.1-0.2-0.1-0.3v-3c0-0.3,0.3-0.6,0.6-0.6H13C13.4,9.7,13.6,9.9,13.6,10.3z M27.8,12.6h-1.7v-2.3c0-1-0.8-1.8-1.8-1.8H19
	c-1,0-1.8,0.8-1.8,1.8v2.3h-2.3v-2.3c0-1-0.8-1.8-1.8-1.8H7.7c-1,0-1.8,0.8-1.8,1.8v2.3H4.2V5.2c0-1,0.8-1.9,1.9-1.9h20
	c1,0,1.9,0.8,1.9,1.9V12.6z M13,15.1c0.8,0,1.5-0.5,1.7-1.3h2.5c0.2,0.8,0.9,1.3,1.7,1.3h5.3c0.8,0,1.5-0.5,1.7-1.3h2l2.5,6.6h-29
	L4,13.8h2c0.2,0.8,0.9,1.3,1.7,1.3H13z M30.8,21.6v5.6H1.2v-5.6H30.8z"/>
</g>
</svg>
Bedroom</p>
</div>
<div class="col-md-10">
	<div class="ColGalIN">
		<div class="row">

			<div class="col-md-6 pad106">
				<div class="tabGallery Tabgallbk2">
					<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
						<div class="carousel-inner">
							<div class="carousel-item active">
								<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/01-VILLA-SENSEL-FIRST-FLOOR-BEDROOM-MASTER-2.jpg" data-caption="Bedroom 1- master(first-floor)">
									<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/01-VILLA-SENSEL-FIRST-FLOOR-BEDROOM-MASTER-2.jpg" alt="Image" class="img-fluid">
								</a>
							</div>
							<div class="carousel-item">
								<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/02-VILLA-SENSEL-FIRST-FLOOR-BEDROOM-MASTER-1.jpg" data-caption="Bedroom 1- master(first-floor)">
									<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/02-VILLA-SENSEL-FIRST-FLOOR-BEDROOM-MASTER-1.jpg" alt="Image" class="img-fluid">
								</a>
							</div>
							<div class="carousel-item">
								<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/03-VILLA-SENSEL-FIRST-FLOOR-BATHROOM-MASTER.jpg" data-caption="Bedroom 1- master(first-floor)">
									<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/03-VILLA-SENSEL-FIRST-FLOOR-BATHROOM-MASTER.jpg" alt="Image" class="img-fluid">
								</a>
							</div>
						</div>
						<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
					</div>




	<div class="GaHeding">
		<h1>Bedroom 1- master <span>(first floor)</span></h1>
		<div class="row forbedmin">
			<div class="col-md-6 col-sm-6 col-6">
				<div class="BediconGal">
					<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<rect y="0" class="st0" width="32" height="32"/>
						<g>
							<path class="st1" d="M30.78,17.16c-1.68-2.21-4.42-2.12-5.59-1.97c-0.9-3.26-3.51-6.71-4.37-7.79l1.09-0.9l-0.46-0.56L16.8,9.78
							l-0.06,0.05l0.46,0.56l1.51-1.25l1.82,2.89c0.78,1.24,0.52,3.09,0.52,3.11c-0.58,3.79-4.5,3.38-4.94,3.32
							c-1.21-0.3-1.97-0.81-2.24-1.49c-0.39-1,0.3-2.23,0.62-2.71c0.26-0.39,0.35-0.85,0.26-1.3c-0.46-2.28-2.78-2.54-2.81-2.54l-3.68,0
							c-6.12,0-7.18,9.36-7.23,9.76l-0.05,0.48h3.52c-0.1,0.37-0.15,0.74-0.15,1.11c0,2.37,1.93,4.29,4.29,4.29c2.2,0,4.06-1.7,4.27-3.88
							h9.05c0.21,2.18,2.07,3.88,4.27,3.88c2.37,0,4.29-1.93,4.29-4.29c0-1.01-0.36-2-1.02-2.77l1.51-1.54L30.78,17.16z M8.65,18.35
							c1.88,0,3.42,1.53,3.42,3.42s-1.53,3.42-3.42,3.42s-3.42-1.53-3.42-3.42S6.77,18.35,8.65,18.35z M13.76,13.78
							c-0.49,0.74-1.22,2.18-0.7,3.51c0.38,0.97,1.34,1.65,2.86,2.03l0.04,0.01c0.21,0.03,5.24,0.64,5.95-4.05
							c0.01-0.09,0.32-2.18-0.64-3.71l-1.88-2.99l0.75-0.62c0.88,1.11,3.56,4.69,4.3,7.83l0.1,0.42l0.42-0.09
							c0.03-0.01,3.1-0.64,4.88,1.29l-0.98,0.99c-0.75-0.59-1.69-0.91-2.64-0.91c-2.17,0-4.03,1.68-4.26,3.83h-9.05
							c-0.23-2.15-2.09-3.83-4.26-3.83c-1.6,0-3.05,0.88-3.8,2.31H1.98c0.33-2.11,1.73-8.49,6.29-8.49l3.6,0c0,0,0.01,0,0.01,0
							c0.24,0,1.71,0.33,2.01,1.84C13.94,13.35,13.89,13.58,13.76,13.78z M26.23,18.35c1.88,0,3.42,1.53,3.42,3.42s-1.53,3.42-3.42,3.42
							s-3.42-1.53-3.42-3.42S24.35,18.35,26.23,18.35z"/>
						</g>
					</svg> Bed 1,8x2Mt</p>
					<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<rect y="0" class="st0" width="32" height="32"/>
						<g>
							<path class="st1" d="M30.75,20.37l-2.67-7.07V5.92c0-1.54-1.24-2.78-2.78-2.78H6.7c-1.54,0-2.78,1.24-2.78,2.78v7.38l-2.67,7.05
							c-0.05,0.12-0.07,0.25-0.07,0.39l0,5.79c0,0.52,0.42,0.95,0.95,0.95h1.49v1.26c0,0.07,0.06,0.13,0.13,0.13h0.78
							c0.07,0,0.13-0.06,0.13-0.13v-1.26h22.64v1.26c0,0.07,0.06,0.13,0.13,0.13h0.78c0.07,0,0.13-0.06,0.13-0.13v-1.26h1.49
							c0.52,0,0.95-0.43,0.95-0.95v-5.76C30.82,20.62,30.8,20.49,30.75,20.37z M4.91,5.92c0-0.99,0.8-1.79,1.79-1.79h18.6
							c0.99,0,1.79,0.8,1.79,1.79v6.97h-1.73v-2.24c0-0.89-0.72-1.62-1.62-1.62h-4.98c-0.89,0-1.62,0.72-1.62,1.62v2.24h-2.29v-2.24
							c0-0.89-0.72-1.62-1.62-1.62H8.26c-0.89,0-1.62,0.72-1.62,1.62v2.24H4.91V5.92z M24.37,10.65v2.79c0,0.11-0.03,0.22-0.09,0.32
							c-0.12,0.2-0.32,0.31-0.54,0.31h-4.98c-0.22,0-0.43-0.12-0.54-0.31c-0.06-0.1-0.09-0.21-0.09-0.32v-2.79
							c0-0.35,0.28-0.63,0.63-0.63h4.98C24.09,10.02,24.37,10.31,24.37,10.65z M13.87,10.65v2.79c0,0.11-0.03,0.22-0.09,0.32
							c-0.12,0.2-0.32,0.31-0.54,0.31H8.26c-0.22,0-0.43-0.12-0.54-0.31c-0.06-0.1-0.09-0.21-0.09-0.32v-2.79c0-0.35,0.28-0.63,0.63-0.63
							h4.98C13.59,10.02,13.87,10.31,13.87,10.65z M4.76,13.88H6.7c0.19,0.7,0.83,1.19,1.56,1.19h4.98c0.73,0,1.36-0.49,1.56-1.19h2.41
							c0.19,0.7,0.83,1.19,1.56,1.19h4.98c0.73,0,1.36-0.49,1.56-1.19h1.95l2.37,6.26H2.39L4.76,13.88z M29.83,26.48H2.17v-5.35h27.66
							V26.48z"/>
						</g>
					</svg> Ensuite Bathroom</p>
					<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<rect y="0" class="st0" width="32" height="32"/>
						<g>
							<path class="st1" d="M26.31,1.01H5.69c-2.58,0-4.68,2.1-4.68,4.68v20.61c0,2.58,2.1,4.68,4.68,4.68h20.61
							c2.58,0,4.68-2.1,4.68-4.68V5.69C30.99,3.11,28.89,1.01,26.31,1.01z M2.13,25.61L9,16.92c0.29-0.36,0.71-0.58,1.17-0.6
							c0.46-0.02,0.9,0.15,1.22,0.49l12.57,13.07H5.69c-1.97,0-3.57-1.6-3.57-3.57V25.61z M18.25,17.68l-2.18,2.69l-4.03-4.19
							c-0.5-0.52-1.19-0.8-1.91-0.76c-0.72,0.04-1.38,0.38-1.83,0.94l-6.17,7.81V5.69c0-1.97,1.6-3.57,3.57-3.57h20.61
							c1.97,0,3.57,1.6,3.57,3.57v19.67l-7.69-7.86c-0.5-0.51-1.18-0.79-1.89-0.79c-0.04,0-0.08,0-0.11,0
							C19.43,16.74,18.73,17.1,18.25,17.68z M26.31,29.87h-1.1l-8.51-8.85l2.25-2.78c0.31-0.39,0.78-0.62,1.27-0.64c0.03,0,0.05,0,0.08,0
							c0.47,0,0.92,0.19,1.24,0.52l8.3,8.49C29.69,28.44,28.14,29.87,26.31,29.87z"/>
							<path class="st1" d="M8.5,5.72C6.68,5.72,5.2,7.2,5.2,9.02s1.48,3.29,3.29,3.29s3.29-1.48,3.29-3.29S10.31,5.72,8.5,5.72z
							M10.89,9.02c0,1.32-1.08,2.4-2.4,2.4c-1.32,0-2.4-1.08-2.4-2.4c0-1.32,1.08-2.4,2.4-2.4C9.82,6.62,10.89,7.69,10.89,9.02z"/>
						</g>
					</svg> Sofa</p>
					<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<rect y="0" class="st0" width="32" height="32"/>
						<g>
							<path class="st1" d="M26.31,1.01H5.69c-2.58,0-4.68,2.1-4.68,4.68v20.61c0,2.58,2.1,4.68,4.68,4.68h20.61
							c2.58,0,4.68-2.1,4.68-4.68V5.69C30.99,3.11,28.89,1.01,26.31,1.01z M2.13,25.61L9,16.92c0.29-0.36,0.71-0.58,1.17-0.6
							c0.46-0.02,0.9,0.15,1.22,0.49l12.57,13.07H5.69c-1.97,0-3.57-1.6-3.57-3.57V25.61z M18.25,17.68l-2.18,2.69l-4.03-4.19
							c-0.5-0.52-1.19-0.8-1.91-0.76c-0.72,0.04-1.38,0.38-1.83,0.94l-6.17,7.81V5.69c0-1.97,1.6-3.57,3.57-3.57h20.61
							c1.97,0,3.57,1.6,3.57,3.57v19.67l-7.69-7.86c-0.5-0.51-1.18-0.79-1.89-0.79c-0.04,0-0.08,0-0.11,0
							C19.43,16.74,18.73,17.1,18.25,17.68z M26.31,29.87h-1.1l-8.51-8.85l2.25-2.78c0.31-0.39,0.78-0.62,1.27-0.64c0.03,0,0.05,0,0.08,0
							c0.47,0,0.92,0.19,1.24,0.52l8.3,8.49C29.69,28.44,28.14,29.87,26.31,29.87z"/>
							<path class="st1" d="M8.5,5.72C6.68,5.72,5.2,7.2,5.2,9.02s1.48,3.29,3.29,3.29s3.29-1.48,3.29-3.29S10.31,5.72,8.5,5.72z
							M10.89,9.02c0,1.32-1.08,2.4-2.4,2.4c-1.32,0-2.4-1.08-2.4-2.4c0-1.32,1.08-2.4,2.4-2.4C9.82,6.62,10.89,7.69,10.89,9.02z"/>
						</g>
					</svg>Bathtub</p>

</div>
</div>
<div class="col-md-6 col-sm-6 col-6">
	<div class="BediconGal">
		<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
			<style type="text/css">
				.st0{fill:none;}
				.st1{fill:#952524;}
			</style>
			<rect y="0" class="st0" width="32" height="32"/>
			<g>
				<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
				c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
				c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
				<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
				<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
				M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
			</g>
		</svg>Air Conditioning</p>


		<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
			<style type="text/css">
				.st0{fill:none;}
				.st1{fill:#952524;}
			</style>
			<rect y="0" class="st0" width="32" height="32"/>
			<g>
				<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
				c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
				c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
				<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
				<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
				M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
			</g>
		</svg>TV LCD 32”</p>

		<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
			<style type="text/css">
				.st0{fill:none;}
				.st1{fill:#952524;}
			</style>
			<rect y="0" class="st0" width="32" height="32"/>
			<g>
				<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
				c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
				c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
				<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
				<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
				M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
			</g>
		</svg>DVD Player</p>


		<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
			<style type="text/css">
				.st0{fill:none;}
				.st1{fill:#952524;}
			</style>
			<rect y="0" class="st0" width="32" height="32"/>
			<g>
				<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
				c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
				c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
				<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
				<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
				M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
			</g>
		</svg>Safety Box</p>

</div>
</div>
</div>
</div>
</div>
</div>
<!-- ==========COL SIX END=== -->
<div class="col-md-6 pad106">
	<div class="tabGallery Tabgallbk2">


		<div id="carouselExampleControls2" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item active">
					<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/04-VILLA-SENSE-GROUND-FLOOR-BEDROOM-MASTER-2.jpg" data-caption="Bedroom 2- Hut (first-floor)">
						<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/04-VILLA-SENSE-GROUND-FLOOR-BEDROOM-MASTER-2.jpg" alt="Image" class="img-fluid" >
					</a>
				</div>
				<div class="carousel-item">
					<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/05-VILLA-SENSEL-GROUND-FLOOR-BEDROOM-MASTER-1.jpg" data-caption="Bedroom 2- Hut (first-floor)">
						<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/05-VILLA-SENSEL-GROUND-FLOOR-BEDROOM-MASTER-1.jpg" alt="Image" class="img-fluid">
					</a>
				</div>
				<div class="carousel-item">
					<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/06-VILLA-SENSEL-GROUND-FLOOR-BATHROOM-MASTER.jpg" data-caption="Bedroom 2- Hut (first-floor)">
						<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/06-VILLA-SENSEL-GROUND-FLOOR-BATHROOM-MASTER.jpg" alt="Image" class="img-fluid">
					</a>
				</div>
			</div>
			<a class="carousel-control-prev" href="#carouselExampleControls2" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleControls2" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>

<!--  <img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/05/g1.jpg" alt="Image" class="img-fluid">

	<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/05/g1.jpg" alt="Image" class="img-fluid"> -->




	<div class="GaHeding">
		<h1>Bedroom 2 - Master B <span>(Ground Floor)</span></h1>
		<div class="row forbedmin">
			<div class="col-md-6 col-sm-6 col-6">
				<div class="BediconGal">
					<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<rect y="0" class="st0" width="32" height="32"/>
						<g>
							<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
							c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
							c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
							<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
							<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
							M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
						</g>
					</svg>Bed 1,8x2Mt</p>
					<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<rect y="0" class="st0" width="32" height="32"/>
						<path class="st1" d="M29.72,17.48l-10.73-6.47l0-5.13l0-0.05c-0.47-3.89-1.95-5.11-2.57-5.46L16.4,0.37h0
						c-0.24-0.12-0.55-0.12-0.79,0l-0.02,0.01c-0.62,0.34-2.1,1.57-2.57,5.46l0,5.17L2.28,17.48c-0.93,0.56-1.51,1.59-1.51,2.67v2.36
						l12.32-4.29l0,1.5c-0.01,0.25,0.02,1.53,0.94,7.23l-2.68,2.08l-0.03,0.02v2.65h9.34v-2.65l-2.7-2.1c0.92-5.71,0.95-6.98,0.94-7.23
						v-1.51l12.32,4.29v-2.36C31.23,19.07,30.65,18.04,29.72,17.48z M12.24,29.52l2.78-2.16l-0.04-0.27C13.97,20.87,14,19.84,14,19.79
						l0-2.84L1.68,21.24v-1.08c0-0.77,0.41-1.5,1.07-1.89l11.14-6.71l0.04-0.02V6.11c0-0.13,0.01-0.26,0.02-0.38
						c0.36-2.7,1.24-3.85,1.72-4.29c0,0,0.04-0.04,0.11-0.08c0.12-0.07,0.29-0.12,0.45-0.01c0.04,0.02,0.06,0.05,0.1,0.08
						c0.49,0.44,1.36,1.59,1.72,4.29c0.02,0.12,0.02,0.25,0.02,0.38v5.42l11.17,6.73c0.66,0.4,1.07,1.12,1.07,1.9v1.08L18,16.95l0,2.83
						c0,0.04,0.05,0.99-0.97,7.3l-0.04,0.27l2.78,2.16v1.3h-7.52V29.52z"/>
					</svg>Ensuite Bathroom</p>
					<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<rect y="0" class="st0" width="32" height="32"/>
						<path class="st1" d="M29.72,17.48l-10.73-6.47l0-5.13l0-0.05c-0.47-3.89-1.95-5.11-2.57-5.46L16.4,0.37h0
						c-0.24-0.12-0.55-0.12-0.79,0l-0.02,0.01c-0.62,0.34-2.1,1.57-2.57,5.46l0,5.17L2.28,17.48c-0.93,0.56-1.51,1.59-1.51,2.67v2.36
						l12.32-4.29l0,1.5c-0.01,0.25,0.02,1.53,0.94,7.23l-2.68,2.08l-0.03,0.02v2.65h9.34v-2.65l-2.7-2.1c0.92-5.71,0.95-6.98,0.94-7.23
						v-1.51l12.32,4.29v-2.36C31.23,19.07,30.65,18.04,29.72,17.48z M12.24,29.52l2.78-2.16l-0.04-0.27C13.97,20.87,14,19.84,14,19.79
						l0-2.84L1.68,21.24v-1.08c0-0.77,0.41-1.5,1.07-1.89l11.14-6.71l0.04-0.02V6.11c0-0.13,0.01-0.26,0.02-0.38
						c0.36-2.7,1.24-3.85,1.72-4.29c0,0,0.04-0.04,0.11-0.08c0.12-0.07,0.29-0.12,0.45-0.01c0.04,0.02,0.06,0.05,0.1,0.08
						c0.49,0.44,1.36,1.59,1.72,4.29c0.02,0.12,0.02,0.25,0.02,0.38v5.42l11.17,6.73c0.66,0.4,1.07,1.12,1.07,1.9v1.08L18,16.95l0,2.83
						c0,0.04,0.05,0.99-0.97,7.3l-0.04,0.27l2.78,2.16v1.3h-7.52V29.52z"/>
					</svg>Sofa</p>
					<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<rect y="0" class="st0" width="32" height="32"/>
						<path class="st1" d="M29.72,17.48l-10.73-6.47l0-5.13l0-0.05c-0.47-3.89-1.95-5.11-2.57-5.46L16.4,0.37h0
						c-0.24-0.12-0.55-0.12-0.79,0l-0.02,0.01c-0.62,0.34-2.1,1.57-2.57,5.46l0,5.17L2.28,17.48c-0.93,0.56-1.51,1.59-1.51,2.67v2.36
						l12.32-4.29l0,1.5c-0.01,0.25,0.02,1.53,0.94,7.23l-2.68,2.08l-0.03,0.02v2.65h9.34v-2.65l-2.7-2.1c0.92-5.71,0.95-6.98,0.94-7.23
						v-1.51l12.32,4.29v-2.36C31.23,19.07,30.65,18.04,29.72,17.48z M12.24,29.52l2.78-2.16l-0.04-0.27C13.97,20.87,14,19.84,14,19.79
						l0-2.84L1.68,21.24v-1.08c0-0.77,0.41-1.5,1.07-1.89l11.14-6.71l0.04-0.02V6.11c0-0.13,0.01-0.26,0.02-0.38
						c0.36-2.7,1.24-3.85,1.72-4.29c0,0,0.04-0.04,0.11-0.08c0.12-0.07,0.29-0.12,0.45-0.01c0.04,0.02,0.06,0.05,0.1,0.08
						c0.49,0.44,1.36,1.59,1.72,4.29c0.02,0.12,0.02,0.25,0.02,0.38v5.42l11.17,6.73c0.66,0.4,1.07,1.12,1.07,1.9v1.08L18,16.95l0,2.83
						c0,0.04,0.05,0.99-0.97,7.3l-0.04,0.27l2.78,2.16v1.3h-7.52V29.52z"/>
					</svg>Work Table</p>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-6">
				<div class="BediconGal">

					<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<rect y="0" class="st0" width="32" height="32"/>
						<g>
							<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
							c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
							c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
							<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
							<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
							M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
						</g>
					</svg>Air Conditioning</p>


					<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<rect y="0" class="st0" width="32" height="32"/>
						<g>
							<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
							c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
							c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
							<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
							<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
							M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
						</g>
					</svg>TV LCD 32”</p>

					<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<rect y="0" class="st0" width="32" height="32"/>
						<g>
							<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
							c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
							c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
							<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
							<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
							M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
						</g>
					</svg>DVD Player</p>


					<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<rect y="0" class="st0" width="32" height="32"/>
						<g>
							<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
							c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
							c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
							<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
							<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
							M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
						</g>
					</svg>Safety Box</p>

				</div>
			</div>
		</div>
	</div>
</div>
</div>


<!-- ==========COL SIX END=== -->
<div class="col-md-6 pad106">
	<div class="tabGallery Tabgallbk2">

		<div id="carouselExampleControls3" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item active">
					<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/07-VILLASENSEL.jpg" data-caption="3-Bedroom 3 - Guests A">
						<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/07-VILLASENSEL.jpg" alt="Image" class="img-fluid" >
					</a>
				</div>
				<div class="carousel-item">
					<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/08-VILLAS-ENSEL.jpg" data-caption="3-Bedroom 3 - Guests A">
						<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/08-VILLAS-ENSEL.jpg" alt="Image" class="img-fluid">
					</a>
				</div>

				<div class="carousel-item">
					<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/09-VILLA-SENSEL.jpg" data-caption="3-Bedroom 3 - Guests A">
						<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/09-VILLA-SENSEL.jpg" alt="Image" class="img-fluid">
					</a>
				</div>

				<div class="carousel-item">
					<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/10-VILLA-SENSE.jpg" data-caption="3-Bedroom 3 - Guests A">
						<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/10-VILLA-SENSE.jpg" alt="Image" class="img-fluid">
					</a>
				</div>

			</div>
			<a class="carousel-control-prev" href="#carouselExampleControls3" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleControls3" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>




		<div class="GaHeding">
			<h1>Bedroom 3 - Guest A <span>(Ground Floor)</span></h1>
			<div class="row forbedmin">
				<div class="col-md-6 col-sm-6 col-6">
					<div class="BediconGal">

						<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
							width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
							<style type="text/css">
								.st0{fill:none;}
								.st1{fill:#952524;}
							</style>
							<rect y="0" class="st0" width="32" height="32"/>
							<g>
								<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
								c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
								c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
								<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
								<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
								M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
							</g>
						</svg>2 Beds 1x2Mt</p>

						<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
							width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
							<style type="text/css">
								.st0{fill:none;}
								.st1{fill:#952524;}
							</style>
							<rect y="0" class="st0" width="32" height="32"/>
							<g>
								<path class="st1" d="M30.75,20.37l-2.67-7.07V5.92c0-1.54-1.24-2.78-2.78-2.78H6.7c-1.54,0-2.78,1.24-2.78,2.78v7.38l-2.67,7.05
								c-0.05,0.12-0.07,0.25-0.07,0.39l0,5.79c0,0.52,0.42,0.95,0.95,0.95h1.49v1.26c0,0.07,0.06,0.13,0.13,0.13h0.78
								c0.07,0,0.13-0.06,0.13-0.13v-1.26h22.64v1.26c0,0.07,0.06,0.13,0.13,0.13h0.78c0.07,0,0.13-0.06,0.13-0.13v-1.26h1.49
								c0.52,0,0.95-0.43,0.95-0.95v-5.76C30.82,20.62,30.8,20.49,30.75,20.37z M4.91,5.92c0-0.99,0.8-1.79,1.79-1.79h18.6
								c0.99,0,1.79,0.8,1.79,1.79v6.97h-1.73v-2.24c0-0.89-0.72-1.62-1.62-1.62h-4.98c-0.89,0-1.62,0.72-1.62,1.62v2.24h-2.29v-2.24
								c0-0.89-0.72-1.62-1.62-1.62H8.26c-0.89,0-1.62,0.72-1.62,1.62v2.24H4.91V5.92z M24.37,10.65v2.79c0,0.11-0.03,0.22-0.09,0.32
								c-0.12,0.2-0.32,0.31-0.54,0.31h-4.98c-0.22,0-0.43-0.12-0.54-0.31c-0.06-0.1-0.09-0.21-0.09-0.32v-2.79
								c0-0.35,0.28-0.63,0.63-0.63h4.98C24.09,10.02,24.37,10.31,24.37,10.65z M13.87,10.65v2.79c0,0.11-0.03,0.22-0.09,0.32
								c-0.12,0.2-0.32,0.31-0.54,0.31H8.26c-0.22,0-0.43-0.12-0.54-0.31c-0.06-0.1-0.09-0.21-0.09-0.32v-2.79c0-0.35,0.28-0.63,0.63-0.63
								h4.98C13.59,10.02,13.87,10.31,13.87,10.65z M4.76,13.88H6.7c0.19,0.7,0.83,1.19,1.56,1.19h4.98c0.73,0,1.36-0.49,1.56-1.19h2.41
								c0.19,0.7,0.83,1.19,1.56,1.19h4.98c0.73,0,1.36-0.49,1.56-1.19h1.95l2.37,6.26H2.39L4.76,13.88z M29.83,26.48H2.17v-5.35h27.66
								V26.48z"/>
							</g>
						</svg> Ensuite Bathroom</p>

					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-6">
					<div class="BediconGal">
						<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
							width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
							<style type="text/css">
								.st0{fill:none;}
								.st1{fill:#952524;}
							</style>
							<rect y="0" class="st0" width="32" height="32"/>
							<g>
								<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
								c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
								c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
								<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
								<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
								M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
							</g>
						</svg>Air Conditioning</p>

							<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<rect y="0" class="st0" width="32" height="32"/>
						<g>
							<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
							c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
							c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
							<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
							<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
							M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
						</g>
					</svg>TV LCD 32”</p>

						<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
							width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
							<style type="text/css">
								.st0{fill:none;}
								.st1{fill:#952524;}
							</style>
							<rect y="0" class="st0" width="32" height="32"/>
							<g>
								<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
								c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
								c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
								<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
								<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
								M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
							</g>
						</svg>Safety Box</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ==========COL SIX END=== -->




<div class="col-md-6 pad106">
	<div class="tabGallery Tabgallbk2">

		<div id="carouselExampleControls4" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item active">
					<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/11-VILLASENSEL.jpg" data-caption="4-Bedroom 4 - Guests  B">
						<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/11-VILLASENSEL.jpg" alt="Image" class="img-fluid" >
					</a>
				</div>
				<div class="carousel-item">
					<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/12-VILLA-SENSE.jpg" data-caption="4-Bedroom 4 - Guests  B">
						<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/12-VILLA-SENSE.jpg" alt="Image" class="img-fluid">
					</a>
				</div>

			</div>
			<a class="carousel-control-prev" href="#carouselExampleControls4" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleControls4" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>


<!--  <img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/05/g1.jpg" alt="Image" class="img-fluid">

	<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/05/g1.jpg" alt="Image" class="img-fluid"> -->


	<div class="GaHeding">
		<h1>Bedroom 4 - Guest B <span>(Ground Floor)</span></h1>
		<div class="row forbedmin">
			<div class="col-md-6 col-sm-6 col-6">
				<div class="BediconGal">
					<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<rect y="0" class="st0" width="32" height="32"/>
						<g>
							<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
							c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
							c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
							<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
							<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
							M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
						</g>
					</svg>Bed 1,8x2Mt</p>

					<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<rect y="0" class="st0" width="32" height="32"/>
						<g>
							<path class="st1" d="M30.75,20.37l-2.67-7.07V5.92c0-1.54-1.24-2.78-2.78-2.78H6.7c-1.54,0-2.78,1.24-2.78,2.78v7.38l-2.67,7.05
							c-0.05,0.12-0.07,0.25-0.07,0.39l0,5.79c0,0.52,0.42,0.95,0.95,0.95h1.49v1.26c0,0.07,0.06,0.13,0.13,0.13h0.78
							c0.07,0,0.13-0.06,0.13-0.13v-1.26h22.64v1.26c0,0.07,0.06,0.13,0.13,0.13h0.78c0.07,0,0.13-0.06,0.13-0.13v-1.26h1.49
							c0.52,0,0.95-0.43,0.95-0.95v-5.76C30.82,20.62,30.8,20.49,30.75,20.37z M4.91,5.92c0-0.99,0.8-1.79,1.79-1.79h18.6
							c0.99,0,1.79,0.8,1.79,1.79v6.97h-1.73v-2.24c0-0.89-0.72-1.62-1.62-1.62h-4.98c-0.89,0-1.62,0.72-1.62,1.62v2.24h-2.29v-2.24
							c0-0.89-0.72-1.62-1.62-1.62H8.26c-0.89,0-1.62,0.72-1.62,1.62v2.24H4.91V5.92z M24.37,10.65v2.79c0,0.11-0.03,0.22-0.09,0.32
							c-0.12,0.2-0.32,0.31-0.54,0.31h-4.98c-0.22,0-0.43-0.12-0.54-0.31c-0.06-0.1-0.09-0.21-0.09-0.32v-2.79
							c0-0.35,0.28-0.63,0.63-0.63h4.98C24.09,10.02,24.37,10.31,24.37,10.65z M13.87,10.65v2.79c0,0.11-0.03,0.22-0.09,0.32
							c-0.12,0.2-0.32,0.31-0.54,0.31H8.26c-0.22,0-0.43-0.12-0.54-0.31c-0.06-0.1-0.09-0.21-0.09-0.32v-2.79c0-0.35,0.28-0.63,0.63-0.63
							h4.98C13.59,10.02,13.87,10.31,13.87,10.65z M4.76,13.88H6.7c0.19,0.7,0.83,1.19,1.56,1.19h4.98c0.73,0,1.36-0.49,1.56-1.19h2.41
							c0.19,0.7,0.83,1.19,1.56,1.19h4.98c0.73,0,1.36-0.49,1.56-1.19h1.95l2.37,6.26H2.39L4.76,13.88z M29.83,26.48H2.17v-5.35h27.66
							V26.48z"/>
						</g>
					</svg>Sharing Bathroom</p>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-6">
				<div class="BediconGal">
					<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<rect y="0" class="st0" width="32" height="32"/>
						<g>
							<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
							c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
							c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
							<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
							<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
							M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
						</g>
					</svg>Air Conditioning</p>

					<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<rect y="0" class="st0" width="32" height="32"/>
						<g>
							<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
							c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
							c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
							<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
							<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
							M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
						</g>
					</svg>TV LCD 32”</p>

					<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<rect y="0" class="st0" width="32" height="32"/>
						<g>
							<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
							c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
							c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
							<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
							<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
							M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
						</g>
					</svg>Safety Box</p>
				</div>
			</div>
		</div>
	</div>
</div>
</div>


<!-- ==========COL SIX END=== -->
<div class="col-md-6 pad106">
	<div class="tabGallery Tabgallbk2">
		<div id="carouselExampleControls5" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item active">
					<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/13-VILLA-SENSE.jpg" data-caption="5-Bedroom 5 - Guests">
						<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/13-VILLA-SENSE.jpg" alt="Image" class="img-fluid" >
					</a>
				</div>
				<div class="carousel-item">
					<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/14-VILLA-SENSEL.jpg" data-caption="5-Bedroom 5 - Guests">
						<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/14-VILLA-SENSEL.jpg" alt="Image" class="img-fluid">
					</a>
				</div>	
				
			</div>
			<a class="carousel-control-prev" href="#carouselExampleControls5" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleControls5" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>

		<div class="GaHeding">
			<h1>Bedroom 5 - Guest C <span>(Ground Floor)</span></h1>
			<div class="row forbedmin">
				<div class="col-md-6 col-sm-6 col-6">
					<div class="BediconGal">
						<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
							width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
							<style type="text/css">
								.st0{fill:none;}
								.st1{fill:#952524;}
							</style>
							<rect y="0" class="st0" width="32" height="32"/>
							<g>
								<path class="st1" d="M30.75,20.37l-2.67-7.07V5.92c0-1.54-1.24-2.78-2.78-2.78H6.7c-1.54,0-2.78,1.24-2.78,2.78v7.38l-2.67,7.05
								c-0.05,0.12-0.07,0.25-0.07,0.39l0,5.79c0,0.52,0.42,0.95,0.95,0.95h1.49v1.26c0,0.07,0.06,0.13,0.13,0.13h0.78
								c0.07,0,0.13-0.06,0.13-0.13v-1.26h22.64v1.26c0,0.07,0.06,0.13,0.13,0.13h0.78c0.07,0,0.13-0.06,0.13-0.13v-1.26h1.49
								c0.52,0,0.95-0.43,0.95-0.95v-5.76C30.82,20.62,30.8,20.49,30.75,20.37z M4.91,5.92c0-0.99,0.8-1.79,1.79-1.79h18.6
								c0.99,0,1.79,0.8,1.79,1.79v6.97h-1.73v-2.24c0-0.89-0.72-1.62-1.62-1.62h-4.98c-0.89,0-1.62,0.72-1.62,1.62v2.24h-2.29v-2.24
								c0-0.89-0.72-1.62-1.62-1.62H8.26c-0.89,0-1.62,0.72-1.62,1.62v2.24H4.91V5.92z M24.37,10.65v2.79c0,0.11-0.03,0.22-0.09,0.32
								c-0.12,0.2-0.32,0.31-0.54,0.31h-4.98c-0.22,0-0.43-0.12-0.54-0.31c-0.06-0.1-0.09-0.21-0.09-0.32v-2.79
								c0-0.35,0.28-0.63,0.63-0.63h4.98C24.09,10.02,24.37,10.31,24.37,10.65z M13.87,10.65v2.79c0,0.11-0.03,0.22-0.09,0.32
								c-0.12,0.2-0.32,0.31-0.54,0.31H8.26c-0.22,0-0.43-0.12-0.54-0.31c-0.06-0.1-0.09-0.21-0.09-0.32v-2.79c0-0.35,0.28-0.63,0.63-0.63
								h4.98C13.59,10.02,13.87,10.31,13.87,10.65z M4.76,13.88H6.7c0.19,0.7,0.83,1.19,1.56,1.19h4.98c0.73,0,1.36-0.49,1.56-1.19h2.41
								c0.19,0.7,0.83,1.19,1.56,1.19h4.98c0.73,0,1.36-0.49,1.56-1.19h1.95l2.37,6.26H2.39L4.76,13.88z M29.83,26.48H2.17v-5.35h27.66
								V26.48z"/>
							</g>
						</svg>2 Beds 1x2Mt</p>
						<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
							width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
							<style type="text/css">
								.st0{fill:none;}
								.st1{fill:#952524;}
							</style>
							<rect y="0" class="st0" width="32" height="32"/>
							<g>
								<path class="st1" d="M30.75,20.37l-2.67-7.07V5.92c0-1.54-1.24-2.78-2.78-2.78H6.7c-1.54,0-2.78,1.24-2.78,2.78v7.38l-2.67,7.05
								c-0.05,0.12-0.07,0.25-0.07,0.39l0,5.79c0,0.52,0.42,0.95,0.95,0.95h1.49v1.26c0,0.07,0.06,0.13,0.13,0.13h0.78
								c0.07,0,0.13-0.06,0.13-0.13v-1.26h22.64v1.26c0,0.07,0.06,0.13,0.13,0.13h0.78c0.07,0,0.13-0.06,0.13-0.13v-1.26h1.49
								c0.52,0,0.95-0.43,0.95-0.95v-5.76C30.82,20.62,30.8,20.49,30.75,20.37z M4.91,5.92c0-0.99,0.8-1.79,1.79-1.79h18.6
								c0.99,0,1.79,0.8,1.79,1.79v6.97h-1.73v-2.24c0-0.89-0.72-1.62-1.62-1.62h-4.98c-0.89,0-1.62,0.72-1.62,1.62v2.24h-2.29v-2.24
								c0-0.89-0.72-1.62-1.62-1.62H8.26c-0.89,0-1.62,0.72-1.62,1.62v2.24H4.91V5.92z M24.37,10.65v2.79c0,0.11-0.03,0.22-0.09,0.32
								c-0.12,0.2-0.32,0.31-0.54,0.31h-4.98c-0.22,0-0.43-0.12-0.54-0.31c-0.06-0.1-0.09-0.21-0.09-0.32v-2.79
								c0-0.35,0.28-0.63,0.63-0.63h4.98C24.09,10.02,24.37,10.31,24.37,10.65z M13.87,10.65v2.79c0,0.11-0.03,0.22-0.09,0.32
								c-0.12,0.2-0.32,0.31-0.54,0.31H8.26c-0.22,0-0.43-0.12-0.54-0.31c-0.06-0.1-0.09-0.21-0.09-0.32v-2.79c0-0.35,0.28-0.63,0.63-0.63
								h4.98C13.59,10.02,13.87,10.31,13.87,10.65z M4.76,13.88H6.7c0.19,0.7,0.83,1.19,1.56,1.19h4.98c0.73,0,1.36-0.49,1.56-1.19h2.41
								c0.19,0.7,0.83,1.19,1.56,1.19h4.98c0.73,0,1.36-0.49,1.56-1.19h1.95l2.37,6.26H2.39L4.76,13.88z M29.83,26.48H2.17v-5.35h27.66
								V26.48z"/>
							</g>
						</svg>Sharing Bathroom</p>
					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-6">
					<div class="BediconGal">
						<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
							width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
							<style type="text/css">
								.st0{fill:none;}
								.st1{fill:#952524;}
							</style>
							<rect y="0" class="st0" width="32" height="32"/>
							<g>
								<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
								c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
								c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
								<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
								<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
								M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
							</g>
						</svg>Air Conditioning</p>

						<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
							width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
							<style type="text/css">
								.st0{fill:none;}
								.st1{fill:#952524;}
							</style>
							<rect y="0" class="st0" width="32" height="32"/>
							<g>
								<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
								c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
								c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
								<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
								<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
								M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
							</g>
						</svg>TV LCD 32”</p>

						<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
							width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
							<style type="text/css">
								.st0{fill:none;}
								.st1{fill:#952524;}
							</style>
							<rect y="0" class="st0" width="32" height="32"/>
							<g>
								<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
								c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
								c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
								<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
								<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
								M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
							</g>
						</svg>Safety Box</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ==========COL SIX END=== -->

<div class="col-md-6 pad106">
	<div class="tabGallery Tabgallbk2">
		<div id="carouselExampleControls6" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item active">
					<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/15-VILLA-SENSEL.jpg" data-caption="5-Bedroom 5 - Guests">
						<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/15-VILLA-SENSEL.jpg" alt="Image" class="img-fluid" >
					</a>
				</div>
				
			</div>
			<a class="carousel-control-prev" href="#carouselExampleControls6" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleControls6" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>

		<div class="GaHeding">
			<h1>Bedroom 6 - Bunk Bed <span>(First Floor)</span></h1>
			<div class="row forbedmin">
				<div class="col-md-6 col-sm-6 col-6">
					<div class="BediconGal">
						<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
							width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
							<style type="text/css">
								.st0{fill:none;}
								.st1{fill:#952524;}
							</style>
							<rect y="0" class="st0" width="32" height="32"/>
							<g>
								<path class="st1" d="M30.75,20.37l-2.67-7.07V5.92c0-1.54-1.24-2.78-2.78-2.78H6.7c-1.54,0-2.78,1.24-2.78,2.78v7.38l-2.67,7.05
								c-0.05,0.12-0.07,0.25-0.07,0.39l0,5.79c0,0.52,0.42,0.95,0.95,0.95h1.49v1.26c0,0.07,0.06,0.13,0.13,0.13h0.78
								c0.07,0,0.13-0.06,0.13-0.13v-1.26h22.64v1.26c0,0.07,0.06,0.13,0.13,0.13h0.78c0.07,0,0.13-0.06,0.13-0.13v-1.26h1.49
								c0.52,0,0.95-0.43,0.95-0.95v-5.76C30.82,20.62,30.8,20.49,30.75,20.37z M4.91,5.92c0-0.99,0.8-1.79,1.79-1.79h18.6
								c0.99,0,1.79,0.8,1.79,1.79v6.97h-1.73v-2.24c0-0.89-0.72-1.62-1.62-1.62h-4.98c-0.89,0-1.62,0.72-1.62,1.62v2.24h-2.29v-2.24
								c0-0.89-0.72-1.62-1.62-1.62H8.26c-0.89,0-1.62,0.72-1.62,1.62v2.24H4.91V5.92z M24.37,10.65v2.79c0,0.11-0.03,0.22-0.09,0.32
								c-0.12,0.2-0.32,0.31-0.54,0.31h-4.98c-0.22,0-0.43-0.12-0.54-0.31c-0.06-0.1-0.09-0.21-0.09-0.32v-2.79
								c0-0.35,0.28-0.63,0.63-0.63h4.98C24.09,10.02,24.37,10.31,24.37,10.65z M13.87,10.65v2.79c0,0.11-0.03,0.22-0.09,0.32
								c-0.12,0.2-0.32,0.31-0.54,0.31H8.26c-0.22,0-0.43-0.12-0.54-0.31c-0.06-0.1-0.09-0.21-0.09-0.32v-2.79c0-0.35,0.28-0.63,0.63-0.63
								h4.98C13.59,10.02,13.87,10.31,13.87,10.65z M4.76,13.88H6.7c0.19,0.7,0.83,1.19,1.56,1.19h4.98c0.73,0,1.36-0.49,1.56-1.19h2.41
								c0.19,0.7,0.83,1.19,1.56,1.19h4.98c0.73,0,1.36-0.49,1.56-1.19h1.95l2.37,6.26H2.39L4.76,13.88z M29.83,26.48H2.17v-5.35h27.66
								V26.48z"/>
							</g>
						</svg>2 Beds 0,9x2Mt</p>
						<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
							width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
							<style type="text/css">
								.st0{fill:none;}
								.st1{fill:#952524;}
							</style>
							<rect y="0" class="st0" width="32" height="32"/>
							<g>
								<path class="st1" d="M30.75,20.37l-2.67-7.07V5.92c0-1.54-1.24-2.78-2.78-2.78H6.7c-1.54,0-2.78,1.24-2.78,2.78v7.38l-2.67,7.05
								c-0.05,0.12-0.07,0.25-0.07,0.39l0,5.79c0,0.52,0.42,0.95,0.95,0.95h1.49v1.26c0,0.07,0.06,0.13,0.13,0.13h0.78
								c0.07,0,0.13-0.06,0.13-0.13v-1.26h22.64v1.26c0,0.07,0.06,0.13,0.13,0.13h0.78c0.07,0,0.13-0.06,0.13-0.13v-1.26h1.49
								c0.52,0,0.95-0.43,0.95-0.95v-5.76C30.82,20.62,30.8,20.49,30.75,20.37z M4.91,5.92c0-0.99,0.8-1.79,1.79-1.79h18.6
								c0.99,0,1.79,0.8,1.79,1.79v6.97h-1.73v-2.24c0-0.89-0.72-1.62-1.62-1.62h-4.98c-0.89,0-1.62,0.72-1.62,1.62v2.24h-2.29v-2.24
								c0-0.89-0.72-1.62-1.62-1.62H8.26c-0.89,0-1.62,0.72-1.62,1.62v2.24H4.91V5.92z M24.37,10.65v2.79c0,0.11-0.03,0.22-0.09,0.32
								c-0.12,0.2-0.32,0.31-0.54,0.31h-4.98c-0.22,0-0.43-0.12-0.54-0.31c-0.06-0.1-0.09-0.21-0.09-0.32v-2.79
								c0-0.35,0.28-0.63,0.63-0.63h4.98C24.09,10.02,24.37,10.31,24.37,10.65z M13.87,10.65v2.79c0,0.11-0.03,0.22-0.09,0.32
								c-0.12,0.2-0.32,0.31-0.54,0.31H8.26c-0.22,0-0.43-0.12-0.54-0.31c-0.06-0.1-0.09-0.21-0.09-0.32v-2.79c0-0.35,0.28-0.63,0.63-0.63
								h4.98C13.59,10.02,13.87,10.31,13.87,10.65z M4.76,13.88H6.7c0.19,0.7,0.83,1.19,1.56,1.19h4.98c0.73,0,1.36-0.49,1.56-1.19h2.41
								c0.19,0.7,0.83,1.19,1.56,1.19h4.98c0.73,0,1.36-0.49,1.56-1.19h1.95l2.37,6.26H2.39L4.76,13.88z M29.83,26.48H2.17v-5.35h27.66
								V26.48z"/>
							</g>
						</svg>Sharing Bathroom</p>
					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-6">
					<div class="BediconGal">
						<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
							width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
							<style type="text/css">
								.st0{fill:none;}
								.st1{fill:#952524;}
							</style>
							<rect y="0" class="st0" width="32" height="32"/>
							<g>
								<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
								c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
								c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
								<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
								<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
								M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
							</g>
						</svg>Air Conditioning</p>

						<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
							width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
							<style type="text/css">
								.st0{fill:none;}
								.st1{fill:#952524;}
							</style>
							<rect y="0" class="st0" width="32" height="32"/>
							<g>
								<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
								c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
								c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
								<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
								<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
								M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
							</g>
						</svg>Safety Box</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ==========COL SIX END=== -->

</div>
<div class="GalPAraT">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-12 pad106">
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse.</p>
		</div>
	</div>

</div>
</div>
</div>
</div>
</div>

<!-- =======GAllery END========= -->
<div class="OutddorDiv GAllBrdrBottom">
	<div class="row">
		<div class="col-md-2 col-sm-2 col-12 OutCenter2">
<p class="OutImg2">
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
<style type="text/css">
	.st0{fill:none;}
	.st1{fill:#952524;}
</style>
<g>
	<rect class="st0" width="32" height="32"/>
</g>
<g>
	<path class="st1" d="M22,10c-1.8-1.8-4.2-2.7-6.7-2.5c-4.1,0.3-7.4,3.7-7.8,7.8C7.3,17.8,8.2,20.2,10,22c1.6,1.6,3.7,2.5,6,2.5
	c0.2,0,0.5,0,0.7,0c4.1-0.3,7.4-3.7,7.8-7.8C24.7,14.2,23.8,11.8,22,10 M21.2,21.2c-1.5,1.5-3.6,2.3-5.8,2.1
	C11.9,23,9,20.1,8.7,16.6c-0.2-2.1,0.6-4.3,2.1-5.8C12.2,9.4,14,8.7,16,8.7c0.2,0,0.4,0,0.6,0c3.5,0.3,6.4,3.2,6.7,6.7
	C23.5,17.5,22.7,19.7,21.2,21.2"/>
	<path class="st1" d="M5.9,16c0-0.3-0.3-0.6-0.6-0.6H1.1c-0.3,0-0.6,0.3-0.6,0.6c0,0.3,0.3,0.6,0.6,0.6h4.2
	C5.6,16.6,5.9,16.3,5.9,16"/>
	<path class="st1" d="M30.9,15.4h-4.2c-0.3,0-0.6,0.3-0.6,0.6c0,0.3,0.3,0.6,0.6,0.6h4.2c0.3,0,0.6-0.3,0.6-0.6
	C31.5,15.7,31.2,15.4,30.9,15.4"/>
	<path class="st1" d="M23.5,9C23.7,9,23.8,9,24,8.9l3-3c0.1-0.1,0.2-0.3,0.2-0.4c0-0.2-0.1-0.3-0.2-0.4c-0.2-0.2-0.6-0.2-0.8,0l-3,3
	C23,8.2,23,8.3,23,8.5c0,0.2,0.1,0.3,0.2,0.4C23.2,9,23.4,9,23.5,9"/>
	<path class="st1" d="M8,23.1l-3,3c-0.1,0.1-0.2,0.3-0.2,0.4c0,0.2,0.1,0.3,0.2,0.4c0.1,0.1,0.3,0.2,0.4,0.2c0.2,0,0.3-0.1,0.4-0.2
	l3-3C9,23.8,9,23.7,9,23.5c0-0.2-0.1-0.3-0.2-0.4C8.7,22.9,8.3,22.9,8,23.1"/>
	<path class="st1" d="M16,5.9c0.3,0,0.6-0.3,0.6-0.6V1.1c0-0.3-0.3-0.6-0.6-0.6c-0.3,0-0.6,0.3-0.6,0.6v4.2
	C15.4,5.6,15.7,5.9,16,5.9"/>
	<path class="st1" d="M16,26.1c-0.3,0-0.6,0.3-0.6,0.6v4.2c0,0.3,0.3,0.6,0.6,0.6c0.3,0,0.6-0.3,0.6-0.6v-4.2
	C16.6,26.4,16.3,26.1,16,26.1"/>
	<path class="st1" d="M24,23.1c-0.2-0.2-0.6-0.2-0.8,0C23,23.2,23,23.4,23,23.5c0,0.2,0.1,0.3,0.2,0.4l3,3c0.1,0.1,0.3,0.2,0.4,0.2
	s0.3-0.1,0.4-0.2c0.1-0.1,0.2-0.3,0.2-0.4c0-0.2-0.1-0.3-0.2-0.4L24,23.1z"/>
	<path class="st1" d="M8,8.9C8.2,9,8.3,9,8.5,9C8.6,9,8.8,9,8.9,8.9C9,8.8,9,8.6,9,8.5C9,8.3,9,8.2,8.9,8l-3-3C5.6,4.8,5.3,4.8,5,5
	C4.9,5.2,4.9,5.3,4.9,5.5c0,0.2,0.1,0.3,0.2,0.4L8,8.9z"/>
</g>
</svg>Outdoor</p>
</div>

<div class="col-md-10">
	<div class="ColGalIN">
		<div class="row">

			<div class="col-md-6 pad106">
				<div class="tabGallery Tabgallbk2">
							<div id="carouselExampleControls7" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item active">
					<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/17-VILLA-SENSE.jpg" data-caption="Swimming">
						<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/17-VILLA-SENSE.jpg" alt="Image" class="img-fluid" >
					</a>
				</div>

				<div class="carousel-item">
					<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/18-VILLA-SENSEL.jpg" data-caption="Swimming">
						<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/18-VILLA-SENSEL.jpg" alt="Image" class="img-fluid" >
					</a>
				</div>

				<div class="carousel-item">
					<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/19-VILLA-SENSEL.jpg" data-caption="Swimming">
						<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/19-VILLA-SENSEL.jpg" alt="Image" class="img-fluid" >
					</a>
				</div>

				<div class="carousel-item">
					<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/20-VILLA-SENSEL.jpg" data-caption="Swimming">
						<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/20-VILLA-SENSEL.jpg" alt="Image" class="img-fluid" >
					</a>
				</div>
				
			</div>
			<a class="carousel-control-prev" href="#carouselExampleControls7" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleControls7" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>

					<div class="GaHeding">
						<h1>Swimming Pool</h1>
						<div class="row forbedmin">
							<div class="col-md-6">
								<div class="BediconGal">
									<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
										<style type="text/css">
											.st0{fill:none;}
											.st1{fill:#952524;}
										</style>
										<rect y="0" class="st0" width="32" height="32"/>
										<g>
											<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
											c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
											c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
											<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
											<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
											M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
										</g>
									</svg>2 Swimming Pools</p>

									<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
										<style type="text/css">
											.st0{fill:none;}
											.st1{fill:#952524;}
										</style>
										<rect y="0" class="st0" width="32" height="32"/>
										<g>
											<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
											c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
											c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
											<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
											<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
											M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
										</g>
									</svg>2,3x8 Mt</p>

									<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
										<style type="text/css">
											.st0{fill:none;}
											.st1{fill:#952524;}
										</style>
										<rect y="0" class="st0" width="32" height="32"/>
										<g>
											<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
											c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
											c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
											<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
											<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
											M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
										</g>
									</svg>0,4 to 1,8 Mt</p>

									<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
										<style type="text/css">
											.st0{fill:none;}
											.st1{fill:#952524;}
										</style>
										<rect y="0" class="st0" width="32" height="32"/>
										<g>
											<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
											c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
											c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
											<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
											<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
											M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
										</g>
									</svg>Built-in Seats</p>
								</div>
							</div>



							<div class="col-md-6">
								<div class="BediconGal">
									<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
										<style type="text/css">
											.st0{fill:none;}
											.st1{fill:#952524;}
										</style>
										<rect y="0" class="st0" width="32" height="32"/>
										<g>
											<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
											c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
											c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
											<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
											<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
											M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
										</g>
									</svg>Shower</p>

									<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
										<style type="text/css">
											.st0{fill:none;}
											.st1{fill:#952524;}
										</style>
										<rect y="0" class="st0" width="32" height="32"/>
										<g>
											<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
											c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
											c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
											<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
											<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
											M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
										</g>
									</svg>Sunbeds</p>

									<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
										<style type="text/css">
											.st0{fill:none;}
											.st1{fill:#952524;}
										</style>
										<rect y="0" class="st0" width="32" height="32"/>
										<g>
											<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
											c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
											c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
											<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
											<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
											M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
										</g>
									</svg>Pool Towels</p>

								</div>
							</div>


						</div>
					</div>
				</div>
			</div>

			<!-- ==========COL SIX END=== -->


			<div class="col-md-6 pad106">
				<div class="tabGallery Tabgallbk2">
							<div id="carouselExampleControls8" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item active">
					<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/21-VILLA-SENSEL.jpg" data-caption="Gazebo">
						<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/21-VILLA-SENSEL.jpg" alt="Image" class="img-fluid" >
					</a>
				</div>
				
			</div>
			<a class="carousel-control-prev" href="#carouselExampleControls8" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleControls8" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>

					<div class="GaHeding">
						<h1>Gazebo</h1>
						<div class="row forbedmin">
							<div class="col-md-6">
								<div class="BediconGal">
									<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
										<style type="text/css">
											.st0{fill:none;}
											.st1{fill:#952524;}
										</style>
										<rect y="0" class="st0" width="32" height="32"/>
										<g>
											<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
											c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
											c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
											<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
											<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
											M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
										</g>
									</svg>Sofa</p>

									<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
										<style type="text/css">
											.st0{fill:none;}
											.st1{fill:#952524;}
										</style>
										<rect y="0" class="st0" width="32" height="32"/>
										<g>
											<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
											c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
											c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
											<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
											<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
											M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
										</g>
									</svg>Coffee Table</p>


								</div>
							</div>



							<div class="col-md-6">
								<div class="BediconGal">
									<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
										<style type="text/css">
											.st0{fill:none;}
											.st1{fill:#952524;}
										</style>
										<rect y="0" class="st0" width="32" height="32"/>
										<g>
											<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
											c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
											c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
											<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
											<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
											M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
										</g>
									</svg>Ceiling Fan</p>

									<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
										<style type="text/css">
											.st0{fill:none;}
											.st1{fill:#952524;}
										</style>
										<rect y="0" class="st0" width="32" height="32"/>
										<g>
											<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
											c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
											c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
											<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
											<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
											M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
										</g>
									</svg>Electric Plug</p>

								</div>
							</div>


						</div>
					</div>
				</div>
			</div>

			<!-- ==========COL SIX END=== -->

			<!--  ===========BOX END===== -->

		</div>

		<div class="GalPAraT">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-12 pad106">
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse.</p>
				</div>
			</div>
		</div>

	</div>
</div>

</div>

</div>
<!-- ======OUTDOOR END===== -->

<div class="OutddorDiv GAllBrdrBottom">
	<div class="row">
		<div class="col-md-2 col-sm-2 col-12 OutCenter2">
<p class="OutImg2">
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
<style type="text/css">
	.st0{fill:none;}
	.st1{fill:#952524;}
</style>
<g>
	<rect class="st0" width="32" height="32"/>
</g>
<path class="st1" d="M31.8,14L16,0.8L0.2,14C0.1,14.1,0,14.3,0,14.4c0,0.2,0,0.3,0.1,0.4c0.2,0.2,0.6,0.3,0.8,0.1l2.9-2.4v17.8
c0,0.5,0.4,0.9,0.9,0.9h22.6c0.5,0,0.9-0.4,0.9-0.9V12.5l0.1,0l2.8,2.4c0.1,0.1,0.3,0.2,0.4,0.1c0.2,0,0.3-0.1,0.4-0.2
c0.1-0.1,0.2-0.3,0.1-0.4C32,14.3,31.9,14.1,31.8,14z M27,30H5V11.5l0,0l11-9.2l0,0L27,11.5V30z"/>
</svg>Indoor</p>
</div>


<div class="col-md-10">
	<div class="ColGalIN">
		<div class="row">


			<div class="col-md-6 pad106">
				<div class="tabGallery Tabgallbk2">
						<div id="carouselExampleControls9" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item active">
					<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/22-VILLA-SENSEL.jpg" data-caption="Living Room">
						<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/22-VILLA-SENSEL.jpg" alt="Image" class="img-fluid" >
					</a>
				</div>
				<div class="carousel-item">
					<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/23-VILLA-SENSEL.jpg" data-caption="Living Room">
						<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/23-VILLA-SENSEL.jpg" alt="Image" class="img-fluid" >
					</a>
				</div>
				
			</div>
			<a class="carousel-control-prev" href="#carouselExampleControls9" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleControls9" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>

					<div class="GaHeding">
						<h1>Living Room</h1>
						<div class="row forbedmin">
							<div class="col-md-6">
								<div class="BediconGal">

									<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
										<style type="text/css">
											.st0{fill:none;}
											.st1{fill:#952524;}
										</style>
										<rect y="0" class="st0" width="32" height="32"/>
										<g>
											<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
											c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
											c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
											<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
											<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
											M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
										</g>
									</svg>Air Conditioning</p>

									<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
										<style type="text/css">
											.st0{fill:none;}
											.st1{fill:#952524;}
										</style>
										<rect y="0" class="st0" width="32" height="32"/>
										<g>
											<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
											c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
											c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
											<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
											<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
											M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
										</g>
									</svg>TV LCD 44”</p>


									<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
										<style type="text/css">
											.st0{fill:none;}
											.st1{fill:#952524;}
										</style>
										<rect y="0" class="st0" width="32" height="32"/>
										<g>
											<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
											c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
											c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
											<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
											<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
											M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
										</g>
									</svg>DVD Player</p>
								</div>
							</div>
							<div class="col-md-6">
								<div class="BediconGal">
									<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
										<style type="text/css">
											.st0{fill:none;}
											.st1{fill:#952524;}
										</style>
										<rect y="0" class="st0" width="32" height="32"/>
										<g>
											<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
											c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
											c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
											<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
											<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
											M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
										</g>
									</svg>Ceiling Fan</p>

									<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
										<style type="text/css">
											.st0{fill:none;}
											.st1{fill:#952524;}
										</style>
										<rect y="0" class="st0" width="32" height="32"/>
										<g>
											<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
											c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
											c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
											<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
											<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
											M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
										</g>
									</svg>Lounge Sofa</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ==========COL SIX END=== -->

			<div class="col-md-6 pad106">
				<div class="tabGallery Tabgallbk2">
						<div id="carouselExampleControls10" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item active">
					<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/24-VILLA-SENSEL.jpg" data-caption="Dining">
						<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/24-VILLA-SENSEL.jpg" alt="Image" class="img-fluid" >
					</a>
				</div>
			
				
			</div>
			<a class="carousel-control-prev" href="#carouselExampleControls10" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleControls10" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>

					<div class="GaHeding">
						<h1>Dining</h1>
						<div class="row forbedmin">
							<div class="col-md-6">
								<div class="BediconGal">
									<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
										<style type="text/css">
											.st0{fill:none;}
											.st1{fill:#952524;}
										</style>
										<rect y="0" class="st0" width="32" height="32"/>
										<g>
											<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
											c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
											c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
											<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
											<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
											M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
										</g>
									</svg>Equipped Kitchen</p>
									<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
										<style type="text/css">
											.st0{fill:none;}
											.st1{fill:#952524;}
										</style>
										<rect y="0" class="st0" width="32" height="32"/>
										<g>
											<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
											c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
											c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
											<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
											<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
											M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
										</g>
									</svg>Kitchen Amenities</p>
								</div>
							</div>
							<div class="col-md-6">
								<div class="BediconGal">
									<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
										<style type="text/css">
											.st0{fill:none;}
											.st1{fill:#952524;}
										</style>
										<rect y="0" class="st0" width="32" height="32"/>
										<g>
											<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
											c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
											c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
											<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
											<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
											M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
										</g>
									</svg>Ceiling Fan</p>
									<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
										<style type="text/css">
											.st0{fill:none;}
											.st1{fill:#952524;}
										</style>
										<rect y="0" class="st0" width="32" height="32"/>
										<g>
											<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
											c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
											c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
											<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
											<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
											M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
										</g>
									</svg>Fresh Water</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- ==========COL SIX END=== -->
			<!--   =====BOX END========== -->
		</div>

		<div class="GalPAraT">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-12 pad106">
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse.</p>
				</div>
			</div>
		</div>

	</div>
</div>
</div>
</div>
<!-- ======INDOOR END===== -->


<div class="OutddorDiv">
	<div class="row">
		<div class="col-md-2 col-sm-2 col-12 OutCenter2">
			<p class="OutImg2"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
				width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
				<style type="text/css">
					.st0{fill:none;}
					.st1{fill:#952524;}
				</style>
				<g>
					<rect class="st0" width="32" height="32"/>
				</g>
				<g>
					<path class="st1" d="M26.7,0.5H5.3c-2.7,0-4.8,2.2-4.8,4.8v21.3c0,2.7,2.2,4.8,4.8,4.8h21.3c2.7,0,4.8-2.2,4.8-4.8V5.3
					C31.5,2.7,29.3,0.5,26.7,0.5 M30.3,5.3v21.3c0,2-1.7,3.7-3.7,3.7H5.3c-2,0-3.7-1.7-3.7-3.7V5.3c0-2,1.7-3.7,3.7-3.7h21.3
					C28.7,1.7,30.3,3.3,30.3,5.3"/>
					<path class="st1" d="M23.1,15.4h-6.6V8.9c0-0.3-0.3-0.6-0.6-0.6c-0.3,0-0.6,0.3-0.6,0.6v6.6H8.9c-0.3,0-0.6,0.3-0.6,0.6
					s0.3,0.6,0.6,0.6h6.6v6.6c0,0.3,0.3,0.6,0.6,0.6c0.3,0,0.6-0.3,0.6-0.6v-6.6h6.6c0.3,0,0.6-0.3,0.6-0.6S23.4,15.4,23.1,15.4"/>
				</g>
			</svg>
		Others</p>
	</div>


	<div class="col-md-10">
		<div class="ColGalIN">
			<div class="row">
				<div class="col-md-6 pad106">
					<div class="tabGallery Tabgallbk2">
								<div id="carouselExampleControls11" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item active">
					<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/25-VILLA-SENSEL.jpg" data-caption="Extras">
						<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/25-VILLA-SENSEL.jpg" alt="Image" class="img-fluid" >
					</a>
				</div>
					<div class="carousel-item ">
					<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/26-VILLA-SENSEL.jpg" data-caption="Extras">
						<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/26-VILLA-SENSEL.jpg" alt="Image" class="img-fluid" >
					</a>
				</div>
			
				
			</div>
			<a class="carousel-control-prev" href="#carouselExampleControls11" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleControls11" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>

						<div class="GaHeding">
							<h1>Extras</h1>
							<div class="row forbedmin">
								<div class="col-md-6">
									<div class="BediconGal">
										<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
											width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
											<style type="text/css">
												.st0{fill:none;}
												.st1{fill:#952524;}
											</style>
											<rect y="0" class="st0" width="32" height="32"/>
											<g>
												<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
												c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
												c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
												<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
												<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
												M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
											</g>
										</svg>Bath Amenities</p>

									</div>
								</div>
								<div class="col-md-6">
									<div class="BediconGal">
										<p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
											width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
											<style type="text/css">
												.st0{fill:none;}
												.st1{fill:#952524;}
											</style>
											<rect y="0" class="st0" width="32" height="32"/>
											<g>
												<path class="st1" d="M23.43,1.09H8.57c-0.84,0-1.52,0.68-1.52,1.52v26.78c0,0.84,0.68,1.52,1.52,1.52h14.86
												c0.84,0,1.52-0.68,1.52-1.52V2.61C24.94,1.77,24.27,1.09,23.43,1.09z M23.43,29.94H8.57c-0.31,0-0.55-0.25-0.55-0.55V2.61
												c0-0.31,0.25-0.55,0.55-0.55h14.86c0.31,0,0.55,0.25,0.55,0.55v26.78C23.98,29.7,23.74,29.94,23.43,29.94z"/>
												<rect x="14" y="5.26" class="st1" width="3.99" height="0.5"/>
												<path class="st1" d="M16,24.06c-1.13,0-2.04,0.92-2.04,2.04s0.92,2.04,2.04,2.04s2.04-0.92,2.04-2.04S17.13,24.06,16,24.06z
												M16,27.64c-0.85,0-1.54-0.69-1.54-1.54s0.69-1.54,1.54-1.54c0.85,0,1.54,0.69,1.54,1.54S16.85,27.64,16,27.64z"/>
											</g>
										</svg>Floating Breakfast</p>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- ==========COL SIX END=== -->
				<!--   =====BOX END========== -->
			</div>

			<div class="GalPAraT">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-12 pad106">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse.</p>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

</div>
<!-- ======EXTRA END===== -->
</div>
</div>
</div>

<!-- ==========LOCATION START========= -->

<!-- Accordion card -->
<!-- =========FEATURES END========== -->


<!-- Accordion card -->
<div class="card carddesign" id="FplanClick1">
	<!-- Card header -->
	<div class="card-header" role="tab" id="headingEight">
		<a data-toggle="collapse" data-parent="#accordionEx" href="#collapseEight" aria-expanded="true" aria-controls="collapseEight" class="iarrowclick">
<h5 class="mb-0"> 
	<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
<style type="text/css">
	.st0{fill:none;}
	.st1{fill:#952524;}
</style>
<g>
	<rect class="st0" width="32" height="32"/>
</g>
<g>
	<path class="st1" d="M31.5,5.1c0-0.3,0-0.6-0.1-0.8c-0.1-0.6-0.4-1.2-0.8-1.7c0,0-0.1-0.1-0.1-0.1c0,0-0.1-0.1-0.1-0.1
	c-0.2-0.3-0.4-0.5-0.7-0.7c0,0-0.1-0.1-0.1-0.1c0,0-0.1-0.1-0.1-0.1c-0.5-0.4-1.1-0.6-1.7-0.8c-0.2-0.1-0.4-0.1-0.7-0.1
	c-0.2,0-0.3,0-0.5,0H5.3c-0.2,0-0.3,0-0.5,0c-0.2,0-0.5,0-0.7,0.1C3.6,0.8,3,1.1,2.6,1.4c0,0-0.1,0.1-0.1,0.1c0,0-0.1,0.1-0.1,0.1
	C2,1.8,1.8,2.1,1.6,2.3c0,0-0.1,0.1-0.1,0.1c0,0-0.1,0.1-0.1,0.1C1,3.1,0.8,3.7,0.6,4.3C0.6,4.6,0.5,4.8,0.5,5.1c0,0.1,0,0.1,0,0.2
	v21.3c0,0.1,0,0.1,0,0.2c0,0.3,0,0.6,0.1,0.8c0.1,0.6,0.4,1.2,0.8,1.7c0,0,0.1,0.1,0.1,0.1c0,0,0.1,0.1,0.1,0.1
	c0.2,0.3,0.5,0.5,0.8,0.8c0,0,0.1,0.1,0.1,0.1c0,0,0.1,0.1,0.1,0.1c0.5,0.4,1.1,0.6,1.8,0.8c0.3,0.1,0.6,0.1,1,0.1h0.8h0.1h6.8h0.1
	h13.5c0.3,0,0.7,0,1-0.1c0.6-0.1,1.2-0.4,1.8-0.8c0,0,0.1-0.1,0.1-0.1c0,0,0.1-0.1,0.1-0.1c0.3-0.2,0.5-0.5,0.8-0.8
	c0,0,0.1-0.1,0.1-0.1c0,0,0.1-0.1,0.1-0.1c0.4-0.5,0.6-1.1,0.8-1.7c0.1-0.3,0.1-0.6,0.1-0.8c0-0.1,0-0.1,0-0.2V5.3
	C31.5,5.3,31.5,5.2,31.5,5.1z M30.3,26.7c0,2-1.7,3.7-3.7,3.7H5.3c-2,0-3.7-1.7-3.7-3.7V12.3h6.9v3.6h1.2V7.5H8.5v3.6H1.7V5.3
	c0-2,1.7-3.7,3.7-3.7h11.1v10.6H27v-1.2h-9.4V1.7h9c2,0,3.7,1.7,3.7,3.7v15.9h-8.4v1.2h8.4V26.7z"/>
</g>
</svg> Floor Plan <i class="fa fa-angle-up rotate-icon"></i></h5>
</a>
</div>
<!-- Card body -->
<div id="collapseEight" class="collapse show" role="tabpanel" aria-labelledby="headingEight" style="">
	<div class="card-body">
		<div class="Mapsection">
			<div class="MApFloor2">
				<div class="row">
					<div class="col-md-12">
						<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/01AB-VILLA-SENSEL-FLOOR.jpg" data-caption="Floor Plans ">
							<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/01AB-VILLA-SENSEL-FLOOR.jpg" alt="Image" class="img-fluid">
						</a>
					</div>
				</div>
			</div>

			<div class="MApFloor2">
				<div class="row">
					<div class="col-md-12">
						<a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/01AB-VILLA-SENSEL-Ground-Floor-FLOOR-PLAN-NO-LOGO.jpg" data-caption="Floor Plans ">
							<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/01AB-VILLA-SENSEL-Ground-Floor-FLOOR-PLAN-NO-LOGO.jpg" alt="Image" class="img-fluid">
						</a>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
</div>
<!-- Accordion card -->


<!-- Accordion card -->
<div class="card carddesign" id="LocClick1">
	<!-- Card header -->
	<div class="card-header" role="tab" id="headingThree">
		<a data-toggle="collapse" data-parent="#accordionEx" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree" class="iarrowclick">
<h5 class="mb-0"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
<style type="text/css">
	.st0{fill:none;}
	.st1{fill:#952524;}
</style>
<g>
	<rect class="st0" width="32" height="32"/>
</g>
<g>
	<path class="st1" d="M16,7c-2.6,0-4.7,2.1-4.7,4.7c0,2.6,2.1,4.7,4.7,4.7c2.6,0,4.7-2.1,4.7-4.7C20.7,9.1,18.6,7,16,7 M19.7,11.7
	c0,2-1.7,3.7-3.7,3.7c-2,0-3.7-1.7-3.7-3.7C12.3,9.7,14,8,16,8C18,8,19.7,9.7,19.7,11.7"/>
	<path class="st1" d="M24.3,3.9C20.9,0.4,16,0.5,16,0.5c-0.1,0-4.9-0.1-8.3,3.4c-2.2,2.3-3.2,5.4-3,9.5c0,0.6,0,6.6,10.8,17.9
	c0,0,0.2,0.2,0.4,0.2c0.1,0,0.2,0,0.4-0.2C27.2,20,27.2,14,27.2,13.4C27.4,9.4,26.4,6.2,24.3,3.9 M26.2,13.4
	c0,0.1,0.1,5.9-10.2,16.9C5.7,19.3,5.8,13.5,5.8,13.4l0-0.1C5.6,9.6,6.5,6.7,8.5,4.6c3-3.1,7.4-3.1,7.6-3.1c0.8,0,4.8,0.2,7.5,3.1
	C25.5,6.7,26.4,9.6,26.2,13.4L26.2,13.4z"/>
</g>
</svg> Location <i class="fa fa-angle-up rotate-icon"></i></h5>
</a>
</div>
<!-- Card body -->
<div id="collapseThree" class="collapse show" role="tabpanel" aria-labelledby="headingThree" style="">
	<div class="card-body">
		<div class="Mapsection">
			<div class="VilaMap">
				<!-- <?php //the_field('overview_map_section_one',356); ?> -->
				<div id="villaMap"></div>
				<input type="hidden" id="latitude" value="-8.688739">
				<input type="hidden" id="longitude" value="115.168690">
			</div>
			<div class="LocBox RatepadinAl">
				<p class="LoCPBol">Jl.Kunti 1, Gang Mangga N.4, 80361, Seminyak, Kuta, Bali, Indonesia</p>
				<ul class="SemiUlLoc rightaliUL">
					<li><p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<g>
							<rect class="st0" width="32" height="32"></rect>
						</g>
						<g>
							<path class="st1" d="M16,7c-2.6,0-4.7,2.1-4.7,4.7c0,2.6,2.1,4.7,4.7,4.7c2.6,0,4.7-2.1,4.7-4.7C20.7,9.1,18.6,7,16,7 M19.7,11.7
							c0,2-1.7,3.7-3.7,3.7c-2,0-3.7-1.7-3.7-3.7C12.3,9.7,14,8,16,8C18,8,19.7,9.7,19.7,11.7"></path>
							<path class="st1" d="M24.3,3.9C20.9,0.4,16,0.5,16,0.5c-0.1,0-4.9-0.1-8.3,3.4c-2.2,2.3-3.2,5.4-3,9.5c0,0.6,0,6.6,10.8,17.9
							c0,0,0.2,0.2,0.4,0.2c0.1,0,0.2,0,0.4-0.2C27.2,20,27.2,14,27.2,13.4C27.4,9.4,26.4,6.2,24.3,3.9 M26.2,13.4
							c0,0.1,0.1,5.9-10.2,16.9C5.7,19.3,5.8,13.5,5.8,13.4l0-0.1C5.6,9.6,6.5,6.7,8.5,4.6c3-3.1,7.4-3.1,7.6-3.1c0.8,0,4.8,0.2,7.5,3.1
							C25.5,6.7,26.4,9.6,26.2,13.4L26.2,13.4z"></path>
						</g>
					</svg>0 km to semiyak</p></li>

					<li><p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<g>
							<rect class="st0" width="32" height="32"></rect>
						</g>
						<g>
							<path class="st1" d="M16,7c-2.6,0-4.7,2.1-4.7,4.7c0,2.6,2.1,4.7,4.7,4.7c2.6,0,4.7-2.1,4.7-4.7C20.7,9.1,18.6,7,16,7 M19.7,11.7
							c0,2-1.7,3.7-3.7,3.7c-2,0-3.7-1.7-3.7-3.7C12.3,9.7,14,8,16,8C18,8,19.7,9.7,19.7,11.7"></path>
							<path class="st1" d="M24.3,3.9C20.9,0.4,16,0.5,16,0.5c-0.1,0-4.9-0.1-8.3,3.4c-2.2,2.3-3.2,5.4-3,9.5c0,0.6,0,6.6,10.8,17.9
							c0,0,0.2,0.2,0.4,0.2c0.1,0,0.2,0,0.4-0.2C27.2,20,27.2,14,27.2,13.4C27.4,9.4,26.4,6.2,24.3,3.9 M26.2,13.4
							c0,0.1,0.1,5.9-10.2,16.9C5.7,19.3,5.8,13.5,5.8,13.4l0-0.1C5.6,9.6,6.5,6.7,8.5,4.6c3-3.1,7.4-3.1,7.6-3.1c0.8,0,4.8,0.2,7.5,3.1
							C25.5,6.7,26.4,9.6,26.2,13.4L26.2,13.4z"></path>
						</g>
					</svg>0,1 km to minimarket</p></li>

					<li><p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<g>
							<rect class="st0" width="32" height="32"></rect>
						</g>
						<g>
							<path class="st1" d="M16,7c-2.6,0-4.7,2.1-4.7,4.7c0,2.6,2.1,4.7,4.7,4.7c2.6,0,4.7-2.1,4.7-4.7C20.7,9.1,18.6,7,16,7 M19.7,11.7
							c0,2-1.7,3.7-3.7,3.7c-2,0-3.7-1.7-3.7-3.7C12.3,9.7,14,8,16,8C18,8,19.7,9.7,19.7,11.7"></path>
							<path class="st1" d="M24.3,3.9C20.9,0.4,16,0.5,16,0.5c-0.1,0-4.9-0.1-8.3,3.4c-2.2,2.3-3.2,5.4-3,9.5c0,0.6,0,6.6,10.8,17.9
							c0,0,0.2,0.2,0.4,0.2c0.1,0,0.2,0,0.4-0.2C27.2,20,27.2,14,27.2,13.4C27.4,9.4,26.4,6.2,24.3,3.9 M26.2,13.4
							c0,0.1,0.1,5.9-10.2,16.9C5.7,19.3,5.8,13.5,5.8,13.4l0-0.1C5.6,9.6,6.5,6.7,8.5,4.6c3-3.1,7.4-3.1,7.6-3.1c0.8,0,4.8,0.2,7.5,3.1
							C25.5,6.7,26.4,9.6,26.2,13.4L26.2,13.4z"></path>
						</g>
					</svg>0,2 km to shops and restaurants</p></li>

					<li><p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<g>
							<rect class="st0" width="32" height="32"></rect>
						</g>
						<g>
							<path class="st1" d="M16,7c-2.6,0-4.7,2.1-4.7,4.7c0,2.6,2.1,4.7,4.7,4.7c2.6,0,4.7-2.1,4.7-4.7C20.7,9.1,18.6,7,16,7 M19.7,11.7
							c0,2-1.7,3.7-3.7,3.7c-2,0-3.7-1.7-3.7-3.7C12.3,9.7,14,8,16,8C18,8,19.7,9.7,19.7,11.7"></path>
							<path class="st1" d="M24.3,3.9C20.9,0.4,16,0.5,16,0.5c-0.1,0-4.9-0.1-8.3,3.4c-2.2,2.3-3.2,5.4-3,9.5c0,0.6,0,6.6,10.8,17.9
							c0,0,0.2,0.2,0.4,0.2c0.1,0,0.2,0,0.4-0.2C27.2,20,27.2,14,27.2,13.4C27.4,9.4,26.4,6.2,24.3,3.9 M26.2,13.4
							c0,0.1,0.1,5.9-10.2,16.9C5.7,19.3,5.8,13.5,5.8,13.4l0-0.1C5.6,9.6,6.5,6.7,8.5,4.6c3-3.1,7.4-3.1,7.6-3.1c0.8,0,4.8,0.2,7.5,3.1
							C25.5,6.7,26.4,9.6,26.2,13.4L26.2,13.4z"></path>
						</g>
					</svg>0,3 km to ATM and money changer</p></li>



					<li><p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<g>
							<rect class="st0" width="32" height="32"></rect>
						</g>
						<g>
							<path class="st1" d="M16,7c-2.6,0-4.7,2.1-4.7,4.7c0,2.6,2.1,4.7,4.7,4.7c2.6,0,4.7-2.1,4.7-4.7C20.7,9.1,18.6,7,16,7 M19.7,11.7
							c0,2-1.7,3.7-3.7,3.7c-2,0-3.7-1.7-3.7-3.7C12.3,9.7,14,8,16,8C18,8,19.7,9.7,19.7,11.7"></path>
							<path class="st1" d="M24.3,3.9C20.9,0.4,16,0.5,16,0.5c-0.1,0-4.9-0.1-8.3,3.4c-2.2,2.3-3.2,5.4-3,9.5c0,0.6,0,6.6,10.8,17.9
							c0,0,0.2,0.2,0.4,0.2c0.1,0,0.2,0,0.4-0.2C27.2,20,27.2,14,27.2,13.4C27.4,9.4,26.4,6.2,24.3,3.9 M26.2,13.4
							c0,0.1,0.1,5.9-10.2,16.9C5.7,19.3,5.8,13.5,5.8,13.4l0-0.1C5.6,9.6,6.5,6.7,8.5,4.6c3-3.1,7.4-3.1,7.6-3.1c0.8,0,4.8,0.2,7.5,3.1
							C25.5,6.7,26.4,9.6,26.2,13.4L26.2,13.4z"></path>
						</g>
					</svg>0,6 km to supermarkets</p></li>


					<li><p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<g>
							<rect class="st0" width="32" height="32"></rect>
						</g>
						<g>
							<path class="st1" d="M16,7c-2.6,0-4.7,2.1-4.7,4.7c0,2.6,2.1,4.7,4.7,4.7c2.6,0,4.7-2.1,4.7-4.7C20.7,9.1,18.6,7,16,7 M19.7,11.7
							c0,2-1.7,3.7-3.7,3.7c-2,0-3.7-1.7-3.7-3.7C12.3,9.7,14,8,16,8C18,8,19.7,9.7,19.7,11.7"></path>
							<path class="st1" d="M24.3,3.9C20.9,0.4,16,0.5,16,0.5c-0.1,0-4.9-0.1-8.3,3.4c-2.2,2.3-3.2,5.4-3,9.5c0,0.6,0,6.6,10.8,17.9
							c0,0,0.2,0.2,0.4,0.2c0.1,0,0.2,0,0.4-0.2C27.2,20,27.2,14,27.2,13.4C27.4,9.4,26.4,6.2,24.3,3.9 M26.2,13.4
							c0,0.1,0.1,5.9-10.2,16.9C5.7,19.3,5.8,13.5,5.8,13.4l0-0.1C5.6,9.6,6.5,6.7,8.5,4.6c3-3.1,7.4-3.1,7.6-3.1c0.8,0,4.8,0.2,7.5,3.1
							C25.5,6.7,26.4,9.6,26.2,13.4L26.2,13.4z"></path>
						</g>
					</svg>1,4 km to Seminyak beach</p></li>

					<li><p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<g>
							<rect class="st0" width="32" height="32"></rect>
						</g>
						<g>
							<path class="st1" d="M16,7c-2.6,0-4.7,2.1-4.7,4.7c0,2.6,2.1,4.7,4.7,4.7c2.6,0,4.7-2.1,4.7-4.7C20.7,9.1,18.6,7,16,7 M19.7,11.7
							c0,2-1.7,3.7-3.7,3.7c-2,0-3.7-1.7-3.7-3.7C12.3,9.7,14,8,16,8C18,8,19.7,9.7,19.7,11.7"></path>
							<path class="st1" d="M24.3,3.9C20.9,0.4,16,0.5,16,0.5c-0.1,0-4.9-0.1-8.3,3.4c-2.2,2.3-3.2,5.4-3,9.5c0,0.6,0,6.6,10.8,17.9
							c0,0,0.2,0.2,0.4,0.2c0.1,0,0.2,0,0.4-0.2C27.2,20,27.2,14,27.2,13.4C27.4,9.4,26.4,6.2,24.3,3.9 M26.2,13.4
							c0,0.1,0.1,5.9-10.2,16.9C5.7,19.3,5.8,13.5,5.8,13.4l0-0.1C5.6,9.6,6.5,6.7,8.5,4.6c3-3.1,7.4-3.1,7.6-3.1c0.8,0,4.8,0.2,7.5,3.1
							C25.5,6.7,26.4,9.6,26.2,13.4L26.2,13.4z"></path>
						</g>
					</svg>1.5 up to 2,5 km to Jl.Oberoi / Jl. Petitenget</p></li>



					<li><p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<g>
							<rect class="st0" width="32" height="32"></rect>
						</g>
						<g>
							<path class="st1" d="M16,7c-2.6,0-4.7,2.1-4.7,4.7c0,2.6,2.1,4.7,4.7,4.7c2.6,0,4.7-2.1,4.7-4.7C20.7,9.1,18.6,7,16,7 M19.7,11.7
							c0,2-1.7,3.7-3.7,3.7c-2,0-3.7-1.7-3.7-3.7C12.3,9.7,14,8,16,8C18,8,19.7,9.7,19.7,11.7"></path>
							<path class="st1" d="M24.3,3.9C20.9,0.4,16,0.5,16,0.5c-0.1,0-4.9-0.1-8.3,3.4c-2.2,2.3-3.2,5.4-3,9.5c0,0.6,0,6.6,10.8,17.9
							c0,0,0.2,0.2,0.4,0.2c0.1,0,0.2,0,0.4-0.2C27.2,20,27.2,14,27.2,13.4C27.4,9.4,26.4,6.2,24.3,3.9 M26.2,13.4
							c0,0.1,0.1,5.9-10.2,16.9C5.7,19.3,5.8,13.5,5.8,13.4l0-0.1C5.6,9.6,6.5,6.7,8.5,4.6c3-3.1,7.4-3.1,7.6-3.1c0.8,0,4.8,0.2,7.5,3.1
							C25.5,6.7,26.4,9.6,26.2,13.4L26.2,13.4z"></path>
						</g>
					</svg>1,5 up to 4 Km to Kuta</p></li>


					<li><p><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:none;}
							.st1{fill:#952524;}
						</style>
						<g>
							<rect class="st0" width="32" height="32"></rect>
						</g>
						<g>
							<path class="st1" d="M16,7c-2.6,0-4.7,2.1-4.7,4.7c0,2.6,2.1,4.7,4.7,4.7c2.6,0,4.7-2.1,4.7-4.7C20.7,9.1,18.6,7,16,7 M19.7,11.7
							c0,2-1.7,3.7-3.7,3.7c-2,0-3.7-1.7-3.7-3.7C12.3,9.7,14,8,16,8C18,8,19.7,9.7,19.7,11.7"></path>
							<path class="st1" d="M24.3,3.9C20.9,0.4,16,0.5,16,0.5c-0.1,0-4.9-0.1-8.3,3.4c-2.2,2.3-3.2,5.4-3,9.5c0,0.6,0,6.6,10.8,17.9
							c0,0,0.2,0.2,0.4,0.2c0.1,0,0.2,0,0.4-0.2C27.2,20,27.2,14,27.2,13.4C27.4,9.4,26.4,6.2,24.3,3.9 M26.2,13.4
							c0,0.1,0.1,5.9-10.2,16.9C5.7,19.3,5.8,13.5,5.8,13.4l0-0.1C5.6,9.6,6.5,6.7,8.5,4.6c3-3.1,7.4-3.1,7.6-3.1c0.8,0,4.8,0.2,7.5,3.1
							C25.5,6.7,26.4,9.6,26.2,13.4L26.2,13.4z"></path>
						</g>
					</svg>9,7 km to the Denpasar International Airport</p></li>


				</ul>

				<div class="RateTCont Rate97">
					<h1 class="AlRCapti" >VILLA SENSEL IS LOCATED RIGHT IN THE REAL CENTER OF SEMINYAK</h1>
					<p>known as the most exsclusive residential area of Bali. </p>
					<p>Set in a peaceful neighborhood with the two most popular tourist areas Jalan Oberoi/ Petitenget and Kuta extending from 1,5 to 4 Km each direction, covered with restaurants, shops and nightlife.</p>

					<p>0.5 km to Sunset Road Bypass crossroad with 24 hours open petrol station, making it simple for you to take a day trip around the island between sacred temples and stunning tropical white sand beaches. </p>
				</div>

</div>
</div>
</div>
</div>
</div>
<!-- Accordion card -->


<!-- ========FEATURES START======== -->
<!-- Accordion card -->
<div class="card carddesign" id="RatClick1">
	<!-- Card header -->
	<div class="card-header" role="tab" id="headingFour">
		<a data-toggle="collapse" data-parent="#accordionEx" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour" class="iarrowclick">
<h5 class="mb-0"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
<style type="text/css">
	.st0{fill:none;}
	.st1{fill:#952524;}
</style>
<g>
	<rect class="st0" width="32" height="32"/>
</g>
<g>
	<path class="st1" d="M26.7,0.5H5.3c-2.7,0-4.8,2.2-4.8,4.8v21.3c0,2.7,2.2,4.8,4.8,4.8h21.3c2.7,0,4.8-2.2,4.8-4.8V5.3
	C31.5,2.7,29.3,0.5,26.7,0.5 M30.3,5.3v21.3c0,2-1.7,3.7-3.7,3.7H5.3c-2,0-3.7-1.7-3.7-3.7V5.3c0-2,1.7-3.7,3.7-3.7h21.3
	C28.7,1.7,30.3,3.3,30.3,5.3"/>
	<path class="st1" d="M21,18.4l-0.1-0.1c-1-1.8-3.4-2.8-4.4-3.2V8.5c1.4,0.1,2.5,0.9,3,1.2c0.2,0.2,0.6,0.1,0.8-0.1
	c0.1-0.1,0.2-0.3,0.1-0.4c0-0.2-0.1-0.3-0.2-0.4c-0.5-0.4-1.9-1.3-3.7-1.5V5.6c0-0.3-0.3-0.6-0.6-0.6c-0.3,0-0.6,0.3-0.6,0.6v1.7
	c-0.8,0.1-1.5,0.4-2.2,0.9c-1.1,0.7-1.7,1.8-1.9,2.9c-0.1,1.4,0.4,3.4,4.1,4.8v7.4c-0.9-0.1-2.7-0.5-3.6-1.5
	c-0.2-0.2-0.5-0.2-0.8-0.1c-0.1,0.1-0.2,0.2-0.2,0.4c0,0.2,0,0.3,0.1,0.5c1.2,1.3,3.5,1.8,4.5,1.9v1.9c0,0.3,0.3,0.6,0.6,0.6
	c0.3,0,0.6-0.3,0.6-0.6v-1.8c1.2,0,3.7-0.4,4.7-3.6C21.4,20.1,21.4,19.2,21,18.4L21,18.4z M20.1,20.6c-0.7,2.4-2.6,2.8-3.6,2.8
	v-7.1c0.9,0.3,2.7,1.2,3.4,2.5C20.2,19.4,20.3,20,20.1,20.6 M15.3,8.5v6.1c-2.1-0.9-3.1-2.1-2.9-3.4c0.1-0.8,0.6-1.5,1.3-2.1
	C14.2,8.9,14.8,8.6,15.3,8.5"/>
</g>
</svg> Rate <i class="fa fa-angle-up rotate-icon"></i></h5>
</a>
</div>
<!-- Card body -->
<div id="collapseFour" class="collapse show" role="tabpanel" aria-labelledby="headingFour" style="">
	<div class="card-body">
		<div class="Mapsection">
			<table class="table table-bodered table-responsive SeasonTable SesonTpa">
				<thead>
					<tr>
						<th scope="col">period</th>
						<th scope="col">Season</th>
						<th scope="col">min stay</th>
						<th scope="col">Rate night</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="FromTdM">From 09-jan to 16-jul</td>
						<td>low season</td>
						<td>1 night</td>
						<td>USD $209</td>
					</tr>
					<tr>
						<td class="FromTdM">From 16-jul to 01-sep</td>
						<td>high season</td>
						<td>1 night</td>
						<td>USD $259</td>
					</tr>
					<tr>
						<td class="FromTdM">From 01-sep to 18-dec</td>
						<td>low season</td>
						<td>1 night</td>
						<td>USD $209</td>
					</tr>

					<tr>
						<td class="FromTdM">From 18-dec to 09-jan</td>
						<td>high season</td>
						<td>1 night</td>
						<td>USD $259</td>
					</tr>
				</tbody>
			</table>

			<div class="row">
				<div class="col-md-12 col-sm-12 col-12">
					<div class="CurTable">
						<select class="selector ftNselct currency_select1">
							<option value="dummy" selected >Currency </option>
							<option value="ARS" >ARS Argentina Peso</option> 
							<option value="AED" >AED United Arab Emirates Dirham</option> 
							<option value="AUD" >AUD Australia Dollar</option> 
							<option value="BSD" >BSD Bahamas Dollar</option> 
							<option value="BGN" >BGN Bulgaria Lev</option> 
							<option value="BRL" >BRL Brazil Real</option> 
							<option value="CAD" >CAD Canada Dollar</option> 
							<option value="CLP" >CLP Chile Peso</option> 
							<option value="CNY" >CNY China Yuan Renminbi</option> 
							<option value="COP" >COP Colombia Peso</option> 
							<option value="HRK" >HRK Croatia Kuna</option> 
							<option value="CZK" >CZK Czech Republic Koruna</option> 
							<option value="DKK" >DKK Denmark Krone</option> 
							<option value="DOP" >DOP Dominican Republic Peso</option> 
							<option value="EGP" >EGP Egypt Pound</option> 
							<option value="EUR" >EUR Euro Member Countries</option> 
							<option value="FJD" >FJD Fiji Dollar</option> 
							<option value="GTQ" >GTQ Guatemala Quetzal</option> 
							<option value="HKD" >HKD Hong Kong Dollar</option> 
							<option value="HUF" >HUF Hungary Forint</option> 
							<option value="ISK" >ISK Iceland Krona</option> 
							<option value="INR" >INR India Rupee</option> 
							<option value="IDR" >IDR Indonesia Rupiah</option> 
							<option value="ILS" >ILS Israel Shekel</option> 
							<option value="JPY" >JPY Japan Yen</option> 
							<option value="KZT" >KZT Kazakhstan Tenge</option> 
							<option value="KRW" >KRW Korea (South) Won</option> 
							<option value="MYR" >MYR Malaysia Ringgit</option> 
							<option value="MXN" >MXN Mexico Peso</option> 
							<option value="NZD" >NZD New Zealand Dollar</option> 
							<option value="NOK" >NOK Norway Krone</option> 
							<option value="PKR" >PKR Pakistan Rupee</option> 
							<option value="PAB" >PAB Panama Balboa</option> 
							<option value="PYG" >PYG Paraguay Guarani</option> 
							<option value="PEN" >PEN Peru Nuevo Sol</option> 
							<option value="PHP" >PHP Philippines Peso</option> 
							<option value="PLN" >PLN Poland Zloty</option> 
							<option value="RON" >RON Romania New Leu</option> 
							<option value="RUB" >RUB Russia Ruble</option> 
							<option value="SAR" >SAR Saudi Arabia Riyal</option> 
							<option value="SGD" >SGD Singapore Dollar</option> 
							<option value="ZAR" >ZAR South Africa Rand</option> 
							<option value="SEK" >SEK Sweden Krona</option> 
							<option value="CHF" >CHF Switzerland Franc</option> 
							<option value="TWD" >TWD Taiwan New Dollar</option> 
							<option value="THB" >THB Thailand Baht</option> 
							<option value="TRY" >TRY Turkey Lira</option> 
							<option value="UAH" >UAH Ukraine Hryvna</option> 
							<option value="GBP" >GBP United Kingdom Pound</option> 
							<option value="USD" >USD United States Dollar</option> 
							<option value="UYU" >UYU Uruguay Peso</option> 
							<option value="VND" >VND Viet Nam Dong</option> 
						</select>
					</div>
				</div>
			</div>

<!-- ==================RATE ACCORDIAN AGAIN ALL============== -->

	<div class="RateTCont brdrWmrgin RatepadinAl">
				<h1 class="AlRCapti">ACCESS TO THE VILLA</h1>
				<div class="ChkInPaE">
					<p class="forChkBold"><span>Check-IN </span>time :not before 02:00 pm</p>
					<p class="forChkBold"><span>Check-OUT </span>time :not later than 11:00 am</p>
				</div>
				<div class="ChkInPaE">
					<p class="forChkBold"><span>Early Check-IN :</span>not before 08:00 am</p>
					<p class="forChkBold"><span>Late Check-OUT :</span>not later than 08:00 pm</p>
					<p>charged an extra 50% on top of the published daily rates.</p>
				</div>
				<p>Select your C-IN and C-OUT dates and continue with [Book Now] to the page “Choose Extra” to view all the updated availability and rates to select your special C-IN or C-OUT and get your final quotation.</p>
				<p class="AirportP"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
					<style type="text/css">
						.st0{fill:none;}
						.st1{fill:#952524;}
					</style>
					<rect y="0" class="st0" width="32" height="32"></rect>
					<path class="st1" d="M29.72,17.48l-10.73-6.47l0-5.13l0-0.05c-0.47-3.89-1.95-5.11-2.57-5.46L16.4,0.37h0
					c-0.24-0.12-0.55-0.12-0.79,0l-0.02,0.01c-0.62,0.34-2.1,1.57-2.57,5.46l0,5.17L2.28,17.48c-0.93,0.56-1.51,1.59-1.51,2.67v2.36
					l12.32-4.29l0,1.5c-0.01,0.25,0.02,1.53,0.94,7.23l-2.68,2.08l-0.03,0.02v2.65h9.34v-2.65l-2.7-2.1c0.92-5.71,0.95-6.98,0.94-7.23
					v-1.51l12.32,4.29v-2.36C31.23,19.07,30.65,18.04,29.72,17.48z M12.24,29.52l2.78-2.16l-0.04-0.27C13.97,20.87,14,19.84,14,19.79
					l0-2.84L1.68,21.24v-1.08c0-0.77,0.41-1.5,1.07-1.89l11.14-6.71l0.04-0.02V6.11c0-0.13,0.01-0.26,0.02-0.38
					c0.36-2.7,1.24-3.85,1.72-4.29c0,0,0.04-0.04,0.11-0.08c0.12-0.07,0.29-0.12,0.45-0.01c0.04,0.02,0.06,0.05,0.1,0.08
					c0.49,0.44,1.36,1.59,1.72,4.29c0.02,0.12,0.02,0.25,0.02,0.38v5.42l11.17,6.73c0.66,0.4,1.07,1.12,1.07,1.9v1.08L18,16.95l0,2.83
					c0,0.04,0.05,0.99-0.97,7.3l-0.04,0.27l2.78,2.16v1.3h-7.52V29.52z"></path>
				</svg> Airport Tranfser is on Request : 1 to 6 Guests: US$ 13.00/transfer; 7 to 8 Guests: US$ 16.00/transfer.</p>
			</div>



<div id="accordionRateAg">
  <div class="card">
    <div class="card-header" id="headingOneRateag">
      <h5 class="mb-0">
        <a data-toggle="collapse" data-target="#collapseOneRateag" aria-expanded="true" aria-controls="collapseOneRateag" class="iarrowclick22">LAST MINUTE RATE <i class="fa fa-angle-up rotate-icon"></i></a>
      </h5>
    </div>

    <div id="collapseOneRateag" class="collapse" aria-labelledby="headingOneRateag" data-parent="#accordionRateAg">
      <div class="card-body">
       <div class="RateTCont brdrWmrgin RatepadinAl">
				<h1 class="AlRCapti">LAST MINUTE RATE</h1>
				<p class="forChkBold">They start around a month before any vacant day.</p>
				<p>Select your C-IN and C-OUT dates to view all the updated and last minute rates to get your final quotation. </p>
				<p class="forChkBold">In the last minute rental rate, breakfast and airport transfer are not included.</p>
			</div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwoRateag">
      <h5 class="mb-0">
        <a class="collapsed iarrowclick22" data-toggle="collapse" data-target="#collapseTwoRateag" aria-expanded="false" aria-controls="collapseTwoRateag"
         >EXTRA GUESTS<i class="fa fa-angle-up rotate-icon"></i></a>
      </h5>
    </div>
    <div id="collapseTwoRateag" class="collapse" aria-labelledby="headingTwoRateag" data-parent="#accordionRateAg">
      <div class="card-body">
       <div class="RateTCont brdrWmrgin RatepadinAl">
				<h1 class="AlRCapti">EXTRA GUESTS</h1>
				<p class="forChkBold">Maximum capacity of the VIlla: 10 Guests.</p>
				<p class="forChkBold">Each extra guest over the maximum capacity of the villa (two people per bedroom) will be charged according to the updated rates.</p>
				<p>Select your C-IN and C-OUT dates and continue with [Book Now] to the page “Choose Extra” to view and select the updated rate for any extra guest you require and get your final quotation.</p>
			</div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThreeRateag">
      <h5 class="mb-0">
        <a class="collapsed iarrowclick22" data-toggle="collapse" data-target="#collapseThreeRateag" aria-expanded="false" aria-controls="collapseThreeRateag">EXTRA BED<i class="fa fa-angle-up rotate-icon"></i></a>
      </h5>
    </div>
    <div id="collapseThreeRateag" class="collapse" aria-labelledby="headingThreeRateag" data-parent="#accordionRateAg">
      <div class="card-body">
        <div class="RateTCont brdrWmrgin RatepadinAl">
				<h1 class="AlRCapti">EXTRA BED</h1>
				<p class="forChkBold">In this villa, not all bedrooms are designed to contain an extra bed.</p>
				<p class="forChkBold">Our beds and mattresses are super king size and can comfortably sleep three people if necessary, especially if the extra person is a child.</p>
				<p>In case an extra bed is anyway required, we will charge US$ 15,00/night and we kindly ask you to contact us to request it during your reservation and get more information about it.</p>
			</div>
      </div>
    </div>
  </div>

   <div class="card">
    <div class="card-header" id="headingFourRateag">
      <h5 class="mb-0">
        <a class="collapsed iarrowclick22" data-toggle="collapse" data-target="#collapseFourRateag" aria-expanded="false" aria-controls="collapseFourRateag">CHILDREN IN THE VILLA<i class="fa fa-angle-up rotate-icon"></i></a>
      </h5>
    </div>
    <div id="collapseFourRateag" class="collapse" aria-labelledby="headingFourRateag" data-parent="#accordionRateAg">
      <div class="card-body">
        <div class="RateTCont brdrWmrgin RatepadinAl">
				<h1 class="AlRCapti">CHILDREN IN THE VILLA</h1>
				<p class="forChkBold">All children are very welcome at Minggu VIllas, and in case the total of them go over the maximum capacity of the villa, depend on their age, they will be either accomodated free or at a discounted rate as follow:</p>
				<ul class="kidsageul forChkBold">
					<li><i class="fa fa-square" aria-hidden="true"></i>Kids age Up to 6: ALWAYS free of charge</li>
					<li><i class="fa fa-square" aria-hidden="true"></i>Kids age 7 to 14: first 2 free of charge; any other charged 50% of the adult extra charge</li>
					<li><i class="fa fa-square" aria-hidden="true"></i>Kids age 15 or over: counted as adults</li>
				</ul>

				<p class="KidWepri">We provide:</p>
				<ul class="kidsageul">
					<li> <i class="fa fa-square" aria-hidden="true"></i>Baby Cot and High Chair: first set free of charge; US$ 8,00/day from the second ones.</li>
					<li><i class="fa fa-square" aria-hidden="true"></i>Pool Fence: extra charge of US$ 20.00/day.</li>
					<li><i class="fa fa-square" aria-hidden="true"></i> Baby Sitting: US$ 4.00/hour from 08:00am; US$ 6.00/hour from 06:00pm till 12:00pm. <a href="#">(see more Details)</a></li>
					<!-- <li><i class="fa fa-square" aria-hidden="true"></i> </li> -->
					<li><i class="fa fa-square" aria-hidden="true"></i>For more information or book something extra, please don’t hesitate to contact us.</li>
				</ul>
			</div>
      </div>
    </div>
  </div>

   <div class="card">
    <div class="card-header" id="headingFiveRateag">
      <h5 class="mb-0">
        <a class="collapsed" data-toggle="collapse" data-target="#collapseFiveRateag" aria-expanded="false" aria-controls="collapseFiveRateag">PAYMENT SCHEDULE<i class="fa fa-angle-up rotate-icon"></i></a>
      </h5>
    </div>
    <div id="collapseFiveRateag" class="collapse" aria-labelledby="headingFiveRateag" data-parent="#accordionRateAg">
      <div class="card-body">
        <div class="RateTCont brdrWmrgin RatepadinAl">
				<h1 class="AlRCapti">PAYMENT SCHEDULE</h1>
				<p>50% at time booking.</p>
			</div>
      </div>
    </div>
  </div>

</div>

<div class="RateTCont brdrWmrgin RatepadinAl">
				<h1 class="AlRCapti">EXTRA RULE</h1>
				<p>The only extra rule we have is that you MUST enjoy your stay!!!</p>
				<p>We trust you will take good care of our villas just like we take great care of all our Guests!</p>
			</div>


			<div class="RateTerm">
				<a href="">Terms and conditions</a>
			</div>

<!-- ==================RATE ACCORDIAN AGAIN ALL============== -->




		
		</div>
	</div>
</div>
</div>
<!-- Accordion card -->
<!-- =========FEATURES END========== -->


<!-- ========FEATURES START======== -->
<!-- Accordion card -->
<div class="card carddesign" id="AvaClick1">
	<!-- Card header -->
	<div class="card-header" role="tab" id="headingFive">
		<a data-toggle="collapse" data-parent="#accordionEx" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive" class="iarrowclick">
			<h5 class="mb-0"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
				width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
				<style type="text/css">
					.st0{fill:none;}
					.st1{fill:#952524;}
				</style>
				<g>
					<rect class="st0" width="32" height="32"/>
				</g>
				<g>
					<path class="st1" d="M26.4,2.5h-1.6V1c0-0.3-0.2-0.5-0.5-0.5c-0.3,0-0.5,0.2-0.5,0.5v1.5h-7.4V1c0-0.3-0.2-0.5-0.5-0.5
					c-0.3,0-0.5,0.2-0.5,0.5v1.5H8.1V1c0-0.3-0.2-0.5-0.5-0.5C7.3,0.5,7.1,0.7,7.1,1v1.5H5c-2.5,0-4.5,2.2-4.5,4.9v19.2
					c0,2.7,2,4.9,4.5,4.9H27c2.5,0,4.5-2.2,4.5-4.9V7.3c0-3.2-2.4-4.8-4.3-4.8 M1.4,10.1h26.5H28c0.2,0,0.4-0.2,0.4-0.5v0
					c0-0.3-0.2-0.5-0.4-0.5H1.4V7.4C1.4,5.2,3,3.5,5,3.5h2.2v1.5c0,0.3,0.2,0.5,0.5,0.5c0.2,0,0.5-0.2,0.5-0.5V3.5h7.5v1.5
					c0,0.3,0.2,0.5,0.5,0.5c0.2,0,0.5-0.2,0.5-0.5V3.5h7.4v1.5c0,0.3,0.2,0.5,0.5,0.5c0.2,0,0.5-0.2,0.5-0.5V3.5H27
					c2,0,3.6,1.8,3.6,3.9v19.2c0,2.2-1.6,3.9-3.5,3.9H5c-2,0-3.6-1.8-3.6-3.9V10.1z"/>
					<g>
						<path class="st1" d="M12.3,14.6h1.3c0.3,0,0.5-0.2,0.5-0.5c0-0.3-0.2-0.5-0.5-0.5h-1.3c-0.3,0-0.5,0.2-0.5,0.5
						C11.8,14.4,12,14.6,12.3,14.6"/>
						<path class="st1" d="M5.2,14.6h1.3c0.3,0,0.5-0.2,0.5-0.5c0-0.3-0.2-0.5-0.5-0.5H5.2c-0.3,0-0.5,0.2-0.5,0.5
						C4.7,14.4,4.9,14.6,5.2,14.6"/>
						<path class="st1" d="M19.4,14.6h1.3c0.3,0,0.5-0.2,0.5-0.5c0-0.3-0.2-0.5-0.5-0.5h-1.3c-0.3,0-0.5,0.2-0.5,0.5
						C18.9,14.4,19.2,14.6,19.4,14.6"/>
						<path class="st1" d="M26.5,14.6h1.3c0.3,0,0.5-0.2,0.5-0.5c0-0.3-0.2-0.5-0.5-0.5h-1.3c-0.3,0-0.5,0.2-0.5,0.5
						C26.1,14.4,26.3,14.6,26.5,14.6"/>
						<path class="st1" d="M12.3,18.9h1.3c0.3,0,0.5-0.2,0.5-0.5c0-0.3-0.2-0.5-0.5-0.5h-1.3c-0.3,0-0.5,0.2-0.5,0.5
						C11.8,18.7,12,18.9,12.3,18.9"/>
						<path class="st1" d="M5.2,18.9h1.3c0.3,0,0.5-0.2,0.5-0.5C7,18.2,6.7,18,6.5,18H5.2c-0.3,0-0.5,0.2-0.5,0.5
						C4.7,18.7,4.9,18.9,5.2,18.9"/>
						<path class="st1" d="M19.4,18.9h1.3c0.3,0,0.5-0.2,0.5-0.5c0-0.3-0.2-0.5-0.5-0.5h-1.3c-0.3,0-0.5,0.2-0.5,0.5
						C18.9,18.7,19.2,18.9,19.4,18.9"/>
						<path class="st1" d="M26.5,18.9h1.3c0.3,0,0.5-0.2,0.5-0.5c0-0.3-0.2-0.5-0.5-0.5h-1.3c-0.3,0-0.5,0.2-0.5,0.5
						C26.1,18.7,26.3,18.9,26.5,18.9"/>
						<path class="st1" d="M12.3,23.2h1.3c0.3,0,0.5-0.2,0.5-0.5c0-0.3-0.2-0.5-0.5-0.5h-1.3c-0.3,0-0.5,0.2-0.5,0.5
						C11.8,23,12,23.2,12.3,23.2"/>
						<path class="st1" d="M5.2,23.2h1.3C6.7,23.2,7,23,7,22.7c0-0.3-0.2-0.5-0.5-0.5H5.2c-0.3,0-0.5,0.2-0.5,0.5
						C4.7,23,4.9,23.2,5.2,23.2"/>
						<path class="st1" d="M19.4,23.2h1.3c0.3,0,0.5-0.2,0.5-0.5c0-0.3-0.2-0.5-0.5-0.5h-1.3c-0.3,0-0.5,0.2-0.5,0.5
						C18.9,23,19.2,23.2,19.4,23.2"/>
						<path class="st1" d="M26.5,23.2h1.3c0.3,0,0.5-0.2,0.5-0.5c0-0.3-0.2-0.5-0.5-0.5h-1.3c-0.3,0-0.5,0.2-0.5,0.5
						C26.1,23,26.3,23.2,26.5,23.2"/>
						<path class="st1" d="M12.3,27.5h1.3c0.3,0,0.5-0.2,0.5-0.5c0-0.3-0.2-0.5-0.5-0.5h-1.3c-0.3,0-0.5,0.2-0.5,0.5
						C11.8,27.3,12,27.5,12.3,27.5"/>
						<path class="st1" d="M5.2,27.5h1.3C6.7,27.5,7,27.3,7,27c0-0.3-0.2-0.5-0.5-0.5H5.2c-0.3,0-0.5,0.2-0.5,0.5
						C4.7,27.3,4.9,27.5,5.2,27.5"/>
						<path class="st1" d="M19.4,27.5h1.3c0.3,0,0.5-0.2,0.5-0.5c0-0.3-0.2-0.5-0.5-0.5h-1.3c-0.3,0-0.5,0.2-0.5,0.5
						C18.9,27.3,19.2,27.5,19.4,27.5"/>
						<path class="st1" d="M26.5,27.5h1.3c0.3,0,0.5-0.2,0.5-0.5c0-0.3-0.2-0.5-0.5-0.5h-1.3c-0.3,0-0.5,0.2-0.5,0.5
						C26.1,27.3,26.3,27.5,26.5,27.5"/>
					</g>
				</g>
			</svg>Availability <i class="fa fa-angle-up rotate-icon"></i></h5>
		</a>
	</div>
	<!-- Card body -->
	<div id="collapseFive" class="collapse show" role="tabpanel" aria-labelledby="headingFive" style="">
		<div class="card-body">
			<div class="AllAvblityBox abnewSinglLity">
				<form>
					<div class="row justify-content-center">


						<div class="col-md-12 mb_20">
							<div id="availability-legend">
								<div class="available legend-square"></div>
								<span>Available</span>
								<div class="unavailable legend-square"></div>
								<span>Unavailable</span>
							</div>
						</div>

						<div class="col-md-12 mb_20">
						   <div id="available" class=FortbResponsive></div>                                         
						</div>
</div>
</form>
</div>
</div>
</div>
</div>
<!-- Accordion card -->
<!-- =========FEATURES END========== -->








<!-- ========REVIEW START======== -->
<!-- Accordion card -->
<div class="card carddesign" id="RevClick1">
	<!-- Card header -->
	<div class="card-header" role="tab" id="headingSix">
		<a data-toggle="collapse" data-parent="#accordionEx" href="#collapseSix" aria-expanded="true" aria-controls="collapseSix" class="iarrowclick">
			<h5 class="mb-0"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
				width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
				<style type="text/css">
					.st0{fill:none;}
					.st1{fill:#952524;}
				</style>
				<g>
					<rect class="st0" width="32" height="32"/>
				</g>
				<path class="st1" d="M32,12.2c-0.1-0.4-0.5-0.6-0.8-0.6l-9.5-1c-0.3,0-0.5-0.2-0.6-0.4l-4.2-9c-0.1-0.4-0.5-0.6-0.9-0.6
				c-0.4,0-0.7,0.2-0.9,0.6l-4,8.9c-0.1,0.2-0.3,0.4-0.6,0.4l-9.7,1c-0.4,0-0.7,0.3-0.8,0.6c-0.1,0.4,0,0.8,0.3,1l7,5.8
				c0.5,0.4,0.7,1,0.5,1.5l-2.2,9.6c-0.1,0.4,0,0.7,0.3,1c0.2,0.1,0.4,0.2,0.6,0.2c0.1,0,0.3,0,0.4-0.1l8.9-4.7c0,0,0,0,0,0l8.9,4.7
				c0.3,0.2,0.7,0.1,1-0.1c0.3-0.2,0.4-0.6,0.3-0.9l-2.1-9.6c-0.1-0.6,0.1-1.1,0.5-1.5l6.9-5.8C31.9,13,32.1,12.6,32,12.2z M22.9,20.8
				l2,9l-8.3-4.4c-0.2-0.1-0.4-0.2-0.6-0.2c-0.2,0-0.4,0.1-0.6,0.2l-8.3,4.4l2-8.9c0.2-1-0.1-2.1-0.9-2.8l-6.5-5.3l9-0.9
				c0.7-0.1,1.3-0.5,1.6-1.2L16,2.4l3.9,8.4c0.3,0.6,0.9,1.1,1.6,1.1l8.7,0.9l-6.4,5.3C23.1,18.8,22.7,19.8,22.9,20.8z"/>
			</svg>Review <i class="fa fa-angle-up rotate-icon"></i></h5>
		</a>
	</div>
	<!-- Card body -->
	<div id="collapseSix" class="collapse show" role="tabpanel" aria-labelledby="headingSix" style="">
		<div class="card-body">
<!-- <div class="Symkheading">
<h1>Reviews</h1>    
</div> -->

<div class="ReviewUl">
	<ul>

		<li><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/05/l1.jpg" alt="Image" class="img-fluid"></li>

		<li><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/05/l2.png" alt="Image" class="img-fluid"></li>

		<li><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/05/l3.png" alt="Image" class="img-fluid"></li>

	</ul>
	<p class="review_para">We are proud to share with you what our guests think about us and if you have enjoyed your stay, please write a review to improve our service.</p>
	<p>Thank you very much for your help and collaboration.</p>
	<!-- <a href="" class="btn btn-cta">Write a Review</a>-->
	<a href="http://pixlritllc.com/mingguvillas/write-a-review-page/" class="btn btn-cta">Write a Review</a>

</div>

<div class="reviewyBox">
	<form>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-12">


				<h1 class="center_heading SingGray1">1</h1>
				<div class="ReviewImg">
					<img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/07/00382-01-2019-Villa-Sabtu-Airbnb-Havani-Irene.jpg">
				</div>
</div>
</div>
</form>

<div class="CloseRev">
	<div class="row">
		<div class="col-md-6 col-sm-6 col-12">
			<a href="http://pixlritllc.com/mingguvillas/write-a-review-page/" class="btn btn-cta">View More</a>
		</div>

		<div class="col-md-6 col-sm-6 col-12">
			<a href="http://pixlritllc.com/mingguvillas/write-a-review-page/" class="btn btn-cta ViewSIngNw">Close Review</a>
		</div>
	</div>


</div>
</div>
</div>
</div>
</div>
<!-- Accordion card -->
<!-- =========REVIEW END========== -->



<!-- ========FEATURES START======== -->
<!-- Accordion card -->
<div class="card carddesign" id="feaClick1">
	<!-- Card header -->
	<div class="card-header" role="tab" id="headingSeven">
		<a data-toggle="collapse" data-parent="#accordionEx" href="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven" class="iarrowclick">
			<h5 class="mb-0"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
				width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
				<style type="text/css">
					.st0{fill:none;}
					.st1{fill:#952524;}
				</style>
				<g>
					<rect class="st0" width="32" height="32"/>
				</g>
				<g>
					<path class="st1" d="M26.7,0.5H5.3c-2.7,0-4.8,2.2-4.8,4.8v21.3c0,2.7,2.2,4.8,4.8,4.8h21.3c2.7,0,4.8-2.2,4.8-4.8V5.3
					C31.5,2.7,29.3,0.5,26.7,0.5 M30.3,5.3v21.3c0,2-1.7,3.7-3.7,3.7H5.3c-2,0-3.7-1.7-3.7-3.7V5.3c0-2,1.7-3.7,3.7-3.7h21.3
					C28.7,1.7,30.3,3.3,30.3,5.3"/>
					<g>
						<path class="st1" d="M9.1,14.9c-0.6,0-1.1,0.5-1.1,1.1c0,0.6,0.5,1.1,1.1,1.1c0.6,0,1.1-0.5,1.1-1.1C10.2,15.4,9.7,14.9,9.1,14.9"
						/>
						<path class="st1" d="M16,14.9c-0.6,0-1.1,0.5-1.1,1.1c0,0.6,0.5,1.1,1.1,1.1s1.1-0.5,1.1-1.1C17.1,15.4,16.6,14.9,16,14.9"/>
						<path class="st1" d="M22.9,14.9c-0.6,0-1.1,0.5-1.1,1.1c0,0.6,0.5,1.1,1.1,1.1c0.6,0,1.1-0.5,1.1-1.1
						C24.1,15.4,23.6,14.9,22.9,14.9"/>
					</g>
				</g>
			</svg> Features <i class="fa fa-angle-up rotate-icon"></i></h5>
		</a>
	</div>
	<!-- Card body -->
	<div id="collapseSeven" class="collapse show" role="tabpanel" aria-labelledby="headingSeven" style="">
		<div class="card-body">
			<div class="FeaturTabRe">






				<div class="FeatureTab2">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-12">
							<div class="TAbULId">
								<div class="row">
									<div class="col-md-12">
										<ul class="EqualTbUlCell">
											<li><a href="#vliaInfoClick1">Information</a></li>
											<li><a href="#ExtraAtClick1">at the villa</a></li>
											<li><a href="#ExtraoutClick1">outside</a></li>
											<li><a href="#VillaAmenClick1">Amenities</li>
												<li><a href="#VillaLayClick1">Layout</a></li>


											</ul>
										</div>
									</div>
								</div> 
								<div class="FeatureTabMain2">

									<!--Accordion wrapper-->
									<div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">

										<!-- Accordion card -->
										<div class="card">

											<!-- Card header -->
											<div class="card-header" role="tab" id="headingTwo1">
												<a class="collapsed iarrowclick" data-toggle="collapse" data-parent="#accordionEx1" href="#collapseTwo1"
												aria-expanded="false" aria-controls="collapseTwo1" >
												<h5 class="mb-0 Mbimgsh"><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg"> Vila information <i class="fa fa-angle-down rotate-icon"></i> </h5>
											</a>
										</div>

										<!-- Card body -->
										<div id="collapseTwo1" class="collapse" role="tabpanel" aria-labelledby="headingTwo1"
										data-parent="#accordionEx1">
										<div class="card-body InnerCardFeat">
											<div class="row">
												<div class="col-md-4 col-sm-6 col-12">
													<div class="FeatureTabMain2vila">
														<h1>Description</h1>

														<ul>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg"> 2 Floors</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Land: 400 Mt2</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Buliding: 300 Mt2</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Connected Properties</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">5 Bedroom</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">5 Bathroom</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Guest Bathroom</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">10 Guests</p></li>
														</ul>
													</div>
												</div>
												<!--  =========COLUMN FOUR END========== -->
												<div class="col-md-4 col-sm-6 col-12">
													<div class="FeatureTabMain2vila">
														<h1>Villa Welcome</h1>

														<ul>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Check-IN:</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Check-OUT:</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Fresh Towel</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Drinks</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Snack</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">5 Bathroom</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Fruit Basket</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">1Candy</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Tropical Flower</p></li>
														</ul>
													</div>
												</div>
												<!--  =========COLUMN FOUR END========== -->
												<div class="col-md-4 col-sm-6 col-12">
													<div class="FeatureTabMain2vila">
														<h1>Villa Facilities</h1>

														<ul>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Mobile Phone, Free 3G</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Unlimited Wi-Fi</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">TV-Cable, 60 channels</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">DVD Selection Movies</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Osmose Purify System</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Electrical Adapters</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Iron and Ironing Board</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Umbrella</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Matches</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Pen</p></li>
														</ul>
													</div>
												</div>
												<!--  =========COLUMN FOUR END========== -->

												<div class="col-md-4 col-sm-6 col-12">
													<div class="FeatureTabMain2vila">
														<h1>Children Facilities</h1>

														<ul>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Baby Cot (first set included)</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">High Chair</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Stairs Gate</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Baby Car Seats</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Arm & Donut Floats</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Pool Fence (extra Cost)</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Baby Sitting (extra Cost)</p></li>

														</ul>
													</div>
												</div>
												<!--  =========COLUMN FOUR END========== -->

												<div class="col-md-4 col-sm-6 col-12">
													<div class="FeatureTabMain2vila">
														<h1>Safety & Sanity</h1>

														<ul>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">24h Security</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">CCTV System</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Safety Box</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">First Aid Need</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">24h Doctor on Call (extra Cost)</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Smoke Detector</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Fire Extinguisher</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Fogging Insect</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Spraying Mosquito</p></li>
														</ul>
													</div>
												</div>
												<!--  =========COLUMN FOUR END========== -->


												<div class="col-md-4 col-sm-6 col-12">
													<div class="FeatureTabMain2vila">
														<h1>Working Staff</h1>

														<ul>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Everyday from 8am to 4pm</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Extra Hours (on Request)</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">24/7 Assistance on call</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">for Urgency/Emergency</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Concierge</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Housekeeping</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Gardener</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Pool Keeper</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Maintenance</p></li>
														</ul>
													</div>
												</div>
												<!--  =========COLUMN FOUR END========== -->


												<div class="col-md-4 col-sm-6 col-12">
													<div class="FeatureTabMain2vila">
														<h1>Private Facilities</h1>

														<ul>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Swimming Pool</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Sauna</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Gym</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Spa Room</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">2TV-Room</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Office</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Gazebo</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Parking</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Private Street Complex</p></li>
															<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Luggage Deposit</p></li>
														</ul>
													</div>
												</div>
												<!--  =========COLUMN FOUR END========== -->
											</div>
										</div>
									</div>

								</div>
								<!-- Accordion card -->

								<!-- Accordion card -->
								<div class="card">

									<!-- Card header -->
									<div class="card-header" role="tab" id="headingTwo2">
										<a class="collapsed iarrowclick" data-toggle="collapse" data-parent="#accordionEx1" href="#collapseTwo21"
										aria-expanded="false" aria-controls="collapseTwo21">
										<h5 class="mb-0 Mbimgsh"><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Extra at the villa <i class="fa fa-angle-down rotate-icon"></i>
										</h5>
									</a>
								</div>

								<!-- Card body -->
								<div id="collapseTwo21" class="collapse" role="tabpanel" aria-labelledby="headingTwo21"
								data-parent="#accordionEx1">
								<div class="card-body InnerCardFeat">
									<div class="row">
										<div class="col-md-4 col-sm-6 col-12">
											<div class="FeatureTabMain2vila">
												<h1>Food service <a href="#">see the menu</a></h1>

												<ul>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg"> Breakfast</p></li>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Floating Breakfast</p></li>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Floating Brunch</p></li>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Lunch</p></li>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Dinner</p></li>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">BBQ</p></li>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Villa Restaurant</p></li>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Finger Food</p></li>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Cooking Class</p></li>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Finger Food</p></li>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Room Service</p></li>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Ice Cream</p></li>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Espresso Coffee Pod</p></li>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Shopping Grocery</p></li>
												</ul>
											</div>
										</div>
										<!--  =========COLUMN FOUR END========== -->
										<div class="col-md-4 col-sm-6 col-12">
											<div class="FeatureTabMain2vila">
												<h1>spa service <a href="#">see the menu</a></h1>

												<ul>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg"> Massage (see the Menu)</p></li>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Skin Treatments</p></li>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Beauty Treatments</p></li>
												</ul>
											</div>


											<div class="FeatureTabMain2vila">
												<h1>celebrations<a href="#">see the menu</a></h1>

												<ul>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg"> Birthday Cake (see the Menu)</p></li>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Birthday Decoration (see the Pics)</p></li>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Event Organizing</p></li>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Video/Photographer</p></li>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Floral Request</p></li>
												</ul>
											</div>

										</div>
										<!--  =========COLUMN FOUR END========== -->


										<div class="col-md-4 col-sm-6 col-12">
											<div class="FeatureTabMain2vila">
												<h1>Others <a href="#">see the menu</a></h1>

												<ul>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg"> Sim Card</p></li>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Floater</p></li>
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Floating Brunch</p></li>

													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Personal Gym Trainer</p></li> 
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Personal Yoga Trainer</p></li> 
													<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Laundry & Dry Cleaning (see the Price List)</p></li>
												</ul>
											</div>
										</div>
										<!--  =========COLUMN FOUR END========== -->

									</div>
								</div>
							</div>

						</div>
						<!-- Accordion card -->

						<!-- Accordion card -->
						<div class="card">

							<!-- Card header -->
							<div class="card-header" role="tab" id="headingThree31">
								<a class="collapsed iarrowclick" data-toggle="collapse" data-parent="#accordionEx1" href="#collapseThree31"
								aria-expanded="false" aria-controls="collapseThree31">
								<h5 class="mb-0 Mbimgsh"><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Extra outside the villa<i class="fa fa-angle-down rotate-icon"></i>
								</h5>
							</a>
						</div>

						<!-- Card body -->
						<div id="collapseThree31" class="collapse" role="tabpanel" aria-labelledby="headingThree31"
						data-parent="#accordionEx1">
						<div class="card-body InnerCardFeat">
							<div class="row">
								<div class="col-md-4 col-sm-6 col-12">
									<div class="FeatureTabMain2vila">
										<h1>Tours</h1>
										<ul>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg"> Bali Temples</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">GWK Cultural Park</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Kecak Dance</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Ubud</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Waterfall</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Ricefield Terrace</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Monkey Forest</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Secret Beaches</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Volcano</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Dolphin</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Manta</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Coffee Luwak</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Local Market</p></li>
										</ul>
									</div>
								</div>
								<!--  =========COLUMN FOUR END========== --> 
								<div class="col-md-4 col-sm-6 col-12">
									<div class="FeatureTabMain2vila">
										<h1>Transports</h1>
										<ul>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg"> Airport Transfer (9,7 Km)</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Transfer Escort by Manager</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Car with Driver</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Car Rental</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Motorbike Rental</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Bicycle Rental</p></li>
										</ul>
									</div>



									<div class="FeatureTabMain2vila">
										<h1>Water activities</h1>
										<ul>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Rafting</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Snorkeling</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Diving</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Fishing</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Private Boat</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Water Sport</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Surf lesson</p></li>
										</ul>
									</div>

								</div>
								<!--  =========COLUMN FOUR END========== --> 
								<div class="col-md-4 col-sm-6 col-12">
									<div class="FeatureTabMain2vila">
										<h1>Others activity</h1>
										<ul>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Horse Riding</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Go-Kart</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">ATV / Quad</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Paintball</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Motocross</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Downhill</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Cycling</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Zip Line</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Trekking</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Golf</p></li>
										</ul>
									</div>
								</div>
								<!--  =========COLUMN FOUR END========== -->



								<div class="col-md-4 col-sm-6 col-12">
									<div class="FeatureTabMain2vila">
										<h1>Ticketing</h1>
										<ul>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Bali Safari</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Bali Bird Park</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Butterfly Park</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Restaurant Reservation</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Beach Club Reservation</p></li>

										</ul>
									</div>
								</div>
								<!--  =========COLUMN FOUR END========== -->


								<div class="col-md-4 col-sm-6 col-12">
									<div class="FeatureTabMain2vila">
										<h1>Islands Tour</h1>
										<ul>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Gili Islands</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Lombok</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Nusa Penida</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Nusa Lembongan</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Nusa Ceningan</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Java Temple</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Raja Ampat</p></li>
										</ul>
									</div>
								</div>
								<!--  =========COLUMN FOUR END========== -->




								<div class="col-md-4 col-sm-6 col-12">
									<div class="FeatureTabMain2vila">
										<h1>Instagram Venues</h1>
										<ul>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Ubud Swing</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Lempuyang Temple</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Jatiluwih Rice Terrace</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Abandoned Plane</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Kelingking Beach T-Rex</p></li>
											<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Water Dam Tukad Unda</p></li>
										</ul>
									</div>
								</div>
								<!--  =========COLUMN FOUR END========== -->


							</div>
						</div>
					</div>

				</div>
				<!-- Accordion card -->



				<!-- Accordion card -->
				<div class="card">

					<!-- Card header -->
					<div class="card-header" role="tab" id="headingFour41">
						<a class="collapsed iarrowclick" data-toggle="collapse" data-parent="#accordionEx1" href="#collapseFour41"
						aria-expanded="false" aria-controls="collapseFour41">
						<h5 class="mb-0 Mbimgsh"><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Villa Amenities<i class="fa fa-angle-down rotate-icon"></i>
						</h5>
					</a>
				</div>

				<!-- Card body -->
				<div id="collapseFour41" class="collapse" role="tabpanel" aria-labelledby="headingFour41"
				data-parent="#accordionEx1">
				<div class="card-body InnerCardFeat">
					<div class="row">
						<div class="col-md-4 col-sm-6 col-12">
							<div class="FeatureTabMain2vila">
								<h1>Bedroom Amenities</h1>
								<ul>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Air Conditioning</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Safety Box</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Linen & Duvet</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Aroma Therapy</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Wardrobe</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Mosquito Vacuum</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Mosquito Repellent</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Hangers</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Sleeping Mask</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Ear Plugs</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Sewing Kit</p></li>
								</ul>
							</div>
						</div>
						<!--  =========COLUMN FOUR END========== --> 
						<div class="col-md-4 col-sm-6 col-12">
							<div class="FeatureTabMain2vila">
								<h1>Bathroom Amenities</h1>
								<ul>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Set Towels</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Hair Dryer</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Hand Soap</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Shampoo</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Conditioner</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Body Lotion</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Bath Foam</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Shower Cap</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Dental kit</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Drinkable Water</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Shaving Kit</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Cotton Bud</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Sanitary Bag</p></li>
								</ul>
							</div>



						</div>
						<!--  =========COLUMN FOUR END========== --> 
						<div class="col-md-4 col-sm-6 col-12">
							<div class="FeatureTabMain2vila">
								<h1>kitchen Amenities</h1>
								<ul>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Fresh Water</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Ice Cube</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Bali coffee</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Nescafe</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Bali Tea</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">White Sugar</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Brown Sugar</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Sweetener</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Creamer</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Salt</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Pepper</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Basic Spices</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Tooth Picks</p></li>
								</ul>
							</div>
						</div>
						<!--  =========COLUMN FOUR END========== -->



						<div class="col-md-4 col-sm-6 col-12">
							<div class="FeatureTabMain2vila">
								<h1>kitchen Appliances</h1>
								<ul>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Gas Kitchen</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Oven</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Microwave</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Toaster</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Rice Cooker</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Kettle</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Blender</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Coffee Machine</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Espresso Machine</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Fridge</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">American Fridge</p></li>
									<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Ice Maker</p></li>

								</ul>
							</div>
						</div>
						<!--  =========COLUMN FOUR END========== -->


					</div>
				</div>
			</div>

		</div>
		<!-- Accordion card -->



		<!-- Accordion card -->
		<div class="card">

			<!-- Card header -->
			<div class="card-header" role="tab" id="headingFive51">
				<a class="collapsed iarrowclick" data-toggle="collapse" data-parent="#accordionEx1" href="#collapseFive51"
				aria-expanded="false" aria-controls="collapseFive51">
				<h5 class="mb-0 Mbimgsh"><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Villa Layout<i class="fa fa-angle-down rotate-icon"></i>
				</h5>
			</a>
		</div>

		<!-- Card body -->
		<div id="collapseFive51" class="collapse" role="tabpanel" aria-labelledby="headingFive51"
		data-parent="#accordionEx1">
		<div class="card-body InnerCardFeat">
			<div class="row">
				<div class="col-md-4 col-sm-6 col-12">
					<div class="FeatureTabMain2vila">
						<h1>Swimming Pool</h1>
						<ul>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">4x10 Mt; Deep: 0,4 to 1,8 Mt</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Built-in Jacuzzi</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Built-in Seats</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Built-in Solarium</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Shower</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Deck</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Sunbeds</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Bean Bag Sofa</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Pool Umbrella</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Pool Towels</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Sewing Kit</p></li>
						</ul>
					</div>
				</div>
				<!--  =========COLUMN FOUR END========== --> 
				<div class="col-md-4 col-sm-6 col-12">
					<div class="FeatureTabMain2vila">
						<h1>Living Room</h1>
						<ul>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Air Conditioning</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">TV LCD 44”</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">DVD Player</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Home Theatre</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Speakers</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Audio Bluetooth</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Audio Dock Cable</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Ceiling Fan</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Lounge Sofa</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Bean Bag Sofa</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Arm Chair</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Bar Table</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Hammocks</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Puff</p></li>
						</ul>
					</div>



				</div>
				<!--  =========COLUMN FOUR END========== --> 
				<div class="col-md-4 col-sm-6 col-12">
					<div class="FeatureTabMain2vila">
						<h1>kitchen</h1>
						<ul>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Guest Kitchen</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Separate Staff Kitchen</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Cooking Utensils</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Cutlery</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Crockery</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Clenaing Set</p></li>
						</ul>
					</div>
				</div>
				<!--  =========COLUMN FOUR END========== -->



				<div class="col-md-4 col-sm-6 col-12">
					<div class="FeatureTabMain2vila">
						<h1>TV-Room</h1>
						<ul>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">TV LCD 44”</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">DVD Player</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Home Theatre</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Air Conditioning</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Ceiling Fan</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Fresh Water</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Audio Bluetooth</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Audio Dock Cable</p></li>

						</ul>
					</div>
				</div>
				<!--  =========COLUMN FOUR END========== --> 

				<div class="col-md-4 col-sm-6 col-12">
					<div class="FeatureTabMain2vila">
						<h1>Gazebo</h1>
						<ul>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Ceiling Fan</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Electric Plug</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Sofa</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Coffee Table</p></li>                
						</ul>
					</div>
				</div>
				<!--  =========COLUMN FOUR END========== -->

				<div class="col-md-4 col-sm-6 col-12">
					<div class="FeatureTabMain2vila">
						<h1>Office</h1>
						<ul>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Work table</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Office chair</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Air Conditioning</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Ceiling Fan</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Fresh Water</p></li>

						</ul>
					</div>
				</div>
				<!--  =========COLUMN FOUR END========== -->





				<div class="col-md-4 col-sm-6 col-12">
					<div class="FeatureTabMain2vila">
						<h1>GYM</h1>
						<ul>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Multifunction Bench</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Elliptical Machine</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Stand Bar</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Bench</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Pad & Tools</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Air Conditioning</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">TV LCD 32”</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">DVD Player</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Speaker</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Audio Bluetooth</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Audio Dock Cable</p></li>

						</ul>
					</div>
				</div>
				<!--  =========COLUMN FOUR END========== --> 

				<div class="col-md-4 col-sm-6 col-12">
					<div class="FeatureTabMain2vila">
						<h1>Sauna</h1>
						<ul>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">up to 8 seats</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Timer</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Arhoma Therapy</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Shower</p></li>                
						</ul>
					</div>
				</div>
				<!--  =========COLUMN FOUR END========== -->

				<div class="col-md-4 col-sm-6 col-12">
					<div class="FeatureTabMain2vila">
						<h1>SPA</h1>
						<ul>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Bed Massage</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Sauna up to 8 Seats</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Bathtub</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Shower</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Chromo Therapy</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Arhoma Therapy</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Air Conditioning</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Speaker</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Audio Bluetooth</p></li>
							<li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Audio Dock Cable</p></li>

						</ul>
					</div>
				</div>
				<!--  =========COLUMN FOUR END========== -->



			</div>
		</div>
	</div>

</div>
<!-- Accordion card -->



</div>
<!-- Accordion wrapper -->


</div>

</div>
</div>
</div>



</div>


</div>
</div>


</div>

<!-- =========FEATURES END========== -->
</div>
</div>
</div>
</div>

</div>
<!-- Accordion card -->





<!-- ========MAINE NINE END======= -->
</div>

<!-- ==========COLUMN EIGTH END====== -->
<div class="col-md-3 col-sm-3 col-12">
	<div class="SidebarFrom">
		<form method="post" action="#" id="booking">
			<!-- <p>from 17,471 ₨ per night </p> -->
			<div class="side_new">
				<div class="row">

					<div class="col-md-12 col-sm-12 col-12">
						<div class="form-group BannrGrup mb_20">
							<input type="text" placeholder="Check-IN" class="form-control  " id="start_date" name="start_date" autocomplete="off" readonly="">   
							<label class="lnr lnr-calendar-full" for="start_date"></label> 
						</div>
					</div>
					<div class="col-md-12 col-sm-12 col-12">
						<div class="form-group BannrGrup mb_20">
							<input type="text" placeholder="Check-OUT" class="form-control  " id="end_date" name="end_date" autocomplete="off" readonly=""> 
							<label class="lnr lnr-calendar-full" for="end_date"></label> 
						</div>
					</div>
					<div class="col-md-12 col-sm-12 col-12">
						<div class="form-group BannrGrup mb_20">
							<select name="guests" class="form-control guests" id="SlcGust">
								<option>Guests</option>
								<?php 
								for($i=1;$i<=12;$i++){ ?>
									<option value="<?php echo $i;?>" <?php echo ($i==2)?'selected':''?> ><?php echo $i;?></option>
								<?php }
								?>
							</select>
							<label class="lnr lnr-users" for="SlcGust"></label> 
						</div>
					</div>
					<div id="total_rupees">

					</div>
					<div class="col-md-12 col-sm-12 col-12">
						<div class="form-group BannrGrup mb_20 PixBtnMr1">
							<button type="button" class="btn SubBtn BkNow">Book Now</button>
						</div>
					</div>

					<select class="selector ftNselct currency_select1">
						<option value="dummy" <?php echo ($currency == 'dummy')?'selected':'';?>>Currency </option>
						<?php 
						foreach( $age as $x => $x_value ) { ?>
							<option value="<?php echo $x; ?>" <?php echo ($currency == $x)?'selected':'';?>><?php echo $x." ".$x_value;?></option> 
						<?php } ?>
					</select>
				</div>
				<div class="LoderBook hide">
					<img src="<?php bloginfo('template_url');?>/assets/images/lg.dual-ring-loader.gif" alt="Load" class="img-fluid">
				</div>
				<div class="ConSlideAgn">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-12">
							<div class="form-group BannrGrup mb_20">
								<div class="TabContactSide NwtabCon22">
									<p>Or</p>
									<button type="button" class="btn nwcntct" id ="SidConbtn">Contact Us</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
</div>
</div>
</div>
</section>







<?php 
get_footer();
?>
<script type="text/javascript">
	var nextCheckoutDates = <?php echo json_encode($nextCheckoutDates);?>;
	$(document).on('click','.deleteDates',function(){
		$('#total_rupees').html('');
		$("#start_date").datepicker("option","maxDate", '');
		$("#end_date").datepicker("option","minDate", 0);
		$("#start_date").datepicker("option","minDate", 0);
		$("#start_date").datepicker("refresh");
		$("#end_date").datepicker("refresh");
		$('#start_date').val('');
		$('#end_date').val('');
		$("#start_date").datepicker("hide");
		$("#end_date").datepicker("hide");
		$('.LoderBook').hide();
	});
	$('.LoderBook').hide();
	$(function () {
		var currentTime = new Date();
		var startDates = <?php echo json_encode($alottedRooms);?>;
		var roomPrice = <?php echo json_encode($roomPrice);?>;
		var nextCheckout;
		$("#start_date").datepicker({
			beforeShow: addCustomInformation,
			minDate: 0,
			firstDay: 1,
			onChangeMonthYear: addCustomInformation,
			beforeShowDay: function(date){
				$('.deleteDates').show();
				var month = ( '0' + (date.getMonth()+1) ).slice( -2 );
				var year = date.getFullYear();
				var day = ( '0' + (date.getDate()) ).slice( -2 );
				var newdate = day+"-"+month+'-'+year;
				var dateClass = day+month+year;
				if ($.inArray(newdate, startDates) == -1) {
					addCustomInformation(roomPrice[newdate],dateClass,newdate);
					return [true, dateClass];
				} else {
					return [false, "highlight", "Unavailable"];
				}
			},  
			dateFormat:'dd/mm/yy', 
			onSelect: function(selected) {
				$('.LoderBook').show();
				$('#end_date').val('');
				$("#end_date").datepicker("option","minDate", selected);
				$.ajax({
					data: {startDateSet:1,selected:selected},
					type: 'post',
					dataType: 'json',
					success: function(result) {
						nextCheckout = result.nextCheckout;
					}
				}).done(function(){ 
					checkAvailability();
					$('.LoderBook').hide();
				});

				checkAvailability();
			},
			onClose: function () {
				$('.deleteDates').hide();
			}
		});

//var endDates = <?php //echo json_encode($endDateNew);?>;
var endDates = <?php echo json_encode($alottedRooms);?>;
$("#end_date").datepicker({
	beforeShow: addCustomInformation,
	minDate: 0,
	firstDay: 1,
	onChangeMonthYear: addCustomInformation,
	beforeShowDay: function(date){
		$('.deleteDates').show();
		var month = ( '0' + (date.getMonth()+1) ).slice( -2 );
		var year = date.getFullYear();
		var day = ( '0' + (date.getDate()) ).slice( -2 );
		var newdate = day+"-"+month+'-'+year;
		var dateClass = day+month+year;
		if ($.inArray(newdate, endDates) == -1) {
			addCustomInformation(roomPrice[newdate],dateClass,newdate);
			return [true, dateClass];
		} else {
			if(nextCheckout!=newdate){
				return [false,"highlight", "Unavailable"];
			}else{
				return [true, 'largeDivCal'];
			}
		}
	},  
	dateFormat:'dd/mm/yy', 
	onSelect: function(selected) {
		$("#start_date").datepicker("option","maxDate", selected);
		checkAvailability();
	},
	onClose: function () {
		$('.deleteDates').hide();
	}
});


$('#available').datepicker({
	inline: true,
	beforeShow: addCustomInformation,
	minDate: 0,
	firstDay: 1,
	numberOfMonths: 2,
	onChangeMonthYear: addCustomInformation,
	dateFormat:'dd/mm/yy', 
	beforeShowDay: function(date){
		var month = ( '0' + (date.getMonth()+1) ).slice( -2 );
		var year = date.getFullYear();
		var day  = ( '0' + (date.getDate()) ).slice( -2 );
		var newdate = day+"-"+month+'-'+year;
		var dateClass = day+month+year;
		if ($.inArray(newdate, startDates) == -1) {
			addCustomInformation(roomPrice[newdate],dateClass+'_available',newdate,'_available');
			return [true, dateClass+'_available'];
		} else {
			return [false,"highlight", "Unavailable"];
		}
	}
});
});

	$(document).on('change','.guests',function(){
		checkAvailability();
	});

	var symbol = $('#symbol').val();
	function addCustomInformation(price,dateClass,newdate,available=false) {
		var priceCal;
		var currencyRate = $('#currency_rate').val();
		priceCal = (currencyRate*price).toFixed(1);
		if (($.inArray(newdate, nextCheckoutDates) == -1) && !isNaN(priceCal)) {
			priceCal = numberWithCommas(priceCal);
			if(symbol == 'Array'){
				symbol = 'USD $';
			}
			setTimeout(function() {
				$("."+dateClass).filter(function() {
					var date = $(this).text();
					return /\d/.test(date);
				}).find("a").attr('data-custom', symbol+' '+priceCal);
				if(available){
					$("."+dateClass).addClass('clickdisble');
				}
				/*to show start date highlighted in end date*/
				var start_date = $('#start_date').val();
				if(start_date!=''){
					start_date = start_date.split('/');
					start_date = start_date[0]+start_date[1]+start_date[2];
					if(dateClass==start_date){
						$('.'+dateClass).find("a").addClass('ui-state-active');
					}
				}

			}, 0);
		}else{
			setTimeout(function() {
				$("."+dateClass).find("a").addClass('largeDiv');
			});
		}
	}

	$(document).on('change','.currency_select1',function(){
		$('.LoderBook').show();
		var currency = $(this).val();
		if(currency!=''){
			var option = $('.currency_select1 .item').text();
			$('.currency_select .item').text(option);
			$('.currency_select .item').attr('data-value',currency);
			$('.currency_select11 .item').text(option);
			$('.currency_select11 .item').attr('data-value',currency);
			setCurrency(currency);
		}
	});

	$(document).on('change','.currency_select11',function(){
		var currency = $(this).val();
		if(currency!=''){
			var option = $('.currency_select11 .item').text();
			$('.currency_select .item').text(option);
			$('.currency_select .item').attr('data-value',currency);
			$('.currency_select1 .item').text(option);
			$('.currency_select1 .item').attr('data-value',currency);
			setCurrency(currency);
		}
	});

	rateChange();
	function rateChange(){
		var symbol = $('#symbol').val();
		var currencyRate = $('#currency_rate').val();
		$.ajax({
			data: {currencyRatesSet:1,symbol:symbol,currencyRate:currencyRate},
			type: 'post',
			dataType: 'json',
			success: function(result) {
				$('#ratesSection').html(result.html);
			}
		});
	}

	function setCurrency(currency){
		$.ajax({
			data: {currency:currency,currencySet:1},
			type: 'post',
			dataType: 'json',
			success: function(result) {
				$('#currency_rate').val(result.rates);
				$('#symbol').val(result.symbol);
				symbol = result.symbol;
			}
		}).done(function(){ 
			checkAvailability();
			$('.LoderBook').hide();
			$('#available').datepicker("refresh");
			$('#start_date').datepicker("refresh");
			$('#end_date').datepicker("refresh");
			rateChange();
		});
	}

	function checkAvailability(){
		var symbol = $('#symbol').val();
		var startDate = $('#start_date').val();
		var endDate   = $('#end_date').val();
		if((startDate != '') && (endDate != '')){
			var date1 = $('#start_date').val();
			var date2 = $('#end_date').val();
			var d1 = date1.split("/");
			var d2 = date2.split("/");
			d1 = d1[2]+d1[1]+d1[0];
			d2 = d2[2]+d2[1]+d2[0];
			if (parseInt(d2) > parseInt(d1)) {
				$('.LoderBook').show();
				$.ajax({
					data: $('#booking').serialize(),
					type: 'post',
					dataType: 'json',
					success: function(result) {
						if(result.status == 0){
							var currencyRate = $('#currency_rate').val();
							priceCal = (currencyRate*result.price).toFixed(1);
							var price = result.price.toFixed(2);
							price = numberWithCommas(price);
							var night = 'Night';
							if(result.nights>1){
								night = 'Nights';
							}
							priceCal = numberWithCommas(priceCal);
							if(symbol == 'Array'){
								symbol = 'USD $';
							}
							$('#total_rupees').html('<span style="color:#942424;">'+result.nights+' '+night+' / Total '+symbol+priceCal+'</span>');
							$('.BkNow').prop('disabled',false);
						}else{
							$('.BkNow').prop('disabled',true);
							$('#total_rupees').html('<span style="color:#942424;">The selected days are not available</span>');
						}
						$('.LoderBook').hide();
					}
				});
			}else{
				Ply.dialog("alert",'Check-OUT date should be greater than Check-IN date');
				$('#total_rupees').html('');
			}
		}
	}

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

	$(document).on('click','.BkNow',function(){
		var url = $('#url').val();
		var startDate = $('#start_date').val();
		var endDate   = $('#end_date').val();
		if((startDate != '') && (endDate != '')){
			var date1 = $('#start_date').val();
			var date2 = $('#end_date').val();
			var d1 = date1.split("/");
			var d2 = date2.split("/");
			d1 = d1[2]+d1[1]+d1[0];
			d2 = d2[2]+d2[1]+d2[0];
			if (parseInt(d2) > parseInt(d1)) {
				window.location.href= url+'/booking';
			}
			else{
				Ply.dialog("alert",'Check-OUT date should be greater than Check-IN date');
				$('#total_rupees').html('');
			}
		}else{
			Ply.dialog("alert",'Please select both the dates');
		}
	});
	$(document).on('click','#SidConbtn',function(){
		var url = $('#url').val();
		var startDate = $('#start_date').val();
		var endDate   = $('#end_date').val();
		if((startDate != '') && (endDate != '')){
			var date1 = $('#start_date').val();
			var date2 = $('#end_date').val();
			var d1 = date1.split("/");
			var d2 = date2.split("/");
			d1 = d1[2]+d1[1]+d1[0];
			d2 = d2[2]+d2[1]+d2[0];
			if (parseInt(d2) > parseInt(d1)) {
				window.location.href= url+'/contact';
			}
			else{
				Ply.dialog("alert",'Check-OUT date should be greater than Check-IN date');
				$('#total_rupees').html('');
			}
		}else{
			Ply.dialog("alert",'Please select both the dates');
		}
	});



</script>
<script type="text/javascript">
// $('#thumbs img').click(function(){
//     $('#largeImage').attr('src',$(this).attr('src').replace('thumb','large'));
//     $('#description').html($(this).attr('alt'));
// });

$(".dropplus").click(function(){
	$(this).siblings(".droplus-content").slideToggle();
	$("i", this).toggleClass("fa fa-angle-up fa fa-angle-down");
});


$('.iarrowclick').click(function(){
	$(this).find('i').toggleClass('fa fa-angle-down fa fa-angle-up');
});

$('.iarrowclick22').click(function(){
	$(this).find('i').toggleClass('fa fa-angle-down fa fa-angle-up');
});
</script>

<script>
	$(document).ready(function(){
		$(".viewallbtn_1").click(function(){
			$("#viewsectn-1").show();
			$(this).hide();
		});
		$('.CloseFaceBtn').hide();
	});

	var view = 0;
	$(document).on('click','.viewMoreAmenities',function(){
		view++;
		viewAmenties(view);
	});

	$(document).on('click','.CloseFaceBtn',function(){
		view--;
		viewAmenties(view);
	});

	function viewAmenties(view){
		if(view>=1){
			$('.CloseFaceBtn').show();
		}else{
			$('.CloseFaceBtn').hide();
		}
	}

	$(document).ready(function(){
		$(".viewallbtn_2").click(function(){
			$("#viewsectn-2").show();
			$(this).hide();
		});
	});

	$(document).ready(function(){
		$(".viewallbtn_3").click(function(){
			$("#viewsectn-3").show();
			$(this).hide();
		});
	});
</script>


<script type="text/javascript">
	jQuery(function($) {
		function fixDiv() {
			var $cache = jQuery('.TAbULId');
			if (jQuery(window).scrollTop() >100)
				$cache.css({
					'position': 'sticky',
					'top': '10px'
				});
			else
				$cache.css({
					'position': 'relative',
					'top': 'auto'
				});
		}
		jQuery(window).scroll(fixDiv);
		fixDiv();
	});
</script>

<script type="text/javascript">
	$('.SinglTabArr').owlCarousel({
		loop:true,
		margin:10,
		nav:true,
		 autoplay:true,
    autoplayTimeout:5000,
		responsive:{
			0:{
				items:1
			},
			600:{
				items:1
			},
			1000:{
				items:1
			}
		}, navText: ["<img src='https://www.mingguvillas.com/new/wp-content/uploads/2019/10/arrowSiL.png'>", "<img src='https://www.mingguvillas.com/new/wp-content/uploads/2019/10/arrowSiR.png'>"]
	})
</script>

<script type="text/javascript">
	$(document).ready(function(){   
		$( ".FortbResponsive" ).find( ".ui-datepicker-group-first" ).addClass( "table-responsive" );
		$( ".FortbResponsive" ).find( ".ui-datepicker-group-last" ).addClass( "table-responsive" );
	});
// alert(myVar);

</script>

<script type="text/javascript">
	$(document).ready(function () {
		size_li = $("#myList li").size();
		x=5;
		$('#myList li:lt('+x+')').show();
		$('#loadMoreSv').click(function () {
			x= (x+5 <= size_li) ? x+5 : size_li;
			$('#myList li:lt('+x+')').show();
		});
		$('#showLessSv').click(function () {
			//x=(x-5<0) ? 3 : x-5;
			//$('#myList li').not(':lt('+x+')').hide();
			x=5;
			$('.closeFacilities').hide();
		});
	});
</script>

<script>
$(document).ready(function(){
  // Activate Carousel
  $("#carouselExampleControls").carousel({interval: 3000});

  $("#carouselExampleControls2").carousel({interval: 3000});

  $("#carouselExampleControls3").carousel({interval: 3000});
  $("#carouselExampleControls4").carousel({interval: 3000});
  $("#carouselExampleControls5").carousel({interval: 3000});
  $("#carouselExampleControls6").carousel({interval: 3000});
  $("#carouselExampleControls7").carousel({interval: 3000});
  $("#carouselExampleControls8").carousel({interval: 3000});
  $("#carouselExampleControls9").carousel({interval: 3000});
  $("#carouselExampleControls10").carousel({interval: 3000});
  $("#carouselExampleControls11").carousel({interval: 3000});
   });
</script>



<style type="text/css">
	.FeaUl h4{
		font-size: 12px;
	}
	.FeaUl li p i{
		color: #942424;
	}
	ul.seculli {
		padding-left: 47px;
	}
	ul.seculli li {
		color: #888;
	}
	.viewallbtn_div button {
		background: transparent !important;
		border: none;
		color: #942424 !important;
		text-transform: capitalize;
		padding-left: 0px;
		padding-top: 10px;
		font-size: 13px;
		cursor: pointer;
	}
	.SinglTabArr .item {
		height: 485px;
		background-size: cover;
		background-position: center;
	}
	.SinglTabArr .owl-nav {
		display: block;
	}
	.SinglTabArr .owl-nav .owl-prev {
		background: unset;
		color: #888;
		background: unset;
		color: #f7f7f7;
		position: absolute;
		top: 34%;
		left: 1px;
		font-size: 80px;
	}
	.SinglTabArr .owl-nav .owl-next {
		background: unset;
		color: #888;
		background: unset;
		color: #f7f7f7;
		position: absolute;
		top: 34%;
		right: 1px;
		font-size: 80px;
	}
	.SinglTabArr .owl-nav .owl-next:hover {
		background: unset;
	}
	.SinglTabArr .owl-nav .owl-prev:hover {
		background: unset;
		color: #FFF;
		text-decoration: none;
	}
	.SinglTabArr .owl-dots {
		display: none;
	}
	.SinglTabArr .owl-prev img, .SinglTabArr .owl-next img {
		width: 100%;
		max-width: 45px;
	}
	a.MenuPdf {
		color: #942424;
	}
	.galdesvideo iframe{
		height: 515px;
	}
	.page-id-356 .SidebarFrom {
		padding: 0px 20px 2px 20px;
	}

.faq_ins.forabvilaFaqins .accordion .card h5 {
	color: #888;
	text-transform: uppercase;
	font-weight: bold;
	position: relative;
	padding-left: 40px;
	padding-right: 20px;
}
.faq_ins.forabvilaFaqins .accordion .card h5 svg {
	position: absolute;
	left: 0;
	top: -2px;
}
.faq_ins.forabvilaFaqins .accordion .card h5:hover {
	color: #942424;
}
.card-header a:hover {
	color: #942424;
}
div.card.carddesign:last-child{
	border-bottom: 1px solid rgba(0,0,0,.125);
}
.card-body p.OutImg2 {
	/*text-align: center;*/
	font-size: 12px !important;
	text-transform: uppercase;
	font-weight: bold;
	margin-bottom: 15px;
}
.faq_ins.forabvilaFaqins .OutCenter2 svg {
	position: relative;
	top: 8px;
}
.SeasonTable th {
	/* color: #353232;*/
	text-transform: uppercase;
}
.ViewSIngNw {
	float: right !important;
}
.SingGray1{
	color: #888;
}
.ChkInPaE span {
    color: #888;
    font-size: 17px;
    font-weight: bold;
}

.ChkInPaE {
    margin-top: 15px;
    margin-bottom: 17px;
}	
.brdrWmrgin{
	/*border: 2px solid #222;*/
	margin-bottom: 22px;
}

.kidsageul li {
	position: relative;
	padding-left: 20px;
	color: #888;
	margin-bottom: 7px;
}
.kidsageul li i {
	position: absolute;
	left: 0;
	color: #888;
	top: 6px;
	font-size: 10px;
}
.kidsageul li a{
	color: #888;
}
.abnewSinglLity div#available {
	width: 97%;
}
.FeatureTabMain2 .card-header {
	padding: 0px 20px;
	line-height: 0;
}
.card-body.InnerCardFeat {
	padding: 10px 25px;
}	
.card-body.InnerCardFeat h1 {
	font-size: 15px;
	color: #888;
	text-transform: uppercase;
	margin-bottom: 10px;
	font-weight: bold;
}
.FeatureTabMain2vila ul li p {
	position: relative;
	padding-left: 26px;
	font-size: 13px;
}
.FeatureTabMain2vila ul li p img {
	position: absolute;
	left: -4px;
	width: 100%;
	max-width: 20px;
	top: 2px;
}
.FeatureTabMain2vila h1 a{
	font-size: 12px;
	color: #942424;
	margin-left: 10px;
}
h5.mb-0.Mbimgsh {
	font-size: 13px !important;
	padding-left: 36px;
	position: relative;
	line-height: 24px;
}
.Mbimgsh img {
	width: 22px;
	position: absolute;
	top: 3px;
	left: 0;
}
/*======30-09-19======*/
.ForTxtCapH {
	text-transform: capitalize;
}
ul.seculli li {
	margin-bottom: 5px;
	font-size: 13px;
}
.faq_ins.forabvilaFaqins .accordion .card h5:hover i {
	color: #942424;
}
.CloseFaceBtn{
	float: right;
}
.StiBlokBar {
	position: sticky;
	top: 55px;
	z-index: 999;
	background: #fff;
}
p.LoCPBol {
	/*padding-top: 12px;*/
	padding-left: 12px;
}
.forbedmin{
	min-height: 112px;
}
.RateTerm a {
    color: #942424;
    transition: all 0.5s;
    margin: 28px 10px 17px 43px;
    display: block;
}
.RateTerm a:hover{
	text-decoration: underline;
}
.SesonTpa{
	padding: 35px 25px 18px 30px;
	text-align: center;
	display: table;
}
.SesonTpa tr td {
	text-transform: capitalize;
}
.rightaliUL{
	padding: 6px 8px;
}
.RatepadinAl {
	padding: 35px 40px;
}
.faq_ins.forabvilaFaqins p.forChkBold {
	font-size: 17px !important;
}
.EqualTbUlCell {
	display: table;
	width: 100%;
}
.FeatureTab2 .EqualTbUlCell li {
	display: table-cell ;
}
.FeatureTabMain2 .card-header {
	padding: 0px 20px;
}
#myList li{ 
	display:none;
}
button#loadMoreSv {
	margin: 0;
}
ul#myList {
	margin: 0;
	/* padding: 9px; */
}
.viewallbtn_div {
	background-color: #fff;
	padding: 0px 24px 24px 24px;
	margin-bottom: 30px;
}
.SinglChkBOxag{
	display: none;
}
.kidsageul li a {
	color: #942424;
}
.MobChkPdall{
	padding-left: 5px; 
	padding-right: 5px;
}
.TRIALICON h6 {
    font-weight: bold;
    text-align: center;
    margin-bottom: 15px;
}
.TRIALICON ul li p {
    position: relative;
    padding-left: 60px;
}
.TRIALICON ul li p img {
    position: absolute;
    left: 0;
}
.faq_ins.forabvilaFaqins .FeatureTabMain2 .accordion .card h5 {
    padding-left: 40px;
    padding-right: 0px;
}
.FeatureTabMain2 .card {
    border-left: 0;
    border-right: 0;
}
ul.EqualTbUlCell {
    background: #fff;
}
ul.OneUlC p.Private2spc {
    margin-bottom: 4px;
}
.RateTCont.Rate97 p {
    margin-bottom: 10px;
}
.GaHeding h1 span {
    color: #888;
    font-size: 13px;
}
.SesonTpa tr td {
    color: #888;
    font-size: 14px;
}
.KidWepri{
	text-transform: uppercase;
}
.AirportP{
	letter-spacing: 0px !important;
}
/*======30-09-19======*/


/*============MEDIA QUERY CSS 767==========*/
@media only screen and (max-width: 767px){
	.SeasonTable th{
		vertical-align: middle !important;
		line-height: 17px;
	}
	.abnewSinglLity div#available .ui-datepicker-multi .ui-datepicker-group table::after{
		position: unset;
	}
	.abnewSinglLity .ui-datepicker-multi-2 .ui-datepicker-group {
		width: 100%;
	}
	.SeasonTable tr td{
		/* color: #353232;*/
		text-align: center;
	}
	td.FromTdM {
		min-width: 115px !important;
		text-align: left !important;
	}
	.SesonTpa {
		display: block;
	}
	.SinglChkBOxag{
		display: block;
	}
	.page-id-356 .SidebarFrom.SingSideABVila {
    padding: 0px 13px 2px 14px;
}
.SingSideABVila form#booking .BannrGrup label {
     right: 8px;
    font-size: 11px;
    top: 14px;
}
.SingSideABVila form#booking .BannrGrup input {
    padding: 7px;
    font-size: 12px;
}
.FeatureTab2 .EqualTbUlCell li {
    display: inline-block;
    max-width: 100px;
    padding: 6px 4px 6px 4px;
}
.DesVideo.galdesvideo.abgalvideo {
    height: 237px;
}
.DesVideo.galdesvideo.abgalvideo p {
    height: 100%;
}
.galdesvideo.abgalvideo iframe {
    height:100% !important;
}
.TAbULId ul.MainWidth-ul {
    margin: 0;
    padding: 0px;
    display: block;
    width: 100%;
    max-width: 299px;
    margin: 0px auto;
    text-align: left;
    padding: 0px 10px 0px 10px;
}
.TAbULId ul li {
    display: inline-block;
    width: 100%;
    /*max-width: 78px;*/
    /* margin: 0px auto; */
    text-align: left;
    padding: 3px 0px;
}
.MainWidth-ul li.MaxwiLi1{
	max-width: 45px; 
}
.MainWidth-ul li.MaxwiLi2{
	max-width: 75px; 
}
.MainWidth-ul li.MaxwiLi3{
	max-width: 72px; 
}
.MainWidth-ul li.MaxwiLi4{
	max-width: 56px; 
}
.MainWidth-ul li.MaxwiLi5{
	max-width: 45px; 
}
.MainWidth-ul li.MaxwiLi6{
	max-width: 76px; 
}
.MainWidth-ul li.MaxwiLi7{
	max-width: 67px; 
}
.MainWidth-ul li.MaxwiLi8{
	max-width: 55px; 
}
ul.MainWidth-ul li a {
    font-size: 10px;
    font-weight: bold;
}
form#booking button.btn.SubBtn.BkNow {
    float: unset;
    font-size: 14px;
    padding-bottom: 8px;
    padding-top: 8px;
}
.TotRu109{
    margin-bottom: 0px !important;
}
.TotRu109 p {
    margin-bottom: 6px;
    color: #942424;
}
.faq_ins.forabvilaFaqins .accordion .card h5 i {
    position: relative;
    top: -5px;
}
.forabvilaFaqins .carddesign .card-header {
    padding: 9px 3px 4px 7px;
}
.faq_ins.forabvilaFaqins .accordion .card h5 {
    padding-top: 5px;
    font-size: 12px;
}
.RatepadinAl {
    padding: 12px 0px;
}
p.LoCPBol {
    padding-left: 4px;
}
.rightaliUL {
    padding: 6px 0px;
}
.faq_ins.forabvilaFaqins .rightaliUL p{
	    font-size: 11px !important;
	line-height: 25.2px;
}
.faq_ins.forabvilaFaqins svg {
    height: 24px;
    width: 24px;
    margin-right: 7px;
}
}
/*============MEDIA QUERY CSS==========*/
</style>