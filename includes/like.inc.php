<?php



if(isset($_POST['action']) && isset($_POST['uid']) && isset($_POST['img']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    $uid = $_POST['uid'];
    $img = $_POST['img'];

    include_once 'dbh.inc.php';

    switch($action) {
        case 'like' : addLike($conn, $img, $uid, true);break;
        case 'dislike' : addDislike($conn, $img, $uid, false);break;
        case 'likeComment' : test($img);break;
        // ...etc...
    }
}
function test($img){
	echo "<script>alert($img);</script>";
}

			//DER GESAMTE CODE HIER IST SEHR SCHEISSE UND MUSS UNBEDINGT VERBESSERT WERDEN


function addLike($conn, $img, $uid, $like) {
	$colour = '';
		$sql = "SELECT isLike FROM likes WHERE user_id = '$uid' AND post_id = '$img'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) == 0){
			$sql = "INSERT INTO likes VALUES ('$img', '$uid', '$like')";
			$result2 = mysqli_query($conn, $sql);
			$colour = '#4fdbff';
		} else {
			while($row = mysqli_fetch_assoc($result)) {
				if($row['isLike'] == 1){
					$sql = "DELETE FROM likes WHERE user_id = '$uid' AND post_id = '$img'";
					$result = mysqli_query($conn, $sql);
					$colour = '#ffffff';
				} else {
					$sql = "UPDATE likes SET isLike= true WHERE user_id = '$uid' AND post_id = '$img'";
					$result = mysqli_query($conn, $sql);
					$colour = '#4fdbff';
				}
			}			
		}
		//GET UPLOAD BENIS
		echo "<p style='color:".$colour.";'>".(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM likes WHERE post_id = '$img' AND isLike = 1"))
			 - mysqli_num_rows(mysqli_query($conn, "SELECT * FROM likes WHERE post_id = '$img' AND isLike = 0")))."</p>";
}

function addDislike($conn, $img, $uid, $like) {
		//echo "<script>alert('".$img."')</script>";
		$colour = '';
		$sql = "SELECT isLike FROM likes WHERE user_id = '$uid' AND post_id = '$img'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) == 0){
			$sql = "INSERT INTO likes VALUES ('$img', '$uid', '$like')";
			$result = mysqli_query($conn, $sql);
			$colour = '#707070';
		} else {
			while($row = mysqli_fetch_assoc($result)) {
				if($row['isLike'] == 0){
					$sql = "DELETE FROM likes WHERE user_id = '$uid' AND post_id = '$img'";
					$result = mysqli_query($conn, $sql);
					$colour = '#ffffff';
				} else {
					$sql = "UPDATE likes SET isLike= false WHERE user_id = '$uid' AND post_id = '$img'";
					$result = mysqli_query($conn, $sql);
					$colour = '#707070';
				}
			}
		}
	//GET UPLOAD BENIS
	echo "<p style='color:".$colour.";'>".(mysqli_num_rows(mysqli_query($conn, "SELECT isLike FROM likes WHERE post_id = '$img' AND isLike = 1"))
		 - mysqli_num_rows(mysqli_query($conn, "SELECT isLike FROM likes WHERE post_id = '$img' AND isLike = 0")))."</p>";
}