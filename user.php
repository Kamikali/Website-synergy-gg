<?php
	include_once "partials/header.php";
	include_once "partials/navbar.php";
	include_once "includes/time.inc.php";
	include_once "includes/dbh.inc.php";
	include_once "includes/countrynames.inc.php";
	include_once "includes/userstats.inc.php";
	include_once "includes/setEmojis.inc.php";
?>
<body>
<div class="container">




    <?php

	$user = $_GET['user'];
	$sql = "SELECT uid, name, role, created, countryID, profile_text FROM users WHERE '$user' = name";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($result)){
		if (mysqli_num_rows($row) === 0) {
			echo "This User does not exist!";
		} else {
			$timeCreated = time_elapsed_string($row['created']);

			if(isset($_SESSION['u_uid'])){
				if($_SESSION['u_uid'] == $user){
					?>
						<form id="right" action="includes/logout.inc.php" method="POST">
					        <button type="submit" style="float:right;" class="btn btn-danger navbar-btn" name="submit">Logout</button>
					    </form>
					<?php
				}
			}

			$uid = $row['uid'];
			$u_coins = 0;
            $coin_result = mysqli_query($conn, "SELECT SUM(coins) AS value_coins FROM users WHERE uid = '$uid'");
            $coin_row = mysqli_fetch_assoc($coin_result);
            $u_coins += $coin_row['value_coins'];
            $colour = selectColour($row['role']);
			echo "<h1 style='color:".$colour.";'>".$user."</h1>";

            echo '<b style="font-size:18px;color:#9d9d9d;"><img style="height:30px;margin-top:-7px;" src="http://www.flag.synergy.gg/'.$row['countryID'].'.png"> '.code_to_country($row['countryID']).'</b><br>';

			echo "<div><svg style='margin-top:2px;' width='19' height='14.5'><circle cx='10' cy='9' r='5' stroke='black' stroke-width='1' fill='".$colour."' /></svg>";
			echo "<i style='color:#9d9d9d;'>".$row['role']."</i>";

			$awards = mysqli_query($conn, "SELECT * FROM awards WHERE uid = $uid ORDER BY achieved DESC");
			while($award_row = mysqli_fetch_assoc($awards)){
				echo "<img data-toggle='tooltip' data-placement='bottom' title='".$award_row['award_description']."' style='float:right;max-height:32px;' src='assets/img/awards/".$award_row['award_name'].".png'>";
			}
			echo "</div>";
			echo "Account created ".$timeCreated."<br>";

			

			echo '<h2><a href="" data-toggle="tooltip" data-placement="bottom" title="'.$row['name'].'&#39s Owlycoins"><img style="margin-top:-7px;height:28px;width:28px;" src="assets/img/icons/owlcoin.png"> '.$u_coins.'</a></h2>';

			echo "<p style='font-size:18px;color:#9d9d9d;'>Self introduction:<p>";
			if($row['profile_text'] == ""){
				echo "<p style='color:#9d9d9d;'><i>This user has not written a self introduction yet.</i></p>";
			} else {
				echo setEmojis(nl2br(replaceLinks($row['profile_text'])));
			}

			echo "<p style='font-size:18px;color:white;'>
					<i style='color:#9d9d9d;'>Uploads</i>  ".mysqli_num_rows(mysqli_query($conn, "SELECT user_id FROM posts WHERE '$user' = user_uid AND visible = 1"))."&emsp;
					<i style='color:#9d9d9d;'>Comments</i> ".mysqli_num_rows(mysqli_query($conn, "SELECT comment_id FROM tbl_comment WHERE '$user' = comment_sender_name AND visible = 1"))."
					</p>";
			echo "<br><h3>Recent uploads by ".$row['name']."</h3><br>";		
			include_once "includes/user_articles.inc.php";
		}
	}
	?>
	<br>
</div>

</body>
<?php
	include_once "partials/footer.php";

function replaceLinks($s) {
    return preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.%-=#]*(\?\S+)?)?)?)@', '<a style="color: #4fdbff;" href="$1">$1</a>', $s);
}

function replaceLinebreaks($s) {
    return str_replace('\r\n', "\t<br />", $s);
}

