<?php
	include_once "partials/header.php";
	include_once "partials/navbar.php";
	include_once "includes/time.inc.php";
	include_once "includes/dbh.inc.php";

?>
<body>
<div class="container">




    <?php

	$user = $_GET['user'];
	$sql = "SELECT uid, role, created FROM users WHERE '$user' = name";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($result)){
		if (mysql_num_rows($row) === 0) {
			//TODO
			//FIX THIS SHITTY CODE THAT IT DISPLAYS AN ERROR WHENEVER A USER DOES NOT EXIST
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

			echo "<h1>".$user."</h1>";
			echo "Account created ".$timeCreated."<br>";
			$role = $row['role'];
			echo $role;
		}
	}
	?>
	<br>
</div>

</body>
<?php
	include_once "partials/footer.php";
?>