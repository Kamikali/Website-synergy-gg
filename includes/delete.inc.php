<?php

include_once "dbh.inc.php";

if(isset($_POST['submit'])){
	if($_POST['toDel'] == "post"){
		$img = $_POST['articleNumber'];
		mysqli_query($conn, "UPDATE posts SET visible = 0 WHERE uid = '$img'");
		header("Location: ../deleted.php?img=".$img."&type=post");
	} else if ($_POST['toDel'] == 'comment'){
		$img = $_POST['commentNumber'];
		mysqli_query($conn, "UPDATE tbl_comment SET visible = 0 WHERE comment_id = '$img'");
		header("Location: ../deleted.php?img=".$img."&type=comment");
	} else {
		echo "Wait, you can see this text? This should not be the case!<br>Apparently this sites Admin is an idiot - please tell him how you got access to this text c:";
	}
}
