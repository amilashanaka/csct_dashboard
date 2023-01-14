<?php

include_once('conn.php');

function get_accurecy($conn){

    $sql = "select    accurecy from trannings ORDER BY id DESC LIMIT 1";

    $result = mysqli_query($conn, $sql);
    $res = mysqli_fetch_assoc($result);
 

    return $res['accurecy'];


}

function get_layer_1_nodes(){

    
}

function get_epochs($conn){
    $sql = "SELECT epochs from trannings order by id desc limit 1";
    $result = mysqli_query($conn, $sql);
    $res = mysqli_fetch_assoc($result);
    return $res['epochs'];

}

function get_execute_time($conn){
    $sql = "SELECT execute_time from trannings order by id desc limit 1";
    $result = mysqli_query($conn, $sql);
    $res = mysqli_fetch_assoc($result);
    return $res['execute_time'];
}

function get_time_steps($conn){
    $sql = "SELECT time_steps from trannings order by id desc limit 1";
    $result = mysqli_query($conn, $sql);
    $res = mysqli_fetch_assoc($result);
    return $res['time_steps'];
}