<?php

include_once('./inc/conn.php');
 
$sql = "SELECT * FROM product__demnd limit 10000";
$result = mysqli_query($conn, $sql);
 
