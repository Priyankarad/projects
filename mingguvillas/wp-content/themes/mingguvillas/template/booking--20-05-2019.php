<?php
/*
Template name:booking
*/
if ( ! session_id() ) {
    session_start();
}

$propertyID = $_SESSION['durationPrice']['propertyID'];
$startPriceDate = $_SESSION['durationPrice']['start_date'];
$endPriceDate = $_SESSION['durationPrice']['end_date'];
$guests = $_SESSION['durationPrice']['guests'];
$propertyID = $_SESSION['durationPrice']['propertyID'];
$available = $_SESSION['durationPrice']['available'];
$currenDate = date('Y-m-d');
$oneYearDate = date('Y-m-d',strtotime('+1 years'));
$result =  getAvailability($propertyID,$currenDate,$oneYearDate); 
$rooms = $result['RoomsAvailability']['RoomAvailability']['DayAvailability'];
$alottedRooms = array();
if(!empty($rooms)){
    foreach($rooms as $room){
        if($room['Alot'] == 0){
            $alottedRooms[] = date('d-m-Y',strtotime($room['@attributes']['day']));
        }
    }
}

$date1 = str_replace('/', '-', $startPriceDate);
$date1 = date_create(date('Y-m-d', strtotime($date1)));

$date2 = str_replace('/', '-', $endPriceDate);
$date2 = date_create(date('Y-m-d', strtotime($date2)));

$diff=date_diff($date1,$date2);
$days = $diff->format("%a");


