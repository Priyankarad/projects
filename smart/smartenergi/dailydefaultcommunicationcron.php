<?php
//mail('subh.laha@gmail.com','Daily communication Cron Mail executed','Daily communication Cron Mail executed at '.date('d/m/Y h:i:s A'));

include('config.php');

$url = BASE_URL.'backoffice/cronjobs/defaultcommunication';

//die($url);

$request = curl_init($url);
curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($request);
curl_close($request);

?>