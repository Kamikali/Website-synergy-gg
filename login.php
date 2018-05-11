<?php
	include_once "partials/header.php";
	include_once "partials/navbar.php";

	if(isset($_GET['loginrequest']))$error = $_GET['loginrequest'];
?>
<body>

<div class="container">

<h2><b>LOGIN</b></h2>
<br>

	<?php
		switch($error){
			case 'like':
			echo "<p style='color:yellow;'>You have to be logged in if you want to like/dislike posts!<br><br></p>";
			break;
		}
	?>

	<form class="form-horizontal" action="includes/login.inc.php" method="POST">
		<div class="form-group">
			<label class="control-label col-sm-2" style="color:white;">Nickname:</label>
			<div class="col-sm-10">
        		<input type="text" class="form-control" name="uid" placeholder="Nickname">
     		</div>
     	</div>
		<div class="form-group">
			<label class="control-label col-sm-2" style="color:white;">Password:</label>
			<div class="col-sm-10">
        		<input type="password" class="form-control" name="pwd" placeholder="Password">
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