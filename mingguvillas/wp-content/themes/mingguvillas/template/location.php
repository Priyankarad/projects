<?php
/*
Template Name:location
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
                    'value'     => ucwords($city),
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
        $minRoomPrice = min($roomPrice);
          $minRoomPrice = $rates*$minRoomPrice;
          $villaData[$villaID]['min_price'] = $symbol.number_format($minRoomPrice,1);
/*Code for image*/
            $imageID = $villaData['main_image'][0];
            $imageData = get_post($imageID);
            if(!empty($imageData)){
              $villaData[$villaID]['image'] = $imageData->guid;
            }else{
              $villaData[$villaID]['image'] = '';
            }
                $villaName = isset($villaData['my_villa_first_section_title_one'][0])?$villaData['my_villa_first_section_title_one'][0]:'';
                $villaName = explode('-',$villaName);
            $villaNameCapital = strtoupper($villaName[1]);
                $latitude = isset($villaData['latitude'][0])?$villaData['latitude'][0]:'';
                $longitude = isset($villaData['longitude'][0])?$villaData['longitude'][0]:'';
                $locations[]=array('name'=>$villaName[0].' - '.$villaNameCapital, 'lat'=>$latitude, 'lng'=>$longitude, 'city'=>$city, 'villa_id'=>$villaID,'image'=>$villaData[$villaID]['image'],'price'=>$villaData[$villaID]['min_price']);
            }
        }
    }
}
$markers = json_encode($locations);
get_header('one');
?>
<input type="hidden" name="markers" id="markers" value='<?php echo $markers;?>'>
<input type="hidden" name="zoom" id="zoom" value='12'>
<section class="LocationPage bodybkf6 pd90">
    <div class="container">
        <div class="fkkf">
            <div class="Symkheading">
                <h1>Where Is Minggu Villas In <?php echo implode(' & ', $cityArray);?>?</h1>
            </div>
        </div>
        <div class="MainLocBoxes">
            <div class="row justify-content-center">
                <div class="col-md-10 col-sm-10 col-10">
                    <div class="MainLocMap">
                        <div id="map"></div>
                    </div>
                </div>
                <div class="col-md-10 col-sm-10 col-10">
                    <div class="MapofCon">
                        <p><em>Jl.Kunti 1, Gang Mangga N.4,</em></p>
                        <p><em>80361, Seminyak, Kuta,</em></p>
                        <p><em>Bali, Indonesia</em></p>
                    </div>
                    <div class="LocationContent">
                        <p><strong>Minggu Villas Is Located Right In The Real Center Of Seminyak</strong>
                        known as the most exsclusive residential area of Bali.</p>
                        <p>Set in a peaceful neighborhood with the two most popular tourist areas Jalan Oberoi/Petitenget and Kuta extending from 1,5 to 4 Km each direction, covered with restaurants, shops and nightlife.</p>
                        <p>0.5 km to Sunset Road bypass crossroad with 24 hours open petrol station, making it simple for you to take a day trip around the island between sacred temples  and  stunning tropical white sand beaches.</p>
                        <ul>
                            <li>0 km to Seminyak</li>
                            <li>0,3 km to shops and restaurants</li>
                            <li>0,3 km to Bali Deli supermarket</li>
                            <li>1,4 km to Seminyak beach</li>
                            <li>1.5 up to 2,5 km to Oberoi / Petitenget</li>
                            <li>1,5 up to 4 Km to Kuta</li>
                            <li>19,7 km to the Denpasar International Airport</li>
                        </ul>
                        <div class="LocFootP">
                            <p><strong>AIrport Transfer</strong>Airport transfer extra charge: US$ 13.00 each way.</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php get_footer();
