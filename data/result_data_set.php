<?php

// Fetch Result from API Core

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://127.0.0.1:5000/forecast_data',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));



$validate = curl_exec($curl);

curl_close($curl);


$arr_new = json_decode($validate, true);


$date_validate = '';
$order_validate = '';
$predection = '';
$error = '';

$total_predection = 0;
$total_order_demands = 0;
$total_error = 0;

foreach ($arr_new as $key => $value) {
   
    $date_validate = $date_validate . "'" .$value['Date']. "',";
    $predection = $predection . "'" .round( $value['Predictions']). "',";
    $order_validate=  $order_validate."'".$value['OrderDemand']."',";
    $error_val=$value['OrderDemand']-$value['Predictions'];
    $error    = $error."'". round($error_val)."',";

  $total_predection += floatval($value['Predictions']);
  $total_order_demands += floatval($value['OrderDemand']);
  $total_error += floatval(abs($error_val));
 
}



//==============================================================================

// Fetch warehouse details from database



