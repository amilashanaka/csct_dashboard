<?php

include_once('./inc/conn.php');
 
$sql = "SELECT * FROM model_settings";
$result = mysqli_query($conn, $sql);
 
