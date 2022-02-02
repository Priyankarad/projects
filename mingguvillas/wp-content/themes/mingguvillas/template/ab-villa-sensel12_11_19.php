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
            $date = get_sub_field('villats_rates_section_title_two',356);
            $fromToDate = explode(' - ',$date);
            $from = date('j-M',strtotime($fromToDate[0]));
            $to = date('j-M',strtotime($fromToDate[1]));
            $seasonRate = get_sub_field('villats_rates_section_title_three',356);
            $rate = $currencyRate*$seasonRate;
            $rate = $symbol.number_format($rate,1);
            $html.='<tr>
            <td class="FromTdM">From '.$from.' to '.$to.'</td>
            <td>'.get_sub_field('villats_rates_section_title_one',356).'</td>
            <td>'.get_sub_field('night',356).' night</td>
            <td data-title="Daily">'.$rate.'</td>
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
                    <div class="NineNewOne">
                        <div class="TabSlider">
                            <div class="owl-carousel owl-theme SinglTabArr">
                                <?php
// check if the repeater field has rows of data
                                if( have_rows('my_villa_overview_section_one',356) ):
// loop through the rows of data
                                    while ( have_rows('my_villa_overview_section_one',356) ) : the_row();
// display a sub field value
                                        ?>
                                        <div class="item" style="background-image: url(<?php the_sub_field('my_villa_overview_section_one_image',356); ?>);">
                                        </div>
                                        <?php
                                    endwhile;

                                else :

