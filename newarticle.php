<?php
	include_once "partials/header.php";
	include_once "partials/navbar.php";
?>
<body>
<div class="container">
	Please choose a image or video to upload.<br>
	Make sure to take a look at our <b><a href="">>>rules</a></b> before uploading!<br><br>

	<form class="form-horizontal" action="includes/upload.inc.php" method="POST" enctype="multipart/form-data">
		<div class="form-group">
			<label class="control-label col-sm-2" style="color:white;">Titel:</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name='title' placeholder='Title'>
     		</div>
     	</div>
		<div class="form-group">
			<label class="control-label col-sm-2" style="color:white;">Description:</label>
			<div class="col-sm-10">
				<textarea name='message' class="form-control" placeholder='Description (optional)'></textarea>
     		</div>
     	</div>
		<div class="form-group">
			<label class="control-label col-sm-2" style="color:white;">Select file:</label>
			<div class="col-sm-10">
				<input type="file" class="form-control" name="file">
     		</div>
     	</div>
	    <div class="form-group">        
	      <div class="col-sm-offset-2 col-sm-10">
	        <button type="submit" name="submit" class="btn btn-info">Next</button>
	      </div>
	    </div>
	</form>

	<a href="news.php">Cancel</a>
</div>
<br>
	
</body>
<?php
	include_once "partials/footer.php";
?>