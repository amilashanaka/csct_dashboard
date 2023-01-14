<?php


include_once('./inc/conn.php');

$sql = "SELECT ms.id, ms.input_units, ms.hidden_layer_1, ms.hidden_layer_2, ms.output_units,tr.epochs, tr.rmse,tr.mae,tr.mape,tr.accurecy FROM model_perforemence mp INNER JOIN trannings tr ON mp.trannings_id = tr.id INNER JOIN model_settings ms ON mp.model_settings_id = ms.id;";

$result = mysqli_query($conn, $sql);

