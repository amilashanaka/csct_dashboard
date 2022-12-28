<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://127.0.0.1:5000/result_tranning',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$training_data = curl_exec($curl);

curl_close($curl);

$arr = json_decode($training_data, true);

$dates = '';
$old_dates = '';
$order_demands = '';
$train_set = '';
$error = '';


foreach ($arr as $key => $value) {
    $dates    = $dates."'".$value['Date']."',";
    $old_dates    = $old_dates."'".$value['Date']."',";
    $order_demands=  $order_demands."'".$value['OrderDemand']."',";
    $train_set = $train_set . "['" . $value['Date'] . "'," . $value['OrderDemand'] . "],";
 
 
}



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://127.0.0.1:5000/result_validate',
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

foreach ($arr_new as $key => $value) {
    $dates    = $dates."'".$value['Date']."',";
    $date_validate = $date_validate . "'" . $value['Date'] . "',";
    $predection = $predection . "'" . $value['Predictions'] . "',";
    $order_validate=  $order_validate."'".$value['OrderDemand']."',";
    $error_val=abs($value['OrderDemand']-$value['Predictions']);
    $error    = $error."'". $error_val."',";
 
}



