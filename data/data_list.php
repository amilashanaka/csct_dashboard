<?php

include_once('./inc/conn.php');
 
$sql = "SELECT * FROM aw_product_demand ";
$result = mysqli_query($conn, $sql);
 
