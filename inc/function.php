<?php

include_once('conn.php');

function get_all_data($conn){

    $sql = "SELECT * FROM product__demnd";
    $result = mysqli_query($conn, $sql);
  


}