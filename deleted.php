<?php
include_once "partials/header.php";
include_once "partials/navbar.php";
$allowedRoles = array("Moderator", "Administrator");
?>

<div class="container">

<?php

if(in_array($_SESSION["u_urole"], $allowedRoles)){
	include_once "includes/dbh.inc.php";

	$type = $_GET['type'];
	if($type == 'post'){
		$img = $_GET['img'];
		echo "You have deleted post number ".$img;

		echo '<br><form method="post" action="includes/revokeDeletion.inc.php">
			<input type="hidden" name="type" value="post">
		    <input type="hidden" name="articleNumber" value="'.$img.'">
		    <button name="submit" type="submit">Revoke deletion</button>
	    </form>';
	} else if ($type == 'comment'){
		$img = $_GET['img'];
		echo "You have deleted comment number ".$img;

		echo '<br><form method="post" action="includes/revokeDeletion.inc.php">
			<input type="hidden" name="type" value="comment">
		    <input type="hidden" name="commentNumber" value="'.$img.'">
		    <button name="submit" type="submit">Revoke deletion</button>
	    </form>';		
	}


	?>

	<br><br>
	<a href="https://synergy.gg/news.php">Back to synergy.gg mainpage</a>
</div>
<?php
}