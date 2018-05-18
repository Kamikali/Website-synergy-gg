<?php

include_once '../dbh.inc.php';

//UPDATE COINS FOR COMMENTS
$c_sql = "SELECT comment_id FROM tbl_comment";
$c_result = mysqli_query($conn, $c_sql);
while($c_row = mysqli_fetch_assoc($c_result)){
	$c_uid = $c_row['comment_id'];
	//GET LIKES (likes - dislike = coins)
	$c_coins = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM comment_likes WHERE comment_id = '$c_uid' AND isLike = 1"))
		   - mysqli_num_rows(mysqli_query($conn, "SELECT * FROM comment_likes WHERE comment_id = '$c_uid' AND isLike = 0"));

	//UPDATE COINS
	mysqli_query($conn, "UPDATE tbl_comment SET coins = '$c_coins' WHERE comment_id = '$c_uid'"); 
}

?>