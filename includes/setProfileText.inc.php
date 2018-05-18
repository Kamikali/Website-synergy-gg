<?php

include_once "header.php";
include_once "dbh.inc.php";
session_start();

if(isset($_POST['submit'])){
	$text = escape($_POST['profile_text']);
	$uid = $_SESSION['u_id'];
	$sql = "UPDATE users SET profile_text = '$text' WHERE '$uid' = uid";
	mysqli_query($conn, $sql);
	header("Location: ../index.php");
}

function escape($s) {
	return str_replace('<', "&lt;", str_replace('>', "&gt;", str_replace('&', "&amp;", $s)));
}