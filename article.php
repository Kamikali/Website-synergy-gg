<?php
	include_once "partials/header.php";
	include_once "partials/navbar.php";
	include_once 'includes/dbh.inc.php';
	include_once 'includes/time.inc.php';
?>
<body>

<script>function goBack(){window.history.back();}</script>

<div class="container">

 


	<?php
			$img = $_GET['img'];
			$sql = "SELECT * FROM posts WHERE uid = $img";
			$result = mysqli_query($conn, $sql);

			while ($row = mysqli_fetch_assoc($result)){
				$uploadTime = time_elapsed_string($row['date']);
				echo "<h2>".$row['title']."</h2>";
				if($row['ispic']){ //IS IMAGE
					?>
					<div align="center">
					<?php
					echo "<br><img style='cursor: pointer;max-height:500px;max-width: 100%;' src=".$row["path"]." onclick='goBack()'><br>";
					?></div><?php
				} else {				 //IS VIDEO
										 //CREATE CUSTOM VIDEO PLAYER <-- doesnt work yet
						?>
						<div align="center">
						    <video id="video" autoplay controls loop style='cursor:pointer;max-height:500px;max-width:100%;' onclick='goBack()'>
						    	<source src='<?php echo $row["path"];?>' type="video/mp4">
						    	<source src='<?php echo $row["path"];?>' type="video/m4v">
						    	Your browser does not support HTML5 video.
						    </video>
						</div>			
							
						<?php
				}

				echo '<div class="row">'; /*<div class="col-sm-1">';
					echo '<p style="font-size:50px;margin-top:-15px;">601</p>';
					echo "<!-- LIKEBAR -->						
							<svg width='70' height='5' style='margin-top:-30px;'>
							 		<rect x='0' y='0' width='70' height='5' style='fill:rgb(90,90,90)' />
							 		<rect x='0' y='0' width='50' height='5' style='fill:rgb(156,220,256)' />
							 	<rect x='0' y='0' width='70' height='5' fill-opacity='0' style='stroke-width:2;stroke:rgb(20,20,20)' />
							</svg>";
					echo '<span style="font-size: 1.5em;" class="glyphicon glyphicon-thumbs-up"></span>';
					echo '  <span style="font-size: 1.5em;" class="glyphicon glyphicon-thumbs-down"></span>';
				echo '</div>'; */
				echo '<div class="col-sm-11">';
				echo '<blockquote style="border-color:#cdcdcd;">
				    <p>'.$row['message'].'</p>
				    <footer style="color:white;"><i>'.$uploadTime.' by <img style="width:20px;height:18px;margin-top:-2px;" src="assets/img/flags/'.$row['country'].'.png"><a href="/user.php?user='.$row['user_uid'].'"></i><b>'.$row['user_uid'].'</b></a></footer>
				</blockquote>';
				echo '</div></div>';
				
			}
			
			include_once "comments.php";
			?>

		<br><br><br><br><br><br><br><br><br><br><br><br><br>
</div>
</body>
<?php
	include_once "partials/footer.php";
?>

