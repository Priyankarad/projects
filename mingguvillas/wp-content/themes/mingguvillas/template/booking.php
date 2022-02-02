<?php
/*
Template name:booking
*/
if ( ! session_id() ) {
    session_start();
}

if(empty($_SESSION['name']) || empty($_SESSION['durationPrice'])){
    wp_redirect(home_url());
}

$currency = 'dummy';
if(!empty($_SESSION['to_currency'])){
    $currency = $_SESSION['to_currency'];
}

if(!empty($_POST['currencySet'])){
    $_SESSION['to_currency'] = $_POST['currency'];
    $currency1 = $_POST['currency'];
    $rates = $_SESSION['exchangeRates']->$currency1;
    $symbol = $_SESSION['symbols'][$_POST['currency']];
    echo json_encode(array('rates'=>$rates,'symbol'=>$symbol));die;
}

require_once( get_parent_theme_file_path( 'countrylist1.php' ) );
if($_POST['request']){
    $start = str_replace('/','-',$_POST['start']);
    $start = date('m/d/Y',strtotime($start));
    $start = date('M j Y', strtotime($start));

    $end = str_replace('/','-',$_POST['end']);
    $end = date('m/d/Y',strtotime($end));
    $end = date('M j Y', strtotime($end));

    $html = 'Hello '.ucwords($_POST['fname'].' '.$_POST['lname']).',<br/><br/>

    You have requested to book '.$_POST['address'].' as per below\'s booking detail.<br/><br/>

    Your booking request has not been confirmed yet, but we will come back to you as soon as possible.<br/><br/>

    In case you have any further questions, please contact us via phone +62 87861916870 or reply to this email.<br/><br/><br/>



    Best regards,<br/>
    '.$_POST['address'].'<br/>
    Telephone: -<br/><br/>
    --------------------------------------------<br/><br/>


    BOOKING (#B'.rand(100000,999999).')<br/><br/>

    Status: Open<br/><br/>

    Arrival: '.$start.'<br/><br/>

    Departure: '.$end.'<br/><br/>

    Nights: '.$_POST['night'].'<br/><br/>

    Property: '.$_POST['address'].'<br/><br/>

    Guests: '.$_POST['guest1'].' guest(s)<br/><br/>

    Addons: ';

    if($_POST['addon0']!=''){
        $html.='Early Check-In<br/>';
    }
    else if($_POST['addon1']!=''){
        $html.='Late Check-Out<br/>';
    }else if($_POST['addon2']!=''){
        $html.='Extra Guest<br/>';
    }else if($_POST['addon3']!=''){
        $html.='Pool Fence<br/>';
    }

    $html.=
    '<br/>

    --------------------------------------------<br/><br/>


    QUOTE (#'.rand(100000,999999).')<br/><br/>

    Status: Pending for owner<br/><br/>


    PRICE<br/><br/>

    '.$_POST['address'].'    USD '.$_POST['price1'].'<br/><br/>';

    if($_POST['addon0']!=''){
        $html.='Early Check-In    USD '.$_POST['addon0'].'<br/><br/>';
    }
    else if($_POST['addon1']!=''){
        $html.='Late Check-Out    USD '.$_POST['addon1'].'<br/><br/>';
    }else if($_POST['addon2']!=''){
        $html.='Extra Guest    USD '.$_POST['addon2'].'<br/><br/>';
    }else if($_POST['addon3']!=''){
        $html.='Pool Fence    USD '.$_POST['addon3'].'<br/><br/>';
    }
    $html.='Total booking amount: '.$_POST['total_amount'].'<br/><br/>


    Payment Schedule<br/><br/>

    Balance at Check-In must be in US$ cash (2006 or newer, unmarked United States Dollars banknotes – F series or newer only) on arrival, as Minggu Villas doesn’t
    provide yet a credit card service.)<br/><br/>


    Cancellation Policy<br/><br/>

    80% of paid prepayments refundable when cancelled 360 <br/>
    days before arrival or earlier.<br/>
    60% of paid prepayments refundable when cancelled 61<br/> 
    days before arrival or earlier.<br/>
    0% refundable if cancelled after.<br/>


    Damage Deposit<br/><br/>

    No damage deposit is due.<br/><br/>

    --------------------------------------------<br/><br/>


    Guest details<br/><br/>

    Name:  '.ucwords($_POST['fname'].' '.$_POST['lname']).'<br/><br/>

    Phone: '.$_POST['phone'].'<br/><br/>

    Email: '.$_POST['email'].'<br/><br/>

    Country: '.$_POST['country'].'<br/><br/>';


    $headers[] = 'Content-Type: text/html; charset=UTF-8';

    $headers[] = 'From: Mingguvillas <owner-ba053d61-9df6-47e7-9976-7737f8a04b2e@lodgify.com>' . "\r\n";
    wp_mail($_POST['email'],$_POST['address'],$html,$headers);
    $email = get_option('admin_email');
    wp_mail($email,$_POST['address'],$html,$headers);
    echo json_encode(array('status'=>1));die;
}


$propertyID = $_SESSION['durationPrice']['propertyID'];
$guestDropdown = $_SESSION['durationPrice']['guest'];
$startPriceDate = $_SESSION['durationPrice']['start_date'];
$endPriceDate = $_SESSION['durationPrice']['end_date'];
$maxGuest = $_SESSION['guest'];
$guests = $_SESSION['durationPrice']['guests'];
$available = $_SESSION['durationPrice']['available'];
$price = $_SESSION['durationPrice']['price'];
$nights = $_SESSION['durationPrice']['nights'];
$poolFence = $_SESSION['pool_fence'];
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

$dateData = getDates($startPriceDate,$endPriceDate);

if($_POST){
    if($_POST['short']){
        $dateData = getDates($_POST['startDate'],$_POST['endDate']);
        echo json_encode($dateData);die;
    }else{
        $checkAlottedDates = array();
        $startDate = $start = date('Y-m-d',strtotime(str_replace('/','-',$_POST['start_date'])));
        $startDate = strtotime($startDate);
        $endDate = $end = date('Y-m-d',strtotime(str_replace('/','-',$_POST['end_date'])));
        $endDate = strtotime($endDate);
        $status = 0;
        for ($i=$startDate; $i<$endDate; $i+=86400) {  
            $dateCheckAlotted =  date("d-m-Y", $i); 
            $checkAlottedDates[] =  date("Y-m-d", $i); 
            if(in_array($dateCheckAlotted,$alottedRooms)){
                $status = 1;
            }
        }
        $price = 0;
        if($status == 0){
            foreach($rooms as $room){
                if(($room['Alot'] != 0) && in_array($room['@attributes']['day'],$checkAlottedDates)){
                    $price+=$room['Price'];
                }
            } 
        }
        /*price calculation*/
        echo json_encode(array('status'=>$status,'price'=>$price));die;
    }
}

function getDates($startPriceDate,$endPriceDate){
    $start = $date1 = str_replace('/', '-', $startPriceDate);
    $date1 = date_create(date('Y-m-d', strtotime($date1)));
    $end = $date2 = str_replace('/', '-', $endPriceDate);
    $date2 = date_create(date('Y-m-d', strtotime($date2)));
    $diff=date_diff($date2,$date1);
    $days = $diff->format("%a");
    $start= date('D, j M  y', strtotime($start)); 
    $end= date('D, j M  y', strtotime($end)); 
    return array('start'=>$start,'end'=>$end,'days'=>$days);
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
//$rates = number_format($currencies[$toCurrency],2);
    $rates = $currencies[$toCurrency];
}
if(!empty($_SESSION['symbols'])){
    $symbols = $_SESSION['symbols'];
    $symbol = $symbols[$toCurrency];
}

get_header('one');

?>
<input type="hidden" id="pool_fence" value="<?php echo !empty($poolFence)?$poolFence:0;?>">
<input type="hidden" id="maxGuest" value="<?php echo !empty($maxGuest)?$maxGuest:0;?>">
<input type="hidden" id="symbol" value="<?php echo $symbol;?>">
<input type="hidden" id="currency_rate" value="<?php echo $rates;?>">
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/assets/css/intlTelInput.min.css">
<style type="text/css">
    input.btn1.HideSubmit {
        position: unset;
    }
</style>
<section class="ChoosStepSection pd90">
    <input type="hidden" id="url" value="<?php home_url(); ?>">
    <input type="hidden" id="available" value="<?php echo $available; ?>">
    <input type="hidden" id="total_price" value="<?php echo $price;?>">
    <div class="container">
        <div class="ChoosStepDetail">
            <div class="row">
                <div class="col-md-8 col-sm-8 col-12">
                    <div class="ChoosStep">
                        <form id="booking" action="somewhere" method="POST" class="multisteps-mawjuuds" >
                            <div class="row">
                                <div class="col-md-4">
                                    <ul id="section-tabs">
                                        <li class="current active Stclickt step_1 step_arrow_1">step 1: rental
                                            <span class="lnr lnr-chevron-down-circle"></span>
                                        </li>
<!-- <li class="Stclickt2 step_2 step_arrow_2">step 2 nights
<span class="lnr lnr-chevron-down-circle"></span>
</li> -->
<li class="step_3 Stclickt3 step_arrow_2">step 2: extras
    <span class="lnr lnr-chevron-down-circle"></span>
</li>
<li class="step_4 step_arrow_3">step 3: payment
    <span class="lnr lnr-chevron-down-circle"></span>
</li>
</ul>
</div>
<div class="col-md-8">
    <div class="mobiitemStep ">
        <a class="mobTabStep">Step 1 <span class="lnr lnr-chevron-down-circle"></span></a>
    </div>
    
<!-- Payment Details-comment-button -->

   <!--  <div class="PaFeldBox" id="paymtdetailss">
        <a href="#pymntbtnscrl">Payment Details</a>
    </div> -->

<!-- Payment Details-comment-button -->


    <div id="fieldsets">
        <fieldset class="current availability_yes step1_1">
            <div class="bydefaultnone check_availability_1">
                <p class="NewVilNN"><?php echo $_SESSION['name'];  ?></p>
                <div class="title-dates duration"><?php echo $dateData['start'];?> - <?php echo $dateData['end'];?></div>
                <p class="nights"><?php echo $dateData['days'];?> <?php echo ($dateData['days']>1)?'Nights':'Night';?></p>
                <button class="edit-nightsbtn Edit2Night23">Edit Nights</button>
            </div>
            <div class="click-new-hides check_availability_2">
                <h1>Check Availability</h1>
                <div class="DAthrMain">
                    <div class="row">
                        <div class="col-md-1">
                            <div class="datcal">
                                <span class="lnr lnr-calendar-full"></span>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-12">
                            <label>Dates</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-12">
                            <div class="form-group BannrGrup">                                  
                                <input type="text" id="start_date" name="start_date" class="form-control" placeholder="Check-IN" autocomplete="off" readonly="" value="<?php echo $startPriceDate;?>">                                 
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-12">
                            <div class="form-group BannrGrup">
                                <!--  <label>Selecte Date:</label> -->
                                <input type="text" id="end_date" name="end_date" class="form-control" placeholder="Check-OUT" autocomplete="off" readonly="" value="<?php echo $endPriceDate;?>">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-12">
                            <div class="form-group BannrGrup">
                                <!--  <label>Selecte Date:</label> -->
                                <p class="selected_night"><?php echo $dateData['days'];?> night selected</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="total_rupees">
                            <?php
                            if($available == 'no'){ ?>
                                <span style="color:#942424;">The selected days are not available</span>
                            <?php }
                            ?>
                        </div>
                    </div>
                    <hr class="TabHr">
                </div>
                <!-- ========FIRST END===== -->
                <div class="DAthrMain">
                    <div class="row">
                        <div class="col-md-1">
                            <div class="datcal">
                                <span class="lnr lnr-calendar-full"></span>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-12">
                            <label>Persons</label>
                        </div>
                    </div>
                    <div class="NighSelMain">
                        <div class="row">
                            <div class="col-md-5 col-sm-5 col-12">
                                <div class="form-group BannrGrup mb_20">
                                    <select name="guests" id="guests" 
                                    class="form-control">
                                    <?php 
                                    for($i=1;$i<=12;$i++){ ?>
                                        <option value="<?php echo $i;?>" <?php echo ($i == $guests)?'selected':'';?> ><?php echo $i;?></option>
                                    <?php }
                                    ?>
                                </select>
                                <span class="lnr lnr-users"></span>
                            </div>
                            <p>persons per room</p>
                        </div>
                    </div>
                </div>
            </div>
            <a class="btn1 next btnnxt22">continue</a>
            <div class="LoderBook booking_loader">
                <img src="<?php bloginfo('template_url');?>/assets/images/lg.dual-ring-loader.gif" alt="Load" class="img-fluid">
            </div>
        </div>
        <!-- ========FIRST END===== -->
    </fieldset>
    <fieldset class="">
        <div class="mobiitemStep">
            <a class="mobTabStep">Step 2 <span class="lnr lnr-chevron-down-circle"></span></a>
        </div>
        <div class="bydefaultnone check_guest_1">
            <div class="row">
                <div class="col-md-8">
                    <div class="title-dates">1 Rental</div>
                    <p class="guestsShort"><?php echo $guests;?>
                    <span class="lnr lnr-users"></span>
                </p>
            </div>
            <div class="col-md-4 EditVilaBtn">
                <div>
                    <button class="ToggleEditVila">Edit Vila</button>
                </div>
            </div>
        </div>
    </div>
    <div class="click-new-hides check_guest_2">
        <div class="NextFildIg">
            <h1>Choose Rental</h1>
            <div class="FldBoxImg">
                <img src="<?php echo  bloginfo('template_url').$_SESSION['image'];?>" alt="Image" class="img-fluid">
                <button type="button" class="btn btn-primary info_btn" data-toggle="modal" data-target=".bd-example-modal-lg"> More info  </button>
                <div class="modal fade bd-example-modal-lg"   tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modelxlmy">
                        <div class="modal-content ">
                            <h4>6 Bedroom - 01AB-Villa Sensel</h4>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="MoreInfoSlider">
                                        <div class="owl-carousel owl-theme infoSlide">
                                            <div class="item InfoS">
                                                <div class="Slideimg">
                                                    <img class="img-responsive" alt="image" src="http://pixlritllc.com/mingguvillas/wp-content/uploads/2019/05/abvillaimg6.jpg" href="#">
                                                    <hr>
                                                </div>
                                            </div>
                                            <div class="item InfoS">
                                                <div class="Slideimg">
                                                    <img class="img-responsive" alt="image" src="http://pixlritllc.com/mingguvillas/wp-content/uploads/2019/05/abvillaimg2.jpg" href="#">
                                                    <hr>
                                                </div>
                                            </div>
                                            <div class="item InfoS">
                                                <div class="Slideimg">
                                                    <img class="img-responsive" alt="image" src="http://pixlritllc.com/mingguvillas/wp-content/uploads/2019/05/abvillaimg3.jpg" href="#">
                                                    <hr>
                                                </div>
                                            </div>
                                            <!--  ====ITEM FIRST END==== -->


                                        </div>
                                    </div>

                                    <!--   =====SLIDER END======= -->

                                </div>
                                <!-- ===================12 END===== -->
                            </div>
                            <!--  ====row end===== -->
                            <div class="InfoBrde">
                                <div class="row">
                                    <div class="col-md-3 col-sm-3 col-12">
                                        <div class="SliderInfoBox">
                                            <div class="room-block">
                                                <span>Description</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- ========ROW END==== -->
                            <div class="InfoBrde">
                                <div class="row">
                                    <div class="col-md-2 col-sm-2 col-12">
                                        <div class="SliderInfoBox">
                                            <div class="room-block">
                                                <span>Rooms</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-8 col-sm-8 col-12">
                                        <div class="SliderInfoBox">
                                            <div class="room-block">
                                                <span>4 Bathroom, 6 Bedroom, 2 Kitchen</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ========ROW END==== -->


                            <div class="InfoBrde">
                                <div class="row">
                                    <div class="col-md-2 col-sm-2 col-12">
                                        <div class="SliderInfoBox">
                                            <div class="room-block">
                                                <span>Amenities</span>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-md-5 col-sm-5 col-12">
                                        <div class="SliderInfoBox">
                                            <div class="room-block">
                                                <h2><img src="http://pixlritllc.com/mingguvillas/wp-content/uploads/2019/05/sleeping.png">Sleeping</h2>
                                                <p>Bed linen, 2 King bed, 4 Single bed, Bunk Bed</p>
                                            </div>
                                        </div>

                                        <div class="SliderInfoBox">
                                            <div class="room-block">
                                                <h2><img src="http://pixlritllc.com/mingguvillas/wp-content/uploads/2019/05/heating.png" class="img-fluid" alt="Image">Heating/Cooling</h2>
                                                <p>Air conditioning, Ceiling fans</p>
                                            </div>
                                        </div>

                                        <div class="SliderInfoBox">
                                            <div class="room-block">
                                                <h2><img src="http://pixlritllc.com/mingguvillas/wp-content/uploads/2019/05/entrtnmnt.png" class="img-fluid" alt="Image">Entertainment</h2>
                                                <p>DVD-Player, Wireless Broadband Internet, Stereo system, TV (Satellite)</p>
                                            </div>
                                        </div>

                                        <div class="SliderInfoBox">
                                            <div class="room-block">
                                                <h2><img src="http://pixlritllc.com/mingguvillas/wp-content/uploads/2019/05/bathtub.png" class="img-fluid" alt="Image">Sanitary</h2>
                                                <p>Hair dryer, Shower, Towel-set, Washbasin</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-5 col-sm-4 col-12">
                                        <div class="SliderInfoBox">
                                            <div class="room-block">
                                                <h2><img src="http://pixlritllc.com/mingguvillas/wp-content/uploads/2019/05/cooking.png" class="img-fluid" alt="Image">Cooking</h2>
                                                <p>Blender, Coffee machine, Cooking utensils, Kitchen stove, Microwave, Toaster, Water cooler</p>
                                            </div>
                                        </div>
                                        <div class="SliderInfoBox">
                                            <div class="room-block">
                                                <h2><img src="http://pixlritllc.com/mingguvillas/wp-content/uploads/2019/05/miscellnous.png" class="img-fluid" alt="Image">Miscellaneous</h2>
                                                <p>Safe, Baby high chair ( Available on request), Set Baby Cot ( Available on request), Pool Fence (Available on request)</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- ========ROW END==== -->
                        </div>
                    </div>
                </div>



            </div>
            <div class="BookBed">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="RentalBook">
                            <p class="prices"><?php echo '$ '.number_format($price,1);?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-12">
                        <span class="lnr lnr-user Sman"></span>
                        <div class="form-group BannrGrup chkBnIn">
                            <!--  <label>Selecte Date:</label> -->
                            <select 
                            class="form-control guests">
                            <?php 
                            for($i=1;$i<=12;$i++){ ?>
                                <option value="<?php echo $i;?>" <?php echo ($i == $guests)?'selected':'';?> ><?php echo $i;?>
                            </option>
                        <?php }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-8 col-sm-8 col-12">
                <div class="RentalBookBtn">
                    <button class="btn btn-cta book_now">Book Now</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="ClickGest">
<!-- <p ><span class="lnr lnr-calendar-full" for="end_date"></span>
5 Guests</p> -->
<p id="guest_short"><?php echo $guests.' Guests';?></p>
</div>
</fieldset>
<fieldset class="next Nxtfld step_3 step3_3">
    <div class="row">
        <div class="col-md-8">
            <h3 class="choose_extra">Choose Extra</h3>
        </div>
        <div class="col-md-4">
            <div class="button_replace Edit2Night23">
                <input type="button" class="skip n2skip" value="SKIP">
            </div>
        </div>
    </div>
<!-- <h3 class="choose_extra">Choose Extra</h3>
<div class="button_replace">
<input type="button" class="skip" value="SKIP">
</div> -->
<div class="bydefaultnone check_extra_1">
    <div class="title-dates dtpExt" >
        <p class="extra_guest_dropdown">0 Extra</p>
        <div class="checkbox_extra_checked"></div>
        <div class="checkbox_extra_array"></div>
        <div class="EditExtraBtn minngus-editbtn">
            <button class="edit_extra">Edit Extra</button>
        </div>
    </div>
</div>
<div class="check_extra_2">
    <div class="click-new-hides FirstEarly">
        <div class="SmallCheckout">
            <div class="row">
                <div class="col-12 col-sm-12 col-12">
                    <div class="EarlyCheck">
                        <h1>Early Check-In</h1>
                        <p>single charge per stay</p>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary info_btn" data-toggle="modal" data-target="#exampleModal">More info</button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog cstm_dialog" role="document">
                                <div class="modal-content cstm_mcntnt">
                                    <div class="modal-header">
                                        <h5 class="modal-title cstm_mtitle" id="exampleModalLabel">Early Check-In</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true" class="cstm_spn">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body cstm_mbody">
                                        Single charge, Per stay
                                    </div>
                                    <div class="modal-footer cstm_mfootr">
                                        Early Check-In or Late Check-Out: 50% additional charge on published daily rates.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="MoreItem">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="SinglChrz">
                        <p id="check_02"></p>
                    </div>
                </div>
                <div class="col-md-8 col-sm-6 col-12">
                    <div class="SinglChrz">
                        <div class="row">
                            <div class="AddedCheck checkItem">
                                <div class="form-check">
                                    <label class="form-check-label" for="exampleCheck1"><input type="checkbox" class="form-check-input chkIn" id="check_0"  data-extra="Early Check-In"> <span>Add item</span></label>
                                </div>
                            </div>
                            <div class="RentalBook priceSection">
                                <p id="check_01">$<?php 
                                if($available == 'yes'){
                                    $checkINOut = $price/2;
                                    echo $symbol.number_format($checkINOut*$rates,1);
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ======================================FIRST ITEM END========== -->
<div class="click-new-hides FirstEarly">
    <div class="SmallCheckout">
        <div class="row">
            <div class="col-12 col-sm-12 col-12">
                <div class="EarlyCheck">
                    <h1>Late Check-Out</h1>
                    <p>single charge per stay</p>
                    <button type="button" class="btn btn-primary info_btn" data-toggle="modal" data-target="#exampleModal1">
                        More info
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog cstm_dialog" role="document">
                            <div class="modal-content cstm_mcntnt">
                                <div class="modal-header">
                                    <h5 class="modal-title cstm_mtitle" id="exampleModalLabel">Late Check-Out</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" class="cstm_spn">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body cstm_mbody">
                                    Single charge, Per stay
                                </div>
                                <div class="modal-footer cstm_mfootr">
                                    Late Check-In or Late Check-Out: 50% additional charge on published daily rates.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="MoreItem">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
                <div class="SinglChrz">
                    <p id="check_12"></p>
                </div>
            </div>
            <div class="col-md-8 col-sm-6 col-12">
                <div class="SinglChrz">
                    <div class="row">
                        <div class="AddedCheck checkItem">
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1"><input type="checkbox" id="check_1" class="form-check-input chkIn" data-extra="Late Check-Out"> <span>Add item</span></label>
                            </div>
                        </div>
                        <div class="RentalBook priceSection">
                            <p id="check_11">$<?php 
                            if($available == 'yes'){
                                $checkINOut = $price/2;
                                echo $symbol.number_format($checkINOut*$rates,1);
                            }
                            ?></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- ========================FIRST ITEM END========== -->
<div class="click-new-hides FirstEarly">
    <div class="SmallCheckout">
        <div class="row">
            <div class="col-12 col-sm-12 col-12">
                <div class="EarlyCheck">
                    <h1>Extra Guest</h1>
                    <p>charge per quantity, per night</p>
                    <button type="button" class="btn btn-primary info_btn" data-toggle="modal" data-target="#exampleModal2">
                        More info
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog cstm_dialog" role="document">
                            <div class="modal-content cstm_mcntnt">
                                <div class="modal-header">
                                    <h5 class="modal-title cstm_mtitle" id="exampleModalLabel">Extra Guest</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" class="cstm_spn">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body cstm_mbody">
                                    Per quantity (max: 3), Per night
                                </div>
<!--   <div class="modal-footer cstm_mfootr">
Early Check-In or Late Check-Out: 50% additional charge on published daily rates.
</div> -->
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="MoreItem">
    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <div class="SinglChrz">
                <p id="check_22"></p>
            </div>
        </div>
        <div class="col-md-8 col-sm-6 col-12">
            <div class="SinglChrz">
                <div class="row">
                    <div class="AddedCheck checkTick checkItem">
                        <div class="form-check">
                            <label class="form-check-label" for="exampleCheck1"><input type="checkbox" id="check_2" class="form-check-input chkIn addGuest" value="<?php echo $extraArray[2];?>" data-extra="Extra Guest" id="extra_checkbox"> <span>Add item</span></label>
                        </div>
                    </div>
                    <div class="AddopenSelect NwAdptn">
                        <select class="selector AdSecCLick guestSelector" id="extra_guest" name="extra_guest">
                            <?php 
                            for($i=1;$i<=3;$i++){ ?>
                                <option value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php }
                            ?>
                        </select>
                        <span class="lnr lnr-users toIn2"></span>
                    </div>
                    <div class="RentalBook priceSection">
                        <p id="check_21"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- =========================FIRST ITEM END========== -->
<!-- <div class="click-new-hides FirstEarly">
    <div class="SmallCheckout">
        <div class="row">
            <div class="col-12 col-sm-12 col-12">
                <div class="EarlyCheck">
                    <h1>Pool Fence</h1>
                    <p>single charge per night</p>
                    <button type="button" class="btn btn-primary info_btn" data-toggle="modal" data-target="#exampleModal3">
                        More info
                    </button>

                    <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog cstm_dialog" role="document">
                            <div class="modal-content cstm_mcntnt">
                                <div class="modal-header">
                                    <h5 class="modal-title cstm_mtitle" id="exampleModalLabel">Pool Fence</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" class="cstm_spn">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body cstm_mbody">
                                    Single charge, Per night
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="MoreItem">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
                <div class="SinglChrz">
                    <p id="check_32"><?php echo $symbol.number_format($poolFence*$rates,1);?></p>
                </div>
            </div>
            <div class="col-md-8 col-sm-6 col-12">
                <div class="SinglChrz">
                    <div class="row">
                        <div class="AddedCheck checkItem">
                            <div class="form-check">
                                <label class="form-check-label" for="exampleCheck1"><input type="checkbox" id="check_3" class="form-check-input chkIn" value="<?php echo $poolFence*$nights;?>" data-extra="Pool Fence"> <span>Add item</span></label>
                            </div>
                        </div>
                        <div class="RentalBook priceSection">
                            <p id="check_31"><?php echo $symbol.number_format(($poolFence*$rates*$nights),1);?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="newcontinue AgnNwCon">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-12">
            <div class="button_replace">
                <input type="button" class="skip n2skip" value="SKIP">
            </div>
        </div>
    </div>
</div>
<div class="PaFeldBox onlyformoblile" id="paymtdetailss">
    <a href="#pymntbtnscrl">Payment Details</a>
</div>
</fieldset>
<fieldset class="next step4_4">
    <div class="mobiitemStep check_details_1">
        <a class="mobTabStep">Step 4 <span class="lnr lnr-chevron-down-circle"></span></a>
    </div>
    <div class="click-new-hides check_details_2">
        <form method="post">
            <h2>Enter Details</h2>
            <div class="col-md-12 col-sm-12 col-12">
                <div class="SymkheadingCol">
                    <h1>Guest Details</h1>
                    <div class="contFrom">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group BannrGrup">
                                    <input type="text"  placeholder="First Name" class="form-control BannerInput" id="fname" name="fname" required="">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group BannrGrup">
                                    <input type="text" placeholder="Last Name" class="form-control BannerInput" id="lname" name="lname" required="">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-12">
                                <div class="form-group BannrGrup">
                                    <input type="email" name="email" id="email" placeholder="Email" class="form-control BannerInput" required="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group BannrGrup country_cstm">
                                    <input name="phone" id="phone" class="form-control phone" type="text" placeholder="(201) 555-0123">
                                </div>
                            </div>
<!--               <div class="col-md-6">
<div class="form-group BannrGrup">
<select autocomplete="off" class="form-control" id="country" name="country">
<option value="">Select Country</option>
<option value="190601">in </option>
<option value="198650"></option>
<option value="190600"></option>
<option value="190604">asa</option>
<option value="189653">gu </option>
<option value="189406">u</option>
<option value="191090">nsel</option>
</select>
</div>
</div> -->

<div class="col-md-12">
    <div class="form-group">
        <textarea cols="20" id="Comment" name="comment" rows="5" class="form-control" placeholder="Comment"></textarea>
    </div>
</div>
<input type="hidden" name="start" id="start">
<input type="hidden" name="end" id="end">
<input type="hidden" name="night" id="night" value="<?php echo $dateData['days'];?>">
<input type="hidden" name="guest1" id="guest1">
<input type="hidden" name="price1" id="price1">
<input type="hidden" name="addon0" id="addon0">
<input type="hidden" name="addon1" id="addon1">
<input type="hidden" name="addon2" id="addon2">
<input type="hidden" name="addon3" id="addon3">
<input type="hidden" name="total_amount" id="total_amount">
<div class="col-md-6 formobOr AgnForCm">
    <button id="contact-send" type="submit" class="btn-send" name="request" value="request" data-loading-text="Loading..." tabindex="9">Request to Book</button>
    <div class="bankttranS_logo paylogo">
        <p>for other Payments:</p>
        <div class="AgnPayDiv">
            <img src="<?php  bloginfo('template_url');?>/assets/images/pay-pal-logo.png" alt="Image">
            <img src="<?php  bloginfo('template_url');?>/assets/images/bank_transfr.png" alt="Image">
        </div>
    </div>
</div>
<div class="col-md-6 AgnNwPayc">
    <div class="pay_new">
        <button class="pay_now">Pay Now</button>
    </div>
    <div class="PayFooter text-center credit_optn">
        <p>with Credit Card :</p>
        <ul class="nav-pay">
            <li>
                <a href="javascript:void(0)"> <img src="<?php  bloginfo('template_url');?>/assets/images/pay1.png" alt="Image"></a>
            </li>

            <li>
                <a href="javascript:void(0)"> <img src="<?php  bloginfo('template_url');?>/assets/images/pay2.png" alt="Image"></a>
            </li>
            <li>
                <a href="javascript:void(0)"> <img src="<?php  bloginfo('template_url');?>/assets/images/jcb.png" alt="Image"></a>
            </li>
        </ul>
    </div>

</div>
</div>
</div>
</div>
</div>
</form>
</div>
</fieldset>
</div>
</div>
</div>
</form>
</div>
</div>
<div class="col-md-4 col-sm-4 col-12 prl_0">
    <div class="ChoosStepSide" id="pymntbtnscrl">
        <div class="chosImg">
            <img src="<?php echo  bloginfo('template_url').$_SESSION['image'];?>" class="img-fluid" alt="Image">
        </div>
        <div class="Chos04">
            <input type="hidden" name="address" id="address" value="<?php echo $_SESSION['name'];?>">
            <h3><?php echo $_SESSION['name'];?></h3>
            <p><?php echo $_SESSION['address_line_1'];?></p>
            <p><?php echo $_SESSION['address_line_2'];?></p>
        </div>
        <div class="Chospill">
            <ul class="nav nav-pills mb-3 SumrryPils RmPilsStick" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Payment Details</a>
                </li>
<!-- <li class="nav-item">
<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Details</a>
</li> -->
</ul>
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
        <div class="SummryRw pdrl">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-6">
                    <div class="SummryBox">
                        <p>Check-IN</p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-6">
                    <div class="SummryBox start_end start_end1">
                        <p class="priceBox"><?php echo $startPriceDate;?></p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-6 col-6">
                    <div class="SummryBox">
                        <p>Check-OUT</p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-6">
                    <div class="SummryBox start_end start_end2">
                        <p class="priceBox"><?php echo $endPriceDate;?></p>
                    </div>
                </div>
            </div>

            <!-- ===ROW END=== -->
            <div class="row">
                <div class="col-md-6 col-sm-6 col-6">
                    <div class="SummryBox">
                        <p>Villa</p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-6">
                    <div class="SummryBox">
                        <!--   <p class="priceBox"><?php echo $symbol.number_format($price*$rates,1);?></p> -->
                        <p class="priceBox_main priceBox"><?php echo $symbol.number_format($price*$rates,1);?></p>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6 col-sm-6 col-6">
                    <div class="SummryBox">
                        <p>Taxes</p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-6">
                    <div class="SummryBox">
                        <p class="priceBox">included</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-6 col-6">
                    <div class="SummryBox">
                        <p>Fees</p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-6">
                    <div class="SummryBox">
                        <p class="priceBox">included</p>
                    </div>
                </div>
            </div>

            <div class="extra_sidebar">
            </div>
        </div>
        <div class="SummryRw ToSummry">
            <div class="row ">
                <div class="col-md-6 col-sm-6 col-6">
                    <div class="SummryBoxTo">
                        <h1>Total</h1>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-6">
                    <div class="SummryBoxTo">
                        <p class="BsumClr total_price"><?php echo $symbol.number_format(($price*$rates),1);?></p>
                    </div>
                </div>
            </div>
<!--  <div class="row PrpSUmmy">
<div class="col-md-6 col-sm-6 col-12">
<div class="SummryBoxTo">                 
<p>Property's currency</p> 
</div>
</div>
<div class="col-md-6 col-sm-6 col-12">
<div class="SummryBoxTo">
<p>$ 445</p> 
</div>
</div>
</div> -->
</div>
<!-- <div class="SummryRw HiddenSumm">
<div class="row">
<div class="col-md-12 col-sm-12 col-12">
<div class="SummryBoxTo">
<h1>Payment Schedule</h1>
</div>
</div>
</div>
<div class="row">
<div class="col-md-6 col-sm-6 col-12">
<div class="SummryBoxTo">
<p class="BsumClr">Payment 1 (On agreement)</p>
</div>
</div>
<div class="col-md-6 col-sm-6 col-12">
<div class="SummryBoxTo">
<p class="BsumClr">$ 398.4</p>
</div>
</div>
</div>

<div class="row RemngSumm">
<div class="col-md-6 col-sm-6 col-12">
<div class="SummryBoxTo">
<p class="BsumClr">Remaining Balance</p>
</div>
</div>
<div class="col-md-6 col-sm-6 col-12">
<div class="SummryBoxTo">
<p class="BsumClr">$ 597.6</p>
</div>
</div>
</div>
</div> -->
<!-- <div class="SummryRw">
<h2>Payment Schedule</h2>
<div class="row">
<div class="col-md-6 col-sm-6 col-12">
<div class="SummryBoxTo">
<h1 class="Agrh1">Payment 1 (On agreement)</h1>
<p>Remaining Balance</p>
</div>
</div>
<div class="col-md-6 col-sm-6 col-12">
<div class="SummryBoxTo">
<p class="BsumClr">$ 178</p>
<p>$ 267</p>
</div>
</div>
</div>
</div> -->
<div class="DollorTabHide sidebar_currency">
    <select class="selector ftNselct currency_select1">
        <option value="dummy" <?php echo ($currency == 'dummy')?'selected':'';?>>Currency </option>
        <?php 
        foreach( $age as $x => $x_value ) { ?>
            <option value="<?php echo $x; ?>" <?php echo ($currency == $x)?'selected':'';?>><?php echo $x." ".$x_value;?></option> 
        <?php } ?>
    </select>
</div>
<div class="SummryRw pdrl">
    <h2>Cancellation Policy</h2>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-12">
            <div class="SummryBoxTo">
                <ul>
                    <li>80% of paid prepayments refundable when canceled 360 days before arrival or earlier</li>
                    <li>60% of paid prepayments refundable when canceled 61 days before arrival or earlier</li>
                    <li>0% refundable if cancelled after</li>
                    <li>80% of paid prepayments refundable when canceled 360 days before arrival or earlier</li>
                </ul>
            </div>
        </div>
    </div>
</div>
</div>


<!-- ================================================================================== -->
<!-- <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
<div class="SummryRw">
<div class="row">
<div class="col-md-6 col-sm-6 col-12">
<div class="SummryBox">
<p>Dates</p>
</div>
</div>
<div class="col-md-6 col-sm-6 col-12">
<div class="SummryBox start_end">
<p><?php echo $startPriceDate;?> - <?php echo $endPriceDate;?></p>
</div>
</div>
</div>
</div>
<div class="SummryRw">
<h6>Villa</h6>
<div class="row">
<div class="col-md-6 col-sm-6 col-12">
<div class="SummryBox">
<p>6 Bedroom - 01AB-Villa Sensel</p>
</div>
</div>
<div class="col-md-6 col-sm-6 col-12">
<div class="SummryBox">
<p class="priceBox">$ <?php echo number_format($price,2);?></p>
</div>
</div>
</div>
<div class="row">
<div class="col-md-6 col-sm-6 col-12">
<div class="SummryBox">
<p><strong>Subtotal</strong></p>
</div>
</div>
<div class="col-md-6 col-sm-6 col-12">
<div class="SummryBox">
<p class="sub_priceBox"><strong>$ <?php echo number_format($price,2);?></strong></p>
</div>
</div>
</div>
</div>
<div class="SummryRw extra_div">

</div>
<div class="SummryRw">
<div class="row">
<div class="col-md-6 col-sm-6 col-12">
<div class="SummryBox">
<p>Total</p>
</div>
</div>
<div class="col-md-6 col-sm-6 col-12">
<div class="SummryBox">
<p class="total_price">$<?php echo number_format($price,2);?></p>
</div>
</div>
</div>

</div>

<div class="SummryRw">
<h2>Cancellation Policy</h2>
<div class="row">
<div class="col-md-12 col-sm-12 col-12">
<div class="SummryBoxTo">
<ul>
<li>80% of paid prepayments refundable when canceled 360 days before arrival or earlier</li>
<li>60% of paid prepayments refundable when canceled 61 days before arrival or earlier</li>
<li>0% refundable if cancelled after</li>
<li>80% of paid prepayments refundable when canceled 360 days before arrival or earlier</li>
</ul>
</div>
</div>
</div>
</div>
</div> -->



</div>
</div>
<div class="SummryRw">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-12">
            <div class="SummryBoxTo terms_section pmnt">
                <label class="terms_label"> <input type="checkbox" aria-label="Checkbox for following text input"><p>I accept <strong>Terms and Conditions</strong></p></label>
            </div>
        </div>
    </div>
</div>
<!-- =======TAB END======= -->

</div>
</div>
</div>
</div>
</div>
</section>
<?php 
get_footer();
?>
<script type="text/javascript" src="<?php bloginfo('template_url');?>/assets/js/intlTelInput.js"></script>
<script type="text/javascript">
    $(document).on('click','.deleteDates',function(){
        $('#start_date').val('');
        $('#end_date').val('');
        $("#start_date").datepicker("hide");
        $("#end_date").datepicker("hide");
        $('.selected_night').html('');
    });
    var nextCheckoutDates = <?php echo json_encode($nextCheckoutDates);?>;
    var startD = $('#start_date').val();
    var endD = $('#end_date').val();
    var guests = $('.guests').val();
    var currencyRate = $('#currency_rate').val();
    var symbol = $('#symbol').val();
    $('#guest1').val(guests);
    $('#start').val(startD);
    $('#end').val(endD);
    $('#check_01').hide();
    $('#check_11').hide();
    $('#check_21').hide();
    $('#check_31').hide();
    var extraArrayContents = ['Early Check-In','Late Check-Out','Extra Guest','Pool Fence'];
    var extraArray = [];
    $("body").on("keyup", "form", function(e){
        if (e.which == 13){
            if ($("#next").is(":visible") && $("fieldset.current").find("input, textarea").valid() ){
                e.preventDefault();
                nextSection();
                return false;
            }
        }
    });

    $("#next").on("click", function(e){
        console.log(e.target);
        nextSection();
    });

    $(".multisteps-mawjuuds").on("submit", function(e){
        if ($("#next").is(":visible") || $("fieldset.current").index() < 3){
            e.preventDefault();
        }
    });

    function goToSection(i){
        $(".multisteps-mawjuuds fieldset:gt("+i+")").removeClass("current").addClass("next");
        $(".multisteps-mawjuuds fieldset:lt("+i+")").removeClass("current").addClass('showbartopR');
        $(".multisteps-mawjuuds li").eq(i).addClass("current").siblings().removeClass("current");
        $(".multisteps-mawjuuds li").prev().addClass("showbartopL");
        setTimeout(function(){
            $(".multisteps-mawjuuds fieldset").eq(i).removeClass("next").addClass("current active");
            if ($(".multisteps-mawjuuds fieldset.current").index() == 3){
                $("#next").hide();
                $(".multisteps-mawjuuds input[type=submit]").show();
            } else {
                $("#next").show();
                $(".multisteps-mawjuuds input[type=submit]").hide();
            }
        }, 80);

    }

    function nextSection(){
        var i = $(".multisteps-mawjuuds fieldset.current").index();
        if (i < 3){
            $(".multisteps-mawjuuds #section-tabs li").eq(i+1).addClass("active");
            goToSection(i+1);
        }
    }

    function dropdown(index){
        for(i=1;i<=3;i++){
            var stepText = '';
            if(i == 1){
                stepText = 'rental';
            }else if(i == 2){
                stepText = 'extras';
            }else if(i == 3){
                stepText = 'payment';
            }
            if(i<=index){
                $('.step_arrow_'+i).html('step '+i+': '+stepText+' <span class="lnr lnr-chevron-down-circle"></span>');
            }else{
                $('.step_arrow_'+i).html('step '+i+': '+stepText+' <i class="fa fa-circle-thin cstmcircl" aria-hidden="true"></i');
            }
        }
    }

    var step1 = 0;
    var step2 = 0;
    var step3 = 0;
    $("#section-tabs li").on("click", function(e){
        var i = $(this).index();
        if ($(this).hasClass("active")){
        } else {
            /*for step 1*/
            if(i == 0){
                $('.chkIn').prop('checked','');
                extraArray = [];
                $('.extra_sidebar').html('');
                $('.extra_div').html('');
                if(confirm('Editing the dates of your stay will remove any previous selections from your reservation. Proceed?')) {
                    editDates();
                }
            }

            /*for step 2*/
// if(i == 1){
//   $('.chkIn').prop('checked','');
//   extraArray = [];
//   $('.extra_sidebar').html('');
//   $('.extra_div').html('');
//   if(step2 == 1){
//     step2 = 0;
//     $('.EditVilaBtn').hide();
//     $('.ClickGest').hide();
//   }else{
//     step2 = 1;
//     $('.EditVilaBtn').show();
//     $('.ClickGest').show();
//   }
// }

/*for step 3*/
if(i == 1){
    if(step3 == 1){
        step3 = 0;
        $('.EditExtraBtn').hide();
        $('.checkbox_extra_array').hide();
    }else{
        step3 = 1;
        $('.EditExtraBtn').show();
        var html = '';
        for(var i = 0; i < extraArray.length; i++) {
            html+='<div>'+extraArray[i]+'<a class="remove" data-index="'+extraArray[i]+'">x</a></div>';
        }
        $('.checkbox_extra_array').html(html);
        $('.checkbox_extra_array').show();
    }
}
}
});

    function editDates(){
        $('.Chospill').hide();
        $('li').removeClass('current');
        $('li').removeClass('active');
        $('.step_1'). addClass('current');
        $('.step_1'). addClass('active');
        $('.step1_1').show();
        $('.step2_2').hide();
        $('.step3_3').hide();
        $('.step4_4').hide();
        $('.check_availability_1').addClass('bydefaultnone');
        $('.check_availability_2').removeClass('bydefaultnone');
        $('.skip').show();
        $('.continue').hide();
        $('.chkIn').prop('checked','');
        extraArray = [];
        $('.extra_sidebar').html('');
        $('.extra_div').html('');
        dropdown(1);
    }
    $(document).on('click','.edit-nightsbtn',function(){
        editDates();
    });

    $(document).on('click','.remove',function(){
        var index = $(this).data('index');
        var checkboxIndex = extraArrayContents.indexOf(index);
        $('#check_'+checkboxIndex).closest('.checkItem').removeClass('introAdChkNw');
        $('#check_'+checkboxIndex).closest('.checkItem').addClass('AddedCheck');
        if(checkboxIndex == 2){
            $('#check_21').hide();
            $('.AddopenSelect').hide();
        }
        $('#check_'+checkboxIndex).prop('checked','');
        $(this).parent().remove();
        $('#addon1').val('');
        $('#addon2').val('');
        $('#addon3').val('');
        $('#addon4').val('');
        extraArray = jQuery.grep(extraArray, function(value) {
            return value != index;
        });
        var extraLength = extraArray.length;
        if(extraLength>0){
            $('.extra_guest_dropdown').html(extraLength+' Extra');
        }else{
            $('.extra_guest_dropdown').html('0 Extra');
        }
        $('.checkbox_extra_checked').html(extraArray.join(", "));
        sidebarCalculation();
    });



    $('.LoderBook').hide();
    var startDates = <?php echo json_encode($alottedRooms);?>;
    var roomPrice = <?php echo json_encode($roomPrice);?>;
    disableInOut();
    $(function () {
        $('.EditVilaBtn').hide();
        $('.EditExtraBtn').hide();
        $('.ClickGest').hide();
        $('.Chospill').hide();
        var available = $('#available').val();
        if(available == 'yes'){
            showStep3();
        }
        var currentTime = new Date();
        console.log(startDates);
        $("#start_date").datepicker({
            minDate: 0,
            beforeShowDay: function(date){
                var month = ( '0' + (date.getMonth()+1) ).slice( -2 );
                var year = date.getFullYear();
                var day = ( '0' + (date.getDate()) ).slice( -2 );
                var newdate = day+"-"+month+'-'+year;
                var dateClass = day+month+year;
                if ($.inArray(newdate, startDates) == -1) {
// addCustomInformation(roomPrice[newdate],dateClass);
addCustomInformation(roomPrice[newdate],dateClass,newdate);
return [true, dateClass];
} else {
    return [false, "highlight", "Unavailable"];
}
},  
dateFormat:'dd/mm/yy', 
onSelect: function(selected) {
    $('#total_rupees').html('');
    getShortDates();
}
});
        var endDates = <?php echo json_encode($endDateNew);?>;
        $("#end_date").datepicker({
            minDate: 0,
            beforeShowDay: function(date){
                var month = ( '0' + (date.getMonth()+1) ).slice( -2 );
                var year = date.getFullYear();
                var day = ( '0' + (date.getDate()) ).slice( -2 );
                var newdate = day+"-"+month+'-'+year;
                var dateClass = day+month+year;
                if ($.inArray(newdate, endDates) == -1) {
// addCustomInformation(roomPrice[newdate],dateClass);
addCustomInformation(roomPrice[newdate],dateClass,newdate);
return [true, dateClass];
} else {
    return [false,"highlight", "Unavailable"];
}
},  
dateFormat:'dd/mm/yy', 
onSelect: function(selected) {
    $('#total_rupees').html('');
    getShortDates();
}
});

// $('#available').datepicker({
//   inline: true,
//   minDate: 0,
//   dateFormat:'dd/mm/yy', 
//   beforeShowDay: function(date){
//     var month = ( '0' + (date.getMonth()+1) ).slice( -2 );
//     var year = date.getFullYear();
//     var day  = ( '0' + (date.getDate()) ).slice( -2 );
//     var newdate = day+"-"+month+'-'+year;
//     if ($.inArray(newdate, endDates) == -1) {
//       return [true, ""];
//     } else {
//       return [false,"highlight", "Unavailable"];
//     }
//   }
// });

});

    $(document).on('change','.currency_select1',function(){
        var currency = $(this).val();
        if(currency!=''){
            var option = $('.currency_select1 .item').text();
            $('.currency_select .item').text(option);
            $('.currency_select .item').attr('data-value',currency);
            $.ajax({
                data: {currency:currency,currencySet:1},
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    $('#currency_rate').val(result.rates);
                    $('#symbol').val(result.symbol);
                    currencyRate = result.rates;
                    symbol = result.symbol;
                }
            }).done(function(){ 
                changeCurrency();
                sidebarCalculation();
            });
        }
    });

    function changeCurrency(){
        var price = $('#pool_fence').val();
        var nights = $('#night').val();
        price = (currencyRate*price*nights).toFixed(1);
        price = numberWithCommas(price);
        $('#check_31').html(symbol+price);
        var price1 = $('#pool_fence').val();
        price1 = (currencyRate*price1).toFixed(1);
        price1 = numberWithCommas(price1);
        $('#check_32').html(symbol+price1);

        var check_0 = $('#check_0').val();
        check_0 = (currencyRate*check_0).toFixed(1);
        check_0 = numberWithCommas(check_0);
        $('#check_01').html(symbol+check_0);
        $('#check_02').html(symbol+check_0);

        var check_1 = $('#check_1').val();
        check_1 = (currencyRate*check_1).toFixed(1);
        check_1 = numberWithCommas(check_1);
        $('#check_11').html(symbol+check_1);
        $('#check_12').html(symbol+check_1);

        /*currency convert guest*/
        var check_2 = $('#check_2').val();
        check_2=check_2*currencyRate;
        check_2 = check_2.toFixed(1);
        check_2 = numberWithCommas(check_2);
        $('#check_22').html(symbol+check_2);

    }

    $(document).on('click','.edit_extra',function(){
        $('li').removeClass('current');
        $('li').removeClass('active');
        $('.step_3'). addClass('current');
        $('.step_3'). addClass('active');
        $('.check_availability_1').removeClass('bydefaultnone');
        $('.check_availability_2').addClass('bydefaultnone');
        $('.availability_yes').addClass('current');
        $('.step4_4').hide();
        $('.step3_3').show();
        $('.check_extra_2').addClass('current');
        $('.check_extra_1').addClass('bydefaultnone');
        $('.check_extra_2').removeClass('bydefaultnone');
        $('.choose_extra').show();
//$('.skip').show();
$('.Chospill').show();
$('sidebar_currency').hide();
if(extraArray.length>0){
    $('.continue').show();
}else{
    $('.skip').show();
}
dropdown(2);
});

    function showStep3(){
        $('li').removeClass('current');
        $('li').removeClass('active');
        $('.step_3'). addClass('current');
        $('.step_3'). addClass('active');
        $('.check_availability_1').removeClass('bydefaultnone');
        $('.check_availability_2').addClass('bydefaultnone');
// $('.check_guest_1').removeClass('bydefaultnone');
//$('.check_guest_2').addClass('bydefaultnone');
$('.availability_yes').addClass('current');
$('.Chospill').show();
$('sidebar_currency').hide();
}

$(document).on('change','#guests',function(){
    $('.guests').val($(this).val());
    $('#guest_short').html($(this).val()+' Guests');
    $('.guestsShort').html($(this).val());
    $('#guest1').val($(this).val());
});

$(document).on('change','.guests',function(){
    $('#guests').val($(this).val());
    $('#guest_short').html($(this).val()+' Guests');
    $('.guestsShort').html($(this).val());
    $('#guest1').val($(this).val());
});

$(document).on('click','.btn1',function(){
    $('#total_rupees').html('');
    $('.checkItem').addClass("AddedCheck");
    $('.checkItem').removeClass("introAdChkNw");
    $('#extra_guest').val(1);
    $('.AddopenSelect').hide();
    $('#check_01').hide();
    $('#check_11').hide();
    $('#check_21').hide();
    $('#check_31').hide();
    checkAvailability();
});

function disableInOut(){
    var date1 = $('#start_date').val().split('/');
    date1 = date1[1] + '-' + date1[0]  + '-' + date1[2];
    date1 = new Date(date1);
    date1.setDate(date1.getDate()-1);
    var month = ( '0' + (date1.getMonth()+1) ).slice( -2 );
    var year = date1.getFullYear();
    var day = ( '0' + (date1.getDate()) ).slice( -2 );
    date1 = day+"-"+month+'-'+year;
    var inOut = roomPrice[date1];
    inOut = inOut/2;
    $('#check_0').val(inOut);
    /*currency calculation starts*/
    inOut=inOut*currencyRate;
    inOut = inOut.toFixed(1);
    /*currency calculation ends*/
    inOut = numberWithCommas(inOut);
    $('#check_01').html(symbol+inOut);
    $('#check_02').html(symbol+inOut);
    if(isNaN(inOut) || ($.inArray(date1, startDates) != -1)){
        $('#check_0').attr('disabled',true);
        $('#check_0').closest('.checkItem').hide();
        $('#check_02').html('NOT AVAILABLE');
    }else{
        $('#check_0').attr('disabled',false);
        $('#check_0').closest('.checkItem').show();
        $('#check_02').show();
    }

    var date2 = $('#end_date').val().split('/');
    date2 = date2[0] + '-' + date2[1]  + '-' + date2[2];

    var inOut = roomPrice[date2];
    inOut = inOut/2;
    $('#check_1').val(inOut);
    /*currency calculation starts*/
    inOut=inOut*currencyRate;
    inOut = inOut.toFixed(1);
    /*currency calculation ends*/
    inOut = numberWithCommas(inOut);
    $('#check_11').html(symbol+inOut);
    $('#check_12').html(symbol+inOut);
    if(isNaN(inOut) || ($.inArray(date2, startDates) != -1)){
        $('#check_1').attr('disabled',true);
        $('#check_1').closest('.checkItem').hide();
        $('#check_12').html('NOT AVAILABLE');
    }
    else{
        $('#check_1').attr('disabled',false);
        $('#check_1').closest('.checkItem').show();
        $('#check_12').show();
    }

    var price = $('#total_price').val();
    var guests = $('#guests').val();

    var guest = price/guests;
    $('#check_2').val(guest);
    /*currency calculation starts*/
    guest=guest*currencyRate;
    guest = guest.toFixed(1);
    /*currency calculation ends*/
    guest = numberWithCommas(guest);
    $('#check_21').html(symbol+guest);

    /*guest calculation*/
    var nights = $('#night').val();
    var maxGuest = $('#maxGuest').val();
    var unitGuestPrice = price/nights/maxGuest;
    unitGuestPrice = unitGuestPrice.toFixed(1);
    $('#check_2').val(unitGuestPrice);
    /*currency calculation starts*/
    unitGuestPrice=unitGuestPrice*currencyRate;
    unitGuestPrice = unitGuestPrice.toFixed(1);
    unitGuestPrice = numberWithCommas(unitGuestPrice);
    $('#check_22').html(symbol+unitGuestPrice);

// var guestPrice = $('#check_2').val();
// var extraGuest = $('#extra_guest').val();
// var totalNights = $('#night').val();
// var guestPriceAll = guestPrice*extraGuest*totalNights;
// var overllExtraGuestPrice = numberWithCommas((guestPriceAll).toFixed(1));
// alert(overllExtraGuestPrice);
// $('#check_21').html(symbol+overllExtraGuestPrice);
}

$(document).on('click','.skip',function(){
    goToStep4('skip');
    step3 = 0;
});

function goToStep4(type){
    $('li').removeClass('current');
    $('li').removeClass('active');
    $('.step_4'). addClass('current');
    $('.step_4'). addClass('active');
    $('.check_availability_1').removeClass('bydefaultnone');
    $('.check_availability_2').addClass('bydefaultnone');
// $('.check_guest_1').removeClass('bydefaultnone');
//$('.check_guest_2').addClass('bydefaultnone');
$('.check_extra_1').removeClass('bydefaultnone');
$('.check_extra_2').addClass('bydefaultnone');
$('.choose_extra').hide();
$('.EditExtraBtn').hide();
$('.'+type).hide();
$('.step4_4').addClass('current');
$('.step4_4').css('display','block');
$('.check_details_2').show();
dropdown(3);
}

function checkAvailability(){ 
    $('.EditVilaBtn').css('display','none');                                      
    $('.ClickGest').css('display','none');                                     
    var guests = $('#guests').val();
    var date1 = $('#start_date').val();
    var date2 = $('#end_date').val();
    var d1 = date1.split("/");
    var d2 = date2.split("/");
    d1 = d1[2]+d1[1]+d1[0];
    d2 = d2[2]+d2[1]+d2[0];
    if((date1 != '') && (date2 != '')){
        if (parseInt(d2) > parseInt(d1)) {
            $('.LoderBook').show();
            $.ajax({
                data: $('#booking').serialize(),
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    if(result.status == 0){
                        $('#total_price').val(result.price);
                        var price = result.price.toFixed(1);
                        currencyTemPrice = price;
                        price = numberWithCommas(price);
                        $('li').removeClass('current');
                        $('li').removeClass('active');
                        $('#price1').val(price);
                        $('#total_amount').val(total_price);
                        /*currency calculation starts*/
                        currencyTemPrice = (currencyRate*currencyTemPrice).toFixed(1);
                        currencyTemPrice = numberWithCommas(currencyTemPrice);
                        /*currency calculation ends*/
                        $('.prices').html(symbol+currencyTemPrice);
                        $('.priceBox_main').html(symbol+currencyTemPrice);
                        $('.total_price').html(symbol+currencyTemPrice);
                        $('.sub_priceBox').html(symbol+currencyTemPrice);
                        $('.step3_3').css('display','block');
                        $('.check_extra_2').addClass('current');
                        $('.check_extra_1').addClass('bydefaultnone');
                        $('.check_extra_2').removeClass('bydefaultnone');
                        $('.step4_4').hide();
                        $('.choose_extra').show();

                        var price = $('#pool_fence').val();
                        var nights = $('#night').val();
                        price = (currencyRate*price*nights).toFixed(1);
                        price = numberWithCommas(price);
                        $('#check_31').html(symbol+price);
                        var price1 = $('#pool_fence').val();
                        price1 = (currencyRate*price1).toFixed(1);
                        price1 = numberWithCommas(price1);
                        $('#check_32').html(symbol+price1);

                        dropdown(2);
                        if(extraArray.length>0){
                            $('.continue').show();
                        }else{
                            $('.skip').show();
                        }
                        showStep3();
                        step2 = 0;
                    }else{
                        $('#total_rupees').html('<span style="color:#942424;">The selected days are not available</span>');
                    }
                    $('.guestsShort').html(guests);
                    $('.LoderBook').hide();
                    disableInOut();
                }
            });
        }else{
            Ply.dialog("alert",'Check-OUT date should be greater than Check-IN date');
        }
    }else{
//Ply.dialog("alert",'Check-OUT and Check-IN date is required');
}
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$(document).on('click','.BkNow',function(){
    var url = $('#url').val();
    window.location.href= url+'/booking';
});

function convertDate(date){
    var d=new Date(date.split("/").reverse().join("-"));
    var dd=d.getDate();
    var mm=( '0' + (d.getMonth()+1) ).slice( -2 );
    var yy=d.getFullYear();
    var newdate=mm+"/"+dd+"/"+yy;
    return newdate;
}

var symbol = $('#symbol').val();
function addCustomInformation(price,dateClass,newdate) {
    if ($.inArray(newdate, nextCheckoutDates) == -1) {
        var priceCal;
        var currencyRate = $('#currency_rate').val();
        priceCal = (currencyRate*price).toFixed(1);
        priceCal = numberWithCommas(priceCal);
        setTimeout(function() {
            $("."+dateClass).filter(function() {
                var date = $(this).text();
                return /\d/.test(date);
            }).find("a").attr('data-custom', symbol+' '+priceCal);
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

function getShortDates(){
    var startDate = $('#start_date').val();
    var endDate = $('#end_date').val();
    var date1 = $('#start_date').val();
    var date2 = $('#end_date').val();
    var d1 = date1.split("/");
    var d2 = date2.split("/");
    d1 = d1[2]+d1[1]+d1[0];
    d2 = d2[2]+d2[1]+d2[0];
    if((date1 != '') && (date2 != '')){
        if (parseInt(d2) > parseInt(d1)) {
            $('#start').val(startDate);
            $('#end').val(endDate);
//$('.start_end').html('<p>'+startDate+' - '+endDate+'</p>');
$('.start_end1 .priceBox').html('<p>'+startDate+'</p>');
$('.start_end2 .priceBox').html('<p>'+endDate+'</p>');
$.ajax({
    data: {startDate:startDate,endDate:endDate,short:1},
    type: 'post',
    dataType: 'json',
    success: function(result) {
        $('.duration').html(result.start+' - '+result.end);
        if(Number(result.days)>Number(1)){
            $('.nights').html(result.days+' Nights');
        }else{
            $('.nights').html(result.days+' Night');
        }
        $('#night').val(result.days);

        var poolFence = $('#pool_fence').val();
        $('#check_32').html(symbol+poolFence);
        poolFence = poolFence*result.days;
        $('#check_3').val(poolFence);

        var daysDiff = result.days;
        var night = 'night';
        if(daysDiff > 1){
            night = 'nights';
        }
        $('.selected_night').html(daysDiff+' '+night+' selected');
    }
});
}else{
    $('.selected_night').html('');
    Ply.dialog("alert",'Check-OUT date should be greater than Check-IN date');
}
}else{
//Ply.dialog("alert",'Check-OUT and Check-IN date is required');
}
}

$(document).on('click', '.AddedCheck', function(){
    $(this).addClass("introAdChkNw");
    $(this).removeClass("AddedCheck");
    $(this).find('label span').text("Added");
    $(this).find('.chkIn').prop('checked',true);
    var reference = $(this).find('.chkIn');
    checkBox(reference);
});
$(document).on('click', '.introAdChkNw', function(){
    $(this).addClass("AddedCheck");
    $(this).removeClass("introAdChkNw");
    $(this).find('label span').text("Add Item");
    $(this).find('.chkIn').prop('checked',false);
    var reference = $(this).find('.chkIn');
    checkBox(reference);
});

$(document).on('click','.checkTick',function() {
    if($(this).find('.chkIn').is(":checked")) {
        $('.AddopenSelect').show();
    }else{
        $('.AddopenSelect').hide();
    }
});

//var extraGuestSet = 0;

$(document).on('click','.continue',function(){
    goToStep4('continue');
    step3 = 0;
    $('.checkbox_extra_array').hide();
    var extraLength = extraArray.length;
    if(extraLength>0){
        $('.extra_guest_dropdown').html(extraLength+' Extra');
    }else{
        $('.extra_guest_dropdown').html('0 Extra');
    }
    $('.checkbox_extra_checked').html(extraArray.join(", "));
});

$(document).on('change','#extra_guest',function(){
    extraArray = jQuery.grep(extraArray, function(value) {
        return value != 'Extra Guest';
    });
    checkBox($('#check_2'));
});
//$('.chkIn').on('click',function(){
    function checkBox(reference){
        var checkBoxId = reference.attr('id');
        var numberNotChecked =  $('input:checkbox:checked').length;
        if(Number(numberNotChecked)>Number(0)){
            $('.button_replace').html('<input type="button" class="continue n2skip" value="CONTINUE">');
        }else{
            $('.button_replace').html('<input type="button" class="skip n2skip" value="SKIP">');
        }

        var removeItem = reference.data('extra');
        if(reference.prop('checked')) {
            $('#'+checkBoxId+1).show();
            extraArray.push(reference.data('extra'));
        } else {
            $('#'+checkBoxId+1).hide();
            extraArray = jQuery.grep(extraArray, function(value) {
                return value != removeItem;
            });
        }
        $('#addon1').val('');
        $('#addon2').val('');
        $('#addon3').val('');
        $('#addon4').val('');
        sidebarCalculation(removeItem);
    }

    function sidebarCalculation(removeItem=false){
        /*code for sidebar*/
        var html = '';
        var total_price = $('#total_price').val();
        var guest = $('#extra_guest').val();
        var withoutComma = total_price;
        for(var i = 0; i < extraArray.length; i++) {
            var index = extraArrayContents.indexOf(extraArray[i]);
            var price = $('#check_'+index).val();
            if(extraArray[i] != 'Extra Guest'){
                withoutComma=Number(withoutComma)+Number(price);
            }
        }

        for(var i = 0; i < extraArray.length; i++) {
            var index = extraArrayContents.indexOf(extraArray[i]);
            var price = $('#check_'+index).val();
            $('#addon'+index).val(price);
            var currencyTempPrice;
            if(extraArray[i] != 'Extra Guest'){
                total_price = Number(total_price)+Number(price);
                price = parseFloat(price).toFixed(1);
                currencyTempPrice = price;
            }else{
                var guestPrice = $('#check_2').val();
                var extraGuest = $('#extra_guest').val();
                var totalNights = $('#night').val();
                var guestPriceAll = guestPrice*extraGuest*totalNights;
                total_price = Number(total_price)+Number(guestPriceAll);
// alert(guestPrice+'----'+extraGuest+'-----'+totalNights);
var overllExtraGuestPrice = numberWithCommas((guestPriceAll*currencyRate).toFixed(1));
$('#check_21').html(symbol+overllExtraGuestPrice);
currencyTempPrice = guestPriceAll;
}

currencyTempPrice = (currencyTempPrice*currencyRate).toFixed(1);
currencyTempPrice = numberWithCommas(currencyTempPrice);
/*currency calculation ends*/
html+='<div class="row"><div class="col-md-6 col-sm-6 col-12"><div class="SummryBox"><p>'+extraArray[i]+'</p></div></div><div class="col-md-6 col-sm-6 col-12"><div class="SummryBox"><p class="priceBox">'+symbol+currencyTempPrice+'</p></div></div></div>';
}
total_price = parseFloat(total_price).toFixed(1);
var currencyTempPrice = total_price;
total_price = numberWithCommas(total_price);
$('#total_amount').val(total_price);
/*currency calculation starts*/
currencyTempPrice = (currencyTempPrice*currencyRate).toFixed(1);
currencyTempPrice = numberWithCommas(currencyTempPrice);
/*currency calculation ends*/
$('.total_price').html(symbol+currencyTempPrice);
$('.extra_sidebar').html(html);

var html = '';
var total_price = $('#total_price').val();
var sub_total = 0;
if(extraArray.length>0){
    html+='<h6>Extra</h6>';
}
for(var i = 0; i < extraArray.length; i++) {
    var index = extraArrayContents.indexOf(extraArray[i]);
    var price = $('#check_'+index).val();
    $('#addon'+index).val(price);
    if(extraArray[i] == 'Extra Guest'){
        price = Number(price)*Number(guest);
    }
    sub_total=Number(sub_total)+Number(price);
    price = parseFloat(price).toFixed(1);
    var currencyTempPrice = price;
    /*currency calculation starts*/
    currencyTempPrice = (currencyTempPrice*currencyRate).toFixed(1);
    currencyTempPrice = numberWithCommas(currencyTempPrice);
    /*currency calculation ends*/
    html+='<div class="row"><div class="col-md-6 col-sm-6 col-12"><div class="SummryBox"><p>'+extraArray[i]+'</p></div></div><div class="col-md-6 col-sm-6 col-12"><div class="SummryBox"><p class="priceBox">'+symbol+currencyTempPrice+'</p></div></div></div>';
}
sub_total = parseFloat(sub_total).toFixed(1);
/*currency calculation starts*/
sub_total = (sub_total*currencyRate).toFixed(1);
sub_total = numberWithCommas(sub_total);
/*currency calculation ends*/
if(extraArray.length>0){
    html+='<div class="row"><div class="col-md-6 col-sm-6 col-12"><div class="SummryBox"><p><strong>Subtotal</strong></p></div></div><div class="col-md-6 col-sm-6 col-12"><div class="SummryBox"><p><strong>'+symbol+sub_total+'</strong></p></div></div></div>';
}
$('.extra_div').html(html);

var total_price = $('#total_price').val();
/*currency calculation starts*/
total_price = (total_price*currencyRate).toFixed(1);
total_price = numberWithCommas(total_price);
$('.priceBox_main').html(symbol+total_price);

}

$(document).ready(function(){
    $("#show").click(function(){
        $(".AddopenSelect").show();
    });

    /*for showing circle and dropdown circle in steps tab*/
    var index = $("ul li.active").index();
    dropdown(++index);
});
$(".phone").intlTelInput();

$(document).on('click','#contact-send',function(){
    var fname = $('#fname').val();
    var lname = $('#lname').val();
    var email = $('#email').val();
    var phone = $('#phone').val();
    var country = $('#country').val();
    var comment = $('#Comment').val();
    var start = $('#start').val();
    var end = $('#end').val();
    var night = $('#night').val();
    var guest1 = $('#guest1').val();
    var price1 = $('#price1').val();
    var addon0 = $('#addon0').val();
    var addon1 = $('#addon1').val();
    var addon2 = $('#addon2').val();
    var addon3 = $('#addon3').val();
    var total_amount = $('#total_amount').val();
    var address = $('#address').val();
    $.ajax({
        data: {fname:fname,lname:lname,email:email,phone:phone,country:country,comment:comment,start:start,end:end,night:night,guest1:guest1,price1:price1,addon0:addon0,addon1:addon1,addon2:addon2,addon3:addon3,total_amount:total_amount,request:1,address:address},
        type: 'post',
        dataType: 'json',
        success: function(result) {
            if(result.status == 1){
                window.location.href = url+'/thank-you';
            }
        }
    });
});
</script>

<script>
    $(document).ready(function(){
        $("#paymtdetailss > a").click(function(){  
            $("#pymntbtnscrl").show();
        });
    });
</script>
<style type="text/css">
    .EditVilaBtn,.ClickGest {
        display: none;
    }
</style>
<style type="text/css">
    .AddopenSelect{
        display: none;
    }
</style>