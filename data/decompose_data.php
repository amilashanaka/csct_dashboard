<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://127.0.0.1:5000/decompose',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$decompose_data = curl_exec($curl);

curl_close($curl);


$arr_new = json_decode($decompose_data, true);


$dates = '';
$trend = '';
$sesonal = '';
$resid = '';

foreach ($arr_new as $key => $value) {
   
    $dates = $dates . "'" .$value['Date']. "',";
    $trend = $trend . "'" .$value['trend']. "',";
    $sesonal = $sesonal . "'" .($value['sesonal']). "',";
    $resid = $resid . "'" .$value['resid']. "',";
 
}

