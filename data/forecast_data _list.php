<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://127.0.0.1:5000/predict_result',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$predict_result = curl_exec($curl);

curl_close($curl);

$result = array();

$arr_new = json_decode($predict_result, true);


$dates = '';
$order_validate = '';
$predection = '';
$error = '';

foreach ($arr_new as $key => $value) {
   
    $dates = $dates . "'" .$value['Date']. "',";
    $predection = $predection . "'" .round( $value['Order_Demand']). "',";

  array_push($result, 'Date', $dates);
 
}

//==============================================================================

// Fetch warehouse details from database