if($_POST){
    $checkAlottedDates = array();
    $startDate = $start = date('Y-m-d',strtotime(str_replace('/','-',$_POST['start_date'])));
    $startDate = strtotime($startDate);
    $endDate = $end = date('Y-m-d',strtotime(str_replace('/','-',$_POST['end_date'])));
    $endDate = strtotime($endDate);
    $status = 0;
    for ($i=$startDate; $i<=$endDate; $i+=86400) {  
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

get_header('one');

?>
<style type="text/css">
input.btn1.HideSubmit {
    position: unset;
}
</style>
<section class="ChoosStepSection pd90">
    <input type="hidden" id="url" value="<?php home_url(); ?>">
    <input type="hidden" id="available" value="<?php echo $available; ?>">
    <div class="container">
        <div class="ChoosStepDetail">
            <div class="row">
                <div class="col-md-8 col-sm-8 col-12">
                    <div class="ChoosStep">
                        <form id="booking" action="somewhere" method="POST" class="multisteps-mawjuuds" >
                            <div class="row">
                                <div class="col-md-4">
                                    <ul id="section-tabs">
                                        <li class="current active">step 1<span class="lnr lnr-chevron-down-circle"></span></li>
                                        <li>step 2<span class="lnr lnr-chevron-down-circle"></span></li>
                                        <li class="step_3">step 3<span class="lnr lnr-chevron-down-circle"></span></li>
                                        <li>step 4<span class="lnr lnr-chevron-down-circle"></span></li>
                                    </ul>
                                </div>
                                <div class="col-md-8">
                                    <div class="mobiitemStep ">
                                        <a class="mobTabStep">Step 1 <span class="lnr lnr-chevron-down-circle"></span></a>
                                    </div>
                                    <div id="fieldsets">
                                        <fieldset class="current availability_yes">
                                            <div class="bydefaultnone check_availability_1">
                                                <div class="title-dates duration">Thu, 16 May 19 - Fri, 17 May 19</div>
                                                <p class="nights">1 Night</p>  
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
                                                                <input type="text" id="start_date" name="start_date" placeholder="<?php echo $startPriceDate;?>" class="form-control" autocomplete="off" readonly="" value="<?php echo $startPriceDate;?>">                                 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-4 col-12">
                                                            <div class="form-group BannrGrup">
                                                                <!--  <label>Selecte Date:</label> -->
                                                                <input type="text" id="end_date" name="end_date" placeholder="<?php echo $endPriceDate;?>" class="form-control" autocomplete="off" readonly="" value="<?php echo $endPriceDate;?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-4 col-12">
                                                            <div class="form-group BannrGrup">
                                                                <!--  <label>Selecte Date:</label> -->
                                                                <p class="selected_night"><?php echo $days;?> night selected</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div id="total_rupees">
                                                            <?php
                                                            if($available == 'no'){ ?>
                                                                <span style="color:#942424;">No availability found for the dates provided</span>
                                                            <?php }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <hr class="TabHr"></div>
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
                                                                        <select name="NumberOfPeople" class="form-control guests">
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
                                                    <a class="btn1 next">continue</a>
                                                </div>
                                                <!-- ========FIRST END===== -->

                                            </fieldset>
                                            <fieldset class="next availability_yes">
                                                <div class="mobiitemStep">
                                                    <a class="mobTabStep">Step 2 <span class="lnr lnr-chevron-down-circle"></span></a>
                                                </div>
                                                <div class="bydefaultnone check_guest_1">
                                                    <div class="title-dates">1 Rental</div>
                                                    <p><span class="lnr lnr-users"></span></p>  
                                                </div>



                                                <div class="click-new-hides check_guest_2">
                                                    <div class="NextFildIg">
                                                        <h1>Choose Rental</h1>
                                                        <div class="FldBoxImg">
                                                            <img src="<?php bloginfo('template_url');?>/assets/images/fldb1.jpg" alt="Image" class="img-fluid">
                                                        </div>
                                                        <div class="BookBed">
                                                            <div class="row">
                                                                <div class="col-md-12 col-sm-12 col-12">
                                                                    <div class="RentalBook">
                                                                        <p>31,087 Rs</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4 col-sm-4 col-12">
                                                                    <span class="lnr lnr-user Sman"></span>
                                                                    <div class="form-group BannrGrup chkBnIn">
                                                                        <!--  <label>Selecte Date:</label> -->
                                                                        <select name="NumberOfPeople" class="form-control">
                                                                            <option>1</option>
                                                                            <option selected="selected">2</option>
                                                                            <option>3</option>
                                                                            <option>4</option>
                                                                            <option>5</option>
                                                                            <option>6</option>
                                                                            <option>7</option>
                                                                            <option>8</option>
                                                                            <option>9</option>
                                                                            <option>10</option>
                                                                            <option>11</option>
                                                                            <option>12</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8 col-sm-8 col-12">
                                                                    <div class="RentalBookBtn">
                                                                        <a href="" class="btn btn-cta">Book Now</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset class="next Nxtfld step_3">
                                                <div class="bydefaultnone check_extra_1">
                                                    <div class="title-dates dtpExt" >
                                                        <p>0 Extra</p>
                                                        <a href="#" class="btn btn-cta">Edit vila</a></div>
                                                    </div>


                                                    <div class="click-new-hides FirstEarly">
                                                        <div class="SmallCheckout">
                                                            <div class="row">
                                                                <div class="col-12 col-sm-12 col-12">
                                                                    <div class="EarlyCheck">
                                                                        <h1>Early Check-In</h1>
                                                                        <p>More info</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="MoreItem">
                                                            <div class="row">
                                                                <div class="col-md-6 col-sm-6 col-12">
                                                                    <div class="SinglChrz">
                                                                        <p>222.5% Single charge Per stay</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-sm-6 col-12">
                                                                    <div class="SinglChrz">
                                                                        <div class="RentalBook">
                                                                            <p>31,087 Rs</p>
                                                                        </div>
                                                                        <div class="AddedCheck">
                                                                            <div class="form-check">
                                                                                <label class="form-check-label" for="exampleCheck1"><input type="checkbox" class="form-check-input chkIn" id="exampleCheck1"> <span>Add item</span></label>
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
                                                                        <h1>Early Check-In</h1>
                                                                        <p>More info</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="MoreItem">
                                                            <div class="row">
                                                                <div class="col-md-6 col-sm-6 col-12">
                                                                    <div class="SinglChrz">
                                                                        <p>222.5% Single charge Per stay</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-sm-6 col-12">
                                                                    <div class="SinglChrz">
                                                                        <div class="RentalBook">
                                                                            <p>31,087 Rs</p>
                                                                        </div>
                                                                        <div class="AddedCheck">
                                                                            <div class="form-check">
                                                                                <label class="form-check-label" for="exampleCheck1"><input type="checkbox" class="form-check-input chkIn" id="exampleCheck1"> <span>Add item</span></label>
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
                                                                        <h1>Early Check-In</h1>
                                                                        <p>More info</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="MoreItem">
                                                            <div class="row">
                                                                <div class="col-md-6 col-sm-6 col-12">
                                                                    <div class="SinglChrz">
                                                                        <p>222.5% Single charge Per stay</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-sm-6 col-12">
                                                                    <div class="SinglChrz">
                                                                        <div class="RentalBook">
                                                                            <p>31,087 Rs</p>
                                                                        </div>
                                                                        <div class="AddedCheck">
                                                                            <div class="form-check">
                                                                                <label class="form-check-label" for="exampleCheck1"><input type="checkbox" class="form-check-input chkIn" id="exampleCheck1"> <span>Add item</span></label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- ======================================FIRST ITEM END========== -->
                                                </fieldset>
                                                <fieldset class="next">
                                                    <div class="mobiitemStep check_details_1">
                                                        <a class="mobTabStep">Step 3 <span class="lnr lnr-chevron-down-circle"></span></a>
                                                    </div>
<!--  <div class="bydefaultnone">
<div class="title-dates">0 Extra</div>
<p>1 Night</p> 
</div> -->

<div class="click-new-hides check_details_2">
    <h2>Enter Details</h2>
    <div class="col-md-12 col-sm-12 col-12">
        <div class="SymkheadingCol">

            <h1>Guest Details</h1>
            <form>
                <div class="contFrom">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="form-group BannrGrup">
                                <input type="text" id="date_ex" placeholder="First Name" class="form-control BannerInput">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="form-group BannrGrup">
                                <input type="text" id="date_ex" placeholder="Last Name" class="form-control BannerInput">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-12">
                            <div class="form-group BannrGrup">
                                <input type="text" id="date_ex" placeholder="Email" class="form-control BannerInput">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input name="Name" class="form-control" type="text" value="" placeholder="(201) 555-0123">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select autocomplete="off" class="form-control" id="SelectedHouseId" name="SelectedHouseId">
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
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea cols="20" id="Comment" name="Comment" rows="5" class="form-control" placeholder="Comment"></textarea>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <button id="contact-send" type="submit" class="btn-send" data-loading-text="Loading..." tabindex="9">Send</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</fieldset>
<!-- <a class="btn1 next">continue</a>
    <input type="submit" class="btn1 HideSubmit"> -->
</div>
</div>
</div>
</form>
</div>
</div>
<div class="col-md-4 col-sm-4 col-12">
    <div class="ChoosStepSide">
        <div class="chosImg">
            <img src="<?php bloginfo('template_url');?>/assets/images/b1.jpg" class="img-fluid" alt="Image">
        </div>
        <div class="Chos04">
            <h3 >5 Bedroom - 04-Villa Sabtu</h3>
            <p >Jl.Kunti 1, Gang Mangga N.04 </p>
            <p>80361 Seminyak, Kuta, Bali Indonesia</p>
        </div>
        <div class="Chospill">
            <ul class="nav nav-pills mb-3 SumrryPils" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Summary</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Details</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="SummryRw">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="SummryBox">
                                    <p>Dates</p>
                                    <p>Villa Taxes & Fees incl.</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="SummryBox">
                                    <p>16/05/2019 - 17/05/2019</p>
                                    <p>31,090.27 Rs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="SummryRw">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="SummryBoxTo">
                                    <h1>Total</h1>
                                    <p>Property's currency</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="SummryBoxTo">
                                    <p class="BsumClr">31,086.8 Rs</p>
                                    <p>$ 445</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="SummryRw">
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
                </div>
                <!-- ================================================================================== -->
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="SummryRw">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="SummryBox">
                                    <p>Dates</p>
                                    <p>Villa Taxes & Fees incl.</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="SummryBox">
                                    <p>16/05/2019 - 17/05/2019</p>
                                    <p>31,090.27 Rs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="SummryRw">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="SummryBoxTo">
                                    <h1>Total</h1>
                                    <p>Property's currency</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="SummryBoxTo">
                                    <p class="BsumClr">31,086.8 Rs</p>
                                    <p>$ 445</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="SummryRw">
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
                </div>
            </div>
        </div>

        <!-- =======TAB END======= -->

        <div class="DollorTabHide sidebar_currency">
            <form>
                <select class="selector ftNselct">
                    <option value="dummy">Currency </option>
                    <option value="ALL Albania Lek">ALL Albania Lek</option> 
                    <option value="AFN Afghanistan Afghani">AFN Afghanistan Afghani</option> 
                    <option value="ARS Argentina Peso">ARS Argentina Peso</option> 
                    <option value="AWG Aruba Guilder">AWG Aruba Guilder</option> 
                    <option value="AUD Australia Dollar">AUD Australia Dollar</option> 
                    <option value="AZN Azerbaijan New Manat">AZN Azerbaijan New Manat</option> 
                    <option value="BSD Bahamas Dollar">BSD Bahamas Dollar</option> 
                    <option value="BBD Barbados Dollar">BBD Barbados Dollar</option> 
                    <option value="BDT Bangladeshi taka">BDT Bangladeshi taka</option> 
                    <option value="BYR Belarus Ruble">BYR Belarus Ruble</option> 
                    <option value="BZD Belize Dollar">BZD Belize Dollar</option> 
                    <option value="BMD Bermuda Dollar">BMD Bermuda Dollar</option> 
                    <option value="BOB Bolivia Boliviano">BOB Bolivia Boliviano</option> 
                    <option value="BAM Bosnia and Herzegovina Convertible Marka">BAM Bosnia and Herzegovina Convertible Marka</option> 
                    <option value="BWP Botswana Pula">BWP Botswana Pula</option> 
                    <option value="BGN Bulgaria Lev">BGN Bulgaria Lev</option> 
                    <option value="BRL Brazil Real">BRL Brazil Real</option> 
                    <option value="BND Brunei Darussalam Dollar">BND Brunei Darussalam Dollar</option> 
                    <option value="KHR Cambodia Riel">KHR Cambodia Riel</option> 
                    <option value="CAD Canada Dollar">CAD Canada Dollar</option> 
                    <option value="KYD Cayman Islands Dollar">KYD Cayman Islands Dollar</option> 
                    <option value="CLP Chile Peso">CLP Chile Peso</option> 
                    <option value="CNY China Yuan Renminbi">CNY China Yuan Renminbi</option> 
                    <option value="COP Colombia Peso">COP Colombia Peso</option> 
                    <option value="CRC Costa Rica Colon">CRC Costa Rica Colon</option> 
                    <option value="HRK Croatia Kuna">HRK Croatia Kuna</option> 
                    <option value="CUP Cuba Peso">CUP Cuba Peso</option> 
                    <option value="CZK Czech Republic Koruna">CZK Czech Republic Koruna</option> 
                    <option value="DKK Denmark Krone">DKK Denmark Krone</option> 
                    <option value="DOP Dominican Republic Peso">DOP Dominican Republic Peso</option> 
                    <option value="XCD East Caribbean Dollar">XCD East Caribbean Dollar</option> 
                    <option value="EGP Egypt Pound">EGP Egypt Pound</option> 
                    <option value="SVC El Salvador Colon">SVC El Salvador Colon</option> 
                    <option value="EEK Estonia Kroon">EEK Estonia Kroon</option> 
                    <option value="EUR Euro Member Countries">EUR Euro Member Countries</option> 
                    <option value="FKP Falkland Islands (Malvinas) Pound">FKP Falkland Islands (Malvinas) Pound</option> 
                    <option value="FJD Fiji Dollar">FJD Fiji Dollar</option> 
                    <option value="GHC Ghana Cedis">GHC Ghana Cedis</option> 
                    <option value="GIP Gibraltar Pound">GIP Gibraltar Pound</option> 
                    <option value="GTQ Guatemala Quetzal">GTQ Guatemala Quetzal</option> 
                    <option value="GGP Guernsey Pound">GGP Guernsey Pound</option> 
                    <option value="GYD Guyana Dollar">GYD Guyana Dollar</option> 
                    <option value="HNL Honduras Lempira">HNL Honduras Lempira</option> 
                    <option value="HKD Hong Kong Dollar">HKD Hong Kong Dollar</option> 
                    <option value="HUF Hungary Forint">HUF Hungary Forint</option> 
                    <option value="ISK Iceland Krona">ISK Iceland Krona</option> 
                    <option value="INR India Rupee">INR India Rupee</option> 
                    <option value="IDR Indonesia Rupiah">IDR Indonesia Rupiah</option> 
                    <option value="IRR Iran Rial">IRR Iran Rial</option> 
                    <option value="IMP Isle of Man Pound">IMP Isle of Man Pound</option> 
                    <option value="ILS Israel Shekel">ILS Israel Shekel</option> 
                    <option value="JMD Jamaica Dollar">JMD Jamaica Dollar</option> 
                    <option value="JPY Japan Yen">JPY Japan Yen</option> 
                    <option value="JEP Jersey Pound">JEP Jersey Pound</option> 
                    <option value="KZT Kazakhstan Tenge">KZT Kazakhstan Tenge</option> 
                    <option value="KPW Korea (North) Won">KPW Korea (North) Won</option> 
                    <option value="KRW Korea (South) Won">KRW Korea (South) Won</option> 
                    <option value="KGS Kyrgyzstan Som">KGS Kyrgyzstan Som</option> 
                    <option value="LAK Laos Kip">LAK Laos Kip</option> 
                    <option value="LVL Latvia Lat">LVL Latvia Lat</option> 
                    <option value="LBP Lebanon Pound">LBP Lebanon Pound</option> 
                    <option value="LRD Liberia Dollar">LRD Liberia Dollar</option> 
                    <option value="LTL Lithuania Litas">LTL Lithuania Litas</option> 
                    <option value="MKD Macedonia Denar">MKD Macedonia Denar</option> 
                    <option value="MYR Malaysia Ringgit">MYR Malaysia Ringgit</option> 
                    <option value="MUR Mauritius Rupee">MUR Mauritius Rupee</option> 
                    <option value="MXN Mexico Peso">MXN Mexico Peso</option> 
                    <option value="MNT Mongolia Tughrik">MNT Mongolia Tughrik</option> 
                    <option value="MZN Mozambique Metical">MZN Mozambique Metical</option> 
                    <option value="NAD Namibia Dollar">NAD Namibia Dollar</option> 
                    <option value="NPR Nepal Rupee">NPR Nepal Rupee</option> 
                    <option value="ANG Netherlands Antilles Guilder">ANG Netherlands Antilles Guilder</option> 
                    <option value="NZD New Zealand Dollar">NZD New Zealand Dollar</option> 
                    <option value="NIO Nicaragua Cordoba">NIO Nicaragua Cordoba</option> 
                    <option value="NGN Nigeria Naira">NGN Nigeria Naira</option> 
                    <option value="NOK Norway Krone">NOK Norway Krone</option> 
                    <option value="OMR Oman Rial">OMR Oman Rial</option> 
                    <option value="PKR Pakistan Rupee">PKR Pakistan Rupee</option> 
                    <option value="PAB Panama Balboa">PAB Panama Balboa</option> 
                    <option value="PYG Paraguay Guarani">PYG Paraguay Guarani</option> 
                    <option value="PEN Peru Nuevo Sol">PEN Peru Nuevo Sol</option> 
                    <option value="PHP Philippines Peso">PHP Philippines Peso</option> 
                    <option value="PLN Poland Zloty">PLN Poland Zloty</option> 
                    <option value="QAR Qatar Riyal">QAR Qatar Riyal</option> 
                    <option value="RON Romania New Leu">RON Romania New Leu</option> 
                    <option value="RUB Russia Ruble">RUB Russia Ruble</option> 
                    <option value="SHP Saint Helena Pound">SHP Saint Helena Pound</option> 
                    <option value="SAR Saudi Arabia Riyal">SAR Saudi Arabia Riyal</option> 
                    <option value="RSD Serbia Dinar">RSD Serbia Dinar</option> 
                    <option value="SCR Seychelles Rupee">SCR Seychelles Rupee</option> 
                    <option value="SGD Singapore Dollar">SGD Singapore Dollar</option> 
                    <option value="SBD Solomon Islands Dollar">SBD Solomon Islands Dollar</option> 
                    <option value="SOS Somalia Shilling">SOS Somalia Shilling</option> 
                    <option value="ZAR South Africa Rand">ZAR South Africa Rand</option> 
                    <option value="LKR Sri Lanka Rupee">LKR Sri Lanka Rupee</option> 
                    <option value="SEK Sweden Krona">SEK Sweden Krona</option> 
                    <option value="CHF Switzerland Franc">CHF Switzerland Franc</option> 
                    <option value="SRD Suriname Dollar">SRD Suriname Dollar</option> 
                    <option value="SYP Syria Pound">SYP Syria Pound</option> 
                    <option value="TWD Taiwan New Dollar">TWD Taiwan New Dollar</option> 
                    <option value="THB Thailand Baht">THB Thailand Baht</option> 
                    <option value="TTD Trinidad and Tobago Dollar">TTD Trinidad and Tobago Dollar</option> 
                    <option value="TRY Turkey Lira">TRY Turkey Lira</option> 
                    <option value="TRL Turkey Lira">TRL Turkey Lira</option> 
                    <option value="TVD Tuvalu Dollar">TVD Tuvalu Dollar</option> 
                    <option value="UAH Ukraine Hryvna">UAH Ukraine Hryvna</option> 
                    <option value="GBP United Kingdom Pound">GBP United Kingdom Pound</option> 
                    <option value="USD United States Dollar">USD United States Dollar</option> 
                    <option value="UYU Uruguay Peso">UYU Uruguay Peso</option> 
                    <option value="UZS Uzbekistan Som">UZS Uzbekistan Som</option> 
                    <option value="VEF Venezuela Bolivar">VEF Venezuela Bolivar</option> 
                    <option value="VND Viet Nam Dong">VND Viet Nam Dong</option> 
                    <option value="YER Yemen Rial">YER Yemen Rial</option> 
                    <option value="ZWD Zimbabwe Dollar">ZWD Zimbabwe Dollar</option> 
                </select>
            </form>
        </div>
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

    $("#section-tabs li").on("click", function(e){
        var i = $(this).index();
        if ($(this).hasClass("active")){
            goToSection(i);
        } else {
            alert("Please complete previous sections first.");
        }
    });

//var alink = 0;
$('.LoderBook').hide();
$(function () {
    $('.Chospill').hide();
    var available = $('#available').val();
    if(available == 'yes'){
        $('li').removeClass('current');
        $('li').removeClass('active');
        $('.step_3'). addClass('current');
        $('.step_3'). addClass('active');
        $('.check_availability_1').removeClass('bydefaultnone');
        $('.check_availability_2').addClass('bydefaultnone');
        $('.check_guest_1').removeClass('bydefaultnone');
        $('.check_guest_2').addClass('bydefaultnone');
        $('.availability_yes').addClass('current');
        $('.Chospill').show();
        $('sidebar_currency').hide();
    }
    var currentTime = new Date();
    var startDates = <?php echo json_encode($alottedRooms);?>;
    console.log(startDates);
    $("#start_date").datepicker({
        minDate: 0,
        beforeShowDay: function(date){
            var month = ( '0' + (date.getMonth()+1) ).slice( -2 );
            var year = date.getFullYear();
            var day = ( '0' + (date.getDate()) ).slice( -2 );
            var newdate = day+"-"+month+'-'+year;
            if ($.inArray(newdate, startDates) == -1) {
                return [true, ""];
            } else {
                return [false, "highlight", "Unavailable"];
            }
        },  
        dateFormat:'dd/mm/yy', 
        onSelect: function(selected) {
            $('#total_rupees').html('');
            var daysDiff = calculateDiff();
            var night = 'night';
            if(daysDiff > 1){
                night = 'nights';
            }
            $('.selected_night').html(daysDiff+' '+night+' selected');
        }
    });
    var endDates = <?php echo json_encode($alottedRooms);?>;
    $("#end_date").datepicker({
        minDate: 0,
        beforeShowDay: function(date){
            var month = ( '0' + (date.getMonth()+1) ).slice( -2 );
            var year = date.getFullYear();
            var day = ( '0' + (date.getDate()) ).slice( -2 );
            var newdate = day+"-"+month+'-'+year;
            if ($.inArray(newdate, endDates) == -1) {
                return [true, ""];
            } else {
                return [false,"highlight", "Unavailable"];
            }
        },  
        dateFormat:'dd/mm/yy', 
        onSelect: function(selected) {
            $('#total_rupees').html('');
            var daysDiff = calculateDiff();
            var night = 'night';
            if(daysDiff > 1){
                night = 'nights';
            }
            $('.selected_night').html(daysDiff+' '+night+' selected');
        }
    });

    $('#available').datepicker({
        inline: true,
        minDate: 0,
        dateFormat:'dd/mm/yy', 
        beforeShowDay: function(date){
            var month = ( '0' + (date.getMonth()+1) ).slice( -2 );
            var year = date.getFullYear();
            var day  = ( '0' + (date.getDate()) ).slice( -2 );
            var newdate = day+"-"+month+'-'+year;
            if ($.inArray(newdate, endDates) == -1) {
                return [true, ""];
            } else {
                return [false,"highlight", "Unavailable"];
            }
        }
    });

});

$(document).on('change','.guests',function(){
    checkAvailability();
});

$(document).on('click','.btn1',function(){
    checkAvailability();
});

function checkAvailability(){
    $('.LoderBook').show();
    $.ajax({
        data: $('#booking').serialize(),
        type: 'post',
        dataType: 'json',
        success: function(result) {
            if(result.status == 0){
                var price = result.price.toFixed(2);
                price = numberWithCommas(price);
                $('#total_rupees').html('<span style="color:#942424;">Total '+price+' Rs</span>');
            }else{
                $('#total_rupees').html('<span style="color:#942424;">No availability found for the dates provided</span>');
            }

            $('.LoderBook').hide();
        }
    });
}


// To calulate difference b/w two dates
function calculateDiff() {

    if($("#start_date").val()!="" && $("#end_date").val()!=""){
        var start = convertDate($("#start_date").val());
        var end = convertDate($("#end_date").val());
        var From_date = new Date(start);
        var To_date = new Date(end);
        var diff_date =  To_date - From_date;
        var years = Math.floor(diff_date/31536000000);
        var months = Math.floor((diff_date % 31536000000)/2628000000);
        var days = Math.floor(((diff_date % 31536000000) % 2628000000)/86400000);
        return days;
    }
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$(document).on('click','.BkNow',function(){
    var url = $('#url').val();
//if(alink == 1){
    window.location.href= url+'/booking';
//}
});

function convertDate(date){
    var d=new Date(date.split("/").reverse().join("-"));
    var dd=d.getDate();
    var mm=( '0' + (d.getMonth()+1) ).slice( -2 );
    var yy=d.getFullYear();
    var newdate=mm+"/"+dd+"/"+yy;
    return newdate;
}

$(document).on('click', '.AddedCheck', function(){
    $(this).addClass("introAdChkNw");
    $(this).removeClass("AddedCheck");

    $(this).find('label span').text("Added");
});
$(document).on('click', '.introAdChkNw', function(){
    $(this).addClass("AddedCheck");
    $(this).removeClass("introAdChkNw");

    $(this).find('label span').text("Add Item");
});
</script>