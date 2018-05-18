<?php

include_once '../dbh.inc.php';

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