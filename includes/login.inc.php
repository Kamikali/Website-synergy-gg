<?php

session_start();

if(isset($_POST['submit'])){

	include 'dbh.inc.php';

	$geo = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
    $country = $geo[geoplugin_countryCode];

	$uid = mysqli_real_escape_string($conn, $_POST['uid']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
	
	//Error handlers
	//Check if the inputs are empty
	if(empty($uid) || empty($pwd)){
		header("Location: ../index.php?login=cannnot-login");
		exit();
	} else {
		$sql = "SELECT * FROM users WHERE name='$uid' OR email='$uid'";
		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);	
		if($resultCheck < 1){
			header("Location: ../index.php?login=error");
			exit();
		} else {
			if ($row = mysqli_fetch_assoc($result)){
				//Dehashing the password
				$hashedPwdCheck = password_verify($pwd, $row['password']);
				if($hashedPwdCheck == false) {
					header("Location: ../index.php?login=error");
					exit();
				} elseif ($hashedPwdCheck == true) {
					//log in the user here
					$_SESSION['u_id'] = $row['uid'];
					$_SESSION['u_email'] = $row['email'];
					$_SESSION['u_uid'] = $row['name'];
					$_SESSION['u_urole'] = $row['role'];
					$_SESSION['u_countryid'] = $country;
					header("Location: ../index.php?login-successfull!");
					exit();
				}
			}
		}
	}

} else {
	header("Location: ../index.php?login=エラー");
	exit();
}