<?php

include_once "dbh.inc.php";

if(isset($_POST['submit'])){
	$type = $_POST['type'];
	if($type == 'post'){
		$img = $_POST['articleNumber'];
		mysqli_query($conn, "UPDATE posts SET visible = 1 WHERE uid = '$img'");
		header("Location: ../article.php?img=".$img);
	} else if($type == 'comment') {
		$img = $_POST['commentNumber'];
		mysqli_query($conn, "UPDATE tbl_comment SET visible = 1 WHERE comment_id = '$img'");
		header("Location: ../news.php");
	}

}