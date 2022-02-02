<?php
/*

Template name:cron

*/

$currenDate = date('Y-m-d');
$oneYearDate = date('Y-m-d',strtotime('+3 months'));
$propertyArrays = array(562554,274371,712389,787365,643089,113867,298710); 
foreach($propertyArrays as $propertyID){
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
	$price = min($roomPrice);
	$wpdb->query($wpdb->prepare("UPDATE min_price SET price=%d WHERE villa_id=%d",$price,$propertyID));
}

?>