<?php

if(isset($_POST['submit'])){

	include_once 'dbh.inc.php';

	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$uid = mysqli_real_escape_string($conn, $_POST['uid']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
	$rPwd = mysqli_real_escape_string($conn, $_POST['rPwd']);

	$geo = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
	$country = $geo[geoplugin_countryCode];

	//Error handlers
	//Name contains only a-z A-Z and 0-9
	
	if (empty($email) || empty($uid) || empty($pwd)){
		header("Location: ../signup.php?signup=empty");		//unused code
		exit();
	} else {
		//Check for empty fields
		if(preg_match("/^[a-zA-Z0-9]+$/", $uid) == 0) {
			header("Location: ../signup.php?signup=invalidchar");		//unused code
			exit();
		} else {
			$sql = "SELECT * FROM users WHERE email='$email'";
			$result = mysqli_query($conn, $sql);
			$resultCheck = mysqli_num_rows($result);

			if ($resultCheck > 0) {
				header("Location: ../signup.php?signup=mailalreadyused");
				exit();
			} else {
				//Check if input characters are valid
				if (!(strlen($uid)>2 && strlen($uid)<17)){
					header("Location: ../signup.php?signup=username");
					exit();
				} else {
					//Check if e-mail is valid
					if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
						header("Location: ../signup.php?signup=cantusemail");
						exit();

					} else {
						$sql = "SELECT * FROM users WHERE name='$uid'";
						$result = mysqli_query($conn, $sql);
						$resultCheck = mysqli_num_rows($result);

						if($resultCheck > 0){
							header("Location: ../signup.php?signup=usernamealreadyused");
							exit();
						} else {
							if ($pwd != $rPwd) {
								header("Location: ../signup.php?signup=passworddoesntmatch");
							} else {
								//Hashing the password
								$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
								//Insert the User into the database
								$sql = "INSERT INTO users (name, role, email, created, password, countryID) 
										VALUES ('$uid', 'user', '$email', NOW(), '$hashedPwd', '$country')";
								mysqli_query($conn, $sql);

								header("Location: ../index.php?signup=signupsuccess");
								exit();
							}
						}		
					}
				}
		    }
		}
	}
} else {
	header("Location: ../signup.php");
	exit();
}