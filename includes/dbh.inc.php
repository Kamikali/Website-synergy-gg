<?php

/*
$dbServerName = "localhost";
$dbUserName = "root";
$dbPassword = "";
$dbName = "synergy";
*/
$conn = mysqli_connect($dbServerName, $dbUserName, $dbPassword, $dbName);

if(!$conn){
	die("Connection failed: ".mysqli_connect_error());
}

mysqli_set_charset($conn, 'utf8mb4');