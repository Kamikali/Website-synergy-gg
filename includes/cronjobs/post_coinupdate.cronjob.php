<?php

include_once '../dbh.inc.php';

//UPDATE COINS FOR POSTS
$sql = "SELECT uid FROM posts";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($result)){
	$uid = $row['uid'];
	//GET LIKES (likes - dislike = coins)
	$coins = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM likes WHERE post_id = '$uid' AND isLike = 1"))
	 	   - mysqli_num_rows(mysqli_query($conn, "SELECT * FROM likes WHERE post_id = '$uid' AND isLike = 0"));

	//UPDATE COINS
	mysqli_query($conn, "UPDATE posts SET coins = '$coins' WHERE uid = '$uid'"); 
}

?>