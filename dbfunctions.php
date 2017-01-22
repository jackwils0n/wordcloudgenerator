<?php
global $error;

function db_con($db){
    global $error;
    $con = mysqli_connect("localhost", "jack", "localhost", $db);
    if(!$con){
        $error = "Unable to connect to database: ". $db;
    }
    return $con;
}

function db_query($con, $query){
    global $error;
    $result = mysqli_query($con, $query);
    if(!$result){
        $error = "Query failed";
    }
    return $result;
}

?>