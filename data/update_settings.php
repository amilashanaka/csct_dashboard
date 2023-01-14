<?php

include_once '../inc/conn.php';


if (isset($_POST['feture_length'])) {
    $feture_length = $_POST['feture_length'];
} else {
    $feture_length = 0;
}
if (isset($_POST['batch_size'])) {
    $batch_size = $_POST['batch_size'];
} else {
    $batch_size = 0;
}
if (isset($_POST['epochs'])) {
    $epochs = $_POST['epochs'];
} else {
    $epochs = 0;
}
if (isset($_POST['input_units'])) {
    $input_units = $_POST['input_units'];
} else {
    $input_units = '';
}
if (isset($_POST['hidden_layer_1'])) {
    $hidden_layer_1 = $_POST['hidden_layer_1'];
} else {
    $hidden_layer_1 = '';
}
if (isset($_POST['hidden_layer_2'])) {
    $hidden_layer_2 = $_POST['hidden_layer_2'];
} else {
    $hidden_layer_2 = '';
}
if (isset($_POST['output_layer'])) {
    $output_units = $_POST['output_layer'];
} else {
    $output_units = '';
} 







$sql = "INSERT INTO `model_settings` (`feature_length`,  `batch_size`, `epochs`, `input_units`, `hidden_layer_1`, `hidden_layer_2`, `output_units`) VALUES ( '$feture_length',  '$batch_size', '$epochs', '$input_units', '$hidden_layer_1', '$hidden_layer_2', '$output_units')";

if (mysqli_query($conn, $sql)) {

    header('Location: ../settings_list.php?error=' . base64_encode(4));
} else {
    header('Location: ../settings_list.php?&error=' . base64_encode(3));
}


