<?php

$dbServerName = "db735578055.db.1and1.com";
$dbUserName = "dbo735578055";
$dbPassword = "ZS<Sn}IY7oDCSPsB";
$dbName = "db735578055";
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