<?php
	include_once "partials/header.php";
	include_once "partials/navbar.php";
	include_once 'includes/dbh.inc.php';
	include_once 'includes/time.inc.php';
	include_once 'includes/userstats.inc.php';
	include_once 'includes/setEmojis.inc.php';
?>
<body>

<script>function goBack(){window.history.back();}</script>

<div class="container">

<style>
	button {
		background:none;
		border:none;
		color:white;
	}
	button:hover {
		color: #4fdbff;
	}
</style>

	<?php
			$img = $_GET['img'];
			$sql = "SELECT * FROM posts WHERE uid = $img";
			$result = mysqli_query($conn, $sql);

			while ($row = mysqli_fetch_assoc($result)){
				$uploadTime = time_elapsed_string($row['date']);
				if($row['ispic']){ //IS IMAGE
					?>
					<div align="center">
					<?php
					echo "<br><img style='cursor: pointer;max-height:500px;max-width: 100%;' src='http://www.img.synergy.gg/".$row["path"]."' onclick='goBack()'><br>";
					?></div><?php
				} else {				 //IS VIDEO
										 //CREATE CUSTOM VIDEO PLAYER <-- doesnt work yet
						?>
						<div align="center">
						    <video id="video" autoplay controls loop style='cursor:pointer;max-height:500px;max-width:100%;' onclick='goBack()'>
						    	<source src='http://www.vid.synergy.gg/<?php echo $row["path"];?>' type="video/mp4">
						    	<source src='http://www.vid.synergy.gg/<?php echo $row["path"];?>' type="video/m4v">
						    	Your browser does not support HTML5 video ¯\_(ツ)_/¯
						    </video>
						</div>			
							
						<?php
				}


				//GET DATA TO CREATE INFO BAR UNDER UPLOAD
				$likes = "SELECT isLike FROM likes WHERE post_id = '$img' AND isLike = 1";
				$resultLikes = mysqli_query($conn, $likes);
				$numLikes = mysqli_num_rows($resultLikes);

				$unlikes = "SELECT isLike FROM likes WHERE post_id = '$img' AND isLike = 0";
				$resultUnlikes = mysqli_query($conn, $unlikes);
				$numUnlikes = mysqli_num_rows($resultUnlikes);

				$uid = $_SESSION['u_id'];
				$colour = '';
				$isLiked = "SELECT isLike FROM likes WHERE user_id = '$uid' AND post_id = '$img'";
				$result = mysqli_query($conn, $isLiked);
				if(mysqli_num_rows($result) == 0){
					$colour = '#ffffff';
				} else {
					while($row2 = mysqli_fetch_assoc($result)) {
						if($row2['isLike'] == 0){
							$colour = '#707070';
						} else {
							$colour = '#4fdbff';
						}
					}
				}

				//GET COLOUR FOR DESCRIPTION
				$roleColour_id = $row['user_id'];
				$roleColour_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT role FROM users WHERE uid = '$roleColour_id'"));
				$roleColour = selectColour($roleColour_row['role']);

				$upload_benis = $numLikes - $numUnlikes;
				 
				if($numLikes + $numUnlikes != 0){
					$likeBarWidth = 70 / ($numLikes + $numUnlikes) * $numLikes;
				} else {
					$likeBarWidth = 70;
				}

				//ROLES THAT ARE ALLOWED TO DELETE POSTS
				$allowedRoles = array("Moderator", "Administrator");

				echo "<h2>".setEmojis($row['title'], 32, -6)."</h2>";
				echo '<div class="row">';
				echo '<div class="col-sm-8">';
				echo "<ul style='list-style-type: none;><li style='float: left'>";
				if(isset($_SESSION['u_id'])){ //LIKE BUTTONS FOR USERS WHO ARE LOGGED IN
						echo   "<ul style='list-style-type: none;'>
									<li id='plus' style='margin-left:-85px;margin-top:20px;'>
										<!-- LIKE BUTTON -->
										<form method='post' id='likeform'>
											<input type='hidden' id='img' value='".$img."'>
											<input type='hidden' id='uid' value='".$_SESSION['u_id']."'>
											<button id='likebtn' type='submit'>&#x25B2</button>
										</form>
									</li>
									<li id='minus' style='margin-left:-85px;'>
										<!-- DISLIKE BUTTON -->
										<form method='post' id='dislikeform'>
											<input type='hidden' id='img' value='".$img."'>
											<input type='hidden' id='uid' value='".$_SESSION['u_id']."'>
											<button id='dislikebtn' type='submit'>&#x25BC</button>
										</form>
									</li>
								</ul>";
					} else {
							echo   "<ul style='list-style-type: none;'>
								<li id='plus' style='margin-left:-85px;margin-top:20px;'>
									<!-- LIKE BUTTON -->
									<form action='login.php' method='get'>
										<input type='hidden' name='loginrequest' value='like'>
										<button id='likebtn' type='submit'>&#x25B2</button>
									</form>
								</li>
								<li id='minus' style='margin-left:-85px;'>
									<!-- DISLIKE BUTTON -->
									<form action='login.php' method='get'>
									    <input type='hidden' name='loginrequest' value='like'>
										<button id='dislikebtn' type='submit'>&#x25BC</button>
									</form>
								</li>
							</ul>";
					}
				echo '</li><li>';
				echo "<ul style='list-style-type: none;'>
						<li style='float:left;margin-left:-55px;margin-top:-70px;' id='benis-display'><h1 style='color:".$colour.";'><span class='jqValue'>...</span></h1></li>
						<!-- LIKEBAR -->	
							<li style='float:left;margin-left:-55px;margin-top:-20px;'>				
								<svg width='70' height='5'>
									<rect x='0' y='0' width='70' height='5' style='fill:rgb(90,90,90)' />
									<rect x='0' y='0' width='".$likeBarWidth."' height='5' style='fill:rgb(79, 219, 255)' />
									<rect x='0' y='0' width='70' height='5' fill-opacity='0' style='stroke-width:2;stroke:rgb(20,20,20)' />
								</svg>
							</li>";

				echo"</li></ul>";
				echo '<li style="margin-top:-50px;margin-left:75px;">
				    <footer style="color:white;"><i>'.$uploadTime.' by <img style="width:20px;height:18px;margin-top:-2px;" src="http://www.flag.synergy.gg/'.$row['country'].'.png"><a style="color:'.$roleColour.';" href="/user.php?user='.$row['user_uid'].'"></i><b>'.$row['user_uid'].'</b></a>
				    ';
                	if(in_array($_SESSION["u_urole"], $allowedRoles)){
                echo '<form method="post" action="includes/delete.inc.php">
	                      <input type="hidden" name="articleNumber" value="'.$img.'">
	                      <input type="hidden" name="toDel" value="post">
	                      <button style="float:right;" name="submit" type="submit">Delete</button>
                     </form>';
                	}
				echo '</footer><p>'.setEmojis($row['message']).'</p></li>';
				echo '</div></div>';
				echo '</ul></li>';
			}
			
			include_once "comments.php";
			?>

		<br><br><br><br><br><br><br><br><br><br><br><br><br>
</div>
</body>


<script>
	var numberLikes = "<?php echo $upload_benis; ?>";
	var $jqValue = $('.jqValue');
	$jqValue.html(numberLikes);	
			
	$('#likeform').submit(function(event){			
		event.preventDefault();
		var img=$.trim($('#img').val());
		var uid=$.trim($('#uid').val());
		$.ajax({ url: 'includes/like.inc.php',
		    data: {action:'like', uid:uid, img:img},
		    type: 'post',
			success: function(output) {
			    $jqValue.html(output);	
            }
		});
	});

	$('#dislikeform').submit(function(event){
		event.preventDefault();
		var img=$.trim($('#img').val());
		var uid=$.trim($('#uid').val());
		$.ajax({ url: 'includes/like.inc.php',
	        data: {action:'dislike', uid:uid, img:img},
			type: 'post',
			success: function(output) {
			    $jqValue.html(output);	
            }
		});
	});
</script>

<?php
	include_once "partials/footer.php";
?>

