<?php
include('config.php');

$url = BASE_URL.'backoffice/cronjobs/borrowermonthlyinstallment';

$request = curl_init($url);
curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($request);
curl_close($request);
print_r($response);

?>