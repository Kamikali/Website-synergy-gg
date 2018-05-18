<?php

include_once '../dbh.inc.php';

$u_sql = "SELECT uid, role, coins FROM users";
$u_result = mysqli_query($conn, $u_sql);
while($u_row = mysqli_fetch_assoc($u_result)){

	$uid = $u_row['uid'];
	$ignoredRoles = array("Moderator", "Administrator");
	if(!in_array($u_row['role'], $ignoredRoles)){
		if($u_row['coins'] >= 0){
			$u_role = 'Synner';
		} else {
			$u_role = 'Yasuo Player';
		}
		mysqli_query($conn, "UPDATE users SET role = '$u_role' WHERE uid = '$uid'");
	}
}

?>