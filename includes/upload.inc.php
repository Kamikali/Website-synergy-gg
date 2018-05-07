<?php
if(isset($_POST['submit'])){

	session_start();
	include_once 'dbh.inc.php';
	include_once 'thumbnail.inc.php';

	//check if connected
	if (!$conn) {
   		die("Connection failed: " . mysqli_connect_error());
	}

	$title = mysqli_real_escape_string($conn, $_POST['title']);
	$message = mysqli_real_escape_string($conn, $_POST['message']);

	$file = $_FILES['file'];

	$fileName = $_FILES['file']['name'];
	$fileTmpName = $_FILES['file']['tmp_name'];
	$fileSize = $_FILES['file']['size'];
	$fileError = $_FILES['file']['error'];
	$fileType = $_FILES['file']['type'];

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));

	$allowed = array('jpg', 'jpeg', 'png', 'gif', 'mp4', 'm4v');

	if (!in_array($fileActualExt, $allowed)) {
		echo "You cannot upload files of this type";
	} else {
		if (!$fileError === 0) {
			echo "There was an error uploading your image";
		} else {
			//TODO: MAX FILESIZE NOT WORKING for some reason... -- should be fixed by now
			if($fileSize > 8000000){ //MB
				echo "Your file was too big";
			} else {
				if (strpos($_POST["title"], '<') !== false || strpos($_POST["title"], '>') !== false) {
  					  echo "Title and/or Description are not allowed to include < or >!";
  				} else {
					if (strpos($_POST["message"], '<') !== false || strpos($_POST["message"], '>') !== false) {
	  					  echo "Title and/or Description are not allowed to include < or >!";
	  				} else {

						$fileNameNew = uniqid('', true).".".$fileActualExt;
						

						$year = date("Y");
						$month = date("m");
						$day = date("d");
						$directory = "$year/$month/$day/";
		 
						if(!is_dir('../uploads/'.$directory)){
		   					mkdir('../uploads/'.$directory, 755, true);
						}

						//test if upload is a video or a picture
						$isPic = true;
						if (($fileActualExt == 'mp4') || ($fileActualExt == 'm4v')) {
							$isPic = false;
						} else {
							$thumbnailName = uniqid('', true).".jpeg";
						}				

						
						
						//upload file
						$fileDestination = 'uploads/'.$directory.$fileNameNew;
						move_uploaded_file($fileTmpName, '../'.$fileDestination);
						//create thumbnail
						$thumbnailDirection = 'uploads/'.$directory.$thumbnailName;
						create_thumbnail('../'.$fileDestination, '../'.$thumbnailDirection, 60, 60);
						//insert file data into database
						$upload_user_id = $_SESSION['u_id'];
						$upload_user_uid = $_SESSION['u_uid'];
						$country = $_SESSION['u_countryid'];
						$sql = "INSERT INTO posts(title, message, path, thumbnail_path, user_id, user_uid, country, nsfwl, date, upvotes, downvotes, ispic)    
								VALUES ('$title', '$message', '$fileDestination', '$thumbnailDirection', '$upload_user_id', '$upload_user_uid', '$country', 'sfw', NOW(), 0, 0, '$isPic')";
						mysqli_query($conn, $sql);
						//head back to main page
						header("Location: ../news.php?=uploadsuccess");
					}
				}
			}
		}	
	}
}