<?php
	include_once "partials/header.php";
	include_once "partials/navbar.php";
?>
<body>

<div class ="container">
	<h2><b>SIGN UP</b></h2>
	<br>

	<form class="form-horizontal" action="includes/signup.inc.php" method="POST">

		<!-- CATCH ERRORS -->
			<?php
				if (isset($_GET['signup'])) {
					echo "<p style='color:yellow;'>An error occured!</p>";
					$error = $_GET['signup'];
					switch ($error) {
						case 'empty':
							echo "<p style='color:yellow;'>Please fill out the whole form.<br></p>";
							break;
						case 'invalidchar':
							echo "<p style='color:yellow;'>Your username may only contain characters from A-Z and numbers from 0-9!<br></p>";
							break;

						case 'mailalreadyused':
							echo "<p style='color:yellow;'>This e-mail adress is already used.<br></p>";
							break;

						case 'cantusemail':
							echo "<p style='color:yellow;'>The entered e-mail adress is invalid.<br></p>";
							break;									

						case 'usernamealreadyused':
							echo "<p style='color:yellow;'>This nickname is already used.<br></p>";
							break;

						case 'passworddoesntmatch':
							echo "<p style='color:yellow;'>The passwords don't match.<br></p>";
							break;

						case 'username':
							echo "<p style='color:yellow;'>The length of your nickname has to be between 3 and 16 characters.<br></p>";
							break;

						default:
							echo "<p style='color:yellow;'>There is a problem with the data you entered.<br></p>";
							break;
						}
						echo "<br>";
					}
				?>
		<div class="form-group">
			<label class="control-label col-sm-2" style="color:white;">Nickname:</label>
			<div class="col-sm-10">
        		<input type="text" class="form-control" name="uid" placeholder="Nickname">
     		</div>
     	</div>
		<div class="form-group">
			<label class="control-label col-sm-2" style="color:white;">Email:</label>
			<div class="col-sm-10">
        		<input type="text" class="form-control" name="email" placeholder="E-Mail adress">
     		</div>
     	</div>
		<div class="form-group">
			<label class="control-label col-sm-2" style="color:white;">Password:</label>
			<div class="col-sm-10">
        		<input type="password" class="form-control" name="pwd" placeholder="Password">
     		</div>
     	</div>
		<div class="form-group">
			<label class="control-label col-sm-2" style="color:white;">Repeat Password:</label>
			<div class="col-sm-10">
        		<input type="password" class="form-control" name="rPwd" placeholder="Confirm password">
     		</div>
     	</div>
	    <div class="form-group">        
	      <div class="col-sm-offset-2 col-sm-10">
	        <button type="submit" name="submit" class="btn btn-default">Next</button>
	      </div>
	    </div>
	</form>
</div>
</body>
<?php
	include_once "partials/footer.php";
?>