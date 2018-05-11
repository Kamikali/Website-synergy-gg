<?php

$dbServerName = "db735578055.db.1and1.com";
$dbUserName = "dbo735578055";
$dbPassword = "cqJ%3+^Dn3n@WQ34yPfr*#Tj^=X^K7kk";
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