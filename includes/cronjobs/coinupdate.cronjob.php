<?php

include_once 'dbh.inc.php';



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

$u_sql = "SELECT * FROM users";
$u_result = mysqli_query($conn, $u_sql);
while($u_row = mysqli_fetch_assoc($u_result)){

	$uid = $u_row['uid'];
	$name = $u_row['name'];

	$u_coins = 0;
	$post_coin_result = mysqli_query($conn, "SELECT SUM(coins) AS value_coins FROM posts WHERE user_id = '$uid'");
	$post_coin_row = mysqli_fetch_assoc($post_coin_result);
	$u_coins += $post_coin_row['value_coins'];
	
	$comment_coin_result = mysqli_query($conn, "SELECT SUM(coins) AS value_coins FROM tbl_comment WHERE comment_sender_name = '$name'");
	$comment_coin_row = mysqli_fetch_assoc($comment_coin_result);
	$u_coins += $comment_coin_row['value_coins'];

	mysqli_query($conn, "UPDATE users SET coins = '$u_coins' WHERE uid = '$uid'");
}

?>