// no rows found

                                endif;

                                ?>
                                <!-- ======ITEM END===== -->
                            </div>
                        </div>
                        <!-- ========SLIDER END======= -->
                        <div class="TabHeading">
                            <h1 class="villainner_heading"><?php the_field('my_villa_first_section_title_one',356); ?></h1>
                            <!--  <p><span class="lnr lnr-map-marker"></span><?php the_field('my_villa_first_section_title_two',356); ?></p> -->
                        </div>

                        <div class="OneulcDivide">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="FiveDivdedUl">
                                        <ul class="OneUlC" id="myList">
                                            <div class="mainFive">
                                                <li>
                                                    <p>
                                                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
                                                            <style type="text/css">
                                                                .st0{fill:none;}
                                                                .st1{fill:#952524;}
                                                            </style>
                                                            <rect class="st0" width="32" height="32"/>
                                                            <g>
                                                                <path class="st1" d="M7.3,17.5c2.5,0,4.6-2.1,4.6-4.6c0-2.5-2.1-4.6-4.6-4.6c-2.5,0-4.6,2.1-4.6,4.6C2.7,15.4,4.8,17.5,7.3,17.5z
                                                                M7.3,9.3c2,0,3.6,1.6,3.6,3.6c0,2-1.6,3.6-3.6,3.6c-2,0-3.6-1.6-3.6-3.6C3.7,10.9,5.3,9.3,7.3,9.3z"/>
                                                                <path class="st1" d="M20.5,16.1c3.3,0,6.1-2.7,6.1-6.1c0-3.3-2.7-6.1-6.1-6.1c-3.3,0-6.1,2.7-6.1,6.1
                                                                C14.5,13.3,17.2,16.1,20.5,16.1z M20.5,4.9c2.8,0,5.1,2.3,5.1,5.1c0,2.8-2.3,5.1-5.1,5.1c-2.8,0-5.1-2.3-5.1-5.1
                                                                C15.5,7.2,17.8,4.9,20.5,4.9z"/>
                                                                <path class="st1" d="M20.5,18.4c-6.6,0-11.4,3.3-11.4,7.9c0,1,0.8,1.8,1.8,1.8h19.2c1,0,1.8-0.8,1.8-1.8
                                                                C31.9,21.7,27.1,18.4,20.5,18.4z M30.1,27.1H11c-0.4,0-0.8-0.4-0.8-0.8c0-3.9,4.4-6.8,10.4-6.9h0c5.7,0,10.4,3.1,10.4,6.9
                                                                C30.9,26.7,30.6,27.1,30.1,27.1z"/>
                                                                <polygon points="20.5,19.5 20.5,19.5 20.5,19.5  "/>
                                                                <path class="st1" d="M1.7,27.2c-0.4,0-0.7-0.3-0.7-0.7c0-3.5,3.9-6,9.4-6.1l0,0c0.3-0.3,0.8-0.7,1.4-1c-0.5,0-1-0.1-1.4-0.1
                                                                c-6,0-10.3,3-10.3,7.2c0,0.9,0.7,1.6,1.6,1.6h6.4c-0.2-0.3-0.3-0.7-0.3-0.9H1.7z"/>
                                                            </g>
                                                        </svg>
                                                        10Guests
                                                    </p>
                                                </li>
                                                <li>
                                                    <p>
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
                                                    5 Bedroom - 6 Bathrooms
                                                </p>
                                            </li>
                                            <li>
                                                <p>
                                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                    width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
                                                    <style type="text/css">
                                                        .st0{fill:none;}
                                                        .st1{fill:#952524;}
                                                    </style>
                                                    <rect class="st0" width="32" height="32"/>
                                                    <g>
                                                        <path class="st1" d="M29.7,22L25,19.8l4-1.4c0.1,0,0.2-0.1,0.3-0.3c0.1-0.1,0.1-0.3,0-0.4c-0.1-0.3-0.4-0.4-0.6-0.3l-5,1.7L17,15.9
                                                        l6.3-4l5.2,1.1c0.1,0,0.3,0,0.4-0.1c0.1-0.1,0.2-0.2,0.2-0.3c0-0.1,0-0.3-0.1-0.4c-0.1-0.1-0.2-0.2-0.3-0.2l-4.2-0.9l4.5-2.8
                                                        c0.2-0.1,0.3-0.4,0.1-0.7c-0.1-0.1-0.2-0.2-0.3-0.2c-0.1,0-0.3,0-0.4,0.1l-4.5,2.8l1-4.2c0-0.1,0-0.3-0.1-0.4
                                                        c-0.1-0.1-0.2-0.2-0.3-0.2c-0.1,0-0.3,0-0.4,0.1c-0.1,0.1-0.2,0.2-0.2,0.3l-1.2,5.2l-6.3,4l-0.1-7.4l3.7-3.8
                                                        c0.1-0.1,0.2-0.2,0.1-0.3c0-0.1-0.1-0.3-0.1-0.3C20,3.1,19.9,3,19.7,3h0c-0.1,0-0.3,0.1-0.3,0.1l-3,3.1L16.3,1
                                                        c0-0.1-0.1-0.3-0.1-0.3c-0.1-0.1-0.2-0.1-0.3-0.1h0c-0.3,0-0.5,0.2-0.5,0.5l0.1,5.3l-3.1-3c-0.1-0.1-0.2-0.1-0.3-0.1h0
                                                        c-0.1,0-0.3,0.1-0.3,0.1c-0.2,0.2-0.2,0.5,0,0.7l3.8,3.7l0.1,7.5L8.8,12L7,7C6.9,6.8,6.6,6.7,6.3,6.7C6.1,6.8,6,7.1,6,7.4l1.4,4
                                                        L2.7,9.1C2.6,9,2.4,9,2.3,9.1C2.2,9.1,2.1,9.2,2,9.3c0,0.1,0,0.1,0,0.2C2,9.7,2.1,9.9,2.3,10l4.9,2.3L3,13.7
                                                        c-0.3,0.1-0.4,0.4-0.3,0.6c0,0.1,0.1,0.2,0.2,0.3c0.1,0.1,0.2,0.1,0.4,0l5-1.8l6.6,3.2l-6.2,4l-5.2-1.1c-0.1,0-0.3,0-0.4,0.1
                                                        C3.1,19.1,3,19.2,3,19.3c0,0.1,0,0.3,0.1,0.4c0.1,0.1,0.2,0.2,0.3,0.2l4.2,0.9l-4.5,2.9c-0.2,0.1-0.3,0.4-0.1,0.7
                                                        c0.1,0.2,0.4,0.3,0.7,0.1l4.5-2.9l-0.9,4.2c0,0.1,0,0.3,0.1,0.4c0.1,0.1,0.2,0.2,0.3,0.2c0.1,0,0.3,0,0.4-0.1
                                                        C8,26.3,8.1,26.2,8.1,26l1.2-5.2l6.2-4l0.1,7.4l-3.7,3.8c-0.1,0.1-0.1,0.2-0.1,0.3c0,0.1,0.1,0.3,0.1,0.3c0.1,0.1,0.2,0.1,0.3,0.1
                                                        c0,0,0,0,0,0c0.1,0,0.3-0.1,0.3-0.1l3-3.1l0.1,5.4c0,0.3,0.2,0.5,0.5,0.5h0c0.3,0,0.5-0.2,0.5-0.5l-0.1-5.3l3.1,3
                                                        c0.2,0.2,0.5,0.2,0.7,0l0,0v0c0.1-0.1,0.1-0.2,0.1-0.3c0-0.1-0.1-0.3-0.1-0.3l-3.8-3.7l-0.1-7.5l6.8,3.2l1.8,5
                                                        c0.1,0.3,0.4,0.4,0.6,0.3c0.1,0,0.2-0.1,0.3-0.3c0.1-0.1,0.1-0.3,0-0.4l-1.5-4.1l4.8,2.3c0.2,0.1,0.5,0,0.7-0.2
                                                        c0.1-0.1,0.1-0.3,0-0.4C29.9,22.2,29.9,22.1,29.7,22"/>
                                                    </g>
                                                </svg>
                                                Air Conditioning
                                            </p>
                                        </li>
                                        <li>
                                            <p>
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
                                                <style type="text/css">
                                                    .st0{fill:none;}
                                                    .st1{fill:#952524;}
                                                </style>
                                                <rect class="st0" width="32" height="32"/>
                                                <path class="st1" d="M29.5,17.4L19,11.1v-5L19,6C18.5,2.2,17,1,16.4,0.6l0,0l0,0c-0.2-0.1-0.6-0.1-0.8,0l0,0C15,1,13.5,2.2,13,6
                                                l0,5.1L2.5,17.4C1.5,18,0.9,19,0.9,20.1v2.4l12.1-4.2v1.4c0,0.3,0,1.5,0.9,7.1l-2.6,2l0,0v2.7h9.3v-2.7L18,26.8
                                                c0.9-5.6,0.9-6.8,0.9-7.1v-1.4L31,22.4l0.1,0v-2.4C31.1,19,30.5,18,29.5,17.4z M29,18.3c0.6,0.4,1,1.1,1,1.8v1L18,16.9l-0.1,0l0,2.9
                                                c0,0,0,1-1,7.2l0,0.3l2.7,2.1v1.2h-7.3v-1.2l2.7-2.1l0,0l0-0.3c-1-6.1-1-7.1-1-7.2l0-2.8l0-0.1L1.9,21.1v-1c0-0.7,0.4-1.4,1-1.8
                                                l11-6.6l0.1,0V6.3c0-0.1,0-0.3,0-0.4c0.4-2.6,1.2-3.8,1.7-4.2c0,0,0,0,0.1-0.1c0.1-0.1,0.2-0.1,0.4,0c0,0,0.1,0,0.1,0.1
                                                c0.5,0.4,1.3,1.5,1.7,4.2c0,0.1,0,0.2,0,0.4v5.4L29,18.3z"/>
                                            </svg>
                                            Airport Transfer Service (9,7 Km)
                                        </p>
                                    </li>
                                    <li>
                                        <p>
                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                            width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
                                            <style type="text/css">
                                                .st0{fill:none;}
                                                .st1{fill:#952524;}
                                            </style>
                                            <rect class="st0" width="32" height="32"/>
                                            <g>
                                                <path class="st1" d="M3.1,12c0.1,0.1,0.2,0.1,0.3,0.1c0,0,0.1,0,0.1,0c0.1,0,0.3-0.1,0.3-0.3l-0.1,0l0.1,0c0.1-0.2,0-0.5-0.2-0.6
                                                c-0.2-0.2-0.5-0.4-0.5-0.7c-0.1-0.6,0.5-1.3,1.6-2c1.2-0.9,1.7-1.7,1.6-2.6C6.2,4.7,5.2,4,4.5,3.6c-0.1-0.1-0.3-0.1-0.4,0
                                                C4,3.7,3.9,3.8,3.8,3.9c-0.1,0.2,0,0.5,0.2,0.6c0.3,0.2,1.3,0.7,1.3,1.4c0.1,0.6-0.6,1.3-1.2,1.7c-1.4,1-2.1,2-2,2.9
                                                C2.3,11.3,2.7,11.7,3.1,12"/>
                                                <path class="st1" d="M8.2,12c0.1,0.1,0.2,0.1,0.3,0.1c0,0,0.1,0,0.1,0c0.1,0,0.3-0.1,0.3-0.3v0c0.1-0.2,0-0.5-0.2-0.6
                                                c-0.2-0.2-0.5-0.4-0.5-0.7c-0.1-0.6,0.5-1.3,1.6-2c1.2-0.9,1.7-1.7,1.6-2.6C11.4,4.7,10.3,4,9.7,3.6c-0.1-0.1-0.3-0.1-0.4,0
                                                C9.2,3.7,9.1,3.8,9,3.9C8.9,4.1,9,4.4,9.3,4.5c0.3,0.2,1.2,0.7,1.3,1.4c0.1,0.6-0.6,1.3-1.2,1.7c-1.4,1-2.1,2-2,2.9
                                                C7.4,11.3,7.9,11.7,8.2,12"/>
                                                <path class="st1" d="M13.1,12c0.1,0.1,0.2,0.1,0.3,0.1c0,0,0.1,0,0.1,0c0.1,0,0.3-0.1,0.3-0.3l-0.1,0l0.1,0c0.1-0.2,0-0.5-0.2-0.6
                                                c-0.2-0.2-0.4-0.4-0.5-0.7c-0.1-0.6,0.5-1.3,1.6-2c1.2-0.9,1.7-1.7,1.6-2.6c-0.1-1.1-1.2-1.8-1.9-2.1c-0.1-0.1-0.3-0.1-0.4,0
                                                c-0.1,0-0.2,0.1-0.3,0.3l0,0c-0.1,0.2,0,0.5,0.2,0.6c0.3,0.2,1.3,0.7,1.3,1.4c0.1,0.6-0.6,1.3-1.2,1.7c-1.4,1-2.1,2-2,2.9
                                                C12.3,11.3,12.8,11.7,13.1,12"/>
                                                <path class="st1" d="M28.9,5.6c-0.3-0.2-0.7-0.2-1.1-0.2h-7.6c-0.3,0-0.5,0.2-0.5,0.5c0,0.3,0.2,0.5,0.5,0.5h7.6
                                                c0.3,0,0.5,0,0.7,0.1c0.7,0.3,1.9,1.1,2,2.7c0.2,2.2-1.5,3-1.6,3l-0.3,0.1v15.1h-6.8c-0.3,0-0.5,0.2-0.5,0.5c0,0.3,0.2,0.5,0.5,0.5
                                                h7.8V13c1.1-0.6,2.1-1.9,1.9-3.9C31.3,7,29.8,6,28.9,5.6"/>
                                                <rect x="20.4" y="9.4" class="st1" width="1" height="1"/>
                                                <rect x="24.5" y="9.4" class="st1" width="1" height="1"/>
                                                <rect x="20.4" y="13.3" class="st1" width="1" height="1"/>
                                                <rect x="24.5" y="13.3" class="st1" width="1" height="1"/>
                                                <path class="st1" d="M18.4,18.5h-0.8c0-0.4,0.1-0.9,0.1-1.3c0-0.2,0-0.3,0-0.5c0-0.1,0-0.2,0-0.3l0-0.2H0.5l0,0.2
                                                c0,0.1,0,0.2,0,0.3c0,0.1,0,0.3,0,0.4l0,0c0.1,3.7,1.5,7.1,3.8,9.2c0,0,4.5,4.3,9.5,0c0.6-0.6,1.2-1.3,1.7-2.1h2.8
                                                c1.6,0,2.9-1.3,2.9-2.9C21.3,19.8,20,18.5,18.4,18.5 M9.1,27.3c-4.1,0-7.4-4.4-7.6-10.1h15.2C16.5,22.9,13.1,27.3,9.1,27.3
                                                M18.4,23.3h-2.3c0.6-1.2,1-2.5,1.3-3.9h1c1.1,0,1.9,0.9,1.9,1.9C20.3,22.4,19.5,23.3,18.4,23.3"/>
                                            </g>
                                        </svg>
                                        Breakfast <a href="#" class="MenuPdf">(see the Menu)</a> 
                                    </p>
                                </li>
                            </div>


                            <div class="FIve16li sixteenLi">

                                <li class="closeFacilities">
                                    <p>
                                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                        width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
                                        <style type="text/css">
                                            .st0{fill:none;}
                                            .st1{fill:#952524;}
                                        </style>
                                        <rect class="st0" width="32" height="32"/>
                                        <g>
                                            <path class="st1" d="M16,16.2c2.6,0,4.7-2.1,4.7-4.7c0-2.6-2.1-4.7-4.7-4.7c-2.6,0-4.7,2.1-4.7,4.7C11.3,14,13.4,16.2,16,16.2
                                            M16,7.7c2,0,3.7,1.7,3.7,3.7c0,2-1.7,3.7-3.7,3.7c-2,0-3.7-1.7-3.7-3.7C12.3,9.4,14,7.7,16,7.7"/>
                                            <path class="st1" d="M16,17.6c-5.1,0-8.8,2.6-8.8,6.1c0,0.8,0.7,1.5,1.5,1.5h14.5c0.8,0,1.5-0.7,1.5-1.5
                                            C24.8,20.2,21.1,17.6,16,17.6 M23.3,24.3H8.7c-0.3,0-0.5-0.2-0.5-0.5c0-2.9,3.3-5,7.7-5.1c4.3,0,7.7,2.3,7.7,5.1
                                            C23.7,24,23.5,24.3,23.3,24.3"/>
                                            <path class="st1" d="M6.1,17.3c2,0,3.6-1.6,3.6-3.6c0-2-1.6-3.6-3.6-3.6c-2,0-3.6,1.6-3.6,3.6C2.4,15.6,4.1,17.3,6.1,17.3 M6.1,11
                                            c1.4,0,2.6,1.2,2.6,2.6c0,1.4-1.2,2.6-2.6,2.6c-1.4,0-2.6-1.2-2.6-2.6C3.5,12.2,4.6,11,6.1,11"/>
                                            <path class="st1" d="M6.6,24.4L6.6,24.4l-4.8-0.1c-0.2,0-0.4-0.2-0.4-0.4c0-2.6,2.9-4.4,7-4.5h0l0,0c0.3-0.2,0.7-0.6,1.2-0.9
                                            l0.2-0.1l-0.3,0c-0.5,0-0.8-0.1-1.2-0.1c-4.6,0-8,2.3-8,5.6c0,0.8,0.6,1.4,1.4,1.4h5.1l-0.1-0.1C6.7,24.9,6.6,24.6,6.6,24.4"/>
                                            <path class="st1" d="M25.9,17.3c2,0,3.6-1.6,3.6-3.6c0-2-1.6-3.6-3.6-3.6c-2,0-3.6,1.6-3.6,3.6C22.3,15.6,23.9,17.3,25.9,17.3
                                            M25.9,11c1.4,0,2.6,1.2,2.6,2.6c0,1.4-1.2,2.6-2.6,2.6c-1.4,0-2.6-1.2-2.6-2.6C23.3,12.2,24.5,11,25.9,11"/>
                                            <path class="st1" d="M23.6,18.3c-0.4,0-0.8,0-1.2,0.1l-0.3,0l0.2,0.1c0.5,0.3,0.9,0.6,1.2,0.9l0,0l0,0c4.1,0.1,7,1.9,7,4.5
                                            c0,0.2-0.2,0.4-0.4,0.4h-4.8l0,0.1c0,0.2-0.1,0.5-0.3,0.8l-0.1,0.1h5.1c0.8,0,1.4-0.6,1.4-1.4C31.6,20.7,28.2,18.3,23.6,18.3"/>
                                        </g>
                                    </svg>
                                    Extra Guests: Available with extra charge <a href="#" class="MenuPdf">(see the Details)</a>
                                </p>
                            </li>
                            <li class="closeFacilities">
                                <p>
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
                                    <style type="text/css">
                                        .st0{fill:none;}
                                        .st1{fill:#952524;}
                                    </style>
                                    <rect class="st0" width="32" height="32"/>
                                    <g>
                                        <path class="st1" d="M16,11.7c2.3,0,4.2-1.9,4.2-4.2S18.3,3.2,16,3.2s-4.2,1.9-4.2,4.2S13.7,11.7,16,11.7z M12.7,7.4
                                        c0-1.8,1.5-3.3,3.3-3.3s3.3,1.5,3.3,3.3s-1.5,3.3-3.3,3.3S12.7,9.2,12.7,7.4z"/>
                                        <path class="st1" d="M21.6,18.6c0.3,0.3,0.8,0.5,1.2,0.6c0.6,0.1,1.1-0.1,1.5-0.5c0.4-0.4,0.6-0.9,0.5-1.5c0-0.4-0.2-0.8-0.6-1.2
                                        l-4.2-4.2c-0.2-0.2-0.5-0.2-0.7,0c-0.2,0.2-0.2,0.5,0,0.7l4.2,4.2c0.2,0.2,0.3,0.3,0.3,0.5c0,0.3-0.1,0.5-0.3,0.7
                                        c-0.2,0.2-0.5,0.3-0.7,0.3c-0.2,0-0.4-0.1-0.5-0.3L20,15.6c-0.1-0.1-0.4-0.2-0.5-0.1c-0.2,0.1-0.3,0.3-0.3,0.5v2.8h-6.2v-2.8
                                        c0-0.2-0.1-0.4-0.3-0.5c-0.2-0.1-0.4,0-0.5,0.1l-2.3,2.3c-0.2,0.2-0.3,0.3-0.5,0.3c-0.3,0-0.5-0.1-0.7-0.3
                                        c-0.2-0.2-0.3-0.5-0.3-0.7c0-0.2,0.1-0.4,0.3-0.5l4.2-4.2c0.1-0.1,0.1-0.2,0.1-0.3c0-0.1-0.1-0.2-0.1-0.3c-0.2-0.2-0.5-0.2-0.7,0
                                        L7.8,16c-0.3,0.3-0.5,0.8-0.6,1.2c0,0.5,0.1,1.1,0.5,1.5c0.4,0.4,0.9,0.6,1.5,0.5c0.4,0,0.8-0.2,1.2-0.6l1.5-1.5v3.2l-2.2,2.2
                                        c-0.8,0.8-0.8,2-0.2,2.9l2,2.7c0.2,0.3,0.6,0.6,0.9,0.7c0.2,0.1,0.5,0.1,0.7,0.1c0.8,0,1.6-0.5,1.9-1.3c0.3-0.7,0.1-1.5-0.4-2.1
                                        L14,24.6c0,0,0-0.1,0-0.1l0.7-0.6c0.4,0.1,0.8,0.2,1.2,0.2v0l0.3,0c0.4,0,0.8-0.1,1.3-0.2l0.7,0.6c0,0,0,0.1,0,0.1l-0.7,0.9
                                        c-0.5,0.6-0.7,1.4-0.4,2.1c0.3,0.8,1,1.3,1.9,1.3c0.2,0,0.5,0,0.7-0.1c0.3-0.1,0.7-0.4,0.9-0.7l2-2.7c0.7-0.9,0.6-2.1-0.2-2.9
                                        l-2.2-2.2l0-3.2L21.6,18.6z M18,26.1l1.2-1.4c0.1-0.2,0.1-0.4,0-0.5l-0.9-0.8c0.7-0.5,1.3-1.2,1.5-2l1.8,1.8
                                        c0.4,0.4,0.5,1.1,0.1,1.6l-2,2.7c-0.2,0.2-0.4,0.4-0.6,0.4c-0.3,0.1-0.7,0-0.9-0.3C17.7,27.2,17.7,26.5,18,26.1z M19.1,20
                                        c0,1.7-1.4,3.1-3.1,3.1c-1.7,0-3.1-1.4-3.1-3.1c0-0.1,0-0.2,0-0.3H19C19.1,19.8,19.1,19.9,19.1,20z M12.8,24.7l1.2,1.4
                                        c0.4,0.4,0.3,1.1,0,1.5c-0.2,0.2-0.6,0.3-0.9,0.3c-0.2-0.1-0.5-0.2-0.6-0.4l-2-2.7c-0.4-0.5-0.3-1.2,0.1-1.6l1.8-1.8
                                        c0.3,0.8,0.8,1.5,1.5,2l-0.9,0.8C12.7,24.3,12.7,24.5,12.8,24.7z"/>
                                    </g>
                                </svg>
                                Extra Kids: 0 to 6: free of charge; 7 to 14: discounted rate. <a href="#" class="MenuPdf">(see the Details)</a>
                            </p>
                        </li>
                        <li class="closeFacilities">
                            <p>
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
                                <style type="text/css">
                                    .st0{fill:none;}
                                    .st1{fill:#952524;}
                                </style>
                                <rect class="st0" width="32" height="32"/>
                                <g>
                                    <path class="st1" d="M26.6,0.5H5.4c-2.7,0-4.8,2.2-4.8,4.8v21.3c0,2.7,2.2,4.8,4.8,4.8h21.3c2.7,0,4.8-2.2,4.8-4.8V5.4
                                    C31.5,2.7,29.3,0.5,26.6,0.5 M30.3,5.4v21.3c0,2-1.7,3.7-3.7,3.7H5.4c-2,0-3.7-1.7-3.7-3.7V5.4c0-2,1.7-3.7,3.7-3.7h21.3
                                    C28.7,1.7,30.3,3.3,30.3,5.4"/>
                                    <path class="st1" d="M7.8,15.3c-0.8-0.3-1.3-0.5-1.5-0.7C6.1,14.5,6,14.3,6,14c0-0.3,0.1-0.5,0.4-0.7C6.6,13.1,6.9,13,7.3,13
                                    c0.4,0,0.7,0.1,0.9,0.3c0.2,0.2,0.4,0.4,0.5,0.7l0,0.1l1.1-0.5l0-0.1c-0.1-0.5-0.5-0.9-0.9-1.2c-0.4-0.3-1-0.5-1.6-0.5
                                    c-0.7,0-1.3,0.2-1.8,0.6C5,12.9,4.8,13.4,4.8,14c0,0.8,0.4,1.5,1.3,1.9c0.2,0.1,0.6,0.2,1.2,0.5c0.6,0.2,1,0.4,1.2,0.6
                                    c0.2,0.2,0.3,0.5,0.3,0.8c0,0.4-0.1,0.7-0.4,0.9C8.1,18.9,7.8,19,7.3,19c-0.2,0-0.4,0-0.6-0.1c-0.2-0.1-0.3-0.2-0.5-0.3
                                    c-0.1-0.1-0.3-0.3-0.4-0.5c-0.1-0.2-0.2-0.4-0.3-0.6l0-0.1l-1.1,0.4l0,0.1c0.2,0.7,0.5,1.2,1.1,1.6c0.5,0.4,1.1,0.6,1.8,0.6
                                    c0.7,0,1.4-0.2,1.9-0.6c0.5-0.4,0.8-1,0.8-1.7c0-0.6-0.2-1.1-0.5-1.5C9.1,15.9,8.6,15.6,7.8,15.3"/>
                                    <path class="st1" d="M14.8,11.7c-1.1,0-2.1,0.4-2.9,1.2c-0.8,0.8-1.2,1.8-1.2,2.9c0,1.2,0.4,2.2,1.2,2.9c0.8,0.8,1.8,1.2,2.9,1.2
                                    c0.6,0,1.2-0.1,1.8-0.4l0.5,0.8l0.9-0.6l-0.5-0.8c0.4-0.4,0.7-0.8,1-1.4c0.2-0.5,0.4-1.1,0.4-1.7c0-1.2-0.4-2.1-1.2-2.9
                                    C16.9,12.1,15.9,11.7,14.8,11.7 M17.7,15.8c0,0.9-0.3,1.6-0.8,2.1L16,16.6L15,17.2l0.9,1.4c-0.4,0.2-0.8,0.3-1.2,0.3
                                    c-0.8,0-1.5-0.3-2.1-0.9c-0.5-0.6-0.8-1.3-0.8-2.2c0-0.9,0.3-1.6,0.8-2.2c0.6-0.6,1.3-0.9,2.1-0.9c0.8,0,1.5,0.3,2.1,0.9
                                    C17.4,14.2,17.7,14.9,17.7,15.8"/>
                                    <polygon class="st1" points="23.7,16.7 21,12.1 21,12 19.9,12 19.9,20 21,20 21,15.3 21,14.2 23.3,18.3 23.3,18.3 24,18.3 
                                    26.4,14.2 26.3,15.3 26.3,20 27.5,20 27.5,12 26.4,12   "/>
                                </g>
                            </svg>
                            2 Floors (Land: 400Mt; Building: 300Mt)
                        </p>
                    </li>
                    <li class="closeFacilities">
                        <p>
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                            width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
                            <style type="text/css">
                                .st0{fill:none;}
                                .st1{fill:#952524;}
                            </style>
                            <g>
                                <rect class="st0" width="32" height="32"/>
                            </g>
                            <path class="st1" d="M28.4,23c0.6-1.5,0.9-3.2,0.9-4.9c0-5.7-3.6-10.6-8.7-12.6c0-0.1,0-0.2,0-0.3c0-2.6-2.1-4.7-4.7-4.7
                            c-2.6,0-4.7,2.1-4.7,4.7c0,0.1,0,0.2,0,0.3c-5.1,1.9-8.7,6.8-8.7,12.6c0,1.7,0.3,3.4,1,4.9c-1.1,0.9-1.8,2.2-1.8,3.7
                            c0,2.6,2.1,4.7,4.7,4.7c1.3,0,2.5-0.5,3.4-1.4c1.8,1,3.9,1.5,6.1,1.5c2.2,0,4.3-0.6,6.2-1.5c0.9,0.9,2,1.4,3.4,1.4
                            c2.6,0,4.7-2.1,4.7-4.7C30.2,25.2,29.5,23.9,28.4,23z M12.5,5.1c0.1-1.9,1.6-3.4,3.5-3.4c1.9,0,3.5,1.5,3.5,3.4c0,0,0,0.1,0,0.1
                            c0,0.4-0.1,0.7-0.2,1.1c-0.5,1.4-1.8,2.5-3.4,2.5c-1.6,0-2.9-1-3.4-2.5c-0.1-0.3-0.2-0.7-0.2-1.1C12.4,5.2,12.5,5.2,12.5,5.1z
                            M9.5,28.5c-0.2,0.3-0.5,0.7-0.8,0.9c-0.6,0.5-1.4,0.9-2.3,0.9c-2,0-3.5-1.6-3.5-3.5c0-1,0.4-1.9,1.1-2.5c0.3-0.3,0.6-0.5,1-0.7
                            c0.4-0.2,0.9-0.3,1.5-0.3c2,0,3.5,1.6,3.5,3.5C10,27.3,9.8,27.9,9.5,28.5z M16,30.3c-1.9,0-3.8-0.5-5.4-1.3c0.4-0.7,0.6-1.5,0.6-2.3
                            c0-2.6-2.1-4.7-4.7-4.7c-0.7,0-1.3,0.2-1.9,0.4c-0.5-1.3-0.8-2.8-0.8-4.3c0-5.2,3.2-9.6,7.8-11.4C12.1,8.6,13.9,10,16,10
                            c2.1,0,3.9-1.4,4.5-3.3c4.5,1.8,7.8,6.2,7.8,11.4c0,1.5-0.3,3-0.8,4.3c-0.6-0.3-1.2-0.4-1.9-0.4c-2.6,0-4.7,2.1-4.7,4.7
                            c0,0.9,0.2,1.6,0.6,2.3C19.8,29.8,17.9,30.3,16,30.3z M25.5,30.2c-0.9,0-1.7-0.3-2.3-0.9c-0.3-0.3-0.6-0.6-0.8-0.9
                            c-0.3-0.5-0.5-1.1-0.5-1.8c0-2,1.6-3.5,3.5-3.5c0.5,0,1,0.1,1.4,0.3c0.4,0.2,0.7,0.4,1,0.7c0.7,0.6,1.1,1.6,1.1,2.6
                            C29,28.6,27.5,30.2,25.5,30.2z"/>
                        </svg>
                        2 Connected Properties
                    </p>
                </li>
                <li class="closeFacilities">
                    <p class="Private2spc">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
                        <style type="text/css">
                            .st0{fill:none;}
                            .st1{fill:#952524;}
                        </style>
                        <rect class="st0" width="32" height="32"/>
                        <g>
                            <path class="st1" d="M31.3,19.3c-0.7,0-1.4,0.2-1.9,0.7l-1.5,1.2c-0.7,0.6-1.8,0.5-2.5-0.1l-0.7-0.6l0,0c-0.7-0.5-1.5-0.9-2.3-1
                            l-6.6-8.1l6.4-1.7c0.5-0.1,0.9-0.5,1.2-0.9c0.3-0.4,0.3-1,0.2-1.5C23.1,6,22,5.4,20.8,5.7l-9.3,2.6c-0.6,0.2-1.1,0.7-1.3,1.3
                            c-0.2,0.6-0.1,1.3,0.4,1.8l3.7,4.4l-4.4,3.6c-0.6,0.1-1.2,0.4-1.7,0.8l-1.6,1.1c-0.4,0.2-0.9,0.1-1.3-0.1l-2-1.4
                            c-0.5-0.3-1-0.5-1.6-0.5H0v1h1.6c0.4,0,0.7,0.1,1,0.3l2,1.4c0.7,0.5,1.6,0.6,2.4,0.2l1.7-1.2c1.4-1,3.2-1,4.6,0l1.1,0.9
                            c0.5,0.5,1.2,0.7,1.9,0.7c0.5,0,1-0.1,1.4-0.4l1-0.9c1.5-1.4,3.7-1.4,5.3-0.2l0.6,0.6c1,1,2.7,1.1,3.8,0.2l1.5-1.2
                            c0.4-0.3,0.8-0.4,1.3-0.4H32v-1H31.3z M15.5,16L15.5,16l-4.3-5.2c-0.2-0.2-0.3-0.6-0.2-0.9c0.1-0.3,0.3-0.5,0.6-0.6l9.3-2.6
                            c0.6-0.2,1.2,0.2,1.4,0.8c0.1,0.2,0,0.5-0.1,0.7c-0.1,0.2-0.3,0.3-0.5,0.4l-6.8,1.8c-0.2,0.1-0.4,0.3-0.5,0.5
                            c-0.1,0.2,0,0.5,0.1,0.7l6.3,7.7c-1.1,0.1-2.2,0.6-3,1.3l-0.9,0.8c-0.7,0.3-1.5,0.3-2.1-0.3l-1.1-1l0,0c-0.7-0.5-1.5-0.8-2.3-0.9
                            L15.5,16z"/>
                            <path class="st1" d="M29.4,23.6l-1.5,1.2c-0.7,0.6-1.8,0.5-2.5-0.1l-0.7-0.6l0,0c-2-1.5-4.8-1.4-6.7,0.3l-0.9,0.8
                            c-0.7,0.3-1.5,0.3-2.1-0.3l-1.1-1l0,0c-1.8-1.2-4-1.2-5.8,0L6.5,25c-0.4,0.2-0.9,0.1-1.3-0.1l-2-1.4c-0.5-0.3-1-0.5-1.6-0.5H0v1
                            h1.6c0.4,0,0.7,0.1,1,0.3l2,1.4c0.7,0.5,1.6,0.6,2.4,0.2l1.7-1.2c1.4-1,3.2-1,4.6,0l1.1,0.9c0.5,0.5,1.2,0.7,1.9,0.7
                            c0.5,0,1-0.1,1.4-0.4l1-0.9c1.5-1.4,3.7-1.4,5.3-0.2l0.6,0.6c1.1,1,2.7,1.1,3.8,0.2l1.5-1.2c0.4-0.3,0.8-0.4,1.3-0.4H32v-1h-0.7
                            C30.6,23,29.9,23.2,29.4,23.6z"/>
                            <path class="st1" d="M20.6,14.3c0,2,1.7,3.7,3.7,3.7s3.7-1.7,3.7-3.7s-1.7-3.7-3.7-3.7S20.6,12.2,20.6,14.3z M21.6,14.3
                            c0-1.5,1.2-2.6,2.6-2.6c1.5,0,2.6,1.2,2.6,2.6c0,1.5-1.2,2.6-2.6,2.6C22.8,16.9,21.6,15.7,21.6,14.3z"/>
                        </g>
                    </svg>
                    2 Private Swimming Pools:
                    <ul class="seculli">
                        <li>1st : Size: 4x10Mt; Deep: 0,4-1,8Mt)</li>
                        <li>2nd : Size: 4x10Mt; Deep: 0,4-1,8Mt)</li>
                    </ul>
                </p>
            </li>
            <li class="closeFacilities">
                <p>
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
<style type="text/css">
    .st0{fill:none;}
    .st1{fill:#952524;}
</style>
<g>
    <rect y="0" class="st0" width="32" height="32"/>
</g>
<g>
    <path class="st0" d="M20.79,9.54c0.01,0.02,0.02,0.05,0.02,0.08c0.01,0.04,0.02,0.07,0.03,0.11c0.01,0.04,0.03,0.07,0.03,0.11
        C20.86,9.73,20.83,9.63,20.79,9.54z"/>
    <path class="st0" d="M20.51,9.11c0.01,0.02,0.03,0.03,0.04,0.05c0.02,0.02,0.03,0.04,0.05,0.06c0.03,0.04,0.07,0.08,0.09,0.12
        C20.63,9.25,20.57,9.18,20.51,9.11z"/>
    <path class="st0" d="M19.55,8.66c0.12,0.01,0.24,0.03,0.35,0.07C19.79,8.69,19.67,8.67,19.55,8.66z"/>
    <path class="st0" d="M20.08,8.8c0.02,0.01,0.03,0.02,0.05,0.03c0.01,0.01,0.03,0.02,0.04,0.03c0.07,0.04,0.14,0.07,0.2,0.12
        C20.28,8.9,20.18,8.85,20.08,8.8z"/>
    <path class="st1" d="M19.52,7.31c1.89,0,3.42-1.53,3.42-3.42c0-1.89-1.53-3.42-3.42-3.42c-1.89,0-3.42,1.53-3.42,3.42
        C16.1,5.77,17.63,7.31,19.52,7.31z M19.52,1.46c1.34,0,2.43,1.09,2.43,2.43s-1.09,2.43-2.43,2.43c-1.34,0-2.43-1.09-2.43-2.43
        S18.18,1.46,19.52,1.46z"/>
    <path class="st1" d="M27.57,9.23H25.4c-0.27,0-0.49,0.22-0.49,0.49v14.11H19.1c-0.29,0-0.53,0.24-0.53,0.53v6.19H8.18
        c-0.27,0-0.49,0.22-0.49,0.49c0,0.27,0.22,0.49,0.49,0.49H19c0.31,0,0.56-0.25,0.56-0.56v-6.16h5.78c0.3,0,0.55-0.25,0.55-0.55
        V10.21h1.68c0.27,0,0.5-0.22,0.5-0.49C28.06,9.45,27.84,9.23,27.57,9.23z"/>
    <path class="st1" d="M9.56,13.89c1.18,0.81,2.76,0.8,3.94-0.02l1.24-0.87c0.53-0.37,1.14-0.55,1.75-0.55
        c0.66,0,1.31,0.21,1.86,0.63l1.01,0.77c0.61,0.47,1.34,0.72,2.11,0.72c0.71,0,1.39-0.21,1.97-0.61l0.57-0.39
        c0.11-0.07,0.18-0.19,0.21-0.32c0.02-0.13,0-0.26-0.08-0.37l-0.02-0.02c-0.07-0.1-0.18-0.16-0.3-0.18c-0.13-0.02-0.26,0-0.37,0.08
        l-0.57,0.39c-0.89,0.61-2.06,0.58-2.92-0.07l-1.01-0.77c-1.41-1.08-3.33-1.12-4.78-0.1l-1.24,0.87c-0.84,0.59-1.97,0.59-2.82,0.01
        l-1.37-0.94c-1.11-0.76-2.54-0.84-3.73-0.21L4.2,12.37c-0.12,0.06-0.2,0.17-0.24,0.29C3.92,12.79,3.93,12.92,4,13.04
        c0.06,0.12,0.17,0.2,0.29,0.24c0.13,0.04,0.26,0.02,0.37-0.04l0.82-0.44c0.86-0.46,1.9-0.4,2.71,0.15L9.56,13.89z"/>
    <path class="st1" d="M20.51,9.11c0.07,0.07,0.13,0.15,0.18,0.23c0.04,0.07,0.08,0.13,0.11,0.2c0.04,0.09,0.07,0.19,0.09,0.29
        c0.01,0.04,0.03,0.07,0.03,0.11l0.34,2.79l0.03,0c0.02,0,0.16,0.02,0.33,0.02c0.27,0,0.48-0.05,0.6-0.13l0.02-0.01L21.9,9.82
        c-0.15-1.26-1.18-2.17-2.44-2.17c-0.08,0-0.17,0-0.25,0.01c-0.73,0.07-1.39,0.43-1.85,1c-0.46,0.57-0.67,1.29-0.59,2.02l0.07,0.63
        l0.09,0.01c0.26,0.03,0.51,0.09,0.76,0.17l0.17,0.06l-0.11-0.98c-0.05-0.47,0.08-0.92,0.38-1.29c0.3-0.36,0.71-0.59,1.18-0.63
        c0.05-0.01,0.1-0.01,0.15-0.01c0.03,0,0.06,0.01,0.09,0.02c0.12,0.01,0.24,0.03,0.35,0.07c0.06,0.02,0.12,0.04,0.17,0.07
        c0.1,0.05,0.2,0.11,0.29,0.18C20.42,9.02,20.46,9.06,20.51,9.11z"/>
    <path d="M20.17,8.85c-0.01-0.01-0.03-0.02-0.04-0.03C20.14,8.83,20.15,8.84,20.17,8.85z"/>
    <path d="M20.85,9.72c-0.01-0.04-0.02-0.07-0.03-0.11C20.83,9.65,20.84,9.69,20.85,9.72z"/>
    <path d="M20.69,9.33c-0.03-0.04-0.06-0.08-0.09-0.12c0.09,0.12,0.17,0.25,0.23,0.4c-0.01-0.03-0.01-0.05-0.02-0.08
        C20.76,9.47,20.73,9.4,20.69,9.33z"/>
    <path d="M20.37,8.98c-0.06-0.05-0.13-0.08-0.2-0.12c0.14,0.08,0.27,0.18,0.38,0.31c-0.01-0.02-0.02-0.03-0.04-0.05
        C20.46,9.06,20.42,9.01,20.37,8.98z"/>
    <path d="M20.55,9.16c0.02,0.02,0.03,0.04,0.05,0.06C20.58,9.2,20.56,9.18,20.55,9.16z"/>
    <path d="M20.08,8.8c-0.06-0.03-0.11-0.05-0.17-0.07C19.97,8.74,20.02,8.77,20.08,8.8z"/>
    <path d="M20.37,8.98c0.05,0.04,0.09,0.09,0.14,0.13C20.46,9.06,20.42,9.02,20.37,8.98z"/>
    <path d="M20.79,9.54c-0.03-0.07-0.07-0.14-0.11-0.2C20.73,9.4,20.76,9.47,20.79,9.54z"/>
    <path class="st1" d="M12.57,29.05c0.07-0.02,0.13-0.05,0.19-0.08c0.09-0.04,0.18-0.07,0.27-0.12c0.55-0.33,0.94-0.85,1.09-1.47
        l1.18-4.82h5.02c0.79,0,1.54-0.34,2.07-0.93c0.52-0.59,0.77-1.38,0.68-2.16l-0.5-4.11l-0.06,0.06c-0.13,0.13-0.67,0.13-0.87,0.11
        l-0.05,0l0.49,4.06c0.06,0.5-0.1,1.01-0.43,1.39c-0.34,0.38-0.82,0.6-1.33,0.6h-5.79l-1.37,5.58c-0.09,0.36-0.32,0.67-0.64,0.86
        c-0.32,0.19-0.7,0.24-1.06,0.14c-0.86-0.23-1.39-1.1-1.21-1.97l1.41-6.77c0.16-0.74,0.79-1.27,1.55-1.29l5.38-0.12l-0.4-3.48
        l-1.03-0.28l0.32,2.8h-0.01l-4.29,0.09c-1.22,0.03-2.25,0.88-2.5,2.08L9.3,25.96c-0.29,1.39,0.56,2.76,1.92,3.13
        c0.1,0.03,0.21,0.04,0.31,0.05c0.06,0.01,0.12,0.02,0.18,0.02c0.11,0.01,0.22,0,0.33-0.01c0.07-0.01,0.14-0.02,0.21-0.03
        C12.36,29.1,12.47,29.08,12.57,29.05z"/>
</g>
</svg> Swimming pool with built-in Jacuzzi, Seat and Solarium
                
            </p>
        </li>
        <li class="closeFacilities">
            <p>
          <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
<style type="text/css">
    .st0{fill:none;}
    .st1{fill:#952524;}
</style>
<g>
    <rect y="0" class="st0" width="32" height="32"/>
</g>
<g>
    <path class="st1" d="M9.42,8.5h0.06h3.9c1.14,0,2.07-0.93,2.07-2.07V6.16c0-1.14-0.93-2.07-2.07-2.07h-0.15
        c0.21-0.33,0.32-0.7,0.32-1.09V2.74c0-1.14-0.93-2.07-2.07-2.07H4.31c-1.14,0-2.07,0.93-2.07,2.07V3c0,0.39,0.11,0.76,0.32,1.09
        H2.41c-1.14,0-2.07,0.93-2.07,2.07v0.26c0,1.14,0.93,2.07,2.07,2.07h3.9h0.06h0.2v8.51h-0.2H6.31h-3.9c-1.14,0-2.07,0.93-2.07,2.07
        v0.26c0,1.14,0.93,2.07,2.07,2.07h0.15c-0.21,0.33-0.32,0.7-0.32,1.09v0.26c0,1.14,0.93,2.07,2.07,2.07h7.15
        c1.14,0,2.07-0.93,2.07-2.07V22.5c0-0.39-0.11-0.76-0.32-1.09h0.15c1.14,0,2.07-0.93,2.07-2.07v-0.26c0-1.14-0.93-2.07-2.07-2.07
        h-3.9H9.42h-0.2V8.5H9.42z M3.22,2.74c0-0.6,0.49-1.09,1.09-1.09h7.15c0.6,0,1.09,0.49,1.09,1.09V3c0,0.6-0.49,1.09-1.09,1.09H4.31
        C3.71,4.09,3.22,3.6,3.22,3V2.74z M2.41,7.51c-0.6,0-1.09-0.49-1.09-1.09V6.16c0-0.6,0.49-1.09,1.09-1.09h10.96
        c0.6,0,1.09,0.49,1.09,1.09v0.26c0,0.6-0.49,1.09-1.09,1.09H2.41z M8.69,17.01H8.44H7.35H7.09V8.5h0.26h1.09h0.26V17.01z
         M12.56,22.76c0,0.6-0.49,1.09-1.09,1.09H4.31c-0.6,0-1.09-0.49-1.09-1.09V22.5c0-0.6,0.49-1.09,1.09-1.09h7.15
        c0.6,0,1.09,0.49,1.09,1.09V22.76z M13.37,17.99c0.6,0,1.09,0.49,1.09,1.09v0.26c0,0.6-0.49,1.09-1.09,1.09H2.41
        c-0.6,0-1.09-0.49-1.09-1.09v-0.26c0-0.6,0.49-1.09,1.09-1.09H13.37z"/>
    <path class="st1" d="M25.63,14.99h0.06h3.9c1.14,0,2.07-0.93,2.07-2.07v-0.26c0-1.14-0.93-2.07-2.07-2.07h-0.15
        c0.21-0.33,0.32-0.7,0.32-1.09V9.23c0-1.14-0.93-2.07-2.07-2.07h-7.15c-1.14,0-2.07,0.93-2.07,2.07V9.5c0,0.39,0.11,0.76,0.32,1.09
        h-0.15c-1.14,0-2.07,0.93-2.07,2.07v0.26c0,1.14,0.93,2.07,2.07,2.07h3.9h0.06h0.2v8.51h-0.2h-0.06h-3.9
        c-1.14,0-2.07,0.93-2.07,2.07v0.26c0,1.14,0.93,2.07,2.07,2.07h0.15c-0.21,0.33-0.32,0.7-0.32,1.09v0.26
        c0,1.14,0.93,2.07,2.07,2.07h7.15c1.14,0,2.07-0.93,2.07-2.07V29c0-0.39-0.11-0.76-0.32-1.09h0.15c1.14,0,2.07-0.93,2.07-2.07
        v-0.26c0-1.14-0.93-2.07-2.07-2.07h-3.9h-0.06h-0.2v-8.51H25.63z M19.44,9.23c0-0.6,0.49-1.09,1.09-1.09h7.15
        c0.6,0,1.09,0.49,1.09,1.09V9.5c0,0.6-0.49,1.09-1.09,1.09h-7.15c-0.6,0-1.09-0.49-1.09-1.09V9.23z M18.63,14.01
        c-0.6,0-1.09-0.49-1.09-1.09v-0.26c0-0.6,0.49-1.09,1.09-1.09h10.96c0.6,0,1.09,0.49,1.09,1.09v0.26c0,0.6-0.49,1.09-1.09,1.09
        H18.63z M24.91,23.5h-0.26h-1.09h-0.26v-8.51h0.26h1.09h0.26V23.5z M28.78,29.26c0,0.6-0.49,1.09-1.09,1.09h-7.15
        c-0.6,0-1.09-0.49-1.09-1.09V29c0-0.6,0.49-1.09,1.09-1.09h7.15c0.6,0,1.09,0.49,1.09,1.09V29.26z M29.59,24.48
        c0.6,0,1.09,0.49,1.09,1.09v0.26c0,0.6-0.49,1.09-1.09,1.09H18.63c-0.6,0-1.09-0.49-1.09-1.09v-0.26c0-0.6,0.49-1.09,1.09-1.09
        H29.59z"/>
</g>
</svg> Private Gym
        </p>
    </li>
    <li class="closeFacilities">
        <p>
       <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
<style type="text/css">
    .st0{fill:none;}
    .st1{fill:#952524;}
</style>
<g>
    <rect y="0" class="st0" width="32" height="32"/>
</g>
<g>
    <path class="st1" d="M23.65,8.91c1.73,0,3.15-1.41,3.15-3.15c0-1.74-1.41-3.15-3.15-3.15c-1.74,0-3.15,1.41-3.15,3.15
        C20.5,7.5,21.91,8.91,23.65,8.91z M21.43,5.77c0-1.22,1-2.22,2.22-2.22c1.22,0,2.22,1,2.22,2.22c0,1.22-0.99,2.22-2.22,2.22
        C22.43,7.98,21.43,6.99,21.43,5.77z"/>
    <path class="st1" d="M16.11,28.64c0.08,0.02,0.16,0.02,0.25,0.03c0.07,0.01,0.14,0.02,0.21,0.03c0.03,0,0.07,0.01,0.1,0.01
        c0.06,0,0.12-0.02,0.18-0.02c0.07-0.01,0.14-0.01,0.21-0.03c0.09-0.02,0.18-0.04,0.27-0.07c0.07-0.02,0.14-0.06,0.21-0.09
        c0.07-0.03,0.14-0.05,0.21-0.09c0.5-0.29,0.85-0.77,0.99-1.33l1.07-4.39h4.56c0.72,0,1.4-0.31,1.87-0.84
        c0.47-0.54,0.69-1.25,0.61-1.96l-1.06-8.74c-0.14-1.12-1.09-1.96-2.22-1.96c-0.07,0-0.14,0-0.21,0.01
        c-0.66,0.06-1.26,0.39-1.68,0.9c-0.42,0.52-0.61,1.17-0.53,1.83l0.66,5.76l-3.91,0.09c-1.11,0.02-2.03,0.8-2.26,1.88l-1.28,6.15
        C14.12,27.06,14.88,28.3,16.11,28.64z M15.28,26l1.28-6.15c0.14-0.65,0.7-1.12,1.37-1.14l4.92-0.11h0.01l-0.77-6.77
        c-0.05-0.41,0.07-0.82,0.33-1.14c0.26-0.32,0.63-0.52,1.04-0.56c0.04-0.01,0.09-0.01,0.13-0.01c0.67,0,1.21,0.48,1.29,1.14
        l1.06,8.74c0.05,0.44-0.09,0.89-0.38,1.23c-0.3,0.33-0.73,0.53-1.17,0.53h-5.29l-1.25,5.1c-0.08,0.32-0.28,0.58-0.56,0.75
        c-0.28,0.17-0.61,0.21-0.93,0.13C15.6,27.54,15.12,26.77,15.28,26z M16.82,27.78c0.01,0,0.02,0,0.03,0
        C16.84,27.77,16.83,27.78,16.82,27.78z"/>
    <path class="st1" d="M30.95,17.79h-2.01c-0.3,0-0.54,0.24-0.54,0.54v5.56h-5.1c-0.29,0-0.52,0.23-0.52,0.52v5.56H13.3
        c-0.27,0-0.49,0.22-0.49,0.49c0,0.27,0.22,0.49,0.49,0.49h10.45v-6.08h5.1c0.28,0,0.51-0.23,0.51-0.51v-5.58h1.57
        c0.27,0,0.49-0.22,0.49-0.49C31.44,18.01,31.22,17.79,30.95,17.79z"/>
    <path class="st1" d="M2.13,18.95c-0.75-0.98-0.78-2.32-0.07-3.34l0.81-1.16c0.77-1.1,0.78-2.59,0.02-3.71L2,9.47
        C1.5,8.73,1.44,7.77,1.86,6.98l0.39-0.72c0.13-0.24,0.04-0.54-0.2-0.66C1.93,5.54,1.8,5.52,1.68,5.56C1.55,5.6,1.45,5.68,1.39,5.8
        L1.12,6.3c-0.67,1.25-0.59,2.76,0.22,3.93l0.74,1.07c0.53,0.78,0.53,1.82-0.01,2.59l-0.81,1.16c-0.95,1.37-0.91,3.17,0.1,4.49
        l0.72,0.94c0.6,0.79,0.63,1.87,0.07,2.69L1.8,23.66c-0.07,0.11-0.1,0.24-0.08,0.37c0.02,0.13,0.09,0.24,0.2,0.31l0,0
        c0.08,0.06,0.18,0.08,0.28,0.08c0.16,0,0.32-0.08,0.41-0.21l0.34-0.49c0.8-1.17,0.76-2.71-0.1-3.84L2.13,18.95z"/>
    <path class="st1" d="M6.91,18.9c-0.54-0.77-0.54-1.81-0.01-2.59l0.88-1.28c0.72-1.04,0.79-2.39,0.19-3.51l-0.38-0.72
        c-0.06-0.11-0.17-0.2-0.29-0.24c-0.12-0.04-0.26-0.03-0.37,0.04c-0.12,0.06-0.2,0.17-0.24,0.29c-0.04,0.13-0.03,0.26,0.04,0.37
        l0.38,0.72c0.42,0.79,0.37,1.75-0.14,2.49l-0.88,1.27c-0.76,1.11-0.76,2.6,0.02,3.71l0.81,1.16c0.71,1.02,0.68,2.36-0.07,3.34
        L6.12,24.9c-0.86,1.13-0.9,2.67-0.1,3.84l0.34,0.49c0.07,0.11,0.19,0.18,0.31,0.2c0.03,0.01,0.06,0.01,0.09,0.01
        c0.1,0,0.2-0.03,0.28-0.09c0.22-0.15,0.28-0.46,0.13-0.68l-0.34-0.49c-0.56-0.82-0.54-1.9,0.07-2.69l0.72-0.94
        c1.01-1.32,1.05-3.13,0.1-4.49L6.91,18.9z"/>
    <path class="st1" d="M12.44,15.29c1.12-1.46,1.17-3.46,0.11-4.97l-0.48-0.69c-0.64-0.91-0.64-2.14-0.01-3.05l0.58-0.84
        c0.8-1.17,0.89-2.67,0.22-3.93l-0.27-0.5c-0.13-0.24-0.42-0.33-0.66-0.2c-0.11,0.06-0.2,0.16-0.24,0.29
        c-0.04,0.13-0.02,0.26,0.04,0.37l0.27,0.5c0.5,0.93,0.43,2.05-0.16,2.91l-0.58,0.84c-0.86,1.25-0.85,2.93,0.02,4.17l0.48,0.68
        c0.81,1.16,0.78,2.69-0.08,3.82l-0.36,0.47c-0.97,1.27-1.02,3-0.11,4.31l0.17,0.25c0.07,0.11,0.19,0.18,0.31,0.2
        c0.03,0.01,0.06,0.01,0.09,0.01c0.1,0,0.19-0.03,0.28-0.09c0.11-0.07,0.18-0.19,0.2-0.31c0.02-0.13,0-0.26-0.08-0.37L12,18.93
        c-0.66-0.96-0.63-2.24,0.08-3.17L12.44,15.29z M12.39,1.14C12.39,1.14,12.39,1.14,12.39,1.14C12.39,1.14,12.39,1.14,12.39,1.14z"/>
</g>
</svg> Private Sauna
       
    </p>
</li>
<li class="closeFacilities">
    <p>
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
<style type="text/css">
    .st0{fill:none;}
    .st1{fill:#952524;}
</style>
<g>
    <rect y="0" class="st0" width="32" height="32"/>
</g>
<g>
    <path class="st1" d="M31.31,12.38c-0.14-1.27-1.24-2.22-2.57-2.22H12.39c0.38-0.49,0.56-1.1,0.51-1.73c-0.1-1.29-1.24-2.3-2.58-2.3
        H4.43c-0.7,0-1.38,0.29-1.88,0.79C2.08,7.41,1.83,8.04,1.84,8.69c0.01,0.58,0.23,1.14,0.61,1.58c-1.05,0.32-1.77,1.29-1.77,2.39
        c0,1.17,0.86,2.22,2.01,2.45v10.26c0,0.27,0.22,0.49,0.49,0.49c0.27,0,0.49-0.22,0.49-0.49V15.16h24.81v10.21
        c0,0.27,0.22,0.49,0.49,0.49c0.27,0,0.49-0.22,0.49-0.49V15.08C30.65,14.77,31.44,13.62,31.31,12.38 M30.34,12.51
        c0.04,0.43-0.1,0.85-0.39,1.17c-0.29,0.32-0.7,0.5-1.13,0.5H3.25c-0.82,0-1.51-0.6-1.59-1.37c-0.04-0.43,0.09-0.85,0.39-1.17
        c0.29-0.32,0.7-0.5,1.13-0.5h25.57C29.56,11.14,30.26,11.74,30.34,12.51 M11.54,9.66c-0.29,0.32-0.7,0.5-1.13,0.5H4.42
        c-0.82,0-1.51-0.6-1.59-1.37C2.79,8.36,2.92,7.94,3.22,7.62c0.29-0.32,0.7-0.5,1.13-0.5h5.99c0.82,0,1.51,0.6,1.59,1.37
        C11.97,8.92,11.83,9.34,11.54,9.66"/>
</g>
</svg> Private Spa Room
     
</p>
</li>
<li class="closeFacilities">
    <p>
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
<style type="text/css">
    .st0{fill:none;}
    .st1{fill:#952524;}
</style>
<g>
    <rect y="0" class="st0" width="32" height="32"/>
</g>
<g>
    <path class="st1" d="M31.08,10.9h-3.62l1.19-3.91c0.1-0.32-0.08-0.66-0.4-0.76c-0.15-0.05-0.32-0.03-0.46,0.04
        c-0.15,0.08-0.25,0.2-0.3,0.36l-1.3,4.27H0.93c-0.52,0-0.95,0.43-0.95,0.95v17.6h0.18c0.44,0,0.8-0.36,0.8-0.8V11.88h24.93
        l-2.58,8.47h-7.83c-0.33,0-0.61,0.27-0.61,0.61c0,0.34,0.27,0.61,0.61,0.61h3.76v6.61h-2.51v1.06h5.83v-1.06h-2.1v-6.61h3.2
        c0.34,0,0.63-0.22,0.73-0.54l2.78-9.15h3.88v17.56h0.18c0.44,0,0.8-0.36,0.8-0.8V11.84C32.02,11.32,31.6,10.9,31.08,10.9z"/>
    <path class="st1" d="M14.77,8.86h-0.9V2.91c0-0.19-0.16-0.35-0.35-0.35H3.64c-0.19,0-0.35,0.16-0.35,0.35v5.95h-1v0.67h12.48V8.86z
         M13.2,3.25v5.6H3.97v-5.6c0-0.01,0.01-0.02,0.02-0.02h9.19C13.19,3.23,13.2,3.24,13.2,3.25z"/>
</g>
</svg> Office
  
</p>
</li>
<li class="closeFacilities">
    <p>
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
<style type="text/css">
    .st0{fill:none;}
    .st1{fill:#952524;}
</style>
<g>
    <rect y="0" class="st0" width="32" height="32"/>
</g>
<g>
    <path class="st1" d="M30.95,5.19H1.05c-0.59,0-1.07,0.48-1.07,1.08v17.87c0,0.73,0.59,1.33,1.32,1.33h2.89v-0.98H0.96V6.18h30.08
        v18.3h-3.23v0.98h2.89c0.73,0,1.32-0.59,1.32-1.33V6.27C32.02,5.68,31.54,5.19,30.95,5.19z"/>
    <path class="st1" d="M12.55,20.06c0-1.26-1.03-2.29-2.29-2.29c-1.26,0-2.29,1.03-2.29,2.29s1.03,2.29,2.29,2.29
        C11.52,22.35,12.55,21.32,12.55,20.06z M8.43,20.06c0-1.01,0.82-1.83,1.83-1.83c1.01,0,1.82,0.82,1.82,1.83
        c0,1.01-0.82,1.82-1.82,1.82C9.25,21.88,8.43,21.06,8.43,20.06z"/>
    <path class="st1" d="M10.25,23.11c-2.47,0-4.26,1.25-4.26,2.98c0,0.4,0.32,0.72,0.72,0.72h7.1c0.4,0,0.72-0.32,0.72-0.72
        C14.52,24.36,12.73,23.11,10.25,23.11z M14.05,26.09c0,0.14-0.11,0.25-0.25,0.25h-7.1c-0.14,0-0.25-0.11-0.25-0.25
        c0-1.39,1.56-2.39,3.8-2.44C12.38,23.65,14.05,24.72,14.05,26.09z"/>
    <path class="st1" d="M24.04,20.06c0-1.26-1.03-2.29-2.29-2.29c-1.26,0-2.29,1.03-2.29,2.29s1.03,2.29,2.29,2.29
        C23.01,22.35,24.04,21.32,24.04,20.06z M19.92,20.06c0-1.01,0.82-1.83,1.82-1.83c1.01,0,1.82,0.82,1.82,1.83
        c0,1.01-0.82,1.82-1.82,1.82C20.74,21.88,19.92,21.06,19.92,20.06z"/>
    <path class="st1" d="M21.75,23.11c-2.47,0-4.26,1.25-4.26,2.98c0,0.4,0.32,0.72,0.72,0.72h7.1c0.4,0,0.72-0.32,0.72-0.72
        C26.01,24.36,24.22,23.11,21.75,23.11z M25.54,26.09c0,0.14-0.11,0.25-0.25,0.25h-7.1c-0.14,0-0.25-0.11-0.25-0.25
        c0-1.39,1.56-2.39,3.79-2.44C23.87,23.65,25.54,24.72,25.54,26.09z"/>
</g>
</svg> TV-Room
     
</p>
</li>
<li class="closeFacilities">
    <p>
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
<style type="text/css">
    .st0{fill:none;}
    .st1{fill:#952524;}
</style>
<g>
    <rect y="0" class="st0" width="32" height="32"/>
</g>
<g>
    <path class="st1" d="M31.21,11.62L16.51,0.66c-0.3-0.23-0.73-0.23-1.03,0L0.81,11.59c-0.3,0.22-0.44,0.6-0.35,0.93
        c0.1,0.38,0.44,0.64,0.83,0.64h2.95v15.02H2.21c-0.29,0-0.53,0.24-0.53,0.54s0.24,0.53,0.53,0.53h2.04v1.72
        c0,0.3,0.24,0.54,0.54,0.54c0.3,0,0.54-0.24,0.54-0.54v-1.72h21.35v1.72c0,0.3,0.24,0.54,0.54,0.54c0.29,0,0.53-0.24,0.53-0.54
        v-1.72h2.02c0.3,0,0.54-0.24,0.54-0.53s-0.24-0.54-0.54-0.54h-2.02V13.17h2.91c0.37,0,0.71-0.22,0.83-0.54
        C31.64,12.26,31.53,11.85,31.21,11.62z M26.68,13.17v9.31H5.32v-9.31H26.68z M26.68,22.89v5.3H5.32v-5.3H26.68z M30.07,12.1H1.93
        L16,1.61L30.07,12.1z"/>
</g>
</svg> Gazebo
            
</p>
</li>
<li class="closeFacilities">
    <a href="">
        <p>
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
                <style type="text/css">
                    .st0{fill:none;}
                    .st1{fill:#952524;}
                </style>
                <g>
                    <rect class="st0" width="32" height="32"></rect>
                </g>
                <g>
                    <g>
                        <polygon class="st1" points="28.7,26.8 31.7,19.5 30.7,19.2 28,25.8 21.3,25.8 21.3,26.8 22.2,26.8 20.8,30.3 21.9,30.3 
                        23.3,26.8 26.7,26.8 28.2,30.3 29.4,30.3 27.8,26.8     "></polygon>
                        <polygon class="st1" points="3.3,26.8 0.3,19.5 1.3,19.2 4,25.8 10.7,25.8 10.7,26.8 9.8,26.8 11.2,30.3 10.1,30.3 8.7,26.8 
                        5.3,26.8 3.8,30.3 2.6,30.3 4.2,26.8       "></polygon>
                        <path class="st1" d="M11.7,24.7h2.2c-0.3,1.1-1,3.3-1.2,5.5l1,0c0.2-2.3,1-4.6,1.2-5.5h2c0.3,0.9,1,3.2,1.2,5.5l1,0
                        c-0.2-2.2-0.8-4.4-1.2-5.5h2.2v-1h-8.5V24.7z"></path>
                    </g>
                    <g>
                        <path class="st1" d="M23.5,13.6l-2.6-1.2l2.2-0.8c0.1,0,0.1-0.1,0.2-0.1c0-0.1,0-0.1,0-0.2c0-0.1-0.2-0.2-0.3-0.2l-2.8,1l-3.7-1.8
                        L19.9,8l2.9,0.6c0.1,0,0.1,0,0.2,0c0.1,0,0.1-0.1,0.1-0.2c0-0.1,0-0.1,0-0.2c0-0.1-0.1-0.1-0.2-0.1l-2.3-0.5L23,6
                        c0.1-0.1,0.2-0.2,0.1-0.4c0-0.1-0.1-0.1-0.2-0.1c-0.1,0-0.1,0-0.2,0l-2.5,1.6l0.5-2.3c0-0.1,0-0.1,0-0.2c0-0.1-0.1-0.1-0.2-0.1
                        c-0.1,0-0.1,0-0.2,0c-0.1,0-0.1,0.1-0.1,0.2l-0.6,2.9l-3.5,2.2l0-4.1l2-2.1c0.1-0.1,0.1-0.1,0.1-0.2c0-0.1,0-0.1-0.1-0.2
                        c-0.1,0-0.1-0.1-0.2-0.1h0c-0.1,0-0.1,0-0.2,0.1l-1.7,1.7l0-2.9c0-0.1,0-0.1-0.1-0.2c-0.1,0-0.1-0.1-0.2-0.1h0
                        c-0.1,0-0.3,0.1-0.3,0.3l0,2.9l-1.7-1.7c-0.1-0.1-0.1-0.1-0.2-0.1h0c-0.1,0-0.1,0-0.2,0.1c-0.1,0.1-0.1,0.3,0,0.4l2.1,2.1l0,4.2
                        L11.8,8l-1-2.7c-0.1-0.1-0.2-0.2-0.3-0.2c-0.1,0.1-0.2,0.2-0.2,0.3l0.8,2.2L8.5,6.4c-0.1,0-0.1,0-0.2,0c-0.1,0-0.1,0.1-0.2,0.1
                        c0,0,0,0.1,0,0.1c0,0.1,0.1,0.2,0.2,0.2l2.7,1.3L8.7,9C8.5,9.1,8.4,9.2,8.5,9.4c0,0.1,0.1,0.1,0.1,0.2c0.1,0,0.1,0,0.2,0l2.8-1
                        l3.7,1.7l-3.4,2.2L9,11.9c-0.1,0-0.1,0-0.2,0c-0.1,0-0.1,0.1-0.1,0.2c0,0.1,0,0.1,0,0.2c0,0.1,0.1,0.1,0.2,0.1l2.3,0.5l-2.5,1.6
                        c-0.1,0.1-0.2,0.2-0.1,0.4C8.7,15,8.9,15,9,15l2.5-1.6L11,15.7c0,0.1,0,0.1,0,0.2c0,0.1,0.1,0.1,0.2,0.1c0.1,0,0.1,0,0.2,0
                        c0.1,0,0.1-0.1,0.1-0.2l0.6-2.9l3.4-2.2l0,4.1l-2.1,2.1c0,0-0.1,0.1-0.1,0.2c0,0.1,0,0.1,0.1,0.2c0.1,0,0.1,0.1,0.2,0.1
                        c0,0,0,0,0,0c0.1,0,0.1,0,0.2-0.1l1.7-1.7l0,3c0,0.1,0.1,0.3,0.3,0.3h0c0.1,0,0.3-0.1,0.3-0.3l0-3l1.7,1.7c0.1,0.1,0.3,0.1,0.4,0
                        l0,0v0c0,0,0.1-0.1,0.1-0.2c0-0.1,0-0.1-0.1-0.2l-2.1-2.1l0-4.1l3.8,1.8l1,2.8c0.1,0.1,0.2,0.2,0.3,0.2c0.1,0,0.1-0.1,0.2-0.1
                        c0-0.1,0-0.1,0-0.2l-0.8-2.3l2.6,1.3c0.1,0.1,0.3,0,0.4-0.1c0-0.1,0-0.1,0-0.2C23.6,13.7,23.5,13.6,23.5,13.6"></path>
                    </g>
                </g>
            </svg>Air Conditioned Living Room
    </p>
</a>
</li>
<li class="closeFacilities">
    <p>
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
<style type="text/css">
    .st0{fill:none;}
    .st1{fill:#952524;}
</style>
<g>
    <rect y="0" class="st0" width="32" height="32"/>
</g>
<g>
    <path class="st1" d="M26.91,20.91c0-0.92-0.71-1.66-1.58-1.66c-0.87,0-1.58,0.74-1.58,1.66s0.71,1.66,1.58,1.66
        C26.2,22.57,26.91,21.83,26.91,20.91z M26.4,20.91c0,0.64-0.48,1.15-1.07,1.15c-0.59,0-1.07-0.52-1.07-1.15
        c0-0.64,0.48-1.15,1.07-1.15C25.92,19.76,26.4,20.28,26.4,20.91z"/>
    <polygon class="st1" points="28.56,13.76 23.63,13.76 22.86,10.23 22.84,10.16 21.34,10.16 21.34,10.67 22.43,10.67 23.11,13.76 
        19.25,13.76 19.25,14.27 28.56,14.27     "/>
    <path class="st1" d="M8.21,23.38c0.06,0.01,0.12,0.01,0.18,0.01c0.14,0,0.28-0.04,0.42-0.06c0.04-0.01,0.07-0.01,0.11-0.02
        c0.21-0.05,0.42-0.14,0.64-0.25c0.01,0,0.02-0.01,0.02-0.01c0.45-0.25,0.9-0.64,1.34-1.18c0.84-1.03,1.38-1.71,1.72-2.13v0.07
        l0.41-0.6c0.01-0.01,0.02-0.03,0.03-0.04c0.16-0.23,0.42-0.45,0.53-0.45c0,0,0.07,0.02,0.19,0.24c0.04,0.08,0.1,0.19,0.17,0.29
        l2.44,3.64c0.19,0.28,0.47,0.46,0.8,0.52c0.08,0.01,0.15,0.02,0.22,0.02c0.25,0,0.5-0.08,0.71-0.23l0.52-0.38l0.07-0.07
        c0.3-0.38,0.68-1.38-0.06-2.44c-0.54-0.76-2.36-3.22-3.4-4.61l-0.29-0.39l-0.04-0.89c-0.02-0.53-0.45-0.94-0.97-0.94H9.69
        c-0.06,0-1.46-0.07-2.09-1.81c-0.25-0.7-0.59-1.14-1.03-1.32c-0.35-0.15-0.74-0.13-1.16,0.05c-0.67,0.3-1.15,0.93-1.29,1.69
        c-0.28,1.44-0.65,5.28,1.92,9.71C6.12,21.95,6.87,23.26,8.21,23.38z M6.69,12c0.87,2.42,2.97,2.45,2.99,2.45h4.29
        c0,0,0.01,0,0.01,0.01l0.04,0.94c0.01,0.17,0.07,0.32,0.17,0.46c0.44,0.58,3.04,4.07,3.7,5.01c0.41,0.59,0.22,1.07,0.12,1.24
        l-0.42,0.31c-0.05,0.04-0.13,0.06-0.2,0.05c-0.07-0.01-0.13-0.05-0.17-0.11l-2.44-3.64c-0.04-0.06-0.07-0.12-0.12-0.22l-0.01-0.01
        c-0.25-0.46-0.58-0.71-0.98-0.73l-0.05,0c-0.67,0-1.19,0.68-1.34,0.89l-0.01,0.02c-0.15,0.2-0.77,0.98-2.08,2.6
        c-0.63,0.77-1.22,1.16-1.77,1.16c-0.03,0-0.05,0-0.08,0l-0.02,0c-0.79-0.07-1.36-0.99-1.42-1.1c-2.4-4.15-2.07-7.71-1.82-9.05
        c0.09-0.45,0.36-0.82,0.74-0.98c0.16-0.07,0.28-0.09,0.38-0.05C6.37,11.31,6.54,11.58,6.69,12z M8.39,23.37c-0.03,0-0.07,0-0.1,0
        c0.08,0,0.17-0.01,0.25-0.02C8.49,23.35,8.44,23.37,8.39,23.37z M9,23.28c0.05-0.01,0.1-0.04,0.14-0.06
        C9.1,23.24,9.05,23.26,9,23.28z"/>
    <path class="st1" d="M7.01,10.04c1.5,0,2.72-1.25,2.72-2.79c0-1.54-1.22-2.79-2.72-2.79c-1.5,0-2.72,1.25-2.72,2.79
        C4.3,8.79,5.51,10.04,7.01,10.04z M5.26,7.25c0-1,0.79-1.82,1.75-1.82c0.97,0,1.75,0.82,1.75,1.82c0,1-0.79,1.82-1.75,1.82
        C6.05,9.07,5.26,8.25,5.26,7.25z"/>
    <path class="st1" d="M8.77,19.3h0.02c0.19,0,0.38-0.08,0.51-0.22l2.33-2.39c0.17-0.17,0.22-0.43,0.13-0.65
        c-0.09-0.22-0.3-0.38-0.54-0.38c-0.45-0.02-2.7-0.12-3.41-0.47c-0.2-0.1-0.45-0.09-0.64,0.04c-0.19,0.13-0.29,0.35-0.27,0.58
        c0.07,0.7,0.33,2.05,1.34,3.25C8.38,19.2,8.57,19.29,8.77,19.3z M10.43,16.57l-1.62,1.67c-0.55-0.73-0.79-1.53-0.88-2.01
        C8.63,16.42,9.64,16.52,10.43,16.57z"/>
    <path class="st1" d="M31.04,12.5v3.2H19.25v0.51h11.79v7.12c0,1.78-1.44,3.22-3.21,3.22H4.17c-1.77,0-3.21-1.45-3.21-3.22V12.5
        h-0.98v10.83c0,2.32,1.88,4.21,4.19,4.21h23.65c2.31,0,4.19-1.89,4.19-4.21V12.5H31.04z"/>
</g>
</svg> Indoor and Outdoor Jacuzzi
</p>
</li>
<li class="closeFacilities">
    <p>
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
<style type="text/css">
    .st0{fill:none;}
    .st1{fill:#952524;}
</style>
<g>
    <rect y="0" class="st0" width="32" height="32"/>
</g>
<g>
    <path class="st1" d="M31.32,12.02H4.18V8.23H7.8V7.24H3.68c-0.26,0-0.48,0.21-0.48,0.48v4.3H0.68c-0.4,0-0.72,0.32-0.72,0.72v0.4
        c0,6.4,5.21,11.61,11.61,11.61h8.87c6.4,0,11.6-5.21,11.6-11.61v-0.4C32.04,12.35,31.72,12.02,31.32,12.02z M31.06,13.15
        c0,5.86-4.76,10.62-10.62,10.62h-8.87c-5.86,0-10.62-4.76-10.62-10.62v-0.14h30.11V13.15z"/>
</g>
</svg>Bathtub

</p>
</li>


</div>

<div class="FIve16li five1Li">

    <li class="closeFacilities">
        <p>
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
        <style type="text/css">
            .st0{fill:none;}
            .st1{fill:#952524;}
        </style>
        <rect class="st0" width="32" height="32"></rect>
        <g>
            <path class="st1" d="M16,4.5c-6,0-11.6,2.3-15.8,6.6c-0.2,0.2-0.2,0.5,0,0.7l0,0h0C0.3,12,0.4,12,0.5,12h0c0.1,0,0.3-0.1,0.4-0.2
            c4-4.1,9.4-6.3,15.1-6.3c5.7,0,11.1,2.2,15.1,6.3c0.1,0.1,0.2,0.2,0.4,0.2h0c0.1,0,0.3-0.1,0.4-0.2c0.2-0.2,0.2-0.5,0-0.7
            C27.6,6.9,22,4.5,16,4.5"></path>
            <path class="st1" d="M16,10.3c-4.5,0-8.7,1.7-11.8,4.9c-0.2,0.2-0.2,0.5,0,0.7c0.2,0.2,0.5,0.2,0.7,0c3-3,6.9-4.6,11.1-4.6
            c4.2,0,8.1,1.6,11.1,4.6c0.1,0.1,0.2,0.2,0.4,0.2h0c0.1,0,0.3-0.1,0.4-0.2c0.2-0.2,0.2-0.5,0-0.7C24.7,12,20.5,10.3,16,10.3"></path>
            <path class="st1" d="M16,16.6c-2.8,0-5.4,1.1-7.3,3.1c-0.2,0.2-0.2,0.5,0,0.7c0.1,0.1,0.2,0.2,0.4,0.2h0c0.1,0,0.3-0.1,0.4-0.2
            c1.8-1.8,4.1-2.7,6.6-2.7s4.8,1,6.6,2.7c0.1,0.1,0.2,0.1,0.4,0.2h0c0.1,0,0.3-0.1,0.4-0.2c0.2-0.2,0.2-0.5,0-0.7
            C21.4,17.7,18.8,16.6,16,16.6"></path>
            <path class="st1" d="M19.4,23.8c-0.9-0.9-2.1-1.5-3.4-1.5c-1.3,0-2.5,0.5-3.4,1.5c-0.1,0.1-0.1,0.3,0,0.4l3.1,3.1
            c0.1,0.1,0.3,0.1,0.4,0l3.1-3.1C19.5,24.1,19.5,23.9,19.4,23.8 M16,26.3l-2.3-2.4l0.1-0.1c0.6-0.5,1.4-0.7,2.2-0.7
            c0.8,0,1.5,0.2,2.2,0.7l0.1,0.1L16,26.3z"></path>
        </g>
    </svg>Free Wi-Fi  
    </p>
</li>
<li class="closeFacilities">
    <p>
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
        <style type="text/css">
            .st0{fill:none;}
            .st1{fill:#952524;}
        </style>
        <rect class="st0" width="32" height="32"></rect>
        <g>
            <path class="st1" d="M22.4,3.1H9.6c-0.8,0-1.4,0.6-1.4,1.4v23c0,0.8,0.6,1.4,1.4,1.4h12.8c0.8,0,1.4-0.6,1.4-1.4v-23
            C23.8,3.7,23.1,3.1,22.4,3.1z M9.2,4.5c0-0.2,0.2-0.4,0.4-0.4h12.8c0.2,0,0.4,0.2,0.4,0.4v23c0,0.2-0.2,0.4-0.4,0.4H9.6
            c-0.2,0-0.4-0.2-0.4-0.4V4.5z"></path>
            <rect x="14.2" y="6.7" class="st1" width="3.6" height="0.6"></rect>
            <path class="st1" d="M16,26.5c1,0,1.8-0.8,1.8-1.8S17,22.8,16,22.8s-1.8,0.8-1.8,1.8S15,26.5,16,26.5z M14.8,24.7
            c0-0.7,0.6-1.2,1.3-1.2c0.7,0,1.2,0.6,1.2,1.2s-0.6,1.2-1.2,1.2C15.3,25.9,14.8,25.4,14.8,24.7z"></path>
        </g>
    </svg>  Mobile Phone with Free Internet 3G
</p>
</li>



<li class="closeFacilities">
    <p>
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
        <style type="text/css">
            .st0{fill:none;}
            .st1{fill:#952524;}
        </style>
        <rect class="st0" width="32" height="32"></rect>
        <g>
            <path class="st1" d="M17.9,0.4c-0.1,0-0.3,0-0.4,0.1c-0.1,0.1-0.2,0.2-0.2,0.3c0,0.3,0.2,0.5,0.4,0.5c1.5,0.2,9.2,1.8,10.7,10.9
            c0,0.2,0.2,0.4,0.5,0.4c0,0,0,0,0.1,0l0,0c0.1,0,0.3-0.1,0.3-0.2c0.1-0.1,0.1-0.2,0.1-0.4C27.8,2.5,19.6,0.7,17.9,0.4z"></path>
            <path class="st1" d="M17.6,4.3c-0.1,0-0.3,0-0.4,0.1C17.1,4.5,17,4.6,17,4.8c0,0.3,0.1,0.5,0.4,0.6c1.5,0.3,6.6,1.7,7.2,7.3
            c0,0.3,0.2,0.5,0.5,0.5h0c0.1,0,0.3-0.1,0.4-0.2c0.1-0.1,0.1-0.2,0.1-0.4C25,6.4,19.3,4.7,17.6,4.3z"></path>
            <path class="st1" d="M17,9.2L17,9.2c0.8,0.2,3.5,1.2,3.7,3.8c0,0.2,0.2,0.4,0.5,0.4c0.1,0,0.3-0.1,0.4-0.2c0.1-0.1,0.1-0.2,0.1-0.4
            c-0.3-3.1-3.2-4.3-4.5-4.6c-0.1,0-0.3,0-0.4,0.1c-0.1,0.1-0.2,0.2-0.2,0.3C16.6,8.9,16.7,9.1,17,9.2z"></path>
            <path class="st1" d="M17.6,15.5c0.7-0.8,0.6-2-0.2-2.8c-0.4-0.4-0.9-0.6-1.5-0.6c-0.5,0-0.9,0.2-1.3,0.5L7.3,5.2
            C6.7,4.7,6.1,5.1,6,5.2c-2.3,2.4-3.5,5.6-3.5,9c0.1,3.4,1.4,6.5,3.8,8.9l0.6,0.6c0,0,0,0,0,0l-2.8,7c-0.1,0.2-0.1,0.4,0.1,0.6
            c0.1,0.2,0.3,0.3,0.5,0.3h7.9c0.3,0,0.5-0.1,0.7-0.4c0.2-0.2,0.2-0.5,0.1-0.8l-1.1-3.5c1.2,0.3,2.4,0.5,3.6,0.5
            c3.3,0,6.4-1.2,8.8-3.4c0.6-0.7,0.1-1.3,0-1.3L17.6,15.5z M15.4,13.2c0.4-0.2,1-0.2,1.3,0.2c0.3,0.3,0.4,0.9,0.2,1.3L15.4,13.2z
            M12.4,30.6H5.2l2.4-6.2c1,0.9,2.2,1.6,3.4,2.1L12.4,30.6z M23.9,23.3c-2.2,2-5,3.1-8,3.1c-3.2,0-6.1-1.2-8.4-3.5L7,22.3
            c-2.2-2.2-3.5-5.2-3.5-8.4c0-3,1.1-5.8,3.1-8L23.9,23.3z"></path>
        </g>
    </svg>TV-Cable with 60 International Channel
    
</p>
</li>
<li class="closeFacilities">
    <p>
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
<style type="text/css">
    .st0{fill:none;}
    .st1{fill:#952524;}
</style>
<g>
    <rect y="0" class="st0" width="32" height="32"/>
</g>
<g>
    <path class="st1" d="M30.65,9.93h-2.98c-1.07-1.87-3.06-3.03-5.21-3.03c-2.14,0-4.13,1.16-5.2,3.03H1.35
        c-0.76,0-1.38,0.62-1.38,1.38v12.41c0,0.76,0.62,1.37,1.38,1.37h29.3c0.76,0,1.37-0.62,1.37-1.37V11.31
        C32.03,10.55,31.41,9.93,30.65,9.93 M22.47,17.93c-2.77,0-5.02-2.25-5.02-5.03c0-0.71,0.15-1.4,0.45-2.06
        c0.11-0.26,0.25-0.51,0.41-0.75c0.94-1.39,2.5-2.21,4.16-2.21c1.67,0,3.23,0.83,4.17,2.21c0.15,0.22,0.29,0.48,0.42,0.75
        c0.29,0.65,0.44,1.35,0.44,2.06C27.5,15.68,25.24,17.93,22.47,17.93 M31.05,23.72c0,0.22-0.18,0.4-0.4,0.4H1.35
        c-0.22,0-0.4-0.18-0.4-0.4V11.31c0-0.22,0.18-0.41,0.4-0.41h15.47c-0.23,0.65-0.35,1.32-0.35,2c0,3.31,2.69,6,6,6
        c3.31,0,6-2.69,6-6c0-0.68-0.12-1.35-0.35-2h2.53c0.22,0,0.4,0.18,0.4,0.41V23.72z"/>
    <path class="st1" d="M22.47,10.53c1.31,0,2.37,1.06,2.37,2.37c0,1.31-1.06,2.37-2.37,2.37c-1.31,0-2.37-1.06-2.37-2.37
        C20.1,11.6,21.16,10.53,22.47,10.53 M22.47,10.02c-1.59,0-2.89,1.3-2.89,2.89c0,1.59,1.3,2.89,2.89,2.89
        c1.59,0,2.89-1.29,2.89-2.89C25.36,11.31,24.06,10.02,22.47,10.02"/>
    <rect x="3.31" y="14.38" class="st1" width="10.2" height="0.52"/>
    <rect x="3.31" y="17.56" class="st1" width="10.2" height="0.52"/>
    <rect x="3.31" y="20.74" class="st1" width="10.2" height="0.52"/>
</g>
</svg>Projector
</p>
</li>
<li class="closeFacilities">
    <p>
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
<style type="text/css">
    .st0{fill:none;}
    .st1{fill:#952524;}
</style>
<g>
    <rect y="0" class="st0" width="32" height="32"/>
</g>
<g>
    <path class="st1" d="M5.12,5.51H0.7C0.31,5.51,0,5.82,0,6.2v19.6c0,0.38,0.31,0.7,0.7,0.7h4.42c0.38,0,0.7-0.31,0.7-0.7V6.2
        C5.81,5.82,5.5,5.51,5.12,5.51 M0.92,6.42H4.9v19.15H0.92V6.42z"/>
    <path class="st1" d="M31.3,5.51h-4.42c-0.38,0-0.7,0.31-0.7,0.7v19.6c0,0.38,0.31,0.7,0.7,0.7h4.42c0.38,0,0.7-0.31,0.7-0.7V6.2
        C32,5.82,31.69,5.51,31.3,5.51 M31.08,25.58h-3.98V6.42h3.98V25.58z"/>
    <path class="st1" d="M22.45,14.07H9.55c-0.31,0-0.57,0.25-0.57,0.57v8.92c0,0.31,0.25,0.57,0.57,0.57h6.29v1.62h-4.1v0.75h8.51
        v-0.75h-3.67v-1.62h5.86c0.31,0,0.57-0.25,0.57-0.57v-8.92C23.02,14.33,22.76,14.07,22.45,14.07 M22.27,23.38H9.73v-8.56h12.54
        V23.38z"/>
    <path class="st1" d="M2.91,7.33c-0.54,0-0.97,0.44-0.97,0.97c0,0.54,0.44,0.97,0.97,0.97c0.54,0,0.97-0.43,0.97-0.97
        C3.88,7.77,3.44,7.33,2.91,7.33"/>
    <path class="st1" d="M2.91,11.2c-0.54,0-0.97,0.44-0.97,0.97c0,0.53,0.44,0.97,0.97,0.97c0.54,0,0.97-0.44,0.97-0.97
        C3.88,11.63,3.44,11.2,2.91,11.2"/>
    <path class="st1" d="M2.91,15.03c-0.54,0-0.97,0.44-0.97,0.97c0,0.53,0.44,0.97,0.97,0.97c0.54,0,0.97-0.44,0.97-0.97
        C3.88,15.46,3.44,15.03,2.91,15.03"/>
    <path class="st1" d="M29.1,9.28c0.53,0,0.97-0.43,0.97-0.97c0-0.54-0.44-0.97-0.97-0.97c-0.54,0-0.97,0.44-0.97,0.97
        C28.12,8.84,28.56,9.28,29.1,9.28"/>
    <path class="st1" d="M29.1,13.14c0.53,0,0.97-0.43,0.97-0.97c0-0.54-0.44-0.97-0.97-0.97c-0.54,0-0.97,0.44-0.97,0.97
        C28.12,12.71,28.56,13.14,29.1,13.14"/>
    <path class="st1" d="M29.1,16.97c0.53,0,0.97-0.43,0.97-0.97c0-0.54-0.44-0.97-0.97-0.97c-0.54,0-0.97,0.44-0.97,0.97
        C28.12,16.54,28.56,16.97,29.1,16.97"/>
</g>
</svg>Home Theatre
</p>
</li>


</div>


<div class="FIve16li five2Li">
    <li class="closeFacilities">
        <p>
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
<style type="text/css">
    .st0{fill:none;}
    .st1{fill:#952524;}
</style>
<g>
    <rect y="0" class="st0" width="32" height="32"/>
</g>
<g>
    <g>
        <path class="st1" d="M16.54,9.47c-3.64,0-6.59,2.96-6.59,6.6c0,3.64,2.96,6.59,6.59,6.59c3.63,0,6.59-2.96,6.59-6.59
            C23.13,12.43,20.17,9.47,16.54,9.47z M16.54,22.18c-3.37,0-6.12-2.74-6.12-6.12c0-3.37,2.75-6.12,6.12-6.12
            c3.37,0,6.12,2.75,6.12,6.12C22.66,19.44,19.91,22.18,16.54,22.18z"/>
        <path class="st1" d="M16.54,5.93c-5.59,0-10.14,4.55-10.14,10.14c0,5.59,4.55,10.14,10.14,10.14c5.59,0,10.14-4.55,10.14-10.14
            C26.67,10.48,22.13,5.93,16.54,5.93z M16.54,25.23c-5.05,0-9.16-4.11-9.16-9.16c0-5.05,4.11-9.16,9.16-9.16
            c5.05,0,9.16,4.11,9.16,9.16C25.7,21.12,21.59,25.23,16.54,25.23z"/>
    </g>
    <path class="st1" d="M31.04,5.76v5.13c0,0.42-0.16,0.82-0.46,1.11c-0.28,0.29-0.66,0.44-1.06,0.44c-0.4,0-0.78-0.16-1.06-0.44
        c-0.3-0.3-0.46-0.69-0.46-1.11V5.76h-0.98v5.13c0,0.68,0.26,1.32,0.75,1.8c0.35,0.35,0.79,0.58,1.27,0.68v13h0.98v-13
        c0.48-0.1,0.92-0.33,1.27-0.68c0.48-0.48,0.74-1.12,0.74-1.8V5.76H31.04z"/>
    <rect x="29.24" y="5.76" class="st1" width="0.56" height="4.66"/>
    <path class="st1" d="M3.02,5.63c-1.67,0-3.04,1.94-3.04,4.32c0,1.03,0.26,2.03,0.74,2.81c0.47,0.77,1.11,1.28,1.81,1.44v12.18h0.98
        V14.19c0.7-0.16,1.34-0.67,1.81-1.44c0.47-0.78,0.74-1.78,0.74-2.81C6.06,7.56,4.7,5.63,3.02,5.63z M5.17,9.95
        c0,1.87-0.96,3.39-2.15,3.39s-2.15-1.52-2.15-3.39c0-1.87,0.96-3.39,2.15-3.39S5.17,8.08,5.17,9.95z"/>
</g>
</svg>Food Service (BBQ, Villa Restaurant, Finger Food, Floating Breakfast and Brunch) <a href="#" class="MenuPdf">(see the Menu)</a>
        
    
    </p>
</li>

<li class="closeFacilities">
    <p>
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
<style type="text/css">
    .st0{fill:none;}
    .st1{fill:#952524;}
</style>
<g>
    <rect y="0" class="st0" width="32" height="32"/>
</g>
<g>
    <path class="st1" d="M30.11,3.34H25.1V1.99c0-0.27-0.22-0.49-0.49-0.49c-0.27,0-0.49,0.22-0.49,0.49v1.35h-7.63V1.99
        c0-0.27-0.22-0.49-0.49-0.49c-0.27,0-0.49,0.22-0.49,0.49v1.35h-7.7V1.99c0-0.27-0.22-0.49-0.49-0.49c-0.27,0-0.49,0.22-0.49,0.49
        v1.35H1.89c-1.06,0-1.91,0.86-1.91,1.92v23.34c0,1.05,0.86,1.91,1.91,1.91h28.21c1.05,0,1.91-0.86,1.91-1.91V5.25
        C32.02,4.19,31.16,3.34,30.11,3.34z M0.96,10.53h27.47c0.24-0.03,0.42-0.23,0.43-0.48v-0.02c-0.01-0.24-0.2-0.45-0.44-0.47H0.96
        V5.25c0-0.52,0.42-0.94,0.94-0.94h4.94v1.34c0,0.27,0.22,0.49,0.49,0.49c0.27,0,0.49-0.22,0.49-0.49V4.31h7.7v1.34
        c0,0.27,0.22,0.49,0.49,0.49c0.27,0,0.49-0.22,0.49-0.49V4.31h7.63v1.34c0,0.27,0.22,0.49,0.49,0.49c0.27,0,0.49-0.22,0.49-0.49
        V4.31h5.01c0.52,0,0.94,0.42,0.94,0.94v23.34c0,0.52-0.42,0.94-0.94,0.94H1.89c-0.52,0-0.94-0.42-0.94-0.94V10.53z"/>
    <path class="st1" d="M8.7,27.25h14.6c0.16,0,0.29-0.13,0.29-0.29c0-0.16-0.13-0.28-0.29-0.28h-0.67v-5.61
        c0-0.74-0.6-1.35-1.35-1.35h-3.77v-2.51c0-0.38-0.16-0.75-0.44-1.02l-0.14-0.14l0.16-0.14c0.46-0.53,0.51-1.26,0.13-1.82
        l-0.86-1.25c-0.06-0.09-0.17-0.15-0.28-0.15c-0.11,0-0.21,0.06-0.27,0.14l-0.85,1.21c-0.38,0.54-0.35,1.28,0.08,1.79l0.22,0.19l0,0
        c0.01,0,0.02,0.01,0.03,0.02c-0.06,0.02-0.13,0.06-0.19,0.12c-0.29,0.27-0.45,0.65-0.45,1.03v2.51H10.9c-0.74,0-1.35,0.6-1.35,1.35
        v5.61H8.7c-0.16,0-0.28,0.13-0.28,0.28C8.42,27.12,8.55,27.25,8.7,27.25z M16.96,17.22v2.51h-1.72v-2.51
        c0-0.47,0.39-0.86,0.86-0.86C16.57,16.36,16.96,16.74,16.96,17.22z M16.7,15.52c-0.15,0.17-0.35,0.27-0.58,0.27
        c-0.24,0-0.45-0.1-0.6-0.28c-0.29-0.34-0.32-0.79-0.08-1.13l0.65-0.93l0.67,0.98C16.99,14.76,16.97,15.21,16.7,15.52z M22.07,23.44
        v3.24H10.12v-3.24H22.07z M10.9,20.3h10.39c0.43,0,0.78,0.35,0.78,0.78v1.8H10.12v-1.8C10.12,20.64,10.47,20.3,10.9,20.3z"/>
</g>
</svg>Event Service (Birthday, Anniversary, Pre-Wedding, etc)
        
</p>
</li>

<li class="closeFacilities">
    <p>
       <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
<style type="text/css">
    .st0{fill:none;}
    .st1{fill:#952524;}
</style>
<g>
    <rect y="0" class="st0" width="32" height="32"/>
</g>
<g>
    <path class="st1" d="M1.56,26.79h15.29c0.46,0,0.91,0.14,1.29,0.39L19.36,28c0.4,0.27,0.86,0.41,1.34,0.41h9.27
        c1.09,0,1.98-0.89,1.98-1.98c0-1.09-0.89-1.98-1.98-1.98h-6.4c-0.3,0-0.58-0.12-0.79-0.33l-4-4c-0.44-0.44-1.03-0.69-1.65-0.69
        H1.56C0.7,19.43,0,20.13,0,20.99v4.24C0,26.09,0.7,26.79,1.56,26.79z M0.98,25.23v-4.24c0-0.32,0.26-0.58,0.58-0.58h15.57
        c0.36,0,0.71,0.14,0.96,0.4l3.99,4c0.4,0.4,0.92,0.62,1.48,0.62h6.4c0.55,0,1,0.45,1,1c0,0.55-0.45,1.01-1,1.01H20.7
        c-0.29,0-0.56-0.08-0.8-0.24l-1.22-0.82c-0.54-0.36-1.18-0.56-1.84-0.56H1.56C1.24,25.81,0.98,25.55,0.98,25.23z"/>
    <path class="st1" d="M24.53,23.65c1.91,0,3.46-1.55,3.46-3.46s-1.55-3.46-3.46-3.46c-1.91,0-3.46,1.55-3.46,3.46
        S22.63,23.65,24.53,23.65z M22.06,20.19c0-1.37,1.11-2.48,2.48-2.48s2.48,1.11,2.48,2.48c0,1.37-1.11,2.48-2.48,2.48
        S22.06,21.56,22.06,20.19z"/>
    <path class="st1" d="M12.61,7.71c1.91,0,3.46-1.55,3.46-3.46c0-1.91-1.55-3.46-3.46-3.46c-1.91,0-3.46,1.55-3.46,3.46
        C9.15,6.16,10.7,7.71,12.61,7.71z M10.13,4.25c0-1.37,1.11-2.48,2.48-2.48s2.48,1.11,2.48,2.48c0,1.37-1.11,2.48-2.48,2.48
        S10.13,5.62,10.13,4.25z"/>
    <path class="st1" d="M4.25,17.09l5.76,0.16h0.03c0.49,0,0.93-0.32,1.08-0.79l0.7-2.15l0.01-0.05c0.04-0.18,0.19-0.56,0.39-0.63
        c0.15-0.05,0.41,0.08,0.72,0.35c0.8,0.71,2.65,1.7,5.48,2.93c0.49,0.21,1.04,0.18,1.51-0.1c0.46-0.27,0.75-0.76,0.79-1.29
        c0.06-0.8-0.45-1.52-1.22-1.72c-3.96-1.03-6.99-4.82-7.32-5.25l-0.04-0.05c-1.69-1.71-3.16-1.24-3.88-0.81
        C7.62,8.09,7.1,8.73,6.82,9.49c-0.94,2.54-2.66,5.63-3.17,6.52c-0.13,0.22-0.13,0.49,0,0.71C3.77,16.95,4,17.08,4.25,17.09z
         M18.82,16.02c-2.66-1.16-4.51-2.14-5.22-2.77c-0.6-0.53-1.16-0.71-1.67-0.54c-0.75,0.25-0.99,1.14-1.03,1.32l-0.69,2.13
        c-0.02,0.07-0.08,0.11-0.16,0.11l-5.33-0.15c0.77-1.38,2.18-4,3.03-6.29c0.21-0.55,0.57-1.01,1.02-1.28
        c0.85-0.5,1.75-0.29,2.66,0.63c0.34,0.45,3.49,4.46,7.83,5.58c0.31,0.08,0.52,0.38,0.49,0.7c-0.02,0.22-0.13,0.41-0.32,0.52
        C19.24,16.09,19.02,16.11,18.82,16.02z M11.77,8.21c0.01,0.01,0.02,0.02,0.03,0.03C11.8,8.23,11.78,8.22,11.77,8.21z M11.13,7.75
        C11.14,7.75,11.14,7.76,11.13,7.75C11.14,7.76,11.14,7.75,11.13,7.75z"/>
    <rect x="-0.02" y="30.23" class="st1" width="32.03" height="0.98"/>
</g>
</svg>Spa Service <a href="#" class="MenuPdf">(see the Menu)</a>
</p>
</li>


<li class="closeFacilities">
    <p>
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
<style type="text/css">
    .st0{fill:none;}
    .st1{fill:#952524;}
</style>
<g>
    <rect y="0" class="st0" width="32" height="32"/>
</g>
<g>
    <path class="st1" d="M27.17,8.9h-3.98V6.22c0-2.81-2.28-5.08-5.08-5.08h-4.2c-2.81,0-5.08,2.28-5.08,5.08V8.9H4.83
        c-2.66,0-4.81,2.15-4.81,4.81v12.33c0,2.66,2.16,4.81,4.81,4.81h22.33c2.66,0,4.81-2.16,4.81-4.81V13.72
        C31.98,11.06,29.82,8.9,27.17,8.9 M27.17,9.91c2.1,0,3.81,1.71,3.81,3.81v12.33c0,2.1-1.71,3.81-3.81,3.81H4.83
        c-2.1,0-3.81-1.7-3.81-3.81V13.72c0-2.1,1.71-3.81,3.81-3.81h3.96c0.57,0,1.03-0.46,1.03-1.03V6.22c0-2.25,1.83-4.08,4.08-4.08h4.2
        c2.25,0,4.08,1.83,4.08,4.08v2.66c0,0.57,0.46,1.03,1.03,1.03H27.17z"/>
    <path class="st1" d="M16,10.79c-4.37,0-7.92,3.56-7.92,7.92c0,4.37,3.55,7.92,7.92,7.92c4.37,0,7.92-3.56,7.92-7.92
        C23.92,14.35,20.37,10.79,16,10.79 M22.92,18.72c0,3.82-3.1,6.92-6.92,6.92c-3.81,0-6.92-3.1-6.92-6.92c0-3.82,3.1-6.92,6.92-6.92
        C19.81,11.8,22.92,14.9,22.92,18.72"/>
    <path class="st1" d="M16,14.67c2.24,0,4.05,1.82,4.05,4.05c0,2.24-1.81,4.05-4.05,4.05c-2.24,0-4.05-1.81-4.05-4.05
        C11.95,16.48,13.76,14.67,16,14.67 M16,14.13c-2.53,0-4.58,2.06-4.58,4.59c0,2.53,2.06,4.58,4.58,4.58c2.53,0,4.58-2.06,4.58-4.58
        C20.58,16.19,18.53,14.13,16,14.13"/>
    <rect x="13.14" y="5.45" class="st1" width="5.72" height="0.53"/>
</g>
</svg>Tour and Activity Service
   
</p>
</li>


<li class="closeFacilities">
    <p>
       <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
        <style type="text/css">
            .st0{fill:none;}
            .st1{fill:#952524;}
        </style>
        <rect class="st0" width="32" height="32"></rect>
        <g>
            <path class="st1" d="M0.6,16.8h5.7L7.2,16H0.8C0.8,14.3,2.3,13,4,13h2.2c1,0,2,0.5,2.6,1.4l0.1,0.1l0.6-0.5l0-0.1
            c-0.8-1-1.9-1.6-3.2-1.6H4c-2.2,0-4,1.8-4,4C0,16.5,0.3,16.8,0.6,16.8"></path>
            <path class="st1" d="M29.8,18.8L28,18.4l-2-2.8l0,0c-0.8-0.9-1.8-1.3-3-1.3H15c-1.3,0-2.5,0.5-3.4,1.4l-3.7,3.5H4.8
            c-1.9,0-3.5,1.5-3.6,3.4l0,0.5c0,0.7,0.2,1.4,0.7,1.9c0.5,0.5,1.2,0.8,1.9,0.8H5c0.2,1.6,1.6,2.8,3.3,2.8c1.6,0,3-1.2,3.3-2.8h10.8
            c0.2,1.6,1.6,2.8,3.3,2.8c1.6,0,3-1.2,3.3-2.8h0.5c1.5,0,2.7-1.2,2.7-2.7v-1.6C32,20.2,31.2,19.1,29.8,18.8 M23.2,24.9
            c0.2-1.2,1.2-2,2.3-2c1.2,0,2.1,0.8,2.3,2c0,0.1,0,0.3,0,0.4c0,0.1,0,0.2,0,0.4c-0.2,1.2-1.2,2-2.3,2c-1.2,0-2.1-0.8-2.3-2
            c0-0.1,0-0.3,0-0.4C23.2,25.2,23.2,25.1,23.2,24.9 M5.9,24.9c0.2-1.2,1.2-2,2.3-2c1.2,0,2.1,0.8,2.3,2c0,0.1,0,0.3,0,0.4
            c0,0.1,0,0.2,0,0.4c-0.2,1.2-1.2,2-2.3,2c-1.2,0-2.1-0.8-2.3-2c0-0.1,0-0.3,0-0.4C5.9,25.2,5.9,25.1,5.9,24.9 M15,15.2h7.9
            c0.9,0,1.7,0.4,2.3,1l2.2,3l0,0l2.2,0.4c0.9,0.2,1.5,0.9,1.5,1.7v1.6c0,1-0.8,1.8-1.8,1.8h-0.5c-0.2-1.6-1.6-2.8-3.3-2.8
            c-1.6,0-3,1.2-3.3,2.8H11.5C11.3,23.2,9.9,22,8.2,22c-1.6,0-3,1.2-3.3,2.8H3.8c-0.5,0-0.9-0.2-1.2-0.5c-0.3-0.3-0.5-0.8-0.5-1.2
            l0-0.5C2.2,21.2,3.4,20,4.8,20h3.5l3.9-3.7C13,15.6,14,15.2,15,15.2"></path>
            <path class="st1" d="M8.4,6.5c0-1.7-1.4-3.1-3.1-3.1H4.6c-1.7,0-3.1,1.4-3.1,3.1c0,0.3,0.1,0.5,0.3,0.7C1.6,7.7,1.5,8.1,1.5,8.6
            C1.5,10.5,3,12,4.8,12c1.8,0,3.4-1.5,3.4-3.4c0-0.4-0.1-0.9-0.3-1.3C8.2,7.2,8.4,6.9,8.4,6.5z M4.8,11.4c-1.5,0-2.7-1.2-2.7-2.7
            c0-0.4,0.1-0.8,0.3-1.2c0,0,0,0,0,0h4.9c0.2,0.4,0.3,0.8,0.3,1.2C7.5,10.1,6.3,11.4,4.8,11.4z M7.5,6.8C7.5,6.8,7.5,6.8,7.5,6.8
            l-5.2,0c-0.1,0-0.2,0-0.2-0.1C2.1,6.7,2.1,6.6,2.1,6.5c0-0.1,0-0.1,0-0.2c0-0.1,0-0.3,0-0.3c0-0.2,0.1-0.4,0.1-0.4
            C2.6,4.7,3.5,4,4.6,4h0.6c1.1,0,2,0.7,2.4,1.7C7.7,5.8,7.7,6,7.7,6.1l0,0c0,0,0,0,0,0c0,0,0,0,0,0l0,0c0,0.1,0,0.3,0,0.3
            c0,0.1,0,0.1,0,0.2C7.8,6.7,7.7,6.8,7.5,6.8z"></path>
        </g>
    </svg> Car with driver Service
        
</li>


<li class="closeFacilities">
    <p>
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
<style type="text/css">
    .st0{fill:none;}
    .st1{fill:#952524;}
</style>
<g>
    <rect y="0" class="st0" width="32" height="32"/>
</g>
<g>
    <polygon class="st1" points="22.11,18.04 17.96,13.71 17.96,6.23 16.97,6.23 16.97,14.11 21.33,18.65 21.4,18.73 22.09,18.06   "/>
    <path class="st1" d="M17.82,0.51c-3.35,0-6.56,1.26-9.03,3.54L8.73,4.12l0.66,0.73l0.08-0.07c2.07-1.92,4.76-3.08,7.57-3.27v2.24
        h0.99V1.5c6.53,0.1,11.96,5.48,12.11,12.01h-2.34v0.99h2.33c-0.28,5.05-3.71,9.48-8.54,11.03l-0.1,0.03l0.29,0.91l0.01,0.02
        l0.1-0.03c5.53-1.77,9.24-6.86,9.24-12.66C31.12,6.48,25.16,0.51,17.82,0.51"/>
    <path class="st1" d="M15.48,22.64c-0.25-0.19-0.58-0.22-0.85-0.06l-1.85,1.07c-0.1,0.06-0.18,0.16-0.21,0.27
        c-0.03,0.12-0.02,0.24,0.05,0.35c0.15,0.25,0.47,0.34,0.72,0.19l1.66-0.96l3.91,3.05l-2.6,3.89C2.78,23.02,1.9,8.86,1.87,6.02h5.35
        l0.62,5.16l-1.72,0.89c-0.15,0.08-0.27,0.22-0.32,0.38c-0.05,0.17-0.04,0.34,0.04,0.5c0.04,0.08,0.11,0.14,0.2,0.17
        c0.08,0.03,0.17,0.02,0.25-0.02l2.21-1.15c0.24-0.13,0.38-0.39,0.35-0.66L8.16,5.51C8.12,5.24,7.89,5.03,7.61,5.03H1.72
        c-0.02,0-0.04,0-0.06,0c-0.23,0-0.42,0.06-0.55,0.19C0.91,5.39,0.88,5.63,0.88,5.73c-0.02,1.06,0.05,4.88,1.63,9.59
        c1.64,4.89,5.31,11.65,13.47,16.08c0.08,0.04,0.25,0.09,0.44,0.09c0.24,0,0.43-0.1,0.57-0.3l2.87-4.3
        c0.21-0.31,0.14-0.72-0.15-0.95L15.48,22.64z M8.96,24.65c0.13,0.14,0.25,0.28,0.38,0.42C9.21,24.93,9.08,24.79,8.96,24.65
         M10.69,26.43c0.15,0.14,0.3,0.27,0.45,0.41C10.99,26.71,10.84,26.57,10.69,26.43 M12.67,28.1c0.15,0.11,0.3,0.23,0.45,0.34
        C12.97,28.33,12.81,28.22,12.67,28.1 M14.91,29.66c0.13,0.08,0.26,0.16,0.39,0.24C15.17,29.81,15.04,29.74,14.91,29.66"/>
</g>
</svg>Motorbike Service
</p>
</li>

</div>



<div class="FIve16li five3Li">
    <li class="closeFacilities">
        <p>
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
        <style type="text/css">
            .st0{fill:none;}
            .st1{fill:#952524;}
        </style>
        <rect class="st0" width="32" height="32"></rect>
        <g>
            <polygon class="st1" points="22.1,18 18,13.7 18,6.2 17,6.2 17,14.1 21.3,18.7 21.4,18.7 22.1,18.1   "></polygon>
            <path class="st1" d="M17.8,0.5c-3.4,0-6.6,1.3-9,3.5L8.7,4.1l0.7,0.7l0.1-0.1c2.1-1.9,4.8-3.1,7.6-3.3v2.2h1V1.5
            c6.5,0.1,12,5.5,12.1,12h-2.3v1h2.3c-0.3,5-3.7,9.5-8.5,11l-0.1,0l0.3,0.9l0,0l0.1,0c5.5-1.8,9.2-6.9,9.2-12.7
            C31.1,6.5,25.2,0.5,17.8,0.5z"></path>
            <path class="st1" d="M15.5,22.6c-0.2-0.2-0.6-0.2-0.9-0.1l-1.9,1.1c-0.1,0.1-0.2,0.2-0.2,0.3c0,0.1,0,0.2,0,0.4
            c0.1,0.3,0.5,0.3,0.7,0.2l1.7-1l3.9,3.1l-2.6,3.9C2.8,23,1.9,8.9,1.9,6h5.4l0.6,5.2l-1.7,0.9c-0.2,0.1-0.3,0.2-0.3,0.4
            c-0.1,0.2,0,0.3,0,0.5C5.9,13,6,13.1,6,13.1c0.1,0,0.2,0,0.3,0L8.5,12c0.2-0.1,0.4-0.4,0.3-0.7L8.2,5.5C8.1,5.2,7.9,5,7.6,5H1.7
            c0,0,0,0-0.1,0C1.4,5,1.2,5.1,1.1,5.2C0.9,5.4,0.9,5.6,0.9,5.7c0,1.1,0.1,4.9,1.6,9.6C4.2,20.2,7.8,27,16,31.4
            c0.1,0,0.3,0.1,0.4,0.1c0.2,0,0.4-0.1,0.6-0.3l2.9-4.3c0.2-0.3,0.1-0.7-0.2-1L15.5,22.6z M9,24.7c0.1,0.1,0.3,0.3,0.4,0.4
            C9.2,24.9,9.1,24.8,9,24.7z M10.7,26.4c0.1,0.1,0.3,0.3,0.5,0.4C11,26.7,10.8,26.6,10.7,26.4z M12.7,28.1c0.1,0.1,0.3,0.2,0.5,0.3
            C13,28.3,12.8,28.2,12.7,28.1z M14.9,29.7c0.1,0.1,0.3,0.2,0.4,0.2C15.2,29.8,15,29.7,14.9,29.7z"></path>
        </g>
    </svg>24h Assistance      
    
    </p>
</li>

<li class="closeFacilities">
    <p>
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
        <style type="text/css">
            .st0{fill:none;}
            .st1{fill:#952524;}
        </style>
        <rect class="st0" width="32" height="32"></rect>
        <g>
            <path class="st1" d="M16,4c-3.3,0-6,2.7-6,6c0,3.3,2.7,6,6,6s6-2.7,6-6C22,6.7,19.3,4,16,4z M16,15c-2.8,0-5-2.3-5-5
            c0-2.8,2.3-5,5-5c2.8,0,5,2.3,5,5C21,12.8,18.8,15,16,15z"></path>
            <path class="st1" d="M16,18.3c-6.6,0-11.3,3.3-11.3,7.9c0,1,0.8,1.8,1.8,1.8h19.1c1,0,1.8-0.8,1.8-1.8C27.3,21.7,22.6,18.3,16,18.3
            z M25.5,27H6.5c-0.4,0-0.8-0.4-0.8-0.8c0-3.9,4.3-6.8,10.3-6.9h0c5.7,0,10.3,3.1,10.3,6.9C26.3,26.7,26,27,25.5,27z"></path>
        </g>
    </svg>5 Working Staff (Concierge, House Keeping, Maintanance)
        
</p>
</li>

<li class="closeFacilities">
    <p>
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
        <style type="text/css">
            .st0{fill:none;}
            .st1{fill:#952524;}
        </style>
        <rect class="st0" width="32" height="32"></rect>
        <g>
            <path class="st1" d="M26.8,1.4H5.2c-1.1,0-2,0.9-2,2v25.1c0,1.1,0.9,2,2,2h21.7c1.1,0,2-0.9,2-2V3.4C28.9,2.3,28,1.4,26.8,1.4z
            M4.1,3.4c0-0.6,0.5-1.1,1-1.1h21.7c0.6,0,1.1,0.5,1.1,1.1v3H4.1V3.4z M27.9,7.5v21.1c0,0.6-0.5,1-1.1,1H5.2c-0.6,0-1-0.5-1-1V7.5
            H27.9z"></path>
            <path class="st1" d="M16,26.1c4.4,0,7.9-3.6,7.9-7.9c0-4.4-3.6-7.9-7.9-7.9s-7.9,3.6-7.9,7.9C8.1,22.5,11.6,26.1,16,26.1z
            M9.1,18.1c0-3.8,3.1-6.9,6.9-6.9c3.8,0,6.9,3.1,6.9,6.9s-3.1,6.9-6.9,6.9C12.2,25.1,9.1,22,9.1,18.1z"></path>
            <path class="st1" d="M16,22.6c2.5,0,4.5-2,4.5-4.5c0-2.5-2-4.5-4.5-4.5c-2.5,0-4.5,2-4.5,4.5C11.5,20.6,13.5,22.6,16,22.6z
            M12.5,18.1c0-1.9,1.6-3.5,3.5-3.5c1.9,0,3.5,1.6,3.5,3.5s-1.6,3.5-3.5,3.5C14.1,21.6,12.5,20.1,12.5,18.1z"></path>
            <circle class="st1" cx="6.9" cy="4.3" r="1.1"></circle>
        </g>
    </svg>Laundry Service
    
</p>
</li>


<li class="closeFacilities">
    <p>
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
        <style type="text/css">
            .st0{fill:none;}
            .st1{fill:#952524;}
        </style>
        <rect class="st0" width="32" height="32"></rect>
        <g>
            <path class="st1" d="M3.6,1.7l-0.1,0l-2.5,9.7c-0.1,0.5-0.1,1.1,0.2,1.6c0.3,0.5,0.7,0.8,1.3,1l6.5,1.7l-1.2,6.9H5.1
            c-0.2-2.3-2.1-4-4.4-4H0v11.9h0.7c2.2,0,4.1-1.6,4.4-3.8h5.7l2.1-9.9l6.6,1.7c1.5,0.4,3-0.5,3.3-2l0-0.1l2,1.9
            c0.1,0.1,0.3,0.1,0.4,0.1c0.2,0,0.3-0.2,0.3-0.3l1.6-6l0.5,0.1c0.3,0.1,0.6,0.1,0.9,0.1c1.6,0,3-1.1,3.4-2.6L32,9.2l0,0L3.6,1.7z
            M11.9,16.4l-2,9.1H5.1v-2h3.4l1.4-7.6L11.9,16.4z M26.1,11.7l-1.4,5.1L23,15.2l1-4L26.1,11.7z M23.1,11l-1.4,5.2
            c-0.1,0.5-0.4,0.8-0.8,1.1c-0.4,0.2-0.9,0.3-1.3,0.2L2.7,13c-0.3-0.1-0.5-0.3-0.7-0.5s-0.2-0.5-0.1-0.8l1.5-5.8L23.1,11z
            M27.8,11.2L3.6,4.8l0.5-2l26.6,7C30.2,10.9,29,11.5,27.8,11.2z M1,29.3v-9.9c1.8,0.2,3.1,1.6,3.1,3.4v3C4.1,27.7,2.7,29.2,1,29.3z
            "></path>
            <path class="st1" d="M16.4,12.2l2.9,0.8c0,0,0.1,0,0.1,0c0.2,0,0.4-0.1,0.5-0.4c0-0.1,0-0.3,0-0.4c-0.1-0.1-0.2-0.2-0.3-0.2
            l-2.9-0.8c-0.3-0.1-0.5,0.1-0.6,0.4c0,0.1,0,0.3,0,0.4C16.1,12.1,16.3,12.2,16.4,12.2z"></path>
        </g>
    </svg>24h Security and CCTV System
   
</p>
</li>


<li class="closeFacilities">
    <p>
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
            <style type="text/css">
                .st0{fill:none;}
                .st1{fill:#952524;}
            </style>
            <rect class="st0" width="32" height="32"></rect>
            <g>
                <path class="st1" d="M26.7,0.5H5.3c-2.7,0-4.8,2.2-4.8,4.8v21.3c0,2.7,2.2,4.8,4.8,4.8h21.3c2.7,0,4.8-2.2,4.8-4.8V5.3
                C31.5,2.7,29.3,0.5,26.7,0.5 M26.7,30.3H5.3c-2,0-3.7-1.7-3.7-3.7V5.3c0-2,1.7-3.7,3.7-3.7h21.3c2,0,3.7,1.7,3.7,3.7v21.3
                C30.3,28.7,28.7,30.3,26.7,30.3"></path>
                <path class="st1" d="M20.6,9.3L20.6,9.3C19.6,8.4,18.5,8,17.2,8h-5.3v16H13v-6.9h4.1c1.4,0,2.5-0.4,3.4-1.3c0.9-0.9,1.4-2,1.4-3.2
                C22,11.3,21.5,10.2,20.6,9.3z M19.7,15c-0.7,0.7-1.5,1-2.5,1H13v-7h4.2c1,0,1.9,0.4,2.5,1.1c0.7,0.7,1,1.5,1,2.4
                C20.8,13.5,20.4,14.3,19.7,15z"></path>
            </g>
        </svg> Free parking
    
        
</li>


<li class="closeFacilities">
    <p>
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
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
    </svg>Address: Jalan Kunti 1, Gang Mangga N.1AB, Seminyak <a href="#headingThree" id="seeTheMap" class="MenuPdf">(see the Map)</a>
</p>
</li>

</div>



</ul>

</div>
</div>
</div>
</div>


<!-- <div id="loadMore">Load more</div>
    <div id="showLess">Show less</div> -->
    <div class="viewallbtn_div"> 
        <button class="viewallbtn_12 viewMoreAmenities" id="loadMoreSv" >View More Facilties</button>
        <button class="viewallbtn_12 CloseFaceBtn scrollToTop1" id="showLessSv">Close Facilties</button>
    </div>
</div>



<!-- ===============TRIAL ICON DEMO START========== -->
<!-- 

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

</div> -->
<!-- ===============TRIAL ICON DEMO END========== -->




<!-- ===============TRIAL ICON DEMO START========== -->


<!-- <div class="TRIALICON" style="margin-top: 30px;">

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

</div> -->
<!-- ===============TRIAL ICON DEMO END========== -->





<!-- ===============TRIAL ICON DEMO START========== -->


<!-- <div class="TRIALICON" style="margin-top: 30px;">

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

</div> -->
<!-- ===============TRIAL ICON DEMO END========== -->



<div class="StiBlokBar">

    <div class="SinglChkBOxag">

        <div class="SidebarFrom SingSideABVila">
            <form method="post" action="#" id="booking1">
                <!-- <p>from 17,471 ₨ per night </p> -->
                <div class="side_new">
                    <div class="row">

                        <div class="col-md-4 col-sm-4 col-4 MobChkPdall">
                            <div class="form-group BannrGrup mobbneergrop2 mb_20">
                                <input type="text" placeholder="Check-IN" class="form-control" id="startDateMob1" name="start_date" autocomplete="off" readonly="">   
                                <label class="lnr lnr-calendar-full" for="start_date"></label> 
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-4 MobChkPdall">
                            <div class="form-group BannrGrup mobbneergrop2 mb_20">
                                <input type="text" placeholder="Check-OUT" class="form-control" id="endDateMob1" name="end_date" autocomplete="off" readonly=""> 
                                <label class="lnr lnr-calendar-full" for="end_date"></label> 
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-4 col-4 MobChkPdall">
                            <div class="form-group BannrGrup mobbneergrop2 mb_20 PixBtnMr1">
                                <button type="button" class="btn SubBtn BkNow">Book Now</button>
                            </div>
                        </div>

                        <div id="total_rupees1" class="TotRu109">
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
                            <!-- <li class="MaxwiLi1"><a href="#VidClick1" class="MaxwiLi1show">Video</a></li> -->
                            <li class="MaxwiLi1"><a href="#" class="MaxwiLi1show" data-lid="VidClick1">Video</a></li>
                            <!-- <li class="MaxwiLi2"><a href="#GalClick1" class="MaxwiLi2show">Gallery</a></li> -->
                            <li class="MaxwiLi2"><a href="#" class="MaxwiLi2show" data-lid="GalClick1">Gallery</a></li>
                          <!--   <li class="MaxwiLi3"><a href="#FplanClick1" class="MaxwiLi3show">Floor Plan</a></li> -->
                            <li class="MaxwiLi3"><a href="#" class="MaxwiLi3show" data-lid="FplanClick1">Floor Plan</a></li>
                            <!-- <li class="MaxwiLi4"><a href="#LocClick1" class="MaxwiLi4show">Location</a></li> -->
                            <li class="MaxwiLi4"><a href="#" class="MaxwiLi4show" data-lid="LocClick1">Location</a></li>
<!--                             <li class="MaxwiLi5"><a href="#RatClick1" class="MaxwiLi5show">Rates</a></li>
 -->                            <li class="MaxwiLi5"><a href="#" class="MaxwiLi5show" data-lid="RatClick1">Rates</a></li>
                            <!-- <li class="MaxwiLi6"><a href="#AvaClick1" class="MaxwiLi6show">Availability</a></li> -->
                            <li class="MaxwiLi6"><a href="#" class="MaxwiLi6show" data-lid="AvaClick1">Availability</a></li>
                            <!-- <li class="MaxwiLi7"><a href="#RevClick1" class="MaxwiLi7show">Review</a></li> -->
                            <li class="MaxwiLi7"><a href="#" class="MaxwiLi7show" data-lid="RevClick1">Review</a></li>
                            <!-- <li class="MaxwiLi8"><a href="#feaClick1" class="MaxwiLi8show">Feature</a></li> -->
                            <li class="MaxwiLi8"><a href="#" class="MaxwiLi8show" data-lid="feaClick1">Feature</a></li>
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
                                </svg> Video <span class="tour_i"><i class="fa fa-angle-up rotate-icon"></i><span></h5>
                            </a>
                        </div>
                        <!-- Card body -->
                        <div id="collapseOne" class="collapse collapse_div show" role="tabpanel" aria-labelledby="headingOne" style="">
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

                                Gallery <span class="tour_i"><i class="fa fa-angle-up rotate-icon"></i><span></h5>
                            </a>
                        </div>
                        <!-- Card body -->
                        <div id="collapseTwo" class="collapse collapse_div" role="tabpanel" aria-labelledby="headingTwo" style="">
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
                                        <a data-fancybox="gallery" href="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/16-VILLA-SENSEL-FRONT-VIEW-1B.jpg" data-caption="Swimming">
                                            <img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/10/16-VILLA-SENSEL-FRONT-VIEW-1B.jpg" alt="Image" class="img-fluid" >
                                        </a>
                                    </div>
                                    <div class="carousel-item">
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
                                        </svg>Bath Amenities</p>

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
            </svg> Floor Plan <span class="tour_i"><i class="fa fa-angle-up rotate-icon"></i><span></h5>
        </a>
    </div>
    <!-- Card body -->
    <div id="collapseEight" class="collapse collapse_div" role="tabpanel" aria-labelledby="headingEight" style="">
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
            </svg> Location <span class="tour_i"><i class="fa fa-angle-up rotate-icon"></i><span></h5>
        </a>
    </div>
    <!-- Card body -->
    <div id="collapseThree" class="collapse collapse_div" role="tabpanel" aria-labelledby="headingThree" style="">
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
            </svg> Rate <span class="tour_i"><i class="fa fa-angle-up rotate-icon"></i><span></h5>
        </a>
    </div>
    <!-- Card body -->
    <div id="collapseFour" class="collapse collapse_div" role="tabpanel" aria-labelledby="headingFour" style="">
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
                    <tbody id="ratesSection">
<!--   <tr>
<td class="FromTdM">From 09-jan to 16-jul</td>
<td>low season</td>
<td>1 night</td>
<td>USD $209</td>
</tr> -->

<!--    <tr>
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
</tr> -->
</tbody>
</table>

<div class="row">
    <div class="col-md-12 col-sm-12 col-12">
        <div class="CurTable Curtab22">
            <select class="selector ftNselct currency_select11">
                <option value="dummy" <?php echo ($currency == 'dummy')?'selected':'';?>>Currency </option>
                <?php 
                foreach( $age as $x => $x_value ) { ?>
                    <option value="<?php echo $x; ?>" <?php echo ($currency == $x)?'selected':'';?>><?php echo $x." ".$x_value;?></option> 
                <?php } ?>
            </select>
        </div>
    </div>
</div>

<!-- ==================RATE ACCORDIAN AGAIN ALL============== -->

<div class="RateTCont brdrWmrgin RatepadinAl RatepadinAlMb">
    <h1 class="AlRCapti">ACCESS TO THE VILLA</h1>
    <div class="ChkInPaE">
        <p class="forChkBold  TimeB4Pos"><span>Check-IN time</span> : not before 02:00 pm</p>
        <p class="forChkBold  TimeB4Pos"><span>Check-OUT time</span> : not later than 11:00 am</p>
    </div>
    <div class="ChkInPaE">
        <p class="forChkBold  TimeB4Pos"><span>Early Check-IN </span> : not before 08:00 am</p>
        <p class="forChkBold  TimeB4Pos"><span>Late Check-OUT </span> : not later than 08:00 pm</p>
        <p class="ChargedFontp">charged an extra 50% on top of the published daily rates.</p>
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
    </svg> Airport Tranfser is on Request: 1 to 6 Guests: US$ 13.00/transfer; 7 to 8 Guests: US$ 16.00/transfer.</p>
</div>





<div id="accordionRateAg">
    <div class="card">
        <div class="card-header" role="tab" id="headingOneRateag">           
                <a data-toggle="collapse" data-target="#collapseOneRateag" aria-expanded="true" aria-controls="collapseOneRateag" class="iarrowclick22"> <h5 class="mb-0">LAST MINUTE RATE <i class="fa fa-angle-down rotate-icon"></i></h5></a>
            
        </div>

        <div id="collapseOneRateag" class="collapse" role="tabpanel" aria-labelledby="headingOneRateag" style="">
            <div class="card-body">
                <div class="RateTCont brdrWmrgin RatepadinAl RatepadinAlgrey ">
                    <!-- <h1 class="AlRCapti">LAST MINUTE RATE</h1> -->
                    <p class="forChkBold">They start around a month before any vacant day.</p>
                    <p class="ChargedFontp">Select your C-IN and C-OUT dates to view all the updated and last minute rates to get your final quotation. </p>
                    <p class="forChkBold forchbm20">In the last minute rental rate, breakfast and airport transfer are not included.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" role="tab" id="headingTwoRateag">
             <a data-toggle="collapse" data-target="#collapseTwoRateag" aria-expanded="true" aria-controls="collapseTwoRateag" class="iarrowclick22"> <h5 class="mb-0">EXTRA GUESTS <i class="fa fa-angle-down rotate-icon"></i></h5></a>
            <!-- <h5 class="mb-0">
                <a class="collapse iarrowclick22" data-toggle="collapse" data-target="#collapseTwoRateag" aria-expanded="false" aria-controls="collapseTwoRateag"
                >EXTRA GUESTS<i class="fa fa-angle-up rotate-icon"></i></a>
            </h5> -->
        </div>
        <div id="collapseTwoRateag" class="collapse" role="tabpanel" aria-labelledby="headingTwoRateag" style="">
            <div class="card-body">
                <div class="RateTCont brdrWmrgin RatepadinAl RatepadinAlgrey">
                    <!-- <h1 class="AlRCapti">EXTRA GUESTS</h1> -->
                    <p class="forChkBold">Maximum capacity of the VIlla: 10 Guests.</p>
                    <p class="forChkBold">Each extra guest over the maximum capacity of the villa (two people per bedroom) will be charged according to the updated rates.</p>
                    <p class="ChargedFontp">Select your C-IN and C-OUT dates and continue with [Book Now] to the page “Choose Extra” to view and select the updated rate for any extra guest you require and get your final quotation.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingThreeRateag">
           
                <a class="collapsed iarrowclick22" data-toggle="collapse" data-target="#collapseThreeRateag" aria-expanded="false" aria-controls="collapseThreeRateag"> <h5 class="mb-0">EXTRA BED<i class="fa fa-angle-down rotate-icon"></i></h5></a>
            
        </div>
        <div id="collapseThreeRateag" class="collapse" aria-labelledby="headingThreeRateag" style="">
            <div class="card-body">
                <div class="RateTCont brdrWmrgin RatepadinAl RatepadinAlgrey">
                    <!-- <h1 class="AlRCapti">EXTRA BED</h1> -->
                    <p class="forChkBold">In this villa, not all bedrooms are designed to contain an extra bed.</p>
                    <p class="forChkBold">Our beds and mattresses are super king size and can comfortably sleep three people if necessary, especially if the extra person is a child.</p>
                    <p class="ChargedFontp">In case an extra bed is anyway required, we will charge US$ 15,00/night and we kindly ask you to contact us to request it during your reservation and get more information about it.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingFourRateag">
           
                <a class="collapsed iarrowclick22" data-toggle="collapse" data-target="#collapseFourRateag" aria-expanded="false" aria-controls="collapseFourRateag"> <h5 class="mb-0">CHILDREN IN THE VILLA<i class="fa fa-angle-down rotate-icon"></i></h5></a>
            
        </div>
        <div id="collapseFourRateag" class="collapse" aria-labelledby="headingFourRateag" style="">
            <div class="card-body">
                <div class="RateTCont brdrWmrgin RatepadinAl RatepadinAlgrey">
                   <!--  <h1 class="AlRCapti">CHILDREN IN THE VILLA</h1> -->
                    <p class="forChkBold Forchkbold2air">All children are very welcome at Minggu VIllas, and in case the total of them go over the maximum capacity of the villa, depend on their age, they will be either accomodated free or at a discounted rate as follow:</p>
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
                    </ul>
                    <p>For more information or book something extra, please don’t hesitate to contact us.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingFiveRateag">
            
                <a class="collapsed" data-toggle="collapse" data-target="#collapseFiveRateag" aria-expanded="false" aria-controls="collapseFiveRateag"><h5 class="mb-0">PAYMENT SCHEDULE<i class="fa fa-angle-down rotate-icon"></i></h5></a>
            
        </div>
        <div id="collapseFiveRateag" class="collapse" aria-labelledby="headingFiveRateag" style="">
            <div class="card-body">
                <div class="RateTCont brdrWmrgin RatepadinAl RatepadinAlgrey">
                    <!-- <h1 class="AlRCapti">PAYMENT SCHEDULE</h1> -->
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
            </svg>Availability <span class="tour_i"><i class="fa fa-angle-up rotate-icon"></i><span></h5>
        </a>
    </div>
    <!-- Card body -->
    <div id="collapseFive" class="collapse collapse_div" role="tabpanel" aria-labelledby="headingFive" style="">
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
            </svg>Review <span class="tour_i"><i class="fa fa-angle-up rotate-icon"></i><span></h5>
        </a>
    </div>
    <!-- Card body -->
    <div id="collapseSix" class="collapse collapse_div" role="tabpanel" aria-labelledby="headingSix" style="">
        <div class="card-body">
<!-- <div class="Symkheading">
<h1>Reviews</h1>    
</div> -->

<div class="ReviewUl singlrev">
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
            <div class="col-md-6 col-sm-6 col-6">
                <a href="javascript:void(0);" class="btn btn-cta ViewMob100 ViewMoreReview">View More</a>
            </div>

            <div class="col-md-6 col-sm-6 col-6">
                <a href="javascript:void(0);" class="btn btn-cta ViewSIngNw ViewMob100 CloseReview">Close Review</a>
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
            </svg> Features <span class="tour_i"><i class="fa fa-angle-up rotate-icon"></i><span></h5>
        </a>
    </div>
    <!-- Card body -->
    <div id="collapseSeven" class="collapse collapse_div" role="tabpanel" aria-labelledby="headingSeven" style="">
        <div class="card-body">
            <div class="FeaturTabRe">






                <div class="FeatureTab2">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-12">
                            <div class="TAbULId">
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="EqualTbUlCell">
                                            <li><a href="#vliaInfoClick1">Info</a></li>
                                            <li><a href="#ExtraAtClick1">at the villa</a></li>
                                            <li><a href="#ExtraoutClick1">outside</a></li>
                                            <li><a href="#VillaAmenClick1">Amenities</a></li>
                                                <li><a href="#VillaLayClick1">Layout</a></li>


                                            </ul>
                                        </div>
                                    </div>
                                </div> 
                                <div class="FeatureTabMain2 childTabsExist" data-child="1">

                                    <!--Accordion wrapper-->
                                    <div id="accordionEx1" role="tablist">







                                        <!-- Accordion card -->
                                        <div class="card">

                                            <!-- Card header -->
                                            <div class="card-header" role="tab" id="headingTwo1">
                                                <a class="iarrowclick" data-toggle="collapse" data-parent="#accordionEx1" href="#collapseTwo1" aria-expanded="true" aria-controls="collapseTwo1" >
                                                <h5 class="mb-0 Mbimgsh"><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg"> Vila information <i class="fa fa-angle-down rotate-icon"></i> </h5>
                                            </a>
                                        </div>

                                        <!-- Card body -->

                                        <div id="collapseTwo1" class="collapse" role="tabpanel" aria-labelledby="headingTwo1" style="">
                                        <div class="card-body InnerCardFeat">
                                            <div class="row">
                                                <div class="col-md-3 col-sm-3 col-12">
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
                                                <div class="col-md-3 col-sm-3 col-12">
                                                    <div class="FeatureTabMain2vila">
                                                        <h1>Villa Welcome</h1>

                                                        <ul>
                                                            <li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Check-IN: 2pm</p></li>
                                                            <li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Check-OUT: 11am</p></li>
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
                                                <div class="col-md-3 col-sm-3 col-12">
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

                                                         <div class="col-md-3 col-sm-3 col-12">
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

                                                    <div class="col-md-3 col-sm-3 col-12">
                                                    <div class="FeatureTabMain2vila">
                                                        <h1>Children Facilities</h1>

                                                        <ul>
                                                            <li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Baby Cot (first set incl.)</p></li>
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


                                                <div class="col-md-3 col-sm-3 col-12">
                                                    <div class="FeatureTabMain2vila">
                                                        <h1>Working Staff</h1>

                                                        <ul>
                                                            <li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Everyday (8am to 4pm)</p></li>
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

                                    <div class="col-md-3 col-sm-3 col-12">
                                                    <div class="FeatureTabMain2vila">
                                                        <h1>Safety & Sanity</h1>

                                                        <ul>
                                                            <li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">24h Security</p></li>
                                                            <li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">CCTV System</p></li>
                                                            <li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Safety Box</p></li>
                                                            <li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">First Aid Need</p></li>
                                                            <li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">24h Doctor on Call</p></li>
                                                            <li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Smoke Detector</p></li>
                                                            <li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Fire Extinguisher</p></li>
                                                            <li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Fogging Insect</p></li>
                                                            <li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Spraying Mosquito</p></li>
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
                                        <a class="iarrowclick" data-toggle="collapse" data-parent="#accordionEx1" href="#collapseTwo21" aria-expanded="true" aria-controls="collapseTwo21">
                                        <h5 class="mb-0 Mbimgsh"><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Extra at the villa <i class="fa fa-angle-down rotate-icon"></i>
                                        </h5>
                                    </a>
                                </div>

                                <!-- Card body -->
                                <div id="collapseTwo21" class="collapse" role="tabpanel" aria-labelledby="headingTwo21"
                                style="">
                                <div class="card-body InnerCardFeat">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-3 col-12">
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
                                        <div class="col-md-3 col-sm-3 col-12">
                                            <div class="FeatureTabMain2vila">
                                                <h1>spa service <a href="#">see the menu</a></h1>

                                                <ul>
                                                    <li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg"> Massage (see the Menu)</p></li>
                                                    <li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Skin Treatments</p></li>
                                                    <li><p><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Beauty Treatments</p></li>
                                                </ul>
                                            </div>

                                        </div>
                                        <!--  =========COLUMN FOUR END========== -->


                                        <div class="col-md-3 col-sm-3 col-12">
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
                                         <div class="col-md-3 col-sm-3 col-12">
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

                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- Accordion card -->

                        <!-- Accordion card -->
                        <div class="card">

                            <!-- Card header -->
                            <div class="card-header" role="tab" id="headingThree31">
                                <a class="collapsed iarrowclick" data-toggle="collapse" data-parent="#accordionEx1" href="#collapseThree31"  aria-expanded="true" aria-controls="collapseThree31">
                                <h5 class="mb-0 Mbimgsh"><img src="https://www.mingguvillas.com/new/wp-content/uploads/2019/09/045.svg">Extra outside the villa<i class="fa fa-angle-down rotate-icon"></i>
                                </h5>
                            </a>
                        </div>

                        <!-- Card body -->
                        <div id="collapseThree31" class="collapse" role="tabpanel" aria-labelledby="headingThree31"
                        style="">
                        <div class="card-body InnerCardFeat">
                            <div class="row">
                                <div class="col-md-3 col-sm-3 col-12">
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
                                <div class="col-md-3 col-sm-3 col-12">
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
                              

                                </div>
                                <!--  =========COLUMN FOUR END========== --> 

                                <div class="col-md-3 col-sm-3 col-12">
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
                                <div class="col-md-3 col-sm-3 col-12">

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



                                <div class="col-md-3 col-sm-3 col-12">
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


                                <div class="col-md-3 col-sm-3 col-12">
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




                                <div class="col-md-3 col-sm-3 col-12">
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
                <div id="collapseFour41" class="collapse" role="tabpanel" aria-labelledby="headingFour41" style="">
                <div class="card-body InnerCardFeat">
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-12">
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
                        <div class="col-md-3 col-sm-3 col-12">
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
                        <div class="col-md-3 col-sm-3 col-12">
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



                        <div class="col-md-3 col-sm-3 col-12">
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
        <div id="collapseFive51" class="collapse" role="tabpanel" aria-labelledby="headingFive51" style="">
        <div class="card-body InnerCardFeat">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-12">
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
                <div class="col-md-3 col-sm-3 col-12">
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
                         <div class="col-md-3 col-sm-3 col-12">
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
                <div class="col-md-3 col-sm-3 col-12">
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



                <div class="col-md-3 col-sm-3 col-12">
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


                <div class="col-md-3 col-sm-3 col-12">
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

                <div class="col-md-3 col-sm-3 col-12">
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

                <div class="col-md-3 col-sm-3 col-12">
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

                <div class="col-md-3 col-sm-3 col-12">
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
        $("#start_date,#startDateMob1").datepicker({
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
$("#end_date,#endDateMob1").datepicker({
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

$(document).on('click','#seeTheMap',function(){
	$('#collapseThree').addClass('show');
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
                            alert('no');
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

$(document).on('click','.MaxwiLi2show',function(){
    $('#collapseTwo').addClass('show');
});
$(document).on('click','.MaxwiLi3show',function(){
    $('#collapseEight').addClass('show');
});
$(document).on('click','.MaxwiLi4show',function(){
    $('#collapseThree').addClass('show');
});
$(document).on('click','.MaxwiLi5show',function(){
    $('#collapseFour').addClass('show');
});
$(document).on('click','.MaxwiLi6show',function(){
    $('#collapseFive').addClass('show');
});
$(document).on('click','.MaxwiLi7show',function(){
    $('#collapseSix').addClass('show');
});
$(document).on('click','.MaxwiLi8show',function(){
    $('#collapseSeven').addClass('show');
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
    $(this).find('i').toggleClass('fa fa-angle-up fa fa-angle-down');
});

$('.iarrowclick22').click(function(){
    $(this).find('i').toggleClass('fa fa-angle-down fa fa-angle-up');
});
</script>

<script>
    $(document).ready(function(){
       // $('.tour_i').html('<i class="fa fa-angle-down rotate-icon"></i>');
        $(".viewallbtn_1").click(function(){
            $("#viewsectn-1").show();
            $(this).hide();
        });
        $('.CloseFaceBtn').hide();
        $('.CloseReview').hide();
        $('.FIve16li').hide();

        $(document).on('click','.MainWidth-ul li a', function(){
            var href = $(this).data('lid');
            var deduct = 90;
            if ($(window).width() < 767) {
                deduct = 217;
            }
            $('html, body').animate({
                scrollTop: $('#'+href).offset().top-deduct
            });
        });

        // var lastClickedOption = '';
        // $(document).on('click','.carddesign',function(){
        //     var _this = $(this);
        //     var id = _this.attr('id');
        //     var child = _this.find('.childTabsExist').data('child');//for featured only
	       //  $('.collapse_div').removeClass('show');
        //     //if(child != 1){
	       //      $('.tour_i').html('<i class="fa fa-angle-down rotate-icon"></i>');
	       //      if(lastClickedOption!=id){
	       //          _this.find('.tour_i').html('<i class="fa fa-angle-up rotate-icon"></i>');
	       //          lastClickedOption = id;
	       //          $('#'+id).find('.collapse_div').addClass('show');
	       //      }else{
	       //      	$('.tour_i').html('<i class="fa fa-angle-down rotate-icon"></i>');
	       //          lastClickedOption = '';
	       //      }
	       //  //}
        // });
    });

    // var view = 0;
    // $(document).on('click','.viewMoreAmenities',function(){
    //     view++;
    //     if(view>=1){
    //         $('.CloseFaceBtn').show();
    //     }else{
    //         $('.CloseFaceBtn').hide();
    //     }
    // });

    // $(document).on('click','.CloseFaceBtn',function(){
    //     $('.CloseFaceBtn').hide();
    // });
    var view = 0;
    $(document).on('click','.viewMoreAmenities',function(){
        view++;
        $('.viewMoreAmenities').show();
        if(view == 1){
            $('.sixteenLi').show();
        }else if(view == 2){
            $('.five1Li').show();
        }else if(view == 3){
            $('.five2Li').show();
        }else if(view == 4){
            $('.five3Li').show();
            $('.viewMoreAmenities').hide();
        }
        $('.CloseFaceBtn').hide();
        $('.CloseFaceBtn').show();
    });

    // $(document).on('click','.CloseFaceBtn',function(){
    //     view = 0;
    //     $('.FIve16li').hide();
    //     $('.CloseFaceBtn').hide();
    //     $('.viewMoreAmenities').show();
    // });


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

    $(document).ready(function(){
// Activate Carousel
// alert('test');
// $("#carouselExampleControls").carousel({interval: 3000});
// $("#carouselExampleControls2").carousel({interval: 3000});
// $("#carouselExampleControls3").carousel({interval: 3000});
// $("#carouselExampleControls4").carousel({interval: 3000});
// $("#carouselExampleControls5").carousel({interval: 3000});
// $("#carouselExampleControls6").carousel({interval: 3000});
// $("#carouselExampleControls7").carousel({interval: 3000});
// $("#carouselExampleControls8").carousel({interval: 3000});
// $("#carouselExampleControls9").carousel({interval: 3000});
// $("#carouselExampleControls10").carousel({interval: 3000});
// $("#carouselExampleControls11").carousel({interval: 3000});
// });
// $('.carousel').carousel({
//   interval: 5000
// })


var t;

var start = $('.carousel').find('.active').attr('data-interval');
t = setTimeout("$('.carousel').carousel({interval: 8000});", start-6000);

$('.carousel').on('slid.bs.carousel', function () {  
     clearTimeout(t);  
     var duration = $(this).find('.active').attr('data-interval');
    
})


</script>

<script type="text/javascript">
//Click event to scroll to top
$(".scrollToTop1").click(function() {
    $("html, body").animate({
        scrollTop: 300
    }, 800);
    view = 0;
    $('.FIve16li').hide();
    $('.CloseFaceBtn').hide();
    $('.viewMoreAmenities').show();
    return false;
});




 // $('.MaxwiLi4show').click(function() {
 //     $('html, body').animate({
 //        scrollTop: $("#LocClick1").offset().top
 //    }, 400);
 //  }); // left menu link3 click() scroll END


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
        line-height: 24px;
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
        /* text-align: center; */
        font-size: 14px !important;
        text-transform: capitalize;
        font-weight: bold;
        margin-bottom: 15px;
        padding: 0px 3px 4px 2px;
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
        font-size: 14px;
        /*font-weight: bold;*/
    }

    .ChkInPaE {
        margin-top: 15px;
        margin-bottom: 17px;
    }   
    .brdrWmrgin{
        /*border: 2px solid #222;*/
        /*margin-bottom: 22px;*/
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
    max-width: 18px;
    top: 4px;
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
        z-index: 998;
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
        margin: 28px 10px 26px 43px;
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
    /*.SesonTpa tr td {
        text-transform: capitalize;
    }*/
    .rightaliUL{
        padding: 6px 8px;
    }
    .RatepadinAl {
        padding: 35px 40px;
    }
    .faq_ins.forabvilaFaqins p.forChkBold {
        font-size: 14px !important;
    }
    ..faq_ins.forabvilaFaqins p.forChkBold.Forchkbold2air{
        font-size: 14px !important;
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
 /*   #myList li{ 
        display:none;
    }*/
    /*button#loadMoreSv {
        margin: 0;
    }*/
    ul#myList {
        margin: 0;
        /* padding: 9px; */
    }
   .viewallbtn_div {
background-color: #fff;
padding: 0px 24px 40px 24px;
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
        background: #f7f7f7;
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
    .TimeB4Pos{
        position: relative;
        padding-left: 126px;
    }
    .TimeB4Pos span{
        position: absolute;
        left: 0;
    }
    #GalClick1 .carousel-control-next-icon {
        background-image: url(https://www.mingguvillas.com/new/wp-content/uploads/2019/10/arrowSiR.png);
        /* max-width: 16px; */
        /* width: 100%; */
    }
    #GalClick1 .carousel-control-prev-icon {
        background-image: url(https://www.mingguvillas.com/new/wp-content/uploads/2019/10/arrowSiL.png);
        /* max-width: 16px; */
        /* width: 100%; */
    }
    .faq_ins .card-body p.ChargedFontp {
        font-size: 14px !important;
    }
    .forchbm20{
        margin-top:12px;
    }
.FIve16li {
margin-top: 20px;
/* border-top: 1px solid #f1f1f1; */
padding-bottom: 10px;
background: #fff;
padding: 10px 25px;
}
.mainFive {
background: #fff;
padding: 10px 25px;
}
    /*======30-09-19======*/
    /*======25-10-19======*/
.faq_ins .FeatureTabMain2vila ul li p {
    position: relative;
    padding-left: 16px;
    font-size: 12.5px !important;
    margin-bottom: 0px;
    letter-spacing: 0px;
}
.faq_ins.forabvilaFaqins .faq_ins .card-body {
    padding-bottom: 28px;
}
div#accordionRateAg .card {
    border: 0;
}
    /*======25-10-19======*/


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
        .SingSideABVila form#booking .MobChkPdall .BannrGrup label {
            right: 8px;
            font-size: 11px;
            top: 14px;
            width: 100%;
            text-align: right;
        }
        .SingSideABVila form#booking .BannrGrup input {
            padding: 7px;
            font-size: 12px;
        }
  /*      .FeatureTab2 .EqualTbUlCell li {
            display: inline-block;
            max-width: 97px;
            padding: 6px 4px 6px 4px;
        }*/
        .FeatureTab2 .EqualTbUlCell li {
    /*display: inline-block;*/
    display: table-cell;
    max-width: unset;
    padding: 6px 4px 6px 4px;
    /*width: unset;*/
    width: auto;
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
            max-width: 310px;
            margin: 0px auto;
            text-align: left;
            padding: 0px 0px 0px 0px;
            text-align: left;
        }
        .TAbULId ul li {
            display: inline-block;
            width: 100%;
            /*max-width: 78px;*/
            /* margin: 0px auto; */
            text-align: left;
            padding: 3px 0px;
        }
        ul.MainWidth-ul li {
            text-align: center;
        }
        .MainWidth-ul li.MaxwiLi1{
            max-width: 60px; 
        }
        .MainWidth-ul li.MaxwiLi2{
            max-width: 75px; 
        }
        .MainWidth-ul li.MaxwiLi3{
            max-width: 71px; 
        }
        .MainWidth-ul li.MaxwiLi4{
            max-width: 69px; 
        }
        .MainWidth-ul li.MaxwiLi5{
            max-width: 64px; 
        }
        .MainWidth-ul li.MaxwiLi6{
            max-width: 81px; 
        }
        .MainWidth-ul li.MaxwiLi7{
            max-width: 54px; 
        }
        .MainWidth-ul li.MaxwiLi8{
            max-width: 80px; 
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
            line-height: 13px;
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
        .faq_ins.div#accordionRateAg .card h5 {
    padding-left: 12px;
}
div#accordionRateAg .card-header a {
    font-size: 14px;
}
.CloseRev {
    padding-bottom: 14px;
}
.ViewMob100{
    width: 100%;
}
.TAbULId ul.EqualTbUlCell li a {
 font-weight: 800;
}

.BannrGrup.mobbneergrop2 input {
    padding: 2px 5px;
    font-size: 12px;
    background: #fff;
    height: 34px;
}
.BannrGrup.mobbneergrop2 label {
    position: absolute;
    right: 5px;
    top: 10px;
    font-size: 13px;
}
.PixBtnMr1 .SubBtn {
    font-size: 14px;
}
.card-body p.OutImg2 {
    padding: 0px 3px 4px 8px;
}
.Mapsection div#villaMap {
    height: 270px;
}
.ReviewUl.singlrev{
 margin: 20px 0px;
}
.RatepadinAl.RatepadinAlMb{
	padding: 12px 10px;
}
.faq_ins.forabvilaFaqins p.forChkBold {
    font-size: 13px !important;
}
div#accordionRateAg .card {
     border: 0;
    margin-bottom: 18px;
}
.TimeB4Pos {
    padding-left: 123px;
}
.LocBox.RatepadinAl{
	padding: 12px 10px;
}
    }
    /*============MEDIA QUERY CSS==========*/
</style>