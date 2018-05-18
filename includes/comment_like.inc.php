<?php



if(isset($_POST['action']) && isset($_POST['uid']) && isset($_POST['img']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    $uid = $_POST['uid'];
    $img = $_POST['img'];

    include_once 'dbh.inc.php';

    switch($action) {
        case 'like' : addLike($conn, $img, $uid, true);break;
        case 'dislike' : addDislike($conn, $img, $uid, false);break;
    }
}
			//DER GESAMTE CODE HIER IST SEHR SCHEISSE UND MUSS UNBEDINGT VERBESSERT WERDEN


function addLike($conn, $img, $uid, $like) {
	$points = 'Points';
	$colour = '';
		$sql = "SELECT isLike FROM comment_likes WHERE user_id = '$uid' AND comment_id = '$img'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) == 0){
			$sql = "INSERT INTO comment_likes VALUES ('$img', '$uid', '$like')";
			$result2 = mysqli_query($conn, $sql);
			$colour = '#4fdbff';
		} else {
			while($row = mysqli_fetch_assoc($result)) {
				if($row['isLike'] == 1){
					$sql = "DELETE FROM comment_likes WHERE user_id = '$uid' AND comment_id = '$img'";
					$result = mysqli_query($conn, $sql);
					$colour = '#ffffff';
				} else {
					$sql = "UPDATE comment_likes SET isLike= true WHERE user_id = '$uid' AND comment_id = '$img'";
					$result = mysqli_query($conn, $sql);
					$colour = '#4fdbff';
				}
			}			
		}
		//GET UPLOAD BENIS
		$likes = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM comment_likes WHERE comment_id = '$img' AND isLike = 1"))
			   - mysqli_num_rows(mysqli_query($conn, "SELECT * FROM comment_likes WHERE comment_id = '$img' AND isLike = 0"));
		if($likes == 1 || $likes == -1){
			$points = 'Point';
		}
		echo "<i style='color:".$colour.";'>".$likes." ".$points."</i>";
}

function addDislike($conn, $img, $uid, $like) {
		$points = 'Points';
		$colour = '';
		$sql = "SELECT isLike FROM comment_likes WHERE user_id = '$uid' AND comment_id = '$img'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) == 0){
			$sql = "INSERT INTO comment_likes VALUES ('$img', '$uid', '$like')";
			$result = mysqli_query($conn, $sql);
			$colour = '#707070';
		} else {
			while($row = mysqli_fetch_assoc($result)) {
				if($row['isLike'] == 0){
					$sql = "DELETE FROM comment_likes WHERE user_id = '$uid' AND comment_id = '$img'";
					$result = mysqli_query($conn, $sql);
					$colour = '#ffffff';
				} else {
					$sql = "UPDATE comment_likes SET isLike= false WHERE user_id = '$uid' AND comment_id = '$img'";
					$result = mysqli_query($conn, $sql);
					$colour = '#707070';
				}
			}
		}
	//GET UPLOAD BENIS
	$likes = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM comment_likes WHERE comment_id = '$img' AND isLike = 1"))
		   - mysqli_num_rows(mysqli_query($conn, "SELECT * FROM comment_likes WHERE comment_id = '$img' AND isLike = 0"));
	if($likes == 1 || $likes == -1){
		$points = 'Point';
	}
	echo "<i style='color:".$colour.";'>".$likes." ".$points."</i>";
}